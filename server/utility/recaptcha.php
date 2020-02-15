<?php

function recaptcha_verify($recaptcha, $remoteip = null)
{
  $fields = [
    'secret' => $recaptcha->secret,
    'response' => $recaptcha->response
  ];

  if ($remoteip)
    $fields['remoteip'] = $remoteip;

  $query_string = http_build_query($fields);

  $ch = curl_init();
  curl_setopt($ch, CURLOPT_URL, $recaptcha->verify);
  curl_setopt($ch, CURLOPT_POST, true);
  curl_setopt($ch, CURLOPT_POSTFIELDS, $query_string);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
  $result = curl_exec($ch);

  return json_decode($result);
}
