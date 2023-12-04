<?php

namespace App\Controllers\GeneralCalculation;

use \Core\View;
use App\Models\Page;
use \App\Models\User;
use \APP\Models\Placeholder;
use App\Controllers\DataFormatHelper\DataTableHelper;

/**
 * Calculation controller
 *
 * PHP version 7.0
 */
// thIs Function is used by the Datatable file to perform the Custom sum Calculation .
class Calculation extends \Core\Controller
{
public $_arrayList = array('ResultList');

// This FUnction Baiscally perform the calution , number formation and all the calution regarding datatbles 
public static function generalCalculation($type , $resultData , $sumType = 3 , $dataFilteration = false , $getColumnsList = false , $searchValue = false , $selectColumn , $customFormula ){
    if($type == 'Panel' || $type = 'PieChart'){
        if ($sumType == 1) {
            if ($dataFilteration) {
                $datumCount = 0;
                foreach ($resultData as $key => $value) {
                    $matchedData = false;
                    $matchedValueCount = 0;
                    if (isset($getColumnsList)) {
                        foreach ($getColumnsList as $singleColumn) {
                            $singleColumn = trim($singleColumn);
                            $rowData = (isset($value[$singleColumn])) ? $value[$singleColumn] : "";
                            $columnDataValue = strtolower($rowData);
                            if ($columnDataValue && is_numeric($columnDataValue)) {
                                $columnDataValue = round($columnDataValue);
                            }
                            if (!empty($columnDataValue) && !empty($searchValue)) {

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
                                }
                            }
                    }
                    if($searchValueCount == $matchedValueCount) {
                        $datumCount++;
                    }
                }
                $resultData = $datumCount;
            } else {
                $resultData = count($resultData);
            }
        } else if ($sumType == 2) {
                $columnSumData = array();
                $columnFilterSumData = array();
                foreach ($resultData as $key => $value) {
                    $matchedValueCount = 0;
                    if ($dataFilteration) {
                        if (isset($getColumnsList)) {
                            foreach ($getColumnsList as $singleColumn) {
                                $singleColumn = trim($singleColumn);
                                $rowData = (isset($value[$singleColumn])) ? $value[$singleColumn] : "";
                                $columnDataValue = strtolower($rowData);
                                if ($columnDataValue && is_numeric($columnDataValue)) {
                                    $columnDataValue = round($columnDataValue);
                                }
                                if (!empty($columnDataValue) && !empty($searchValue)) {

                                    if(isset($searchValue[$singleColumn])) {
                                        $searchValueComumn = explode('|',$searchValue[$singleColumn]);
                                        $searchValueComumnCount = count($searchValueComumn);
                                        if($searchValueComumnCount > 1) {
                                            for($i = 0; $i < $searchValueComumnCount; $i++ ) {
                                                if (strpos($columnDataValue, strtolower($searchValueComumn[$i])) !== false) {
                                                    $outputData = (isset($value[$selectColumn])) ? $value[$selectColumn] : "";
                                                    if ($outputData > 0) {
                                                        try {
                                                            $outputData = round($outputData);
                                                            $matchedValueCount++;
                                                        } catch (Exception $exc) {
                                                        }
                                                    }
                                                }
                                            }
                                        } else {
                                            if (strpos($columnDataValue, strtolower($searchValueComumn[0])) !== false) {
                                                $outputData = (isset($value[$selectColumn])) ? $value[$selectColumn] : "";
                                                if ($outputData > 0) {
                                                    try {
                                                        $outputData = round($outputData);
                                                        $matchedValueCount++;
                                                    } catch (Exception $exc) {
                                                    }
                                                }
                                            }
                                        }
                                    }
                                }
                            }
                        }
                    } else {
                        $outputData = (isset($value[$selectColumn])) ? $value[$selectColumn] : "";
                        if ($outputData > 0) {
                            try {
                                $outputData = round($outputData,2);
                            } catch (Exception $exc) {
                            }
                        }
                    }
                    if($dataFilteration) {
                        if($searchValueCount == $matchedValueCount) {
                            if(isset($outputData)) {
                                $columnFilterSumData[] = $outputData;
                            }
                        }
                    } else {
                        if(isset($outputData)) {
                            $columnSumData[] = $outputData;
                        }
                    }
                }
                if ($dataFilteration) {
                    if ($columnFilterSumData) {
                        $resultData = array_sum($columnFilterSumData);
                    } else {
                        $resultData = 0;
                    }
                } else {
                    if ($columnSumData) {
                        $resultData = array_sum($columnSumData);
                    }
                }
        } else if ($sumType == 3) {
           
                if(!empty($resultData)){
                    $explodeColumns = explode(',',  $selectColumn);
                    if(count($explodeColumns) >= 1 ) {
                        $customeSumFlag = 0;
                        if($type != 'PieChart'){
                            $customSumFormula = (isset($customFormula)) ? $customFormula : "";
                            if(strpos($customSumFormula, '100') === false)
                            {
                                $customeSumFlag = 1;
                            }
                        }
                        $customSumSearchColumnArray = array();
                        $customSumColumnArray = array();
                        $valuessss = $customVal = 0 ;
                        foreach ($resultData as $key=>$eachRecord) {
                            $customSumData = '';
                            $customSumFormula = (isset($customFormula)) ? $customFormula : "";
                            $customSumFormulaTemp =  array();
                            foreach($explodeColumns as $value) {
                                $explodeColumnsSingle = trim($value);
                                $customSumDataResults = array();
                                $customSumFilterDataResults = array();
                                
                                $matchedValueCount = 0;
                                $customSumFilterData = '';
                                $eachColumn = $explodeColumnsSingle;

                                if ($dataFilteration) {
                                        if (isset($getColumnsList)) {
                                            foreach ($getColumnsList as $singleColumn) {
                                                $singleColumn = trim($singleColumn);
                                                $rowData = (isset($eachRecord[$singleColumn])) ? $eachRecord[$singleColumn] : "";
                                                $columnDataValue = strtolower($rowData);
                                                if ($columnDataValue && is_numeric($columnDataValue)) {
                                                    $columnDataValue = round($columnDataValue);
                                                }
                                                if (!empty($columnDataValue) && !empty($searchValue)) {
                                                    if (isset($searchValue[$singleColumn])) {
                                                        $searchValueComumn = explode('|',$searchValue[$singleColumn]);
                                                        $searchValueComumnCount = count($searchValueComumn);
                                                        if($searchValueComumnCount > 1) {
                                                            for($i = 0; $i < $searchValueComumnCount; $i++ ) {
                                                                if (strpos($columnDataValue, strtolower($searchValueComumn[$i])) !== false) {
                                                                    if (isset($customSumFormula) && !empty($customSumFormula)) {
                                                                        $customSumFilterData = round($columnData);;
                                                                        $matchedValueCount++;
                                                                    }
                                                                }
                                                            }
                                                        } else {

                                                            if (strpos($columnDataValue, strtolower($searchValueComumn[0])) !== false) {
                                                                if (isset($customSumFormula) && !empty($customSumFormula)) {
                                                                    $customSumFilterData = round($columnData);;
                                                                    $matchedValueCount++;
                                                                }
                                                            }
                                                        }
                                                    }
                                                }
                                            }
                                        }
                                    } else {


                                        $columnData = $eachRecord[$eachColumn];
                                        $customSumColumnArray[$eachColumn] = isset($customSumColumnArray[$eachColumn])?$customSumColumnArray[$eachColumn]: 0;
                                        $valuessss  =  $customSumColumnArray[$eachColumn] + $columnData ; 
                                        $customSumColumnArray[$eachColumn] = $valuessss;

                                        // For Value which don't have 100 
                                        if($type != 'PieChart'){
                                            if($customeSumFlag == 1){
                                                if (isset($customSumFormula) && !empty($customSumFormula)) {
                                                $replaceColumn = "(" . $eachColumn . ")";
                                                $vallue = str_replace(array(',', ' '), '', $columnData);
                                                $customSumData = str_replace($replaceColumn, $vallue, $customSumFormula);
                                                $customSumFormula = $customSumData;
                                                }
                                            }
                                        }
                                        else if($type == 'PieChart')
                                        {
                                            if (isset($customSumFormula) && !empty($customSumFormula)) {
                                            $cSFormula = explode('|', $customSumFormula);

                                            foreach ($cSFormula as $k => $v) {
                                                if(strpos($v, '100') === false)
                                                {
                                                    $customeSumFlag = 1;
                                                }else {
                                                    $customeSumFlag = 0;
                                                }
                                                
                                                if($customeSumFlag == 1){
                                                    $replaceColumn = "(" . $eachColumn . ")";
                                                    $vallue = str_replace(array(',', ' '), '', $columnData);
                                                    $customSumFormulaTemp['Flag1'][$v][$eachColumn] =$vallue;  
                                                  
                                                    }
                                                }
                                            }
                                        }
                                    }
                                    if($dataFilteration) {
                                        if($searchValueCount == $matchedValueCount){
                                            $customSumSearchColumnArray[$eachColumn] = $customSumFilterData;
                                        }
                                    }

                                }

                            if($type != 'PieChart'){
                                if($customeSumFlag == 1){
                                    if (isset($customSumFormula) && !empty($customSumFormula)){
                                         if (strpos($customSumData, '--') === false) {
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
                                                
                                                $customVal = $customVal + $result;
                                                $customSumColumnArray['customSum']=round($customVal,2);
                                        }

                                    }
                                }
                            }elseif($type == 'PieChart')
                            {
                                if(!empty($customSumFormulaTemp['Flag1'])){
                                   foreach ($customSumFormulaTemp['Flag1'] as $key => $tempVal) {
                                        $cFormula = $key;
                                        foreach ($tempVal as $keyTemp => $valueTempp) {
                                                $replaceColumn = "(" . $keyTemp . ")";
                                                $customSumData = str_replace($replaceColumn, $valueTempp, $cFormula);
                                                $cFormula = $customSumData ;
                                            }

                                        if (strpos($customSumData, '--') === false) {
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
                                                    
                                                    $customVal = $customVal + $result;
                                                    $customSumColumnArray[$key]=round($customVal,2);
                                            }
                                        }
                                    }

                            }
                        }
                        if($type != 'PieChart'){
                            if($customeSumFlag == 0){
                                if(isset($customSumColumnArray) ){
                                    foreach ($customSumColumnArray as $eachColumn => $vallue) {
                                        if (isset($customSumFormula) && !empty($customSumFormula)) {
                                            $replaceColumn = "(" . $eachColumn . ")";
                                            $vallue = str_replace(array(',', ' '), '', $vallue);
                                            $customSumData = str_replace($replaceColumn, $vallue, $customSumFormula);
                                            $customSumFormula = $customSumData;
                                        }
                                    } 
                                    
                                    if (strpos($customSumData, '--') === false) {
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
                                            $customSumColumnArray['customSum']=round($result,2);
                                    }
                                }else if (isset($customSumSearchColumnArray))
                                {
                                    foreach ($customSumSearchColumnArray as $eachColumn => $vallue) {
                                        if (isset($customSumFormula) && !empty($customSumFormula)) {
                                            $replaceColumn = "(" . $eachColumn . ")";
                                            $vallue = str_replace(array(',', ' '), '', $vallue);
                                            $customSumData = str_replace($replaceColumn, $vallue, $customSumFormula);
                                            $customSumFormula = $customSumData;
                                        }
                                    }

                                    if (strpos($customSumData, '--') === false) {
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
                                        $customSumColumnArray['customSum']=round($result,2);
                                    }
                                }
                            }
                        }else if($type == 'PieChart'){
                            $csFormula = explode('|', $customSumFormula);
                            foreach ($csFormula as $k => $v) {
                                $formula = $v;
                                if(strpos($v, '100') !== false)
                                {
                                    $customeSumFlag = 0;
                                }else
                                {
                                    $customeSumFlag = 1;
                                }
                                if($customeSumFlag == 0){
                                    if(isset($customSumColumnArray) ){
                                        foreach ($customSumColumnArray as $eachColumn => $vallue) {
                                            if (isset($formula) && !empty($formula)) {
                                                $replaceColumn = "(" . $eachColumn . ")";
                                                $vallue = str_replace(array(',', ' '), '', $vallue);
                                                $customSumData = str_replace($replaceColumn, $vallue, $formula);
                                                $formula = $customSumData;
                                            }
                                        }
                                        if (strpos($customSumData, '--') === false) {
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
                                                $customSumColumnArray[$v]=round($result,2);
                                        }
                                    }else if (isset($customSumSearchColumnArray))
                                    {
                                        foreach ($customSumSearchColumnArray as $eachColumn => $vallue) {
                                            if (isset($formula) && !empty($formula)) {
                                                $replaceColumn = "(" . $eachColumn . ")";
                                                $vallue = str_replace(array(',', ' '), '', $vallue);
                                                $customSumData = str_replace($replaceColumn, $vallue, $formula);
                                                $formula = $customSumData;
                                            }
                                        }

                                        if (strpos($customSumData, '--') === false) {
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
                                            $customSumColumnArray[$v]=round($result,2);
                                        }
                                    }
                                }
                            }
                        }
                    }
                }
        } else if ($sumType == 4) {
                $explodeColumns = explode(',', $selectColumn);
                $customSumDataResults = array();
                $customSumFilterDataResults = array();
                $customSumColumnArray = array();
                $customSumSearchColumnArray = array();
                $customSumFilterDataNew = '';
                $customRowResult = '';
                foreach ($resultData as $key => $eachRecord) {
                    $customSumFormula = (isset($customFormula)) ? $customFormula : "";
                    $matchedValueCount = 0;
                    $customSumFilterData = '';

                    if (isset($explodeColumns)) {
                        foreach ($explodeColumns as $eachColumn) {

                            if ($dataFilteration) {
                                if (isset($getColumnsList)) {
                                    foreach ($getColumnsList as $singleColumn) {
                                        $singleColumn = trim($singleColumn);
                                        $rowData = (isset($eachRecord[$singleColumn])) ? $eachRecord[$singleColumn] : "";
                                        $columnDataValue = strtolower($rowData);
                                        if ($columnDataValue && is_numeric($columnDataValue)) {
                                            $columnDataValue = round($columnDataValue);
                                        }
                                        if (!empty($columnDataValue) && !empty($searchValue)) {

                                            if(isset($searchValue[$singleColumn])) {
                                                $searchValueComumn = explode('|',$searchValue[$singleColumn]);
                                                $searchValueComumnCount = count($searchValueComumn);
                                                if($searchValueComumnCount > 1) {
                                                    for($i = 0; $i < $searchValueComumnCount; $i++ ) {
                                                        if (strpos($columnDataValue, strtolower($searchValueComumn[$i])) !== false) {
                                                            $eachColumn = trim($eachColumn);
                                                            $columnData = $eachRecord[$eachColumn];
                                                            if (isset($customSumFormula) && !empty($customSumFormula)) {
                                                                $replaceColumn = "(" . $eachColumn . ")";
                                                                $columnData = str_replace(array(',', ' '), '', round($columnData));
                                                                $customSumFilterData = str_replace($replaceColumn, $columnData, $customSumFormula);
                                                                $customSumFormula = $customSumFilterData;
                                                                if($this->customRowResult($customSumFilterData) != 0) {
                                                                    $matchedValueCount++;
                                                                }
                                                            }
                                                        }
                                                    }
                                                } else {
                                                    if (strpos($columnDataValue, strtolower($searchValueComumn[0])) !== false) {
                                                        $eachColumn = trim($eachColumn);
                                                        $columnData = $eachRecord[$eachColumn];
                                                        if (isset($customSumFormula) && !empty($customSumFormula)) {
                                                            $replaceColumn = "(" . $eachColumn . ")";
                                                            $columnData = str_replace(array(',', ' '), '', round($columnData));
                                                            $customSumFilterData = str_replace($replaceColumn, $columnData, $customSumFormula);
                                                            $customSumFormula = $customSumFilterData;
                                                            if($this->customRowResult($customSumFilterData) != 0) {
                                                                $matchedValueCount++;
                                                            }
                                                        }
                                                    }
                                                }
                                            }
                                        }
                                    } //
                                }
                            } else {
                                $eachColumn = trim($eachColumn);
                                $columnData = $eachRecord[$eachColumn];
                                if (isset($customSumFormula) && !empty($customSumFormula)) {
                                    $replaceColumn = "(" . $eachColumn . ")";
                                    $columnData = str_replace(array(',', ' '), '', round($columnData));
                                    $customSumData = str_replace($replaceColumn, $columnData, $customSumFormula);
                                    $customSumFormula = $customSumData;
                                }

                            }
                            if($dataFilteration) {
                                if($searchValueCount == $matchedValueCount){
                                    $customSumFilterDataResults[] = $this->customRowResult($customSumFilterData);
                                }
                            } else {
                                $customSumDataResults[] = $this->customRowResult($customSumData);
                            }
                        }

                    }
                }
                if ($dataFilteration) {
                    if ($customSumFilterDataResults) {
                        $resultData = array_sum($customSumFilterDataResults);
                    } else {
                        $resultData = 0;
                    }
                } else {
                    if ($customSumDataResults) {
                        $resultData = array_sum($customSumDataResults);
                    }
                }
        }
    }
    if(!empty($customSumColumnArray) && $sumType == 3)
    {
        $resultData = $customSumColumnArray;
    }

    return $resultData;

}
public function customRowResult ($customSumData) {
        if (strpos($customSumData, '--') === false) {
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
            return round($result);
        }
    }
}