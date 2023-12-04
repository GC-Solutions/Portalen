<?php

namespace App\Controllers\DataTables;

use \Core\View;
use App\Config;
use App\Models\Page;
use \App\Models\User;
use \App\Models\Companies;
use App\Models\Placeholder;
use APP\Models\Execute;
use App\Controllers\DataFormatHelper\DataTableHelper;
use App\Models\Products;
use App\Controllers\DataTables\DataTables;

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

/**
 * UpdateForm controller
 *
 * PHP version 7.0
 */
// This file contain main function that are used by Action button to perform 
// UPdate form Data or 
// to perform a predefined update .

class UpdateForm extends \Core\Controller
{
 	// In  action button we allow the user to update the form it the code for it . 
    public function getUpdateFormAction()
    {
       
        set_time_limit(0);
        ini_set('memory_limit', '2G');
        $_arrayList = array('ResultList');
        $getUserDetails = User::getUserDetails($_SESSION['UserID']);
        if ($getUserDetails) {
            $getCompanyDetails = Companies::getCompanyDetails($getUserDetails[0]['CompanyID']);
        }
        // fetching data from Post request .
        $placeholderId = (isset($_REQUEST['dataSourceId'])) ? $_REQUEST['dataSourceId'] : "";
        $pageId = (isset($_REQUEST['pageId'])) ? $_REQUEST['pageId'] : "";
        $pageText = (isset($_REQUEST['page_text'])) ? $_REQUEST['page_text'] : "";
        
        $tableID = (isset($_REQUEST['tableID'])) ? $_REQUEST['tableID'] : "";
        
        $getPlaceholderDetails = Page::getDatasourceDetailsById($placeholderId);
        // $getTableActionDetails = Page::getTableActionDetails($_REQUEST['dataSourceId']);
          
        // print_r($getTableActionDetails); exit;
        $keys = Page::getUneditableKeys($placeholderId, $pageId , $tableID);
       
        $keys = explode(',' , $keys[0]['UneditableColumns']);
        if ($getPlaceholderDetails) {
            $getSourceType = $getPlaceholderDetails[0]['SourceAddress'];

            $companyAddress = $getCompanyDetails[0]['CompanyGISKey'];
            $companyToken = $getCompanyDetails[0]['CompanyGISToken'];
            $requestType = $getPlaceholderDetails[0]['RequestType'];
            $requestBody = $getPlaceholderDetails[0]['Body'];
            $requestBody2 = $getPlaceholderDetails[0]['Body_2'];
            $columnNameDialog = !empty($getPlaceholderDetails[0]['columnNameDialog'])?json_decode($getPlaceholderDetails[0]['columnNameDialog'] ,true):'';
            
            $getPlaceholderColumn = trim($getPlaceholderDetails[0]['Placeholder']);

            $columnName = '';
            $columnValue = '';
            if ($getPlaceholderColumn) {
                $columnName = (isset($_REQUEST['columnName'])) ? $_REQUEST['columnName'] : "";
                $columnValue = (isset($_REQUEST['columnValue'])) ? $_REQUEST['columnValue'] : "";
                $columnNameRow = (isset($_REQUEST['columnNameRow'])) ? $_REQUEST['columnNameRow'] : "";
                $columnValueRow = (isset($_REQUEST['columnValueRow'])) ? $_REQUEST['columnValueRow'] : "";
                $columnName1 = explode('||', $columnName);
                    $columnValue1  = explode('||', $columnValue);

                    if(count($columnName1) == count($columnValue1))
                    {

                        $columnNameRow = (isset($postData['columnNameRow'])) ? $postData['columnNameRow'] : "";
                        $columnValueRow = (isset($postData['columnValueRow'])) ? $postData['columnValueRow'] : "";
                        
                        foreach ($columnName1 as $key => $value) {
                            $requestBody = str_replace("(" . $columnName1[$key] . ")", $columnValue1[$key], $requestBody);
                        }
                    }else{
                        $columnName = explode('||',$columnName);
                        $columnValue = explode('||',$columnValue);
                        if (count($columnName) > 1 && count($columnName) > 1 ) {
                            $requestBody = str_replace("(" . $columnName[0] . ")", $columnValue[0], $requestBody);
                            $requestBody = str_replace("(" . $columnName[1] . ")", $columnValue[1], $requestBody);
                        } else {
                            $requestBody = str_replace("(" . $columnName[0] . ")", $columnValue[0], $requestBody);
                        }
                    }
               
            }
           
            $requestUrl = str_replace("(address)", $companyAddress, $getSourceType);
            $requestUrl = str_replace("(token)", $companyToken, $requestUrl);
          
            // CURL call for Updating  the Data.
            if ($requestUrl) {
                $gcsCustomer = $requestUrl;
                $ch = curl_init();
                curl_setopt($ch, CURLOPT_HEADER, false);
                curl_setopt($ch, CURLOPT_NOBODY, false);
                curl_setopt($ch, CURLOPT_URL, $gcsCustomer);
                if(strpos($requestUrl , 'EditRole') !== false)
                {
                    $head = array( 'Authorization:ZGVtb0BiYWJjLmFwcDpiYWJj',
                    'Content-type:application/json');
                   
                    curl_setopt($ch, CURLOPT_POSTFIELDS, $requestBody);
                    curl_setopt($ch, CURLOPT_HTTPHEADER,$head);
                }
                else if ($requestType && $requestType == 2) {
                    curl_setopt($ch, CURLOPT_POSTFIELDS, $requestBody);
                    curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));
                }
                curl_setopt($ch, CURLOPT_TIMEOUT, 60);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
                $results = curl_exec($ch);
                curl_close($ch);
                if(strpos($requestUrl , 'getEditRole') !== false)
                {
                    $results = json_decode($results, true);
                    if(isset($_SESSION['DeleteRedis'])) {
                        $placeholderIdTable = (isset($_SESSION['RedisplaceholderId'])) ? $_SESSION['RedisplaceholderId'] : 0;
                        $userPagePlaceholder = (isset(  $_SESSION['RedisId'])) ? $_SESSION['RedisId']: 0;
                        $DeleteRedis = (isset($_SESSION['DeleteRedis'])) ? $_SESSION['DeleteRedis'] : 0;
                        $DataArr = self::RedisUpdate($placeholderIdTable ,  $userPagePlaceholder  ,  $DeleteRedis);
                    }
                    if($requestBody){
                        $body = json_decode($requestBody , true);
                        $results = $results['data'];
                        foreach( $results as $k => $b){
                            if($b['ID'] == $body['ID'] ){
                                unset( $results);
                                $results = $b;
                                break;
                            }
                        }
                    }
                    $temp = $results;  unset( $results);
                    $results['data'] =  $temp; 
                   
                    $apiData =  $results;
                }else if ($results) {
                    $decodedResults = json_decode($results, true);
                    if(isset($_SESSION['DeleteRedis'])) {
                        $placeholderIdTable = (isset($_SESSION['RedisplaceholderId'])) ? $_SESSION['RedisplaceholderId'] : 0;
                        $userPagePlaceholder = (isset( $_SESSION['RedisId'])) ? $_SESSION['RedisId']: 0;
                        $DeleteRedis = (isset($_SESSION['DeleteRedis'])) ? $_SESSION['DeleteRedis'] : 0;
                        $DataArr = self::RedisUpdate($placeholderIdTable ,  $userPagePlaceholder  ,  $DeleteRedis);
                    }
                    $apiData = $decodedResults;
                    if ($decodedResults) {
                        foreach ($_arrayList as $key) {
                            if (isset($decodedResults[$key])) {
                                $apiData = $decodedResults[$key];
                                break;
                            }
                        }
                    }
                }
            }
         
