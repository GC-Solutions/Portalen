<?php

namespace App\Controllers\DataTables;

use \Core\View;
use App\Models\Page;
use \App\Models\User;
use \App\Models\Companies;
use App\Models\Placeholder;
use \App\Models\DataTableDesigns;
use App\Controllers\DataFormatHelper\DataTableHelper;

/**
 * DataTables controller
 *
 * PHP version 7.0
 *
 This File contain all the general Ftn using for  setting the data like performing cartesian product or sorting that in array for perform any calculation for custom summ . all the functin related with DataTable data .
 */

class GeneralDataTableFtn extends \Core\Controller
{
	// GLobal variable
    public $retval = array();

    // This specific function is linked with generate table ftn 
    // this function is to perform  recursive ftn that is used when we want to fetch the
    // multiple noded data .
    public static function addforLoops( $value , $params , $count = 0  , $cntNew = 0 )
    {
        // Variable declaration 
        $res = array();
        $singleFlag = 0;
        //(Start) Part Specially for Product Text because they have inner node that have same name for index.
        if( $params[$count] == 'ProductText')
        {
           
            $nam = trim($params[$count]);
            $count = $count + 1;
        
            if(!empty($value[$nam])){
                $value = $value[$nam];
                foreach ($value as $keys => $values) {

                    if($values['Field'] == $params[$count]){
                            $res = $values['Value'];
                            
                        }
                     
                }
            }   
        }//(End) Part Specially for Product Text because they have inner node that have same name for index.
        else if(!isset($value[trim($params[$count])]) && array_key_exists( $count + 1,$params))
        {
            $nam = trim($params[$count]);
            if(isset($value[$nam])){
                $value = $value[$nam];
            }   
            if( $count < count($params)-1){
                $cntNeaw = $count + 1; 
            }
            $singleFlag = 1;
            // Performing a recursive FUnction to fuction inner data of nodes
            Self::addforLoops($value , $params , $cntNeaw ); 
        }else{
            $res = isset($value[trim($params[$count])])?$value[trim($params[$count])]:'';
        }

        if($count > $cntNew && $cntNew != 0)
        {
            $GLOBALS['flag1'] = $count;
        }
        $cnt = count($params);
        $cntNew = 0;
        // generating the data part .
        if( is_array($res) && !isset($res[0])  &&  $params[0] != 'ProductText' ){
            
            if( $count < $cnt-1){
                $cntNew = $count + 1;
            }
            if($singleFlag)
            {
                Self::addforLoops($value , $params , $cntNew , $count );
            }else{
                Self::addforLoops($res , $params , $cntNew , $count );
            }
        }
        else if( is_array($res) && count($res) >= 1  &&  $params[0] != 'ProductText'){ 
           
           foreach ($res as $key => $val) {
                if( $count < $cnt-1){
                    $count = $count + 1;
                }
                Self::addforLoops($val , $params , $count );
                
                if( $GLOBALS['flag1'] )
                {
                   $count = $count - 1;
                }
                else{
                    $count = 0;
                }
           }
        }
        else
        {
            $GLOBALS['flag1'] = $count;
            if($res == '')
            {
                $res = 0;
            }
            array_push($GLOBALS['retVal'], $res);
        }
       return $GLOBALS['retVal'];
        
    }
	// Recursive function for searching the Array 
    public static function searchArray(array $array, $search)
    {
        while ($array) { 
            if (isset($array[$search])) return $array[$search];
            $segment = array_shift($array);
            if (is_array($segment)) {
                if ($return = Self::searchArray($segment, $search)) return $return; // recursive function that will perform search on inner nodes 
            }
        }
        return false;
    }
    // Function to get result for custtom SUm (Not Used)
    public static function customRowResult ($customSumData) {
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
    // Function to get perform Calculation (Not used)
    public static function customFormulaResult($customSumColumnArray,$customSumFormula) {
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
    // this specfic function is a helping ftn that rearange the array for multinode Api call 
    public static function array_flatten($array) { 
        $singleDimArray = [];
     
        foreach ($array as $item) {
            if (is_array($item)) {
                $singleDimArray = array_merge($singleDimArray, Self::array_flatten($item));

            } else {
                $singleDimArray[] = $item;
            }
        }

        return $singleDimArray;
    } 

    // this specfic function is a helping to perform cartersian product for multinode Api call. 
    public static function cartesian($arr1, $arr2){
       
        $output = array();
        foreach ($arr1 as $key1 => $value1) {
           foreach($arr2 as $key2 => $value2){

                $temp = array($value1);
                array_push($temp, $value2);
                array_push($output, $temp);
           }
        }
        return $output;
    }

}
