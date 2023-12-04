<?php

// Load the Google API PHP Client Library.
$path  =  explode("\public", dirname(__DIR__) );
$path  = $path[0];

// Load the Google API PHP Client Library.
require  $path  . '/vendor/autoload.php';

// Start a session to persist credentials.
session_start();

// $curl = curl_init();

// curl_setopt_array($curl, array(
//   CURLOPT_URL => 'https://analyticsdata.googleapis.com/v1beta/properties/301911084:runReport',
//   CURLOPT_RETURNTRANSFER => true,
//   CURLOPT_ENCODING => '',
//   CURLOPT_MAXREDIRS => 10,
//   CURLOPT_TIMEOUT => 0,
//   CURLOPT_FOLLOWLOCATION => true,
//   CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
//   CURLOPT_CUSTOMREQUEST => 'POST',
//   CURLOPT_POSTFIELDS =>'{
//     "dateRanges":[
// {
// "startDate":"90daysAgo",
// "endDate":"yesterday"
// }
// ],
//   "dimensions": [
//     {
//       "name": "city"
//     },
//     {
//       "name": "Country"
//     }
//   ],
//   "metrics": [
//     {
//       "name": "activeUsers"
//     }
//   ]
// }',
//   CURLOPT_HTTPHEADER => array(
//     'Authorization: Bearer ya29.a0ARrdaM_6hKnOuaZzpigpCi_9tayUSFrVdslquqjf5SXcyBhavDDOMBAGZeCNjgWma0Gi877naZ__PyhtsjUZNEqWiobswb1pvXSCO7GV_-r4KUacAngN1RCYhOU40yxx4wqlvsXtXrs_UNlpFu3Khl_a4AE1',
//     'Content-Type: application/json'
//   ),
// ));

// $response = curl_exec($curl);

// curl_close($curl);
// echo $response; exit;

// printResults($response); exit;

// function printResults($reports) {

//   for ( $reportIndex = 0; $reportIndex < count( $reports ); $reportIndex++ ) {
//     $report = $reports[ $reportIndex ];
//     $header = $report->getColumnHeader();
//     $dimensionHeaders = $header->getDimensions();
//     $metricHeaders = $header->getMetricHeader()->getMetricHeaderEntries();
//     $rows = $report->getData()->getRows();

//     for ( $rowIndex = 0; $rowIndex < count($rows); $rowIndex++) {
//       $row = $rows[ $rowIndex ];
//       $dimensions = $row->getDimensions();
//       $metrics = $row->getMetrics();
//       for ($i = 0; $i < count($dimensionHeaders) && $i < count($dimensions); $i++) {
//         print($dimensionHeaders[$i] . ": " . $dimensions[$i] . "\n");
//       }

//       for ($j = 0; $j < count($metrics); $j++) {
//         $values = $metrics[$j]->getValues();
//         for ($k = 0; $k < count($values); $k++) {
//           $entry = $metricHeaders[$k];
//           print($entry->getName() . ": " . $values[$k] . "\n");
//         }
//       }
//     }
//   }
// }
// Create the client object and set the authorization configuration
// from the client_secrets.json you downloaded from the Developers Console.
$client = new Google_Client();
$client->setAuthConfig(__DIR__ . '\client_secret.json');
$client->setRedirectUri('http://' . $_SERVER['HTTP_HOST'] . '/public/Test_Files/oauth2callback.php');
$client->addScope(Google_Service_Analytics::ANALYTICS_READONLY);
$client->setAccessType('offline');
$client->setPrompt('consent');
$client->setApprovalPrompt("consent"); 
//$client->setApprovalPrompt("force");

// Handle authorization flow from the server.

if(isset($_SESSION['ACCESSTOKEN'])){

  $token = $_SESSION['ACCESSTOKEN'] ;
  
  if($client->isAccessTokenExpired()){  // if token expired
    $refreshToken = $token['refresh_token'];

    // refresh the token
    $client->refreshToken($refreshToken);
    $token_Main = $client->getAccessToken();
    $_SESSION['ACCESSTOKEN'] = $token_Main;
    print_r($_SESSION['ACCESSTOKEN']); exit;

  }else{
    $client->setAccessToken($token);
  } 
  
}
else if (isset($_GET['code'])) {
 
  $client->authenticate($_GET['code']);
  $token_Main = $client->getAccessToken();
  $_SESSION['ACCESSTOKEN'] = $token_Main;
 
  print_r($_SESSION['ACCESSTOKEN']); exit;
  if($token_Main){
      // use the same token
      $client->setAccessToken($token_Main);
  }
   
}







   