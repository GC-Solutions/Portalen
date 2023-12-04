<?php

namespace App\Controllers\DataTables;

use \Core\View;
use App\Models\Page;
use \App\Models\User;
use \App\Models\Companies;
use App\Models\Placeholder;
use \App\Models\DataTableDesigns;
use App\Controllers\DataTables\DataTableJoinTable;
use App\Controllers\DataTables\DBDataSourceCallRowCreation;
use App\Controllers\DataTables\APIDataSourceCallMultipleNode;
use App\Controllers\DataTables\SourceType;
use App\Controllers\DataTables\GoogleCallData;


/**
 * DataTables controller
 *
 * PHP version 7.0
 *
 This File contain Function that generate the datatable data .
 all the formating or any custom sum is performed over here . 
 this function get the data form google api , datatbase datasource call and API datasource call.
 apart from that if any action button is linked with the table this function create the URL and the name of the action button and attach it with the respective row .

 */

class DataTables extends \Core\Controller
{
    // GLobal Variable
    public $_arrayList = array('ResultList');
    public $retval = array();

    // Test FUnction
    public function test1($arr) {
        $temp = array();
        foreach ($arr as $obj) {
            $vals = array_values($obj);
            array_push($temp,$vals);
        }
        return $temp;
    }

    // Main table for generation of dataTables 
    // This function contain the code if we want to access the DB or Api Datasouce .
    // Get the data for google too.

