<?php

header("Access-Control-Allow-Origin: *"); // TODO: https://jonas.ee

require 'root.php';
require 'utility/all.php';

$config = parse_config('config.ini');
$error = (object)$config->error;

# Pre-process encoded data (like JSON). This has to be done so that
# sanitization will be done properly. Otherwise we would sanitize
# e.g. JSON-encoded data which would, as a result, be unparseable.
$data = $_POST;
$data['currency'] = json_decode($data['currency']);

$request = (object)[
  'remote_address' => $_SERVER['REMOTE_ADDR'],
  // Some of the data supplied by the user will be put into an HTML mail body.
  'data' => sanitize_html($data, [ 'g-recaptcha-response' ])
];

$recaptcha = (object)[
  'verify' => $config->recaptcha->verify,
  'secret' => $config->recaptcha->secret,
  'response' => $request->data['g-recaptcha-response'],
  'user_errors' => $config->recaptcha->user_errors
];

# Check if the submitted form contains all expected fields.
if (!array_keys_exists($config->form->fields, $request->data))
  fail(400, $error->bad_request); # Bad Request

# Check if the terms have been accepted. If the field has the required value
# the user must have explicitly stated their consent (by ticking the checkbox).
$termsAccepted = strtolower($request->data['legal']) === 'on';
if (!$termsAccepted)
  fail(400, $error->terms_accept);

# Check if the reCaptcha response token has a value.
if (empty($recaptcha->response)) # TODO
  fail(400, $error->recaptcha_missing);

# Verify the reCaptcha result from the client.
$recaptcha_result = recaptcha_verify($recaptcha, $request->remote_address);

if (!$recaptcha_result->success) {
  $errors = $recaptcha_result->{ 'error-codes' };

  foreach ($errors as $code) {
    if (!isset($recaptcha->user_errors->$code))
      # Fail as server error if there's an
      # error that is not caused by the user.
      break;

    $reason = $recaptcha->user_errors->$code;
    fail(400, $error->recaptcha_invalid, $reason);
  }

  write_response(500, $error->recaptcha_failed); # Internal Server Error
  end_response(); # Code after this runs in the background.

  # Log the error locally and via e-mail.
  log_error($config, [
    'data' => $request->data,
    'recaptcha_result' => $recaptcha_result
  ], true);

  die();
}

$from = $request->data['_replyto'];

# Check validity of the supplied e-mail address.
if (!filter_var($from, FILTER_VALIDATE_EMAIL))
  fail(400, $error->email_malformed);

# TODO: Send verification mail instead of accepting the offer immediately.

# Send
$mail = create_mail_with_config($config);
configure_mail($mail, [
  'from' => $from, # TODO: this should overwrite!
  'to' => $config->gmail->address,
  'subject' => 'Someone made an offer for jonas.ee',
  'body' => create_mail_body($config->template->offer, [
    'offer' => $request->data['offer'],
    'currency' => $request->data['currency']
  ])
]);

if (!$mail->send())
  fail(500, $error->email_failed, $mail->ErrorInfo); # TODO: Log error info.

success();
