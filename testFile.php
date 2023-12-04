<?php


ini_set("memory_limit", "-1");
set_time_limit(0);
ini_set('display_errors', 1);
error_reporting(E_ALL);



$fp = fopen('testerPing.txt', 'wb');  // Save data in these file

$data = 'tester';

$body = file_get_contents("php://input"); 
$body = json_decode($body, true) ; 
$data = $body;



fwrite($fp, $data);
fwrite($fp, "\n");
    