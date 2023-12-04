<?php

namespace App\Controllers\API;

use \Core\View;
use App\Models\Page;
use \App\Models\User;
use App\Models\Placeholder;
use App\Controllers\DataFormatHelper\DataTableHelper;
use App\Controllers\DataTables\DBDataSourceCallData;


class DBDataSourceCallRowCreation extends \Core\Controller
{
	public static function getDBDataSourceCallRowCreation( $getPlaceholderDetails , $getCompanyDetails, $getSourceType  ,  $tableActions , $getColumnsList , $explodeColumns , $keyColumnName , $searchValue , $actationTableColumn , 
		$filterion , $getColumnsProperties){
		// variable Declaration .
		$tableData = array();
		$sumType = $getPlaceholderDetails[0]['SumType'];
		$sumColumnLable = $getPlaceholderDetails[0]['SumColumnLable'];
        //For Action Button  
        if ($tableActions) {
            $actionButtons = "<div class='btn-group pull-right'>";
            $actionButtons .= "<a class='btn deepPink-bgcolor  btn-outline dropdown-toggle' data-toggle='dropdown'>Actions1";
            $actionButtons .= "<i class='fa fa-angle-down'></i></a>";

            $actionButtons .= "<ul class='dropdown-menu pull-right'>";
            $pageTextValue = array();
            foreach ($tableActions as $key => $eachAction) {
		        if(isset($key) && !in_array($key,$actationTableColumn)) {
                    foreach ($eachAction as  $k => $actionDetails) {
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
        // Fetch data from DataSource Call to DB 
        $allData = DBDataSourceCallData::getDBDataSourceCallData($getPlaceholderDetails , $getCompanyDetails, $getSourceType ); // Get the data from DB 
        //custom Sum Calculation for sum Type 1 
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
       
        // (Start) For loop for data fetched .
        foreach ($allData as  $eachRecord) {
            // Variable Declaration 
            $matchedData = false;
            $matchedValueCount = 0;
            $imgKeyCheck = 0;
            $imgKeyCheck1 = 0;
            $txt_ =  "";
            $class_ = "";
            $separator= "%";
            $keyColumnValue = '';
            $detailKeyColumnValue = '';
            $columnData = '';
            $customerAction = '';
            $customSumFormula = (isset($getPlaceholderDetails[0]['CustomSumFormula'])) ? $getPlaceholderDetails[0]['CustomSumFormula'] : "";
            //(Start) if column name list is not empty 
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
                //(Start)  for loop for column Names 
                foreach ($explodeColumns as $singleColumn => $singleColumnValue) {
                    
                    //(Start) Processing on Column name for Join Table 
                    if($getPlaceholderDetails[0]['TableType'] == 3) // for Join Table
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
                    //(End) Processing on Column name for Join Table 
                    $columnData = '';
                    if ($keyColumnName == $singleColumn) { // get row 
                        $keyColumnValue = $eachRecord[$singleColumn];
                    }
                    $singleColumn = trim($singleColumn);
                    if(isset($eachRecord[$singleColumn]))
                    {
                        $columnData = $eachRecord[$singleColumn];
                    }
                    //(Start) Processing for Custom Sum Formula and performing data formatting 
                    if($getPlaceholderDetails[0]['TableType'] != 3 )
                    {
                        if (isset($customSumFormula) && !empty($customSumFormula) && array_key_exists($singleColumn, $eachRecord)) // In case of CustomFormula replace the data 
                        {
                            $replaceColumn = "(" . $singleColumn . ")";
                            $sumColumnData = str_replace(array(',', ' '), '', $columnData);
                            $customSumData = str_replace($replaceColumn, $sumColumnData, $customSumFormula);
                            $customSumFormula = $customSumData;
                        }
                   
                        $columnData = DataTableHelper::ColumnProperties($columnData,$singleColumnValue); // Data Formating 
                        $columnData = DataTableHelper::columnDataRound($columnData,$singleColumnValue); // Data Formating 
                    }  
                    //(End) Processing for Custom Sum Formula and performing data formatting 
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
                    // Setting the paramter for Table Action 
                    if (array_key_exists($singleColumn, $tableActions)) {
                        foreach ($tableActions[$singleColumn] as $key => $value) {
                            $tableActions[$singleColumn][$key]['TableParameterColumnValue'] = $columnData;
                        }
                    }

                }
                //(End)  for loop for column Names 
                // (Start) for  Action button       
                if($tableActions){
                    //(Start) For all the table Action defined for that table rows .
                    foreach ($tableActions as $key => $eachAction) {
                    	if(isset($key) && !in_array($key,$actationTableColumn)) {
                        	foreach ($eachAction as $k => $actionDetails) {
                                // VAriable declaration and initialization 
		                        $tableParameterColumnValue = (isset($actionDetails['TableParameterColumnValue'])) ? $actionDetails['TableParameterColumnValue'] : "";
		                        $textValue = (isset($pageTextValue[$key][$k])?$pageTextValue[$key][$k]:'');
		                        $buttonAction = baseUrl . 'page?id=' . $actionDetails['PageTargetId'] . '&page_text='. $textValue .'&columnName=' . $actionDetails['TableParameterColumn'] . '&columnValue='.$tableParameterColumnValue;
			                    //(Start) if the action selected is Update DataSource . it can be update through form or predefined update .
                                if ($actionDetails['updateDataSource'] == 1) {
			                        $parameterArray = array('orderNoCol'=>$actionDetails['TableParameterColumn'],'orderNoValue'=> $tableParameterColumnValue,'baseUrl' => baseUrl, 'pageTextValue' => rawurlencode ($textValue), 'dataSourceId' => $actionDetails['DataSourceId'],'pageTargetId' => $actionDetails['PageTargetId']);
                                    $parameterArray = json_encode($parameterArray, JSON_UNESCAPED_SLASHES);
			                         // (Start) For predefined Update 
                                    if ($actionDetails['PredefinedUpdate'] == 1) {
			                            $buttonAction = 'getUpdatePredefined('. $parameterArray .')';
			                            $txt_ .=  $actionDetails['ActionButtonText'].$separator;
			                            $class_ .= str_replace("http://","",$buttonAction).$separator;
			                        } 
                                     // (End) For predefined Update 
                                      // (Start)For Update a DataSoucre Call 
			                        else if ($actionDetails['DataSourceCall'] == 1) {
			                            $buttonAction = 'getUpdateDataSourceCall('. $parameterArray .')';
			                            $txt_ .=  $actionDetails['ActionButtonText'].$separator;
			                            $class_ .= str_replace("http://","",$buttonAction).$separator;
			                        } 
                                    // (End)For Update a DataSoucre Call 
                                    // (Start)For Update row from Form  
			                         else {
			                            $buttonAction = baseUrl . 'getUpdateForm?dataSourceId=' . $actionDetails['DataSourceId'] .   '&pageId=' . $actionDetails['PageTargetId']  . '&columnName=' . $actionDetails['TableParameterColumn'] . '&columnValue=' . $tableParameterColumnValue .'&tableID=' . $actionDetails['TableTemplateId']. '&page_text='. rawurlencode ($textValue) ;
			                            $txt_ .=  $actionDetails['ActionButtonText'].$separator;
			                            $class_ .= str_replace("http://","",$buttonAction).$separator;
			                        }
                                    // (End))For Update row from Form 
			                    }
                                //(Start) if the action selected is Update DataSource . it can be update through form or predefined update .
			                    else {
                                    // (Start) if you want to Download a PDf normally a invoice .
			                        if ($actionDetails['IsPdf'] == 1) {
			                            $buttonAction = baseUrl . 'downloadPdf?dataSourceId=' . $actionDetails['DataSourceId'] . '&InvoiceNo=' . $tableParameterColumnValue;
			                            $txt_ .= $actionDetails['ActionButtonText'].$separator;
			                            $class_ .= str_replace("http://","",$buttonAction).$separator;
			                        } // (End) if you want to Download a PDf normally a invoice .
			                        else {
			                            $txt_ .= $actionDetails['ActionButtonText'].$separator;
			                            $class_ .= str_replace("http://","",$buttonAction).$separator;
			                        }
			                    }
                    		}
                		} 
                	}
                    //(End) For all the table Action defined for that table rows .
           		}
                //(End) For ACTION BUTTON .
                $sumColumnLable = trim($sumColumnLable);
                
                if(isset($sumColumnLable) && !empty($sumColumnLable) &&  $sumColumnLable == 'City')
                {
                     $dataToTable[] = 'ST';
                }
                //(Start) Else 
                else{
                    //(Start) FOr Custom SUm Calculation 
                    if (isset($sumColumnLable) && !empty($sumColumnLable)) { // Custom Formula Calcultion 
                        if (isset($explodeColumns)) {
                            if (!in_array($sumColumnLable, $explodeColumns)) {
                                // Will call the SUmm Calculation file after some more Testing .
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
                                            $dataToTable[$singleColumn] = $columnSumResults;

                                        } else {
                                            if(!empty($getColumnsProperties[$sumColumnLable])){
                                                $columnSumResults = DataTableHelper::ColumnProperties($columnSumResults,$getColumnsProperties[$sumColumnLable]);
                                            }
                                            $dataToTable[$singleColumn] = $columnSumResults;
                                        }

                                    } 
                                    else if ($sumType == 2) {
                                        $csData = explode(',' , $customSumData);
                                        $sumLabel = explode(',' , $sumColumnLable); 
                                        
                                        foreach ($csData as $key => $value) {
                                            if (strpos($value, '--') === false) {
                                                
                                                try{
                                                    @eval('$result = (' . @$value . ');');
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
                                                   
                                                    $dataToTable[$singleColumn] = $result;
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

                                                    $dataToTable[$singleColumn] = $result;

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
                     //(End) FOr Custom SUm Calculation 
                } // (End) Else

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
                if(isset($dataToTable['Images']) && !empty($dataToTable['Images']))
                {
                        $dataToTable['Images'] = explode(',', $dataToTable['Images']);

                }
                if(isset($_GET['search']))
                {
                    $checkCount = 0;
                    foreach ($dataToTable as $dataToTableKey => $dataToTableValue) {
                        if(is_array($dataToTableValue)){
                            $dataToTableValue = implode(',', $dataToTableValue);
                        }

                        if(strpos($dataToTableValue, $_GET['search']) !== false ){
                                $checkCount =  $checkCount + 1;
                                break;
                        }
                    }
                    if($checkCount == 0)
                    {
                        $dataToTable = [];
                    }
                }

                if($dataToTable){
                    if ($filterion) {

                        if($searchValueCount == $matchedValueCount) {
                            $tableData['data'][] = $dataToTable;
                        }
                    } else {
                        $tableData['data'][] = $dataToTable;
                    }
                }
            }
            //(End) if column name list is not empty 
        }
        // (End) For loop for data fetched .
        
    return $tableData ;

	}
}
?>