<?php

namespace App\Controllers\DataTables;

use \Core\View;
use App\Models\Page;
use \App\Models\User;
use \App\Models\Companies;
use App\Models\Placeholder;
use App\Controllers\DataFormatHelper\DataTableHelper;
use App\Controllers\DataTables\DBDataSourceCallData;

class JoinTableData  extends \Core\Controller
{
	public static function getJoinTableData($joinTbaleRes , $getPlaceholderDetails ,$explodeColumns ,$sumType , $columnSumResults , $getColumnsProperties , $sumColumnLable , $searchValue , $searchValueArray , $columnSumResultsValue , $tableMatchId, $placeholderId){
        
		$getPlaceholderDetailsColumnProperties  =  isset($getColumnsProperties)?$getColumnsProperties:array();
        $getCompanyDetails = Companies::getCompaniesDetails($_SESSION['UserID']); 
        //(Start) get all the table result that need to be joined .
      
           
       
		if(!empty($joinTbaleRes) && $getPlaceholderDetails[0]['ColumnsMatching'] != '')
            {
                
                $tempDataArr = [];
                $compareTable = isset($joinTbaleRes[$tableMatchId]['data'])?$joinTbaleRes[$tableMatchId]['data']:array();
                unset( $joinTbaleRes[$tableMatchId]);	
                // Process for matching the Column value in both table and creating a new combined data 
                
                foreach($compareTable as $comTabKey => $comTabVal)
                {
                    // Variable Declaration
                    $tabId =  array_keys($joinTbaleRes);
                    $tabId = $tabId[0];
                    $oneTymEntry = 0 ;
                    $jTabRes =  [];
                   
                    foreach($joinTbaleRes[$tabId]['data'] as $joinTbaleResKey => $joinTbaleResValue){

                       
                       
                        $matchCol = explode(',', $getPlaceholderDetails[0]['ColumnsMatching']);
                        $ColumnTobeMatched =  explode(',', $getPlaceholderDetails[0]['ColumnsToBeMatched']);
                        $cnt = 0;
                        $matchColval = '';

                        $cntMatchCol = count($matchCol);
                        $cntColumnTobeMatched = count($ColumnTobeMatched);
                       
                        if($cntMatchCol == $cntColumnTobeMatched){
                            foreach ($matchCol as $matchColkey => $matchColvalue) {
    
                                if(strpos($matchColvalue, ';')!== false)
                                {
                                    $matchColvalue = explode(';', $matchColvalue);
                                    $matchColval =  $comTabVal[$matchColvalue[0]];
                                }else
                                {
                                   
                                    if(array_key_exists($matchColvalue, array_keys($comTabVal)))
                                    {
                                        $matchColval =  $comTabVal[$matchColvalue];
                                    }else{
                                        $colMVal = explode('-', $matchColvalue);
                                        $colMVal = end($colMVal);
                                        if(isset( $comTabVal[$colMVal]))
                                        {
                                            $matchColval =  $comTabVal[$colMVal];
                                        }else{
                                            $matchColval =  $comTabVal[$matchColvalue];
                                        }
                                       
                                      
                                    }
    
                                   
                                }
                               
                               
                                if($matchColval == $joinTbaleResValue[$ColumnTobeMatched[$matchColkey]])	
                                { 
                                    $cnt = $cnt + 1 ;
                                }
                                
                            } 
                        }else if($cntMatchCol != $cntColumnTobeMatched){

                            if($cntMatchCol > $cntColumnTobeMatched){
                                
                            
                                foreach ($matchCol as $matchColkey => $matchColvalue) {
        
                                    if(strpos($matchColvalue, ';')!== false)
                                    {
                                        $matchColvalue = explode(';', $matchColvalue);
                                        $matchColval .=  $comTabVal[$matchColvalue[0]];
                                    }else
                                    {
                                        if(array_key_exists($matchColvalue, array_keys($comTabVal)))
                                        {
                                            $matchColval .=  $comTabVal[$matchColvalue];
                                        }else{
                                            $colMVal = explode('-', $matchColvalue);
                                            $colMVal = end($colMVal);
                                            if(isset( $comTabVal[$colMVal]))
                                            {
                                                $matchColval .=  $comTabVal[$colMVal];
                                            }else{
                                                $matchColval .=  $comTabVal[$matchColvalue];
                                            }
                               
                                        }
                                    }
                                }   
                                    
                                
                                    $cntColumnTobeMatched = $cntColumnTobeMatched-1;
                                    if($matchColval == $joinTbaleResValue[$ColumnTobeMatched[$cntColumnTobeMatched]])	
                                    { 
                                        $cnt = $cnt + 2 ;
                                    }else{
                                        $joinTbaleResValue = $comTabVal;
                                    }
                            }   
                        }
                     
                        if($cnt == count($matchCol))	
                        {   
                         
                            $temp = [];
                            foreach($joinTbaleResValue as $keyVal  =>  $Vals){
                               
                                if(empty($Vals)){
                                   
                                    if(in_array($keyVal , array_keys($comTabVal) ))
                                    {
                                        $temp[$keyVal] = $comTabVal[$keyVal] ;
                                    }
                                    elseif(array_key_exists($keyVal, array_keys($comTabVal))){
                                        $temp[$keyVal] = $comTabVal[$keyVal] ;
                                    }else{
                                        $chk = 0;
                                        $keyValT = explode('-', $keyVal);
                                        $keyValT = end($keyValT);
                                       
                                      
                                        foreach ($comTabVal as $keycomTabVal => $valuecomTabVal) {
                                            if(strpos($keycomTabVal, '->'))
                                            {
                                               $var = explode('->', $keycomTabVal );
                                               $var = end($var);
                                            }else{
                                                $var = $keycomTabVal;
                                            }
                                       
                                            if($keyValT == $var){
                                                $temp[$keyVal] = $comTabVal[$keycomTabVal] ;
                                                $chk = 1;
                                                break;
                                            }
                                          
                                        }
                                        if($chk == 0)
                                        {
                                            $temp[$keyVal] = $Vals ;
                                        }
                                       
                                    }
                                  
                                    
                                }else{
                                    $temp[$keyVal] = $Vals ;
                                }


                            }
                         
                            if(!isset($tempDataArr[$tabId]['data']))
                            {
                                $tempDataArr[$tabId]['data'][] =  $temp ;
                                
                            }else{
                                array_push($tempDataArr[$tabId]['data'] , $temp );
                            }
                            if(!empty($jTabRes)){
                                $jTabRes = [];
                                $oneTymEntry = 1;
                               
                            }
                            
                        
                        }else{
                           
                           if(empty($oneTymEntry))
                           {
                                $jTabRes = $joinTbaleResValue ;
                           }
                         
                        }
                            
                    }    
                          
                    if($jTabRes && empty($oneTymEntry))
                    {
                        
                        $temp = [];
                        $temp1 = [];
                        if($cnt == count($matchCol)){
                            foreach($jTabRes as $keyVal  =>  $Vals)
                            {
                                
                                if(empty($Vals)){
                                    if(array_key_exists($keyVal, array_keys($comTabVal))){
                                        $temp[$keyVal] = $comTabVal[$keyVal] ;
                                    }else{
                                        $chk = 0;
                                        $keyValT = explode('-', $keyVal);
                                        $keyValT = end($keyValT);
                                       
                                       
                                        foreach ($comTabVal as $keycomTabVal => $valuecomTabVal) {
                                            if(strpos($keycomTabVal, '->'))
                                            {
                                               $var = explode('->', $keycomTabVal );
                                               $var = end($var);
                                            }else{
                                                $var = $keycomTabVal;
                                            }
                                       
                                            if($keyValT == $var){
                                                $temp[$keyVal] = $comTabVal[$keycomTabVal] ;
                                                $chk = 1;
                                                break;
                                            }
                                          
                                        }
                                        if($chk == 0)
                                        {
                                            $temp[$keyVal] = '' ;
                                        }
                                       
                                    }
                                  
                                    
                                    }else{
                                        $temp[$keyVal] = $Vals ;
                                    }
    
    
                            }
                        }else{
                            $temp = $jTabRes;
                           
                            foreach($jTabRes as $keyVal  =>  $Vals)
                            {

                                    if(array_key_exists($keyVal, array_keys($comTabVal))){
                                        $temp1[$keyVal] = $comTabVal[$keyVal] ;
                                    }else{
                                        $chk = 0;
                                        $keyValT = explode('-', $keyVal);
                                        $keyValT = end($keyValT);
                                       
                                       
                                        foreach ($comTabVal as $keycomTabVal => $valuecomTabVal) {
                                            if(strpos($keycomTabVal, '->'))
                                            {
                                               $var = explode('->', $keycomTabVal );
                                               $var = end($var);
                                            }else{
                                                $var = $keycomTabVal;
                                            }
                                       
                                            if($keyValT == $var){
                                                $temp1[$keyVal] = $comTabVal[$keycomTabVal] ;
                                                $chk = 1;
                                                break;
                                            }
                                          
                                        }
                                        if($chk == 0)
                                        {
                                            $temp1[$keyVal] = '' ;
                                        }
                                       
                                    }
                                  
                                    
    
    
                            }
                            
                            
                        }
                       
                           
                        if(!isset($tempDataArr[$tabId]['data']))
                        {
                            $tempDataArr[$tabId]['data'][] =  $temp ;
                            
                        }else{
                            if(!empty($temp1)){
                                array_push($tempDataArr[$tabId]['data'] , $temp1 );
                            }
                            array_push($tempDataArr[$tabId]['data'] , $temp );
                        }
                          
                        $oneTymEntry = 1;
                    }
                        
                }   
               
                if($tempDataArr){
                        unset($joinTbaleRes);
                        $joinTbaleRes= $tempDataArr;
                }else{
                    
                        $tableData['data'] = '';
                        //$joinTbaleRes =[];
                }
            }
        //(End)get all the table result that need to be joined . 
        // (Start) if the data is joined 
       
        if(!empty($joinTbaleRes))
        {
            // Variable declaration
            $tableData = array();
            $allKeys = array_keys($joinTbaleRes);
            $tempcnt = 0;
            $mainKey = 0;
            $newRe = array();
            // get all Keys as they are the Table ID 
            foreach ($allKeys as $key => $valu) {
              if(count($joinTbaleRes[$valu]['data'])> $tempcnt)
              {
                $tempcnt = count($joinTbaleRes[$valu]['data']);
                $mainKey = $valu;
              }
            }
            // (Start)Processing for joined table Data     
            foreach ($joinTbaleRes[$mainKey]['data'] as $key => $value) 
            {
                // (Start)Processing for join table data 
                foreach ($allKeys as $k => $v) {
                    if($v != $mainKey)
                    {
                        if(isset($joinTbaleRes[$v]['data'][$key])){
                            foreach ($value as $key12 => $value12) {
                                if(empty($value12) && !empty($joinTbaleRes[$v]['data'][$key][$key12]))
                                {
                                    $value[$key12] = $joinTbaleRes[$v]['data'][$key][$key12] ;
                                }else if(!empty($value12) && !empty($joinTbaleRes[$v]['data'][$key][$key12])){
                                    $nwArr = array($key12.'-'.$v =>$joinTbaleRes[$v]['data'][$key][$key12]);
                                    $value = array_merge($value , $nwArr);
                                }
                            }
                        }
                    }
                }
               
                // (Start)Processing for join table data 
                $customSumFormula = (isset($getPlaceholderDetails[0]['CustomSumFormula'])) ? $getPlaceholderDetails[0]['CustomSumFormula'] : "";
               
                // For each column will perform formating or custom sum according to setting in table place holder 
                foreach ($explodeColumns as $singleColumn => $singleColumnValue) {
                    if(!isset($value[$singleColumn]))
                    {
                        $value[$singleColumn] = '';
                    }
                    $columnData = $value[$singleColumn];
                    if($getPlaceholderDetails[0]['TableType'] == 3)
                    {
                            $columnDataFlag  = 0;
                            $singleColumnVal = $singleColumn;
                            
                            if (isset( $getPlaceholderDetailsColumnProperties) ) {
                                $singleColumn12 = explode('-', $singleColumn);
                                if($singleColumn12[1] != '')
                                {
                                    $columnDataFlag  = 1;
                                    $singleColumn12 = end($singleColumn12);
                                }
                               
                                $singleColumnValue = isset( $getPlaceholderDetailsColumnProperties[$singleColumn12])? $getPlaceholderDetailsColumnProperties[$singleColumn12]:$singleColumn12;
                            }
                    }
                    // (Start)Custom Sum formala replacing the column name with data       
                    if (isset($customSumFormula) && !empty($customSumFormula) ) 
                    {
                        if(isset($singleColumnValue['Label']) && $singleColumn != $singleColumnValue['Label'])
                        {
                            $replaceColumn = "(" . $singleColumnValue['Label'] . ")";
                        }else{
                            $replaceColumn = "(" . $singleColumnVal . ")";
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
                            if(!empty($columnData))
                            {
                                $sumColumnData = str_replace(array(',', ' '), '', $columnData);
                                $customSumData = str_replace($replaceColumn, $sumColumnData, $customSumFormula);
                                $customSumFormula = $customSumData;
                            }else{
                               
                                $sumColumnData = str_replace(array(',', ' '), '', 0);
                                $customSumData = str_replace($replaceColumn, $sumColumnData, $customSumFormula);
                                $customSumFormula = $customSumData;
                            }
                        }
                    }
                   
                    
                    // (end)Custom Sum formala replacing the column name with data      
                    $columnData = DataTableHelper::ColumnProperties($columnData,$singleColumnValue);
                   // $columnData = DataTableHelper::columnDataRound($columnData,$singleColumnValue);  
                    $value[$singleColumnVal] = $columnData;
                    $sumColumnLable = trim($sumColumnLable);
                   
                    }  
                    // (Start)Custom Sum Calcultion 
                    if (isset($sumColumnLable) && !empty($sumColumnLable)) {
                            if (isset($explodeColumns)) {
                                if (!in_array($sumColumnLable, $explodeColumns)) {
                                    if (!empty($customSumData) ) {

                                        if(is_array($customSumData))
                                        {
                                            $tempArr = array();
                                            $tempVal = explode(',', $customSumData[0]);

                                            foreach ($tempVal  as $key => $val) {
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
                                                   array_push($value, $result);
                                                }
                                            
                                           
                                        }else{
                                        	SumCalculation::SumCalulation($sumType , $customSumData , $columnSumResults , $getColumnsProperties , $sumColumnLable , $searchValue , $searchValueArray , $columnSumResultsValue , $customSumData , $dataToTable ); 
                                        }
                            }

                   		 	}
						}

            		}
                     // (End)Custom Sum Calcultion 
                     // Processing for Image as need to separate the images .
                    // if( !empty($value['1016_SB_Masterdata_Per_kund-Pack'] )){
                    //     print_r($value); exit;
                    // }
                   
       			    $getKeys = array_keys($value);
                    foreach ($getKeys as $kgetKeys => $vgetKeys) {
                        if(strpos($vgetKeys , '-Images' ))
                        {
                            $img = explode(',', $value[$vgetKeys]);
                            // Total 6 images can increase the Number from here .
                            for ($i=0; $i <= 10 ; $i++) { 
                                if(isset($img[$i])){
                                    $value[] = $img[$i];
                                }else{
                                    $value[] = '';
                                }
                        
                            }
                        unset($value[$vgetKeys]);
                        }
                        
                    }
                    
                    foreach ($getKeys as $kgetKeys => $vgetKeys) {
                        
                        if(strpos($vgetKeys , 'Pack' )){
                            $temp = $value[$vgetKeys];
                            unset($value[$vgetKeys]);
                            $value[$vgetKeys]= $temp;
                            $skupack = '';
                            $modelNo = '';
                            if(!empty($temp) && $getPlaceholderDetails[0]['EnableChildRowsRunTym']){
                                foreach ($getKeys as $k => $v) {
                                    if(strpos($v , 'DimensionDescription' )){
                                        $skupack = $value[$v];
                                    }
                                    if(strpos($v , 'ModelNo' )){
                                        $modelNo = $value[$v];
                                    }

                                }

                                $reqBody = '';
                               
                                foreach ($temp as $tempkey => $tempvalue) {
                                    $reqBody .= "'".$tempvalue['SKU']."' ,"; 
                                }
                                
                                $_REQUEST['ChildProductNo'] = "(".trim($reqBody , ',').")";
                                $_REQUEST['SKUPack'] = $skupack;
                                $_REQUEST['ModelNo'] = $modelNo;
                                //Child row Part 
                                if($getPlaceholderDetails[0]['EnableChildRowsRunTym']){
                                    $getChilRowDetails = Page::getChildRow($placeholderId);
                                    $getPlaceholderChild= Page::getDatasourceTableDetails($getChilRowDetails[0]['TableTemplateId']);
                                    $getPlaceholderChild[0]['TableType'] = 3;
                                    // Variable Declaration 
                                    $newResArr1 = array();
                                    $requestUrl = '';
                                    $requestType = '';
                                    $requestBody = '';
                                    $requestGAPI = '';
                                    $accessTokenGAPI = '';
                                    $accessRefreshTokenGAPI = '';
                                    $displayDetailButton = false;
                                    $showMapButton = false;
                                    $customSumData = '';
                                    $customSumDataArr = array();
                                    $explodeColumnsChild= '';
                                    $columnsListChild = array();
                                      
                                    // get Source type from Source type File . 
                                    $getSourceType = SourceType::getSourceType($getPlaceholderChild , 'address');
                                   
                                    // getting Column Name .  will get the Columns in case of multiple Node .
                                    if($getPlaceholderChild[0]['ApiType'] == '2')
                                    {
                                        $getColumnsListChild = $getPlaceholderChild[0]['Columns'];
                                    }else{
                                        $getColumnsListChild = $getPlaceholderChild[0]['tableColumns'];
                                    
                                    } 
                                    $newExplodeColumnschild = array();
                                    // (Start) if we got the Column Name 
                                    if (isset($getColumnsListChild)) {
                                        //Processing for Column Name properties .
                                        $explodeColumnsChild = explode(',', $getColumnsListChild);
                                        $explodeColumnsChild = array_combine($explodeColumnsChild,$explodeColumnsChild);
                                        $columnsListChild = explode(',', $getColumnsListChild);
                                        $getColumnsPropertiesChild = $getPlaceholderChild[0]['ColumnsProperties'];
                                        
                                        if (isset($getColumnsPropertiesChild)) {
                                            $getColumnsPropertiesChild = json_decode($getColumnsPropertiesChild, true);

                                            if(!empty($getPlaceholderDetailsColumnPropertiesChild)){
                                                $getPlaceholderDetailsColumnPropertiesChild = array_merge($getPlaceholderDetailsColumnPropertiesChild, $getColumnsProperties);
                                            }else{
                                                $getPlaceholderDetailsColumnPropertiesChild = $getColumnsPropertiesChild;
                                            }
                                            $getColumnsPropertiesChild = array_replace(array_flip($explodeColumnsChild), $getColumnsPropertiesChild);
                                            unset($explodeColumnsChild);
                                            foreach($getColumnsPropertiesChild as $key => $value12) {
                                                if(in_array($key, $columnsListChild)) {
                                                    $explodeColumnsChild[$key] = $value12;
                                                }
                                            }
                                        }
                                    }
                                    // (End) if we got the Column Name
                                    // Variable Declarationn and initialization 
                                    $sumColumnLable = $getPlaceholderChild[0]['SumColumnLable'];
                                    $keyColumnName = $getPlaceholderChild[0]['KeyColumn'];
                                    $customSumFormula = $getPlaceholderChild[0]['CustomSumFormula'];
                                    $companyAddress = $getCompanyDetails[0]['CompanyGISKey'];
                                    $companyToken = $getCompanyDetails[0]['CompanyGISToken'];
                                    $requestType = $getPlaceholderChild[0]['RequestType'];
                                    $requestBody = $getPlaceholderChild[0]['Body'];
                                    $requestGAPI = $getPlaceholderChild[0]['SourceAddress'];
                                    $accessTokenGAPI =  $getCompanyDetails[0]['GoogleAccessToken'];
                                    $accessRefreshTokenGAPI =  $getCompanyDetails[0]['GoogleAccessRefreshToken'];
                                    // replacing (NOW TIMe) in Body to actual time 
                                    if (strpos($requestBody, strtolower('(nowtime)')) !== false) {
                                        if(isset($_SESSION['NowTime'])){
                                            $requestBody = str_replace("(nowtime)", $_SESSION['NowTime'], $requestBody);
                                        }
                                    }
                                    //Getting Placeholder Name 
                                    $getPlaceholderColumn = trim($getPlaceholderChild[0]['Placeholder']);
                                    if ($getPlaceholderColumn) {
                                        $getRequestData = (isset($_REQUEST[$getPlaceholderColumn])) ? $_REQUEST[$getPlaceholderColumn] : "";
                                        if ($getRequestData) {
                                            $requestBody = str_replace("(" . $getPlaceholderColumn . ")", $getRequestData, $requestBody);
                                        }
                                    }
                                  
                                    //Getting the Request Url 
                                    $sumType = $getPlaceholderChild[0]['SumType'];
                                    $requestUrl = str_replace("(address)", $companyAddress, $getSourceType);
                                    $requestUrl = str_replace("(token)", $companyToken, $requestUrl);
                                    $filterion = false;
                                    //replacing (NOW TIMe) from Body to actual time 
                                    if (strpos($requestUrl, strtolower('(nowtime)')) !== false) {
                                        if(isset($_SESSION['NowTime'])){
                                            $requestUrl = str_replace("(nowtime)", $_SESSION['NowTime'], $requestUrl);
                                        }
                                    }

                                    $columnSumResults = 0;
                                    $searchValueArray = array();
                                    $columnSumResultsValue = array();
                                    $tableActions = array();
                                    $actationTableColumn = '';
                                  
                                    //(Start) Fetching Data  from Data Source Call DB 
                                    if ($requestType == 3) {
                                        $tableDatachild = DBDataSourceCallRowCreation::getDBDataSourceCallRowCreation( $getPlaceholderChild , $getCompanyDetails, $getSourceType ,  $tableActions , $getColumnsListChild , $explodeColumnsChild ,
                                                $keyColumnName , $searchValue , $actationTableColumn , $filterion , $getColumnsPropertiesChild);
                                        if(empty($tableDatachild))
                                        {
                                            $tableDatachild['data'] = [];
                                        }
                                        if($getPlaceholderChild[0]['TableType'] == 3)
                                        {
                                            
                                            $value[$vgetKeys]= $tableDatachild['data'];
                                           
                                        }

                                    } 
                                    //(ENd) Fetching Data  from Data Source Call DB 
                                    //(Start) Fetching Data  from Data Source Call Api  
                                    else {
                                        // Calling Funbction for multiple Node 
                                        
                                        if(isset($getPlaceholderChild) && $getPlaceholderChild[0]['ApiType'] == '2')
                                        {
                                            $tableDatachild = APIDataSourceCallMultipleNode::getAPIDataSourceCallMultipleNode($getPlaceholderChild , $getCompanyDetails , $getSourceType, $requestUrl , $customSumFormula , $explodeColumnsChild , $getColumnsListChild , $sumColumnLable , $sumType , $keyColumnName , $tableActions , $filterion ,   $actationTableColumn , $getColumnsPropertiesChild); 
                                            
                                        }else{
                                            $tableDatachild = APIDataSourceCallSingleNode::getAPIDataSourceCallSingleNode($getPlaceholderChild , $getCompanyDetails , $getSourceType, $requestUrl , $customSumFormula , $explodeColumnsChild , $getColumnsListChild , $sumColumnLable , $sumType , $keyColumnName , $tableActions , $filterion ,  $actationTableColumn , $getColumnsPropertiesChild); 
                                        }
                                        
                                        if($getPlaceholderChild[0]['TableType'] == 3)
                                        {
                                            $value[$vgetKeys]= $tableDatachild['data'];
                                        }

                                    }
                                        //(End) Fetching Data  from Data Source Call Api   
                                    
                                }
                                
                                //End Child Row 
                                } 
                            }else{}
                        
                        }
                        
                   // setting the value and removing the Column Name .
                    $value = array_values($value);
                   
                    foreach ($value as $k => $v) {
                        if($v){
                           if(is_array($v) && $k != 47)
                           {
                                $value[$k] = $v[0];
                           }else{
                                $value[$k] = $v;
                           }
                           
                        }
                        else if($v == 0 ){
                            $value[$k] = $v ;
                        }
                        else{
                            $value[$k] = "";
                        }
                    }
                   
                    if($getPlaceholderDetails[0]['EnableChildRowsRunTym'] && ($value[5] == 'BPack' ||  $value[5] == 'CPack' ))
                    {
                        if(!empty($value[47])){
                            foreach ($value[47] as $vkey => $vvalue) {
                               
                                $value[47][$vkey]['Antal_enhet'] = $vvalue['Antal_enhet'] * $value[7];
                                
                            }
                        }
                        
                        
                    }
                    $tableData['data'][] = $value;
            }
           
            // (End)Processing for join table Data    
            
        }
       
        if($getPlaceholderDetails[0]['EnableChildRowsRunTym']){
            $newArr = array();
            
           
            foreach ($tableData['data'] as $key => $value) {

                if(($value[5] == 'BPack') && !empty($value[47]))
                {
                    $tempcont = array();
                    $tempcont = $value;
                    $cnt =0 ;
                    foreach ($tableData['data'] as $inkey => $invalue) {
                        if(isset($tableData['data'][$inkey])){
                            if(!empty($tempcont[0]) && ($invalue[0] == $tempcont[0]) && $tableData['data'][$inkey][5] == 'CPack'  ) {
                                    
                                    unset($tableData['data'][$key]);
                                    if(isset($tableData['data'][$inkey][47])){
                                        $testArr = array();
                                        $testArr = $tempcont[47];
                                        foreach ($tableData['data'][$inkey][47] as $packey => $pacvalue) 
                                        {
                                            if(isset($tempcont[47])){

                                               foreach ($tempcont[47] as $packkey => $packvalue) {
                                                    if(($tempcont[47][$packkey]['VariantNo'] == $pacvalue['VariantNo']) && ($tempcont[47][$packkey]['Storlek'] == $pacvalue['Storlek']))
                                                    {
                                                        
                                                        $tableData['data'][$inkey][47][$packey]['Antal_enhet'] =
                                                        (int)$tempcont[47][$packkey]['Antal_enhet'] + (int)$pacvalue['Antal_enhet']  ;
                                                        unset($testArr[$packkey]);
                                                        break;
                                                    
                                                    }


                                               }
                                              
                                
                            
                                            }
                                        }
                                        if(count($testArr) >= 1){
                                            $tableData['data'][$inkey][47] = array_merge($tableData['data'][$inkey][47], $testArr );
                                        }

                                    }
                                    $cnt = 1 ; 
                                    $newArr[] = $tableData['data'][$inkey];
                                    unset($tableData['data'][$inkey]);
                                break;  
                            }
                        }
                        
                    }

                    if($cnt == 0){
                        $tableData['data'][$key] =  $tempcont ;
                    }
                    
                }
                
            }
            $tableData['data']= array_merge($tableData['data'] , $newArr);
        }
        $tableData['data'] =  array_values($tableData['data']);
        
        //  $input = array_map("unserialize", array_unique(array_map("serialize",  $tableData['data'])));
        //  $tableData['data'] =  $input;
        //print_r( $tableData); exit;
        // (End) if the data is joined    
        return $tableData;
	}

}
?>