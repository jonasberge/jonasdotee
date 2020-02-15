<?php

function create_log_name($directory)
{
  $tz = new DateTimeZone('Europe/Berlin');
  $time = new DateTime('now', $tz);
  $timestamp = $time->format('Y-m-d_H-i-s');
  $suffix = uniqid();

  $filename = $timestamp . "_$suffix.json";

  return "$directory/$filename";
}

function write_log($directory, $data)
{
  $content = json_encode($data, JSON_PRETTY_PRINT);
  file_put_contents(create_log_name($directory), $content);
}

function create_log_mail($config, $data)
{
  $mail = create_mail_with_config($config);
  configure_mail($mail, [
    'to' => $config->log->mail_address,
    'subject' => 'jonas.ee - Internal Server Error', # TODO: put this string into the config
    'body' => create_mail_body($config->template->log, $data)
  ]);

  return $mail;
}

function log_error($config, $data, $with_mail = false)
{
  if ($with_mail) {
    $mail = create_log_mail($config, $data);
    $data['mail_result'] = $mail->send();
  }

  $directory = SERVER_ROOT . '/' . $config->log->folder;
  write_log($directory, $data);
}
