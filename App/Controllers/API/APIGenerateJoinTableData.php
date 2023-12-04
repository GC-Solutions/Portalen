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

/**
 * APIGenerateTableData controller
 *
 * PHP version 7.0
 */

// Need to separate that code .

// This file conatin all the FUnction for gererating the API data .
// The main function allow to create (GET , POST , PUT ) requests .
 
class APIGenerateJoinTableData extends \Core\Controller
{
static public function generateJoinTableAction()
    {
        
         // get company detail
        $getCompanyDetails = Companies::getCompaniesDetails($_SESSION['UserID']);
         
        if ($getCompanyDetails) {
                    $_SESSION['CompanyName'] = $getCompanyDetails[0]['CompanyName'];
                    if(!empty($getCompanyDetails[0]['CompanyDBPass']))
                    {
                        $getCompanyDetails[0]['CompanyDBPass'] = json_decode( $getCompanyDetails[0]['CompanyDBPass'] , true);
                        $getCompanyDetails[0]['CompanyDBUserName'] = json_decode( $getCompanyDetails[0]['CompanyDBUserName'] , true);

                        foreach ($getCompanyDetails[0]['CompanyDBUserName'] as $key => $value) {

                              
                            $getCompanyDetails[0]['CompanyDBUserName'][$key][$getCompanyDetails[0]['CompanyDBPass'][$key][0]] = $value;
                            unset( $getCompanyDetails[0]['CompanyDBUserName'][$key][0]);
                        }
                        $_SESSION['CompanyDBPass'] = $getCompanyDetails[0]['CompanyDBPass'];
                    
                        $_SESSION['CompanyDBUserName'] = $getCompanyDetails[0]['CompanyDBUserName'];
                        $_SESSION['AdminDb'] = json_decode($getCompanyDetails[0]['AdminDb'] , true);
                    
                    }
                    
                    if(!empty($getCompanyDetails[0]['CompanyHostName'])){
                        $getCompanyDetails[0]['CompanyHostName'] = json_decode( $getCompanyDetails[0]['CompanyHostName'] , true);
                        $getCompanyDetails[0]['DBType'] = json_decode( $getCompanyDetails[0]['DBType'] , true);

                        foreach ($getCompanyDetails[0]['CompanyHostName'] as $key => $value) {

                              
                            $getCompanyDetails[0]['CompanyHostName'][$key][$getCompanyDetails[0]['DBType'][$key][0]] = $value;
                            unset( $getCompanyDetails[0]['CompanyHostName'][$key][0]);
                        }
                        $_SESSION['DBType'] = $getCompanyDetails[0]['DBType'];
                    
                         $_SESSION['CompanyHostName'] = $getCompanyDetails[0]['CompanyHostName'];
                    }
        }
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
      
        $tableMatchId = ''; 
        $joinTbaleRes = array();   
        $getPlaceholderDetailsColumnProperties  = array();
      
        if(count($getPlaceholderDetails1) >= 1)
        {
            $flagholder = 0 ;
            $colMatch = explode(',', $getPlaceholderDetails1[0]['ColumnsMatching']);
            $tempMatch = [];

            foreach ($getPlaceholderDetails1 as $kes =>  $valueees) {
                $mcnt = 0;
                if($valueees['TableType'] == '3')
                    {
                       
                     
                        if(strpos($valueees['tableColumns'], $valueees['Name']) === false )
                        {
                            $flagholder = 1 ;
                         
                            unset($getPlaceholderDetails1[$kes]);
                            
                        }
                        foreach ($colMatch as $key => $value) {
                            if(strpos($value, $valueees['Name']) !== false)
                            {
                                $mcnt = $mcnt + 1;
                                $tempMatch  = $kes;
                                $tableMatchId = $valueees['ID'];

                            }
                            
                        }

                    }
                    
            }
           
            $temp = $getPlaceholderDetails1[$tempMatch];
            unset($getPlaceholderDetails1[$tempMatch]);
            array_unshift($getPlaceholderDetails1, $temp);

            if($flagholder)
            {
                $getPlaceholderDetails1 = array_values($getPlaceholderDetails1);
            }
           
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


                    if(isset($_SESSION['APIParam'])) {

                        $arr = explode('|', $_SESSION['APIParam'] );
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
                    $csvData = [];

                    // // Add Extra Column
                    // if($getPlaceholderDetails[0]['Name'] == '2000_GCS_Masterdata2_date')
                    // {
                    //         $csvFile = file(baseUrl.'/assets/Custome_Code/Highsofts/MapsCSV/SEMaps.csv');
                          
                    //         foreach ($csvFile as $line) {
                    //             $csvData[] = str_getcsv($line);
                    //         }
                    // }
                    
                    // That function is the main issue So far what i found 
                    if(strpos($getSourceType, 'UserHistory'))
                    {
                        $userCompanyDbName = 'BP_Admin10';
                    }
                    else{
                       
                        if(!empty($getPlaceholderDetails[0]['DBName']) || $getPlaceholderDetails[0]['AllowCustomTable'] == 1)
                        {
                            $userCompanyDbName = $getCompanyDetails[0]['CompanyBPDb'];
                        } else
                        {
                             $userCompanyDbName = $getCompanyDetails[0]['CompanyBABCDb'];
                        }
                        //$userCompanyDbName = $getCompanyDetails[0]['CompanyBABCDb'];
                    }
                    if(!empty($getPlaceholderDetails[0]['customTable']))
                        {
                            $Table =$getPlaceholderDetails[0]['customTable'];
                        } else
                        {
                             $Table = "";
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

                        if(!empty($getPlaceholderDetails[0]['DBType']) && empty($getPlaceholderDetails[0]['DBName']))
                        {
                            $_SESSION['dataSourceDbType'] = $getPlaceholderDetails[0]['DBType'];
                        } else
                        {
                            unset($_SESSION['dataSourceDbType'])  ;
                        }
                      
                      
                        $allData = User::executeQuery($getSourceType, $userCompanyDbName , $Table );
                     
                        if($allData == 'createTable')
                        {
                           
                            $tabName = $getPlaceholderDetails[0]['customTable'];
                            $TabFeilds = json_decode($getPlaceholderDetails[0]['dbNewColumns'] , true);
                            $feild = '';
                            foreach($TabFeilds as $TabKey => $TabValue){
                                    if($TabKey == 'ID'){
                                        $feild .= $TabValue['label'] .' int NOT NULL IDENTITY (1,1) ,';
                                    }else{
                                        $feild .= $TabValue['label'];
                                        if($TabValue['type'] == 'integer')
                                        {
                                            $feild .= ' int NULL ,';
                                        }else if($TabValue['type'] == 'nvarchar')
                                        {
                                            $feild .= ' nvarchar(max) NULL ,';
                                        }else if($TabValue['type'] == 'date'){
                                            $feild .= 'date NULL ,';
                                        }
                                    }

                            }
                            $feild = rtrim( $feild , ',');
                            $newTabQuery = 'create Table ' .  $tabName . ' ( ' . $feild . ');';
                           
                            $res =  User::AddQuery($newTabQuery, $getCompanyDetails[0]['CompanyBPDb']);
                            if(!$res)
                            {
                                $allData = User::executeQuery($getSourceType, $getCompanyDetails[0]['CompanyBPDb'] , $Table );
                        
                            }
                           
                        }
                    }  
                       
                    $tableData = array();

                    //     if(!empty($csvData))
                    //     {
                    //        $count = 0;
                    //         foreach ($csvData as $csvkey => $csvvalue) {


                    //             foreach ($allData as $key => $value) {


                    //                 if($value['CountryId'] == 'SE')
                    //                 {
                    //                     if(trim($value['ZipCode']) == trim($csvvalue[1]) && !isset($value['States'])) 
                    //                     {

                    //                             $count = $count +1;
                    //                             $allData[$key]['States'] = $csvvalue[3];
                                             
                    //                     }else if(trim($value['ZipCode']) == trim($csvvalue[1]) && isset($value['States'])){
                                            
                    //                         break;
                    //                     }
                                       
                    //                 }

                    //         }
                               
                    //     }
                    // }
                   
                   
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
                        
                            foreach ($explodeColumns as $singleColumn => $singleColumnValue) {
                                if($getPlaceholderDetails[0]['TableType'] == 3)
                                {
                                    $columnDataFlag  = 0 ;
                                    $singleColumnVal = $singleColumn;
                                    if(strpos($singleColumn, $getPlaceholderDetails[0]['Name']) !== false){
                                        $singleColumn = explode('-', $singleColumn);
                                        if(count($singleColumn) > 2){
                                           
                                            array_shift($singleColumn);
                                           
                                            $singleColumn = implode('-' , $singleColumn );
                                           
                                            
                                            
                                            }
                                        else if($singleColumn[1] != '')
                                        {
                                            $columnDataFlag  = 1;
                                            $singleColumn = end($singleColumn);
                                        }
                                        
                                    if (isset($getPlaceholderDetails[0]['ColumnsProperties']) && $columnDataFlag == 1 ) {
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
                                
                                if($getPlaceholderDetails[0]['TableType'] != 3 )
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
                                        $dataToTable[] = $columnData;
                                    }
                                    

                                } else {
                                    if($getPlaceholderDetails[0]['TableType'] == 3)
                                    {
                                        $dataToTable[$singleColumnVal] = $columnData;
                                    }
                                    else{
                                        $dataToTable[] = $columnData;
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
                                    $buttonAction = baseUrl . 'page?id=' . $actionDetails['PageTargetId'] . '&page_text='. $textValue .'&columnName=' . $actionDetails['TableParameterColumn'] . '&columnValue='.$tableParameterColumnValue;
                                    //-----------------------------------------//
                                    // if ($actionDetails['DataSourceCall'] == 1) {
                                    //                     $parameterArray = array('orderNoCol'=>$actionDetails['TableParameterColumn'],'orderNoValue'=> $tableParameterColumnValue,'baseUrl' => baseUrl, 'pageTextValue' => rawurlencode ($textValue), 'dataSourceId' => $actionDetails['DataSourceId'],'pageTargetId' => $actionDetails['PageTargetId']);
                                    //                     $parameterArray = json_encode($parameterArray, JSON_UNESCAPED_SLASHES);
                                    //                     $buttonAction = 'getUpdateDataSourceCall('. $parameterArray .')';
                                    //                     $txt_ .=  $actionDetails['ActionButtonText'].$separator;
                                    //                     //Comentet this line out SA
                                    //                     //$class_ .= $buttonAction.$separator;
                                    //                     $class_ .= str_replace("http://","",$buttonAction).$separator;

                                    //                     //me: $actionButtons .= "<li><a href='#' onclick='" . $buttonAction . "'>" . $actionDetails['ActionButtonText'] . "</a></li>";

                                    //                 } 
                                    //                 else {
                                    //                     $txt_ .=  $actionDetails['ActionButtonText'].$separator;
                                    //                     // Commentet out SA
                                    //                     //$class_ .= $buttonAction.$separator;
                                    //                     $class_ .= str_replace("http://","",$buttonAction).$separator;
                                    //                     //me: $actionButtons .= "<li><a href='" . $buttonAction . "'>" . $actionDetails['ActionButtonText'] . "</a></li>";
                                    //
                                    //}
                                    //-----------------------------------------//
                                    // New Code from here 


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
                                        $txt_ .= $actionDetails['ActionButtonText'].$separator;
                               
                                        $class_ .= str_replace("http://","",$buttonAction).$separator;
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

                            if($tableActions){
                                $dataToTable[] = $txt_ ;
                                $dataToTable[] = $class_ ;
                            
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
                    if(empty($tableData))
                    {
                        $tableData['data'] = [];
                    }
                    if($getPlaceholderDetails1[0]['TableType'] == 3)
                    {
                        $joinTbaleRes[$getPlaceholderDetails[0]['ID']] = $tableData;
                    }
                   
                } 
                else {
                   
                     
                    
                    $invoiceNo = '';
                    $header  = '' ;
                    if ($requestUrl) {
                        
                        $gcsCustomer = $requestUrl;
                        if($getPlaceholderDetails[0]['ExternalAPIReq'])
                        {
                        
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
                        
                        }
                       
                        $ch = curl_init();
                        if($header)
                        {
                            curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
                        }else{
                            curl_setopt($ch, CURLOPT_HEADER, false);
                        }

                        curl_setopt($ch, CURLOPT_NOBODY, false);
                        curl_setopt($ch, CURLOPT_URL, $gcsCustomer);
                        
                        if($ke > 0)
                        {
                            
                            $results = [];
                            foreach ($tableData['data'] as $key => $value) {
                                $newRes = [];
                                $newrequestBody = $requestBody;
                                $matchCol = explode(',', $getPlaceholderDetails[0]['ColumnsMatching']);
                                $matchColval = '';
                                foreach ($matchCol as $matchColkey => $matchColvalue) {
                                    if(strpos($matchColvalue, ';')!== false)
                                    {
                                        $matchColvalue = explode(';', $matchColvalue);
                                        $matchColval =  $matchColval.$value[$matchColvalue[0]];
                                    }else
                                    {
                                        $matchColval =  $matchColval.$value[$matchColvalue];
                                    }
                                }
                               
                                $newrequestBody = str_replace("(ProductNo)", $matchColval, $requestBody);
                                
                                if ($requestType && $requestType == 2) {

                                curl_setopt($ch, CURLOPT_POSTFIELDS, $newrequestBody);
                               
                                if($header)
                                {
                                    curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
                                }else{
                                    curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));
                                }
                           
                                }
                                curl_setopt($ch, CURLOPT_TIMEOUT, 60);
                                curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
                                $newRes = curl_exec($ch);

                                $tempdecodedResults = json_decode($newRes, true);
                                if($newRes)
                                {
                                    foreach ($tempdecodedResults as $tempdecodedResultsKey => $tempdecodedResultsValue) {
                                       
                                       
                                       foreach ($tempdecodedResultsValue as $mainkey => $mainvalue) {
                                            $name = $getPlaceholderDetails[0]['Name'].'-'.$mainkey;
                                            if(array_key_exists($name,$joinTbaleRes[ $tableMatchId]['data'][$key])){
                                            $joinTbaleRes[ $tableMatchId]['data'][$key][$getPlaceholderDetails[0]['Name'].'-'.$mainkey] = $mainvalue;
                                                }
                                           
                                       }
                                       
                                    }
                                }

                                

                            }
                            

                        }else
                        {
                            if ($requestType && $requestType == 2) {

                                curl_setopt($ch, CURLOPT_POSTFIELDS, $requestBody);
                               
                                if($header)
                                {
                                    curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
                                }else{
                                    curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));
                                }
                           
                            }
                            curl_setopt($ch, CURLOPT_TIMEOUT, 60);
                            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
                            $results = curl_exec($ch);
                        }
                       
                        //print_r($ProductNo);
                       // print_r($requestBody);
                        //print_r($gcsCustomer);exit;
                        $tableData['data'] = array();

                        if ($results) {
                           
                            if(count($results) > 1){
                                $decodedResults = [];
                                foreach ($results as $key => $value) {
                                   
                                    $tempdecodedResults = json_decode($value, true);
                                    if(!empty($tempdecodedResults)){
                                        array_push($decodedResults, $tempdecodedResults);
                                    }
                                }
                                $decodedResults = $decodedResults[0];
                            }else
                            {
                                 $decodedResults = json_decode($results, true);
                            }
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
                                                        #print_r ($eachRecord);
                                                        
                                                    }
                                                $dataToTable1 = [];
                                               
                                                if (array_key_exists('boards',$eachRecords))
                                                {
                                                    $eachRecords= $eachRecords['boards'];

                                                 }
                                                foreach ($eachRecords as $key => $val ) {
                                                   
                                                    $dataToTable= [];
                                                    
                                                    $val['Nodes'] = $val;

                                                    foreach ($explodeColumns as $singleColumn => $singleColumnValue) {
                                                         if($getPlaceholderDetails[0]['TableType'] == 3)
                                                            {
                                                                $columnDataFlag  = 0;
                                                                $singleColumnVal = $singleColumn;
                                                                if(strpos($singleColumn, $getPlaceholderDetails[0]['Name']) !== false){
                                                                    $singleColumn = explode('-', $singleColumn);
                                                                    if($singleColumn[1] != '')
                                                                    {
                                                                        $columnDataFlag  = 1;
                                                                        $singleColumn = end($singleColumn);
                                                                    }
                                                                    
                                                                if (isset($getPlaceholderDetails[0]['ColumnsProperties']) && $columnDataFlag == 1 ) {
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
                                                        if($getPlaceholderDetails[0]['TableType'] != 3 ){
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
                                                                if($singleColumn[1] != '')
                                                                    {
                                                                        $columnDataFlag  = 1;
                                                                        $singleColumn = end($singleColumn);
                                                                    }
                                                                   
                                                                    
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


                                                            if (!empty($externalUrl)) {
                                                                $buttonAction = $externalUrl;
                                                                // $txt_ .=  "".$separator;
                                                                // $class_ .= "".$separator;
                                                            } 
                                                            else {

                                                                 
                                                                $buttonAction = baseUrl . 'page?id=' . $actionDetails['PageTargetId'] . '&page_text='. $pageTextValue .'&columnName=' . $actionDetails['TableParameterColumn'] . '&columnValue=' . $tableParameterColumnValue;
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
                                                                    $txt_ .= $actionDetails['ActionButtonText'].$separator;
                                                                    //$class_ .= $buttonAction.$separator;
                                                                    //commentet out SA
                                                                    $class_ .= str_replace("http://","",$buttonAction).$separator;

                                                                    //me: $actionButtons .= "<li><a href='" . $buttonAction . "'>" .$actionDetails['ActionButtonText'] . "</a></li>"; // ACTION BINDER MY_
                                                                }
                                                            }
                                                        }
                                                    }
                                                 
                                                }
                                               
                                                $dataToTable[] = $txt_ ;
                                                $dataToTable[] = $class_ ;
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

                                                                    
                                                                    $buttonAction = baseUrl . 'page?id=' . $actionDetails['PageTargetId'] . '&page_text='. $pageTextValue .'&columnName=' . $actionDetails['TableParameterColumn'] . '&columnValue=' . $tableParameterColumnValue;
                                                                    
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
                                                                        $txt_ .= $actionDetails['ActionButtonText'].$separator;
                                                                        $class_ .= str_replace("http://","",$buttonAction).$separator;

                                                                    }
                                                                }
                                                            }
                                                        }
                                                    
                                                    }
                                                
                                                    $tempRes[] = $txt_ ;
                                                    $tempRes[] = $class_ ;
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
                        $tst = $dataToTable[0];

                        for ($i=1; $i < count($dataToTable) ; $i++) { 
                            
                            if(!is_array($tst))
                            {
                                $tst = array($tst);
                            }
                            if(!is_array($dataToTable[$i]))
                            {
                                $dataToTable[$i]= array($dataToTable[$i]);
                            }

                            $tst = Self::cartesian($tst , $dataToTable[$i]);
                        }
                        foreach ($tst as $key => $value) {
                            $tempRes = array();
                            $tempRes = Self::array_flatten($value);
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

                if(!empty($joinTbaleRes) && $getPlaceholderDetails[0]['ColumnsMatching'] != '')
                {
                  
                    
                    $tempDataArr = [];
                   
                    $compareTable = $joinTbaleRes[$tableMatchId]['data'];
                    unset( $joinTbaleRes[$tableMatchId]);
                                    
                    foreach($compareTable as $comTabKey => $comTabVal)
                            {

                                $tabId =  array_keys($joinTbaleRes);
                                $tabId = $tabId[0];
                                foreach($joinTbaleRes[$tabId]['data'] as $joinTbaleResKey => $joinTbaleResValue){

                                    $matchCol = explode(',', $getPlaceholderDetails[0]['ColumnsMatching']);
                                    $ColumnTobeMatched =  explode(',', $getPlaceholderDetails[0]['ColumnsToBeMatched']);
                                    $cnt = 0;
                                    $matchColval = '';
                                    $cntMatchCol = count($matchCol);
                                    $cntColumnTobeMatched = count($ColumnTobeMatched);
                                    if($cntMatchCol == $cntColumnTobeMatched){
                                        foreach ($matchCol as $matchColkey => $matchColvalue) {
                
                                            if(strpos($matchColvalue, ';')!== false)
                                            {
                                                $matchColvalue = explode(';', $matchColvalue);
                                                $matchColval =  $comTabVal[$matchColvalue[0]];
                                            }else
                                            {
                                                if(array_key_exists($matchColvalue, array_keys($comTabVal)))
                                                {
                                                    $matchColval =  $comTabVal[$matchColvalue];
                                                }else{
                                                    $colMVal = explode('-', $matchColvalue);
                                                    $colMVal = end($colMVal);
                                                    if(isset( $comTabVal[$colMVal]))
                                                    {
                                                        $matchColval =  $comTabVal[$colMVal];
                                                    }else{
                                                        $matchColval =  $comTabVal[$matchColvalue];
                                                    }
                                                   
                                                  
                                                }
                
                                               
                                            }
                                           
                                            if($matchColval == $joinTbaleResValue[$ColumnTobeMatched[$matchColkey]])	
                                            { 
                                                $cnt = $cnt + 1 ;
                                            }
                                            
                                        }
                                    }else if($cntMatchCol != $cntColumnTobeMatched){
            
                                        if($cntMatchCol > $cntColumnTobeMatched){
                                            
                                        
                                            foreach ($matchCol as $matchColkey => $matchColvalue) {
                    
                                                if(strpos($matchColvalue, ';')!== false)
                                                {
                                                    $matchColvalue = explode(';', $matchColvalue);
                                                    $matchColval .=  $comTabVal[$matchColvalue[0]];
                                                }else
                                                {
                                                    if(array_key_exists($matchColvalue, array_keys($comTabVal)))
                                                    {
                                                        $matchColval .=  $comTabVal[$matchColvalue];
                                                    }else{
                                                        $colMVal = explode('-', $matchColvalue);
                                                        $colMVal = end($colMVal);
                                                        if(isset( $comTabVal[$colMVal]))
                                                        {
                                                            $matchColval .=  $comTabVal[$colMVal];
                                                        }else{
                                                            $matchColval .=  $comTabVal[$matchColvalue];
                                                        }
                                           
                                                    }
                                                }
                                            }   
                                            
                                                $cntColumnTobeMatched = $cntColumnTobeMatched-1;
                                                if($matchColval == $joinTbaleResValue[$ColumnTobeMatched[$cntColumnTobeMatched]])	
                                                { 
                                                    $cnt = $cnt + 2 ;
                                                }
                                        }   
                                    }
                                  
                                    if($cnt == count($matchCol))  
                                        {
                                            $temp = [];
                                            foreach($joinTbaleResValue as $keyVal  =>  $Vals){
                                                if(empty($Vals)){
                                                    $temp[$keyVal] = $comTabVal[$keyVal] ;
                                                }else{
                                                    $temp[$keyVal] = $Vals ;
                                                }


                                            }
                                            if(!isset($tempDataArr[$tabId]['data']))
                                            {
                                                $tempDataArr[$tabId]['data'][] =  $temp ;
                                                
                                            }else{
                                                array_push($tempDataArr[$tabId]['data'] , $temp );
                                            }
                                            
                                        
                                        }
                                }     
                                                
                                            
                                }
                                if($tempDataArr){
                                        unset($joinTbaleRes);
                                        $joinTbaleRes= $tempDataArr;
                                }else{
                                    
                                        $tableData['data'] = '';
                                        $joinTbaleRes =[];
                                       
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
                                    $columnDataFlag  = 0;
                                    $singleColumnVal = $singleColumn;
                                    //if(strpos($singleColumn, $getPlaceholderDetails[0]['Name']) !== false){
                                        
                                   
                                    if (isset( $getPlaceholderDetailsColumnProperties) ) {
                                        $singleColumn12 = explode('-', $singleColumn);
                                        if($singleColumn12[1] != '')
                                        {
                                            $columnDataFlag  = 1;
                                            $singleColumn12 = end($singleColumn12);
                                        }
                                       // $getColumnsProperties = json_decode($getPlaceholderDetails[0]['ColumnsProperties'], true);
                                        $singleColumnValue = isset( $getPlaceholderDetailsColumnProperties[$singleColumn12])? $getPlaceholderDetailsColumnProperties[$singleColumn12]:$singleColumn12;
                                    }

                                    //}
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
               
                //$value = array_values($value);
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
       
        if(isset($_GET['search']))
        {
            $checkCount = 0;
            $id = '';
            foreach ($tableData['data'] as $dataToTableKey => $dataToTableValue) {
                
                if(is_array($dataToTableValue)){
                    foreach($dataToTableValue as $key => $val){
                        if($val == $_GET['search']){
                            $checkCount =  $checkCount + 1;
                            $id =  $dataToTableKey;
                            break;
                        }
                    }
                } 
            }
            if($checkCount == 0)
            {
                $tableData['data']= [];
            }else{
                $d = $tableData['data'][$id];
                unset($tableData['data']);
                $tableData['data'] = $d;
            }
        }
        if($getPlaceholderDetails[0]['ApiType'] == '2')
        {

            $input = array();
            $input = array_map("unserialize", array_unique(array_map("serialize", $newResArr1)));
              
            $input = array_values($input);
             
            $tableData['data'] =$input;
            return $tableData;
          }else{

             return $tableData;
         }
         exit;
    }
}
