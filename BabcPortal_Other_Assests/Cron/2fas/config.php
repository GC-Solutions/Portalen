<?php
$db_host = 'localhost:3306';
$db_user = 'samr';
$db_pass = '019j!Lmg5';
$db_name = 'admin_2fa';

$conn = new mysqli($db_host, $db_user, $db_pass, $db_name);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Email settings
$mail_host = 'smtp.office365.com';
$mail_username = 'noreply@gcsolutions.se';
$mail_password = '!GCSmail2022';
$mail_port = 587;

?>