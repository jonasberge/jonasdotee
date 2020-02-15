<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require dirname(__FILE__) . '/../vendor/autoload.php';

function create_mail($user, $password, $from = null)
{
  global $config;

  $mail = new PHPMailer();
  $mail->isSMTP();

  $mail->Host = 'smtp.gmail.com';
  $mail->Port = '587';
  $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
  $mail->SMTPAuth = true;
  $mail->Username = $user;
  $mail->Password = $password;

  if ($from)
    $mail->setFrom($from);

  return $mail;
}

function create_mail_body($resource, $data)
{
  $url = get_server_url();
  $query = http_build_query($data);
  return file_get_contents("$url/$resource?$query");
}

function configure_mail($mail, $options)
{
  if (isset($options['from']))    $mail->setFrom($options['from']);
  if (isset($options['to']))      $mail->addAddress($options['to']);
  if (isset($options['subject'])) $mail->Subject = $options['subject'];
  if (isset($options['body']))    $mail->msgHTML($options['body']); # TODO: Images?
}

/*function send_mail($mail, $template, $data)
{
  # TODO: Remove this.
  # $template = $options['template'];
  # unset($options['template']);

  $body = create_mail_body($template, $data);
  $mail->msgHTML($body);

  return $mail->send();
}*/
