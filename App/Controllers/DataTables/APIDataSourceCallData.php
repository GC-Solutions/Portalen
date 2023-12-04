<?php

namespace App\Controllers\DataTables;

use \Core\View;
use App\Models\Page;
use \App\Models\User;
use App\Models\Placeholder;
use App\Controllers\DataFormatHelper\DataTableHelper;
use App\Controllers\DataTables\DBDataSourceCallData;
use App\Controllers\DataTables\SourceType;
class APIDataSourceCallData extends \Core\Controller
{
    // (Start) this function makes the Curl Request for Api DataSource call . 
    public static function getAPIDataSourceCallData($getPlaceholderDetails , $getCompanyDetails , $getSourceType){
        //Variable Declaration 
        $header  = '' ;
        $companyAddress = $getCompanyDetails[0]['CompanyGISKey'];
        $companyToken = $getCompanyDetails[0]['CompanyGISToken'];
        $sumType = $getPlaceholderDetails[0]['SumType'];
        $requestType = $getPlaceholderDetails[0]['RequestType'];
        $requestUrl = str_replace("(address)", $companyAddress, $getSourceType);
        $gcsCustomer = str_replace("(token)", $companyToken, $requestUrl);
        $gcsCustomer = isset($_REQUEST['id'])?str_replace("(id)", $_REQUEST['id'], $gcsCustomer):$gcsCustomer;
        $gcsCustomer = isset($_REQUEST['email'])?str_replace("(email)", $_REQUEST['email'], $gcsCustomer):$gcsCustomer;
        $requestBody = SourceType::getSourceType($getPlaceholderDetails , 'body');
     	   
      
		if(isset($_SESSION['NotiCheck']) || ($getPlaceholderDetails[0]['AllowDynamicForm'] && !isset($_SESSION['TableValue']['LSearch']))){
			$bodyNew = json_decode($requestBody , true);
			$LogDate = '';
			if(isset($_SESSION['NotiCheck']) && isset($_SESSION['NotificationlogDate'])){
				$LogDate = $_SESSION['NotificationlogDate'];
			}else {
				$LogDate = $_SESSION['UserLastLogoutDate'];
			}
			foreach($bodyNew as $keyB => $valB){
				if($keyB == 'LogDateFrom'){
					$bodyNew[$keyB] = $LogDate;
				}
				elseif($keyB == 'LogDateTo'){
					$bodyNew[$keyB] = DATE('ymd') ;
 
				}
			}
			$requestBody = json_encode($bodyNew);
			
		}
       
        $FilterSession = !empty($getPlaceholderDetails[0]['FilterSessionEnable'])?trim($getPlaceholderDetails[0]['FilterSessionEnable']):0;
        // (Start)replace now time if its given in call Url .
        if (strpos($requestUrl, strtolower('(nowtime)')) !== false) {
            if(isset($_SESSION['NowTime'])){
                $gcsCustomer = str_replace("(nowtime)", $_SESSION['NowTime'], $gcsCustomer);
            }
        }   
        
        //(End)replace now time if its given in call Url .
        if (strpos($requestBody, strtolower('(nowtime)')) !== false) {
            if(isset($_SESSION['NowTime'])){
                $requestBody = str_replace("(nowtime)", $_SESSION['NowTime'], $requestBody);
            }
        } 
        
        // if(!isset($_SESSION['TableValue'])){
        //     // foreach($_SESSION['AllParameters'] as $key => $value){
        //     //     $requestBody = str_replace("(".$value['ParamName'].")", $value['ParamValue'], $requestBody);
        //     // }
            

            
        // }
       
        if(isset($_SESSION['TableValue']) && (isset($_SESSION['TableValue']['LSearch']) || $FilterSession == '1')){
            if(isset($_SESSION['TableValue']['LSearch'])){
                unset($_SESSION['TableValue']['LSearch']);
            }
           
            $bodyJson = json_decode($requestBody, true);
            
            if(isset($bodyJson['RunReport']['Dialogs'])){
                foreach($bodyJson['RunReport']['Dialogs'] as $JKey => $JVal){
                        $idName = $JVal['Id'];
                        $idName = str_replace(' ','_',$idName);
                       
                        if(array_key_exists($idName,$_SESSION['TableValue']) &&  !empty($_SESSION['TableValue'][$idName])){
                           
                            $bodyJson['RunReport']['Dialogs'][$JKey]['Value'] = trim($_SESSION['TableValue'][$idName]);
                        }
                }   
            }
            foreach($_SESSION['TableValue'] as $key => $value){
                $keyNew = str_replace('_' , ' ', $key);
                if(isset($bodyJson['RunReport'][$key]) ){
                    $bodyJson['RunReport'][$key] = trim($value);
                }elseif(isset($bodyJson['RunReport'][$keyNew])){
                    $bodyJson['RunReport'][$keyNew] = trim($value);
                }
               
            }

           
            if(isset($_SESSION['TableValue']['LogDateFrom'])){
                foreach($bodyJson as $keyB => $valB){
                    if($keyB == 'LogDateFrom' &&  $_SESSION['TableValue'][$keyB] != ''){
                        $bodyJson[$keyB] =  $_SESSION['TableValue'][$keyB] ;
                    }
                    elseif($keyB == 'LogDateTo' &&  $_SESSION['TableValue'][$keyB] != ''){
                        $bodyJson[$keyB] = $_SESSION['TableValue'][$keyB] ;
     
                    }
                }
            }
			
           
            $requestBody = json_encode($bodyJson); 
            //unset($_SESSION['TableValue']); 
        }
       
        // (Start ) If we need to call External Api Like fortnox or Monday then it comes in this condition .
        if($getPlaceholderDetails[0]['ExternalAPIReq'])
        {
          
            //(Start) to call an thrid person Api or an External Api we need to access it uername , 
            //password and all the required info then condition get all that info that being set at the admin side .
            if(isset($_SESSION['CompanyDBUserName']) && strpos($gcsCustomer, '(ExternalAddress)') !== false)
            {
                foreach($_SESSION['CompanyDBUserName'] as $k => $v){
                    if($_SESSION['CompanyDBPass'][$k][0] == $getPlaceholderDetails[0]['ExternalAPIReq'] ){
                        $header =  $_SESSION['CompanyDBUserName'][$k][$getPlaceholderDetails[0]['ExternalAPIReq']][0];
                        $header = explode('|', $header);
                    }
                }
            }
            $gcsCustomer = str_replace('(ExternalAddress)', $getPlaceholderDetails[0]['ExternalAPIReq'], $gcsCustomer);
        }else if(!empty($getPlaceholderDetails[0]['Headers'])) {
            
            if(substr_count($getPlaceholderDetails[0]['Headers'], ' ') === strlen($getPlaceholderDetails[0]['Headers'])){
                $header = '';
            }else{
                $header = array(($getPlaceholderDetails[0]['Headers']));
            } 
        }
       
        // (End) If we need to call External Api Like fortnox or Monday then it comes in this condition .
        // Replace the CustomerNo if it comes in body with the one given in Get request.
        if(isset( $_GET['CustomerNo'])){
            $requestBody = str_replace('(CustomerNo)','"'. $_GET['CustomerNo'].'"', $requestBody);
        }
        
        //print_r($requestBody); exit;
        //(Start) Curl Request for Api call data fetching.
        //Curl initalization 
        $ch = curl_init();
        // Curl Header call when Header is set .
        

        // if($header)
        // {
        //     curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
        // }else{
        //     curl_setopt($ch, CURLOPT_HEADER, false);
        // }  
        curl_setopt($ch, CURLOPT_NOBODY, false);
      
        curl_setopt($ch, CURLOPT_URL, $gcsCustomer); // Curl option for url setting 
       
        if ($requestType && $requestType == 2) {
            // Curl for post body 
            curl_setopt($ch, CURLOPT_POSTFIELDS, $requestBody);
            if($header)
            {
             
                curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
            }else{
               
                curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));
            }
            
        }
        // Curl option for time out
        curl_setopt($ch, CURLOPT_TIMEOUT, 6000000000);
        // curl option set to true for getting the result back .
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        //curl Execute 
        $results = curl_exec($ch);
        
        // return the curl Result .
        return $results;
       
    }
     // (End) this function makes the Curl Request for Api DataSource call . 


}
?>