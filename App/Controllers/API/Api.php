<?php

namespace App\Controllers\API;

use MongoDB;
use ZipArchive;
use \Core\View;
use \App\Models\Apis;
use \App\Models\Placeholder;
use \App\Models\Page;
use \App\Models\User;
use \App\Models\Companies;
use \App\Models\Execute;
use App\Controllers\DataFormatHelper\DataTableHelper;
use \App\Models\Products;
use \App\Controllers\API\APILogin;
use \App\Controllers\API\APIGenerateTableData;
//use \App\Controllers\API\MongoTable;
use \App\Models\MongoTable;

/**
 * Api controller
 *
 * PHP version 7.0
 */

// Need to separate that code .

// This file conatin all the FUnction for gererating the API data .
// The main function allow to create (GET , POST , PUT ) requests .
 
class Api extends \Core\Controller
{
  public $_arrayList = array('ResultList');
  public $retval = array();

  // this is the main function API  . All the API comes to this Function .
  // this function has diiferent parts in it e.g logic for login , or for downloading the image zip , and accessing a post request or a Get one . logoc for Logout part .

  public function ExternalAccess(){

    header('Access-Control-Allow-Origin: *');
    header('Access-Control-Allow-Methods: GET, POST, PATCH, PUT, DELETE, OPTIONS');
    header('Access-Control-Allow-Headers: Origin, Content-Type, Authorization, authorization, X-Auth-Token');


    set_time_limit(0);
    ini_set('memory_limit', '2G');
    header('Content-Type: application/json');
    $headers = apache_request_headers();
    $getUserDetail= '';
    $url =  '';
    $auth = '';
    
    
    if(strpos($_SERVER['QUERY_STRING'], 'userLogin') !== false ) // For user Login 
    {
          APILogin::loginUser();  
    }
    else if(strpos($_SERVER['QUERY_STRING'], 'userLogOut') !== false )
    {
          APILogin::logoutUser(); 
    }


    if(isset($headers['authorization']) || isset($headers['Authorization'])|| isset($_GET['AuthKey'])){
        if(isset($headers['authorization'])){
          $auth =$headers['authorization'];
          
        }else if(isset($headers['Authorization'])){
          $auth =$headers['Authorization'];
          
        }else{
          $auth = $_GET['AuthKey'];
        }
        $user = base64_decode($auth);
        $user = explode(':' , $user);
        
        $body = file_get_contents("php://input"); 
        if(!empty($body))
        {
           
            $body = json_decode($body , true);
            if( (isset($body['username']) &&  isset($body['password']))){
                if($body['username'] !=  $user[0] || $body['password'] !=  $user[1] ){
                        echo json_encode(array('Status' => 'Please Enter Correct Authorization Key ')); 
                        exit;
                }
            }
        }

        $getUserDetail = Companies::getSpecficUsers($user[0]);
     }
 
      if(empty($getUserDetail))
      {
        echo json_encode(array('Status' => 'Please Enter Correct Authorization Key ')); 
        exit;
      }
      $_SESSION['UserID'] = $getUserDetail[0]['UserID'];
      $_SESSION['DBParam'] = $getUserDetail[0]['DBParam'];
      $_SESSION['NowTime'] =  date("ymd"); 

      if($_SERVER['REQUEST_METHOD'] == 'GET' )
      {
          $reqType = 1;
      }else if ($_SERVER['REQUEST_METHOD'] == 'POST')
      {
          $reqType = 2;
      }

      if(isset($_REQUEST['reqtype']))
      {
          $reqType = $_REQUEST['reqtype'];
      }
      
      if(strpos($_SERVER['REQUEST_URI'], '/getSpecficDetail?'))
      {
              $url = explode('/getSpecficDetail?', $_SERVER['REQUEST_URI']);
              if(strpos($url[0], 'public/') !== false)
              {
                $url =  explode('public/', $url[0]);
                $url = trim($url[1] , '/');
                
              }else{
                $url = trim($url[0] , '/');
              }
      }else
      {
            $url = $_SERVER['QUERY_STRING'];
            if(strpos($url, '&') !== false)
            {
               $url = explode('&',  $url);
               $url = $url[0];
            }
           
            
      }
      
    if(strpos($_SERVER['REQUEST_URI'], '/focusPage?'))
    {
          $url = explode('/focusPage?', $_SERVER['REQUEST_URI']);
        
              $var = explode('&' ,$url[1]);
              if(strpos($url[0], '/public') !== false)
              {
                $url =  explode('/public', $url[0]);
                $url = trim($url[1] , '/');
                
              }else{
                $url = trim($url[0] , '/');
              }
          
          if (!empty($_REQUEST['columnName']) && !empty($_REQUEST['columnValue'])) {
          
          $_REQUEST[$_REQUEST['columnName'] ]=  $_REQUEST['columnValue'];
      }
          
          $APIData = Apis::getSpecficAPI( $url, $reqType);
        
         
          $_REQUEST['placeholderId'] = $_GET['Tableid'];
          $_REQUEST['APIData'] = $APIData[0];
          $_REQUEST['APIData']['PlaceholderActionIds'] = '';
          $_REQUEST['AuthKey']= $auth;
         
    }else
    {
      
      $APIData = Apis::getSpecficAPI( $url, $reqType);
      
      
    }
    
      if($reqType == '2' && (empty($APIData[0]['Fields'])))
      { 
       
        if(  strpos($_SERVER['REDIRECT_URL'] , 'getEditRole')){
          $body =  json_decode(file_get_contents("php://input") , true); 
            $query = "Select * from EditableCSV  where ID = '".$body['ID']."'";
            $allData = User::AddQuery($query,'BP_GcSolutions'  );
            if($allData)
                echo json_encode(array('data' => $allData));
            else
                echo json_encode(array('FailMsg' => ' Fail'));
            exit; 
        }
        if(strpos($APIData[0]['APIUrl'] , 'postEditRole')){
            $body =  json_decode(file_get_contents("php://input") , true); 
            $query = "update EditableCSV set Role =  '".$body['Role']."' where ID = '".$body['ID']."'";
            $allData = User::AddQuery($query,'BP_GcSolutions'  );
            if($allData)
                echo json_encode(array('SuccessMsg' => 'Success'));
            else
                echo json_encode(array('FailMsg' => ' Fail'));
            exit;
        }
        if(!empty($APIData[0]['Tables'])){
          $_REQUEST['placeholderId'] = $APIData[0]['Tables'];
          $_REQUEST['APIData'] = $APIData[0];
          $_REQUEST['AuthKey']= $auth;

          $body = file_get_contents("php://input"); 
          $_REQUEST['postBody']=  $body ;
          $res = Self::placeholderUpdateFormAction();
         
          if($res){
            echo json_encode(array('SuccessMsg' => 'Order has been placed' , 'OrderNo'=> trim($res,'"')));
          }else
          {
            echo json_encode(array('FailMsg' => 'order has not being placed' , 'OrderNo'=> 0));
          }
        }else{
            $body = file_get_contents("php://input"); 
            $body = json_decode($body, true) ; 
            $zip = new ZipArchive;
            $zipname = sys_get_temp_dir() . "/" . time() . ".zip";
                 if ($zip->open($zipname, ZipArchive::CREATE) === TRUE) {
              
                      set_time_limit(0);
                     
                      foreach ($body['ImageUrl'] as $urlKey => $urlValue) {
                          $imgName = explode('/' , $urlValue);
                          $imgName =  end($imgName);
                          $imgName = str_replace(' ', '_', $imgName);
                        $urlValue = str_replace(' ', '%20', $urlValue);
                        $zip->addFromString($imgName, file_get_contents($urlValue));
                       
                      }
                      
                      $zip->close();
                      if (file_exists($zipname)) {
                          // force to download the zip
                          header("Pragma: public");
                          header("Expires: 0");
                          header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
                          header("Cache-Control: private", false);
                          header('Content-type: application/zip');
                          header('Content-Disposition: attachment; filename="' . $zipname . '"');
                          readfile($zipname);
                          // remove zip file from temp path
                          unlink($zipname);

                          echo "ok";
                       } else {
                          echo "file not exist";
                       }
                      } else {
                         echo "failed";
                    }
                    exit;
          
            
            echo json_encode(array('SuccessMsg' => 'Image downloaded' ));
            
        }

        
        exit;
      }
     
      if($reqType == '2' && (isset($_REQUEST['reqType']) && $_REQUEST['reqType'] == 'delete'))
      {
        $_REQUEST['placeholderId'] = $APIData[0]['Tables'];
        $_REQUEST['APIData'] = $APIData[0];
        $_REQUEST['AuthKey']= $auth;
        //$res = Self::placeholderUpdateFormAction();
        if($res){
          echo json_encode(array('Status' => 'Result deleted'));
        }else
        {
          echo json_encode(array('Status' => 'Result NOT deleted'));
      
        }
        exit;
      }
      elseif ($reqType == '1') {
       
        $_REQUEST['placeholderId'] = $APIData[0]['Tables'];
        $_REQUEST['APIData'] = $APIData[0];
        $_REQUEST['AuthKey']= $auth; 
        
        if(strpos($_SERVER['QUERY_STRING'], 'GetImages') !== false ){
          $filter = [];
          
          if(isset($_REQUEST['ImageID']))
          {
               $imageId = new MongoDB\BSON\ObjectID($_REQUEST['ImageID']);
               $filter = ['_id'=> $imageId];
          }
          $imageData = Products::GetImages($filter);
         
          if(isset($imageData[0]->uploadImage)){
            echo json_encode(array('Image' => $imageData[0]->uploadImage));
          }else{
            echo json_encode(array('Image' => $imageData[0]->uploadImage_MongoDB));
          }
         
          exit;
        }



        if(count($_GET) > 1)
        {
          
          $_REQUEST['Fields'] = $_REQUEST['APIData']['Fields'] ;

          $_REQUEST['APIData']['Fields'] = '';
          $_REQUEST['APIData']['parameterFocusPage'] = '';
          $_REQUEST['APIData']['showFocusPage'] = '';

          $tempArrr = [];
      
          $parm = $APIData[0]['parameterFocusPage'];
          
          if(!empty($parm)){
            $res = APIGenerateTableData::generateTableAction();
                  $parm = explode(',', $APIData[0]['parameterFocusPage']);
               
            foreach ($res['data'] as $key => $value) {
              foreach ($parm  as $key1 => $value1) {
                $colName = explode('-', $value1);
                        
                $colName = isset($colName[1])?$colName[1]:$colName[0];
                        $colName = trim($colName);
                        
                if($value[$colName] == $_GET[$colName])
              {
                $tempArrr[] = $value; 
              }
              }
            }
            $res['data'] = $tempArrr;
          }else{
          
             $tempArrrFin = [];
              $loopCheck = 1;
              while($loopCheck){
                  $_REQUEST['placeholderId'] = $APIData[0]['Tables'];
                  $_REQUEST['APIData'] = $APIData[0];
                  $_REQUEST['AuthKey']= $auth;
                 
                  $res = APIGenerateTableData::generateTableAction();
                
                  $tempArrr = [];
                
                  if($res){

                    $tempArrr =   $res['data'];
                    $cntArr = count($tempArrr);
                    $gettable  = MongoTable::getMongotable( $_REQUEST['placeholderId'] );
                    if(isset($tempArrr[0]) && isset($_REQUEST['ProductNo']) && !empty($gettable)){
                       
                      foreach ($tempArrr as $key => $value) {
                        $select = [];
                        $gettable  = MongoTable::getMongotable( $_REQUEST['placeholderId'] );
                        if($gettable){
                          $formFields = json_decode($gettable[0]['DetailColumns'] , true);
                          
                          foreach ($formFields as $formFieldskey => $formFieldsvalue) {
                              $select[$formFieldskey ] = 1;
                          }
                        }
                        $select['ImageId'] = 1;
                        $result = Products::getProduct($select , $value['ProductNo']);
                       
                        //$result = $tempArrr;
                        if($result[0]){
                          foreach ($result[0] as $resKey => $resValue) {
                              unset($select['minStockStatus']);
                              unset($select['maxStockStatus']);
                              if(array_key_exists($resKey,  $select))
                              {
                                  
                                  if($resKey == 'minStock' && ( $resValue != '') )
                                  {

                                      if($cntArr == 1){
                                          $_SESSION['StockStatus'] = $resValue;
                                          $_SESSION['minStockStatus'] = false;
                                          $_SESSION['maxStockStatus'] = true;
                                      }
                                     
                                      $checkVal = isset($_SESSION['StockStatus'])?$_SESSION['StockStatus']:$resValue;

                                      if((int)$value['Stock'] < (int)$checkVal)
                                      {
                                        $tempArrr[$key]['StockStatus'] =   isset($_SESSION['minStockStatus'])?$_SESSION['minStockStatus']:0;
                                      }else{
                                        $tempArrr[$key]['StockStatus'] =   isset($_SESSION['maxStockStatus'])?$_SESSION['maxStockStatus']:0;
                                      }

                                  }else{
                                    if($resValue != ''){
                                        $tempArrr[$key][$resKey] = $resValue;
                                      }
                                  }
                              }
                          }
                        }

                        if((isset($_SESSION['StockStatus']) &&  $_SESSION['StockStatus']!= '') && $cntArr > 1 && isset($value['Stock']))
                        {
                            $checkVal = isset($_SESSION['StockStatus'])?$_SESSION['StockStatus']:'';

                            if((int)$value['Stock'] < (int)$checkVal)
                            {
                              $tempArrr[$key]['StockStatus'] =   isset($_SESSION['minStockStatus'])?$_SESSION['minStockStatus']:0;
                            }else{
                              $tempArrr[$key]['StockStatus'] = isset($_SESSION['maxStockStatus'])?$_SESSION['maxStockStatus']:0;
                            }
                        }


                           
                      }
                      
                    }
                    }
                 
                    if(!empty($APIData[0]['linkedApi'])){
                        $tempArrrFin = $tempArrr;
                        $APIData = Apis::getAPI($APIData[0]['linkedApi']);
                    }else{
                        if(!empty($tempArrrFin)){
                              $tempArrrFin = array_merge($tempArrrFin , $tempArrr);
                              $tempArrr = [];
                              $tempArrr = $tempArrrFin;
                        }
                        $loopCheck = 0;
                    }

              }
          $res['data'] = $tempArrr;
          }
  
        }else{
            
              $tempArrrFin = [];
              $loopCheck = 1;
              while($loopCheck){
                  $_REQUEST['placeholderId'] = $APIData[0]['Tables'];
                  $_REQUEST['APIData'] = $APIData[0];
                  $_REQUEST['AuthKey']= $auth;
                 
                  $res = APIGenerateTableData::generateTableAction();
                   
                  $tempArrr = [];
                
                  if($res){

                    $tempArrr =   $res['data'];
                    $cntArr = count($tempArrr);
                    // if(isset($tempArrr[0]) && array_key_exists('ProductNo', $tempArrr[0])){
                    //   foreach ($tempArrr as $key => $value) {
                    //     $select = [];
                    //     $gettable  = MongoTable::getMongotable( $_REQUEST['placeholderId'] );
                    //     if($gettable){
                    //       $formFields = json_decode($gettable[0]['DetailColumns'] , true);
                          
                    //       foreach ($formFields as $formFieldskey => $formFieldsvalue) {
                    //           $select[$formFieldskey ] = 1;
                    //       }
                    //     }
                    //     $select['ImageId'] = 1;
                    //     $result = Products::getProduct($select , $value['ProductNo']);
                      
                    //     if(isset($result) && !empty($result[0])){
                    //       foreach ($result[0] as $resKey => $resValue) {
                    //           unset($select['minStockStatus']);
                    //           unset($select['maxStockStatus']);
                    //           if(array_key_exists($resKey,  $select))
                    //           {
                                  
                    //               if($resKey == 'minStock' && ( $resValue != '') )
                    //               {

                    //                   if($cntArr == 1){
                    //                       $_SESSION['StockStatus'] = $resValue;
                    //                       $_SESSION['minStockStatus'] = false;
                    //                       $_SESSION['maxStockStatus'] = true;
                    //                   }
                                     
                    //                   $checkVal = isset($_SESSION['StockStatus'])?$_SESSION['StockStatus']:$resValue;

                    //                   if((int)$value['Stock'] < (int)$checkVal)
                    //                   {
                    //                     $tempArrr[$key]['StockStatus'] =  $_SESSION['minStockStatus'];
                    //                   }else{
                    //                     $tempArrr[$key]['StockStatus'] =  $_SESSION['maxStockStatus'];
                    //                   }

                    //               }else{
                    //                 if($resValue != ''){
                    //                     $tempArrr[$key][$resKey] = $resValue;
                    //                   }
                    //               }
                    //           }
                    //       }
                    //     }

                    //     if((isset($_SESSION['StockStatus']) &&  $_SESSION['StockStatus']!= '') && $cntArr > 1 && isset($value['Stock']))
                    //     {
                    //         $checkVal = isset($_SESSION['StockStatus'])?$_SESSION['StockStatus']:'';

                    //         if((int)$value['Stock'] < (int)$checkVal)
                    //         {
                    //           $tempArrr[$key]['StockStatus'] =  $_SESSION['minStockStatus'];
                    //         }else{
                    //           $tempArrr[$key]['StockStatus'] =  $_SESSION['maxStockStatus'];
                    //         }
                    //     }


                           
                    //   }
                      
                    // }
                    }
                 
                    if(!empty($APIData[0]['linkedApi'])){
                        $tempArrrFin = $tempArrr;
                        $APIData = Apis::getAPI($APIData[0]['linkedApi']);
                    }else{
                        if(!empty($tempArrrFin)){
                              $tempArrrFin = array_merge($tempArrrFin , $tempArrr);
                              $tempArrr = [];
                              $tempArrr = $tempArrrFin;
                        }
                        $loopCheck = 0;
                    }

              }
          $res['data'] = $tempArrr;
        }
      
        echo json_encode($res, JSON_UNESCAPED_SLASHES);
        exit;

      }
      else if($reqType == '2')
      {
       
              $body = file_get_contents("php://input"); 
              $body = json_decode( $body ,true);
              if($body){
                foreach ($body as $bKey => $bValue) {
                    $_REQUEST[$bKey] = $bValue;
                }
              }
              $tempArrrFin = [];
              $loopCheck = 1;
              while($loopCheck){
                  $_REQUEST['placeholderId'] = $APIData[0]['Tables'];
                  $_REQUEST['APIData'] = $APIData[0];
                  $_REQUEST['AuthKey']= $auth;
                 
                  $res = APIGenerateTableData::generateTableAction();
                  
                  $colName = isset($_REQUEST['colName'])?$_REQUEST['colName']:'';
                  $searchType = isset($_REQUEST['searchType'])?$_REQUEST['searchType']:'';
                  
                  $tempArrr = [];
                  if($searchType == 'Normal'){
                    $searchValue = $_REQUEST['searchValue'];
                    foreach ($res['data'] as $key => $value) {
                      if(   strpos($value[$colName], $searchValue) !== false )
                      {
                        $tempArrr[] = $value; 
                      }
                    }
                  }else if ($searchType == 'Range')
                  {
                    $to = $_REQUEST['to'];
                    $from = $_REQUEST['from'];
                    foreach ($res['data'] as $key => $value) {

                      if(!empty($from) && !empty($to))
                      {
                        if(($value[$colName] >= $from && $value[$colName] <= $to) )
                        {
                          $tempArrr[] = $value; 
                        }
                      }else if(!empty($from) ){
                        if(($value[$colName] >= $from ) )
                        {
                          $tempArrr[] = $value; 
                        }
                      }else if(!empty($to))
                      {
                        if(($value[$colName] <= $to) )
                        {
                          $tempArrr[] = $value; 
                        }
                      }
                      
                    }

                  }elseif($searchType == 'Multiple')
                  {
                    $searchValue = $_REQUEST['searchValue'];
                    $searchValue = explode(',', $searchValue);
                    foreach ($res['data'] as $key => $value) {
                      foreach ($searchValue as $keys => $values) {
                        
                        if($value[$colName] == $values)
                        {
                          $tempArrr[] = $value; 
                        }
                      }
                    }

                  }
                  else{
                    $tempArrr =   $res['data'];
                    $cntArr = count($tempArrr);
                    if(isset($tempArrr[0]) && array_key_exists('ProductNo', $tempArrr[0])){
                      foreach ($tempArrr as $key => $value) {
                        $select = [];
                        $gettable  = MongoTable::getMongotable( $_REQUEST['placeholderId'] );
                        if($gettable){
                          $formFields = json_decode($gettable[0]['DetailColumns'] , true);
                          
                          foreach ($formFields as $formFieldskey => $formFieldsvalue) {
                              $select[$formFieldskey ] = 1;
                          }
                        }
                        $select['ImageId'] = 1;
                        $result = Products::getProduct($select , $value['ProductNo']);
                      
                        if($result[0]){
                          foreach ($result[0] as $resKey => $resValue) {
                              unset($select['minStockStatus']);
                              unset($select['maxStockStatus']);
                              if(array_key_exists($resKey,  $select))
                              {
                                  
                                  if($resKey == 'minStock' && ( $resValue != '') )
                                  {

                                      if($cntArr == 1){
                                          $_SESSION['StockStatus'] = $resValue;
                                          $_SESSION['minStockStatus'] = false;
                                          $_SESSION['maxStockStatus'] =true;
                                      }
                                     
                                      $checkVal = isset($_SESSION['StockStatus'])?$_SESSION['StockStatus']:$resValue;

                                      if((int)$value['Stock'] < (int)$checkVal)
                                      {
                                        $tempArrr[$key]['StockStatus'] =  $_SESSION['minStockStatus'];
                                      }else{
                                        $tempArrr[$key]['StockStatus'] =  $_SESSION['maxStockStatus'];
                                      }

                                  }else{
                                    if($resValue != ''){
                                        $tempArrr[$key][$resKey] = $resValue;
                                      }
                                  }
                              }
                          }
                        }

                        if((isset($_SESSION['StockStatus']) &&  $_SESSION['StockStatus']!= '') && $cntArr > 1 && isset($value['Stock']))
                        {
                            $checkVal = isset($_SESSION['StockStatus'])?$_SESSION['StockStatus']:'';

                            if((int)$value['Stock'] < (int)$checkVal)
                            {
                              $tempArrr[$key]['StockStatus'] =  $_SESSION['minStockStatus'];
                            }else{
                              $tempArrr[$key]['StockStatus'] =  $_SESSION['maxStockStatus'];
                            }
                        }


                           
                      }
                      
                    }
                    }
                  
                    if(!empty($APIData[0]['linkedApi'])){
                        $tempArrrFin = $tempArrr;
                        $APIData = Apis::getAPI($APIData[0]['linkedApi']);
                    }else{
                        if(!empty($tempArrrFin)){
                              $tempArrrFin = array_merge($tempArrrFin , $tempArrr);
                              $tempArrr = [];
                              $tempArrr = $tempArrrFin;
                        }
                        $loopCheck = 0;
                    }

              }
      }


      $res['data'] = $tempArrr;
      echo json_encode($res, JSON_UNESCAPED_SLASHES);
          exit;
   }
    