            if ($apiData ) {
                $apiData = isset($apiData[0])?$apiData[0]:$apiData['data'];
                if(isset($_REQUEST['backbutton'])) {
                    $backBtn = (isset($_REQUEST['backbutton'])) ? $_REQUEST['backbutton'] : 0;
                    $backBtn = explode('&' , $backBtn );
                    if(count($backBtn) >= 6){

                        $_SESSION['RedisplaceholderId']  = (isset($backBtn[6])) ?$backBtn[6] : 0;
                        $_SESSION['RedisId'] = (isset($backBtn[7])) ? $backBtn[7] : 0;
                        $_SESSION['DeleteRedis'] = (isset($backBtn[8])) ?$backBtn[8] : 0;

                        $_SESSION['RedisplaceholderId'] = explode('=',  $_SESSION['RedisplaceholderId']);
                        $_SESSION['RedisId'] = explode('=',  $_SESSION['RedisId']);
                        $_SESSION['DeleteRedis'] = explode('=',  $_SESSION['DeleteRedis']);

                        $_SESSION['RedisplaceholderId'] = $_SESSION['RedisplaceholderId'][1];
                        $_SESSION['RedisId'] = $_SESSION['RedisId'][1];
                        $_SESSION['DeleteRedis'] = $_SESSION['DeleteRedis'][1];
                        //print_r($_SESSION['DeleteRedis']); exit;
                        
                 
                    }
                    
                }
               //print_r($_SESSION['DeleteRedis']); exit;
                // Start Code to replace the parameter name 
                // $postedBody2 = json_decode($requestBody2 , true);
               
                // $arrKeys = array_keys($apiData);
                // foreach ($postedBody2 as $PBkey => $PBvalue) {
                //     $cmpVal = str_replace('(' , '' , $PBvalue);
                //     $cmpVal = str_replace(')' , '' , $cmpVal);
                //     foreach ($arrKeys as $key => $value) {
                //         if( $PBkey != $value && $cmpVal  == $value){
                //             $apiData[$PBkey] = $apiData[$value];
                //             unset($apiData[$value]);
                //         }
                //     }
                    
                // }
                // End Code to replace the parameter name 
                
            }
          	// Will Take back to the Form Page .
            $path = isset($_REQUEST['currLoc'])?$_REQUEST['currLoc']:'';
           
