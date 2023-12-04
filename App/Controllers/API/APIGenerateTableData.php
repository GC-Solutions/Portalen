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
use \App\Controllers\API\APIGenerateJoinTableData;
use App\Controllers\DataTables\SourceType;
use App\Controllers\DataTables\GoogleCallData;
use App\Controllers\API\DBDataSourceCallRowCreation;
use \App\Controllers\API\APIDataSourceCallSingleNode;



/**
 * APIGenerateTableData controller
 *
 * PHP version 7.0
 */

// Need to separate that code .

// This file conatin all the FUnction for gererating the API data .
// The main function allow to create (GET , POST , PUT ) requests .
 
class APIGenerateTableData extends \Core\Controller
{
	public  static function generateTableAction()
    {
        // get company detail
        $getCompanyDetails = Companies::getCompaniesDetails($_SESSION['UserID']);
        $_arrayList = array('ResultList');
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

        $actationTableColumn = array();
        $placeholderId = (isset($_REQUEST['placeholderId'])) ? $_REQUEST['placeholderId'] : "";
        $pHolderId = (isset($_REQUEST['pholderid'])) ? $_REQUEST['pholderid'] : "";
        $userPagePlaceholder = (isset($_REQUEST['id'])) ? $_REQUEST['id'] : "";
        $pholderId = (isset($_REQUEST['pholderid'])) ? $_REQUEST['pholderid'] : "";
        $columnName = (isset($_REQUEST['columnName'])) ? $_REQUEST['columnName'] : "";
        $columnValue = (isset($_REQUEST['columnValue'])) ? $_REQUEST['columnValue'] : "";         
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
        if($getPlaceholderDetails1[0]['ColumnsMatching'])
        {
            
            $res = APIGenerateJoinTableData::generateJoinTableAction();
            return $res;
            exit;
        }

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
                    $getSourceType =  SourceType::getSourceType($getPlaceholderDetails , 'single') ;
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
              
                //(Start) Fetching  data from  Google Api   
                
                if ($requestType == 4) {
                    if($accessTokenGAPI){
                        $flagGapi = 1;
                        GoogleCallData::getGoogleCallData($flagGapi , $accessTokenGAPI , $requestGAPI , $requestBody , $accessRefreshTokenGAPI , $getCompanyDetails  ); 
                        
                    }
                }
                //(End) Fetching  data from  Google Api  
                else if ($requestType == 3) {
                    
                    $tableData = array();    
                    $tableData = DBDataSourceCallRowCreation::getDBDataSourceCallRowCreation( $getPlaceholderDetails , $getCompanyDetails, $getSourceType ,  $tableActions , $getColumnsList , $explodeColumns ,
                    $keyColumnName , $searchValue , $actationTableColumn , $filterion , $getColumnsProperties);
                    if(empty($tableData))
                    {
                        $tableData['data'] = [];
                    }
                  
                } 
                else {
                    if(isset($getPlaceholderDetails) && $getPlaceholderDetails[0]['ApiType'] == '2')
                    {
                        $tableData = APIDataSourceCallMultipleNode::getAPIDataSourceCallMultipleNode($getPlaceholderDetails , $getCompanyDetails , $getSourceType, $requestUrl , $customSumFormula , $explodeColumns , $getColumnsList , $sumColumnLable , $sumType , $keyColumnName , $tableActions , $filterion ,  $actationTableColumn , $getColumnsProperties); 
                    }else{
                        $tableData = APIDataSourceCallSingleNode::getAPIDataSourceCallSingleNode($getPlaceholderDetails , $getCompanyDetails , $getSourceType, $requestUrl , $customSumFormula , $explodeColumns , $getColumnsList , $sumColumnLable , $sumType , $keyColumnName , $tableActions , $filterion , $actationTableColumn , $getColumnsProperties); 
                    }
                    
                }
                //(End) Fetching Data  from Data Source Call Api
            }
        }
        //(End)if we have fetched data for placeholder
       
    
        if($getPlaceholderDetails[0]['ApiType'] == '2')
        {
            
            $input = array();
            $input = array_map("unserialize", array_unique(array_map("serialize", $tableData)));   
            $input = array_values($input);
            unset($tableData);
            $tableData['data'] = $input;
            return $tableData;
        }else{
            
                return $tableData;
            }
        
        
        exit;
}
}
?>