    public function placeholderUpdateFormAction()
    {
      
        $getUserDetails = User::getUserDetails($_SESSION['UserID']);
        if ($getUserDetails) {
            $getCompanyDetails = Companies::getCompanyDetails($getUserDetails[0]['CompanyID']);
        }
        $placeholderId = (isset($_REQUEST['placeholderId'])) ? $_REQUEST['placeholderId'] : "";
        
        $getPlaceholderDetails = Page::getDatasourceDetailsById($placeholderId);

        $getPlaceholderDetails = Page::getDatasourceDetailsById($placeholderId);

        
        if ($getPlaceholderDetails) {
            $getSourceType = $getPlaceholderDetails[0]['SourceAddress_2'];

            $companyAddress = $getCompanyDetails[0]['CompanyGISKey'];
            $companyToken = $getCompanyDetails[0]['CompanyGISToken'];
            $requestType = $getPlaceholderDetails[0]['RequestType_2'];
            $requestBody = $_REQUEST['postBody'];
            
            if($requestBody )
            {
              $value = json_decode($_REQUEST['postBody'], true);
               foreach ($value as $key => $val) {
                  $value[$key] = str_replace('(nowtime)', $_SESSION['NowTime'], $val) ;
               }

               $requestBody = json_encode($value);
            }
            $getPlaceholderColumn = trim($getPlaceholderDetails[0]['Placeholder']);
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
            }
        }

      if($results)
      {
          return $results;
      }else{
        return false;
      }
     
    }

 


}

?>