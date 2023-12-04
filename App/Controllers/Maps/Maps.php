<?php

namespace App\Controllers\Maps;

use \Core\View;
use App\Models\Page;
use \App\Models\User;
use \App\Models\Companies;
use \APP\Models\Placeholder;

/**
 * Maps controller
 *
 * PHP version 7.0
 */
class Maps extends \Core\Controller
{
    public $_arrayList = array('ResultList');
    // This Function Basically get all the necessaray Info Regarding the Maps .
    public function showMapDetailsAction()
    {
        set_time_limit(0);
        ini_set('memory_limit', '512M');
        $getUserDetails = User::getUserDetails($_SESSION['UserID']);
        if ($getUserDetails) {
            $getCompanyDetails = Companies::getCompanyDetails($getUserDetails[0]['CompanyID']);
        }

        $placeholderId = $_REQUEST['placeholder'];
        $getPlaceholderDetails = Placeholder::getPlaceholderDetails($placeholderId);
        $getMapCountryValue = '';
        if ($getPlaceholderDetails) {
            $getMapKey = $getPlaceholderDetails[0]['MapFieldName'];
            $getMapCountryValue = (isset($_REQUEST[$getMapKey])) ? $_REQUEST[$getMapKey] : '';
            if (empty($getMapCountryValue)) {
                $getSourceType = $getPlaceholderDetails[0]['SourceType'];
                $companyAddress = $getCompanyDetails[0]['CompanyGISKey'];
                $companyToken = $getCompanyDetails[0]['CompanyGISToken'];
                $requestType = $getPlaceholderDetails[0]['RequestType'];
                $requestBody = $getPlaceholderDetails[0]['RequestBody'];
                $requestUrl = str_replace("(Address)", $companyAddress, $getSourceType);
                $requestUrl = str_replace("(token)", $companyToken, $requestUrl);


            }
        }
        $totalCustomerCountries = array();
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
                    foreach ($this->_arrayList as $key) {
                        if (isset($decodedResults[$key])) {
                            $apiData = $decodedResults[$key];
                            break;
                        }
                    }
                }
                if ($apiData) {
                    foreach ($apiData as $eachRecord) {
                        if ($eachRecord) {
                            $columnData = '';
                            $columnData = Self::searchArray($eachRecord, $getMapKey);
                            if (trim($columnData) == '') {
                                $columnData = 'Sweden';
                            }
                            if (!in_array($columnData, $totalCustomerCountries)) {
                                $totalCustomerCountries[] = $columnData;
                            }
                        }
                    }
                }

            }
        }
        include_once 'view/table_map_details.php';
    }
    // This FUnction returns the data that is used to display the MAps
    public function generateMapDataAction()
    {

        set_time_limit(0);
        ini_set('memory_limit', '2G');

        $placeholderId = (isset($_REQUEST['placeholderId'])) ? $_REQUEST['placeholderId'] : "";
        $pholderId = (isset($_REQUEST['pholderid'])) ? $_REQUEST['pholderid'] : "";
        $searchValue = (isset($_REQUEST['searchvalue'])) ? json_decode($_REQUEST['searchvalue']) : "";
        $columnName = (isset($_REQUEST['columnName'])) ? $_REQUEST['columnName'] : "";
        $columnValue = (isset($_REQUEST['columnValue'])) ? $_REQUEST['columnValue'] : "";
        $customerNo = (isset($_REQUEST['CustomerNo'])) ? $_REQUEST['CustomerNo'] : "";
        $CustomerNo = (isset($_REQUEST['CustomerNo'])) ? $_REQUEST['CustomerNo'] : "";
        $ProductNo = (isset($_REQUEST['ProductNo'])) ? $_REQUEST['ProductNo'] : "";
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
        $id = (isset($_REQUEST['id'])) ? $_REQUEST['id'] : "";
        
        $getDatatableDetails = "";
        $searchValueCount = '';
        if($searchValue) {
            $searchValue = (array)$searchValue[0];
            $searchValueCount = count($searchValue);
            foreach($searchValue as $key=>$value) {

                if (strpos($value, '|') === false) {
                    $searchValue[$key] = (int)str_replace(array(" ", ","), "", $value);
                    if($searchValue[$key] == 0) {
                        $searchValue[$key] = $value;
                    }
                }

            }
        }

        if (!empty($pholderId)) {
            $getDatatableDetails = Page::getDatasourceTableDetails($pholderId);
        }


        $dataFilteration = false;

        $mapData = array();
        $MapTitle = '';
        $MapLabels = array();
        $getUserDetails = User::getUserDetails($_SESSION['UserID']);
        $MapType = 0;
        $filterColumn = '';
        $isTabelFlag = 0;
        $getPlaceholderDetails = Page::getDatasourceMapsDetails($placeholderId);

        if ($getUserDetails && $getPlaceholderDetails) {
            $getCompanyDetails = Companies::getCompanyDetails($getUserDetails[0]['CompanyID']);
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
            // For gettig the fields whose sum needed to be done
            $getFieldsColumns= trim($getPlaceholderDetails[0][9]);
            if ($getFieldsColumns) {
                $getFieldsColumns = explode(',', trim($getFieldsColumns));
            }

            $getDataSourceColumns = trim($getPlaceholderDetails[0]['Columns']);
            if ($getDataSourceColumns) {
                $getDataSourceColumns = explode(',', trim(trim($getDataSourceColumns)));
            }
        }
            
        if ($getDatatableDetails && $getPlaceholderDetails) {
                if ($getDatatableDetails[0]['DataSourceId'] == $getPlaceholderDetails[0]['DataSourceId']) {
                    if (!empty($searchValue)) {
                        $keyValue = key($searchValue);
                        $keyValue = ltrim($keyValue);
                        $getDataSourceColumnsArray = array();
                        foreach ($getDataSourceColumns as $value) {
                            $getDataSourceColumnsArray[] = trim($value);
                        }
                        if(in_array($keyValue, $getDataSourceColumnsArray, true)) {
                            $dataFilteration = true;
                        }
                    }
                }
            }
        
        $keyColumnName = $getPlaceholderDetails[0]['KeyColumn'];
        
        $MapTitle = $getPlaceholderDetails[0]['HeadersText'];

        $companyAddress = $getCompanyDetails[0]['CompanyGISKey'];
        $companyToken = $getCompanyDetails[0]['CompanyGISToken'];
        $requestType = $getPlaceholderDetails[0]['RequestType'];

        $getPlaceholderColumn = trim($getPlaceholderDetails[0]['Placeholder']);
        $requestBody = (isset($getPlaceholderDetails[0]['Body'])) ? $getPlaceholderDetails[0]['Body'] : "";

        if ($getPlaceholderColumn) {
            $getRequestData = (isset($_REQUEST[$getPlaceholderColumn])) ? $_REQUEST[$getPlaceholderColumn] : "";

            if ($getRequestData) {
                $requestBody = str_replace("(" . $getPlaceholderColumn . ")", $getRequestData, $requestBody);
            }
        }

            $MapType = $getPlaceholderDetails[0]['MapType'];
           
            $requestUrl = str_replace("(address)", $companyAddress, $getSourceType);
            $requestUrl = str_replace("(token)", $companyToken, $requestUrl);
            $sum = array();
            //print_r($getPlaceholderDetails); exit;
            $coumnNameCountry = ['landkod','CountryId','Id'];
               
            if ($requestType == 3) {
                $userCompanyDbName = $getCompanyDetails[0]['CompanyBABCDb'];
                $allData = User::executeQuery($getSourceType, $userCompanyDbName);
                
                if ($allData) {
                    if (isset($getDataSourceColumns) ) { 
                        foreach ($allData as $eachRecord) {
                            foreach ($coumnNameCountry as $k => $v) {
                                if(isset($eachRecord[$v])){
                                    $colname = $v;
                                    break;
                                }
                            }

                            foreach ($getFieldsColumns as $col) {
                          
                                if(in_array(" ".$col, $getDataSourceColumns )){
                                    
                                    if(isset($sum[$eachRecord[$colname]]['value'.$col]) && isset($sum[$eachRecord[$colname]]['label'.$col])){

                                        $sum[$eachRecord[$colname]]['value'.$col] =  (int)$sum[$eachRecord[$colname]]['value'.$col] + (int)$eachRecord[$col];
                                           
                                    }
                                    else
                                    {
                                        $sum[$eachRecord[$colname]]['label'.$col] = $col;
                                        $sum[$eachRecord[$colname]]['code'] = $eachRecord[$colname] ;
                                        $sum[$eachRecord[$colname]]['value'.$col] =  (int)$eachRecord[$col];


                                    }
                                    
                                }

                            } 
                        }
                    }
                    // if(!empty($getPlaceholderDetails['CustomNameLabel']))
                    // {
                    //     print_r($getFieldsColumns); exit;
                    //     foreach ($sum as $sumKey => $sumValue) {

                    //     }
                    // } 
                    // print_r($sum); exit;
                    $mapData = array_values($sum);
                    
                }
            } else {
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
                    if ($decodedResults) {
                        $apiData = $decodedResults;
                        foreach ($this->_arrayList as $key) {
                            if (isset($decodedResults[$key])) {
                                $apiData = $decodedResults[$key];
                                break;
                            }
                        }
                        
                        if (isset($getDataSourceColumns) ) { 
                                foreach ($apiData as $eachRecord) {
                                    foreach ($coumnNameCountry as $k => $v) {
                                        if(isset($eachRecord[$v])){
                                            $colname = $v;
                                            break;
                                        }
                                    }
                                    foreach ($getFieldsColumns as $col) {
                                        if(in_array(" ".$col, $getDataSourceColumns )){
                                              if(isset($sum[$eachRecord[$colname]]['value'.$col]) && isset($sum[$eachRecord[$colname]]['label'.$col])){

                                        $sum[$eachRecord[$colname]]['value'.$col] =  (int)$sum[$eachRecord[$colname]]['value'.$col] + (int)$eachRecord[$col];
                                           
                                        }
                                        else
                                        {
                                            $sum[$eachRecord[$colname]]['label'.$col] = $col;
                                            $sum[$eachRecord[$colname]]['code'] = $eachRecord[$colname] ;
                                            $sum[$eachRecord[$colname]]['value'.$col] =  (int)$eachRecord[$col];


                                        }
                                        }
                                    }
                                }   
                        $mapData = array_values($sum);
                        }
                    }
                }
            }
            $getFieldsColumns =  implode(',', $getFieldsColumns);
        
    echo json_encode(array('map_title' => $MapTitle, 'map_label' => $getFieldsColumns, 'map_data' => $mapData, 'map_type' => $MapType));
    }

 
}