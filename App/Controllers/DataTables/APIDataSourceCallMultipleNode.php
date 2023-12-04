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
    public static function getAPIDataSourceCallMultipleNode($getPlaceholderDetails , $getCompanyDetails , $getSourceType, $requestUrl , $customSumFormula , $explodeColumns , $getColumnsList , $sumColumnLable , $sumType , $keyColumnName , $tableActions , $filterion , $actationTableColumn , $getColumnsProperties ,  $placeholderId , $userPagePlaceholder)
    {
        //Variable declaration 
        $tableData['data'] = array();
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
                //$results = preg_replace('/\: *([0-9]+\.?[0-9e+\-]*)/', ':"\\1"', $results);
                
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
                                    
                                   
                                    if(count($apiData) == 1 && $getPlaceholderDetails[0]['ApiType'] == '2' && $getPlaceholderDetails[0]['TableType'] != 3){
                                        $newNames = array();
                                        if($getPlaceholderDetails[0]['ApiType'] == '2'){
                                            $mainName = explode(',', $getPlaceholderDetails[0][7]);
                                           
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
                                                #print_r ($eachRecord);
                                                
                                            }
                                        $dataToTable1 = [];
                                       
                                        if (array_key_exists('boards',$eachRecords))
                                        {
                                            $eachRecords= $eachRecords['boards'];

                                         }
                                        foreach ($eachRecords as $key => $val ) {
                                           
                                            $dataToTable= [];
                                            
                                            $val['Nodes'] = $val;

                                            foreach ($explodeColumns as $singleColumn => $singleColumnValue) {
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
                                                
                                                if(strpos($singleColumn,'->') !== false)
                                                {   

                                                    $flag1 = 0;
                                                    global $retVal , $flag1 ;
                                                    $GLOBALS['retVal'] = array();
                                                    
                                                    $GLOBALS['flag1'] = 0;
                                                    $m_name = explode('->', $singleColumn );
                                                    
                                                    $columnData = GeneralDataTableFtn::addforLoops($val , $m_name , 0 );
                                                 
                                                }else{
                                                   
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
                                                /*if ($columnData && is_numeric($columnData)) {
                                                    $columnData = round($columnData);
                                                }*/
                                               
                                               
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
                                         $dataToTable1[] = $dataToTable;
                                        }

                                    }else{
                                        
                                        foreach ($explodeColumns as $singleColumn => $singleColumnValue) {
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
                                            
                                            if(strpos($singleColumn,'->') !== false)
                                            {   

                                                $flag1 = 0;
                                                global $retVal , $flag1 ;
                                                $GLOBALS['retVal'] = array();
                                                
                                                $GLOBALS['flag1'] = 0;
                                                $m_name = explode('->', $singleColumn );
                                               
                                                $columnData = GeneralDataTableFtn::addforLoops($eachRecord , $m_name , 0 );
                                                
                                            }else{
                                               
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
                                   
                                    if($tableActions){
                                        $ActValue = ActionButton::getActionButton($tableActions , $dataToTable , $actationTableColumn, $placeholderId , $userPagePlaceholder);
                                        
										$dataToTable[] =$ActValue[0];
										$dataToTable[] =$ActValue[1];
                                       
                                       
                                    }   
                                   
                                    // if any filter is Applied .
                                    if ($filterion) {
                                        if($searchValueCount == $matchedValueCount) {
                                            $tableData['data'][] = $dataToTable;
                                        }
                                    } 
                                    else {
                                        $tableData['data'][] = $dataToTable;
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
                                                        if ($tableActions) 
                                                        {
                                                            $ActValue = ActionButton::getActionButton($tableActions , $tempRes , $actationTableColumn , $placeholderId , $userPagePlaceholder);
                                                            $tempRes[] =$ActValue[0];
										                    $tempRes[] =$ActValue[1];              
                                                        }
                                                        
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
                                        
                                       
                                        }// (End API type 2 )
                                       
                                        if($getPlaceholderDetails[0]['TableType'] == 3)
                                        {
                                            $joinTbaleRes[$getPlaceholderDetails[0]['ID']] = $tableData;
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
          
            if($getPlaceholderDetails[0]['TableType'] == 3)
            {
                if(!isset($joinTbaleRes))
                {
                    $joinTbaleRes[$getPlaceholderDetails[0]['ID']] = $tableData;
                }
                return  $joinTbaleRes[$getPlaceholderDetails[0]['ID']];
            }else{
               
                if(empty($newResArr1)){
                    return $tableData['data'];
                }else{
                    return $newResArr1;
                }
               
            }
          
        }
        //(End) if a call is made 
        
             
    }

}