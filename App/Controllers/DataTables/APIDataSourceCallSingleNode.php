<?php

namespace App\Controllers\DataTables;

use \Core\View;
use App\Models\Page;
use \App\Models\User;
use App\Models\Placeholder;
use App\Controllers\DataFormatHelper\DataTableHelper;
use App\Controllers\DataTables\APIDataSourceCallData;
use App\Controllers\DataTables\GeneralDataTableFtn;
use App\Controllers\DataTables\SumCalculation;
use App\Controllers\DataTables\ActionButton;
use Exception;

class APIDataSourceCallSingleNode extends \Core\Controller
{
	// Global Variable 
    public $retval = array();
	public static function getAPIDataSourceCallSingleNode($getPlaceholderDetails , $getCompanyDetails , $getSourceType, $requestUrl , $customSumFormula , $explodeColumns , $getColumnsList , $sumColumnLable , $sumType , $keyColumnName , $tableActions , $filterion , $actationTableColumn, $getColumnsProperties ,  $placeholderId , $userPagePlaceholder){

	    $tableData['data'] = array();
	    $invoiceNo = '';
	    $_arrayList = array('ResultList');
	    $columnValue = (isset($_REQUEST['columnValue'])) ? $_REQUEST['columnValue'] : "";
		//(Start) if a call is made then 
	    if ($requestUrl) {
			
	        // Make an Api Call using  getAPIDataSourceCallData function on APIDataSourceCallData file.    
	        $results = APIDataSourceCallData::getAPIDataSourceCallData($getPlaceholderDetails , $getCompanyDetails , $getSourceType);
			
			//(Start) if Api call return any Result 
	        if ($results) { 
					
				// (Start)decode the json resukt from Api call and make it an array so further processing can be carried out on it .
	            $decodedResults = json_decode($results, true);
	            $apiData = $decodedResults;
	            if ($decodedResults) {
	                foreach ($_arrayList as $key) {
	                    if (isset($decodedResults[$key])) {
	                        $apiData = $decodedResults[$key];
	                        break;
	                    }
	                }
	            }
				$COLName = $getPlaceholderDetails[0]['tableColumns'].','.$getPlaceholderDetails[0]['SumColumnLable'];
				$COLName = trim($COLName,',');
				$COLName = explode(',' , $COLName);
				$COLNameSort = [];
				if($getPlaceholderDetails[0]['ColumnSort']){
					$ColumnSort = explode(',' ,$getPlaceholderDetails[0]['ColumnSort']);
					
					foreach($ColumnSort as $K => $V){
						$newKey = array_search($V , $COLName);
						$COLNameSort[] = $newKey;
						 
					}
				}
				
				$columnSumResults = 0;
				$getColumnsProperties = '';
				$searchValue = '' ;
				$searchValueArray = array();
				$columnSumResultsValue = array();
	            // (End)decode the json resukt from Api call and make it an array so further processing can be carried out on it .
	            if ($apiData) {
					//(Start) if Sum Type is 1 then need get the column Sum before .
	                if ($sumType == 1) {
	                    $columnSumResults = 0;
	                    $columnSumData = array();
	                    $singleColumn = $customSumFormula;
	                    foreach ($apiData as $eachRecord) {
	                         
	                        $outputData = GeneralDataTableFtn::searchArray($eachRecord, $singleColumn);
	                        if ($outputData > 0) {
	                            try {
	                                $outputData = (int)$outputData;
	                                $outputData = round($outputData);
	                                $columnSumData[] = $outputData;
	                            } catch (Exception $ex) {
	                            }

	                        }
	                       
	                    }
	                    
	                    if ($columnSumData) {
	                        $columnSumResults = array_sum($columnSumData);
	                    }
	                }  
	                if((!isset($apiData[0]) && is_array($apiData))) //if Api return only single data
	                {
	                    $tempArray =$apiData;
	                    $apiData = array();
	                    $apiData[0] = $tempArray;
	                }
	                //(End) if Sum Type is 1 then need get the column Sum before .  
                    //(Start)  when the Api return only one index as result  and set the return tableData variable  
	                if(!is_array($apiData) || (count($apiData) == 1 && count($apiData[0]) == 1))
	                {
	                    if($getPlaceholderDetails[0]['TableType'] == '3')
                        {
                             $tableData['data'][$singleColumn] = $apiData;
                             $joinTbaleRes[$getPlaceholderDetails[0]['ID']] = $tableData;
                        }else{
                             $tableData['data'][] = $apiData;
                        }
	                }
	                // (End)  if Api return only single data
	                else{
						if($getPlaceholderDetails[0]['ApiType'] == 3){
							$MaintempData = [];
							$GetColumnName = $getPlaceholderDetails[0]['GetColumnName'];
							$GetValueName = $getPlaceholderDetails[0]['GetValueName'];
							
							$fetchCol = explode('->' , $GetColumnName);
							$fetchName= explode('->' , $GetValueName);

							$colName  = end($fetchCol);
							$colValue = end($fetchName);

							$ist = $apiData[0][$fetchCol[0]];
							
							foreach($ist as $istKey => $istValue){
								$scd = $istValue[$fetchCol[1]];
								$tempData = [];
								foreach($scd as $scdKey => $scdValue){
									$tempData[$scdValue[$colName]] = $scdValue[$colValue];
									
								}
								$MaintempData[] = $tempData;
							}
							unset($apiData);
							$apiData = $MaintempData;
						}
	                // (Start) For muliple data 
	                    foreach ($apiData as $eachRecord) {
							
							//(Start) if we have a row 
	                        if ($eachRecord) {
								//variable declaration
	                            $matchedData = false;
	                            $matchedValueCount = 0;
	                            $keyColumnValue = '';
	                            $detailColumnValue = '';
	                            $mapColumnValue = '';
	                            $columnData = '';
	                            $customSumDataArr = array();
								//(Start) if column name list is not empty 
	                            if (isset($getColumnsList)) {

	                                $dataToTable = [];
	                                $filterData = false;
	                                $customSumFormula = (isset($getPlaceholderDetails[0]['CustomSumFormula'])) ? $getPlaceholderDetails[0]['CustomSumFormula'] : "";
	                               
									// (Start)for loop for every Column defined at the admin side table Placeholder
	                                foreach ($explodeColumns as $singleColumn => $singleColumnValue) {
										// (Start) For Join table the column name formatting as the column name also has the table Name with it .
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
										// (End) For Join table the column name formatting as the column name also has the table Name with it .
                                        // (Start) Condition that check which column should get the inner node data     
	                                    if(strpos($singleColumn,'->') !== false)
	                                    {   
	                                        $flag1 = 0;
	                                        global $retVal , $flag1 ;
	                                        $GLOBALS['retVal'] = array();
	                                        $GLOBALS['flag1'] = 0;
	                                        $m_name = explode('->', $singleColumn );
	                                        $columnData = GeneralDataTableFtn::addforLoops($eachRecord , $m_name , 0 );
	                                    }
										 // (End) Condition that check which column should get the inner node data    
										else{
	                                        if ($singleColumn == $keyColumnName) {
	                                            $keyColumnValue = GeneralDataTableFtn::searchArray($eachRecord, $singleColumn);
	                                            $columnData = $keyColumnValue;
	                                        }
	                                        if ($singleColumn == 'CountryId') {
	                                            $columnValue = GeneralDataTableFtn::searchArray($eachRecord, $singleColumn);
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
	                                            $columnData = GeneralDataTableFtn::searchArray($eachRecord, $singleColumn);
	                                        }

	                                        if ($singleColumn == 'InvoiceNo') {
	                                            $columnDataValue = GeneralDataTableFtn::searchArray($eachRecord, $singleColumn);
	                                            $invoiceNo = $columnDataValue;
	                                        }
	                                    }
										// (Start) Custom Sum Calcution  processing . In the code below we are replacing the column name and perform differnt operation like these 
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
	                                    // (End) Custom Sum Calcution  processing . In the code below we are replacing the column name and perform differnt operation like these  
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
									 //(End)for loop for every Column defined at the admin side table Placeholder
	                                //(Start) code for custom Sum Calculation 
									
	                            	$sumColumnLable = trim($sumColumnLable);
									
	                            	if (isset($sumColumnLable) && !empty($sumColumnLable)) {
	                                	if (isset($explodeColumns)) {
	                                    	if (!in_array($sumColumnLable, $explodeColumns)) {
	                                        	if (!empty($customSumData) ) {
	                                            	if(is_array($customSumData))
	                                            	{
														$result = 0;
														if($customSumData[0] == '/'){
															$result = 0;
															$dataToTable[] = $result;
														}else{
															
															$tempArr = array();
															$tempVal = explode(',', $customSumData[0]);

															foreach ($tempVal  as $key => $value) {
																$tempArr[$key] = array();
															}
															
															foreach ($customSumData as $key1 => $value1) {
																	// calling the function for custom Sum .
																	$getColumnsProperties = json_decode($getPlaceholderDetails[0]['ColumnsProperties'], true);
																	SumCalculation::SumCalulation($sumType , $customSumData , $columnSumResults , $getColumnsProperties , $sumColumnLable , $searchValue , $searchValueArray , $columnSumResultsValue , $value1 , $dataToTable , 'multiple');
															}
															if(count($tempArr) > 0)
															{
																foreach ($tempVal  as $key => $value) {
																	$dataToTable[] = $tempArr[$key];
																}
															}else{
																$dataToTable[] = $result;
															}
														}
	                                                	
	                                            	}else{
														if($customSumData[0] == '/'){
															$result = 0;
															$dataToTable[] = $result;
														}else{
															$sepVal =  explode(',', $customSumData);
															if(count($sepVal) >=1){
																$sepLabel =  explode(',', $sumColumnLable);
																foreach ($sepVal as $key1 => $value1) {
																	$getColumnsProperties = json_decode($getPlaceholderDetails[0]['ColumnsProperties'], true);

																	$dataToTable[] = SumCalculation::SumCalulation($sumType ,  $value1 , $columnSumResults , $getColumnsProperties , $sepLabel[$key1] , $searchValue , $searchValueArray , $columnSumResultsValue , $value1 , $dataToTable , 'single' );
																}
															}else{
																$getColumnsProperties = json_decode($getPlaceholderDetails[0]['ColumnsProperties'], true);
																$dataToTable[] = SumCalculation::SumCalulation($sumType , $customSumData , $columnSumResults , $getColumnsProperties , $sumColumnLable , $searchValue , $searchValueArray , $columnSumResultsValue , $customSumData , $dataToTable , 'single' );
															
															}
														}
													}
	                                        	}
	                                    	}
	                                	}

	                            	}	

									if($getPlaceholderDetails[0]['AddZeroForNegVal']){
										$ColAddZeroForNegVal = isset($getPlaceholderDetails[0]['ColAddZeroForNegVal'])?explode(',',$getPlaceholderDetails[0]['ColAddZeroForNegVal']):[];
										
										foreach($ColAddZeroForNegVal as $NKey => $NVal){
											foreach($COLName as $COLNameKey => $COLNameVal){
												
													if(($COLName[$COLNameKey]) == trim($NVal)){
														if(strpos($dataToTable[$COLNameKey] , '-') !== false){
															$dataToTable[$COLNameKey]  = 0;
															break;
															
														}
														
														
													}
										
											}
										}
									}
									
									$tempArrColumnSort = array();
									if(trim($getPlaceholderDetails[0]['ColumnSort']) != ''){
										$ColumnSort = explode(',' ,$getPlaceholderDetails[0]['ColumnSort']);
										
										foreach($COLNameSort as $ColumnSortKey => $ColumnSortVal){
											
											$tempArrColumnSort[] =  $dataToTable[$ColumnSortVal];
											
										}
										//$dataToTable = $tempArr;
										
									}
									
	                                // action Button 
		                            if($tableActions){
										
		                                $ActValue = ActionButton::getActionButton($tableActions , $dataToTable , $actationTableColumn , $placeholderId , $userPagePlaceholder);
										if($tempArrColumnSort){
											$tempArrColumnSort[] =$ActValue[0];
											$tempArrColumnSort[] =$ActValue[1];
										}
										else{
											$dataToTable[] =$ActValue[0];
											$dataToTable[] =$ActValue[1];
										}
										
		                            }
									
									
									if ($filterion) {
		                                if(isset($searchValueCount) && $searchValueCount == $matchedValueCount) {
											if($tempArrColumnSort){
												$tableData['data'][] =$tempArrColumnSort;
											}else{
		                                    	$tableData['data'][] = $dataToTable;
											}
		                                }
		                            } 
		                            else {
										if($tempArrColumnSort){
											$tableData['data'][] =$tempArrColumnSort;
										}else{
											$tableData['data'][] = $dataToTable;
										}
		                            }
	                        	}//(End) if column name list is not empty 
	                    	}// (End)for loop for every  record
	                	}//(End) if we have multiple records 
	                }//End forEach Multiple
	            }//End If apiData
	             
	        }// End if results
	    }
		//(End) if a call is made then 
	    return $tableData ;

	}
	
}

?>