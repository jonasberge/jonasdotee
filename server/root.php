<?php

function normalize_path($path)
{
  return str_replace('\\', '/', realpath($path));
}

function get_site_root()
{
  $file_directory = normalize_path(SERVER_ROOT);
  $root_directory = normalize_path($_SERVER['DOCUMENT_ROOT']);
  return substr($file_directory, strlen($root_directory));
}

define('SERVER_ROOT', __DIR__);
define('SITE_ROOT', get_site_root());
