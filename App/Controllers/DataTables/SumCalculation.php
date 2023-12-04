<?php

namespace App\Controllers\DataTables;

use \Core\View;
use App\Models\Page;
use \App\Models\User;
use App\Models\Placeholder;
use App\Controllers\DataFormatHelper\DataTableHelper;
use App\Controllers\DataTables\APIDataSourceCallData;
use App\Controllers\DataTables\GeneralDataTableFtn;
use Exception;

class SumCalculation extends \Core\Controller
{


	public static function SumCalulation($sumType , $customSumData , $columnSumResults , $getColumnsProperties , $sumColumnLable , $searchValue , $searchValueArray , $columnSumResultsValue , $value1 , $dataToTable  ,$type = 'multiple'){
      
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
                return  $columnSumResults;
            } else {
                if(!empty($getColumnsProperties[$sumColumnLable])){
                    $columnSumResults = DataTableHelper::ColumnProperties($columnSumResults,$getColumnsProperties[$sumColumnLable]);
                }
                return $columnSumResults;
            }
        } else if ($sumType == 2) 
        {
           
            $csData = explode(',' , $value1); // 
            $sumLabel = explode(',' , $sumColumnLable); 
           
            foreach ($csData as $key => $value) {
               
                if (strpos($value, '--') === false) {
                   
                    if(1 === preg_match('~[0-9]~',  $value)){
                        try{
                            @eval('$result = (' . @$value . ');');
    
                        }catch(Exception $e){
                            $result = 0;
                        }
                    }else{
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
                        return $result;

                    } else {
                        $sumLabelkey = trim($sumLabel[$key]);
                        if(!empty($getColumnsProperties[$sumLabelkey])){
                            $result = DataTableHelper::ColumnProperties($result,$getColumnsProperties[$sumLabelkey]);
                        }
                       
                        if($type == 'single')
                        {
                            return $result;
                        }else{
                            array_push($tempArr[$key], $result);
                        }
                    }
                } else{
                   
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
                    } else {
                        if(!empty($getColumnsProperties[$sumLabel[$key]])){
                            $result = DataTableHelper::ColumnProperties($result,$getColumnsProperties[$sumLabel[$key]]);
                        }
                        if($type == 'single')
                        {
                             return $result;
                        }else{
                            array_push($tempArr[$key], $result);
                        }
                        
                    }
                }
        	}
        }
	}



}

?>