<?php

namespace App\Controllers\DataTables;

use \Core\View;
use App\Models\Page;
use \App\Models\User;
use \App\Models\Companies;
use App\Models\Placeholder;
use \App\Models\DataTableDesigns;
use App\Controllers\DataFormatHelper\DataTableHelper;
use App\Controllers\DataTables\GeneralDataTableFtn;
use App\Controllers\DataTables\SourceType;
use App\Controllers\DataTables\GoogleCallData;
use App\Controllers\DataTables\JoinTableData;
/**
 * DataTableJoinTable controller
 *
 * PHP version 7.0
 *
 This file contain a function for getting the Join Table data .
 all the formating or any custom sum is performed over here . 
 this function  join the data from datatbase datasource call and API datasource call or joining 2 datatbase datasource call or joining 2 API datasource call.
 apart from that if any action button is linked with the table this function create the URL and the name of the action button and attach it with the respective row .
 */

class DataTableJoinTable extends \Core\Controller
{
    // this function is specfcic for join table .
    // it perform all the operationregarding join table  btw 2 diiferent table or API or btw a database call table and API based table .
    public static  function generateJoinTableAction()
    {
        // Set the number of seconds a script is allowed to run to infinity .
        set_time_limit(0); 
        // Memory Limit for the script 
        ini_set('memory_limit', '2G'); 
        $_arrayList= array('ResultList');
    	$retval = array();
        // Get Company Info 
        $getCompanyDetails = Companies::getCompaniesDetails($_SESSION['UserID']);
        // Variable Initialization and declaration  
        $placeholderId = (isset($_REQUEST['placeholderId'])) ? $_REQUEST['placeholderId'] : "";
        $pHolderId = (isset($_REQUEST['pholderid'])) ? $_REQUEST['pholderid'] : "";
        $userPagePlaceholder = (isset($_REQUEST['id'])) ? $_REQUEST['id'] : "";
        $pholderId = (isset($_REQUEST['pholderid'])) ? $_REQUEST['pholderid'] : "";
        $columnName = (isset($_REQUEST['columnName'])) ? $_REQUEST['columnName'] : "";
        $columnValue = (isset($_REQUEST['columnValue'])) ? $_REQUEST['columnValue'] : "";
        $getDatatableDetails = "";
        $searchValue = (isset($_REQUEST['searchvalue'])) ? json_decode($_REQUEST['searchvalue']) : "";
        $searchValueCount = '';
        $actationTableColumn = array();
        if($searchValue) {
            $searchValue = (array)$searchValue[0];
            $searchValueCount = count($searchValue);
        }
        // Get table Placeholder Detail
        if (!empty($pholderId)) {
            $getDatatableDetails = Page::getDatasourceTableDetails($pholderId);
        }
        $getPlaceholderDetails1= Page::getDatasourceTableDetails($placeholderId);
        
        // Get table Action Detail
        $getTableActionDetails = Page::getTableActionDetails($userPagePlaceholder);
        $tableActions = array();
        //(Start) processing for Action Button 
        if ($getTableActionDetails) {
            $getTableActionIds = (isset($getTableActionDetails[0]['PlaceholderActionIds'])) ? $getTableActionDetails[0]['PlaceholderActionIds'] : "";
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
        $tableMatchId = ''; 
        $joinTbaleRes = array();   
        $getPlaceholderDetailsColumnProperties  = array();
       
        //(Start)if we have fetched data for placeholder
        if(count($getPlaceholderDetails1) >= 1)
        {
            $flagholder = 0 ;
            $colMatch = explode(',', $getPlaceholderDetails1[0]['ColumnsMatching']);
            $tempMatch = [];
            // (Start) For loop for all the Placeholder . For Join Table we at a time select 2 table so we have 2 placeholders.
            foreach ($getPlaceholderDetails1 as $kes =>  $valueees) {
                $mcnt = 0;
                // processing to get tableMatchId .
                if($valueees['TableType'] == '3')
                    {
                    //    if(strpos($valueees['tableColumns'], $valueees['Name']) === false )
                    //     {
                    //         $flagholder = 1 ;
                    //         unset($getPlaceholderDetails1[$kes]);
                    //     }
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
            // (End) For loop for all the Placeholder . For Join Table we at a time select 2 table so we have 2 placeholders. 
           
            $temp = $getPlaceholderDetails1[$tempMatch];
            unset($getPlaceholderDetails1[$tempMatch]);
            array_unshift($getPlaceholderDetails1, $temp);
            
           
            if($flagholder)
            {
                $getPlaceholderDetails1 = array_values($getPlaceholderDetails1);
            }
            
          
            foreach ($getPlaceholderDetails1 as $ke => $valueee) {
                // Variable Declaration 
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
                // get Source type from Source type File . 
                $getSourceType = SourceType::getSourceType($getPlaceholderDetails , 'address');
                
                // getting Column Name .  will get the Columns in case of multiple Node .
                if($getPlaceholderDetails[0]['ApiType'] == '2')
                {
                    $getColumnsList = $getPlaceholderDetails[0]['Columns'];
                }else{
                    $getColumnsList = $getPlaceholderDetails[0]['tableColumns'];
                
                } 
                $newExplodeColumns = array();
                // (Start) if we got the Column Name 
                if (isset($getColumnsList)) {
                    //Processing for Column Name properties .
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
                // Variable Declarationn and initialization 
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
                // replacing (NOW TIMe) in Body to actual time 
                if (strpos($requestBody, strtolower('(nowtime)')) !== false) {
                    if(isset($_SESSION['NowTime'])){
                        $requestBody = str_replace("(nowtime)", $_SESSION['NowTime'], $requestBody);
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
                $sumType = $getPlaceholderDetails[0]['SumType'];
                $requestUrl = str_replace("(address)", $companyAddress, $getSourceType);
                $requestUrl = str_replace("(token)", $companyToken, $requestUrl);
                $filterion = false;
                //replacing (NOW TIMe) from Body to actual time 
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
                $columnSumResults = 0;
                $searchValueArray = array();
                $columnSumResultsValue = array();
                //(Start) Fetching  data from  Google Api  
                if ($requestType == 4) {
                    if($accessTokenGAPI){
                        $flagGapi = 1;
                         GoogleCallData::getGoogleCallData($flagGapi , $accessTokenGAPI , $requestGAPI , $requestBody , $accessRefreshTokenGAPI , $getCompanyDetails  ); 
                    }
                }
                //(End) Fetching data from  Google Api 
                //(Start) Fetching Data  from Data Source Call DB 
                else if ($requestType == 3) {
                    $tableData = DBDataSourceCallRowCreation::getDBDataSourceCallRowCreation( $getPlaceholderDetails , $getCompanyDetails, $getSourceType ,  $tableActions , $getColumnsList , $explodeColumns ,
                            $keyColumnName , $searchValue , $actationTableColumn , $filterion , $getColumnsProperties);
                    if(empty($tableData))
                    {
                        $tableData['data'] = [];
                    }
                    if($getPlaceholderDetails1[0]['TableType'] == 3)
                    {
                        $joinTbaleRes[$getPlaceholderDetails[0]['ID']] = $tableData;
                    }

                } 
                //(ENd) Fetching Data  from Data Source Call DB 
                //(Start) Fetching Data  from Data Source Call Api  
                else {
                    // Calling Funbction for multiple Node 
                   
                    if(isset($getPlaceholderDetails) && $getPlaceholderDetails[0]['ApiType'] == '2')
                    {
                        $tableData = APIDataSourceCallMultipleNode::getAPIDataSourceCallMultipleNode($getPlaceholderDetails , $getCompanyDetails , $getSourceType, $requestUrl , $customSumFormula , $explodeColumns , $getColumnsList , $sumColumnLable , $sumType , $keyColumnName , $tableActions , $filterion ,   $actationTableColumn , $getColumnsProperties); 
                      
                    }else{
                        $tableData = APIDataSourceCallSingleNode::getAPIDataSourceCallSingleNode($getPlaceholderDetails , $getCompanyDetails , $getSourceType, $requestUrl , $customSumFormula , $explodeColumns , $getColumnsList , $sumColumnLable , $sumType , $keyColumnName , $tableActions , $filterion ,  $actationTableColumn , $getColumnsProperties); 
                    }
                   
                    if($getPlaceholderDetails1[0]['TableType'] == 3)
                    {
                        $joinTbaleRes[$getPlaceholderDetails[0]['ID']] = $tableData;
                    }

                }
                 //(End) Fetching Data  from Data Source Call Api   
            }
            unset($tableData);
            // Main Function to perform the join after fetching the data from Placeholders 
            $tableData = JoinTableData::getJoinTableData($joinTbaleRes , $getPlaceholderDetails ,$explodeColumns ,$sumType , $columnSumResults , $getColumnsProperties , $sumColumnLable , $searchValue , $searchValueArray , $columnSumResultsValue , $tableMatchId, $placeholderId);
        }
        //(End)if we have fetched data for placeholder
        //Condition to be exceuted in case of Multiple Node .
        if(isset($getPlaceholderDetails) && $getPlaceholderDetails[0]['ApiType'] == '2')
        {
            $input = array();
            $input = array_map("unserialize", array_unique(array_map("serialize", $tableData)));
              $tableData['data'] = array_values($input);
              
             echo json_encode($tableData, JSON_UNESCAPED_SLASHES);
        }else{
            foreach ($tableData['data'] as $key => $value) {
                $count = array_filter($value);
                if(empty($count)){
                    unset($tableData['data'][$key]);
                }
            }
            $tableData['data'] = array_values($tableData['data']);
            echo json_encode($tableData, JSON_UNESCAPED_SLASHES);
        } 
        exit;
    }



}