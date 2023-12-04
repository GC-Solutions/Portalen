<?php

namespace App\Controllers\Graphs;

use \Core\View;
use App\Models\Page;
use \App\Models\User;
use \App\Models\Companies;
use \APP\Models\Placeholder;
use App\Controllers\DataFormatHelper\DataTableHelper;
use App\Controllers\GeneralCalculation\Calculation;

/**
 * Graphs controller
 *
 * PHP version 7.0
 */
class Graphs extends \Core\Controller
{
    public $_arrayList = array('ResultList');
    // generate data for Graph
    public function generateGraphDataAction()
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

        $graphData = array();
        $graphTitle = '';
        $graphLabels = array();
        $getUserDetails = User::getUserDetails($_SESSION['UserID']);
        $graphType = 0;
        $buttonAction = '';
        $buttonColor = '';
        $buttonText = '';
        $filterColumn = '';
        $isTabelFlag = 0;

        $getPlaceholderActionDetails = Page::getGraphActionDetails($id);
        $getPlaceholderDetails = Page::getDatasourceGraphDetails($placeholderId);

        if(empty($getPlaceholderDetails))
        {
            $getPlaceholderDetails = Page::getDataTableGraphDetails($placeholderId);
            $isTabelFlag = 1;
        }
        
        if(!empty($getPlaceholderDetails) && !empty($isTabelFlag))
        {
            $graphTitle = $getPlaceholderDetails[0]['HeadersText'];
            $graphType = $getPlaceholderDetails[0]['GraphType'];
            $filterColumn = trim($getPlaceholderDetails[0]['Filters']);

            $graphData = '';
            $graphLabels[] = $getPlaceholderDetails[0]['XFieldLabel'];
            $graphLabels[] = $getPlaceholderDetails[0]['YFieldLabel'];
            if (isset($getPlaceholderDetails[0]['ZFieldLabel']) && !empty($getPlaceholderDetails[0]['ZFieldLabel'])) {
                $graphLabels[] = $getPlaceholderDetails[0]['ZFieldLabel'];
            }

        }
        else{
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
             $xAxis = array();
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
            $getDataSourceColumns = trim($getPlaceholderDetails[0]['Columns']);
            if ($getDataSourceColumns) {
                $getDataSourceColumns = explode(',', trim($getDataSourceColumns));
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
            $graphTitle = $getPlaceholderDetails[0]['HeadersText'];

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

            $graphType = $getPlaceholderDetails[0]['GraphType'];
            $filterColumn = trim($getPlaceholderDetails[0]['Filters']);

            $getColumnsList = array();
            $getColumnsList[] = $getPlaceholderDetails[0]['XField'];
            $getColumnsList[] = $getPlaceholderDetails[0]['YField'];
            if (isset($getPlaceholderDetails[0]['ZField']) && !empty($getPlaceholderDetails[0]['ZField'])) {
                $getColumnsList[] = $getPlaceholderDetails[0]['ZField'];
            }
            $graphLabels[] = $getPlaceholderDetails[0]['XFieldLabel'];
            $graphLabels[] = $getPlaceholderDetails[0]['YFieldLabel'];
            if (isset($getPlaceholderDetails[0]['ZFieldLabel']) && !empty($getPlaceholderDetails[0]['ZFieldLabel'])) {
                $graphLabels[] = $getPlaceholderDetails[0]['ZFieldLabel'];
            }

            $requestUrl = str_replace("(address)", $companyAddress, $getSourceType);
            $requestUrl = str_replace("(token)", $companyToken, $requestUrl);


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
            
            //print_r($getColumnsList); exit;
            if ($requestType == 3) {
                $userCompanyDbName = $getCompanyDetails[0]['CompanyBABCDb'];
                $allData = User::executeQuery($getSourceType, $userCompanyDbName);
                //print_r($allData); exit;
               // print_r($getColumnsList); exit;
                if ($allData) {
                   
                    $lastarr = array();
                    $countYaxis = array();
                    $yAxisVal = 0;
                    $yAxisSum = 0;
                    $countY2axis = array();
                    $y2AxisVal = 0;
                    $y2AxisSum = 0 ; $yAxisTotal = 0 ; $y2AxisTotal = 0;
                    $totalAxis = array();
                    foreach ($allData as $eachRecord) {
                        $newValue = array();
                        
                        array_push($xAxis, $eachRecord[$getPlaceholderDetails[0]['XField']]);
                        foreach ($getColumnsList as $col) {
                            array_push($newValue, $eachRecord[$col]);
                            
                        }
                        array_push($lastarr,$newValue);
                        if($eachRecord[$getPlaceholderDetails[0]['YField']]){
                            $yAxisVal = round($eachRecord[$getPlaceholderDetails[0]['YField']]);
                            $yAxisSum = $yAxisVal ? $yAxisVal : 0;
                            $countYaxis[$eachRecord[$getPlaceholderDetails[0]['XField']]] = $yAxisSum; 
                        }
                        if($eachRecord[$getPlaceholderDetails[0]['ZField']]){
                            $y2AxisVal = round($eachRecord[$getPlaceholderDetails[0]['ZField']]);
                            $y2AxisSum = $y2AxisVal ? $y2AxisVal : 0;
                            $countY2axis[$eachRecord[$getPlaceholderDetails[0]['XField']]] = $y2AxisSum; 
                        }

                        $totalAxis[1] = $yAxisTotal = $yAxisTotal + 
                        $countYaxis[$eachRecord[$getPlaceholderDetails[0]['XField']]];
                        //print_r($totalAxis[1]);
                        $totalAxis[2] =  $y2AxisTotal = $y2AxisTotal + $countY2axis[$eachRecord[$getPlaceholderDetails[0]['XField']]];
                    }
                   
                    $graphData = $lastarr;
               
                }
                // if ($allData) {
                //     // foreach ($allData as $eachRecord) {
                //     //     if (isset($getDataSourceColumns)) {
                //     //         $eachRowData = array();
                //     //         $matchedData = false;
                //     //         $matchedValueCount = 0;
                //     //         //$searchValueCount = !empty($searchValueArray) ? count($searchValueArray) : '';

                //     //         foreach ($getDataSourceColumns as $singleColumn) {
                //     //             $singleColumn = trim($singleColumn);
                //     //             if ($graphType == 1) {
                //     //                 $rowData = (isset($eachRecord[$singleColumn])) ? $eachRecord[$singleColumn] : "";
                //     //                 if ($rowData && is_numeric($rowData)) {
                //     //                     if ($rowData < 0) {
                //     //                         $rowData = abs($rowData);
                //     //                     }
                //     //                 }

                //     //                 if ($dataFilteration) {
                //     //                     $columnDataValue = strtolower($rowData);
                //     //                     if ($columnDataValue && is_numeric($columnDataValue)) {
                //     //                         $columnDataValue = round($columnDataValue);
                //     //                     }


                //     //                     if(isset($searchValue[$singleColumn])) {
                //     //                         $searchValueComumn = explode('|',$searchValue[$singleColumn]);
                //     //                         $searchValueComumnCount = count($searchValueComumn);
                //     //                         if($searchValueComumnCount > 1) {
                //     //                             for($i = 0; $i < $searchValueComumnCount; $i++ ) {
                //     //                                 if (strpos($columnDataValue, strtolower($searchValueComumn[$i])) !== false) {
                //     //                                     $matchedValueCount++;
                //     //                                 }
                //     //                             }
                //     //                         } else {
                //     //                             if (strpos($columnDataValue, strtolower($searchValueComumn[0])) !== false) {
                //     //                                 $matchedValueCount++;
                //     //                             }
                //     //                         }

                //     //                         /*$explodedColumn = explode('|',$searchValue[$singleColumn]);
                //     //                         if (strpos($columnDataValue, strtolower($explodedColumn[0])) !== false || strpos($columnDataValue, strtolower($explodedColumn[1])) !== false) {
                //     //                         //if (strpos($columnDataValue, $searchValue[$singleColumn]) !== false) {
                //     //                             $matchedData = true;
                //     //                             $matchedValueCount++;
                //     //                         }*/
                //     //                     }

                //     //                     if (in_array($singleColumn, $getColumnsList)) {
                //     //                         $eachRowData[$singleColumn] = $rowData;
                //     //                     }
                //     //                 } else {
                //     //                     if (in_array($singleColumn, $getColumnsList)) {
                //     //                         $eachRowData[$singleColumn] = $rowData;
                //     //                     }
                //     //                 }
                //     //             } else {
                //     //                 $rowData = (isset($eachRecord[$singleColumn])) ? $eachRecord[$singleColumn] : "";
                //     //                 if ($dataFilteration) {
                //     //                     $columnDataValue = strtolower($rowData);
                //     //                     if ($columnDataValue && is_numeric($columnDataValue)) {
                //     //                         $columnDataValue = round($columnDataValue);
                //     //                     }

                //     //                     if(isset($searchValue[$singleColumn])) {
                //     //                         $searchValueComumn = explode('|',$searchValue[$singleColumn]);
                //     //                         $searchValueComumnCount = count($searchValueComumn);
                //     //                         if($searchValueComumnCount > 1) {
                //     //                             for($i = 0; $i < $searchValueComumnCount; $i++ ) {
                //     //                                 if (strpos($columnDataValue, strtolower($searchValueComumn[$i])) !== false) {
                //     //                                     $matchedValueCount++;
                //     //                                 }
                //     //                             }
                //     //                         } else {
                //     //                             if (strpos($columnDataValue, strtolower($searchValueComumn[0])) !== false) {
                //     //                                 $matchedValueCount++;
                //     //                             }
                //     //                         }
                //     //                         /*$explodedColumn = explode('|',$searchValue[$singleColumn]);
                //     //                         if (strpos($columnDataValue, strtolower($explodedColumn[0])) !== false || strpos($columnDataValue, strtolower($explodedColumn[1])) !== false) {
                //     //                         //if (strpos($columnDataValue, $searchValue[$singleColumn]) !== false) {
                //     //                             $matchedData = true;
                //     //                             $matchedValueCount++;
                //     //                         }*/
                //     //                     }

                //     //                     if (in_array($singleColumn, $getColumnsList)) {
                //     //                         $eachRowData[$singleColumn] = $rowData;
                //     //                     }
                //     //                 } else {
                //     //                     if (in_array($singleColumn, $getColumnsList)) {
                //     //                         $eachRowData[$singleColumn] = $rowData;
                //     //                     }
                //     //                 }
                //     //             }
                //     //         }
                //     //         $eachGroupData = array();
                //     //         if ($eachRowData) {
                //     //             if ($getColumnsList) {
                //     //                 foreach ($getColumnsList as $column) {
                //     //                     $eachGroupData[] = (isset($eachRowData[$column])) ? $eachRowData[$column] : "";
                //     //                 }
                //     //             }
                //     //         }
                //     //         if ($dataFilteration) {
                //     //             if($searchValueCount == $matchedValueCount) {
                //     //                 $graphData[] = $eachGroupData;
                //     //             }
                //     //         } else {
                //     //             $graphData[] = $eachGroupData;
                //     //         }
                //     //     }
                //     // }
                // }
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
                        foreach ($apiData as $eachRecord) {
                            if (isset($getDataSourceColumns)) {
                                $eachRowData = array();
                                $matchedData = false;
                                $matchedValueCount = 0;
                                //$searchValueCount = !empty($searchValueArray) ? count($searchValueArray) : '';
                                foreach ($getDataSourceColumns as $singleColumn) {
                                    $eachColumn = trim($singleColumn);
                                    if ($graphType == 1) {
                                        $rowData = Self::searchArray($eachRecord, $eachColumn);
                                        if ($rowData && is_numeric($rowData)) {
                                            if ($rowData < 0) {
                                                $rowData = abs($rowData);
                                            }
                                        }

                                        if ($dataFilteration) {
                                            $columnDataValue = strtolower($rowData);
                                            if ($columnDataValue && is_numeric($columnDataValue)) {
                                                $columnDataValue = round($columnDataValue);
                                            }
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

                                                /*$explodedColumn = explode('|',$searchValue[$singleColumn]);
                                                if (strpos($columnDataValue, strtolower($explodedColumn[0])) !== false || strpos($columnDataValue, strtolower($explodedColumn[1])) !== false) {
                                                //if (strpos($columnDataValue, $searchValue[$singleColumn]) !== false) {
                                                    $matchedData = true;
                                                    $matchedValueCount++;
                                                }*/
                                            }
                                           /* if (!empty($columnDataValue) && !empty($searchValueArray)) {
                                                foreach ($searchValueArray as $searchValue) {
                                                    if(isset($searchValue) && !empty($searchValue)) {
                                                        if (strpos($columnDataValue, $searchValue) !== false) {
                                                            $matchedData = true;
                                                            $matchedValueCount++;
                                                        }
                                                    }
                                                }
                                            }*/


                                            /*if (!empty($columnDataValue) && strpos($columnDataValue, $searchValue) !== false) {
                                                $matchedData = true;
                                            }*/

                                            if (in_array($eachColumn, $getColumnsList)) {
                                                $eachRowData[$eachColumn] = $rowData;
                                            }
                                        } else {
                                            if (in_array($eachColumn, $getColumnsList)) {
                                                $eachRowData[$eachColumn] = $rowData;
                                            }
                                        }
                                    } else {
                                        $rowData = Self::searchArray($eachRecord, $eachColumn);
                                        if ($dataFilteration) {
                                            $columnDataValue = strtolower($rowData);
                                            if ($columnDataValue && is_numeric($columnDataValue)) {
                                                $columnDataValue = round($columnDataValue);
                                            }
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
                                                /*$explodedColumn = explode('|',$searchValue[$singleColumn]);
                                                if (strpos($columnDataValue, strtolower($explodedColumn[0])) !== false || strpos($columnDataValue, strtolower($explodedColumn[1])) !== false) {
                                                //if (strpos($columnDataValue, $searchValue[$singleColumn]) !== false) {
                                                    $matchedData = true;
                                                    $matchedValueCount++;
                                                }*/
                                            }
                                            /*if (!empty($columnDataValue) && !empty($searchValueArray)) {
                                                foreach ($searchValueArray as $searchValue) {
                                                    if(isset($searchValue) && !empty($searchValue)) {
                                                        if (strpos($columnDataValue, $searchValue) !== false) {
                                                            $matchedData = true;
                                                            $matchedValueCount++;
                                                        }
                                                    }
                                                }
                                            }*/
                                           /* if (!empty($columnDataValue) && strpos($columnDataValue, $searchValue) !== false) {
                                                $matchedData = true;
                                            }*/



                                            if (in_array($eachColumn, $getColumnsList)) {
                                                $eachRowData[$eachColumn] = $rowData;
                                            }
                                        } else {
                                            if (in_array($eachColumn, $getColumnsList)) {
                                                $eachRowData[$eachColumn] = $rowData;
                                            }
                                        }
                                    }

                                }
                                $eachGroupData = array();
                                if ($eachRowData) {
                                    if ($getColumnsList) {
                                        foreach ($getColumnsList as $column) {
                                            $eachGroupData[] = (isset($eachRowData[$column])) ? $eachRowData[$column] : "";
                                        }
                                    }
                                }

                                if ($dataFilteration) {
                                    if($searchValueCount == $matchedValueCount) {
                                        $graphData[] = $eachGroupData;
                                    }
                                } else {
                                    $graphData[] = $eachGroupData;
                                }
                            }
                        }
                    }
                }
            }
        }
    }
        $countAxis = array('yaxis' => $countYaxis , 'y2axis' => $countY2axis , 'totalAxis' => $totalAxis );
        
        echo json_encode(array('', 'xAxis' => $xAxis  ,'graph_title' => $graphTitle, 'graph_labels' => $graphLabels, 'filter_column' => $filterColumn,
            'graph_data' => $graphData, 'graph_type' => $graphType,
            'buttonText' => $buttonText, 'buttonColor' => $buttonColor, 'buttonAction' => $buttonAction , 'dataSourceCallCheck' => '1'));
    }


    // this Function get all the necesary information for generating a highchart as stand alone 
    function generateGraphDataHighChartAction() {
        set_time_limit(0);
        ini_set('memory_limit', '2G');
        $placeholderId = (isset($_REQUEST['placeholderId'])) ? $_REQUEST['placeholderId'] : "";
        $id = (isset($_REQUEST['id'])) ? $_REQUEST['id'] : "";
        $getPlaceholderDetails = Page::getDatasourceGraphDetails($placeholderId);
        
        $getUserDetails = User::getUserDetails($_SESSION['UserID']);
        if ($getUserDetails && $getPlaceholderDetails) {
            $graphType = $getPlaceholderDetails[0]['GraphType'];
            $deactivate3D = $getPlaceholderDetails[0]['Deactivate3d'];
            $filterColumn = trim($getPlaceholderDetails[0]['Filters']);

            $getColumnsList = array();
            $graphTitle = '';
            $getColumnsList['xAxis'] = $getPlaceholderDetails[0]['XField'];
            $getColumnsList['yAxis'] = $getPlaceholderDetails[0]['YField'];
            if (isset($getPlaceholderDetails[0]['ZField']) && !empty($getPlaceholderDetails[0]['ZField'])) {
                $getColumnsList[''] = $getPlaceholderDetails[0]['ZField'];
            }
            $graphLabels['xAxis'] = $getPlaceholderDetails[0]['XFieldLabel'];
            $graphLabels['yAxis'] = $getPlaceholderDetails[0]['YFieldLabel'];
            if (isset($getPlaceholderDetails[0]['ZFieldLabel']) && !empty($getPlaceholderDetails[0]['ZFieldLabel'])) {
                $graphLabels['zAxis'] = $getPlaceholderDetails[0]['ZFieldLabel'];
            }
            $graphTitle = $getPlaceholderDetails[0]['HeadersText'];
            echo json_encode(array('graph_title' => $graphTitle, 'graph_labels' => $graphLabels, 'filter_column' => $filterColumn,
                'graph_data' => '', 'graph_type' => $graphType, 'deactivate_3D' => $deactivate3D));
        }
    }
    // Part for Pie Charts 

    function generatePieChartDataAction(){

        set_time_limit(0);
        ini_set('memory_limit', '2G');

        $placeholderId = (isset($_REQUEST['placeholderId'])) ? $_REQUEST['placeholderId'] : "";
        $pholderId = (isset($_REQUEST['pholderid'])) ? $_REQUEST['pholderid'] : "";
        $searchValue = (isset($_REQUEST['searchvalue'])) ? $_REQUEST['searchvalue'] : "";
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
        $returnValue = array();
        $pieChartTitle = '';
        $getUserDetails = User::getUserDetails($_SESSION['UserID']);
        $pieChartType = 0;
        $pieDisplayType = 0;
        $filterColumn = '';
        $getPlaceholderDetails = Page::getDatasourcePieChartDetails($placeholderId);
        $dataValue = array(); 
        if ($getUserDetails && $getPlaceholderDetails) {
            $getCompanyDetails = Companies::getCompanyDetails($getUserDetails[0]['CompanyID']);
            $getSourceType = $getPlaceholderDetails[0]['SourceAddress'];
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
            $pieChartTitle = $getPlaceholderDetails[0]['HeadersText'];

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

            $pieChartType = $getPlaceholderDetails[0]['PieChartType'];
            $pieDisplayType = $getPlaceholderDetails[0]['DisplayType'];
           
            $requestUrl = str_replace("(address)", $companyAddress, $getSourceType);
            $requestUrl = str_replace("(token)", $companyToken, $requestUrl);
            $sum = array();

            $CustomNameLabel = $getPlaceholderDetails[0]['CustomNameLabel'];
             //print_r($getPlaceholderDetails); exit;
           
            if ($requestType == 3) {
                $userCompanyDbName = $getCompanyDetails[0]['CompanyBABCDb'];
                $allData = User::executeQuery($getSourceType, $userCompanyDbName);
                
                }else{
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
                        $allData = $decodedResults;
                        if ($decodedResults) {
                            foreach ($this->_arrayList as $key) {
                                if (isset($decodedResults[$key])) {
                                    $allData = $decodedResults[$key];
                                    break;
                                }
                            }
                        }
                    }
                }
            
            $newArr = array();  

            if(!empty($allData)){
                
                $mainCol = isset($getPlaceholderDetails[0]['Fields'])?explode(',', $getPlaceholderDetails[0]['Fields']):'';
                if(count($mainCol) == 1 && $getPlaceholderDetails[0]['CalculationType'] == 1){
                     
                     foreach ($allData as $key => $value) {
                        if(isset($newArr[$value[$mainCol[0]]])){
                            $newArr[$value[$mainCol[0]]] = (int)$newArr[$value[$mainCol[0]]] + 1 ;
                        }else{
                            $newArr[$value[$mainCol[0]]] = 0;
                        }
                    }
                    if(isset($getPlaceholderDetails[0]['DisplayType']) && $getPlaceholderDetails[0]['DisplayType'] == 1 ){
                            $cnt = count($allData);
                            $tempArr = array();
                            foreach ($newArr as $key => $value) {
                                $newArr[$key] = (($value/$cnt)*100);
                            }
                        }
                    
                    $returnValue = $newArr;

                }else if(count($mainCol) == 2 && $getPlaceholderDetails[0]['CalculationType'] == 2){
                    foreach ($allData as $key => $value) {

                        if(isset($newArr[$value[$mainCol[0]]])){

                            $newArr[$value[$mainCol[0]]] = (int)$newArr[$value[$mainCol[0]]] + (int)$value[$mainCol[1]];
                        }else{
                            $newArr[$value[$mainCol[0]]] = (int)$value[$mainCol[1]] ;
                        } 
                    }
                    $temp = $newArr;
                    $cnt = array_sum($temp);

                    if(isset($getPlaceholderDetails[0]['DisplayType']) && $getPlaceholderDetails[0]['DisplayType'] == 1 ) {
                            
                            $tempArr = array();
                            if(!empty($cnt)){
                                foreach ($newArr as $key => $value) {
                                    $newArr[$key] = (($value/$cnt)*100);
                                }
                            }
                        }
                    $returnValue = $newArr;
                }else if($getPlaceholderDetails[0]['CalculationType'] == 3){
                    $returnValue = Calculation::generalCalculation('PieChart', $allData , $sumtype = 3 ,$dataFilteration ,  $getDataSourceColumns , $searchValue ,$getPlaceholderDetails[0]['Fields'] , $getPlaceholderDetails[0]['CustomSumFormula'] , $CustomNameLabel );

                    if(!empty($getPlaceholderDetails[0]['CustomSumFormula'])){
                        $csFormula = explode('|', $getPlaceholderDetails[0]['CustomSumFormula']);
                        $CustomNameLabel = explode('|', $CustomNameLabel);
                        foreach ($csFormula as $key => $value) {
                            $tempVal = 0;
                           
                            if (array_key_exists($value, $returnValue)) {
                               
                                $tempVal = $returnValue[$value];
                                unset($returnValue[$value]);
                                $returnValue[$CustomNameLabel[$key]] = $tempVal;
                            }
                         
                            
                        }
                    }
                }
                
                $cnt = 0;
                foreach ($returnValue as $key => $value) {
                  $dataValue[$cnt]['name']=  $key;
                  $dataValue[$cnt]['value']=  $value;
                  $cnt = $cnt +1;
                }  
            }
        }
   
      echo json_encode(array('pie_chart_title' => $pieChartTitle, 'pie_data' => $dataValue, 'chart_type' => $pieChartType , "display_type" => $pieDisplayType));

    }


}