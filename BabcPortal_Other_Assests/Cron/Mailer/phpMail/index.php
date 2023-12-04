<?php

ini_set('memory_limit', '200G');
ini_set('display_errors', 1);
error_reporting(E_ALL);
//Import PHPMailer classes into the global namespace
//These must be at the top of your script, not inside a function
require_once __DIR__ . '/vendor/autoload.php';
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

$mail_host = 'smtp.office365.com';
$mail_username = 'noreply@gcsolutions.se';
$mail_password = '!GCSmail2022';
$mail_port = 587;

$mail = new PHPMailer(true);
    try {
        $mail->isSMTP();
        $mail->Host       = $mail_host;
        $mail->SMTPAuth   = true;
        $mail->Username   = $mail_username;
        $mail->Password   = $mail_password;
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port       = $mail_port;

        $mail->setFrom($mail_username, 'Babc Portal');
        $mail->addAddress('saharkhan201@gmail.com', 'User');

        $mail->isHTML(true);
        $mail->Subject = 'Your 2FA Code';
        $mail->Body    = "Your 2FA code is: ";

        $mail->send();
    } catch (Exception $e) {
        $error = "Mailer Error: " . $mail->ErrorInfo;
    }



print_r("hello"); exit;
