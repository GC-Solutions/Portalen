<?php

namespace App\Controllers\Panels;

use \Core\View;
use App\Models\Page;
use \App\Models\User;
use \App\Models\Companies;
use \APP\Models\Placeholder;
use APP\Models\Execute;
use App\Controllers\DataFormatHelper\DataTableHelper;
use App\Controllers\GeneralCalculation\Calculation;

/**
 * Panels controller
 *
 * PHP version 7.0
 */
class Panels extends \Core\Controller
{
    public $_arrayList = array('ResultList');

    public function test1($arr) {
        $temp = array();
        foreach ($arr as $obj) {
            $vals = array_values($obj);
            array_push($temp,$vals);
        }
        return $temp;
    }
    // Gether general Informatiom to be displayed for panel
    public function getPanelInformationAction()
    {

        $placeholderId = (isset($_REQUEST['placeholderId'])) ? $_REQUEST['placeholderId'] : "";
        $id = (isset($_REQUEST['id'])) ? $_REQUEST['id'] : "";

        $getPlaceholderDetails = Page::getDatasourcePanelDetails($placeholderId);
        if(empty($getPlaceholderDetails))
        {
            $getPlaceholderDetails = Page::getDataTablePanelDetails($placeholderId);
        }
        
        $getPlaceholderActionDetails = Page::getPanelActionDetails($id);
        $panelColor = 'bg-success';
        $panelImage = 'style';
        $buttonAction = '';
        $buttonColor = '';
        $buttonText = '';
        $panelType = '';
        $TableId = '';
        $panelColumns = '';


        if ($getPlaceholderDetails) {
            $getPanelColor = (isset($getPlaceholderDetails[0]['PanelColor'])) ? $getPlaceholderDetails[0]['PanelColor'] : "";
            $getPanelText = (!empty($getPlaceholderDetails[0]['TextDesign2'])) ? $getPlaceholderDetails[0]['TextDesign2'] : "";
            $getPanelProgress = (isset($getPlaceholderDetails[0]['ProgressBarD3'])) ? $getPlaceholderDetails[0]['ProgressBarD3'] : "";
            $getImageName = (isset($getPlaceholderDetails[0]['ImageName'])) ? $getPlaceholderDetails[0]['ImageName'] : "";
            $TableId = (isset($getPlaceholderDetails[0]['TableId'])) ? $getPlaceholderDetails[0]['TableId'] : 0;
            $panelColumns = $getPlaceholderDetails[0]['penalColumns'];

            
            if($getPlaceholderDetails[0]['PanelType'] == '5'){
                if ($getPanelColor == 1) {
                    $panelColor = 'bg-danger';
                } else if ($getPanelColor == 2) {
                    $panelColor = 'cyan';
                } else if ($getPanelColor == 3) {
                    $panelColor = 'green';
                } else if ($getPanelColor == 4) {
                    $panelColor = 'bg-warning';
                }else if ($getPanelColor == 5) {
                    $panelColor = 'purple';
                }else if ($getPanelColor == 6) {
                    $panelColor = 'orange';
                }else if ($getPanelColor == 5) {
                    $panelColor = 'deepPink-bgcolor';
                }
            }else{
                if ($getPanelColor == 1) {
                    $panelColor = 'bg-danger';
                } else if ($getPanelColor == 2) {
                    $panelColor = 'bg-blue';
                } else if ($getPanelColor == 3) {
                    $panelColor = 'bg-success';
                } else if ($getPanelColor == 4) {
                    $panelColor = 'bg-warning';
                }else if ($getPanelColor == 5) {
                    $panelColor = 'purple';
                }else if ($getPanelColor == 6) {
                    $panelColor = 'orange';
                }else if ($getPanelColor == 5) {
                    $panelColor = 'deepPink-bgcolor';
                }
            }



            if ($getImageName) {
                $panelImage = $getImageName;
            }
        }

        $panelType = (isset($getPlaceholderDetails[0]['PanelType'])) ? $getPlaceholderDetails[0]['PanelType'] : 1 ;
        if ($getPlaceholderActionDetails && isset($getPlaceholderActionDetails[0]['PlaceholderActionIds']) && !empty($getPlaceholderActionDetails[0]['PlaceholderActionIds'])) {
            $externalUrl = $getPlaceholderActionDetails[0]['ExternalUrl'];
            if (!empty($externalUrl)) {
                $buttonAction = $externalUrl;
            } else {
                $buttonAction = baseUrl . 'page?id=' . $getPlaceholderActionDetails[0]['PageTargetId'];
            }

            $getButtonColor = (isset($getPlaceholderActionDetails[0]['ActionButtonColor'])) ? $getPlaceholderActionDetails[0]['ActionButtonColor'] : "";
            $buttonText = (isset($getPlaceholderActionDetails[0]['ActionButtonText'])) ? $getPlaceholderActionDetails[0]['ActionButtonText'] : "";


            if ($getButtonColor == 1) {
                $buttonColor = 'btn-danger';
            } else if ($getButtonColor == 2) {
                $buttonColor = 'btn-info';
            } else if ($getButtonColor == 3) {
                $buttonColor = 'btn-success';
            } else if ($getButtonColor == 4) {
                $buttonColor = 'btn-warning';
            }


        }
  
        echo json_encode(array('panelColor' => $panelColor, 'panelImage' => $panelImage,
            'buttonText' => $buttonText, 'buttonColor' => $buttonColor, 'buttonAction' => $buttonAction, 'tableId' =>$TableId, 'panelColumns' => $panelColumns, 'panelType' => $panelType , 'panelProgress' => $getPanelProgress , 'panelText' => $getPanelText));
        exit;
    }

