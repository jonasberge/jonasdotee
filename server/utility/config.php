<?php

function parse_config($file)
{
  $result = to_object(parse_ini_file($file, true));
  $result->form->fields = explode(', ', $result->form->fields);
  return $result;
}

function create_mail_with_config($config)
{
  $user = $config->gmail->user;
  $password = $config->gmail->app_password;
  $from = $config->gmail->address;
  return create_mail($user, $password, $from);
}
