<?php

function create_response($success, $message = null, $reason = null)
{
  $result = [ 'success' => $success ];
  if ($success) return json_encode($result);

  if ($message) $result['message'] = $message;
  if ($reason) $result['reason'] = $reason;
  return json_encode($result);
}

function write_response($code, $message = null, $reason = null)
{
  $success = substr($code, 0, 1) === '2'; // 2xx response codes.
  $response = create_response($success, $message, $reason);
  echo $response;

  http_response_code($code);
  header('Content-Type: application/json;charset=utf-8');
}

function end_response()
{
  $size = ob_get_length();

  header("Content-Length: $size");
  header('Connection: close');

  ob_end_flush();
  ob_flush();
  flush();

  # Note: Close all sessions when making use of them.
  # Reference: https://www.php.net/manual/de/ref.session.php
}

function fail($code, $message = null, $reason = null)
{
  write_response($code, $message, $reason);
  end_response();
  die();
}

function success($message = null)
{
  write_response(200, $message);
  end_response();
  die();
}
