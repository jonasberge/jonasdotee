<?php

function to_object($mixed)
{
  return is_array($mixed) ? (object)array_map(__FUNCTION__, $mixed) : $mixed;
}

function array_keys_exists($keys, $arr)
{
  return !array_diff_key(array_flip($keys), $arr);
}

function sanitize_html(&$data, $exclude = [])
{
  foreach ($data as $key => &$entry) {
    if (in_array($key, $exclude))
      continue;

    $nested_exclude = [];
    if (isset($exclude[$key]))
      $nested_exclude = $exclude[$key];

    $is_nested = is_array($entry) || is_object($entry);
    $entry = $is_nested ? sanitize_html($entry, $nested_exclude)
      : htmlspecialchars($entry);
  }

  return $data;
}

function get_protocol()
{
  if (isset($_SERVER['HTTPS'])) {
    $https = filter_var($_SERVER['HTTPS'], FILTER_VALIDATE_BOOLEAN);
    if ($https) return 'https';
  }

  if (isset($_SERVER['HTTP_X_FORWARDED_PROTO'])) {
    $https = strtolower($_SERVER['HTTP_X_FORWARDED_PROTO']) === 'https';
    if ($https) return 'https';
  }

  return 'http';
}

function get_server_url()
{
  $protocol = get_protocol();
  $server_name = $_SERVER['SERVER_NAME'];
  $server_port = $_SERVER['SERVER_PORT'];
  $directory = SITE_ROOT;

  return "$protocol://$server_name:$server_port/$directory";
}
