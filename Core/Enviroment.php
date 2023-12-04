<?php
namespace Core;

if($_SERVER['SERVER_NAME'] == 'localhost'){
define('baseUrl','/public/');
}else
{
	
	// define('baseUrl','http://172.20.10.2/public/');
	define('baseUrl','https://babcportal.app/public/');
}
define('directoryName','BabcPortal');
 define('Host','10.30.57.5');
//define('Host','212.247.32.103');
define('DBName','BP_Admin10');
define('Username','jeff');
define('Password','gcsmakeit2010');


?>