            View::render('administrator/pageaccess/update_from.php', [ 'columnNameDialog' => $columnNameDialog, 'path' => $path,   'apiData' => $apiData, 'columnName' => $columnName, 'placeholderId' => $placeholderId, 'pageId' => $pageId, 'pageText' => $pageText , 'keys'=> $keys]);
        }
    }

    // Function that automatically Update the form Value In action Button
    public function placeholderUpdateFormAction()
    {

        set_time_limit(0);
        ini_set('memory_limit', '2G');
        $getUserDetails = User::getUserDetails($_SESSION['UserID']);
        if ($getUserDetails) {
            $getCompanyDetails = Companies::getCompanyDetails($getUserDetails[0]['CompanyID']);
        }
        // get all the post value 
        $placeholderId = (isset($_REQUEST['placeholderId'])) ? $_REQUEST['placeholderId'] : "";
        $pageId = (isset($_REQUEST['pageId'])) ? $_REQUEST['pageId'] : "";
        $pageText = (isset($_REQUEST['pageText'])) ? $_REQUEST['pageText'] : "";
        $curLoc = (isset($_REQUEST['curLoc'])) ? $_REQUEST['curLoc'] : "";

        $getPlaceholderDetails = Page::getDatasourceDetailsById($placeholderId);

        $getPlaceholderDetails = Page::getDatasourceDetailsById($placeholderId);
        // Settong the value to be send as body in the Post request
        if ($getPlaceholderDetails) {
            $getSourceType = $getPlaceholderDetails[0]['SourceAddress_2'];

            $companyAddress = $getCompanyDetails[0]['CompanyGISKey'];
            $companyToken = $getCompanyDetails[0]['CompanyGISToken'];
            $requestType = $getPlaceholderDetails[0]['RequestType_2'];
            $requestBody = $getPlaceholderDetails[0]['Body_2'];

            $getPlaceholderColumn = trim($getPlaceholderDetails[0]['Placeholder']);
            // Start Code to replace the parameter name 

            // $postedBody = json_decode($requestBody , true);
            
            // $arrKeys = array_keys($postedBody);
            // foreach ($postedBody as $PBkey => $PBvalue) {
            //     $keyName = str_replace('(' , '' , $PBvalue);
            //     $keyName = str_replace(')' , '' , $keyName);
            //     if(!in_array($keyName,$arrKeys)){
            //         $postedBody[$keyName] = '('.$PBkey.')' ;
            //         unset($postedBody[$PBkey]);
            //     }
            // }
            //  // End Code to replace the parameter name 
            // $requestBody = json_encode($postedBody); 
            $columnName = '';
            $columnValue = '';
          
           
            foreach ($_REQUEST as $eachKey => $eachValue) {
                if ($eachKey && $eachValue) {
                    $requestBody = str_replace("(" . $eachKey . ")", $eachValue, $requestBody);
                } else if($eachKey && empty($eachValue)) {
                    $requestBody = str_replace("(" . $eachKey . ")", '', $requestBody);
                }
            }
            
            $requestUrl = str_replace("(address)", $companyAddress, $getSourceType);
            $requestUrl = str_replace("(token)", $companyToken, $requestUrl);
          
            // CURL request to make the API request to post the data
            if ($requestUrl) {
                $gcsCustomer = $requestUrl;
                $ch = curl_init();
                curl_setopt($ch, CURLOPT_HEADER, false);
                curl_setopt($ch, CURLOPT_NOBODY, false);
                curl_setopt($ch, CURLOPT_URL, $gcsCustomer);
                if(strpos($requestUrl , 'EditRole') !== false)
                {
                    $head = array( 'Authorization:ZGVtb0BiYWJjLmFwcDpiYWJj',
                    'Content-type:application/json');
                   
                    curl_setopt($ch, CURLOPT_POSTFIELDS, $requestBody);
                    curl_setopt($ch, CURLOPT_HTTPHEADER,$head);
                }
                else if ($requestType && $requestType == 2) {
                    curl_setopt($ch, CURLOPT_POSTFIELDS, $requestBody);
                    curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));
                }
               
                curl_setopt($ch, CURLOPT_TIMEOUT, 60);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
                $results = curl_exec($ch);
                curl_close($ch);
            }
        }
      
        // Redirect Location is defined here 
        if($pageId && empty($curLoc)){
            header('Location: ' . baseUrl . 'page?id='.$pageId.'&page_text='.$pageText);
        }else if (!empty($curLoc)){
                $curLoc = str_replace('undefined', '' ,$curLoc );
                header('Location: ' . $curLoc);
        }
    }
     // Function to update the predefined value from Post API
    public function updatePredefinedAction()
    {
       
        set_time_limit(0);
        ini_set('memory_limit', '2G');
       
        $postData = $_REQUEST['params'];
        $_arrayList = array('ResultList');
       
        if($postData) {
            $getUserDetails = User::getUserDetails($_SESSION['UserID']);
            if ($getUserDetails) {
                $getCompanyDetails = Companies::getCompanyDetails($getUserDetails[0]['CompanyID']);
            }
            // Fetch all the value of post body
            $placeholderId = (isset($postData['dataSourceId'])) ? $postData['dataSourceId'] : "";
            $pageId = (isset($postData['pageTargetId'])) ? $postData['pageTargetId'] : "";
            $pageText = (isset($postData['pageTextValue'])) ? $postData['pageTextValue'] : "";
            $curLoc = (isset($postData['curLoc'])) ? $postData['curLoc'] : "";
            $Allupdate =  (isset($postData['Allupdate'])) ? $postData['Allupdate'] : 0;
            $getPlaceholderDetails = Page::getDatasourceDetailsById($placeholderId);
           
            // Setting the body for sending the body for post
            if ($getPlaceholderDetails) {
                
                $getSourceType = $getPlaceholderDetails[0]['SourceAddress'];

                $companyAddress = $getCompanyDetails[0]['CompanyGISKey'];
                $companyToken = $getCompanyDetails[0]['CompanyGISToken'];
                $requestType = $getPlaceholderDetails[0]['RequestType'];
                $requestBody = $getPlaceholderDetails[0]['Body'];

                $getPlaceholderColumn = trim($getPlaceholderDetails[0]['Placeholder']);

                $columnName = '';
                $columnValue = '';
                
                if($Allupdate){
                    if ($getPlaceholderColumn) {
                        $columnName = (isset($postData['orderNoCol'])) ? $postData['orderNoCol'] : "";
                        $columnValue = (isset($postData['orderNoValue'])) ? $postData['orderNoValue'] : "";
                       
                        $columnName = explode('||',$columnName);
                        $columnValue = explode('||',$columnValue);
                        $results = array();
                       
                        foreach( $columnValue as $colKey => $colVal){

                            $getSourceType = $getPlaceholderDetails[0]['SourceAddress'];
                            $companyAddress = $getCompanyDetails[0]['CompanyGISKey'];
                            $companyToken = $getCompanyDetails[0]['CompanyGISToken'];
                            $requestType = $getPlaceholderDetails[0]['RequestType'];
                            $requestBody = $getPlaceholderDetails[0]['Body'];

                            $requestBody = str_replace("(" . $columnName[0] . ")", $colVal, $requestBody);

                            $requestUrl = str_replace("(address)", $companyAddress, $getSourceType);
                            $requestUrl = str_replace("(token)", $companyToken, $requestUrl);
                            
                            if ($requestUrl) {
                                $gcsCustomer = $requestUrl;
                                $ch = curl_init();
                                curl_setopt($ch, CURLOPT_HEADER, false);
                                curl_setopt($ch, CURLOPT_NOBODY, false);
                                curl_setopt($ch, CURLOPT_URL, $gcsCustomer);
                                if(strpos($requestUrl , 'EditRole') !== false)
                                {
                                    $head = array( 'Authorization:ZGVtb0BiYWJjLmFwcDpiYWJj',
                                    'Content-type:application/json');
                                
                                    curl_setopt($ch, CURLOPT_POSTFIELDS, $requestBody);
                                    curl_setopt($ch, CURLOPT_HTTPHEADER,$head);
                                }
                                else if ($requestType && $requestType == 2) {
                                    curl_setopt($ch, CURLOPT_POSTFIELDS, $requestBody);
                                    curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));
                                }
                               
                                curl_setopt($ch, CURLOPT_TIMEOUT, 60);
                                curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
                                $results = curl_exec($ch);
                                curl_close($ch);
                                
                                if(strpos($requestUrl , 'getEditRole') !== false)
                                {
                                    $results = json_decode($results, true);
                                    $apiData =  $results['data'];
                                }else if ($results) {
                            
                                    $decodedResults = json_decode($results, true);
            
                                    $apiData = $decodedResults;
                                    if ($decodedResults) {
                                        foreach ($_arrayList as $key) {
                                            if (isset($decodedResults[$key])) {
                                                $apiData = $decodedResults[$key];
                                                break;
                                            }
                                        }
                                    }
                                }
                            }
                           
                            if ($apiData) {
                                $apiData = $apiData[0];
                                $getSourceType = $getPlaceholderDetails[0]['SourceAddress_2'];
                                $companyAddress = $getCompanyDetails[0]['CompanyGISKey'];
                                $companyToken = $getCompanyDetails[0]['CompanyGISToken'];
                                $requestType = $getPlaceholderDetails[0]['RequestType_2'];
                                $requestBody = $getPlaceholderDetails[0]['Body_2'];
            
                                foreach ($apiData as $eachKey => $eachValue) {
                                    if ($eachKey && $eachValue) {
                                        $requestBody = str_replace("(" . $eachKey . ")", $eachValue, $requestBody);
                                    }
                                }
            
                                $requestUrl = str_replace("(address)", $companyAddress, $getSourceType);
                                $requestUrl = str_replace("(token)", $companyToken, $requestUrl);
            
                                if ($requestUrl) {
                                    $gcsCustomer = $requestUrl;
                                    $ch = curl_init();
                                    curl_setopt($ch, CURLOPT_HEADER, false);
                                    curl_setopt($ch, CURLOPT_NOBODY, false);
                                    curl_setopt($ch, CURLOPT_URL, $gcsCustomer);
            
                                    if(strpos($requestUrl , 'EditRole') !== false)
                                    {
                                        $head = array( 'Authorization:ZGVtb0BiYWJjLmFwcDpiYWJj',
                                        'Content-type:application/json');
                                       
                                        curl_setopt($ch, CURLOPT_POSTFIELDS, $requestBody);
                                        curl_setopt($ch, CURLOPT_HTTPHEADER,$head);
                                    }
                                    else if ($requestType && $requestType == 2) {
                                        curl_setopt($ch, CURLOPT_POSTFIELDS, $requestBody);
                                        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));
                                    }
                                    curl_setopt($ch, CURLOPT_TIMEOUT, 60);
                                    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
                                    $results = curl_exec($ch);
                                    curl_close($ch);
                                    
            
                                }
                            }

                        }
                        
                        if(strpos($requestUrl , 'getEditRole') !== false)
                        {
                            if(isset($postData['DeleteRedis'])) {
                                $placeholderIdTable = (isset($postData['placeholderId'])) ? $postData['placeholderId'] : 0;
                                $userPagePlaceholder = (isset($postData['userPagePlaceholder'])) ? $postData['userPagePlaceholder'] : 0;
                                $DeleteRedis = (isset($postData['DeleteRedis'])) ? $postData['DeleteRedis'] : 0;
                                $DataArr = self::RedisUpdate($placeholderIdTable ,  $userPagePlaceholder  ,  $DeleteRedis);
                            }
                            if($pageId && $decodedResults){
                                //$url['url'] = baseUrl . 'page?id='.$pageId.'&page_text='.$pageText;
                                header('Location: ' . $curLoc);
                                
                                exit;
                            }
                        }else if ($results) {
                            
                            if(isset($postData['DeleteRedis'])) {
                                $placeholderIdTable = (isset($postData['placeholderId'])) ? $postData['placeholderId'] : 0;
                                $userPagePlaceholder = (isset($postData['userPagePlaceholder'])) ? $postData['userPagePlaceholder'] : 0;
                                $DeleteRedis = (isset($postData['DeleteRedis'])) ? $postData['DeleteRedis'] : 0;
                                $DataArr = self::RedisUpdate($placeholderIdTable ,  $userPagePlaceholder  ,  $DeleteRedis);
                            }
                            $decodedResults = json_decode($results, true);
                            if($pageId && $decodedResults){
                                //$url['url'] = baseUrl . 'page?id='.$pageId.'&page_text='.$pageText;
                                $url['url'] = $curLoc ;
                                echo json_encode($url);
                                exit;
                            }

                        }

                    }

                }else {
                   
                    if ($getPlaceholderColumn) {
                        $columnName = (isset($postData['orderNoCol'])) ? $postData['orderNoCol'] : "";
                        $columnValue = (isset($postData['orderNoValue'])) ? $postData['orderNoValue'] : "";
                        $columnNameRow = (isset($postData['columnNameRow'])) ? $postData['columnNameRow'] : "";
                        $columnValueRow = (isset($postData['columnValueRow'])) ? $postData['columnValueRow'] : "";
                        $columnName = explode('||',$columnName);
                        $columnValue = explode('||',$columnValue);
                        if (count($columnName) > 1 && count($columnName) > 1 ) {
                            $requestBody = str_replace("(" . $columnName[0] . ")", $columnValue[0], $requestBody);
                            $requestBody = str_replace("(" . $columnName[1] . ")", $columnValue[1], $requestBody);
                        } else {
                            $requestBody = str_replace("(" . $columnName[0] . ")", $columnValue[0], $requestBody);
                        }
                    }
                    
                    $requestUrl = str_replace("(address)", $companyAddress, $getSourceType);
                    $requestUrl = str_replace("(token)", $companyToken, $requestUrl);
    
                    if ($requestUrl) {
                        $gcsCustomer = $requestUrl;
                        $ch = curl_init();
                        curl_setopt($ch, CURLOPT_HEADER, false);
                        curl_setopt($ch, CURLOPT_NOBODY, false);
                        curl_setopt($ch, CURLOPT_URL, $gcsCustomer);
                        if(strpos($requestUrl , 'EditRole') !== false)
                        {
                            $head = array( 'Authorization:ZGVtb0BiYWJjLmFwcDpiYWJj',
                            'Content-type:application/json');
                           
                            curl_setopt($ch, CURLOPT_POSTFIELDS, $requestBody);
                            curl_setopt($ch, CURLOPT_HTTPHEADER,$head);
                        }
                        else if ($requestType && $requestType == 2) {
                            curl_setopt($ch, CURLOPT_POSTFIELDS, $requestBody);
                            curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));
                        }
                       
                        curl_setopt($ch, CURLOPT_TIMEOUT, 600000000);
                        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
                        $results = curl_exec($ch);
                        curl_close($ch);

                       
                        if(strpos($requestUrl , 'getEditRole') !== false)
                        {
                            $results = json_decode($results, true);
                            $apiData =  $results['data'];
                        }else if ($results) {
                       
                            $decodedResults = json_decode($results, true);
    
                            $apiData = $decodedResults;
                            if ($decodedResults) {
                                foreach ($_arrayList as $key) {
                                    if (isset($decodedResults[$key])) {
                                        $apiData = $decodedResults[$key];
                                        break;
                                    }
                                }
                            }
                        }
                    }
                   
                    if ($apiData) {
                        $apiData = $apiData[0];
                        $getSourceType = $getPlaceholderDetails[0]['SourceAddress_2'];
    
                        $companyAddress = $getCompanyDetails[0]['CompanyGISKey'];
                        $companyToken = $getCompanyDetails[0]['CompanyGISToken'];
                        $requestType = $getPlaceholderDetails[0]['RequestType_2'];
                        $requestBody = $getPlaceholderDetails[0]['Body_2'];
    
                        foreach ($apiData as $eachKey => $eachValue) {
                            if ($eachKey && $eachValue) {
                                $requestBody = str_replace("(" . $eachKey . ")", $eachValue, $requestBody);
                            }
                        }
                       
                        $requestUrl = str_replace("(address)", $companyAddress, $getSourceType);
                        $requestUrl = str_replace("(token)", $companyToken, $requestUrl);
    
                        if ($requestUrl) {
                            $gcsCustomer = $requestUrl;
                            $ch = curl_init();
                            curl_setopt($ch, CURLOPT_HEADER, false);
                            curl_setopt($ch, CURLOPT_NOBODY, false);
                            curl_setopt($ch, CURLOPT_URL, $gcsCustomer);
    
                            if(strpos($requestUrl , 'EditRole') !== false)
                            {
                                $head = array( 'Authorization:ZGVtb0BiYWJjLmFwcDpiYWJj',
                                'Content-type:application/json');
                               
                                curl_setopt($ch, CURLOPT_POSTFIELDS, $requestBody);
                                curl_setopt($ch, CURLOPT_HTTPHEADER,$head);
                            }
                            else if ($requestType && $requestType == 2) {
                                curl_setopt($ch, CURLOPT_POSTFIELDS, $requestBody);
                                curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));
                            }
                            curl_setopt($ch, CURLOPT_TIMEOUT, 60);
                            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
                            $results = curl_exec($ch);
                            curl_close($ch);
                           
                            if(strpos($requestUrl , 'getEditRole') !== false)
                            {
                                if(isset($postData['DeleteRedis'])) {
                                    $placeholderIdTable = (isset($postData['placeholderId'])) ? $postData['placeholderId'] : 0;
                                    $userPagePlaceholder = (isset($postData['userPagePlaceholder'])) ? $postData['userPagePlaceholder'] : 0;
                                    $DeleteRedis = (isset($postData['DeleteRedis'])) ? $postData['DeleteRedis'] : 0;
                                    $DataArr = self::RedisUpdate($placeholderIdTable ,  $userPagePlaceholder  ,  $DeleteRedis);
                                }
                                if($pageId && $decodedResults){
                                    //$url['url'] = baseUrl . 'page?id='.$pageId.'&page_text='.$pageText;
                                    header('Location: ' . $curLoc);
                                    exit;
                                }
                            }else if ($results) {
                                if(isset($postData['DeleteRedis'])) {
                                    $placeholderIdTable = (isset($postData['placeholderId'])) ? $postData['placeholderId'] : 0;
                                    $userPagePlaceholder = (isset($postData['userPagePlaceholder'])) ? $postData['userPagePlaceholder'] : 0;
                                    $DeleteRedis = (isset($postData['DeleteRedis'])) ? $postData['DeleteRedis'] : 0;
                                    $DataArr = self::RedisUpdate($placeholderIdTable ,  $userPagePlaceholder  ,  $DeleteRedis);
                                }
                                $decodedResults = json_decode($results, true);
                                if($pageId && $decodedResults){
                                    //$url['url'] = baseUrl . 'page?id='.$pageId.'&page_text='.$pageText;
                                    $url['url'] = $curLoc ;
                                    echo json_encode($url);
                                    exit;
                                }
    
                            }
    
                        }
                    }
                }
                
            }
        }
    }
   
     // Update the dataSource Call
    public function updateDataSourceCallAction()
    {

        set_time_limit(0);
        ini_set('memory_limit', '2G');
        $postData = $_REQUEST['params'];
        if($postData) {
            $getUserDetails = User::getUserDetails($_SESSION['UserID']);
            if ($getUserDetails) {
                $getCompanyDetails = Companies::getCompanyDetails($getUserDetails[0]['CompanyID']);
            }
            $placeholderId = (isset($postData['dataSourceId'])) ? $postData['dataSourceId'] : "";
            $pageId = (isset($postData['pageTargetId'])) ? $postData['pageTargetId'] : "";
            $pageText = (isset($postData['pageTextValue'])) ? $postData['pageTextValue'] : "";

            $getPlaceholderDetails = Page::getDatasourceDetailsById($placeholderId);



            if ($getPlaceholderDetails) {
                $getSourceType = $getPlaceholderDetails[0]['SourceAddress'];

                $companyAddress = $getCompanyDetails[0]['CompanyGISKey'];
                $companyToken = $getCompanyDetails[0]['CompanyGISToken'];
                $requestType = $getPlaceholderDetails[0]['RequestType'];
                $requestBody = $getPlaceholderDetails[0]['Body'];

                $getPlaceholderColumn = trim($getPlaceholderDetails[0]['Placeholder']);

                $columnName = '';
                $columnValue = '';
                if ($getPlaceholderColumn) {
                    $columnName = (isset($postData['orderNoCol'])) ? $postData['orderNoCol'] : "";
                    $columnValue = (isset($postData['orderNoValue'])) ? $postData['orderNoValue'] : "";
                    $columnNameRow = (isset($postData['columnNameRow'])) ? $postData['columnNameRow'] : "";
                    $columnValueRow = (isset($postData['columnValueRow'])) ? $postData['columnValueRow'] : "";
                    $columnName1 = explode('||', $columnName);
                    $columnValue1  = explode('||', $columnValue);

                    if(count($columnName1) == count($columnValue1))
                    {

                        $columnNameRow = (isset($postData['columnNameRow'])) ? $postData['columnNameRow'] : "";
                        $columnValueRow = (isset($postData['columnValueRow'])) ? $postData['columnValueRow'] : "";
                        
                        foreach ($columnName1 as $key => $value) {
                            $requestBody = str_replace("(" . $columnName1[$key] . ")", $columnValue1[$key], $requestBody);
                        }
                    }else{

                       
                        $columnName = explode('||',$columnName);
                        $columnValue = explode('||',$columnValue);
                        if (count($columnName) > 1 && count($columnName) > 1 ) {
                            $requestBody = str_replace("(" . $columnName[0] . ")", $columnValue[0], $requestBody);
                            $requestBody = str_replace("(" . $columnName[1] . ")", $columnValue[1], $requestBody);
                        } else {
                            $requestBody = str_replace("(" . $columnName[0] . ")", $columnValue[0], $requestBody);
                        }
                    }
                }

                $requestUrl = str_replace("(address)", $companyAddress, $getSourceType);
                $requestUrl = str_replace("(token)", $companyToken, $requestUrl);

                if ($requestUrl) {
                    $gcsCustomer = $requestUrl;
                    $ch = curl_init();
                    curl_setopt($ch, CURLOPT_HEADER, false);
                    curl_setopt($ch, CURLOPT_NOBODY, false);
                    curl_setopt($ch, CURLOPT_URL, $gcsCustomer);

                    if ($requestType && $requestType == 2) {
                        curl_setopt($ch, CURLOPT_POSTFIELDS, $requestBody);
                        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));
                    }
                    curl_setopt($ch, CURLOPT_TIMEOUT, 60);
                    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
                    $results = curl_exec($ch);
                    curl_close($ch);

                    if ($results) {
                        $decodedResults = json_decode($results, true);
                        $apiData = $decodedResults;
                        if ($decodedResults) {
                            $status = array('status' => true);
                            echo json_encode($status);
                            exit;
                        }
                    }
                }
            }
        }
    }

    public function RedisUpdate($placeholderId , $userPagePlaceholder , $DeleteRedis){
       
       
        $_SESSION['RedisId'] = $userPagePlaceholder ;
        $_SESSION['RedisplaceholderId'] =  $placeholderId ;
        $_SESSION['DeleteRedis'] =  $DeleteRedis ;
        
        
        $data =  DataTables::generateTableAction();
        return print_r('Success');
       

    }

    public function ExcelUpload(){
        //$server = explode('htdocs/' , $_SERVER['DOCUMENT_ROOT']);
        //$server = $server[0].'htdocs/Babcportal';
		$server = $_SERVER['DOCUMENT_ROOT'];
        $CompanyName = $_SESSION['CompanyName'] ;
        $target_dir = $server.'/BabcPortal_Other_Assests/BabcPortal/Excel/'.$CompanyName.'/';
        $UserEmail = isset ($_SESSION['parentUsername'])?$_SESSION['parentUsername']:$_SESSION['username'];
        $target_file = $target_dir .$UserEmail.'_'.basename($_FILES["file"]["name"]);

        $file_type = explode(".", basename($_FILES["file"]["name"]));
        $file_type = end( $file_type);
        if ($file_type == "xlsx" || $file_type == "xlx") {
            if (move_uploaded_file($_FILES["file"]["tmp_name"], $target_file)) {
                $sql = "Insert into ExceluploadedFiles (Filename , dateCreated) VALUES ( '".basename($_FILES["file"]["name"])."' , '" .date('Y-m-d H:i:s')." ')";
                User::AddQuery($sql, 'BP_Saljpartner');
                $subject = "Excel-filen uppladdad";
                $msg = "File " . basename($_FILES["file"]["name"]) . " har laddats och vissas i portalen om 15 min." ;
                $this->SendMail($subject , $msg);
                echo "Filen" . basename($_FILES["file"]["name"]) . " har laddats och vissas i portalen om 15 min.";
            } else {
                $subject = "Excel-filen uppladdad";
                $msg = "Tyvärr uppstod ett fel vid uppladdning av din fil." ;
                $this->SendMail($subject , $msg);
                echo "Tyvärr uppstod ett fel vid uppladdning av din fil..";
            }
        }else{
            $subject = "Excel-fil uppladdad i fel formatt";
                $msg =  "Sorry, there was an error uploading your file. Kindly select an Excel format File " ;
                $this->SendMail($subject , $msg);
            echo "Sorry, there was an error uploading your file. Kindly select an Excel format File ";
        }

    }
   
    public function PDFUpload(){
        //$server = explode('htdocs/' , $_SERVER['DOCUMENT_ROOT']);
        //$server = $server[0].'htdocs/Babcportal';
        $server = $_SERVER['DOCUMENT_ROOT'];
        $target_dir = $server.'/BabcPortal_Other_Assests/Cron/pdf2/PDFS/';

        $UserEmail = isset ($_SESSION['parentUsername'])?$_SESSION['parentUsername']:$_SESSION['username']; // getting current user Email
        $target_file = $target_dir .$UserEmail.'_'.basename($_FILES["file"]["name"]);
        //$target_file = $target_dir . basename($_FILES["file"]["name"]);
       
        
        $file_type=$_FILES['file']['type'];
 
        if ($file_type=="application/pdf") {
            
            if (move_uploaded_file($_FILES["file"]["tmp_name"], $target_file)) {

                $sql = "Insert into PDFuploadedFiles (Filename , dateCreated) VALUES ( '".basename($_FILES["file"]["name"])."' , '" .date('Y-m-d H:i:s')." ')";
                User::AddQuery($sql, 'BP_Saljpartner');
                $subject = "PDF File Uploaded";
                $msg = "Filen " . basename($_FILES["file"]["name"]) . " har laddats och vissas i portalen om 15 min." ;
                $this->SendMail($subject , $msg);
                echo "Filen " . basename($_FILES["file"]["name"]) . " har laddats och vissas i portalen om 15 min.";
            } else {
                $subject = "PDF File Uploading Error";
                $msg = "Sorry, there was an error uploading your file." ;
                $this->SendMail($subject , $msg);
                echo "Sorry, there was an error uploading your file.";
            }
        }else{
            $subject = "PDF File uploaded worng  Format";
                $msg =  "Sorry, there was an error uploading your file. Kindly Select an PDF format File " ;
                $this->SendMail($subject , $msg);
            echo "Sorry, there was an error uploading your file. Kindly Select an PDF format File ";
        }
        
    }
	
	public function FileDelete(){
		$fileName = $_REQUEST['Data'];
		$server = $_SERVER['DOCUMENT_ROOT'];
        $target_dir_PDF = $server.'/BabcPortal_Other_Assests/Cron/pdf2/PDFS/';
		 
	     $CompanyName = $_SESSION['CompanyName'] ;
        $target_dir_Excel = $server.'/BabcPortal_Other_Assests/BabcPortal/Excel/'.$CompanyName.'/';
		
        $UserEmail = isset ($_SESSION['parentUsername'])?$_SESSION['parentUsername']:$_SESSION['username']; // getting current user Email
		$fileNameOld = $fileName;
		$fileName = explode('.', $fileName);
		$fileExt = $fileName[1];
		$fileName =  implode('.', $fileName);
        
        if($fileExt == 'xlxs'){
			$target_file_email = $target_dir_Excel .$UserEmail.'_'.$fileNameOld;
			$target_file = $target_dir_Excel .$fileNameOld;
			if(file_exists($target_file_email)){
				 
				unlink($target_file_email);
				$sql = "Delete from ExceluploadedFiles where Filename = '".$fileName."'";
                User::AddQuery($sql, 'BP_Saljpartner');
				echo "File have been Deleted";
				
			}else if(file_exists($target_file)){
				
				unlink($target_file);
				$sql = "Delete from ExceluploadedFiles where Filename = '".$fileName."'";
                User::AddQuery($sql, 'BP_Saljpartner');
				echo "File have been Deleted";
				
			}else {
				echo "No Such File Exist";
			}
			
		}else if($fileExt == 'pdf'){
			
			$target_file_email = $target_dir_PDF .$UserEmail.'_'.$fileNameOld;
			$target_file = $target_dir_PDF .$fileNameOld;
			if(file_exists($target_file_email)){
				
				unlink($target_file_email);
				$sql = "Delete from PDFuploadedFiles where Filename = '".$fileName."'";
                User::AddQuery($sql, 'BP_Saljpartner');
				echo "File have been Deleted";
				
			}else if(file_exists($target_file)){
				
				unlink($target_file);
				$sql = "Delete from PDFuploadedFiles where Filename = '".$fileName."'";
                User::AddQuery($sql, 'BP_Saljpartner');
				echo "File have been Deleted";
				
			}else {
				echo "No Such File Exist";
			}
		}
		 
		 exit;
       
	}

    public function SendMail($subject , $msg){
        $mail = new PHPMailer(true);
        $mail_host = 'smtp.office365.com';
        $mail_username = 'noreply@gcsolutions.se';
        $mail_password = '!GCSmail2022';
        $mail_port = 587;
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
            $mail->addAddress('saman.andishmand@gcsolutions.se', 'User');
            $UserEmail = isset ($_SESSION['parentUsername'])?$_SESSION['parentUsername']:$_SESSION['username']; // getting current user Email
            $mail->addAddress($UserEmail, $_SESSION['UserFirstName']);
    
            $mail->isHTML(true);
            $mail->Subject = $subject;
            $mail->Body    = $msg;
    
            $mail->send();
        } catch (Exception $e) {
            $error = "Mailer Error: " . $mail->ErrorInfo;
        }
    }

}


?>