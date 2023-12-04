<?php

namespace App\Controllers\DataFormatHelper;

use \Core\View;

/**
 * DataTableHelper controller
 *
 * PHP version 7.0
 */

class DataTableHelper extends \Core\Controller
{

    /**
     * Show the index page
     *
     * @return void
     */

    // All the function in these file are used for fomarting the data in datatables .or preparing the data to Read by the dataTable when displayed at front End . 

     // This Function Basically perform number formating mention at the Admin side 
    public static function ColumnProperties($columnData,$singleColumnValue)
    {
      

        if(is_array($columnData)) // condition if more an array conatining the properties are given 
        {
            foreach ($columnData as $key => $value) {
                if(is_array($singleColumnValue)) {
                    if (array_key_exists("type",$singleColumnValue) && $singleColumnValue['type'] == 'decimals')
                    {
                        
                        if (array_key_exists("decimals",$singleColumnValue) && array_key_exists("thousand_sep",$singleColumnValue) && array_key_exists("decimal_point",$singleColumnValue)) {
                            $thousandSep = $singleColumnValue['thousand_sep'];
                            $decimals = $singleColumnValue['decimals'];
                            $decimalPoint = $singleColumnValue['decimal_point'];
                            $value = (float)$value;
                            $value = rtrim(rtrim((string)number_format($value, $decimals, $decimalPoint, $thousandSep),""),$decimalPoint);
                        }
                    }
                    if (array_key_exists("type",$singleColumnValue) && $singleColumnValue['type'] == 'integer')
                    {
                        if ($value && is_numeric($value)) {
                            $value = round($value);
                        }
                    }

                    if (array_key_exists("type",$singleColumnValue) && $singleColumnValue['type'] == 'text')
                    {
                               
                        $value = (string)$value;
                    }

                    
                }
                $columnData[$key] = $value;
        }

        }else{
           
            if(is_array($singleColumnValue)) {
                if (array_key_exists("type",$singleColumnValue) && $singleColumnValue['type'] == 'decimals')
                {
                    if (array_key_exists("decimals",$singleColumnValue) && array_key_exists("thousand_sep",$singleColumnValue) && array_key_exists("decimal_point",$singleColumnValue)) {
                        $thousandSep = $singleColumnValue['thousand_sep'];
                        $decimals = $singleColumnValue['decimals'];
                        $decimalPoint = $singleColumnValue['decimal_point'];
                        $columnData = (float)$columnData;
                        $columnData = rtrim(rtrim((string)number_format($columnData, $decimals, $decimalPoint, $thousandSep),""),$decimalPoint);
                    }
                }
                if (array_key_exists("type",$singleColumnValue) && $singleColumnValue['type'] == 'integer')
                {
                    if ($columnData && is_numeric($columnData)) {
                        $columnData = round($columnData);
                    }
                }

                if (array_key_exists("type",$singleColumnValue) && $singleColumnValue['type'] == 'text')
                {
                    $columnData = (string)$columnData;
                        
                }

                if (array_key_exists("type",$singleColumnValue) && $singleColumnValue['type'] == 'date')
                {
                    //$columnData = date("Y-m-d", strtotime($columnData));
                    // do nothing
                }
            }else{
                
                    $columnData = (string)$columnData;
                        
                
            }
            
        }
        return $columnData;
    }
     // This Function Basically perform Round Off the numerical number
    public static function columnDataRound($columnData,$singleColumnValue)
    {
        if(is_array($columnData))
        {
            foreach ($columnData as $key => $value) {

                if(!is_array($singleColumnValue)) {
                    if ($value && is_numeric($value)) {
                        $value = round($value);
                    }
                }
                $columnData[$key] = $value;
            }
        }else{
            if(!is_array($singleColumnValue)) {
               
                if ($columnData && is_float($columnData)) {
                    $columnData  = $columnData;
                }
                else if ($columnData && is_numeric($columnData)) {
                    if($singleColumnValue == 'Volyme'){
                        $columnData =$columnData;
                    }else{
                        $columnData = round($columnData);
                    }
                   
                }
            }
        }
        return $columnData;
    }
    // This Function Basically perform Column Alignment on datatAble front side
    public static function columnAlignment($getColumnsProperties,$columnTitle,$columnDb)
    {

        $getColumnsProperties = json_decode($getColumnsProperties , true);
         
        $alignemtRighArray = array();
        $alignmentRightKeys = array();
        foreach($getColumnsProperties as $key => $value) {
            if (array_key_exists("alignment",$value) && $value['alignment'] == 'right')
            {
                $alignemtRighArray[] = $key;
            }
        }
       
        if(!empty($alignemtRighArray)) {

            $alignmentRightKeys = array_intersect($columnTitle,$alignemtRighArray);
            if(empty($alignmentRightKeys)) {
                $alignmentRightKeys = array_intersect($columnDb,$alignemtRighArray);
            }
            $alignmentRightKeys = array_keys($alignmentRightKeys);
        }
        return $alignmentRightKeys;
    }
    // This Function Basically is used to get all those column that would display the footer columns 
    public static function footerColumnVisibility($getColumnsPropertiesFooter,$columnTitle)
    {
      
        $footerKeyArray = array();
        $footerColumn = array();
        $getColumnsPropertiesFooter = json_decode($getColumnsPropertiesFooter, true);
        $footerKeyArray = array_intersect($columnTitle,array_keys($getColumnsPropertiesFooter));
        foreach($footerKeyArray as $key => $value) {
            $footerColumn[$key] = $getColumnsPropertiesFooter[$value];
        }
        return $footerColumn;
    }
    // This Function Basically is used to get all those column that would display the footer columns 
    public static function footerColumnVisibilityNew($getColumnsPropertiesFooter,$columnTitle)
    {
      
        $footerKeyArray = array();
        $footerColumn = array();
        $getColumnsPropertiesFooter = json_decode($getColumnsPropertiesFooter, true);
        $footerKeyArray = array_intersect($columnTitle,array_keys($getColumnsPropertiesFooter));
        foreach($footerKeyArray as $key => $value) {
            $footerColumn[$key] = $getColumnsPropertiesFooter[$value];
        }
        return $footerColumn;
    }
    // This Function Basically is used to get all those column that would display the AdditionalColumn 
    
