<?php
namespace App\Controllers\API;

use \Core\View;
use App\Models\Page;
use \App\Models\User;
use App\Models\Placeholder;
use App\Controllers\DataFormatHelper\DataTableHelper;
use App\Controllers\DataTables\APIDataSourceCallData;
use App\Controllers\DataTables\GeneralDataTableFtn;
use App\Controllers\DataTables\SumCalculation;
use App\Controllers\DataTables\ActionButton;


class APIDataSourceCallMultipleNode extends \Core\Controller
{
    // Global Variable 
    public $retval = array();
    /* This Function is Called when Multiple Node data is fetched .
     Multiple Node mean that fetching the data from inner node e.g getting the data of test index 
    { data:{
        data1:23,
            data2:{
                test:345
            }} }
    */
    public static function getAPIDataSourceCallMultipleNode($getPlaceholderDetails , $getCompanyDetails , $getSourceType, $requestUrl , $customSumFormula , $explodeColumns , $getColumnsList , $sumColumnLable , $sumType , $keyColumnName , $tableActions , $filterion , $actationTableColumn , $getColumnsProperties)
    {
        //Variable declaration 
        $tableData = array();
        $_arrayList = array('ResultList');
        $invoiceNo = '';
        $header  = '' ;
        $newResArr1 = array();
        $columnValue = (isset($_REQUEST['columnValue'])) ? $_REQUEST['columnValue'] : "";
        //(Start) if a call is made .
        if ($requestUrl) 
        {
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
                                } catch (Exception $exc) {
                                }

                            }
                        }
                        if ($columnSumData) {
                            $columnSumResults = array_sum($columnSumData);
                        }
                    }
                    //(End) if Sum Type is 1 then need get the column Sum before .  
                    //(Start)  when the Api returjn only one index as result  and set the return tableData variable  
                    if((!isset($apiData[0]) && is_array($apiData)))
                    {
                        $tempArray =$apiData;
                        $apiData = array();
                        $apiData[0] = $tempArray;
                    }
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
                    //(End)  when the Api return only one index as result   
                    else{
                        
                        //(Start) if we have multiple records 
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
                                $eachRecords = array();
                                //(Start) if column name list is not empty 
                                
                                if (isset($getColumnsList)) {
                                    $dataToTable = [];
                                    $filterData = false;
                                    $customSumFormula = (isset($getPlaceholderDetails[0]['CustomSumFormula'])) ? $getPlaceholderDetails[0]['CustomSumFormula'] : "";
                                    
                                    $newNames = array();
                                    $mainName = explode(',', $getPlaceholderDetails[0][7]); // Column Name

                                    $showFields = $_REQUEST['APIData']['Fields'];
                                    
                                    if(!empty($showFields))
                                    {
                                        $showFields = explode(',',$_REQUEST['APIData']['Fields']);
                                    
                                        $temp = [];
                                        foreach ($showFields as $k => $v) {
                                        $v = trim($v);
                                        
                                        if($getPlaceholderDetails[0]['ApiType'])
                                            {
                                                
                                                foreach ($explodeColumns as $colkey => $colvalue) {

                                                    if(isset($colvalue['Label'])){
                                                    if(($v == $colvalue['Label']))
                                                    {
                                                        
                                                        $temp[$colkey] = $colvalue;
                                                        break;
                                                    }}else
                                                    {

                                                        $var = explode('->', $colkey);
                                                        $var = end($var);

                                                        if($v == $var)
                                                        {
                                                        $temp[$colkey] = $colvalue;
                                                        break;
                                                        }
                                                    }

                                                }
                                            }else{
                                            if(array_key_exists($v, $explodeColumns))
                                                {
                                                $temp[$v] = $explodeColumns[$v];
                                                }
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
                                     
                                    // (start) since we define the name of with -> so now we get the column name after processing 
                                    foreach ($mainName as $ki => $vi) {
                                        foreach ($explodeColumns as $singleColumn => $singleColumnValue) {
                                            $tempName = explode('->' , $singleColumn);  
                                            if(in_array($mainName[$ki], $tempName))
                                            {
                                                if(in_array($mainName[$ki], $tempName))
                                                {
                                                    $newNames[$singleColumn] = $singleColumnValue;
                                                    break;
                                                }
                                            }
                                        
                                        }
                                        
                                    }
                                    $explodeColumns = $newNames;
                                      
                                    foreach ($explodeColumns as $singleColumn => $singleColumnValue) {
                                        
                                        if(strpos($singleColumn,'->') !== false)
                                        {   
                                            $m_name = explode('->', $singleColumn);
                                            if(count($apiData) == 1 && count($m_name) > 1)
                                                {
                                                    $n = $m_name[0];
                                                    if(array_key_exists($n, $eachRecord)){
                                                        $eachRecords= $eachRecord[$n];
                                                        break;
                                                    }
                                                }
                                        }
                                        
                                    }
                                     // (End) since we define the name of with -> so now we get the column name after processing 
                                    $dataToTable1 = [];
                                    //  FOr special Url 
                                    if (array_key_exists('boards',$eachRecords))
                                    {
                                        $eachRecords= $eachRecords['boards'];
                                    }
                                    // (Start)for loop for every  record
                                    if(empty($eachRecords)){
                                        $eachRecords = $eachRecord;
                                    }
                                    
                                    foreach ($eachRecords as $key => $val ) {
                                        $dataToTable= [];
                                        //$val['Nodes'] = $val;
                                        // (Start)for loop for every Column defined at the admin side table Placeholder
                                        foreach ($explodeColumns as $singleColumn => $singleColumnValue) {
                                            // (Start) For Join table the column name formatting as the column name also has the table Name with it .
                                            if($getPlaceholderDetails[0]['TableType'] == 3)
                                                {
                                                    $columnDataFlag  = 0;
                                                    $singleColumnVal = $singleColumn;
                                                    if(strpos($singleColumn, $getPlaceholderDetails[0]['Name']) !== false){
                                                        $singleColumn = explode('-', $singleColumn);
                                                        if($singleColumn[1] != '')
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
                                            // (End) For Join table the column name formatting as the column name also has the table Name with it .
                                            // (Start) Condition that check which column should get the inner node data    
                                            
                                            if(strpos($singleColumn,'->') !== false)
                                                {   
                                                    $flag1 = 0;
                                                    global $retVal , $flag1 ;
                                                    $GLOBALS['retVal'] = array();
                                                    $GLOBALS['flag1'] = 0;
                                                    $m_name = explode('->', $singleColumn );
                                                    $columnData = GeneralDataTableFtn::addforLoops($val , $m_name , 0 );
                                                    
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
                                            if($getPlaceholderDetails[0]['TableType'] != 3 ){
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
                                                    if(isset($singleColumnValue['Label'])){
                                                        $comNam = $singleColumnValue['Label'];
                                                    }else{
                                                        $comNam = $singleColumn;
                                                    }
                                                        $dataToTable[$comNam] = is_array($columnData)?$columnData[0]:$columnData;
                                                }
                                                
                                            } else {
                                                if($getPlaceholderDetails[0]['TableType'] == '3')
                                                { 
                                                    $dataToTable[$singleColumnVal] = $columnData;
                                                }else{
                                                    if(isset($singleColumnValue['Label'])){
                                                        $comNam = $singleColumnValue['Label'];
                                                    }else{
                                                        $comNam = $singleColumn;
                                                    }
                                                    $dataToTable[$comNam] = is_array($columnData)?$columnData[0]:$columnData;
                                                }
                                            }
                                            
                                            // action Button 
                                            if(!empty($tableActions))
                                            {
                                                $tableActionsKey=  array_keys($tableActions);
                                                $col = explode('->', $singleColumn);
                                                if (in_array($tableActionsKey[0],  $col )) {
                                                    $dataToTable[$tableActionsKey[0]] = $columnData;
                                                }
                                            }
                                            if (array_key_exists($singleColumn, $tableActions)) {
                                                foreach ($tableActions[$singleColumn] as $key => $value) {
                                                    $tableActions[$singleColumn][$key]['TableParameterColumnValue'] = $columnData;
                                                }
                                            }
                                        }
                                        //(End)for loop for every Column defined at the admin side table Placeholder
                                        //$dataToTable1[] = $dataToTable;
                                    }
                                    // (End)for loop for every  record
                                    $sumColumnLable = trim($sumColumnLable);
                                    if (isset($sumColumnLable) && !empty($sumColumnLable)) {
                                        if (isset($explodeColumns)) {
                                            if (!in_array($sumColumnLable, $explodeColumns)) {
                                                if (!empty($customSumData) ) {

                                                    if(is_array($customSumData))
                                                    {
                                                        $tempArr = array();
                                                        $tempVal = explode(',', $customSumData[0]);

                                                        foreach ($tempVal  as $key => $value) {
                                                                $tempArr[$key] = array();
                                                        }
                                                        
                                                        foreach ($customSumData as $key1 => $value1) {
                                                            
                                                            SumCalculation::SumCalulation($sumType , $customSumData , $columnSumResults , $getColumnsProperties , $sumColumnLable , $searchValue , $searchValueArray , $columnSumResultsValue , $value1 , $dataToTable );
                                                        }
                                                        if(count($tempArr) > 0)
                                                        {
                                                            foreach ($tempVal  as $key => $value) {
                                                                $dataToTable[] = $tempArr[$key];
                                                            }
                                                                
                                                        }else{
                                                            $dataToTable[] = $result;
                                                        }
                                                        
                                                        
                                                    }else{
                                                            SumCalculation::SumCalulation($sumType , $customSumData , $columnSumResults , $getColumnsProperties , $sumColumnLable , $searchValue , $searchValueArray , $columnSumResultsValue , $customSumData , $dataToTable );   
                                                    }
                                                }
                                            }
                                        }

                                    }
                                    // adding Action button link and related info on each row .
                                    // if($tableActions){
                                    //     $ActValue = ActionButton::getActionButton($tableActions , $tempRes , $actationTableColumn);
                                        
									// 	$tempRes[] =$ActValue[0];
									// 	$tempRes[] =$ActValue[1];
                                    // }   
                                    // if any filter is Applied .
                                    if ($filterion) {
                                        if($searchValueCount == $matchedValueCount) {
                                            $tableData['data'][] = $dataToTable;
                                        }
                                    } 
                                    else {
                                        $tableData[] = $dataToTable;
                                    }
                                  
                                    // (Start)Main part for Multiple Node processing 
                                    if($getPlaceholderDetails[0]['ApiType'] == '2'){
                                        $newResArr = array();
                                        // (Start) perform operation on the fetched Data 
                                        if(isset(($dataToTable1)))
                                        { 
                                           
                                            //(Start) For Each record perform Cartesian Product 
                                            foreach ($dataToTable1 as $kes => $vals) {
                                                $tabAct = [];
                                                if(!empty($tableActions))
                                                {
                                                    $tableActionsKey=  array_keys($tableActions);

                                                    if (array_key_exists($tableActionsKey[0],  $vals )) {
                                                        $tabAct = $vals[$tableActionsKey[0]];
                                                        unset($vals[$tableActionsKey[0]]);
                                                        $vals= array_merge($vals);
                                                    }
                                                }
                                                $tst = $vals[0];
                                                if( count($vals) >1 ){
                                                    for ($i=1; $i < count($vals) ; $i++) { 
                                                        
                                                        if(!is_array($tst))
                                                        {
                                                            $tst = array($tst);
                                                        }
                                                        if(!is_array($vals[$i]))
                                                        {
                                                            $vals[$i]= array($vals[$i]);
                                                        }

                                                        $tst = GeneralDataTableFtn::cartesian($tst , $vals[$i]);
                                                    }
                                                    foreach ($tst as $key => $value) {
                                                        $tempRes = array();
                                                        $tempRes = GeneralDataTableFtn::array_flatten($value);
                                                        // if ($tableActions) 
                                                        // {
                                                        //     $ActValue = ActionButton::getActionButton($tableActions , $tempRes , $actationTableColumn);
                                                        //     $tempRes[] =$ActValue[0];
										                //     $tempRes[] =$ActValue[1];              
                                                        // }
                                                        
                                                        array_push($newResArr1 , $tempRes);
                                                    }
                                                }else{
                                                    
                                                    foreach ($tst as $key => $value) {
                                                        $newTam = [];
                                                        $newTam[] = $value ;
                                                        array_push($newResArr1 , $newTam);
                                                    }
                                                }
                                            }
                                             //(End) For Each record perform Cartesian Product 
                                        }
                                        //(End) perform operation on the fetched Data 
                                        else{
                                            
                                            $tst = $dataToTable;

                                            for ($i=1; $i < count($dataToTable) ; $i++) { 
                                                
                                                if(!is_array($tst))
                                                {
                                                    $tst = array($tst);
                                                }
                                                if(!is_array($dataToTable[$i]))
                                                {
                                                    $dataToTable[$i]= array($dataToTable[$i]);
                                                }

                                                $tst = GeneralDataTableFtn::cartesian($tst , $dataToTable[$i]);
                                            }
                                            foreach ($tst as $key => $value) {
                                                $tempRes = array();
                                                $tempRes = GeneralDataTableFtn::array_flatten($value);
                                                array_push($newResArr1 , $tempRes);
                                            }
                                            print_r($newResArr1); exit;
                                        }
                                        if($_REQUEST['APIData']['showFocusPage'])
                                        {
                                            if(isset($_REQUEST['APIData']['parameterFocusPage']) && !empty($_REQUEST['APIData']['parameterFocusPage'])){
                                                $var = explode('-', $_REQUEST['APIData']['parameterFocusPage']);
                                                $var = isset($var[1])?$var[1]:'';
                                                $var12 = trim($_REQUEST['APIData']['parameterFocusPage']);
                                                $value['detailUrl'] = baseUrl.$_REQUEST['APIData']['APIUrl'].'/getSpecficDetail?'.trim($var).'='.$value[$var12];

                                                //unset($value[$var12]);
                                            }
                                        }
                                        if(isset($value)){
                                            foreach ($value as $k => $v) {

                                                $oldke = explode('-', $k);
                                                $ke = isset($oldke[1])?trim($oldke[1]):trim($oldke[0]);
                                                    if(count($oldke) > 1){
                                                    if($value[$k]){
                                                        $value[$ke] = $v;
                                                    }
                                                    else{
                                                        $value[$ke] = "";
                                                    }
                                                    if($k != 'detailUrl'){
                                                        unset($value[$k]);
                                                    }
                                                    }
                                                    
                                                }
                                                
                                                $tableData['data'][] = $value;
                                        }
                                        

                                    }

                                    }
                                    // (End)Main part for Multiple Node processing 
                                }//(End) if column name list is not empty 
                            }
                            //(End) if we have a row 
                        }
                        //(End) if we have multiple records 
                    }
                    
                }
               
            //(End) if Api call return any Result  
           
            if(empty($newResArr1)){
                return $tableData;
            }else{
                return $newResArr1;
            }
            
        }
        //(End) if a call is made 
             
    }

}