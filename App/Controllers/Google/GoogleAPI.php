<?php

namespace App\Controllers\Google;


use \Core\View;
use App\Models\Page;
use \App\Models\User;
use \App\Models\Companies;


/**
 * GoogleAPI controller
 *
 * PHP version 7.0
 */
// This File has function that make  Connection with Goole API to access the data .
// And to get the Required Data Report 
class GoogleAPI extends \Core\Controller
{

	public function getAccessToken (){
	 	
	
	$companyId = isset($_GET['Id'])?$_GET['Id']:'';

  	$companyId = isset($_SESSION['gapiCompanyId'])?$_SESSION['gapiCompanyId']:base64_decode($companyId);

    $_SESSION['gapiCompanyId'] = $companyId;

    $client = $GLOBALS['client'] ;
    $client->setAuthConfig(baseUrl. 'client_secret.json');
	$client->addScope('https://www.googleapis.com/auth/analytics');
	$client->setAccessType('offline');
	$client->setPrompt('consent');
    
	if (isset($_GET['code'])) { 
	    $client->authenticate($_GET['code']);
	    $_SESSION['token'] = $client->getAccessToken();
	}

	if (isset($_SESSION['token'])) { 
	    $token = $_SESSION['token'];
	    $client->setAccessToken($token);
	}

	if (!$client->getAccessToken()) { // auth call to google
	    $authUrl = $client->createAuthUrl();
	    header("Location: ".$authUrl);
	    die;
	}
	$data =  array('companyId' => $companyId , 'accessToken' => $_SESSION['token'] );  
	Companies::updateCompanyForGoogleApi($data);
	print_r('User Has been registered '); exit();
	
	}

function getReport($analytics) {

  // Replace with your view ID, for example XXXX.
   $VIEW_ID = "212399685";
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $myClubMemberUrl);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array(
        'Content-Type: application/json',
        'Content-Length: ' . strlen($data_json)));
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_TIMEOUT, 60);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $data_json);
    $result = curl_exec($ch);
	
	header('Location: ' . baseUrl . 'index.php?op=page&id=' . $pageId);
	exit();
 
}



}