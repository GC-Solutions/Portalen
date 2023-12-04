<?php

namespace App\Controllers\DataTables;

use \Core\View;
use App\Models\Page;
use \App\Models\User;
use \App\Models\Companies;
use App\Models\Placeholder;
use \App\Models\DataTableDesigns;
use App\Controllers\DataFormatHelper\DataTableHelper;
use App\Controllers\DataTables\DataTableJoinTable;
use App\Controllers\DataTables\GeneralDataTableFtn;

class GoogleCallData extends \Core\Controller
{
	public static function getGoogleCallData($flagGapi , $accessTokenGAPI , $requestGAPI , $requestBody , $accessRefreshTokenGAPI , $getCompanyDetails ){
	 	while ($flagGapi) {
			// (Start ) Curl Request
			
	        $ch = curl_init();
	        $header = array();
			// Setting Headers
	        $header[] = 'Content-type: application/json';
	        $header[] = 'Authorization:'.$accessTokenGAPI;
			
			// Setting Curl option for Url , body , header and return value .
	        curl_setopt($ch, CURLOPT_URL, $requestGAPI);
	        curl_setopt($ch, CURLOPT_POSTFIELDS, $requestBody);
	        curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
	        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	        $results = curl_exec($ch); // Execute Curl 
			// Close Curl 
	        curl_close($ch);
	        // (End ) Curl Request 
	        if ($results) {
	            $decodedResults = json_decode($results, true); // Json decode 
	        }
			
	        if(isset($decodedResults['error']) && ($decodedResults['error']['code'] == '401'))
	        {
				
				// (Start ) Curl Request 
	            $ch = curl_init();
	            // get File Data (Client Sercert )
				
	            $fileContent = file_get_contents('http://dev.babcportal.com/public/Test_Files/client_secret.json');
				$fileContent = json_decode($fileContent , true); 
				//$accessRefreshTokenGAPI = '1//0ceHoUN5u_Y7PCgYIARAAGAwSNwF-L9Ir3NtsUqjklW5b0b1YW5VYxvxIgZb2D70WcAqvFh3CLh_DMYT_LoXjT2V-Aw8NxyTja8M';
				$url = "https://accounts.google.com/o/oauth2/token"; // path for google Oauth 
				// Setting Curl option for Url , body , header and return value .
	            curl_setopt($ch, CURLOPT_URL,$url);
	            curl_setopt($ch, CURLOPT_POST, 1);
	            curl_setopt($ch, CURLOPT_POSTFIELDS,
	                        "client_id=".$fileContent['web']['client_id']."&client_secret=".$fileContent['web']['client_secret']."&grant_type=refresh_token&refresh_token=".$accessRefreshTokenGAPI);
	            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	            $results = curl_exec($ch); // Excute Curl 
	            $results =  json_decode($results, true); // json decode the data to array .
				
	            $resData =  array('companyId' => $getCompanyDetails[0]['CompanyID'] , 'accessToken' => $results, 'type' => 'Update'); 
				
				Companies::updateCompanyForGoogleApi($resData); 
	            curl_close($ch);// close Curl 
	            // (ENd) Curl Request 
				$ch = curl_init();
				$header = array();
				// Setting Headers
				$header[] = 'Content-type: application/json';
				$header[] = 'Authorization:'.$results['token_type'].' '.$results['access_token'];
				
				// Setting Curl option for Url , body , header and return value .
				curl_setopt($ch, CURLOPT_URL, $requestGAPI);
				curl_setopt($ch, CURLOPT_POSTFIELDS, $requestBody);
				curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
				curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
				$resul = curl_exec($ch); // Execute Curl 
				// Close Curl 
				curl_close($ch);
				// (End ) Curl Request 
				if ($resul) {
					$decodedResults = json_decode($resul, true); // Json decode 
				}
	        }
			// After Fecting the data processing to get the requried column values .
			$flagGapi = 0;
		
			
			$mainArrRes= array();
			if(isset($decodedResults['rows'])){
				$decodedResults =$decodedResults['rows'];
				foreach ($decodedResults as $decodedResultsKey => $decodedResultsValue) {
					$resultss = array();
					
					if($decodedResultsValue['dimensionValues'])
					{
					foreach ($decodedResultsValue['dimensionValues'] as $dimensionKey => $dimensionvalue) {
							array_push($resultss,$dimensionvalue['value'] );
						}
					}
					if($decodedResultsValue['metricValues'])
					{
					foreach ($decodedResultsValue['metricValues'] as $metricsKey => $metricsvalue) {
							array_push($resultss,$metricsvalue['value'] );
						}
					}
					
					$mainArrRes[] =$resultss;
			}
			}
			
	            
	        

	    }
	
	    return $tableData['data'] = $mainArrRes;
	}

}
?>