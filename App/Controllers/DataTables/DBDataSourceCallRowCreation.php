<?php

namespace App\Controllers\DataTables;

use \Core\View;
use App\Models\Page;
use \App\Models\User;
use App\Models\Placeholder;
use App\Controllers\DataFormatHelper\DataTableHelper;
use App\Controllers\DataTables\DBDataSourceCallData;


class DBDataSourceCallRowCreation extends \Core\Controller
{
	public static function getDBDataSourceCallRowCreation( $getPlaceholderDetails , $getCompanyDetails, $getSourceType  ,  $tableActions , $getColumnsList , $explodeColumns , $keyColumnName , $searchValue , $actationTableColumn , 
		$filterion , $getColumnsProperties , $oldSourceType){
		// variable Declaration .
		$tableData = array();
		$sumType = $getPlaceholderDetails[0]['SumType'];
		$sumColumnLable = $getPlaceholderDetails[0]['SumColumnLable'];
        $placeholderId = (isset($_REQUEST['placeholderId'])) ? $_REQUEST['placeholderId'] : "";
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
        $allData = DBDataSourceCallData::getDBDataSourceCallData($getPlaceholderDetails , $getCompanyDetails, $getSourceType , $oldSourceType); // Get the data from DB 

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
       // print_r($allData); exit;
        foreach ($allData as  $eachRecord) {
            // Variable Declaration 
            $matchedData = false;
            $matchedValueCount = 0;
            $imgKeyCheck = 0;
            $imgKeyCheck1 = 0;
            $imgLinkKeyCheck = 0;
            $imgLinkKeyCheck1 = 0;
            $imgLinkAKeyCheck = 0;
            $imgLinkAKeyCheck1 = 0;
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
                //(Start)  for loop for column Names 
                foreach ($explodeColumns as $singleColumn => $singleColumnValue) {
                    
                    // Processing for Images Column .
                    if(array_key_exists('Images', $eachRecord)) // check if the Image Column is Present 
                    {
                        $imgKeyCheck =  $imgKeyCheck + 1 ;
                    }  
                    if($singleColumn == 'Images') // check if the Image Column is Present 
                    {
                        $imgKeyCheck1 =  $imgKeyCheck ;
                    }

                    // Processing for Images Column .
                    if(array_key_exists('image_link', $eachRecord) ) // check if the Image Column is Present 
                    {
                        $imgLinkKeyCheck =  $imgLinkKeyCheck + 1 ;
                    }  
                    if($singleColumn == 'image_link'  ) // check if the Image Column is Present 
                    {
                        $imgLinkKeyCheck1 =  $imgLinkKeyCheck ;
                    }
                    
                    if( array_key_exists('additional_image_link', $eachRecord)) // check if the Image Column is Present 
                    {
                        $imgLinkAKeyCheck =  $imgLinkAKeyCheck + 1 ;
                    }  
                    if( $singleColumn == 'additional_image_link' ) // check if the Image Column is Present 
                    {
                        $imgLinkAKeyCheck1 =  $imgLinkAKeyCheck ;
                    }
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
                        if($columnData == INF)
                        {
                            $columnData = $eachRecord[$singleColumn];
                        }
               
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
                                $externalUrl = $actionDetails['ExternalUrl'];
		                        $tableParameterColumnValue = (isset($actionDetails['TableParameterColumnValue'])) ? $actionDetails['TableParameterColumnValue'] : "";
		                       
                                // if(count($tableActions) == 1) {
                                //     $orderNoCol = '';
                                //     $orderNoValue = '';
                                //     $orderNoCol = $actionDetails['TableParameterColumn'];
                                //     $orderNoValue = $tableParameterColumnValue;
                                    
                                // }
                                //$pageTextValue = '';
                                //(Start) Get page Text 
                                // if($_SESSION['UserID'] && $actionDetails['PageTargetId']) {
                                //     $pageText = Page::getPageText($actionDetails['PageTargetId'], $_SESSION['UserID']);
                                //     if($pageText) {
                                //         $pageTextValue = $pageText[0]['PageMenuText'];
                                //     }
                                // }
                                $textValue = (isset($pageTextValue[$key][$k])?$pageTextValue[$key][$k]:'');
		                        
                                 //(End) Get page Text 
                                 //(Start) In Case if External Url is defined 
                                if (!empty($externalUrl)) {
                                    $buttonAction = $externalUrl;
                                } //(end)In Case if External Url is defined 
                                else {
                                //(Start) if external Url not defined 
                                    $buttonAction = baseUrl . 'page?id=' . $actionDetails['PageTargetId'] . '&page_text='. $textValue .'&columnName=' . $actionDetails['TableParameterColumn'] . '&columnValue='.$tableParameterColumnValue;
			                    
                                }
                                $parameterArray = array('orderNoCol'=>$actionDetails['TableParameterColumn'],'orderNoValue'=> $tableParameterColumnValue,'baseUrl' => baseUrl, 'pageTextValue' => rawurlencode ($textValue), 'dataSourceId' => $actionDetails['DataSourceId'],'pageTargetId' => $actionDetails['PageTargetId']);
                                $parameterArray = json_encode($parameterArray, JSON_UNESCAPED_SLASHES);
                                
                                //(Start) if the action selected is Update DataSource . it can be update through form or predefined update .
                                if ($actionDetails['updateDataSource'] == 1) {
			                       // (Start) For predefined Update 
                                    if ($actionDetails['PredefinedUpdate'] == 1) {
			                            $buttonAction = 'getUpdatePredefined('. $parameterArray .')';
			                            $txt_ .=  $actionDetails['ActionButtonText'].$separator;
			                            $class_ .= str_replace("http://","",$buttonAction).$separator;
			                        } 
                                     // (End) For predefined Update 
                                    
                                    // (Start)For Update row from Form  
			                         else {
			                            $buttonAction = baseUrl . 'getUpdateForm?dataSourceId=' . $actionDetails['DataSourceId'] .   '&pageId=' . $actionDetails['PageTargetId']  . '&columnName=' . $actionDetails['TableParameterColumn'] . '&columnValue=' . $tableParameterColumnValue .'&tableID=' . $actionDetails['TableTemplateId']. '&page_text='. rawurlencode ($textValue) ;
			                           
                                        $txt_ .=  $actionDetails['ActionButtonText'].$separator;
			                            $class_ .= str_replace("http://","",$buttonAction).$separator;
			                        }
                                    // (End))For Update row from Form 
			                    }
                                  // (Start)For Update a DataSoucre Call 
			                    else if ($actionDetails['DataSourceCall'] == 1) {
			                            $buttonAction = 'getUpdateDataSourceCall('. $parameterArray .')';
			                            $txt_ .=  $actionDetails['ActionButtonText'].$separator;
			                            $class_ .= str_replace("http://","",$buttonAction).$separator;
			                    } 
                                // (End)For Update a DataSoucre Call 
                                //(Start) if the action selected is Update DataSource . it can be update through form or predefined update .
			                    else {
                                    // (Start) if you want to Download a PDf normally a invoice .
			                        if ($actionDetails['IsPdf'] == 1) {
			                            $buttonAction = baseUrl . 'downloadPdf?dataSourceId=' . $actionDetails['DataSourceId'] . '&InvoiceNo=' . $tableParameterColumnValue;
			                            $txt_ .= $actionDetails['ActionButtonText'].$separator;
			                            $class_ .= str_replace("http://","",$buttonAction).$separator;
			                        } // (End) if you want to Download a PDf normally a invoice .
                                    else if($actionDetails['FormOnActionBTN'] == 1) {
                                      
                                        $buttonAction = 'LiveAPISyncReport("create" , "'.$placeholderId.'" , "2" ,  "0","'.$buttonAction.'" ,"1" , "'.$actionDetails['TableParameterColumn'].'" , "'.$tableParameterColumnValue.'")';
                                        $txt_ .=  $actionDetails['ActionButtonText'].$separator;
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
											
                                            if (strpos($value, '--') === false){
                                               
                                                try{
													if (strpos($value, '/*') === false) {
														@eval('$result = (' . @$value . ');');
													}else{
                                                    	$result = 0;
													}
													 
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
                                                    
                                                    $dataToTable[] = round($result);
                                                }
                                            }
                                            else{

                                               $value = str_replace('--', '+', $value);
                                               try{
												   	if(strpos($value, '/*') === false){
                                                    	@eval('$result = (' . @$value . ');');
												   	}
                                                    //eval("\$result = $customSumData;");
                                                }
                                                catch(Exception $e){
                                                   $result = 0;
                                                }
												//$result = (int)$result; 
                                                if (gettype($result) != 'string' && is_nan($result)) {
                                                    $result = 0;
                                                } else if(gettype($result) != 'string' && is_infinite($result)) {
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
													 
                                                    $dataToTable[$singleColumn] = round($result);
													
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
                // (Start) Separate image as its Comma seapated value in DB . 
                if($imgKeyCheck1) 
                {
                    // Processing that will separate the URL for iMage and will show 6 images . can change the Number from her .
                    if($dataToTable[$imgKeyCheck1-1])
                    {
                        $img = explode(',', $dataToTable[$imgKeyCheck1-1]);
                        $dataToTable[$imgKeyCheck1-1] = $img[0];
                        for ($i=1; $i <= 10 ; $i++) { 
                            if(isset($img[$i])){
                                $dataToTable[] = $img[$i];
                            }else{
                                $dataToTable[] = '';
                            }
                        }
                    }
                    else{
                        for ($i=1; $i <= 10 ; $i++) { 
                            $dataToTable[] = '';
                        }
                    }
                  
                }
                if($imgLinkKeyCheck1) 
                {
                    // Processing that will separate the URL for iMage and will show 1 images . can change the Number from her .
                    if($dataToTable[$imgLinkKeyCheck1-1])
                    {
                        $img = explode(',', $dataToTable[$imgLinkKeyCheck1-1]);
                       
                        $dataToTable[$imgLinkKeyCheck1-1] = $img[0];
                       
                       
                    }
                    else{
                       
                            $dataToTable[] = '';
                    }
                  
                }
                if($imgLinkAKeyCheck1) 
                {
                    // Processing that will separate the URL for iMage and will show 1 images . can change the Number from her .
                    if($dataToTable[$imgLinkAKeyCheck1-1])
                    {
                        $img = explode(',', $dataToTable[$imgLinkAKeyCheck1-1]);
                       
                        unset($img[0]);
                        $dataToTable[$imgLinkAKeyCheck1-1] = implode(',' , $img);
                       
                    }
                    else{
                       
                            $dataToTable[] = '';
                    }
                  
                }
                // (End) Separate image as its Comma seapated value in DB . 
                if($tableActions){
                    $dataToTable[] = $txt_ ;
                    $dataToTable[] = $class_ ;
                }
                if($getPlaceholderDetails[0]['AddZeroForNegVal']){
                    $ColAddZeroForNegVal = isset($getPlaceholderDetails[0]['ColAddZeroForNegVal'])?explode(',',$getPlaceholderDetails[0]['ColAddZeroForNegVal']):[];
                    $COLName = $getPlaceholderDetails[0]['tableColumns'].','.$getPlaceholderDetails[0]['SumColumnLable'];
                    $COLName = trim($COLName,',');
                    $COLName = explode(',' , $COLName);
                    $COLNameDisplay = isset($getPlaceholderDetails[0]['DisplayColumnNames'])?($getPlaceholderDetails[0]['DisplayColumnNames'].','.$getPlaceholderDetails[0]['SumColumnLable']):'';
                    
													
				
					
					
					
					
                    foreach($ColAddZeroForNegVal as $NKey => $NVal){
                        foreach($COLName as $COLNameKey => $COLNameVal){
                            if(!is_array($COLNameDisplay)){
                                
                                $COLNameDisplay = trim($COLNameDisplay,',');
                                $COLNameDisplay = explode(',' , $COLNameDisplay );
                                if(trim($COLName[$COLNameKey]) == trim($NVal) || trim($COLNameDisplay[$COLNameKey]) == trim($NVal) ){
                                    
                                        if(strpos($dataToTable[$COLNameKey] , '-') !== false){
                                            $dataToTable[$COLNameKey]  =  0;
                                            
                                        }
                                    
                                    
                                }
                            }else{
                                    
                                if(($COLName[$COLNameKey]) == trim($NVal)){
                                    if(strpos($dataToTable[$COLNameKey] , '-') !== false){
                                        $dataToTable[$COLNameKey]  = 0;
                                        
                                    }
                                    
                                    
                                }
                            }

                        }
                    }
                }
				
				
					$tempArrColumnSort = array();		
		            $COLName = $getPlaceholderDetails[0]['tableColumns'].','.$getPlaceholderDetails[0]['SumColumnLable'];
                    $COLName = trim($COLName,',');
                    $COLName = explode(',' , $COLName);
				$COLNameSort = [];
				if(trim($getPlaceholderDetails[0]['ColumnSort']) && trim($getPlaceholderDetails[0]['ColumnSort'])!=''){
					$ColumnSort = explode(',' ,trim($getPlaceholderDetails[0]['ColumnSort']));
				
					foreach($ColumnSort as $K => $V){
						$newKey = array_search($V , $COLName);
							$tempArrColumnSort[] =  $dataToTable[$newKey];
					//$tableData['data'][] = null;
						// $dataToTable2[] =$tempArrColumnSort;
					}
					$dataToTable = $tempArrColumnSort;
					
				}
		
				
				
                if ($filterion) {
                    if($searchValueCount == $matchedValueCount) 
                    {
                        $tableData['data'][] = $dataToTable;
                    }
                } else {
                    $tableData['data'][] = $dataToTable;
                }
            }

            //(End) if column name list is not empty 
        }
												
						
				
	
        // (End) For loop for data fetched .
	
    return $tableData ;

	}
}
?>