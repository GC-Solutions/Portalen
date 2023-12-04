<?php 

ini_set("memory_limit", "-1");
set_time_limit(0);
ini_set('display_errors', 1);
error_reporting(E_ALL);


    $_arrayList = array('ResultList');
    $retval = array();

    
	$DBName = 'BP_SelectedBrands';
    $DBPass = 'gcsmakeit2010';
    $DBUsername = 'jeff';
    $DBHost = '10.30.57.5';
    $db = new PDO("sqlsrv:Server=$DBHost;Database=$DBName;", "$DBUsername", "$DBPass");

    // Throw an Exception when an error occurs
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

	$ftp_server = $_SERVER['REQUEST_SCHEME'].':/'.$_SERVER['SERVER_ADDR']; // Ip address 	

	$basePath = $_SERVER['DOCUMENT_ROOT']; // base path in folder 

	// set up basic connection
	//C:\MAMP\htdocs\BabcPortal_Other_Assests\API-IMG\Selected Brands - Demo\Images\user\shopsb@babc.app
	$filename = $basePath.'/BabcPortal_Other_Assests/API-IMG/API-IMG/Selected Brands - Demo/Images/user/shopsb@babc.app/';
	//$filename = "C:/xampp/htdocs/API-IMG/Selected Brands - Demo/Images/user/shopsb@babc.app/";
	echo ":jnjkn";
	print_r($ftp_server);exit;