    public static function AdditionalColumnProperties($getColumnsPropertiesFooter,$columnTitle)
    {

        $footerKeyArray = array();
        $footerColumn = array();
        $getColumnsPropertiesFooter = json_decode($getColumnsPropertiesFooter, true);
        $footerKeyArray = array_intersect($columnTitle,array_keys($getColumnsPropertiesFooter));
        foreach($footerKeyArray as $key => $value) {
            $footerColumn[$key] = $getColumnsPropertiesFooter[$value];
        }
        return $footerColumn;
    }
    // This Function Basically is used to get all those column that would display the AdditionalColumn New 
    
    public static function AdditionalColumnPropertiesNew($getMainVal,$columnTitle , $columnDisplayName )
    {
        $getMainVal = explode(',' , $getMainVal );
        $newExplodeColumns = array();    
        foreach ($getMainVal as $getMainValKey => $getMainValVal) {
            foreach ($columnTitle as $key => $value) {
                if($columnTitle[$key] ==  trim($getMainValVal)  || $columnDisplayName[$key] ==  trim($getMainValVal) )
                {
                    $newExplodeColumns[] = $key ;
                    break;
                } 
            }
        }
        return  $newExplodeColumns;
    }
    // This Function Basically is used to get all those column that would  used when an chart is linked with the datatable. 
    