    static public function generateTableAction()
    {
         // Set the number of seconds a script is allowed to run to infinity 
        set_time_limit(0);
        // Memory Limit for the script 
        ini_set('memory_limit', '2G');
        $getCompanyDetails = Companies::getCompaniesDetails($_SESSION['UserID']); // getting  user Company Info 
        //Variable Declaration  
        
        $placeholderId = (isset($_REQUEST['placeholderId'])) ? $_REQUEST['placeholderId'] : "";
        $pHolderId = (isset($_REQUEST['pholderid'])) ? $_REQUEST['pholderid'] : "";
        $pagePlacholder = explode('&' , $_SERVER['REQUEST_URI'] );
        $pagePlacholder = explode('id=' , $pagePlacholder[0]);
       // $userPagePlaceholder = (isset($_REQUEST['id'])) ? $_REQUEST['id'] : "";
        $userPagePlaceholder = (isset($pagePlacholder[1])) ? $pagePlacholder[1] : "";
        $pholderId = (isset($_REQUEST['pholderid'])) ? $_REQUEST['pholderid'] : "";
        $searchValue = (isset($_REQUEST['searchvalue'])) ? json_decode($_REQUEST['searchvalue']) : "";
        $silderActionId = (isset($_REQUEST['silderActionId'])) ? json_decode($_REQUEST['silderActionId']) : "";

          if(isset($_SESSION['DeleteRedis'] ) && isset($_SESSION['RedisplaceholderId'])&& isset($_SESSION['RedisId'])){
           $placeholderId =  isset($_SESSION['RedisplaceholderId']) ? $_SESSION['RedisplaceholderId']: $_REQUEST['placeholderId'];
           $userPagePlaceholder  =  $_SESSION['RedisId'];
           $keyName = $_SESSION['CompanyID'] .'-'.$_SESSION['ParentUserID'] .'-'.$placeholderId;
		   $GLOBALS['redisClient']->del($keyName);
           unset($_SESSION['RedisId']);
           unset($_SESSION['RedisplaceholderId'])  ;
		     $GLOBALS['redisClient']->hset($keyName."-Lock",$keyName."-Lock", $keyName."-Lock" );
           $GLOBALS['redisClient']->expire($keyName."-Lock", 200);
		              if($keyName=="1039-3262-1824") {
            $GLOBALS['redisClient']->hset("1039-3262-1837-Lock","1039-3262-1837-Lock", "1039-3262-1837-Lock" );
            $GLOBALS['redisClient']->expire("1039-3262-1837-Lock", 200);
           }
            
        }
		
      
        $getDatatableDetails = "";
        $searchValueCount = '';
        $getPlaceholderDetails1 = '';
        $actationTableColumn  = array();
        $fileName = '';
        $fileData = '';
        $RedisCheckData  = 1;

        if($searchValue) {
            $searchValue = (array)$searchValue[0];
            $searchValueCount = count($searchValue);
        }
        // Get table Placeholder Detail
        if (!empty($pholderId)) {
            $getDatatableDetails = Page::getDatasourceTableDetails($pholderId);
        }
      
        $getPlaceholderDetails1 = Page::getDatasourceTableDetails($placeholderId);
        
		$server =  $_SERVER['DOCUMENT_ROOT'];
		$jsonServer  = $server.'/BabcPortal_Other_Assests/BabcPortal/jsonData/';
        $server = $server.'/BabcPortal_Other_Assests/BabcPortal/Reports/';
        $localhost = '/Applications/MAMP/htdocs/reports/';
        
        $CompanyDir =  $server.trim($_SESSION['CompanyName']).'/';
        $CompanyUserDir =  $server.trim($_SESSION['CompanyName']).'/'.$_SESSION['UserFirstName'].'/';
		
		$jsonCompanyDir =  $jsonServer.trim($_SESSION['CompanyName']).'/';
        $UserName  =  isset($_SESSION['ParentUserFirstName'])?$_SESSION['ParentUserFirstName']:$_SESSION['UserFirstName'];
        $jsonCompanyUserDir =  $jsonServer.trim($_SESSION['CompanyName']).'/'.$UserName.'/';
    
        $file = $placeholderId.'_'.$getPlaceholderDetails1[0]['Descriptions'];
        $fileName = $CompanyUserDir.$file.'.txt';
		$fileNameJson = $jsonCompanyUserDir.$file.'.txt';
        $fileNameSearch = $CompanyUserDir.$file.'Search.txt';
		
        if ($getPlaceholderDetails1[0]['AllowJsonSave'] == '1' && empty($getPlaceholderDetails1[0]['EnableCacheTable']) && file_exists($fileNameJson)) {
            $fileData = file_get_contents($fileNameJson);
            if(!empty($fileData)){
                echo $fileData;
                exit;
            }
        }
		
       
        if($getPlaceholderDetails1[0]['DisableReports']){
            $RedisCheckData  = 0;
        }else if((isset($_SESSION['NoRedisFoucus']) && $_SESSION['NoRedisFoucus'] = 1) || isset($_REQUEST['focusPage']) ){
			if(isset($_SESSION['NoRedisFoucus'])){
				unset($_SESSION['NoRedisFoucus']);
			}
            $RedisCheckData  = 0;	
        }
        else if(!empty($_SESSION['DisableAPIDataRedisUser']) && ($getPlaceholderDetails1[0]['RequestType'] != '3' || $getPlaceholderDetails1[0]['RequestType'] != '4' )){
           
            $RedisCheckData  = 0;
        }
        else if(!empty($_SESSION['TableSelection'])){
            if(!empty($getPlaceholderDetails1[0]['EnableCacheTable'])){
                $RedisCheckData  = 1;
               
            }else{
                $RedisCheckData  = 0;
            }
        }else{
            $RedisCheckData  = 1;
        }
       
        if(isset($_SESSION['CacheUser']) && $RedisCheckData){
                
			$Uid = isset($_SESSION['ParentUserID'])?$_SESSION['ParentUserID'].$_SESSION['username']:$_SESSION['UserID'];
			//print_r($Uid); exit;
            $keyName = $_SESSION['CompanyID'] .'-'.$_SESSION['ParentUserID'] .'-'.$placeholderId;

            $RedisCheck =  $GLOBALS['redisClient']->exists([$Uid ,$keyName]) ;
			
            $keyNameNew = $_SESSION['CompanyID'] .'-'.$_SESSION['ParentUserID']  .'-'.$placeholderId;
			
            $RedisCheckNew =  $GLOBALS['redisClient']->exists([$keyName ,$keyName]) ;

			//print_r($Uid ); exit;
            //$_SESSION['DeleteRedis'] = 1;
            $unsetRedisNew = false;
            $unsetRedis = false;
            if(isset($_SESSION['DeleteRedis']) && $RedisCheckNew  === 1){
               
                $GLOBALS['redisClient']->del($keyName);
                $unsetRedisNew = true;


          
            }
            if(isset($_SESSION['DeleteRedis']) && $RedisCheck  === 1){
               
                $GLOBALS['redisClient']->hdel($Uid, $keyName);
                $unsetRedis = true;
         
            }

            if($unsetRedis || $unsetRedisNew) {
                unset($_SESSION['DeleteRedis']);
            }
            else if(true) {
                $RedisValue  = $GLOBALS['redisClient']->hget($keyName ,$keyName);
				
                if($RedisValue != ''){
                    echo $RedisValue ;
                    exit;
                }
            }
            else if($RedisCheck  === 1){
                
                $RedisValue  = $GLOBALS['redisClient']->hget($Uid ,$keyName);
				
                if($RedisValue != ''){
                   echo $RedisValue ;
                   exit;
                }
              
            }
        }
		//print_r($GLOBALS['redisClient']->exists(['3160ledning@tbo.eu' ,'1015-3160ledning@tbo.eu-1676']));
			//print_r($RedisCheck  );
            //print_r($keyName); exit;
        $FilterSession = !empty($getPlaceholderDetails1[0]['FilterSessionEnable'])?trim($getPlaceholderDetails1[0]['FilterSessionEnable']):0;
        
        
        $logData = '0';
        if($_SESSION['LoggedIn'] == 1){
            $logData = '1'; 
        }else{
            $logData = '0' ;
        }
        
        if( $getPlaceholderDetails1[0]['EnableTxtFile'] == '1' && ($getPlaceholderDetails1[0]['ReportOnLoad'] == 0 ) &&  $_SESSION['LoggedIn'] == 1){
                
            $_SESSION['LoggedIn'] = 0;
            if(is_dir($CompanyUserDir)){
                if (is_file($fileName)){
                    unlink($fileName) ;
                }
                //array_map('unlink', glob("$CompanyUserDir/*.*"));
                //rmdir($CompanyUserDir);
            }
            
                
            
        }else if ( $getPlaceholderDetails1[0]['EnableTxtFile'] == '1' && $getPlaceholderDetails1[0]['ReportOnLoad'] == 1 &&  $_SESSION['LoggedIn'] == 1){
            $_SESSION['LoggedIn'] = 0;
            
            if(file_exists($fileName)){
                $fileData = file_get_contents($fileName);
            }
            
            if($FilterSession == 1){
                if(file_exists($fileNameSearch)){
                    $fileDataSearch = file_get_contents($fileNameSearch);
                
               
                    if($fileDataSearch != ''){
                        $_SESSION[$placeholderId.'_orgData'] = $fileDataSearch;
                    }
                 }
            }
           
           
            if(!empty($fileData)){
                echo $fileData;
                exit;
            }
        }

        
        if($FilterSession == 1 ||  $getPlaceholderDetails1[0]['EnableTxtFile'] == '1'){

           
            // if(isset( $_SESSION[$placeholderId.'_orgData']) &&  $_SESSION[$placeholderId.'_orgData'] != 'noData'){
            //     // if(file_exists($fileName) !== false && $getPlaceholderDetails1[0]['EnableTxtFile'] == '1' ){
                       
            //     //     $fileData = file_get_contents($fileName);
            //     //     if(!empty($fileData)){
            //     //         unset($_SESSION['backBtn0']);
            //     //         echo $fileData;
            //     //         exit;
            //     //     }
        
            //     // }else{
                   
            //         $_SESSION['Allowfetchdata'] = 1;
            //     //}
               
            // }
            // else
           
             if(isset($_SESSION['BackbtnCheck'])){
                $text = explode('page_text=' , $_SESSION['backBtn0']);
                $text = $text[1];
                $text = str_replace('%20', ' ', $text);
               
                if(trim($text) == trim($_SESSION['currentPageName1'])){
                   
                    if( isset($_SESSION['Allowfetchdata']) &&  $_SESSION['Allowfetchdata'] != 1 && file_exists($fileName) !== false && $getPlaceholderDetails1[0]['EnableTxtFile'] == '1' ){
                      
                        
                        if(isset($_SESSION[$placeholderId.'_orgData']) &&  $_SESSION[$placeholderId.'_orgData'] != 'noData'){
                            if($getPlaceholderDetails1[0]['ReportOnLoad'] == 1 && $FilterSession == 1){
                               
                                    $resSearch = $_SESSION[$placeholderId.'_orgData'];
                                    file_put_contents($fileNameSearch, $resSearch );
                            }
                        }else if(isset($_SESSION[$placeholderId.'_orgData']) &&  $_SESSION[$placeholderId.'_orgData'] == 'noData') {
                            if($getPlaceholderDetails1[0]['ReportOnLoad'] == 1 && $FilterSession == 1){
                                $resSearch = '';
                                file_put_contents($fileNameSearch, $resSearch );
                            }
                        }
                        
                        if($FilterSession == 1){
                            $fileDataSearch = '';
                            if(file_exists($fileNameSearch)){
                                $fileDataSearch = file_get_contents($fileNameSearch);
                            }
                            
                            if($fileDataSearch != ''){
                                $_SESSION[$placeholderId.'_orgData'] = $fileDataSearch;
                            }
                        }
                        $fileData = file_get_contents($fileName);
                        if(!empty($fileData)){
                            unset($_SESSION['BackbtnCheck']);
                           
                            echo $fileData;
                            exit;
                        }
            
                    }else{
                       
                            $_SESSION['Allowfetchdata'] = 1;
                            unset($_SESSION['BackbtnCheck']);
                            
                        
                    }
                }
                
            }else if( (!isset($_SESSION['Allowfetchdata'] ) || $_SESSION['Allowfetchdata'] == 0) &&  $getPlaceholderDetails1[0]['EnableTxtFile'] == '1' && $getPlaceholderDetails1[0]['ReportOnLoad'] == 1){
                
                
                if(isset($_SESSION[$placeholderId.'_orgData']) &&  $_SESSION[$placeholderId.'_orgData'] != 'noData'){
                    if($getPlaceholderDetails1[0]['ReportOnLoad'] == 1 && $FilterSession == 1 && file_exists($fileNameSearch)){
                       
                            $resSearch = $_SESSION[$placeholderId.'_orgData'];
                            file_put_contents($fileNameSearch, $resSearch );
                    }
                }else if(isset($_SESSION[$placeholderId.'_orgData']) &&  $_SESSION[$placeholderId.'_orgData'] == 'noData' && $logData == 0) {
                    if($getPlaceholderDetails1[0]['ReportOnLoad'] == 1 && $FilterSession == 1 && file_exists($fileNameSearch)){
                        $resSearch = '';
                        file_put_contents($fileNameSearch, $resSearch );
                    }
                }
                
                if( $FilterSession == 1 &&  file_exists($fileNameSearch)){
                    $fileDataSearch = file_get_contents($fileNameSearch);
                
                    if($fileDataSearch != ''){
                        $_SESSION[$placeholderId.'_orgData'] = $fileDataSearch;
                    }
                }
                
                if(file_exists($fileName)){
                    $fileData = file_get_contents($fileName);
                }
                if(!empty($fileData)){
                    echo $fileData;
                    exit;
                }
            }
        }
       
        if( isset($_SESSION['Allowfetchdata']) &&   $getPlaceholderDetails1[0]['EnableTxtFile'] == 1){
            
            if( is_dir($CompanyDir) === false )
            {
                
                    mkdir($CompanyDir , 0777);
            }
            if(is_dir($CompanyUserDir) === false){
                mkdir($CompanyUserDir , 0777);
            }
            $fp = fopen( $fileName, 'wb');
            if($getPlaceholderDetails1[0]['ReportOnLoad'] == 1 && $FilterSession == 1){
                $fp = fopen( $fileNameSearch, 'wb');
            }
        }
        // else if(file_exists($fileName) !== false ){
            
        //     $fileData = file_get_contents($fileName);
        //     if(!empty($fileData)){
        //         echo $fileData;
        //         exit;
        //     }

        // }
        
        //$getPlaceholderDetails1[0]['LiveReportSync'] = 0;
        if(empty($getPlaceholderDetails1[0]['ReportOnLoad'])){
            $getPlaceholderDetails1[0]['LiveReportSync'] = 0;
        }
    
        if( $getPlaceholderDetails1[0]['LiveReportSync'] != 1 || $getPlaceholderDetails1[0]['LiveSyncOnLoad'] == 1 || (isset($_SESSION['Allowfetchdata']) &&  $_SESSION['Allowfetchdata'] == 1)){
            
            //$_SESSION['Allowfetchdata']=0;
            if($getPlaceholderDetails1[0]['EnableChildRowsRunTym']){
                $getChilRowDetails = Page::getChildRow($placeholderId);
            }
          
            //(Start) Condition if Join Table id Selected .
            if($getPlaceholderDetails1[0]['ColumnsMatching'])
            {
                DataTableJoinTable::generateJoinTableAction();
                exit;
            }
            //(End) Condition if Join Table id Selected .
            // Get table Action Detail
            
            $getTableActionDetails = Page::getTableActionDetails($userPagePlaceholder);
          
            $tableActions = array();
           
            //(Start) processing for Action Button 
            if ($getTableActionDetails || $silderActionId) {
                
                if($silderActionId){
                    $getTableActionIds = $silderActionId;
                }else{
                    $getTableActionIds = (isset($getTableActionDetails[0]['PlaceholderActionIds'])) ? $getTableActionDetails[0]['PlaceholderActionIds'] : "";
              
                }
                
                if ($getTableActionIds) {
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
            //(End) processing for Action Button 
            $getPlaceholderDetailsColumnProperties  = array();
            //(Start)if we have fetched data for placeholder
            if(count($getPlaceholderDetails1) >= 1)
            {
                $flagholder = 0 ;
                foreach ($getPlaceholderDetails1 as $ke => $valueee) {
                    // Variable Declaration
                    $requestUrl = '';
                    $requestType = '';
                    $requestBody = '';
                    $requestGAPI = '';
                    $accessTokenGAPI = '';
                    $accessRefreshTokenGAPI = '';
                    $displayDetailButton = false;
                    $customSumData = '';
                    $customSumDataArr = array();
                    $explodeColumns = '';
                    $columnsList = array();
                    $getPlaceholderDetails[0] = $valueee;    
                    //(Start) if their is any detail of placeholder 
                    if ($getPlaceholderDetails) {
                        // get Source type from Source type File . 
                        $getSourceType = SourceType::getSourceType($getPlaceholderDetails , 'address');
						$oldSourceType = SourceType::getSourceType($getPlaceholderDetails , 'address');
                        //Variable Declaration and intialization 
                        $sumColumnLable = $getPlaceholderDetails[0]['SumColumnLable'];
                        $keyColumnName = $getPlaceholderDetails[0]['KeyColumn'];
                        $customSumFormula = $getPlaceholderDetails[0]['CustomSumFormula'];
                        $companyAddress = $getCompanyDetails[0]['CompanyGISKey'];
                        $companyToken = $getCompanyDetails[0]['CompanyGISToken'];
                        $requestType = $getPlaceholderDetails[0]['RequestType'];
                        $requestBody = $getPlaceholderDetails[0]['Body'];
                        $requestGAPI = $getPlaceholderDetails[0]['SourceAddress'];
                        $accessTokenGAPI =  $getCompanyDetails[0]['GoogleAccessToken'];
                        $accessRefreshTokenGAPI =  $getCompanyDetails[0]['GoogleAccessRefreshToken'];
                        $sumType = $getPlaceholderDetails[0]['SumType'];
                        // getting Column Name .  will get the Columns in case of multiple Node .
                        if($getPlaceholderDetails[0]['ApiType'] == '2')
                        {
                            $getColumnsList = $getPlaceholderDetails[0]['Columns'];
                        }else{
                            $getColumnsList = $getPlaceholderDetails[0]['tableColumns'];
                            
                        } 
						
						
                        // (Start) if we got the Column Name 
                        $newExplodeColumns = array();
                        if (isset($getColumnsList)) {
                            $explodeColumns = explode(',', $getColumnsList);
                        
                            $explodeColumns = array_combine($explodeColumns,$explodeColumns);
                            $columnsList = explode(',', $getColumnsList);
                            $getColumnsProperties = $getPlaceholderDetails[0]['ColumnsProperties'];

                            if (isset($getColumnsProperties)) {
                                $getColumnsProperties = json_decode($getColumnsProperties, true);

                                if(!empty($getPlaceholderDetailsColumnProperties)){

                                    $getPlaceholderDetailsColumnProperties = array_merge($getPlaceholderDetailsColumnProperties, $getColumnsProperties);
                                
                                }else{
                                    $getPlaceholderDetailsColumnProperties = $getColumnsProperties;
                                }
                                $getColumnsProperties = array_replace(array_flip($explodeColumns), $getColumnsProperties);
                                unset($explodeColumns);
                                foreach($getColumnsProperties as $key => $value) {
                                    if(in_array($key, $columnsList)) {
                                        $explodeColumns[$key] = $value;
                                    }
                                }
                            }
                        }
                        // (End) if we got the Column Name 
                        // replace now time with actual time in body and url.
                        if (strpos($requestBody, strtolower('(nowtime)')) !== false) {
                            if(isset($_SESSION['NowTime'])){
                                $requestBody = str_replace("(nowtime)", $_SESSION['NowTime'], $requestBody);
                            }
                        }
                        if (strpos($requestUrl, strtolower('(nowtime)')) !== false) {
                            if(isset($_SESSION['NowTime'])){
                                $requestUrl = str_replace("(nowtime)", $_SESSION['NowTime'], $requestUrl);
                            }
                        }
                        //Getting Placeholder Name 
                        $getPlaceholderColumn = trim($getPlaceholderDetails[0]['Placeholder']);
                        if ($getPlaceholderColumn) {
                            $getRequestData = (isset($_REQUEST[$getPlaceholderColumn])) ? $_REQUEST[$getPlaceholderColumn] : "";

                            if ($getRequestData) {
                                $requestBody = str_replace("(" . $getPlaceholderColumn . ")", $getRequestData, $requestBody);
                            }
                        }
                        //Getting the Request Url 
                        $requestUrl = str_replace("(address)", $companyAddress, $getSourceType);
                        $requestUrl = str_replace("(token)", $companyToken, $requestUrl);
                        $filterion = false;
                        
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
                    //(End) if their is any detail of placeholder
                    //(Start) Fetching  data from  Google Api   
                  
                    if ($requestType == 4) {
                        if($accessTokenGAPI){
                            $flagGapi = 1;
                            $tableData['data']  = GoogleCallData::getGoogleCallData($flagGapi , $accessTokenGAPI , $requestGAPI , $requestBody , $accessRefreshTokenGAPI , $getCompanyDetails  ); 
                           
                        }
                    }
                    //(End) Fetching  data from  Google Api  
                    //(Start) Fetching Data  from Data Source Call DB 
                 
                    else if ($requestType == 3) {
						 $R3keyName = $_SESSION['CompanyID'] .'-'.$_SESSION['ParentUserID'] .'-'.$placeholderId;
						
                        $tableData = $GLOBALS['redisClient']->hget($R3keyName ,$R3keyName);
						 $tableData = json_decode($tableData, JSON_UNESCAPED_SLASHES);

                        if(empty($tableData)) {
                        $tableData = DBDataSourceCallRowCreation::getDBDataSourceCallRowCreation( $getPlaceholderDetails , $getCompanyDetails, $getSourceType ,  $tableActions , $getColumnsList , $explodeColumns ,
                            $keyColumnName , $searchValue , $actationTableColumn , $filterion , $getColumnsProperties , $oldSourceType);
                        }
								
        //                $tableData = DBDataSourceCallRowCreation::getDBDataSourceCallRowCreation( $getPlaceholderDetails , //$getCompanyDetails, $getSourceType ,  $tableActions , $getColumnsList , $explodeColumns ,
     //                       $keyColumnName , $searchValue , $actationTableColumn , $filterion , $getColumnsProperties , $oldSourceType);
                        if(empty($tableData))
                        {
                            $tableData['data'] = [];
                        }
                        //print_r($tableData); exit; 
                    } 
                    //(ENd) Fetching Data  from Data Source Call DB 
                    //(Start) Fetching Data  from Data Source Call Api  
                    else {
                        
						if($companyAddress == '123'){
							$tableData['data'] = [];
						}else {
							if(isset($getPlaceholderDetails) && $getPlaceholderDetails[0]['ApiType'] == '2')
							{

								$tableData = APIDataSourceCallMultipleNode::getAPIDataSourceCallMultipleNode($getPlaceholderDetails , $getCompanyDetails , $getSourceType, $requestUrl , $customSumFormula , $explodeColumns , $getColumnsList , $sumColumnLable , $sumType , $keyColumnName , $tableActions , $filterion ,  $actationTableColumn , $getColumnsProperties , $placeholderId , $userPagePlaceholder); 
							}else{

								$tableData = APIDataSourceCallSingleNode::getAPIDataSourceCallSingleNode($getPlaceholderDetails , $getCompanyDetails , $getSourceType, $requestUrl , $customSumFormula , $explodeColumns , $getColumnsList , $sumColumnLable , $sumType , $keyColumnName , $tableActions , $filterion , $actationTableColumn , $getColumnsProperties , $placeholderId , $userPagePlaceholder ); 
							}
						}
                        
                    }
                    //(End) Fetching Data  from Data Source Call Api
                }
            }

            if (isset($getColumnsList)) {
						  
                $explodeColumns = explode(',', $getColumnsList);
				
                if($explodeColumns[0] == 'checkbox' || $explodeColumns[0] == 'box' ) {

                    for ($new=0; $new < count($tableData['data']) ; $new++) { 
                        $tableData['data'][$new][0] = $new+1;
                    }
                } else {							 
										                        $GLOBALS['redisClient']->hset('entered','entered',  json_encode($tableData) );

                    for ($new=0; $new < count($tableData['data']) ; $new++) { 
                      //  $tableData['data'][$new][0] = $new;                    
                	}
															                        $GLOBALS['redisClient']->hset('entered2','entered2',  json_encode($tableData) );

				}
            }
                         
        //(End)if we have fetched data for placeholder
        //Condition to be exceuted in case of Multiple Node .
        if(isset($_REQUEST['ticket_id']))
        {
			
            return $tableData;
        }else{
            if(isset($getPlaceholderDetails) && $getPlaceholderDetails[0]['ApiType'] == '2')
            {
                $input = array();
                $input = array_map("unserialize", array_unique(array_map("serialize", $tableData)));
                unset($tableData);
                $tableData['data'] = array_values($input);
                $tableData['data'] = array_values($input);
                foreach ($tableData['data'] as $key => $value) {
                    foreach ($value as $ke => $val) {
                        if(empty($val))
                        {
                        $tableData['data'][$key][$ke ] = '';
                        }
                    }
                }
                if(file_exists($fileName) !== false && $getPlaceholderDetails1[0]['EnableTxtFile'] == '1' ){
                    $res = json_encode($tableData, JSON_UNESCAPED_SLASHES);
                    file_put_contents($fileName, $res );
                    if(isset($_SESSION[$placeholderId.'_orgData']) &&  $_SESSION[$placeholderId.'_orgData'] != 'noData'){
                        if($getPlaceholderDetails1[0]['ReportOnLoad'] == 1 && $FilterSession == 1){
                                $resSearch = $_SESSION[$placeholderId.'_orgData'];
                                file_put_contents($fileNameSearch, $resSearch );
                        }
                    }
                    
                }
                echo json_encode($tableData, JSON_UNESCAPED_SLASHES);
            }else{
                if(file_exists($fileName) !== false && $getPlaceholderDetails1[0]['EnableTxtFile'] == '1' ){
                    if(!empty($tableData['data'])){
                        $res = json_encode($tableData, JSON_UNESCAPED_SLASHES);
                        file_put_contents($fileName, $res );
                    }
                    if(isset($_SESSION[$placeholderId.'_orgData']) &&  $_SESSION[$placeholderId.'_orgData'] != 'noData'){
                        if($getPlaceholderDetails1[0]['ReportOnLoad'] == 1 && $FilterSession == 1){
                                $resSearch = $_SESSION[$placeholderId.'_orgData'];
                                file_put_contents($fileNameSearch, $resSearch );
                        }
                    }else if(isset($_SESSION[$placeholderId.'_orgData']) &&  $_SESSION[$placeholderId.'_orgData'] == 'noData') {
                        if($getPlaceholderDetails1[0]['ReportOnLoad'] == 1 && $FilterSession == 1){
                            $resSearch = '';
                            file_put_contents($fileNameSearch, $resSearch ); }
                    }

                }
                if($fileData){
                    echo $fileData;
                }else{
                    if(isset($_SESSION['CacheUser']) &&  $RedisCheckData){
                        $Uid = isset($_SESSION['ParentUserID'])?$_SESSION['ParentUserID'].$_SESSION['username']:$_SESSION['UserID'];
                        $keyName = $_SESSION['CompanyID'] .'-'.$_SESSION['ParentUserID'] .'-'.$placeholderId;
                        $keyNameNew = $_SESSION['CompanyID'] .'-'.$_SESSION['ParentUserID']  .'-'.$placeholderId;
                        $NewData = json_encode($tableData, JSON_UNESCAPED_SLASHES);

                        $TTL = intval($getPlaceholderDetails1[0]['TimeDurationRedisTable'])*60;
                        if (isset($TTL) && $TTL !== 0) {
   
                        } else {
                        $TTL = 600;
                        }
                         $GLOBALS['redisClient']->hset($keyName,$keyName, $NewData );
                         $GLOBALS['redisClient']->expire($keyName, $TTL);

                        $GLOBALS['redisClient']->hset($Uid,$keyName,  $NewData );
                        $GLOBALS['redisClient']->expire($Uid, $TTL+200);

                    }
                    echo json_encode($tableData, JSON_UNESCAPED_SLASHES);
                }
            }
        }
    }else{
       
        $tableData['data'] = [];
        if(isset($_REQUEST['ticket_id']))
        {
            return $tableData;
        }else{
            if(file_exists($fileName) !== false && $getPlaceholderDetails1[0]['EnableTxtFile'] == '1' ){
                if(!empty($tableData['data'])){
                    $res = json_encode($tableData, JSON_UNESCAPED_SLASHES);
                    file_put_contents($fileName, $res );
                }
                if(isset($_SESSION[$placeholderId.'_orgData']) &&  $_SESSION[$placeholderId.'_orgData'] != 'noData'){
                        if($getPlaceholderDetails1[0]['ReportOnLoad'] == 1 && $FilterSession == 1){
                           
                                $resSearch = $_SESSION[$placeholderId.'_orgData'];
                                file_put_contents($fileNameSearch, $resSearch );
                        }
                }else if(isset($_SESSION[$placeholderId.'_orgData']) &&  $_SESSION[$placeholderId.'_orgData'] == 'noData') {
                    if($getPlaceholderDetails1[0]['ReportOnLoad'] == 1 && $FilterSession == 1){
                        $resSearch = '';
                        file_put_contents($fileNameSearch, $resSearch ); }
                    }
            }
            if($fileData){
                echo $fileData;
            }else{
                if(isset($_SESSION['CacheUser']) &&  $RedisCheckData){
                    $Uid = isset($_SESSION['ParentUserID'])?$_SESSION['ParentUserID'].$_SESSION['username']:$_SESSION['UserID'];
                    $keyName = $_SESSION['CompanyID'] .'-'.$_SESSION['ParentUserID'] .'-'.$placeholderId;
                    $keyNameNew = $_SESSION['CompanyID'] .'-'.$_SESSION['ParentUserID']  .'-'.$placeholderId;
                    $NewData = json_encode($tableData, JSON_UNESCAPED_SLASHES);

                    $TTL = intval($getPlaceholderDetails1[0]['TimeDurationRedisTable'])*60;
                    if (isset($TTL) && $TTL !== 0) {

                    } else {
                    $TTL = 600;
                    }
                     $GLOBALS['redisClient']->hset($keyName,$keyName, $NewData );
                     $GLOBALS['redisClient']->expire($keyName, $TTL);

                    $GLOBALS['redisClient']->hset($Uid,$keyName,  $NewData );
                     $GLOBALS['redisClient']->expire($Uid, $TTL+100);

                }
                echo json_encode($tableData, JSON_UNESCAPED_SLASHES);
            }
        }
        
       
    }
        
        exit;
    }


}