     // Gether general Informatiom to be displayed for panel
    public function getPanelInformationTest($placeholderDetail)
    {

        $placeholderId = (isset($_REQUEST['placeholderId'])) ? $_REQUEST['placeholderId'] : "";
        $id = (isset($_REQUEST['id'])) ? $_REQUEST['id'] : "";

        $getPlaceholderDetails = $placeholderDetail;
        if(empty($getPlaceholderDetails))
        {
            $getPlaceholderDetails = Page::getDataTablePanelDetails($placeholderId);
        }
        
        $getPlaceholderActionDetails = Page::getPanelActionDetails($id);
        $panelColor = 'bg-success';
        $panelImage = 'style';
        $buttonAction = '';
        $buttonColor = '';
        $buttonText = '';
        $panelType = '';
        $TableId = '';
        $panelColumns = '';


        if ($getPlaceholderDetails) {
            $getPanelColor = (isset($getPlaceholderDetails[0]['PanelColor'])) ? $getPlaceholderDetails[0]['PanelColor'] : "";
            $getPanelText = (!empty($getPlaceholderDetails[0]['TextDesign2'])) ? $getPlaceholderDetails[0]['TextDesign2'] : "";
            $getPanelProgress = (isset($getPlaceholderDetails[0]['ProgressBarD3'])) ? $getPlaceholderDetails[0]['ProgressBarD3'] : "";
            $getImageName = (isset($getPlaceholderDetails[0]['ImageName'])) ? $getPlaceholderDetails[0]['ImageName'] : "";
            $TableId = (isset($getPlaceholderDetails[0]['TableId'])) ? $getPlaceholderDetails[0]['TableId'] : 0;
            $panelColumns = $getPlaceholderDetails[0]['penalColumns'];
            $allowDecimalFlag = $getPlaceholderDetails[0]['AllowDecimalFlag'];
            
            if($getPlaceholderDetails[0]['PanelType'] == '5'){
                if ($getPanelColor == 1) {
                    $panelColor = 'bg-danger';
                } else if ($getPanelColor == 2) {
                    $panelColor = 'cyan';
                } else if ($getPanelColor == 3) {
                    $panelColor = 'green';
                } else if ($getPanelColor == 4) {
                    $panelColor = 'bg-warning';
                }else if ($getPanelColor == 5) {
                    $panelColor = 'purple';
                }else if ($getPanelColor == 6) {
                    $panelColor = 'orange';
                }else if ($getPanelColor == 5) {
                    $panelColor = 'deepPink-bgcolor';
                }
            }else{
                if ($getPanelColor == 1) {
                    $panelColor = 'bg-danger';
                } else if ($getPanelColor == 2) {
                    $panelColor = 'bg-blue';
                } else if ($getPanelColor == 3) {
                    $panelColor = 'bg-success';
                } else if ($getPanelColor == 4) {
                    $panelColor = 'bg-warning';
                }else if ($getPanelColor == 5) {
                    $panelColor = 'purple';
                }else if ($getPanelColor == 6) {
                    $panelColor = 'orange';
                }else if ($getPanelColor == 5) {
                    $panelColor = 'deepPink-bgcolor';
                }
            }



            if ($getImageName) {
                $panelImage = $getImageName;
            }
        }

        $panelType = (isset($getPlaceholderDetails[0]['PanelType'])) ? $getPlaceholderDetails[0]['PanelType'] : 1 ;
        if ($getPlaceholderActionDetails && isset($getPlaceholderActionDetails[0]['PlaceholderActionIds']) && !empty($getPlaceholderActionDetails[0]['PlaceholderActionIds'])) {
            $externalUrl = $getPlaceholderActionDetails[0]['ExternalUrl'];
            if (!empty($externalUrl)) {
                $buttonAction = $externalUrl;
            } else {
                $buttonAction = baseUrl . 'page?id=' . $getPlaceholderActionDetails[0]['PageTargetId'];
            }

            $getButtonColor = (isset($getPlaceholderActionDetails[0]['ActionButtonColor'])) ? $getPlaceholderActionDetails[0]['ActionButtonColor'] : "";
            $buttonText = (isset($getPlaceholderActionDetails[0]['ActionButtonText'])) ? $getPlaceholderActionDetails[0]['ActionButtonText'] : "";


            if ($getButtonColor == 1) {
                $buttonColor = 'btn-danger';
            } else if ($getButtonColor == 2) {
                $buttonColor = 'btn-info';
            } else if ($getButtonColor == 3) {
                $buttonColor = 'btn-success';
            } else if ($getButtonColor == 4) {
                $buttonColor = 'btn-warning';
            }


        }
        return  array('panelColor' => $panelColor, 'panelImage' => $panelImage,
            'buttonText' => $buttonText, 'buttonColor' => $buttonColor, 'buttonAction' => $buttonAction, 'tableId' =>$TableId, 'panelColumns' => $panelColumns, 'panelType' => $panelType , 'panelProgress' => $getPanelProgress , 'panelText' => $getPanelText,'allowDecimalFlag' => $allowDecimalFlag);
        exit;
    }
    // Gether data to be displayed on panel
    public function getPanelDataAction()
    {
        set_time_limit(0);
        ini_set('memory_limit', '2G');
        $placeholderId = (isset($_REQUEST['placeholderId'])) ? $_REQUEST['placeholderId'] : "";
        $pholderId = (isset($_REQUEST['pholderid'])) ? $_REQUEST['pholderid'] : "";
        $searchValue = (isset($_REQUEST['searchvalue'])) ? $_REQUEST['searchvalue'] : "";
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
        $searchValueCount = '';

        if($searchValue) {
            $searchValue = (array)$searchValue[0];
            /*echo '<pre>';
            print_r($searchValue);*/
            $searchValueCount = count($searchValue);
            foreach($searchValue as $key=>$value) {
                //$searchValue[$key] = preg_replace('/\D/', '', $value);
                $searchValue[$key] = (int)str_replace(array(" ", ","), "", $value);
                if($searchValue[$key] == 0) {
                    $searchValue[$key] = $value;
                }
            }
            //$searchValue['Omsättning'] = preg_replace('/[^0-9.]/', '', $searchValue['Omsättning']);
        }
        //$searchValue['Omsättning'] = '99,7395';
        //$searchValue['Omsättning'] = preg_replace('/[^0-9,]/s', '', $searchValue['Omsättning']);

        //$searchValue['Omsättning'] = number_format($searchValue['Omsättning'], 2);


        $resultData = 0;
        $panelTitle = '';
        $dataFilteration = false;
        $getDatatableDetails = "";
        $accessTokenGAPI = "";
        $accessRefreshTokenGAPI ="";
        $requestGAPI = "" ;

        if (!empty($pholderId)) {
            $getDatatableDetails = Page::getDatasourceTableDetails($pholderId);
        }

        $getPlaceholderDetails = Page::getDatasourcePanelDetails($placeholderId);
        
     
        $linkedWithTable = $getPlaceholderDetails[0]['TableId'];
        
        $getUserDetails = User::getUserDetails($_SESSION['UserID']);
        if ($getUserDetails && $getPlaceholderDetails) {
           
            $keyColumnName = $getPlaceholderDetails[0]['KeyColumn'];
            if($linkedWithTable){
                $columnNamesDisplay = Page::getTableColumnsNew($linkedWithTable);
                
                if(isset($columnNamesDisplay) &&  !empty($columnNamesDisplay[0]['DisplayColumnNames'])){
                  
                   
                    $columnKey  = explode(',', $columnNamesDisplay[0]['Columns']);
                    $til = $getPlaceholderDetails[0]['Title'];
                    
                    $columnKey  = array_search(trim($til) ,  $columnKey);
                   
                    $newColumnName = explode(',', $columnNamesDisplay[0]['DisplayColumnNames']);
                   
                    if(!empty($columnKey)){
                        
                        if( trim($newColumnName[0]) == ""){
                            $panelTitle = $getPlaceholderDetails[0]['Title'];
                        }else{
                            $panelTitle =   $newColumnName[$columnKey];
                        } 
                        
                    }else {
                        $panelTitle = $getPlaceholderDetails[0]['Title'];
                    }

                   
                }else{
                    $panelTitle = $getPlaceholderDetails[0]['Title'];
                }
            }else{
                $panelTitle = $getPlaceholderDetails[0]['Title'];
            }
           
            $panelTableId = isset($getPlaceholderDetails[0]['TableId']) ? $getPlaceholderDetails[0]['TableId'] : 0;
            $panelFormula = $getPlaceholderDetails[0]['CustomSumFormula'];
            $panelSumType = $getPlaceholderDetails[0]['SumType'];
            $panelColumns = $getPlaceholderDetails[0]['penalColumns'];
            $denominationText = $getPlaceholderDetails[0]['DenominationText'];
            $customSumFormula = $getPlaceholderDetails[0]['CustomSumFormula'];
            $columnOperatoins = $getPlaceholderDetails[0]['ColumnOpr'];
            $requestType = $getPlaceholderDetails[0]['RequestType'];
            $panelType = $getPlaceholderDetails[0]['PanelType'];

            if(empty($linkedWithTable) ||  $panelSumType == 1 ){

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
                /*if (isset($columnName) && strpos($getSourceType, '('.$columnName.')') !== false) {
                    if(isset($columnValue)) {
                        $getSourceType = str_replace("(CustomerNo)", $columnValue, $getSourceType);
                    }
                }*/
                $getColumnsList = $getPlaceholderDetails[0]['Columns'];
                $companyAddress = $getCompanyDetails[0]['CompanyGISKey'];
                $companyToken = $getCompanyDetails[0]['CompanyGISToken'];

                if ($getDatatableDetails && $getPlaceholderDetails) {
                    if ($getDatatableDetails[0]['DataSourceId'] == $getPlaceholderDetails[0]['DataSourceId']) {
                        $keyValue = '';
                        if (!empty($searchValue)) {
                            $keyValue = (string) key($searchValue);
                            if (strpos($getColumnsList, $keyValue) !== false) {
                                $dataFilteration = true;
                            }
                        }
                    }
                }

                if ($getColumnsList) {
                    $getColumnsList = explode(',', $getColumnsList);
                }
             
               

                $requestBody = $getPlaceholderDetails[0]['Body'];

                $getPlaceholderColumn = trim($getPlaceholderDetails[0]['Placeholder']);

                if ($getPlaceholderColumn) {
                    $getRequestData = (isset($_REQUEST[$getPlaceholderColumn])) ? $_REQUEST[$getPlaceholderColumn] : "";

                    if ($getRequestData) {
                        $requestBody = str_replace("(" . $getPlaceholderColumn . ")", $getRequestData, $requestBody);
                    }
                }

                $sumType = $getPlaceholderDetails[0]['SumType'];
                $selectColumn = $getPlaceholderDetails[0]['penalColumns'];
                $requestGAPI = $getPlaceholderDetails[0]['SourceAddress'];
                $customSumFormula = $getPlaceholderDetails[0]['CustomSumFormula'];
                $accessTokenGAPI =  $getCompanyDetails[0]['GoogleAccessToken'];
                $accessRefreshTokenGAPI =  $getCompanyDetails[0]['GoogleAccessRefreshToken'];
                $requestUrl = str_replace("(address)", $companyAddress, $getSourceType);
                $requestUrl = str_replace("(token)", $companyToken, $requestUrl);
                if (strpos($requestBody, strtolower('(nowtime)')) !== false) {
                    if(isset($_SESSION['NowTime'])){
                        $requestBody = str_replace("(nowtime)", $_SESSION['NowTime'], $requestBody);
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
                                     if( isset($decodedResultsValue['dimensions']) && !empty($decodedResultsValue['dimensions']))
                                     {
                                        foreach ($decodedResultsValue['dimensions'] as $dimensionKey => $dimensionvalue) {
                                                array_push($resultss,$dimensionvalue );
                                            }
                                     }
                                    
                                     if(isset($decodedResultsValue['metrics']) && !empty($decodedResultsValue['metrics']))
                                     {
                                        foreach ($decodedResultsValue['metrics'][0]['values'] as $metricsKey => $metricsvalue) {
                                                array_push($resultss,$metricsvalue );
                                            }
                                     }
                                    
                                }
                                
                            }

                        }
                        $resultData = $resultss;
                        
                    }
                }
                else if ($requestType == 3) {
                    // if(isset($_SESSION[$getSourceType])){
                    //     $resultData = $_SESSION[$getSourceType];
                       
                    // }else{
                        $userCompanyDbName = $getCompanyDetails[0]['CompanyBABCDb'];
                        $resultData = User::executeQuery($getSourceType, $userCompanyDbName);
                        //$_SESSION[$getSourceType] = $resultData;

                        // if(!isset($_SESSION['queryName']) || (strpos($_SESSION['queryName'],$getSourceType) === false))
                        // {
                           
                        //     $_SESSION['queryName'] = !isset($_SESSION['queryName'])?($getSourceType):($_SESSION['queryName'].'|'.$getSourceType);
                           
                        // } 
                       
                    //}
                    
                    $resultData = Calculation::generalCalculation('Panel', $resultData , $sumType ,$dataFilteration ,  $getColumnsList , $searchValue , $selectColumn , $customSumFormula );
                    
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
                        $apiData = $decodedResults;
                        if ($decodedResults) {
                            foreach ($this->_arrayList as $key) {
                                if (isset($decodedResults[$key])) {
                                    $apiData = $decodedResults[$key];
                                    break;
                                }
                            }
                        }
                    $resultData = Calculation::generalCalculation('Panel', $apiData , $sumType ,$dataFilteration ,  $getColumnsList , $searchValue , $selectColumn , $customSumFormula );    
                    }

                }
               
                if ($resultData) {
                    if(!empty($resultData[$selectColumn])){
                        $resultData = number_format($resultData[$selectColumn]);
                    }else if(!empty($resultData['customSum']))
                    {
                        $resultData = number_format($resultData['customSum']);
                    }else
                    {
                       if(is_array($resultData))
                       {
                           $col =  explode(',' , $selectColumn);
                           $resultData = number_format($resultData[$col[0]]);
                       }else{
                            $resultData = number_format($resultData);
                       }
                        
                    }

                    $resultData = str_replace(',', '.', $resultData);
                    $resultData = trim($resultData) . ' ' . $denominationText;
                }
            }

        }
       
        $designValues = $this->getPanelInformationTest($getPlaceholderDetails);
        $panelFormula = $getPlaceholderDetails[0]['CustomSumFormula'];
        $panelSumType = $getPlaceholderDetails[0]['SumType'];
        $panelProgress = !empty($getPlaceholderDetails[0]['ProgressBarD3'])?$getPlaceholderDetails[0]['ProgressBarD3']:0;

        $panelD3Text = !empty($getPlaceholderDetails[0]['TextDesign2'])?$getPlaceholderDetails[0]['TextDesign2']:'';
        $EnableGroupRowCal = !empty($getPlaceholderDetails[0]['EnableGroupRowCal'])?$getPlaceholderDetails[0]['EnableGroupRowCal']:'0';
        $RowGroupColumnName = !empty($getPlaceholderDetails[0]['RowGroupColumnName'])?$getPlaceholderDetails[0]['RowGroupColumnName']:'';
        $TimeTableSeparator =  !empty($getPlaceholderDetails[0]['TimeTableSeparator'])?$getPlaceholderDetails[0]['TimeTableSeparator']:'';
        $ColumnDataType =  !empty($getPlaceholderDetails[0]['ColumnDataType'])?$getPlaceholderDetails[0]['ColumnDataType']:1;
        echo json_encode(array_merge($designValues , array('number' => $resultData, 'title' => $panelTitle, 'tableId' => $panelTableId, 'panelFormula' => $panelFormula, 'panelSumType' => $panelSumType,'panelColumns' => $panelColumns, 'columnOperatoins' => $columnOperatoins, 'denominationText' =>$denominationText , 'panelType' => $panelType , 'panelProgress' => $panelProgress , 'panelD3Text' => $panelD3Text , 'EnableGroupRowCal'=> $EnableGroupRowCal , 'RowGroupColumnName' => $RowGroupColumnName ,  'TimeTableSeparator' => $TimeTableSeparator , 'ColumnDataType' => $ColumnDataType )) );
    }


    // Custom formula that calculates the sum for custom sum 
    public function customFormulaResult($customSumColumnArray,$customSumFormula) {
        $resultData = '';
        if(!empty($customSumColumnArray)) {
            $customSumColumnDataArray = array();
            foreach($customSumColumnArray as $key=> $value){
                $customSumColumnDataArray[$key] = array_sum($value);
                //$customSumFilterData = str_replace($replaceColumn, $columnData, $customSumFormula);

                if (isset($customSumFormula) && !empty($customSumFormula)) {
                    $replaceColumn = "(" . $key . ")";
                    $columnData = round(array_sum($value));
                    $columnData = str_replace(array(',', ' '), '', $columnData);
                    $customSumData = str_replace($replaceColumn, $columnData, $customSumFormula);
                    $customSumFormula = $customSumData;
                }

            }


            if (strpos($customSumData, '--') === false && $customSumData !== '') {
                try{
                    @eval('$result = (' . @$customSumData . ');');
                }
                catch(Exception $e){

                    $result = 0;
                }
                if (is_nan($result)) {
                    $result = 0;
                } else if(is_infinite($result)) {
                    $result = 0;
                }
                $resultData = round($result,2);
            }
        }
        return $resultData;
    }

    
    // custom function that runs the custom sum formula 
    public function customRowResult ($customSumData) {
        if (strpos($customSumData, '--') === false) {
            try{
                @eval('$result = (' . @$customSumData . ');'); // this line basically perform the formala interpetation and calculation.
            }
            catch(Exception $e){
                $result = 0;
            }
            if (is_nan($result)) {
                $result = 0;
            } else if(is_infinite($result)) {
                $result = 0;
            }
            return round($result);
        }
    }

     // Custom formula to search  within array 
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




}