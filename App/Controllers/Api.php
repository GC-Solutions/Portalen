<?php

namespace App\Controllers;

use MongoDB;
use \Core\View;
use \App\Models\Apis;
use \App\Models\Placeholder;
use \App\Models\Page;
use \App\Models\User;
use \App\Models\Companies;
use \App\Models\Execute;
use App\Controllers\DataTableHelper;
use \App\Models\Products;
use \App\Models\DataSources;
use \App\Models\TablePlaceholders;
use \App\Models\MongoTable;
/**
 * DataTables controller
 *
 * PHP version 7.0
 */
class Api extends \Core\Controller
{
	public $_arrayList = array('ResultList');
	public $retval = array();

	public function showAllAPI(){

		$getAllAPI = Apis::getAllAPI();
        View::render('administrator/API/show.php', ['getAllApi' => $getAllAPI]);
	}
  public function deleteAction()
  {
      $APIId = (isset($_REQUEST['id'])) ? $_REQUEST['id'] : "";

      if ($APIId) {
          Apis::deleteAPI($APIId);
      }
      header('Location: ' . baseUrl . 'api');
  }
	public function addApiAction(){
        if (isset($_SESSION['IsAdmin']) && $_SESSION['IsAdmin'] == 1) {
            $APIid = (isset($_REQUEST['id'])) ? $_REQUEST['id'] : "";
            
            if($APIid){

            	$getAllTableActions = Placeholder::getAllTableData("TableActions");
                $getSpecificDetail = Apis::getAPI($APIid);
              	$getDataTable = getAllDataTable::getAllDataTable();
                $getDataSource = DataSources::getAllDataSourceApi();
                $getAllAPI = Apis::getAllAPI();
              
                View::render('administrator/API/add.php', ['APIDetail' => $getSpecificDetail[0] , 'getDataTable' => $getDataTable , 'getAllTableActions' => $getAllTableActions , 'getDataSource' => $getDataSource , 'getAllAPI' => $getAllAPI]);
            }
            else{

            	$getAllTableActions = Placeholder::getAllTableData("TableActions");
            	$getDataTable = getAllDataTable::getAllDataTable();
              $getDataSource = DataSources::getAllDataSourceApi();
              $getAllAPI = Apis::getAllAPI();
              
              View::render('administrator/API/add.php', ['getDataTable' => $getDataTable , 'getAllTableActions' => $getAllTableActions, 'getDataSource' => $getDataSource , 'getAllAPI' => $getAllAPI]);
            }
        } else {
            header('Location: ' . baseUrl . 'api');
        }
  }
  public function saveApiAction(){
    	$Fields = (isset($_REQUEST['Fields'])) ? $_REQUEST['Fields'] : "";

        if ($Fields) {
            $Fields = implode(',', $Fields);
        }
        $params = (isset($_REQUEST['parameterFocusPage'])) ? $_REQUEST['parameterFocusPage'] : "";

        if ($params) {
            $params = implode(',', $params);
        }
        $PlaceholderActionIds = (isset($_REQUEST['PlaceholderActionIds'])) ? $_REQUEST['PlaceholderActionIds'] : "";

        if ($PlaceholderActionIds) {
            $PlaceholderActionIds = implode(',', $PlaceholderActionIds);
        }
    	$_REQUEST['Fields'] = $Fields;
    	$_REQUEST['parameterFocusPage'] = $params;
    	$_REQUEST['PlaceholderActionIds'] = $PlaceholderActionIds;
    	
        Apis::addAPI();
        header('Location: ' . baseUrl . 'api');
    }
   public function ExternalAccess(){

	   header('Access-Control-Allow-Origin: *');
	   header('Access-Control-Allow-Methods: GET, POST, PATCH, PUT, DELETE, OPTIONS');
	   header('Access-Control-Allow-Headers: Origin, Content-Type, Authorization, authorization, X-Auth-Token');

      define('GlobalAuthKey', 'Z2xvYmFsYXV0aEBiYWJjLmFwcDpnaGRmazclOWhmJjRmaCVqIA') ; // == Removed Global Auth (MD5)
      // OLD = define('GlobalAuthKey', '54712cecea80d5a149ecb6f0f597e8f6') ; // sam_me@me.com:12345  MD5
      set_time_limit(0);
      ini_set('memory_limit', '2G');
      header('Content-Type: application/json');
   	  $headers = apache_request_headers();
   	  $getUserDetail= '';
   	  $url =  '';
         $auth = '';
      
      if(strpos($_SERVER['QUERY_STRING'], 'userLogin') !== false ) // For user Login 
      {
          $body = file_get_contents("php://input"); // it allows us to tale the json value from body 
          $body = json_decode( $body ,true);
          if($body){
            foreach ($body as $bKey => $bValue) {
                $_REQUEST[$bKey] = $bValue;
            }
          }

          // check for Authorization 
          if(isset($headers['authorization']) && $headers['authorization'] != GlobalAuthKey){
            echo json_encode(array('Status' => 'Please Enter Correct Authorization Key ')); 
            exit;
          }
          self::loginAction();
        
          exit;
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

      if($_SERVER['REQUEST_METHOD'] == 'GET')
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
              if(strpos($url[0], 'bpu/public/') !== false)
              {
                $url =  explode('bpu/public/', $url[0]);
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
              if(strpos($url[0], 'bpu/public/') !== false)
              {
                $url =  explode('bpu/public/', $url[0]);
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
         
          echo json_encode(array('Image' => $imageData[0]->uploadImage));
         
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
            $res = Self::generateTableAction();
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
                 
                  $res = Self::generateTableAction();

                  $tempArrr = [];
                
                  if($res){

                    $tempArrr =   $res['data'];
                    $cntArr = count($tempArrr);
                    
                    if(isset($tempArrr[0]) && isset($_REQUEST['ProductNo'])){
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
                                          $_SESSION['maxStockStatus'] = true;
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
          $res['data'] = $tempArrr;
          }

      	}else{

              $tempArrrFin = [];
              $loopCheck = 1;
              while($loopCheck){
                  $_REQUEST['placeholderId'] = $APIData[0]['Tables'];
                  $_REQUEST['APIData'] = $APIData[0];
                  $_REQUEST['AuthKey']= $auth;
                 
                  $res = Self::generateTableAction();

                  $tempArrr = [];
                
                  if($res){

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
                                          $_SESSION['maxStockStatus'] = true;
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
                 
                  $res = Self::generateTableAction();
                  
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

    public function generateTableAction()
    {

        $getCompanyDetails = Companies::getCompaniesDetails($_SESSION['UserID']);

        $placeholderId = (isset($_REQUEST['placeholderId'])) ? $_REQUEST['placeholderId'] : "";
        $pHolderId = (isset($_REQUEST['pholderid'])) ? $_REQUEST['pholderid'] : "";
        $userPagePlaceholder = (isset($_REQUEST['id'])) ? $_REQUEST['id'] : "";
        $pholderId = (isset($_REQUEST['pholderid'])) ? $_REQUEST['pholderid'] : "";
        $columnName = (isset($_REQUEST['columnName'])) ? $_REQUEST['columnName'] : "";
        $columnValue = (isset($_REQUEST['columnValue'])) ? $_REQUEST['columnValue'] : "";
        $customerNo = (isset($_REQUEST['CustomerNo'])) ? $_REQUEST['CustomerNo'] : "";
        $CustomerNo = (isset($_REQUEST['CustomerNo'])) ? $_REQUEST['CustomerNo'] : "";
        $ProductNo = (isset($_REQUEST['ProductNo'])) ? $_REQUEST['ProductNo'] : "";
        $ChildProductNo = (isset($_REQUEST['ChildProductNo'])) ? $_REQUEST['ChildProductNo'] : "";

        $OrderNo = (isset($_REQUEST['OrderNo'])) ? $_REQUEST['OrderNo'] : "";
        $SupplierNo = (isset($_REQUEST['SupplierNo'])) ? $_REQUEST['SupplierNo'] : "";   
        $CountryId = (isset($_REQUEST['CountryId'])) ? $_REQUEST['CountryId'] : ""; 
        $Period = (isset($_REQUEST['Period'])) ? $_REQUEST['Period'] : ""; 
        $CategoryId = (isset($_REQUEST['CategoryId'])) ? $_REQUEST['CategoryId'] : "";  
        $SellerId = (isset($_REQUEST['SellerId'])) ? $_REQUEST['SellerId'] : "";  
        $Category = (isset($_REQUEST['Category'])) ? $_REQUEST['Category'] : ""; 
        $ProductGroup1 = (isset($_REQUEST['ProductGroup1'])) ? $_REQUEST['ProductGroup1'] : "";  
        $ProductGroup2 = (isset($_REQUEST['ProductGroup2'])) ? $_REQUEST['ProductGroup2'] : "";  
        $ProductGroup3 = (isset($_REQUEST['ProductGroup3'])) ? $_REQUEST['ProductGroup3'] : "";  
        $ProductGroup4 = (isset($_REQUEST['ProductGroup4'])) ? $_REQUEST['ProductGroup4'] : "";  
        $WarehouseNo = (isset($_REQUEST['WarehouseNo'])) ? $_REQUEST['WarehouseNo'] : "";  
        $Purchaser = (isset($_REQUEST['Purchaser'])) ? $_REQUEST['Purchaser'] : "";  
        $Year = (isset($_REQUEST['Year'])) ? $_REQUEST['Year'] : "";  
        $DeliverCustomerNo = (isset($_REQUEST['DeliverCustomerNo'])) ? $_REQUEST['DeliverCustomerNo'] : "";
        $InvoiceCustomerNo = (isset($_REQUEST['InvoiceCustomerNo'])) ? $_REQUEST['InvoiceCustomerNo'] : "";
        $CompanyId = (isset($_REQUEST['CompanyId'])) ? $_REQUEST['CompanyId'] : "";
        $ProjectId = (isset($_REQUEST['ProjectId'])) ? $_REQUEST['ProjectId'] : "";
        $Focus = (isset($_REQUEST['Focus'])) ? $_REQUEST['Focus'] : "";
        $CurrencyId = (isset($_REQUEST['CurrencyId'])) ? $_REQUEST['CurrencyId'] : "";
        $PriceListId = (isset($_REQUEST['PriceListId'])) ? $_REQUEST['PriceListId'] : "";
        $getDatatableDetails = "";
        $searchValue = (isset($_REQUEST['searchvalue'])) ? json_decode($_REQUEST['searchvalue']) : "";
        $searchValueCount = '';
        if($searchValue) {
            $searchValue = (array)$searchValue[0];
            $searchValueCount = count($searchValue);
        }

        if (!empty($pholderId)) {
            $getDatatableDetails = Page::getDatasourceTableDetails($pholderId);
        }

        $getPlaceholderDetails1= Page::getDatasourceTableDetails($placeholderId);
        $getTableActionDetails = '';
        $tableActions = array();
     	$getTableActionIds =  $_REQUEST['APIData']['PlaceholderActionIds'];
        
        if (!empty($getTableActionIds) &&  !empty($_REQUEST['APIData']['showFocusPage'])) {

            if ($getTableActionIds) {
                //$getTableActionIds = explode(",", $getTableActionIds);
                $tableActionDetails = Page::getTableActionDetailsByIdIN($getTableActionIds);

                if ($tableActionDetails) {
                    foreach ($tableActionDetails as $getAllTableActions) {
                        $actationTableColumn = array('RowNo');
                        $columnRowNo = '';
                        if(isset($getAllTableActions['Columns'])) {
                            $columnRowNo = explode(",", $getAllTableActions['Columns']);
                            foreach($columnRowNo as $value) {
                                $value = trim($value);
                                if($value == 'RowNo'){
                                    $columnRowNo = $value;
                                }
                            }
                        }
                        $tableActions[$getAllTableActions['TableParameterColumn']][] = $getAllTableActions;
                        if(isset($columnRowNo) && $columnRowNo == 'RowNo') {
                            $tableActions[$columnRowNo][] = $getAllTableActions;
                            $tableActions[$columnRowNo][0]['TableParameterColumn'] = $columnRowNo;
                        }
                    }
                }
            }
        }
        
           
     $joinTbaleRes = array();   
        
        if(count($getPlaceholderDetails1) >= 1)
            {
            foreach ($getPlaceholderDetails1 as $ke => $valueee) {
                $newResArr1 = array();
                $requestUrl = '';
                $requestType = '';
                $requestBody = '';
                $requestGAPI = '';
                $accessTokenGAPI = '';
                $accessRefreshTokenGAPI = '';
                $displayDetailButton = false;
                $showMapButton = false;
                $customSumData = '';
                $customSumDataArr = array();
                $explodeColumns = '';
                $columnsList = array();
                $getPlaceholderDetails[0] = $valueee;    
              
                if ($getPlaceholderDetails) {
                    $getSourceType = $getPlaceholderDetails[0]['SourceAddress'];
                    if(isset($_SESSION['DBParam'])) {
                        $arr = explode('|', $_SESSION['DBParam'] );
                        if(!empty($arr[0])){
                            foreach ($arr as $v) {
                                $val = explode(':', $v);
                                $str = explode(',', $val[1]);
                                $dataVal = '';
                                if(count($str) > 1){
                                    foreach ($str as $ke => $va) {
                                        $dataVal = $dataVal .  $va . ",";
                                    }
                                }else{
                                     $dataVal = $str[0];
                                }

                                $dataVal = rtrim($dataVal,',');
                                $getSourceType = str_replace("'(".$val[0].")'", $dataVal, $getSourceType);
                                $getSourceType = str_replace("(".$val[0].")", $dataVal, $getSourceType);
                                
                            }
                        }
                    }

                    if(isset($CustomerNo)) {
                        $getSourceType = str_replace("(CustomerNo)", $CustomerNo, $getSourceType);
                    }
                    if(isset($ProductNo)) {
                        $getSourceType = str_replace("(ProductNo)", $ProductNo, $getSourceType);
                    }
                    if(isset($ChildProductNo)) {
                        $ChildProductNo = str_replace("and", "&", $ChildProductNo);
                        $getSourceType = str_replace("(ChildProductNo)", $ChildProductNo, $getSourceType);
                    }
                    
                    if(isset($OrderNo)) {
                        $getSourceType = str_replace("(OrderNo)", $OrderNo, $getSourceType);
                    }
                    if(isset($SupplierNo)) {
                        $getSourceType = str_replace("(SupplierNo)", $SupplierNo, $getSourceType);
                    }
                     if(isset($CountryId)) {
                        $getSourceType = str_replace("(CountryId)", $CountryId, $getSourceType);
                    }
                     if(isset($Period)) {
                        $getSourceType = str_replace("(Period)", $Period, $getSourceType);
                    }
                    if(isset($CategoryId)) {
                        $getSourceType = str_replace("(CategoryId)", $CategoryId, $getSourceType);
                    }
                    if(isset($SellerId)) {
                        $getSourceType = str_replace("(SellerId)", $SellerId, $getSourceType);
                    }
                    if(isset($Category)) {
                        $getSourceType = str_replace("(Category)", $Category, $getSourceType);
                    }
                    if(isset($ProductGroup1)) {
                        $getSourceType = str_replace("(ProductGroup1)", $ProductGroup1, $getSourceType);
                    }
                    if(isset($ProductGroup2)) {
                        $getSourceType = str_replace("(ProductGroup2)", $ProductGroup2, $getSourceType);
                    }
                    if(isset($ProductGroup3)) {
                        $getSourceType = str_replace("(ProductGroup3)", $ProductGroup3, $getSourceType);
                    }
                    if(isset($ProductGroup4)) {
                        $getSourceType = str_replace("(ProductGroup4)", $ProductGroup4, $getSourceType);
                    }
                    if(isset($WarehouseNo)) {
                        $getSourceType = str_replace("(WarehouseNo)", $WarehouseNo, $getSourceType);
                    }
                    if(isset($Purchaser)) {
                        $getSourceType = str_replace("(Purchaser)", $Purchaser, $getSourceType);
                    }
                    if(isset($Year)) {
                        $getSourceType = str_replace("(Year)", $Year, $getSourceType);
                    }
                    if(isset($DeliverCustomerNo)) {
                        $getSourceType = str_replace("(DeliverCustomerNo)", $DeliverCustomerNo, $getSourceType);
                    }
                    if(isset($InvoiceCustomerNo)) {
                        $getSourceType = str_replace("(InvoiceCustomerNo)", $InvoiceCustomerNo, $getSourceType);
                    }
                    if(isset($CompanyId)) {
                        $getSourceType = str_replace("(CompanyId)", $CompanyId, $getSourceType);
                    }
                    if(isset($ProjectId)) {
                        $getSourceType = str_replace("(ProjectId)", $ProjectId, $getSourceType);
                    }
                    if(isset($Focus)) {
                        $getSourceType = str_replace("(Focus)", $Focus, $getSourceType);
                    }
                    if(isset($CurrencyId)) {
                        $getSourceType = str_replace("(CurrencyId)", $CurrencyId, $getSourceType);
                    }
                    if(isset($PriceListId)) {
                        $getSourceType = str_replace("(PriceListId)", $PriceListId, $getSourceType);
                    }

                    if(isset($_REQUEST))
                    {
                      foreach ($_REQUEST as $reqKey => $reqValue) {
                          if(strpos($getSourceType, "(".$reqKey.")") !== false)
                          {
                            $getSourceType = str_replace("(".$reqKey.")", $reqValue, $getSourceType);

                          }
                      }
                    }
                                   

                    if($getPlaceholderDetails[0]['ApiType'] == '2')
                    {
                        $getColumnsList = $getPlaceholderDetails[0]['Columns'];
                    }else{
                        $getColumnsList = $getPlaceholderDetails[0]['tableColumns'];
                    
                    } 
                    
                    
                   
                    $newExplodeColumns = array();
                    if (isset($getColumnsList)) {
                        $explodeColumns = explode(',', $getColumnsList);
                        $explodeColumns = array_combine($explodeColumns,$explodeColumns);
                        $columnsList = explode(',', $getColumnsList);
                        $getColumnsProperties = $getPlaceholderDetails[0]['ColumnsProperties'];

                        if (isset($getColumnsProperties)) {
                            $getColumnsProperties = json_decode($getColumnsProperties, true);

                            $getColumnsProperties = array_replace(array_flip($explodeColumns), $getColumnsProperties);
                            unset($explodeColumns);
                            foreach($getColumnsProperties as $key => $value) {
                                if(in_array($key, $columnsList)) {
                                    $explodeColumns[$key] = $value;
                                }
                            }
                        }
                    }
                  
                    $sumColumnLable = $getPlaceholderDetails[0]['SumColumnLable'];
                    $keyColumnName = $getPlaceholderDetails[0]['KeyColumn'];
                    $customSumFormula = $getPlaceholderDetails[0]['CustomSumFormula'];

                    //print_r($newExplodeColumns); exit;
                    $companyAddress = $getCompanyDetails[0]['CompanyGISKey'];
                    $companyToken = $getCompanyDetails[0]['CompanyGISToken'];
                    $requestType = $getPlaceholderDetails[0]['RequestType'];
                    $requestBody = $getPlaceholderDetails[0]['Body'];
                    $requestGAPI = $getPlaceholderDetails[0]['SourceAddress'];
                    $accessTokenGAPI =  $getCompanyDetails[0]['GoogleAccessToken'];
                    $accessRefreshTokenGAPI =  $getCompanyDetails[0]['GoogleAccessRefreshToken'];
                    if (strpos($requestBody, strtolower('(nowtime)')) !== false) {
                        if(isset($_SESSION['NowTime'])){
                            $requestBody = str_replace("(nowtime)", $_SESSION['NowTime'], $requestBody);
                        }
                    }
                    $getPlaceholderColumn = trim($getPlaceholderDetails[0]['Placeholder']);

                    if ($getPlaceholderColumn) {
                        $getRequestData = (isset($_REQUEST[$getPlaceholderColumn])) ? $_REQUEST[$getPlaceholderColumn] : "";

                        if ($getRequestData) {
                            $requestBody = str_replace("(" . $getPlaceholderColumn . ")", $getRequestData, $requestBody);
                        }
                    }

                    $sumType = $getPlaceholderDetails[0]['SumType'];
                    $requestUrl = str_replace("(address)", $companyAddress, $getSourceType);
                    $requestUrl = str_replace("(token)", $companyToken, $requestUrl);
                    $filterion = false;

                    if (strpos($requestUrl, strtolower('(nowtime)')) !== false) {
                        if(isset($_SESSION['NowTime'])){
                            $requestUrl = str_replace("(nowtime)", $_SESSION['NowTime'], $requestUrl);
                        }
                    }


                    if ($getDatatableDetails && $getPlaceholderDetails) {
                        if ($getDatatableDetails[0]['DataSourceId'] == $getPlaceholderDetails[0]['DataSourceId']) {
                            if (!empty($searchValue)) {
                                $keyValue = key($searchValue);
                                if(in_array($keyValue, $columnsList)) {
                                    $filterion = true;
                                }
                            }
                        }
                    }
                }
              
                if ($requestType == 4) {
                    if($accessTokenGAPI){
                        $flagGapi = 1;
                         
                        while ($flagGapi) {
                        
                            $ch = curl_init();
                            $header = array();

                            $header[] = 'Content-type: application/json';
                            $header[] = 'Authorization:'.$accessTokenGAPI;
                            curl_setopt($ch, CURLOPT_URL, $requestGAPI);
                            curl_setopt($ch, CURLOPT_POSTFIELDS, $requestBody);
                            curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
                            
                            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
                            $results = curl_exec($ch);
                          
                            curl_close($ch);
                            
                            if ($results) {
                                $decodedResults = json_decode($results, true);
                            }
                           
                            if(isset($decodedResults['error']) && ($decodedResults['error']['code'] == '401'))
                            {
                                $ch = curl_init();
                               
                                $fileContent = file_get_contents(baseUrl . 'client_secret.json');

                                $fileContent = json_decode($fileContent); 
                                
                                $url = "https://accounts.google.com/o/oauth2/token";
                                curl_setopt($ch, CURLOPT_URL,$url);
                                curl_setopt($ch, CURLOPT_POST, 1);
                                curl_setopt($ch, CURLOPT_POSTFIELDS,
                                            "client_id=".$fileContent->web->client_id."&client_secret=".$fileContent->web->client_secret."&grant_type=refresh_token&refresh_token=".$accessRefreshTokenGAPI);
                                curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
                                $results = curl_exec($ch);
                                $results =  json_decode($results, true);

                                $resData =  array('companyId' => $getCompanyDetails[0]['CompanyID'] , 'accessToken' => $results, 'type' => 'Update'); 
                                
                                Companies::updateCompanyForGoogleApi($resData); 
                                curl_close($ch);
                                
                            }else
                            {
                                $flagGapi = 0;
                                $decodedResults = $decodedResults['reports'][0]['data']['rows'];
                                $mainArrRes= array();
                                
                                foreach ($decodedResults as $decodedResultsKey => $decodedResultsValue) {
                                     $resultss = array();
                                     if($decodedResultsValue['dimensions'])
                                     {
                                        foreach ($decodedResultsValue['dimensions'] as $dimensionKey => $dimensionvalue) {
                                                array_push($resultss,$dimensionvalue );
                                            }
                                     }
                                    
                                     if($decodedResultsValue['metrics'])
                                     {
                                        foreach ($decodedResultsValue['metrics'][0]['values'] as $metricsKey => $metricsvalue) {
                                                array_push($resultss,$metricsvalue );
                                            }
                                     }
                                      
                                     $mainArrRes[] =$resultss;
                                }
                                
                            }

                        }
                        $tableData['data'] =$mainArrRes;
                    }
                } else if ($requestType == 3) {
                    $txt_ =  "";
                    $class_ = "";
                    $separator= "%";
                    
                    // That function is the main issue So far what i found 
                    if(strpos($getSourceType, 'UserHistory'))
                    {
                        $userCompanyDbName = 'BP_Admin10';
                    }
                    else{
                        $userCompanyDbName = $getCompanyDetails[0]['CompanyBABCDb'];
                    }

                    if( $userCompanyDbName == 'BABC_Megalodon')
                    {
                        $maxLimit = 30000;
                        $offSet = 0;
                        $tempLimt = 15000;
                        $allData = array();
                        $oldSourceType = $getSourceType;
                       
                        if( strpos($getSourceType , 'top(') !== false ){
                            $allData = User::executeQuery($getSourceType, $userCompanyDbName);
                            
                        }else{
                            while($offSet <= $maxLimit)
                            {

                                $tempallData = array();
                                $getSourceType = $getSourceType . ' OFFSET '.$offSet.' ROWS FETCH NEXT '. $tempLimt .' ROWS ONLY;' ;
                               
                                $tempallData = User::executeQuery($getSourceType, $userCompanyDbName);
                                
                                if(!empty($tempallData))
                                {
                                    $allData = array_merge($allData , $tempallData);
                                    $offSet = $offSet + $tempLimt +1;
                                    $getSourceType = $oldSourceType;

                                }else{
                                    break;
                                }
                            

                            }
                        }
                     
                    }else
                    {
                        $allData = User::executeQuery($getSourceType, $userCompanyDbName);
                    }                         
                    $tableData = array();

                    if ($sumType == 1) {
                        $columnSumResults = 0;
                        $columnSumData = array();
                        $singleColumn = $customSumFormula;
                        foreach ($allData as $eachRecord) {

                            $outputData = (isset($eachRecord[$singleColumn])) ? $eachRecord[$singleColumn] : "";

                            if ($outputData > 0) {
                                try {
                                    $outputData = (int)$outputData;
                                    $outputData = round($outputData);
                                    $columnSumData[] = $outputData;
                                } catch (Exception $exc) {
                                }

                            }
                        }
                        if ($columnSumData) {
                            $columnSumResults = array_sum($columnSumData);
                        }
                    }
                   
                    //Actions Button 1 - Artikelkategorier
                            if ($tableActions) {
                                $actionButtons = "<div class='btn-group pull-right'>";
                                $actionButtons .= "<a class='btn deepPink-bgcolor  btn-outline dropdown-toggle' data-toggle='dropdown'>Actions1";
                                $actionButtons .= "<i class='fa fa-angle-down'></i></a>";

                                $actionButtons .= "<ul class='dropdown-menu pull-right'>";
                                $pageTextValue = array();
                                foreach ($tableActions as $key => $eachAction) {
                                 if(isset($key) && !in_array($key,$actationTableColumn)) {
                                            foreach ($eachAction as  $k => $actionDetails) {
                                                //$actionDetails = $eachAction[0];
                                                $externalUrl = $actionDetails['ExternalUrl'];
                                                if (!empty($externalUrl)) {
                                                    $buttonAction = $externalUrl;
                                                } 
                                                else {
                                                    if($_SESSION['UserID'] && $actionDetails['PageTargetId']) {
                                                        $pageText = Page::getPageText($actionDetails['PageTargetId'], $_SESSION['UserID']);

                                                        if($pageText) {
                                                            $pageTextValue[$key][$k] = $pageText[0]['PageMenuText'];
                                                        }
                                                    }
                                                }
                                        }

                                }
                               }
                        
                            }
                    foreach ($allData as $eachRecord) {
                        $matchedData = false;
                        $matchedValueCount = 0;

                        $txt_ =  "";
                        $class_ = "";
                        $separator= "%";
                        
                        $keyColumnValue = '';
                        $detailKeyColumnValue = '';
                        $columnData = '';
                        $customerAction = '';
                        $customSumFormula = (isset($getPlaceholderDetails[0]['CustomSumFormula'])) ? $getPlaceholderDetails[0]['CustomSumFormula'] : "";

                        if (isset($getColumnsList)) {
                            $dataToTable = [];
                            $filterData = false;

                            $showFields = $_REQUEST['APIData']['Fields'];
                             
                            if(!empty($showFields))
                            {
                            	$showFields = explode(',',$_REQUEST['APIData']['Fields']);
                             
                            	$temp = [];
                            	foreach ($showFields as $k => $v) {
                            		$v = trim($v);
                            		if(array_key_exists($v, $explodeColumns))
                            		{
                            			$temp[$v] = $explodeColumns[$v];
                            		}
                            	}

                            	if($_REQUEST['APIData']['showFocusPage'])
						      	{
						      		$var=trim($_REQUEST['APIData']['parameterFocusPage']);
						      		if($var){
						      			$temp[$var] = $explodeColumns[$var];
						      		}
						      	}
				                                            	
                            	if(!empty($temp)){
                                	unset($explodeColumns);
                                	$explodeColumns = $temp;
                            	}
                            }

                            foreach ($explodeColumns as $singleColumn => $singleColumnValue) {
                                if($getPlaceholderDetails[0]['TableType'] == 3)
                                {
                                    $singleColumnVal = $singleColumn;
                                    if(strpos($singleColumn, $getPlaceholderDetails[0]['Name']) !== false){
                                        $singleColumn = explode('-', $singleColumn);
                                        $singleColumn = $singleColumn[1];
                                        
                                    if (isset($getPlaceholderDetails[0]['ColumnsProperties'])) {
                                        $getColumnsProperties = json_decode($getPlaceholderDetails[0]['ColumnsProperties'], true);
                                        $singleColumnValue = isset($getColumnsProperties[$singleColumn])?$getColumnsProperties[$singleColumn]:$singleColumn;
                                    }

                                    }
                                }
                                
                                $columnData = '';
                                if ($keyColumnName == $singleColumn) {
                                    $keyColumnValue = $eachRecord[$singleColumn];
                                }

                                $singleColumn = trim($singleColumn);
                                if(isset($eachRecord[$singleColumn]))
                                {
                                    $columnData = $eachRecord[$singleColumn];
                                }
                                

                                if($getPlaceholderDetails[0]['TableType'] != 3)
                                {
                                    if (isset($customSumFormula) && !empty($customSumFormula) && array_key_exists($singleColumn, $eachRecord))
                                    {

                                        $replaceColumn = "(" . $singleColumn . ")";
                                        $sumColumnData = str_replace(array(',', ' '), '', $columnData);
                                        $customSumData = str_replace($replaceColumn, $sumColumnData, $customSumFormula);
                                        $customSumFormula = $customSumData;
                                    }
                                }
                                
                                if($getPlaceholderDetails[0]['TableType'] != 3)
                                {
                                    $columnData = DataTableHelper::ColumnProperties($columnData,$singleColumnValue);
                                    $columnData = DataTableHelper::columnDataRound($columnData,$singleColumnValue);
                                }
                                if (!empty($searchValue) && isset($searchValue[$singleColumn])) {
                                    $columnDataValue = strtolower($columnData);
                                    if(isset($searchValue[$singleColumn])) {
                                        $searchValueComumn = explode('|',$searchValue[$singleColumn]);
                                        $searchValueComumnCount = count($searchValueComumn);
                                        if($searchValueComumnCount > 1) {
                                            for($i = 0; $i < $searchValueComumnCount; $i++ ) {
                                                if (strpos($columnDataValue, strtolower($searchValueComumn[$i])) !== false) {
                                                    $matchedValueCount++;
                                                }
                                            }
                                        } else {
                                            if (strpos($columnDataValue, strtolower($searchValueComumn[0])) !== false) {
                                                $matchedValueCount++;
                                            }
                                        }
                                    }
                                    if($getPlaceholderDetails[0]['TableType'] == 3)
                                    {
                                        $dataToTable[$singleColumnVal] = $columnData;
                                    }
                                    else{
                                       
                                        $dataToTable[$singleColumn] = $columnData;
                                    }
                                    

                                } else {
                                    if($getPlaceholderDetails[0]['TableType'] == 3)
                                    {
                                        $dataToTable[$singleColumnVal] = $columnData;
                                    }
                                    else{
                                        $dataToTable[$singleColumn] = $columnData;
                                    }
                                   
                                }

                                if (array_key_exists($singleColumn, $tableActions)) {
                                    foreach ($tableActions[$singleColumn] as $key => $value) {
                                        $tableActions[$singleColumn][$key]['TableParameterColumnValue'] = $columnData;
                                    }
                                }

                            }
                        
                            // for button       
                            
                            if($tableActions){
                                foreach ($tableActions as $key => $eachAction) {
                                //$key = key($tableActions); 
                                if(isset($key) && !in_array($key,$actationTableColumn)) {
                                    foreach ($eachAction as $k => $actionDetails) {
                                    //$actionDetails = $eachAction[0];
                                    $tableParameterColumnValue = (isset($actionDetails['TableParameterColumnValue'])) ? $actionDetails['TableParameterColumnValue'] : "";
                                    $textValue = (isset($pageTextValue[$key][$k])?$pageTextValue[$key][$k]:'');
                                    //$buttonAction = baseUrl . 'page?id=' . $actionDetails['PageTargetId'] . '&page_text='. $textValue .'&columnName=' . $actionDetails['TableParameterColumn'] . '&columnValue='.$tableParameterColumnValue;
                                    
                                    $getPagePlaceholders = Page::getPagePlaceholders($actionDetails['PageTargetId'], $_SESSION['UserID'], $pageText[0]['PageMenuText']);
                                
                                if ($actionDetails['updateDataSource'] == 1) {
                                   
                                    $parameterArray = array('orderNoCol'=>$actionDetails['TableParameterColumn'],'orderNoValue'=> $tableParameterColumnValue,'baseUrl' => baseUrl, 'pageTextValue' => rawurlencode ($textValue), 'dataSourceId' => $actionDetails['DataSourceId'],'pageTargetId' => $actionDetails['PageTargetId']);


                                    $parameterArray = json_encode($parameterArray, JSON_UNESCAPED_SLASHES);
                                    if ($actionDetails['PredefinedUpdate'] == 1) {
                                        $buttonAction = 'getUpdatePredefined('. $parameterArray .')';
                                        $txt_ .=  $actionDetails['ActionButtonText'].$separator;
                                        
                                        $class_ .= str_replace("http://","",$buttonAction).$separator;
                                       
                                    } 
                                    else if ($actionDetails['DataSourceCall'] == 1) {
                                        $buttonAction = 'getUpdateDataSourceCall('. $parameterArray .')';
                                        $txt_ .=  $actionDetails['ActionButtonText'].$separator;
                                         
                                        $class_ .= str_replace("http://","",$buttonAction).$separator;
                                    } 
                                    else {

                                        $buttonAction = baseUrl . 'getUpdateForm?dataSourceId=' . $actionDetails['DataSourceId'] .   '&pageId=' . $actionDetails['PageTargetId']  . '&columnName=' . $actionDetails['TableParameterColumn'] . '&columnValue=' . $tableParameterColumnValue . '&page_text='. rawurlencode ($textValue) . '&tableID=' . $actionDetails['TableTemplateId'];

                                        $txt_ .=  $actionDetails['ActionButtonText'].$separator;
                                        $class_ .= str_replace("http://","",$buttonAction).$separator;
                                    }
                                } 
                                else {
                                    if ($actionDetails['IsPdf'] == 1) {
                                       
                                        $buttonAction = baseUrl . 'downloadPdf?dataSourceId=' . $actionDetails['DataSourceId'] . '&InvoiceNo=' . $tableParameterColumnValue;
                                        $txt_ .= $actionDetails['ActionButtonText'].$separator;
                                        $class_ .= str_replace("http://","",$buttonAction).$separator;
                                    } 
                                    else {

                                    	foreach ($getPagePlaceholders as $getPagePlaceholdersKey => $getPagePlaceholdersValue) {
                                    		
                                    		if($getPagePlaceholdersValue['PlaceholderType'] == 2)
                                    		{
                                    			$dataToTable['FocusPageURL'.$getPagePlaceholdersValue['PlaceholderId']] = baseUrl.$_REQUEST['APIData']['APIUrl'].'/focusPage?'.$actionDetails['TableParameterColumn']. '='.$tableParameterColumnValue.'&Tableid='.$getPagePlaceholdersValue['PlaceholderId'].'&AuthKey='.$_REQUEST['AuthKey'] ;
                                    		}
                                    		
                                    	}

                                        // $txt_ .= $actionDetails['ActionButtonText'].$separator;
                               
                                        // $class_ .= str_replace("http://","",$buttonAction).$separator;
                                    }
                                }

                                }
                            }
                                
                            }
                        }
                     
                            $sumColumnLable = trim($sumColumnLable);
                          
                            if(isset($sumColumnLable) && !empty($sumColumnLable) &&  $sumColumnLable == 'City')
                            {
                                 $dataToTable[] = 'ST';
                            }
                            else{
                                if (isset($sumColumnLable) && !empty($sumColumnLable)) {
                                    if (isset($explodeColumns)) {

                                        if (!in_array($sumColumnLable, $explodeColumns)) {
                                            if (!empty($customSumData)) {
                                                if ($sumType == 1) {

                                                    if ($columnSumResults && is_numeric($columnSumResults)) {
                                                        $columnSumResults = round($columnSumResults);
                                                    }

                                                    if (!empty($searchValue) && !empty($searchValueArray)) {
                                                        $columnSumResultsValue = strtolower($columnSumResults);

                                                          if (!empty($columnSumResultsValue)) {
                                                            foreach ($searchValueArray as $searchValue) {
                                                                if(isset($searchValue) && !empty($searchValue)) {
                                                                    if (strpos($columnSumResultsValue, $searchValue) !== false) {
                                                                        $matchedData = true;
                                                                        $matchedValueCount++;
                                                                    }
                                                                }
                                                            }
                                                        }

                                                        if(!empty($getColumnsProperties[$sumColumnLable])){
                                                            $columnSumResults = DataTableHelper::ColumnProperties($columnSumResults,$getColumnsProperties[$sumColumnLable]);
                                                        }
                                                        $dataToTable[] = $columnSumResults;

                                                    } else {
                                                        if(!empty($getColumnsProperties[$sumColumnLable])){
                                                            $columnSumResults = DataTableHelper::ColumnProperties($columnSumResults,$getColumnsProperties[$sumColumnLable]);
                                                        }
                                                        $dataToTable[] = $columnSumResults;
                                                    }

                                                } 
                                                else if ($sumType == 2) {
                                                    $csData = explode(',' , $customSumData);
                                                    $sumLabel = explode(',' , $sumColumnLable); 
                                                    foreach ($csData as $key => $value) {
                                                        if (strpos($value, '--') === false) {
                                                            
                                                            try{
                                                                @eval('$result = (' . @$value . ');');
                                                                //eval("\$result = $customSumData;");
                                                            
                                                            }
                                                            catch(Exception $e){
                                                                $result = 0;
                                                            }
                                                            if (is_nan($result)) {
                                                                $result = 0;
                                                            } else if(is_infinite($result)) {
                                                                $result = 100;
                                                            }
                                                            if (!empty($searchValue) && !empty($searchValueArray)) {
                                                                $resultValue = strtolower($result);

                                                                if (!empty($resultValue)) {
                                                                    foreach ($searchValueArray as $searchValue) {
                                                                        if(isset($searchValue) && !empty($searchValue)) {
                                                                            if (strpos($resultValue, $searchValue) !== false) {
                                                                                $matchedData = true;
                                                                                $matchedValueCount++;
                                                                            }
                                                                        }
                                                                    }
                                                                }

                                                                if(!empty($getColumnsProperties[$sumLabel[$key]])){
                                                                    $result = DataTableHelper::ColumnProperties($result,$getColumnsProperties[$sumLabel[$key]]);
                                                                }
                                                                $dataToTable[] = $result;

                                                            } else {
                                                                $sumLabelkey = trim($sumLabel[$key]);
                                                                if(!empty($getColumnsProperties[$sumLabelkey])){
                                                                    $result = DataTableHelper::ColumnProperties($result,$getColumnsProperties[$sumLabelkey]);
                                                                }
                                                                
                                                                $dataToTable[] = $result;
                                                            }
                                                        }
                                                        else{

                                                           $value = str_replace('--', '+', $value);
                                                           try{
                                                                @eval('$result = (' . @$value . ');');
                                                                //eval("\$result = $customSumData;");
                                                            }
                                                            catch(Exception $e){
                                                               $result = 0;
                                                            }
                                                            if (is_nan($result)) {
                                                                $result = 0;
                                                            } else if(is_infinite($result)) {
                                                                $result = 100;
                                                            }
                                                            if (!empty($searchValue) && !empty($searchValueArray)) {
                                                                $resultValue = strtolower($result);

                                                                if (!empty($resultValue)) {
                                                                    foreach ($searchValueArray as $searchValue) {
                                                                        if(isset($searchValue) && !empty($searchValue)) {
                                                                            if (strpos($resultValue, $searchValue) !== false) {
                                                                                $matchedData = true;
                                                                                $matchedValueCount++;
                                                                            }
                                                                        }
                                                                    }
                                                                }

                                                                if(!empty($getColumnsProperties[$sumLabel[$key]])){
                                                                    $result = DataTableHelper::ColumnProperties($result,$getColumnsProperties[$sumLabel[$key]]);
                                                                }

                                                                $dataToTable[] = $result;

                                                            } else {
                                                                if(!empty($getColumnsProperties[$sumLabel[$key]])){
                                                                    $result = DataTableHelper::ColumnProperties($result,$getColumnsProperties[$sumLabel[$key]]);
                                                                }
                                                                
                                                                $dataToTable[$singleColumn] = $result;
                                                            }

                                                        }
                                                    }
                                                }
                                            }
                                        }
                                    }

                                }
                            } // here ENd
                            
                            // if($tableActions){
                            //     $dataToTable[] = $txt_ ;
                            //     $dataToTable[] = $class_ ;
                            
                            // }
                            if($_REQUEST['APIData']['showFocusPage'])
					      	{
					      		if(isset($_REQUEST['APIData']['parameterFocusPage']) && !empty($_REQUEST['APIData']['parameterFocusPage'])){
						      		$var = explode('-', $_REQUEST['APIData']['parameterFocusPage']);
						      		$var = isset($var[1])?$var[1]:$var[0];
						      		
						      		$var12 = trim($_REQUEST['APIData']['parameterFocusPage']);
						      		
						      		$dataToTable['detailUrl'] = baseUrl.$_REQUEST['APIData']['APIUrl'].'/getSpecficDetail?'.trim($var).'='.$dataToTable[$var12];

						      		$dataToTable['detailUrl'] = $dataToTable['detailUrl'] .'&AuthKey='.$_REQUEST['AuthKey'];
					      		}
					      		//unset($value[$var12]);
					      	}

                            if ($filterion) {

                                if($searchValueCount == $matchedValueCount) {
                                    $tableData['data'][] = $dataToTable;
                                }
                            } else {
                                $tableData['data'][] = $dataToTable;
                            }
                        }
                       
                    }
                   
                    if($getPlaceholderDetails1[0]['TableType'] == 3)
                    {
                        $joinTbaleRes[$getPlaceholderDetails[0]['ID']] = $tableData;
                    }
                  
                } 
                else {

                   
                    $tableData['data'] = array();
                    $invoiceNo = '';
                    if ($requestUrl) {
                        
                        // console.info('URL: ' + #)
                        //echo 'test change for new branch
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
                      
                        
                        if ($results) {
                            $decodedResults = json_decode($results, true);
                            $apiData = $decodedResults;

                            if ($decodedResults) {
                                foreach ($this->_arrayList as $key) {
                                    if (isset($decodedResults[$key])) {
                                        $apiData = $decodedResults[$key];
                                        break;
                                    }
                                }
                            }
                           
                            if ($apiData) {
                                if ($sumType == 1) {
                                    $columnSumResults = 0;
                                    $columnSumData = array();
                                    $singleColumn = $customSumFormula;
                                    foreach ($apiData as $eachRecord) {
                                         
                                        $outputData = Self::searchArray($eachRecord, $singleColumn);
                                        if ($outputData > 0) {
                                            try {
                                                $outputData = (int)$outputData;
                                                $outputData = round($outputData);
                                                $columnSumData[] = $outputData;
                                            } catch (Exception $exc) {
                                            }

                                        }
                                       
                                    }
                                    
                                    if ($columnSumData) {
                                        $columnSumResults = array_sum($columnSumData);
                                    }
                                }   

                                if((!isset($apiData[0]) && is_array($apiData)))
                                {
                                    $tempArray =$apiData;
                                    $apiData = array();
                                    $apiData[0] = $tempArray;

                                }
                                if(!is_array($apiData) || (count($apiData) == 1 && count($apiData[0]) == 1))
                                {
                                    if($getPlaceholderDetails[0]['TableType'] == '3')
                                    {
                                         $tableData['data'][$singleColumn] = $apiData;
                                         $joinTbaleRes[$getPlaceholderDetails[0]['ID']] = $tableData;
                                    }else{
                                         $tableData['data'][] = $apiData;
                                    }
                                   
                                    
                                }else{
                                  

                                foreach ($apiData as $eachRecord) {
                                    
                                    if ($eachRecord) {
                                        $matchedData = false;
                                        $matchedValueCount = 0;
                                        //$searchValueCount = !empty($searchValueArray) ? count($searchValueArray) : '';
                                        $keyColumnValue = '';
                                        $detailColumnValue = '';
                                        $mapColumnValue = '';
                                        $columnData = '';
                                        $customSumDataArr = array();

                                       
                                        if (isset($getColumnsList)) {

                                            $dataToTable = [];

                                            $filterData = false;
                                            //$multipleFlag = false;
                                            $customSumFormula = (isset($getPlaceholderDetails[0]['CustomSumFormula'])) ? $getPlaceholderDetails[0]['CustomSumFormula'] : "";
                                           
                                           $showFields = $_REQUEST['APIData']['Fields'];
                                            
                                            if(!empty($showFields))
                                            {
                                            	$showFields = explode(',',$_REQUEST['APIData']['Fields']);
                                           
                                            	$temp = [];
                                            	foreach ($showFields as $k => $v) {
                                            		$v = trim($v);
                                                
                                                if($getPlaceholderDetails[0]['ApiType'])
                                                  {
                                                      
                                                      foreach ($explodeColumns as $colkey => $colvalue) {

                                                          if(isset($colvalue['Label'])){
                                                            if(($v == $colvalue['Label']))
                                                            {
                                                              
                                                              $temp[$colkey] = $colvalue;
                                                              break;
                                                            }}else
                                                            {

                                                              $var = explode('->', $colkey);
                                                              $var = end($var);

                                                              if($v == $var)
                                                              {
                                                                $temp[$colkey] = $colvalue;
                                                                break;
                                                              }
                                                            }

                                                      }
                                                  }else{
                                                    if(array_key_exists($v, $explodeColumns))
                                                      {
                                                        $temp[$v] = $explodeColumns[$v];
                                                      }
                                                  }
                                            		
                                            	}

                                            	if($_REQUEST['APIData']['showFocusPage'])
                  										      	{
                  										      		$var=trim($_REQUEST['APIData']['parameterFocusPage']);
                  										      		if($var){
                  										      			$temp[$var] = $explodeColumns[$var];
                  										      		}
                  										      	}
                  								                                            	
                                            	if(!empty($temp)){
	                                            	unset($explodeColumns);
	                                            	$explodeColumns = $temp;
                                            	}
                                            }
                                           
                                            if(count($apiData) == 1 && $getPlaceholderDetails[0]['ApiType'] == '2'){

                                                $newNames = array();
                                                if($getPlaceholderDetails[0]['ApiType'] == '2'){
                                                    $mainName = explode(',', $getPlaceholderDetails[0][7]);
                                                         
                                                    foreach ($mainName as $ki => $vi) {
                                                         
                                                        foreach ($explodeColumns as $singleColumn => $singleColumnValue) {
                                                          
                                                            $tempName = explode('->' , $singleColumn);
                                                          
                                                            if(in_array($mainName[$ki], $tempName))
                                                            {
                                                               if(in_array($mainName[$ki], $tempName))
                                                                {
                                                                    $newNames[$singleColumn] = $singleColumnValue;
                                                                    break;
                                                                    
                                                                }
                                                            
                                                            }
                                                       
                                                        }
                                                       
                                                    }
                                                }
                                                
                                                $explodeColumns = $newNames;
                                                foreach ($explodeColumns as $singleColumn => $singleColumnValue) {
                                                        if(strpos($singleColumn,'->') !== false)
                                                        {   

                                                            $m_name = explode('->', $singleColumn);
                                                            if(count($apiData) == 1 && count($m_name) > 1)
                                                                {
                                                                    $n = $m_name[0];
                                                                    if(array_key_exists($n, $eachRecord)){

                                                                        $eachRecords= $eachRecord[$n];
                                                                        break;
                                                                    }
                                                                }
                                                        }
                                                        
                                                    }
                                                $dataToTable1 = [];
                                              
                                                foreach ($eachRecords as $key => $val ) {
                                                    
                                                    $dataToTable= [];
                                                    
                                                    $val['Nodes'] = $val;

                                                    foreach ($explodeColumns as $singleColumn => $singleColumnValue) {
                                                       
                                                         if($getPlaceholderDetails[0]['TableType'] == 3)
                                                            {
                                                                $singleColumnVal = $singleColumn;
                                                                if(strpos($singleColumn, $getPlaceholderDetails[0]['Name']) !== false){
                                                                    $singleColumn = explode('-', $singleColumn);
                                                                    $singleColumn = $singleColumn[1];
                                                                    
                                                                if (isset($getPlaceholderDetails[0]['ColumnsProperties'])) {
                                                                    $getColumnsProperties = json_decode($getPlaceholderDetails[0]['ColumnsProperties'], true);
                                                                    $singleColumnValue = isset($getColumnsProperties[$singleColumn])?$getColumnsProperties[$singleColumn]:$singleColumn;
                                                                }

                                                                }
                                                            }
                                                        
                                                        if(strpos($singleColumn,'->') !== false)
                                                        {   

                                                            $flag1 = 0;
                                                            global $retVal , $flag1 ;
                                                            $GLOBALS['retVal'] = array();
                                                            
                                                            $GLOBALS['flag1'] = 0;
                                                            $m_name = explode('->', $singleColumn );
                                                            // if(count($m_name) == 2 && $m_name[0] == $n)
                                                            // {
                                                            //     $temp =$m_name[1];
                                                            //     $m_name = array();
                                                            //     $m_name[0] = $temp ;
                                                            // }
                                                            // print_r($m_name)
                                                            $columnData = Self::addforLoops($val , $m_name , 0 );
                                                            
                                                        }else{
                                                           
                                                            if ($singleColumn == $keyColumnName) {
                                                                $keyColumnValue = Self::searchArray($eachRecord, $singleColumn);
                                                                $columnData = $keyColumnValue;

                                                            }
                                                           
                                                            if ($singleColumn == 'CountryId') {
                                                                $columnValue = Self::searchArray($eachRecord, $singleColumn);
                                                                if ($columnValue == '' || $columnValue == 'SE') {
                                                                    $customerCountry = 'Sweden';
                                                                } else if ($columnValue == 'FI') {
                                                                    $customerCountry = 'Finland';
                                                                } elseif ($columnValue == 'Ge') {
                                                                    $customerCountry = 'Georgia';
                                                                } elseif ($columnValue == 'IT') {
                                                                    $customerCountry = 'Italy';
                                                                } elseif ($columnValue == 'TW') {
                                                                    $customerCountry = 'Taiwan';
                                                                } elseif ($columnValue == 'NO') {
                                                                    $customerCountry = 'Norway';
                                                                } elseif ($columnValue == 'DK') {
                                                                    $customerCountry = 'Denmark';
                                                                } else {
                                                                    $customerCountry = $columnValue;
                                                                }
                                                                $columnData = $customerCountry;
                                                            } else {
                                                                
                                                                $columnData = Self::searchArray($eachRecord, $singleColumn);

                                                            }

                                                            if ($singleColumn == 'InvoiceNo') {
                                                                $columnDataValue = Self::searchArray($eachRecord, $singleColumn);
                                                                $invoiceNo = $columnDataValue;
                                                            }
                                                        }
                                                        if($getPlaceholderDetails[0]['TableType'] != 3){
                                                            if (isset($customSumFormula) && !empty($customSumFormula) && array_key_exists($singleColumn, $eachRecord)) {

                                                               if(isset($singleColumnValue['Label']) && $singleColumn != $singleColumnValue['Label'])
                                                                {
                                                                        $replaceColumn = "(" . $singleColumnValue['Label'] . ")";
                                                                    
                                                                }else{
                                                                        $replaceColumn = "(" . $singleColumn . ")";
                                                                }

                                                                
                                                                if(is_array($columnData) || is_array($customSumFormula)){


                                                                    if(is_array($customSumFormula))
                                                                    {
                                                                         foreach ($columnData as $k => $v) {

                                                                            $sumColumnData = str_replace(array(',', ' '), '', $v);
                                                                            $customSumData = str_replace($replaceColumn, $sumColumnData, $customSumFormula[$k], $cont);
                                                                            
                                                                            if($cont)
                                                                            {   
                                                                                $customSumDataArr[$k] =  $customSumData;
                                                                                
                                                                            }
                                                                        }
                                                                        
                                                                    }else{
                                                                        foreach ($columnData as $k => $v) {
                                                                       
                                                                            $sumColumnData = str_replace(array(',', ' '), '', $v);
                                                                            $customSumData = str_replace($replaceColumn, $sumColumnData, $customSumFormula, $cont);
                                                                            if($cont)
                                                                            {   
                                                                                array_push($customSumDataArr ,   $customSumData);

                                                                            }
                                                                        }
                                                                    }

                                                                   

                                                                    $customSumData = $customSumDataArr;
                                                                    $customSumFormula = $customSumDataArr ;

                                                                }else{
                                                                  
                                                                    $sumColumnData = str_replace(array(',', ' '), '', $columnData);
                                                                    $customSumData = str_replace($replaceColumn, $sumColumnData, $customSumFormula);
                                                                    $customSumFormula = $customSumData;


                                                                }
                                                            }
                                                        
                                                        
                                                            
                                                            $columnData = DataTableHelper::ColumnProperties($columnData,$singleColumnValue);
                                                            $columnData = DataTableHelper::columnDataRound($columnData,$singleColumnValue);
                                                        }
                                                        /*if ($columnData && is_numeric($columnData)) {
                                                            $columnData = round($columnData);
                                                        }*/
                                                       
                  
                                                        if (!empty($searchValue) && isset($searchValue[$singleColumn])) {
                                                            $columnDataValue = strtolower($columnData);
                                                            if(isset($searchValue[$singleColumn])) {
                                                                $searchValueComumn = explode('|',$searchValue[$singleColumn]);
                                                                $searchValueComumnCount = count($searchValueComumn);
                                                                if($searchValueComumnCount > 1) {
                                                                    for($i = 0; $i < $searchValueComumnCount; $i++ ) {
                                                                        if (strpos($columnDataValue, strtolower($searchValueComumn[$i])) !== false) {
                                                                            $matchedValueCount++;
                                                                        }
                                                                    }
                                                                } else {
                                                                    if (strpos($columnDataValue, strtolower($searchValueComumn[0])) !== false) {
                                                                        $matchedValueCount++;
                                                                    }
                                                                }
                                                            }
                                                            if($getPlaceholderDetails[0]['TableType'] == '3')
                                                            { 
                                                                $dataToTable[$singleColumnVal] = $columnData;

                                                            }else{
                                                               
                                                                 $dataToTable[] = $columnData;
                                                            }
                                                        } else {
                                                          
                                                            if($getPlaceholderDetails[0]['TableType'] == '3')
                                                            { 
                                                                $dataToTable[$singleColumnVal] = $columnData;

                                                            }else{
                                                                
                                                                 $dataToTable[] = $columnData;
                                                            }
                                                        }
                                                        if(!empty($tableActions))
                                                        {
                                                            $tableActionsKey=  array_keys($tableActions);
                                                            $col = explode('->', $singleColumn);
                                                            if (in_array($tableActionsKey[0],  $col )) {
                                                                $dataToTable[$tableActionsKey[0]] = $columnData;
                                                            }
                                                        }

                                                        if (array_key_exists($singleColumn, $tableActions)) {
                                                            foreach ($tableActions[$singleColumn] as $key => $value) {
                                                                $tableActions[$singleColumn][$key]['TableParameterColumnValue'] = $columnData;
                                                            }
                                                        }
                                                    }
                                                 $dataToTable1[] = $dataToTable;
                                                }
                                               
                                            }else{
                                               
                                                foreach ($explodeColumns as $singleColumn => $singleColumnValue) {
                                                   
                                                     if($getPlaceholderDetails[0]['TableType'] == 3)
                                                        {
                                                            $singleColumnVal = $singleColumn;
                                                            if(strpos($singleColumn, $getPlaceholderDetails[0]['Name']) !== false){
                                                                $singleColumn = explode('-', $singleColumn);
                                                                $singleColumn = $singleColumn[1];
                                                                
                                                            if (isset($getPlaceholderDetails[0]['ColumnsProperties'])) {
                                                                $getColumnsProperties = json_decode($getPlaceholderDetails[0]['ColumnsProperties'], true);
                                                                $singleColumnValue = isset($getColumnsProperties[$singleColumn])?$getColumnsProperties[$singleColumn]:$singleColumn;
                                                            }

                                                            }
                                                        }
                                                    
                                                    if(strpos($singleColumn,'->') !== false)
                                                    {   

                                                        $flag1 = 0;
                                                        global $retVal , $flag1 ;
                                                        $GLOBALS['retVal'] = array();
                                                        
                                                        $GLOBALS['flag1'] = 0;
                                                        $m_name = explode('->', $singleColumn );
                                                       
                                                        $columnData = Self::addforLoops($eachRecord , $m_name , 0 );
                                                        
                                                    }else{
                                                       
                                                        if ($singleColumn == $keyColumnName) {
                                                            $keyColumnValue = Self::searchArray($eachRecord, $singleColumn);
                                                            $columnData = $keyColumnValue;

                                                        }
                                                       
                                                        if ($singleColumn == 'CountryId') {
                                                            $columnValue = Self::searchArray($eachRecord, $singleColumn);
                                                            if ($columnValue == '' || $columnValue == 'SE') {
                                                                $customerCountry = 'Sweden';
                                                            } else if ($columnValue == 'FI') {
                                                                $customerCountry = 'Finland';
                                                            } elseif ($columnValue == 'Ge') {
                                                                $customerCountry = 'Georgia';
                                                            } elseif ($columnValue == 'IT') {
                                                                $customerCountry = 'Italy';
                                                            } elseif ($columnValue == 'TW') {
                                                                $customerCountry = 'Taiwan';
                                                            } elseif ($columnValue == 'NO') {
                                                                $customerCountry = 'Norway';
                                                            } elseif ($columnValue == 'DK') {
                                                                $customerCountry = 'Denmark';
                                                            } else {
                                                                $customerCountry = $columnValue;
                                                            }
                                                            $columnData = $customerCountry;
                                                        } else {
                                                            
                                                            $columnData = Self::searchArray($eachRecord, $singleColumn);

                                                        }

                                                        if ($singleColumn == 'InvoiceNo') {
                                                            $columnDataValue = Self::searchArray($eachRecord, $singleColumn);
                                                            $invoiceNo = $columnDataValue;
                                                        }
                                                    }
                                                    if($getPlaceholderDetails[0]['TableType'] != 3){
                                                        if (isset($customSumFormula) && !empty($customSumFormula) && array_key_exists($singleColumn, $eachRecord)) {

                                                           if(isset($singleColumnValue['Label']) && $singleColumn != $singleColumnValue['Label'])
                                                            {
                                                                    $replaceColumn = "(" . $singleColumnValue['Label'] . ")";
                                                                
                                                            }else{
                                                                    $replaceColumn = "(" . $singleColumn . ")";
                                                            }

                                                            
                                                            if(is_array($columnData) || is_array($customSumFormula)){


                                                                if(is_array($customSumFormula))
                                                                {
                                                                     foreach ($columnData as $k => $v) {

                                                                        $sumColumnData = str_replace(array(',', ' '), '', $v);
                                                                        $customSumData = str_replace($replaceColumn, $sumColumnData, $customSumFormula[$k], $cont);
                                                                        
                                                                        if($cont)
                                                                        {   
                                                                            $customSumDataArr[$k] =  $customSumData;
                                                                            
                                                                        }
                                                                    }
                                                                    
                                                                }else{
                                                                    foreach ($columnData as $k => $v) {
                                                                   
                                                                        $sumColumnData = str_replace(array(',', ' '), '', $v);
                                                                        $customSumData = str_replace($replaceColumn, $sumColumnData, $customSumFormula, $cont);
                                                                        if($cont)
                                                                        {   
                                                                            array_push($customSumDataArr ,   $customSumData);

                                                                        }
                                                                    }
                                                                }

                                                               

                                                                $customSumData = $customSumDataArr;
                                                                $customSumFormula = $customSumDataArr ;

                                                            }else{
                                                              
                                                                $sumColumnData = str_replace(array(',', ' '), '', $columnData);
                                                                $customSumData = str_replace($replaceColumn, $sumColumnData, $customSumFormula);
                                                                $customSumFormula = $customSumData;


                                                            }
                                                        }
                                                    
                                                    
                                                        
                                                        $columnData = DataTableHelper::ColumnProperties($columnData,$singleColumnValue);
                                                        $columnData = DataTableHelper::columnDataRound($columnData,$singleColumnValue);
                                                    }
                                                    /*if ($columnData && is_numeric($columnData)) {
                                                        $columnData = round($columnData);
                                                    }*/
                                                   
                                                        
                                                    if (!empty($searchValue) && isset($searchValue[$singleColumn])) {
                                                        $columnDataValue = strtolower($columnData);
                                                        if(isset($searchValue[$singleColumn])) {
                                                            $searchValueComumn = explode('|',$searchValue[$singleColumn]);
                                                            $searchValueComumnCount = count($searchValueComumn);
                                                            if($searchValueComumnCount > 1) {
                                                                for($i = 0; $i < $searchValueComumnCount; $i++ ) {
                                                                    if (strpos($columnDataValue, strtolower($searchValueComumn[$i])) !== false) {
                                                                        $matchedValueCount++;
                                                                    }
                                                                }
                                                            } else {
                                                                if (strpos($columnDataValue, strtolower($searchValueComumn[0])) !== false) {
                                                                    $matchedValueCount++;
                                                                }
                                                            }
                                                        }
                                                        if($getPlaceholderDetails[0]['TableType'] == '3')
                                                        { 
                                                            $dataToTable[$singleColumnVal] = $columnData;

                                                        }else{
                                                            
                                                            if(isset($singleColumnValue['Label']))
                                                            {
                                                                $dataToTable[$singleColumnValue['Label']] = $columnData;
                                                            }else{
                                                                $dataToTable[$singleColumn] = $columnData;
                                                            }
                                                        }
                                                    } else {
                                                      
                                                        if($getPlaceholderDetails[0]['TableType'] == '3')
                                                        { 
                                                            $dataToTable[$singleColumnVal] = $columnData;

                                                        }else{
                                                           
                                                            if(isset($singleColumnValue['Label']))
                                                            {
                                                                $dataToTable[$singleColumnValue['Label']] = $columnData;
                                                            }else{
                                                                $dataToTable[$singleColumn] = $columnData;
                                                            }
                                                             
                                                        }
                                                        
                                                    }
                                                      if(isset($singleColumnValue['Label']))
                                                    {
                                                        if (array_key_exists($singleColumnValue['Label'], $tableActions)) {
                                                            foreach ($tableActions[$singleColumnValue['Label']] as $key => $value) {
                                                                $tableActions[$singleColumnValue['Label']][$key]['TableParameterColumnValue'] = $columnData[0];
                                                            }
                                                        }
                                                    }else{
                                                    if (array_key_exists($singleColumn, $tableActions)) {
                                                        foreach ($tableActions[$singleColumn] as $key => $value) {
                                                            $tableActions[$singleColumn][$key]['TableParameterColumnValue'] = $columnData;
                                                        }
                                                    }
                                                  }
                                                }
                                         
                                            
                                            }



                                            
                                            $sumColumnLable = trim($sumColumnLable);
                                            if (isset($sumColumnLable) && !empty($sumColumnLable)) {
                                                if (isset($explodeColumns)) {
                                                    if (!in_array($sumColumnLable, $explodeColumns)) {
                                                        if (!empty($customSumData) ) {

                                                            if(is_array($customSumData))
                                                            {
                                                                $tempArr = array();
                                                                $tempVal = explode(',', $customSumData[0]);

                                                                foreach ($tempVal  as $key => $value) {
                                                                        $tempArr[$key] = array();
                                                                }
                                                              
                                                                foreach ($customSumData as $key1 => $value1) {
                                                                    
                                                                    if ($sumType == 1) {
                                                                        if ($columnSumResults && is_numeric($columnSumResults)) {
                                                                            $columnSumResults = round($columnSumResults);
                                                                        }

                                                                        if (!empty($searchValue) && !empty($searchValueArray)) {
                                                                            $columnSumResultsValue = strtolower($columnSumResults);

                                                                            if (!empty($columnSumResultsValue)) {
                                                                                foreach ($searchValueArray as $searchValue) {
                                                                                    if(isset($searchValue) && !empty($searchValue)) {
                                                                                        if (strpos($columnSumResultsValue, $searchValue) !== false) {
                                                                                            $matchedData = true;
                                                                                            $matchedValueCount++;
                                                                                        }
                                                                                    }
                                                                                }
                                                                            }

                                                                            if(!empty($getColumnsProperties[$sumColumnLable])){
                                                                                $columnSumResults = DataTableHelper::ColumnProperties($columnSumResults,$getColumnsProperties[$sumColumnLable]);
                                                                            }
                                                                            $dataToTable[] = $columnSumResults;
                                                                        } else {
                                                                            if(!empty($getColumnsProperties[$sumColumnLable])){
                                                                                $columnSumResults = DataTableHelper::ColumnProperties($columnSumResults,$getColumnsProperties[$sumColumnLable]);
                                                                            }
                                                                            $dataToTable[] = $columnSumResults;
                                                                        }
                                                                    } else if ($sumType == 2) {
                                                                  
                                                                    $csData = explode(',' , $value1);
                                                                    $sumLabel = explode(',' , $sumColumnLable); 
                                                                    
                                                                    foreach ($csData as $key => $value) {
                                                                        if (strpos($value, '--') === false) {
                                                                            try{
                                                                                @eval('$result = (' . @$value . ');');
                                                                                //eval("\$result = $customSumData;");
                                                                            
                                                                            }
                                                                            catch(Exception $e){
                                                                                $result = 0;
                                                                            }
                                                                            if (is_nan($result)) {
                                                                                $result = 0;
                                                                            } else if(is_infinite($result)) {
                                                                                $result = 100;
                                                                            }
                                                                            if (!empty($searchValue) && !empty($searchValueArray)) {
                                                                                $resultValue = strtolower($result);

                                                                                if (!empty($resultValue)) {
                                                                                    foreach ($searchValueArray as $searchValue) {
                                                                                        if(isset($searchValue) && !empty($searchValue)) {
                                                                                            if (strpos($resultValue, $searchValue) !== false) {
                                                                                                $matchedData = true;
                                                                                                $matchedValueCount++;
                                                                                            }
                                                                                        }
                                                                                    }
                                                                                }

                                                                                if(!empty($getColumnsProperties[$sumLabel[$key]])){
                                                                                    $result = DataTableHelper::ColumnProperties($result,$getColumnsProperties[$sumLabel[$key]]);
                                                                                }
                                                                                $dataToTable[] = $result;

                                                                            } else {
                                                                                $sumLabelkey = trim($sumLabel[$key]);
                                                                                if(!empty($getColumnsProperties[$sumLabelkey])){
                                                                                    $result = DataTableHelper::ColumnProperties($result,$getColumnsProperties[$sumLabelkey]);
                                                                                }
                                                                                
                                                                                array_push($tempArr[$key], $result);
                                                                                //$dataToTable[] = $result;
                                                                            }
                                                                        }
                                                                        else{

                                                                           $value = str_replace('--', '+', $value);
                                                                           try{
                                                                                @eval('$result = (' . @$value . ');');
                                                                                //eval("\$result = $customSumData;");
                                                                            }
                                                                            catch(Exception $e){
                                                                               $result = 0;
                                                                            }
                                                                            if (is_nan($result)) {
                                                                                $result = 0;
                                                                            } else if(is_infinite($result)) {
                                                                                $result = 100;
                                                                            }
                                                                            if (!empty($searchValue) && !empty($searchValueArray)) {
                                                                                $resultValue = strtolower($result);

                                                                                if (!empty($resultValue)) {
                                                                                    foreach ($searchValueArray as $searchValue) {
                                                                                        if(isset($searchValue) && !empty($searchValue)) {
                                                                                            if (strpos($resultValue, $searchValue) !== false) {
                                                                                                $matchedData = true;
                                                                                                $matchedValueCount++;
                                                                                            }
                                                                                        }
                                                                                    }
                                                                                }

                                                                                if(!empty($getColumnsProperties[$sumLabel[$key]])){
                                                                                    $result = DataTableHelper::ColumnProperties($result,$getColumnsProperties[$sumLabel[$key]]);
                                                                                }

                                                                                //$dataToTable[] = $result;

                                                                            } else {
                                                                                if(!empty($getColumnsProperties[$sumLabel[$key]])){
                                                                                    $result = DataTableHelper::ColumnProperties($result,$getColumnsProperties[$sumLabel[$key]]);
                                                                                }
                                                                                array_push($tempArr[$key], $result );
                                                                            }

                                                                        }
                                                                    }
                                                                    }
                                                                 

                                                                }
                                                                if(count($tempArr) > 0)
                                                                    {
                                                                        
                                                                        foreach ($tempVal  as $key => $value) {
                                                                            $dataToTable[] = $tempArr[$key];
                                                                        }
                                                                         
                                                                    }else{
                                                                        $dataToTable[] = $result;
                                                                    }
                                                                
                                                               
                                                            }else{

                                                            if ($sumType == 1) {
                                                                if ($columnSumResults && is_numeric($columnSumResults)) {
                                                                    $columnSumResults = round($columnSumResults);
                                                                }

                                                                if (!empty($searchValue) && !empty($searchValueArray)) {
                                                                    $columnSumResultsValue = strtolower($columnSumResults);

                                                                    if (!empty($columnSumResultsValue)) {
                                                                        foreach ($searchValueArray as $searchValue) {
                                                                            if(isset($searchValue) && !empty($searchValue)) {
                                                                                if (strpos($columnSumResultsValue, $searchValue) !== false) {
                                                                                    $matchedData = true;
                                                                                    $matchedValueCount++;
                                                                                }
                                                                            }
                                                                        }
                                                                    }


                                                                    /*if (!empty($columnSumResultsValue) && strpos($columnSumResultsValue, $searchValue) !== false) {
                                                                        $matchedData = true;
                                                                    }*/
                                                                    if(!empty($getColumnsProperties[$sumColumnLable])){
                                                                        $columnSumResults = DataTableHelper::ColumnProperties($columnSumResults,$getColumnsProperties[$sumColumnLable]);
                                                                    }
                                                                    $dataToTable[] = $columnSumResults;
                                                                } else {
                                                                    if(!empty($getColumnsProperties[$sumColumnLable])){
                                                                        $columnSumResults = DataTableHelper::ColumnProperties($columnSumResults,$getColumnsProperties[$sumColumnLable]);
                                                                    }
                                                                    $dataToTable[] = $columnSumResults;
                                                                }
                                                            } else if ($sumType == 2) {
                                                                    $csData = explode(',' , $customSumData);
                                                                    $sumLabel = explode(',' , $sumColumnLable); 
                                                                    
                                                                    foreach ($csData as $key => $value) {
                                                                        if (strpos($value, '--') === false) {
                                                                            try{
                                                                                @eval('$result = (' . @$value . ');');
                                                                                //eval("\$result = $customSumData;");
                                                                            
                                                                            }
                                                                            catch(Exception $e){
                                                                                $result = 0;
                                                                            }
                                                                            if (is_nan($result)) {
                                                                                $result = 0;
                                                                            } else if(is_infinite($result)) {
                                                                                $result = 100;
                                                                            }
                                                                            if (!empty($searchValue) && !empty($searchValueArray)) {
                                                                                $resultValue = strtolower($result);

                                                                                if (!empty($resultValue)) {
                                                                                    foreach ($searchValueArray as $searchValue) {
                                                                                        if(isset($searchValue) && !empty($searchValue)) {
                                                                                            if (strpos($resultValue, $searchValue) !== false) {
                                                                                                $matchedData = true;
                                                                                                $matchedValueCount++;
                                                                                            }
                                                                                        }
                                                                                    }
                                                                                }

                                                                                if(!empty($getColumnsProperties[$sumLabel[$key]])){
                                                                                    $result = DataTableHelper::ColumnProperties($result,$getColumnsProperties[$sumLabel[$key]]);
                                                                                }
                                                                                $dataToTable[] = $result;

                                                                            } else {
                                                                                $sumLabelkey = trim($sumLabel[$key]);
                                                                                if(!empty($getColumnsProperties[$sumLabelkey])){
                                                                                    $result = DataTableHelper::ColumnProperties($result,$getColumnsProperties[$sumLabelkey]);
                                                                                }
                                                                                
                                                                                $dataToTable[] = $result;
                                                                            }
                                                                        }
                                                                        else{

                                                                           $value = str_replace('--', '+', $value);
                                                                           try{
                                                                                @eval('$result = (' . @$value . ');');
                                                                                //eval("\$result = $customSumData;");
                                                                            }
                                                                            catch(Exception $e){
                                                                               $result = 0;
                                                                            }
                                                                            if (is_nan($result)) {
                                                                                $result = 0;
                                                                            } else if(is_infinite($result)) {
                                                                                $result = 100;
                                                                            }
                                                                            if (!empty($searchValue) && !empty($searchValueArray)) {
                                                                                $resultValue = strtolower($result);

                                                                                if (!empty($resultValue)) {
                                                                                    foreach ($searchValueArray as $searchValue) {
                                                                                        if(isset($searchValue) && !empty($searchValue)) {
                                                                                            if (strpos($resultValue, $searchValue) !== false) {
                                                                                                $matchedData = true;
                                                                                                $matchedValueCount++;
                                                                                            }
                                                                                        }
                                                                                    }
                                                                                }

                                                                                if(!empty($getColumnsProperties[$sumLabel[$key]])){
                                                                                    $result = DataTableHelper::ColumnProperties($result,$getColumnsProperties[$sumLabel[$key]]);
                                                                                }

                                                                                $dataToTable[] = $result;

                                                                            } else {
                                                                                if(!empty($getColumnsProperties[$sumLabel[$key]])){
                                                                                    $result = DataTableHelper::ColumnProperties($result,$getColumnsProperties[$sumLabel[$key]]);
                                                                                }

                                                                                $dataToTable[] = $result;
                                                                            }

                                                                        }
                                                                    }
                                                            }
                                                            }






                                                        }
                                                    }
                                                }

                                            }

                                            if ($tableActions) {
                                                //MY_ This needs to be hide
                                                $orderNoCol = '';
                                                $orderNoValue = '';
                                                if(count($tableActions) > 1) {
                                                    foreach ($tableActions as $eachAction) {
                                                        foreach ($eachAction as $actionDetails) {
                                                            if ((isset($actionDetails['TableParameterColumn']))) {
                                                                $orderNoCol .= $actionDetails['TableParameterColumn'].'||';
                                                            }
                                                            if ((isset($actionDetails['TableParameterColumnValue']))) {
                                                                $orderNoValue .= $actionDetails['TableParameterColumnValue'].'||';
                                                            }
                                                        }
                                                    }

                                                    $orderNoCol = rtrim($orderNoCol, '||');
                                                    $orderNoValue = rtrim($orderNoValue, '||');
                                                }
                                

                                                $names_ = "";
                                                $actions_ = "";
                                                $t = "";
                                                $txt_ =  "";
                                                $class_ = "";
                                                $separator= "%";


                                                foreach ($tableActions as $key => $eachAction) {

                                                    if(isset($key) && !in_array($key,$actationTableColumn)) {
                                                        foreach ($eachAction as $actionDetails) {

                                                            
                                                            $externalUrl = $actionDetails['ExternalUrl'];
                                                            $tableParameterColumnValue = (isset($actionDetails['TableParameterColumnValue'])) ? $actionDetails['TableParameterColumnValue'] : "";
                                                            if(count($tableActions) == 1) {
                                                                $orderNoCol = '';
                                                                $orderNoValue = '';
                                                                $orderNoCol = $actionDetails['TableParameterColumn'];
                                                                $orderNoValue = $tableParameterColumnValue;
                                                                
                                                            }
                                                            $pageTextValue = '';
                                                            if($_SESSION['UserID'] && $actionDetails['PageTargetId']) {
                                                                $pageText = Page::getPageText($actionDetails['PageTargetId'], $_SESSION['UserID']);
                                                                if($pageText) {
                                                                    $pageTextValue = $pageText[0]['PageMenuText'];
                                                                }
                                                            }

                                                            $getPagePlaceholders = Page::getPagePlaceholders($actionDetails['PageTargetId'], $_SESSION['UserID'], $pageText[0]['PageMenuText']);
 
                                                            if (!empty($externalUrl)) {
                                                                $buttonAction = $externalUrl;
                                                                // $txt_ .=  "".$separator;
                                                                // $class_ .= "".$separator;
                                                            } 
                                                            else {

                                                                
                                                                //$buttonAction = baseUrl . 'page?id=' . $actionDetails['PageTargetId'] . '&page_text='. $pageTextValue .'&columnName=' . $actionDetails['TableParameterColumn'] . '&columnValue=' . $tableParameterColumnValue;
                                                                
                                                                foreach ($getPagePlaceholders as $getPagePlaceholdersKey => $getPagePlaceholdersValue) {
                                                                    
                                                                    if($getPagePlaceholdersValue['PlaceholderType'] == 2)
                                                                    {
                                                                     
                                                                        $dataToTable['FocusPageURL'.$getPagePlaceholdersValue['PlaceholderId']] = baseUrl.$_REQUEST['APIData']['APIUrl'].'/focusPage?'.$actionDetails['TableParameterColumn']. '='.$tableParameterColumnValue.'&Tableid='.$getPagePlaceholdersValue['PlaceholderId'].'&AuthKey='.$_REQUEST['AuthKey'] ;
                                                                    }
                                                                    
                                                                }
                                                                // $txt_ .=  "".$separator;
                                                                // $class_ .= "".$separator;
                                                            }

                                                            if ($actionDetails['updateDataSource'] == 1) {
                                                                $parameterArray = array('orderNoCol'=>$orderNoCol,'orderNoValue'=>$orderNoValue,'baseUrl' => baseUrl, 'pageTextValue' => rawurlencode ($pageTextValue), 'dataSourceId' => $actionDetails['DataSourceId'],'pageTargetId' => $actionDetails['PageTargetId']);
                                                                $parameterArray = json_encode($parameterArray, JSON_UNESCAPED_SLASHES);
                                                                if ($actionDetails['PredefinedUpdate'] == 1) {
                                                                    $buttonAction = 'getUpdatePredefined('. $parameterArray .')';
                                                                    $txt_ .=  $actionDetails['ActionButtonText'].$separator;
                                                                    //$class_ .= $buttonAction.$separator;
                                                                    //commentet out SA
                                                                    $class_ .= str_replace("http://","",$buttonAction).$separator;
                                                                   //me:$actionButtons .= "<li><a href='#' onclick='" . $buttonAction . "'>" . $actionDetails['ActionButtonText'] . "</a></li>";

                                                                } 
                                                                else if ($actionDetails['DataSourceCall'] == 1) {
                                                                    $buttonAction = 'getUpdateDataSourceCall('. $parameterArray .')';
                                                                    $txt_ .=  $actionDetails['ActionButtonText'].$separator;
                                                                     //$class_ .= $buttonAction.$separator;
                                                                    //commentet out SA
                                                                    $class_ .= str_replace("http://","",$buttonAction).$separator;

                                                                  //me: $actionButtons .= "<li><a href='#' onclick='" . $buttonAction . "'>" . $actionDetails['ActionButtonText']. "</a></li>";

                                                                } 
                                                                 else {
                                                                    
                                                                    $buttonAction = baseUrl . 'getUpdateForm?dataSourceId=' . $actionDetails['DataSourceId'] .   '&pageId=' . $actionDetails['PageTargetId']  . '&columnName=' . $orderNoCol . '&columnValue=' . $orderNoValue . '&page_text='. rawurlencode ($pageTextValue) . '&tableID=' . $actionDetails['TableTemplateId'];

                                                                    $txt_ .=  $actionDetails['ActionButtonText'].$separator;
                                                                     //$class_ .= $buttonAction.$separator;
                                                                    //commentet out SA
                                                                    $class_ .= str_replace("http://","",$buttonAction).$separator;

                                                                    //me:$actionButtons .= "<li><a data-href='" . $buttonAction . "' class='LoadForm'>" . $actionDetails['ActionButtonText'] . "</a></li>";
                                                                }
                                                            } 
                                                            else {
                                                                if ($actionDetails['IsPdf'] == 1) {
                                                                    /*$parameterArray = array('baseUrl' => baseUrl, 'InvoiceNo' => $invoiceNo,'dataSourceId' => $actionDetails['DataSourceId']);
                                                                    $parameterArray = json_encode($parameterArray, JSON_UNESCAPED_SLASHES);
                                                                    $buttonAction = 'downloadPdf('. $parameterArray .')';*/
                                                                    $buttonAction = baseUrl . 'downloadPdf?dataSourceId=' . $actionDetails['DataSourceId'] . '&InvoiceNo=' . $invoiceNo;
                                                                    $txt_ .= $actionDetails['ActionButtonText'].$separator;
                                                                     //$class_ .= $buttonAction.$separator;
                                                                    //commentet out SA
                                                                    $class_ .= str_replace("http://","",$buttonAction).$separator;

                                                                    //me: $actionButtons .= "<li><a href='" . $buttonAction . "' target='_blank'>" . $actionDetails['ActionButtonText'] . "</a></li>";

                                                                } 
                                                                else {
                                                                    
                                                                    foreach ($getPagePlaceholders as $getPagePlaceholdersKey => $getPagePlaceholdersValue) {
                                                                        
                                                                        if($getPagePlaceholdersValue['PlaceholderType'] == 2)
                                                                        {
                                                                            $dataToTable['FocusPageURL'.$getPagePlaceholdersValue['PlaceholderId']] = baseUrl.$_REQUEST['APIData']['APIUrl'].'/focusPage?'.$actionDetails['TableParameterColumn']. '='.$tableParameterColumnValue.'&Tableid='.$getPagePlaceholdersValue['PlaceholderId'].'&AuthKey='.$_REQUEST['AuthKey'].'&reqtype='.$_REQUEST['APIData']['RequestType'] ;
                                                                        }
                                                                        
                                                                    }
                                                                    // $txt_ .= $actionDetails['ActionButtonText'].$separator;
                                                                    // //$class_ .= $buttonAction.$separator;
                                                                    // //commentet out SA
                                                                    // $class_ .= str_replace("http://","",$buttonAction).$separator;

                                                                    //me: $actionButtons .= "<li><a href='" . $buttonAction . "'>" .$actionDetails['ActionButtonText'] . "</a></li>"; // ACTION BINDER MY_
                                                                }
                                                            }
                                                        }
                                                    }
                                                 
                                                }
                                               
                                                // $dataToTable[] = $txt_ ;
                                                // $dataToTable[] = $class_ ;
                                            }


                if ($filterion) {
                    if($searchValueCount == $matchedValueCount) {
                        $tableData['data'][] = $dataToTable;
                    }
                } 
                else {
                      
                    $tableData['data'][] = $dataToTable;
                   
                }
                
              
                if($getPlaceholderDetails[0]['ApiType'] == '2'){
                    $newResArr = array();
                    //$flag  = 0;
                    if(isset(($dataToTable1)))
                    {

                        foreach ($dataToTable1 as $kes => $vals) {
                            $tabAct = [];
                            if(!empty($tableActions))
                            {
                                $tableActionsKey=  array_keys($tableActions);

                                if (array_key_exists($tableActionsKey[0],  $vals )) {
                                    $tabAct = $vals[$tableActionsKey[0]];
                                    unset($vals[$tableActionsKey[0]]);
                                    $vals= array_merge($vals);
                                }
                            }
                            $tst = $vals[0];
                            if( count($vals) >1 ){
                                for ($i=1; $i < count($vals) ; $i++) { 
                                    
                                    if(!is_array($tst))
                                    {
                                        $tst = array($tst);
                                    }
                                    if(!is_array($vals[$i]))
                                    {
                                        $vals[$i]= array($vals[$i]);
                                    }

                                    $tst = Self::cartesian($tst , $vals[$i]);
                                }
                                foreach ($tst as $key => $value) {
                                    $tempRes = array();
                                    $tempRes = Self::array_flatten($value);
                                    if ($tableActions) {
                                                    
                                                    $orderNoCol = '';
                                                    $orderNoValue = '';
                                                    if(count($tableActions) > 1) {
                                                        foreach ($tableActions as $eachAction) {
                                                            foreach ($eachAction as $actionDetails) {
                                                                if ((isset($actionDetails['TableParameterColumn']))) {
                                                                    $orderNoCol .= $actionDetails['TableParameterColumn'].'||';
                                                                }
                                                                if ((isset($actionDetails['TableParameterColumnValue']))) {
                                                                    $orderNoValue .= $actionDetails['TableParameterColumnValue'].'||';
                                                                }
                                                            }
                                                        }

                                                        $orderNoCol = rtrim($orderNoCol, '||');
                                                        $orderNoValue = rtrim($orderNoValue, '||');
                                                    }
                                    

                                                    $names_ = "";
                                                    $actions_ = "";
                                                    $t = "";
                                                    $txt_ =  "";
                                                    $class_ = "";
                                                    $separator= "%";


                                                    foreach ($tableActions as $key => $eachAction) {

                                                        if(isset($key) && !in_array($key,$actationTableColumn)) {
                                                            foreach ($eachAction as $actionDetails) {


                                                                $externalUrl = $actionDetails['ExternalUrl'];
                                                                if(!empty($tabAct)){
                                                                    foreach ($tabAct as $tabActkey => $tabActvalue) {
                                                                        $kes = array_search($tabActvalue, $tempRes);
                                                                        if($kes !== false)
                                                                        {
                                                                            $tableParameterColumnValue = (isset($tempRes[$kes])) ? $tempRes[$kes] : "";
                                                                        }
                                                                    }
                                                                
                                                                    
                                                                }
                                                                
                                                                if(count($tableActions) == 1) {
                                                                    $orderNoCol = '';
                                                                    $orderNoValue = '';
                                                                    $orderNoCol = $actionDetails['TableParameterColumn'];
                                                                    $orderNoValue = $tableParameterColumnValue;
                                                                    
                                                                }
                                                                $pageTextValue = '';
                                                                if($_SESSION['UserID'] && $actionDetails['PageTargetId']) {
                                                                    $pageText = Page::getPageText($actionDetails['PageTargetId'], $_SESSION['UserID']);
                                                                    if($pageText) {
                                                                        $pageTextValue = $pageText[0]['PageMenuText'];
                                                                    }
                                                                }


                                                                if (!empty($externalUrl)) {
                                                                    $buttonAction = $externalUrl;
                                                                    
                                                                } 
                                                                else {

                                                                    
                                                                    //$buttonAction = baseUrl . 'page?id=' . $actionDetails['PageTargetId'] . '&page_text='. $pageTextValue .'&columnName=' . $actionDetails['TableParameterColumn'] . '&columnValue=' . $tableParameterColumnValue;
                                                                    
                                                                    foreach ($getPagePlaceholders as $getPagePlaceholdersKey => $getPagePlaceholdersValue) {
                                                                        
                                                                        if($getPagePlaceholdersValue['PlaceholderType'] == 2)
                                                                        {
                                                                            $tempRes['FocusPageURL'.$getPagePlaceholdersValue['PlaceholderId']] = baseUrl.$_REQUEST['APIData']['APIUrl'].'/focusPage?'.$actionDetails['TableParameterColumn']. '='.$tableParameterColumnValue.'&Tableid='.$getPagePlaceholdersValue['PlaceholderId'].'&AuthKey='.$_REQUEST['AuthKey'] ;
                                                                        }
                                                                        
                                                                    }
                                                                }

                                                                if ($actionDetails['updateDataSource'] == 1) {
                                                                    $parameterArray = array('orderNoCol'=>$orderNoCol,'orderNoValue'=>$orderNoValue,'baseUrl' => baseUrl, 'pageTextValue' => rawurlencode ($pageTextValue), 'dataSourceId' => $actionDetails['DataSourceId'],'pageTargetId' => $actionDetails['PageTargetId']);
                                                                    $parameterArray = json_encode($parameterArray, JSON_UNESCAPED_SLASHES);
                                                                    if ($actionDetails['PredefinedUpdate'] == 1) {
                                                                        $buttonAction = 'getUpdatePredefined('. $parameterArray .')';
                                                                        $txt_ .=  $actionDetails['ActionButtonText'].$separator;
                                                                    
                                                                        $class_ .= str_replace("http://","",$buttonAction).$separator;
                                                                    

                                                                    } 
                                                                    else if ($actionDetails['DataSourceCall'] == 1) {
                                                                        $buttonAction = 'getUpdateDataSourceCall('. $parameterArray .')';
                                                                        $txt_ .=  $actionDetails['ActionButtonText'].$separator;
                                                                        //$class_ .= $buttonAction.$separator;
                                                                        //commentet out SA
                                                                        $class_ .= str_replace("http://","",$buttonAction).$separator;

                                                                    

                                                                    } 
                                                                    else {
                                                                        
                                                                        $buttonAction = baseUrl . 'getUpdateForm?dataSourceId=' . $actionDetails['DataSourceId'] .   '&pageId=' . $actionDetails['PageTargetId']  . '&columnName=' . $orderNoCol . '&columnValue=' . $orderNoValue . '&page_text='. rawurlencode ($pageTextValue) . '&tableID=' . $actionDetails['TableTemplateId'];

                                                                        $txt_ .=  $actionDetails['ActionButtonText'].$separator;
                                                                        
                                                                        $class_ .= str_replace("http://","",$buttonAction).$separator;

                                                                    }
                                                                } 
                                                                else {
                                                                    if ($actionDetails['IsPdf'] == 1) {
                                                                        
                                                                        $buttonAction = baseUrl . 'downloadPdf?dataSourceId=' . $actionDetails['DataSourceId'] . '&InvoiceNo=' . $invoiceNo;
                                                                        $txt_ .= $actionDetails['ActionButtonText'].$separator;
                                                                    
                                                                        $class_ .= str_replace("http://","",$buttonAction).$separator;
                                                                    } 
                                                                    else {
                                                                       
                                                                    foreach ($getPagePlaceholders as $getPagePlaceholdersKey => $getPagePlaceholdersValue) {
                                                                        
                                                                        if($getPagePlaceholdersValue['PlaceholderType'] == 2)
                                                                        {
                                                                            $tempRes['FocusPageURL'.$getPagePlaceholdersValue['PlaceholderId']] = baseUrl.$_REQUEST['APIData']['APIUrl'].'/focusPage?'.$actionDetails['TableParameterColumn']. '='.$tableParameterColumnValue.'&Tableid='.$getPagePlaceholdersValue['PlaceholderId'].'&AuthKey='.$_REQUEST['AuthKey'] ;
                                                                        }
                                                                        
                                                                    }
                                                                    }
                                                                }
                                                            }
                                                        }
                                                    
                                                    }
                                                
                                                   
                                                }

                                    array_push($newResArr1 , $tempRes);
                                }
                            }else{
                                
                                foreach ($tst as $key => $value) {
                                    $newTam = [];
                                    $newTam[] = $value ;
                                    array_push($newResArr1 , $newTam);
                                }
                            }
                        }
                        
                    }else{
                       
                        $dataToTable12 = array_values($dataToTable);
                        $tst = $dataToTable12[0];
                        $allKeys = array_keys($dataToTable);
                       
                        for ($i=1; $i < count($dataToTable12) ; $i++) { 
                            
                            if(!is_array($tst))
                            {
                                $tst = array($tst);
                            }
                            if(!is_array($dataToTable12[$i]))
                            {
                                $dataToTable12[$i]= array($dataToTable12[$i]);
                            }

                            $tst = Self::cartesian($tst , $dataToTable12[$i]);
                        }
                       
                        foreach ($tst as $key => $value) {
                            $tempRes = array();
                            $tempRes = Self::array_flatten($value);
                            foreach ($tempRes as $Mainkey => $Mainvalue) {
                                $tempRes[$allKeys[$Mainkey]] = $Mainvalue;
                                unset($tempRes[$Mainkey]);
                            }
                            
                            array_push($newResArr1 , $tempRes);
                        }
                       
                    }

                 }

                                        }

                                    
                                    }
                                    
                
               
                                }
                                }
                            }
                             
                        }
                        }
                    }
                    
                    if($getPlaceholderDetails1[0]['TableType'] == 3)
                    {
                        $joinTbaleRes[$getPlaceholderDetails[0]['ID']] = $tableData;
                    }

                    }
                    
                }
                 
                if(!empty($joinTbaleRes))
                {
                    $tableData = array();
                    $allKeys = array_keys($joinTbaleRes);
                    $tempcnt = 0;
                    $mainKey = 0;
                    $newRe = array();
                    foreach ($allKeys as $key => $valu) {
                      if(count($joinTbaleRes[$valu]['data'])> $tempcnt)
                      {
                        $tempcnt = count($joinTbaleRes[$valu]['data']);
                        $mainKey = $valu;
                      }
                    }
                     
                    
                    foreach ($joinTbaleRes[$mainKey]['data'] as $key => $value) {
                     
                        foreach ($allKeys as $k => $v) {
                            if($v != $mainKey)
                            {
                                
                               
                                if(isset($joinTbaleRes[$v]['data'][$key])){
                                  
                                    foreach ($value as $key12 => $value12) {
                                      
                                        
                                        if(empty($value12) && !empty($joinTbaleRes[$v]['data'][$key][$key12]))
                                        {
                                            $value[$key12] = $joinTbaleRes[$v]['data'][$key][$key12] ;
                                        }else if(!empty($value12) && !empty($joinTbaleRes[$v]['data'][$key][$key12])){
                                            $nwArr = array($key12.'-'.$v =>$joinTbaleRes[$v]['data'][$key][$key12]);
                                         
                                            $value = array_merge($value , $nwArr);
                                            
                                        }
                                    }
                                }
                            }
                        }
                      
                        
                        $customSumFormula = (isset($getPlaceholderDetails[0]['CustomSumFormula'])) ? $getPlaceholderDetails[0]['CustomSumFormula'] : "";
                       
                        foreach ($explodeColumns as $singleColumn => $singleColumnValue) {
                            $columnData = $value[$singleColumn];
                             if($getPlaceholderDetails[0]['TableType'] == 3)
                                {
                                    $singleColumnVal = $singleColumn;
                                    if(strpos($singleColumn, $getPlaceholderDetails[0]['Name']) !== false){
                                        $singleColumn = explode('-', $singleColumn);
                                        $singleColumn = $singleColumn[1];
                                        
                                    if (isset($getPlaceholderDetails[0]['ColumnsProperties'])) {
                                        $getColumnsProperties = json_decode($getPlaceholderDetails[0]['ColumnsProperties'], true);
                                        $singleColumnValue = isset($getColumnsProperties[$singleColumn])?$getColumnsProperties[$singleColumn]:$singleColumn;
                                    }

                                    }
                                }

                            if (isset($customSumFormula) && !empty($customSumFormula) ) {

                                   if(isset($singleColumnValue['Label']) && $singleColumn != $singleColumnValue['Label'])
                                    {
                                            $replaceColumn = "(" . $singleColumnValue['Label'] . ")";
                                        
                                    }else{
                                            $replaceColumn = "(" . $singleColumnVal . ")";
                                    }
                                  
                                    if(is_array($columnData) || is_array($customSumFormula)){


                                        if(is_array($customSumFormula))
                                        {
                                             foreach ($columnData as $k => $v) {

                                                $sumColumnData = str_replace(array(',', ' '), '', $v);
                                                $customSumData = str_replace($replaceColumn, $sumColumnData, $customSumFormula[$k], $cont);
                                                
                                                if($cont)
                                                {   
                                                    $customSumDataArr[$k] =  $customSumData;
                                                    
                                                }
                                            }
                                            
                                        }else{
                                            foreach ($columnData as $k => $v) {
                                           
                                                $sumColumnData = str_replace(array(',', ' '), '', $v);
                                                $customSumData = str_replace($replaceColumn, $sumColumnData, $customSumFormula, $cont);
                                                if($cont)
                                                {   
                                                    array_push($customSumDataArr ,   $customSumData);

                                                }
                                            }
                                        }
                                        $customSumData = $customSumDataArr;
                                        $customSumFormula = $customSumDataArr ;

                                    }else{
                                        
                                        if(!empty($columnData))
                                        {
                                            
                                            $sumColumnData = str_replace(array(',', ' '), '', $columnData);
                                            $customSumData = str_replace($replaceColumn, $sumColumnData, $customSumFormula);
                                            $customSumFormula = $customSumData;
                                        }else{
                                           
                                            $sumColumnData = str_replace(array(',', ' '), '', 0);
                                            $customSumData = str_replace($replaceColumn, $sumColumnData, $customSumFormula);
                                            $customSumFormula = $customSumData;
                                        }

                                    }

                            }
                            $columnData = DataTableHelper::ColumnProperties($columnData,$singleColumnValue);
                            $columnData = DataTableHelper::columnDataRound($columnData,$singleColumnValue);  
                            $value[$singleColumnVal] = $columnData;
                            $sumColumnLable = trim($sumColumnLable);

                        }  
                        
                        if (isset($sumColumnLable) && !empty($sumColumnLable)) {
                                if (isset($explodeColumns)) {
                                    if (!in_array($sumColumnLable, $explodeColumns)) {
                                        if (!empty($customSumData) ) {

                                            if(is_array($customSumData))
                                            {
                                                $tempArr = array();
                                                $tempVal = explode(',', $customSumData[0]);

                                                foreach ($tempVal  as $key => $val) {
                                                        $tempArr[$key] = array();
                                                }
                                              
                                                foreach ($customSumData as $key1 => $value1) {
                                                    
                                                    if ($sumType == 1) {
                                                        if ($columnSumResults && is_numeric($columnSumResults)) {
                                                            $columnSumResults = round($columnSumResults);
                                                        }

                                                        if (!empty($searchValue) && !empty($searchValueArray)) {
                                                            $columnSumResultsValue = strtolower($columnSumResults);

                                                            if (!empty($columnSumResultsValue)) {
                                                                foreach ($searchValueArray as $searchValue) {
                                                                    if(isset($searchValue) && !empty($searchValue)) {
                                                                        if (strpos($columnSumResultsValue, $searchValue) !== false) {
                                                                            $matchedData = true;
                                                                            $matchedValueCount++;
                                                                        }
                                                                    }
                                                                }
                                                            }

                                                            if(!empty($getColumnsProperties[$sumColumnLable])){
                                                                $columnSumResults = DataTableHelper::ColumnProperties($columnSumResults,$getColumnsProperties[$sumColumnLable]);
                                                            }
                                                            $dataToTable[] = $columnSumResults;
                                                        } else {
                                                            if(!empty($getColumnsProperties[$sumColumnLable])){
                                                                $columnSumResults = DataTableHelper::ColumnProperties($columnSumResults,$getColumnsProperties[$sumColumnLable]);
                                                            }
                                                            array_push($value, $result);
                                                        }
                                                    } else if ($sumType == 2) {
                                                  

                                                    $csData = explode(',' , $value1);
                                                    $sumLabel = explode(',' , $sumColumnLable); 
                                                    
                                                    foreach ($csData as $key => $value123) {
                                                        if (strpos($value123, '--') === false) {
                                                            try{
                                                                @eval('$result = (' . @$value123 . ');');
                                                                //eval("\$result = $customSumData;");
                                                            
                                                            }
                                                            catch(Exception $e){
                                                                $result = 0;
                                                            }
                                                            if (is_nan($result)) {
                                                                $result = 0;
                                                            } else if(is_infinite($result)) {
                                                                $result = 100;
                                                            }
                                                            if (!empty($searchValue) && !empty($searchValueArray)) {
                                                                $resultValue = strtolower($result);

                                                                if (!empty($resultValue)) {
                                                                    foreach ($searchValueArray as $searchValue) {
                                                                        if(isset($searchValue) && !empty($searchValue)) {
                                                                            if (strpos($resultValue, $searchValue) !== false) {
                                                                                $matchedData = true;
                                                                                $matchedValueCount++;
                                                                            }
                                                                        }
                                                                    }
                                                                }

                                                                if(!empty($getColumnsProperties[$sumLabel[$key]])){
                                                                    $result = DataTableHelper::ColumnProperties($result,$getColumnsProperties[$sumLabel[$key]]);
                                                                }
                                                                array_push($value, $result);

                                                            } else {
                                                                $sumLabelkey = trim($sumLabel[$key]);
                                                                if(!empty($getColumnsProperties[$sumLabelkey])){
                                                                    $result = DataTableHelper::ColumnProperties($result,$getColumnsProperties[$sumLabelkey]);
                                                                }
                                                                
                                                                array_push($tempArr[$key], $result);
                                                                //$dataToTable[] = $result;
                                                            }
                                                        }
                                                        else{

                                                           $value123 = str_replace('--', '+', $value123);
                                                           try{
                                                                @eval('$result = (' . @$value123 . ');');
                                                                //eval("\$result = $customSumData;");
                                                            }
                                                            catch(Exception $e){
                                                               $result = 0;
                                                            }
                                                            if (is_nan($result)) {
                                                                $result = 0;
                                                            } else if(is_infinite($result)) {
                                                                $result = 100;
                                                            }
                                                            if (!empty($searchValue) && !empty($searchValueArray)) {
                                                                $resultValue = strtolower($result);

                                                                if (!empty($resultValue)) {
                                                                    foreach ($searchValueArray as $searchValue) {
                                                                        if(isset($searchValue) && !empty($searchValue)) {
                                                                            if (strpos($resultValue, $searchValue) !== false) {
                                                                                $matchedData = true;
                                                                                $matchedValueCount++;
                                                                            }
                                                                        }
                                                                    }
                                                                }

                                                                if(!empty($getColumnsProperties[$sumLabel[$key]])){
                                                                    $result = DataTableHelper::ColumnProperties($result,$getColumnsProperties[$sumLabel[$key]]);
                                                                }

                                                                //$dataToTable[] = $result;

                                                            } else {
                                                                if(!empty($getColumnsProperties[$sumLabel[$key]])){
                                                                    $result = DataTableHelper::ColumnProperties($result,$getColumnsProperties[$sumLabel[$key]]);
                                                                }
                                                                array_push($tempArr[$key], $result );
                                                            }

                                                        }
                                                    }
                                                    }
                                                 

                                                }
                                                if(count($tempArr) > 0)
                                                    {
                                                        
                                                        foreach ($tempVal  as $key => $value) {
                                                            $dataToTable[] = $tempArr[$key];
                                                        }
                                                         
                                                    }else{
                                                       array_push($value, $result);
                                                    }
                                                
                                               
                                            }else{

                                            if ($sumType == 1) {
                                                if ($columnSumResults && is_numeric($columnSumResults)) {
                                                    $columnSumResults = round($columnSumResults);
                                                }

                                                if (!empty($searchValue) && !empty($searchValueArray)) {
                                                    $columnSumResultsValue = strtolower($columnSumResults);

                                                    if (!empty($columnSumResultsValue)) {
                                                        foreach ($searchValueArray as $searchValue) {
                                                            if(isset($searchValue) && !empty($searchValue)) {
                                                                if (strpos($columnSumResultsValue, $searchValue) !== false) {
                                                                    $matchedData = true;
                                                                    $matchedValueCount++;
                                                                }
                                                            }
                                                        }
                                                    }

                                                    if(!empty($getColumnsProperties[$sumColumnLable])){
                                                        $columnSumResults = DataTableHelper::ColumnProperties($columnSumResults,$getColumnsProperties[$sumColumnLable]);
                                                    }
                                                     array_push($value, $result);
                                                } else {
                                                    if(!empty($getColumnsProperties[$sumColumnLable])){
                                                        $columnSumResults = DataTableHelper::ColumnProperties($columnSumResults,$getColumnsProperties[$sumColumnLable]);
                                                    }
                                                     array_push($value, $result);
                                                }
                                            } else if ($sumType == 2) {
                                                    $csData = explode(',' , $customSumData);
                                                    $sumLabel = explode(',' , $sumColumnLable); 
                                                 
                                                    foreach ($csData as $key => $value123) {
                                                        if (strpos($value123, '--') === false) {
                                                            try{
                                                                @eval('$result = (' . @$value123 . ');');
                                                                //eval("\$result = $customSumData;");
                                                            
                                                            }
                                                            catch(Exception $e){
                                                                $result = 0;
                                                            }
                                                            if (is_nan($result)) {
                                                                $result = 0;
                                                            } else if(is_infinite($result)) {
                                                                $result = 100;
                                                            }
                                                            if (!empty($searchValue) && !empty($searchValueArray)) {
                                                                $resultValue = strtolower($result);

                                                                if (!empty($resultValue)) {
                                                                    foreach ($searchValueArray as $searchValue) {
                                                                        if(isset($searchValue) && !empty($searchValue)) {
                                                                            if (strpos($resultValue, $searchValue) !== false) {
                                                                                $matchedData = true;
                                                                                $matchedValueCount++;
                                                                            }
                                                                        }
                                                                    }
                                                                }

                                                                if(!empty($getColumnsProperties[$sumLabel[$key]])){
                                                                    $result = DataTableHelper::ColumnProperties($result,$getColumnsProperties[$sumLabel[$key]]);
                                                                }
                                                                $value[$sumLabel[$key]] = $result;
                                                            } else {
                                                                $sumLabelkey = trim($sumLabel[$key]);
                                                                if(!empty($getColumnsProperties[$sumLabelkey])){
                                                                    $result = DataTableHelper::ColumnProperties($result,$getColumnsProperties[$sumLabelkey]);
                                                                }
                                                                
                                                                $value[$sumLabel[$key]] = $result;
                                                            }
                                                        }
                                                        else{

                                                           $value123 = str_replace('--', '+', $value123);
                                                           try{
                                                                @eval('$result = (' . @$value123 . ');');
                                                                //eval("\$result = $customSumData;");
                                                            }
                                                            catch(Exception $e){
                                                               $result = 0;
                                                            }
                                                            if (is_nan($result)) {
                                                                $result = 0;
                                                            } else if(is_infinite($result)) {
                                                                $result = 100;
                                                            }
                                                            if (!empty($searchValue) && !empty($searchValueArray)) {
                                                                $resultValue = strtolower($result);

                                                                if (!empty($resultValue)) {
                                                                    foreach ($searchValueArray as $searchValue) {
                                                                        if(isset($searchValue) && !empty($searchValue)) {
                                                                            if (strpos($resultValue, $searchValue) !== false) {
                                                                                $matchedData = true;
                                                                                $matchedValueCount++;
                                                                            }
                                                                        }
                                                                    }
                                                                }

                                                                if(!empty($getColumnsProperties[$sumLabel[$key]])){
                                                                    $result = DataTableHelper::ColumnProperties($result,$getColumnsProperties[$sumLabel[$key]]);
                                                                }

                                                                $value[$sumLabel[$key]] = $result;

                                                            } else {
                                                                if(!empty($getColumnsProperties[$sumLabel[$key]])){
                                                                    $result = DataTableHelper::ColumnProperties($result,$getColumnsProperties[$sumLabel[$key]]);
                                                                }

                                                                $value[$sumLabel[$key]] = $result;
                                                            }

                                                        }
                                                    }
                                            }
                                            }
                                }

                        }


                    }

                }
                
                // $value = array_values($value);
           
            if($_REQUEST['APIData']['showFocusPage'])
		      	 {
		      		if(isset($_REQUEST['APIData']['parameterFocusPage']) && !empty($_REQUEST['APIData']['parameterFocusPage'])){
			      		$var = explode('-', $_REQUEST['APIData']['parameterFocusPage']);
			      		$var = isset($var[1])?$var[1]:'';
			      		$var12 = trim($_REQUEST['APIData']['parameterFocusPage']);
			      		$value['detailUrl'] = baseUrl.$_REQUEST['APIData']['APIUrl'].'/getSpecficDetail?'.trim($var).'='.$value[$var12];

			      		//unset($value[$var12]);
		      		}
		      	}
                
                foreach ($value as $k => $v) {

                	$oldke = explode('-', $k);
                	$ke = isset($oldke[1])?trim($oldke[1]):trim($oldke[0]);
                    if(count($oldke) > 1){
                      if($value[$k]){
                          $value[$ke] = $v;
                      }
                      else{
                          $value[$ke] = "";
                      }
                      if($k != 'detailUrl'){
                      	 unset($value[$k]);
                      }
                    }
                    
                }
                
                $tableData['data'][] = $value;
            }

        }
       
        	
                if($getPlaceholderDetails[0]['ApiType'] == '2')
                {

                    $input = array();
                    $input = array_map("unserialize", array_unique(array_map("serialize", $newResArr1)));
                      
                    $input = array_values($input);
                 
                    // if(!empty($_REQUEST['APIData']['Fields'])){
                    //     $fields = $_REQUEST['APIData']['Fields'] ;
                    //     $fields = explode(',' , $fields);
                    //     foreach ($input as $key1 => $value1) {
                    //         $temp = [];
                    //         foreach($fields as $key => $value){

                    //             $value1[$value] = $value1[$key];
                    //             unset($value1[$key]);
                                
                    //         }
                    //         $input[$key1]= $value1;
                            
                    //     }
                        
                    // }     
                    $tableData['data'] =$input;
                    return $tableData;
                }else{

                     return $tableData;
                 }
                
                
                exit;
    }

    public static function searchArray(array $array, $search)
    {
        while ($array) {
            if (isset($array[$search])) return $array[$search];
            $segment = array_shift($array);
            if (is_array($segment)) {
                if ($return = Self::searchArray($segment, $search)) return $return;
            }
        }
        return false;
    }
     public function addforLoops( $value , $params , $count = 0  , $cntNew = 0 )
    {
        
       
        $res = $value[$params[$count]];
        if($count > $cntNew && $cntNew != 0)
        {
            $GLOBALS['flag1'] = $count;
            //$count = 0;
        }

        $cnt = count($params);
        $cntNew = 0;

        if( is_array($res) && !isset($res[0]) ){
            
            if( $count < $cnt-1){
                $cntNew = $count + 1;
              
            }

            Self::addforLoops($res , $params , $cntNew , $count );
        }
       
       else if( is_array($res) && count($res) >= 1){ 
            
           
           foreach ($res as $key => $val) {
                if( $count < $cnt-1){
                    $count = $count + 1;
                }

               
                Self::addforLoops($val , $params , $count );
                
                if( $GLOBALS['flag1'] )
                {
                   $count = $count - 1;
                }
                else{
                    $count = 0;
                }
                
           }
        }
        else

        {

            $GLOBALS['flag1'] = $count;
            if($res == '')
            {
                $res = 0;
            }
            
            array_push($GLOBALS['retVal'], $res);
        }

       return $GLOBALS['retVal'];
        
    }

    function array_flatten($array) { 
          $singleDimArray = [];

         foreach ($array as $item) {

        if (is_array($item)) {
            $singleDimArray = array_merge($singleDimArray, Self::array_flatten($item));

            } else {
                $singleDimArray[] = $item;
            }
        }

        return $singleDimArray;
    } 

    function cartesian($arr1, $arr2){
       
        $output = array();
        foreach ($arr1 as $key1 => $value1) {
           foreach($arr2 as $key2 => $value2){

                $temp = array($value1);
                array_push($temp, $value2);
                array_push($output, $temp);
           }
        }
        return $output;
    }
// Login Api 

    public function loginAction()
    {
        $ignoreIpArr = ['127.0.0.1', '81.233.130.113', '81.225.166.75']; 
        print_r($_SESSION); exit;
        if(isset($_SESSION['password']) && isset($_SESSION['username']))
        {
          	$userName = $_SESSION['username'];
            $password = $_SESSION['password'];
            $_REQUEST['username'] = $_SESSION['username'];
            $_REQUEST['password'] = $_SESSION['password'];

        }else{
          	
          	$userName = $_REQUEST['username'];
            $password = $_REQUEST['password'];
             $_SESSION['username'] = $userName ;
             $_SESSION['password'] =  $password;
            
            // $_SESSION['username'] = "buyer@babc.com" ;
            // $_SESSION['password'] = "babc";
           
        }
        if (isset($_REQUEST['username']) && isset($_REQUEST['password']) || (isset($_REQUEST['parentUsername']) && isset($_REQUEST['parentPassword']) && isset($_REQUEST['childAcc']))) {

            $userCount = [];
            if (isset($_REQUEST['username']) && isset($_REQUEST['password'])){
                    $userName = $_REQUEST['username'];
                    $password = $_REQUEST['password'];

			            // $userName = "buyer@babc.com" ;
			            // $password  = "babc";
                    $getUserDetails = User::verifyUser($userName, $password);
            
            }else if (isset($_REQUEST['parentUsername']) && isset($_REQUEST['parentPassword']) && isset($_REQUEST['childAcc']))
            {
                    $userName =  $_REQUEST['parentUsername'];
                    $password =  $_REQUEST['parentPassword'];
                   
                    $getUserDetails = User::verifyUser($userName, $password);
             
                    $AvailableUsers = explode(',' ,$getUserDetails[0]['AvailableUserGroup']);
                   
                    if($_REQUEST['childAcc'] != $getUserDetails[0]['UserEmail']){
                      if(empty($getUserDetails[0]['AllowParentDBParam'])){
                          $ParentDBParam = $getUserDetails[0]['DBParam'];
                      }
                      if(empty($getUserDetails[0]['AllowParentAPIParam'])){
                          $ParentAPIParam = $getUserDetails[0]['APIParam'];
                      }
                      if(in_array($_REQUEST['childAcc'], $AvailableUsers)){
                            $getUserDetails = User::verifyGroupUser($_REQUEST['childAcc']);
                        }
                    } 
            }            
            if (!$getUserDetails) {
                
                echo json_encode(array('errorMessage' => 'Invalid credentials')); exit();
            } else {

                
                $data = array();
                $currentDateValue = substr(date('Ymd'), 2);

                $data['AvailableUserGroup']=$getUserDetails[0]['AvailableUserGroup'];
                $data['username'] = $getUserDetails[0]['UserEmail'];
                $data['CompanyID'] = $getUserDetails[0]['CompanyID'];
                $data['DBParam'] = isset($ParentDBParam)?$ParentDBParam:$getUserDetails[0]['DBParam'];
              
                if(isset($ParentAPIParam))
                {
                  $APIdata1= $ParentAPIParam;
                  $APIdata1 = explode('|', $APIdata1);
                  foreach ($APIdata1 as $key1 => $value1) {
                      $keyVal =  explode(':', $value1);
                      $data[$keyVal[0]] = $keyVal[1];
                  }
                  
                }else
                {
                  $APIdata1= $getUserDetails[0]['APIParam'];
                  if(!empty($APIdata1)){
                    $APIdata1 = explode('|', $APIdata1);
                    foreach ($APIdata1 as $key1 => $value1) {
                        $keyVal =  explode(':', $value1);
                        $data[$keyVal[0]] = $keyVal[1];

                    }
                  }
                  
                  
                }
                $data['AuthorizationAPIkey'] = $getUserDetails[0]['Auth'];
                User::updateUserNowTime($getUserDetails[0]['UserID'],$currentDateValue);
                if(!in_array($_SERVER['REMOTE_ADDR'], $ignoreIpArr)){
                    User::updateUserLog($getUserDetails[0]);
                }
                $getCompanyDetails = Companies::getCompanyDetails($getUserDetails[0]['CompanyID']);
                if ($getCompanyDetails) {
                    $data['CompanyName'] = $getCompanyDetails[0]['CompanyName'];
                }
                
                echo json_encode(array('Data' => $data ,'successMessage' => 'Success Full login'));
                exit;
            }

        } else {
            echo json_encode(array('successMessage' => 'Invalid Credentials'));
            exit();
        }
    }

}

?>