    public static function chartColumnProperties($getChartColumn,$columnTitle)
    {

        $chartColumnKeys = array();
        $chartColumn = array();

        $getChartColumn = json_decode($getChartColumn, true);
        if(isset($getChartColumn['XAxis'])){
            $chartColumn  =  $getChartColumn;
        }else{

            $chartColumnKeys = array_intersect($columnTitle,array_keys($getChartColumn));

            foreach($chartColumnKeys as $key => $value) {
                $flag = 0;
                $customSumName = '';
                $keys1 = array_keys($getChartColumn[$value]);
                foreach ($keys1 as $key1 => $value1) {
                    if(strpos($value1, 'custom_sum') !== false)
                    {
                        $flag = 1;
                        $customSumName = $value1;
                        break;
                    }
                }
            
                if( $flag == 1 )
                {
                    foreach ($columnTitle as $keys => $val) {

                        $getChartColumn[$value][$customSumName] = str_replace("(".$val.")", "(".$keys .")" , $getChartColumn[$value][$customSumName]);
                    }
                }
                
                $chartColumn[$key] = $getChartColumn[$value];
            }
        }
        return $chartColumn;
    }
    // This Function Basically is used to get all those column on which the predefined search is being applied .
    public static function predefineSearchProperties($getPredefineSearchColumn,$columnTitle)
    {

        $predefineSearchColumnKeys = array();
        $searchColumn = array();
        if($getPredefineSearchColumn != '1'){
            $getPredefineSearchColumn = json_decode($getPredefineSearchColumn, true);
            $predefineSearchColumnKeys = array_keys($getPredefineSearchColumn);
        }else{
            $getPredefineSearchColumn = array();
        }

        foreach($columnTitle as $key => $value) {
            if(in_array($value, $predefineSearchColumnKeys)){
               
                $getPredefineSearchColumn[$value]['sSearch'] = str_replace('(curr_year)', date('Y'), $getPredefineSearchColumn[$value]['sSearch']); 
                $getPredefineSearchColumn[$value]['sSearch'] = str_replace('(curr_month)', date('m'), $getPredefineSearchColumn[$value]['sSearch']); 
                $getPredefineSearchColumn[$value]['sSearch'] = str_replace('(curr_date)', date('d'), $getPredefineSearchColumn[$value]['sSearch']); 
                if( isset($_SESSION['UserLastLogoutDate'])){
                   
                    $getPredefineSearchColumn[$value]['sSearch'] = str_replace('(LogDate)',$_SESSION['UserLastLogoutDate'] , $getPredefineSearchColumn[$value]['sSearch']);   
                        
                }
                $searchColumn[$key] = $getPredefineSearchColumn[$value];
            }
            else{
                $searchColumn[$key] = null;
            }
        }
        
        return $searchColumn;
    }
    // This Function Basically is used to get all those column on which the predefined search is being applied but those column should not show them . its an invisble predefined search .
    public static function invPredefineSearchProperties($getPredefineSearchColumn,$columnTitle)
    {

        $predefineSearchColumnKeys = array();
        $searchColumn = array();
        if($getPredefineSearchColumn != '1'){
            $getPredefineSearchColumn = json_decode($getPredefineSearchColumn, true);
            $predefineSearchColumnKeys = array_keys($getPredefineSearchColumn);
        }else{
            $getPredefineSearchColumn = array();
        }

        foreach($columnTitle as $key => $value) {
            if(in_array($value, $predefineSearchColumnKeys)){
               
                $getPredefineSearchColumn[$value]['value'] = str_replace('(curr_year)', date('Y'), $getPredefineSearchColumn[$value]['value']); 
                $getPredefineSearchColumn[$value]['value'] = str_replace('(curr_month)', date('m'), $getPredefineSearchColumn[$value]['value']); 
                $getPredefineSearchColumn[$value]['value'] = str_replace('(curr_date)', date('d'), $getPredefineSearchColumn[$value]['value']); 
               
                $searchColumn[$key] = $getPredefineSearchColumn[$value];
            }
            else{
                $searchColumn[$key] = null;
            }
        }
        
        return $searchColumn;
    }

    // This Function Basically is used to get all those column on which the predefined search on Range filter is being applied .
    public static function PredefineSearchforRangeProperties($getPredefineSearchRangeColumn,$columnTitle)
    {

        $predefineSearchColumnKeys = array();
        $searchColumn = array();

        $getPredefineSearchRangeColumn = json_decode($getPredefineSearchRangeColumn, true);
      
        $predefineSearchColumnKeys = array_intersect($columnTitle,array_keys($getPredefineSearchRangeColumn));

        foreach($predefineSearchColumnKeys as $key => $value) {

                $getPredefineSearchRangeColumn[$value]['from'] = str_replace('(curr_year)', date('Y'), $getPredefineSearchRangeColumn[$value]['from']); 
                $getPredefineSearchRangeColumn[$value]['from'] = str_replace('(curr_month)', date('m'), $getPredefineSearchRangeColumn[$value]['from']); 
                $getPredefineSearchRangeColumn[$value]['from'] = str_replace('(curr_date)', date('d'), $getPredefineSearchRangeColumn[$value]['from']); 
                $getPredefineSearchRangeColumn[$value]['to'] = str_replace('(curr_year)', date('Y'), $getPredefineSearchRangeColumn[$value]['to']); 
                $getPredefineSearchRangeColumn[$value]['to'] = str_replace('(curr_month)', date('m'), $getPredefineSearchRangeColumn[$value]['to']); 
                $getPredefineSearchRangeColumn[$value]['to'] = str_replace('(curr_date)', date('d'), $getPredefineSearchRangeColumn[$value]['to']);
              
                $searchColumn[$key] = $getPredefineSearchRangeColumn[$value];
        }
        return $searchColumn;
    }
     // This Function Basically is used to get all those column that would  used when an MAP is linked with the datatable. 
    public static function MapColumnProperties($getMapColumn,$columnTitle)
    {

        $mapColumnKeys = array();
        $mapColumn = array();
        $getMapColumn = json_decode($getMapColumn, true);
        $mapColumnKeys = array_intersect($columnTitle,array_keys($getMapColumn));
        foreach($mapColumnKeys as $key => $value) {
            $mapColumn[$key] = $getMapColumn[$value];
        }
        return $mapColumn;
    }
     // This Function Basically is used to get all those column that would  used when an Piechart is linked with the datatable. 
    public static function PieChartColumnProperties($getPieChartColumn,$columnTitle, $sumColumnLabel, $newArr= array())
    {

        $PieChartColumnKeys = array();
        $PieChartColumn = $newArr;
        $getPieChartColumn = json_decode($getPieChartColumn, true);

        // print_r($getPieChartColumn); exit;
        $PieChartColumnKeys = array_intersect($columnTitle,array_keys($getPieChartColumn));

        foreach($PieChartColumnKeys as $key => $value) {
            if(in_array($value, $sumColumnLabel ))
            {
                $PieChartColumn[$value] = $getPieChartColumn[$value];
            }else{
                $PieChartColumn[$key] = $getPieChartColumn[$value];
            }
            
        }
        return $PieChartColumn;
    }

    // This Function Basically is used to get all those column that on which  group by row group is applied .
    public static function rowGroupColumnProperties($getRowGroupColumn,$columnTitle , $columnDB)
    {
        $rowGroupColumnKeys = array();
        $rowGroupColumn = array();
        
       
        $rowGroupColumnKeys = array_intersect($columnDB,array_values($getRowGroupColumn));
       
       
        foreach($rowGroupColumnKeys as $key => $value) {
            $rowGroupColumn[$key] = $columnTitle[$key];
        }
       
       return $rowGroupColumn;
       // return $rowGroupColumn;
    }
     // ??
    public static function filterColumnProperties($getFilterColumn,$columnTitle)
    {

        $filterColumnKeys = array();
        $filterColumn = array();
        $getFilterColumn = array_map('trim', $getFilterColumn);
        $filterColumnKeys = array_intersect($columnTitle,array_values($getFilterColumn));
        foreach($filterColumnKeys as $key => $value) {
            $filterColumn[$key] = $value;
        }
        return $filterColumn;
    }
}
