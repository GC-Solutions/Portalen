<?php

namespace App\Controllers\Admin\adminPlaceholder;

use \Core\View;
use \App\Models\User;
use \App\Models\Placeholder;
use \App\Models\Page;
use \App\Models\Companies;
use \App\Models\DataSources;
use \App\Models\TablePlaceholders;
/**
 * Placeholders controller
 *
 * PHP version 7.0
 */
class TablePlaceholder extends \Core\Controller
{
	// Load the Add form 
	public function addTableAction()
    {
        $getDataSource = DataSources::getAllDataSource();
        $GetDynamicForm = Placeholder::GetDynamicForm();
        $getPredefinedVal = Page::getPredefinedVals();
       
        View::render('administrator/placeholder/add_table.php', ['getDataSource' => $getDataSource , 'GetDynamicForm' => $GetDynamicForm , 'getPredefinedVal' => $getPredefinedVal]);
    }

    // Load the Add form 
	public function addNewTableAction()
    {
        $getDataSource = DataSources::getAllDataSource();
        $GetDynamicForm = Placeholder::GetDynamicForm();
        View::render('administrator/placeholder/add_new_table.php', ['getDataSource' => $getDataSource , 'GetDynamicForm' => $GetDynamicForm]);
    }
     //Load column Settingform 
    
     public function addColumSettingAction()
     {
        $id = (isset($_REQUEST['id'])) ? $_REQUEST['id'] : "";
        if(!empty($id)){
            $getDataTable = Placeholder::getAllTableData("Tables");
          
            $getTableDetails = Placeholder::getTableDetails("Tables", $id);
           
            View::render('administrator/placeholder/add_column_setting.php', ['getDataTable' => $getDataTable  , 'getTableDetails' => $getTableDetails[0]]);
        }else{
            $getDataTable = Placeholder::getAllTableData("Tables");
            View::render('administrator/placeholder/add_column_setting.php', ['getDataTable' => $getDataTable ]);
        }
        
     }
     
     public function deleteColumnSetting()
     {
         $saveData = $_REQUEST;
         $saveData['EnableFilterWidth1'] = '';
         $saveData['CustomColumnWidth'] = '';
         $saveData['CustomColumnWidthName'] = '';
         $saveData['CustomColumnWidthDesc'] = '';
         $saveData['TableId'] = $_REQUEST['id'];

         TablePlaceholders::addColumnSetting($saveData);
         header('Location: ' . baseUrl . 'placeholders');

     }
     
     public function saveColumnSetting()
    {
        $saveData = $_REQUEST;
        $saveData['EnableFilterWidth1'] = 1;
       
        //$totalCol = TablePlaceholders::getTableColumns($saveData['TableId']);
       
        $totalCol =  $saveData['TotalColumns'];
        $newTempArr = [];
        for ($i=1; $i <= $totalCol ; $i++) { 
            $newTempArr[$saveData['ColumnWidthName'.$i]] = $saveData['ColumnWidth'.$i] ;
        }
        $saveData['CustomColumnWidth'] =  json_encode($newTempArr);
      
        TablePlaceholders::addColumnSetting($saveData);
        header('Location: ' . baseUrl . 'placeholders');

        

    }
    // Load the Add Join table form 
    public function  addJoinTableAction()
    {
        $getDataSource = DataSources::getAllDataSource();
        View::render('administrator/placeholder/add_join_table.php', ['getDataSource' => $getDataSource]);
    }
   
    // Save Data for Tables in DB
    public function saveTable()
    {
        $saveData = $_REQUEST;
        
        $columns = (isset($saveData['Columns'])) ? $saveData['Columns'] : "";
       
        $dataSourceId = (isset($saveData['DataSourceId'])) ? $saveData['DataSourceId'] : "";
        $GroupRowsColumn = (isset($saveData['GroupRowsColumn'])) ? $saveData['GroupRowsColumn'] : "";
        $columnsFooter = (isset($saveData['ColumnsFooter'])) ? $saveData['ColumnsFooter'] : "";
        $sumColumnLabel = (isset($saveData['SumColumnLable'])) ? $saveData['SumColumnLable'] : "";
        $HideColumn = (isset($saveData['HideColumn'])) ? $saveData['HideColumn'] : "";
        $PredefineSort = (isset($saveData['PredefineSort'])) ? $saveData['PredefineSort'] : "";
        $ExcludeZeroCol = (isset($saveData['ExcludeZeroCol'])) ? $saveData['ExcludeZeroCol'] : "";
        $ColumnsMatching = (isset($saveData['ColumnsMatching'])) ? $saveData['ColumnsMatching'] : "";
        $ColumnstoBeMatched = (isset($saveData['ColumnsToBeMatched'])) ? $saveData['ColumnsToBeMatched'] : "";
        $ColumnNameColor = (isset($saveData['ColumnNameColor'])) ? $saveData['ColumnNameColor'] : "";
        $EnableLastSearchDF = (isset($saveData['EnableLastSearchDF'])) ? $saveData['EnableLastSearchDF'] : "";
       $SelectPredefinedNames = (isset($saveData['SelectPredefinedNames'])) ? $saveData['SelectPredefinedNames'] : ""; 
        if ($columns) {
            $columns = implode(',', $columns);
        }
       
        if($EnableLastSearchDF){
            if(in_array( '1', $EnableLastSearchDF) && in_array('2' ,$EnableLastSearchDF ) ){
                $EnableLastSearchDF = '12';
            }else{
                $EnableLastSearchDF = implode(',', $EnableLastSearchDF);
            }
        }
        if ($dataSourceId) {
            $dataSourceId = implode(',', $dataSourceId);
        }
        if ($SelectPredefinedNames) {
            $SelectPredefinedNames = implode(',', $SelectPredefinedNames);
        }
        if ($columnsFooter) {
            if(!in_array($sumColumnLabel,$columnsFooter)){
                $columnsFooter[] = $sumColumnLabel;
            }
            $columnsFooter = rtrim(implode(',', $columnsFooter),',');
        }
        if ($GroupRowsColumn) {
            $GroupRowsColumn = implode(',', $GroupRowsColumn);
        }
        if ($HideColumn) {
            $HideColumn = implode(',', $HideColumn);
        }
        if ($PredefineSort) {
            $PredefineSort = implode(',', $PredefineSort);
        }
        if ($ExcludeZeroCol) {
            $ExcludeZeroCol = implode(',', $ExcludeZeroCol);
        }
        if ($ColumnsMatching) {
            $ColumnsMatching = implode(',', $ColumnsMatching);
        }
       
        if ($ColumnstoBeMatched) {
            $ColumnstoBeMatched = implode(',', $ColumnstoBeMatched);
        }
        if ($ColumnNameColor) {
            $ColumnNameColor = implode(',', $ColumnNameColor);
        }
        
      
        $saveData['Columns'] = $columns;
        $saveData['DataSourceId'] = $dataSourceId;
        $saveData['GroupRowsColumn'] =$GroupRowsColumn;
        $saveData['ColumnsFooter'] = $columnsFooter;
        $saveData['HideColumn'] = $HideColumn;
        $saveData['PredefineSort'] = $PredefineSort;
        $saveData['ExcludeZeroCol'] = $ExcludeZeroCol;
        $saveData['ColumnsMatching'] = $ColumnsMatching;
        $saveData['ColumnstoBeMatched'] = $ColumnstoBeMatched;
        $saveData['ColumnNameColor'] = $ColumnNameColor;
        $saveData['EnableLastSearchDF'] = $EnableLastSearchDF;
        $saveData['SelectPredefinedNames']  = $SelectPredefinedNames;
        
        if( isset($saveData['AllowColumnRowMarking']) && $saveData['AllowColumnRowMarking'] == 1)
        {
            $dataArr = [];
            foreach($_REQUEST['Columns'] as $colKey => $colVal){
               // $total = isset($saveData[$colVal.'_totalNum'])?$saveData[$colVal.'_totalNum']:0;
               $keys  = array_keys($saveData);
               $keyTemp = [];
               foreach($keys as $saveKey => $saveValue){
                    if(strpos($saveValue ,  $colVal.'_FirstParameter_') !== false){
                        $ids = explode( $colVal.'_FirstParameter_' , $saveValue);
                        $keyTemp[] = $ids[1];
                    }
                }
                $cnt = 1;
               
                foreach( $keyTemp as $ke => $i)
                {
                   
                    $conName = $colVal.'_Condition_'.$i;
                    $colorName = $colVal.'_Colors_'.$i;
                    if(!empty($saveData[$conName]) && !empty($saveData[$colorName]) ){
                       
                        $dataArr[$colVal][$cnt]['FirstParameter'] = $saveData[$colVal.'_FirstParameter_'.$i];
                        $dataArr[$colVal][$cnt]['Condition'] = $saveData[$colVal.'_Condition_'.$i];
                        $dataArr[$colVal][$cnt]['SecondParameter'] = $saveData[$colVal.'_SecondParameter_'.$i];
                        $dataArr[$colVal][$cnt]['TextColors'] = $saveData[$colVal.'_Colors_'.$i];
                       
                       
                    }
                    $cnt = $cnt +1;
                }
                
            }
           
            $dataArr = json_encode($dataArr);
            
            $saveData['ColorTextMatch'] = $dataArr;
        }
        // if( isset($saveData['EnableFilterWidth1']) && $saveData['EnableFilterWidth1'] == 1){
        //     $totalCol = $saveData['TotalColumns'];
        //     $newTempArr = [];
        //     for ($i=1; $i <= $totalCol ; $i++) { 
        //         $newTempArr[$saveData['ColumnWidthName'.$i]] = $saveData['ColumnWidth'.$i] ;
        //     }
        //     $saveData['CustomColumnWidth'] =  json_encode($newTempArr);

        // }
      
        if( isset($saveData['EnableRowGroupLevel']) && $saveData['EnableRowGroupLevel'] == 1){
            $RowGroupLevelColumns = array();
            if(isset($saveData['RowGroupLevelColumns1'])){
                $RowGroupLevelColumns['level1'] = $saveData['RowGroupLevelColumns1'];
                unset($saveData['RowGroupLevelColumns1']);
            }
            if(isset($saveData['RowGroupLevelColumns2'])){
                $RowGroupLevelColumns['level2'] = $saveData['RowGroupLevelColumns2'];
                unset($saveData['RowGroupLevelColumns2']);
            }
            if(isset($saveData['RowGroupLevelColumns3'])){
                $RowGroupLevelColumns['level3'] = $saveData['RowGroupLevelColumns3'];
                unset($saveData['RowGroupLevelColumns3']);
            }
            if(isset($saveData['RowGroupLevelColumns4'])){
                $RowGroupLevelColumns['level4'] = $saveData['RowGroupLevelColumns4'];
                unset($saveData['RowGroupLevelColumns4']);
            }
            $saveData['RowGroupLevelColumns'] = json_encode( $RowGroupLevelColumns);
        }
      
        if( isset($saveData['AllowDataGrouping']) && $saveData['AllowDataGrouping'] == 1){
            $tempArr = [];
            for ($i=1; $i <= $saveData['DataGroupCount'] ; $i++) { 
                $col = explode(',' ,$saveData['Columns'] );
                if(trim($saveData['ColumnSort']) != ''){
                    $col = explode(',' ,$saveData['ColumnSort'] );
                }else {
                    $col = explode(',' ,$saveData['Columns'] );
                }
                
                if(isset($saveData['StartDataGroup'.$i]) && $saveData['EndDataGroup'.$i]){ 
                    
                    $startName = array_search(trim($saveData['StartDataGroup'.$i]) ,  $col);
                    $endName = array_search(trim($saveData['EndDataGroup'.$i]) ,  $col);
                   
                    $tempArr[$i]['start'] = $startName;
                    $tempArr[$i]['End'] = $endName ;
                }
            }
            $saveData['DataGroupingJson'] = json_encode($tempArr);
        }
        TablePlaceholders::addTable($saveData ,0);
        header('Location: ' . baseUrl . 'placeholders');
    }
     // Save Data for  New Tables in DB
     public function saveNewTable()
     {
        $saveData = $_REQUEST;
    
        $columns = (isset($saveData['Columns'])) ? $saveData['Columns'] : "";
        $FooterSumArr=[];
        $HighChartColumnArr = [];
        $HighMapColumnArr = [];
        $HighPieChartColumnArr =[];
        $PredefineSearchArr = [];
        $InvisiblePredefineSearchArr = [];
        $PredefineSearchForRangeArr = [];
        $saveDataKeys = array_keys($saveData);
        
        foreach($saveDataKeys as $keyData => $valueData){
           
            //Footer Sum 
            if(strpos($valueData , 'FooterSum_') !== false){
                    $cnt  = substr($valueData, -1);
                    $valueDataNew = explode('FooterSum_' ,$valueData );
                    $valueDataNew =   rtrim($valueDataNew[1] , $cnt);
                    if(!isset($saveData['FooterSum_perform_custom_sum'.$cnt])){
                        if($valueData == 'FooterSum_Input_ColumnName'.$cnt &&  $saveData[$valueData] != ''){
                            $saveData['FooterSum_Input_ColumnName'.$cnt]  =  '';
                        }
                    }
                    if($valueData == 'FooterSum_Input_ColumnName'.$cnt &&  $saveData[$valueData] != ''){
                        $FooterSumArr[$cnt]['ColumnName'] =  $saveData['FooterSum_Input_ColumnName'.$cnt];
                        if( $saveData['FooterSum_custom_sum'.$cnt]  == '('.$saveData['FooterSum_Input_ColumnName'.$cnt].')'){
                            $FooterSumArr[$cnt]['perform_custom_sum']  = 0;
                        }
                    }else if($valueData == 'FooterSum_Input_ColumnName'.$cnt &&  $saveData[$valueData] == ''){
                        if(isset(($saveData['FooterSum_Input_ColumnName'.$cnt]))){
                            $saveData['FooterSum_custom_sum'.$cnt]  = '('.$saveData['FooterSum_ColumnName'.$cnt].')'; 
                            $FooterSumArr[$cnt]['perform_custom_sum']  = 0;
                            
                        }
                    }
                    if($valueData == 'FooterSum_footer_visible'.$cnt){
                        $saveData[$valueData] = rtrim($saveData[$valueData]);
                    }
                    $FooterSumArr[$cnt][$valueDataNew] = $saveData[$valueData] ;
            }
            //High Chart 
            if(strpos($valueData , 'HighChartColumn_') !== false){
                if(strpos($valueData , 'Input') !== false){
                    $valueData = str_replace('_Input' ,'' ,  $valueData );
                    $cnt  = substr($valueData, -1);
                   
                    $valueData =  $valueData.'_Input';
                } else{
                    $cnt  = substr($valueData, -1);
                    if(strpos($valueData , 'custom_sum') !== false){
                        $trim  = '';
                    }else{
                        $trim  = substr($valueData, -2);
                    }
                    
                }
                
                $valueDataNew = explode('HighChartColumn_' ,$valueData );
                $valueDataNew =   rtrim($valueDataNew[1] ,  $trim);
                $HighChartColumnArr[$cnt][$valueDataNew] = $saveData[$valueData] ;
            }
            if(strpos($valueData , 'HighMapColumn_') !== false){
                $cnt  = substr($valueData, -1);
                $valueDataNew = explode('HighMapColumn_' ,$valueData );
                $valueDataNew =   rtrim($valueDataNew[1] , $cnt);
                $HighMapColumnArr[$cnt][$valueDataNew] = $saveData[$valueData] ;
            }
            if(strpos($valueData , 'HighPieChartColumn_') !== false){
                $cnt  =  0;
                if($valueData == 'HighPieChartColumn_PieChartType'){
                    $valueDataNew = explode('HighPieChartColumn_' ,$valueData );
                    $valueDataNew =   rtrim($valueDataNew[1]);
                    $saveData[$valueData] = array('type' =>  $saveData[$valueData] );

                }else if ($valueData == 'HighPieChartColumn_PieChartLabel'){
                   
                    $valueDataNew = explode('HighPieChartColumn_' ,$valueData );
                    $valueDataNew =   rtrim($valueDataNew[1]);
                    $saveData[$valueData] = array('label' =>  $saveData[$valueData] );
                }else{
                    $cnt  = substr($valueData, -1);
                    $valueDataNew = explode('HighPieChartColumn_' ,$valueData );
                    $valueDataNew =   rtrim($valueDataNew[1] , $cnt);
                }
                if($cnt){
                    $HighPieChartColumnArr[$cnt][$valueDataNew] = $saveData[$valueData] ;
                }else{
                    $HighPieChartColumnArr[$valueDataNew] = $saveData[$valueData] ;
                }
               
            }
            if(strpos($valueData , 'PredefineSearch_') !== false){
                $cnt  = substr($valueData, -1);
                $valueDataNew = explode('PredefineSearch_' ,$valueData );
                $valueDataNew =   rtrim($valueDataNew[1] , $cnt);
            
                $PredefineSearchArr[$cnt][$valueDataNew] = $saveData[$valueData] ;
            }
           
            if(strpos($valueData , 'InvisiblePredefineSearch_') !== false){
                $cnt  = substr($valueData, -1);
                $valueDataNew = explode('InvisiblePredefineSearch_' ,$valueData );
                $valueDataNew =   rtrim($valueDataNew[1] , $cnt);
            
                $InvisiblePredefineSearchArr[$cnt][$valueDataNew] = $saveData[$valueData] ;
            }
            if(strpos($valueData , 'InvisiblePredefineSearch_') !== false){
                $cnt  = substr($valueData, -1);
                $valueDataNew = explode('InvisiblePredefineSearch_' ,$valueData );
                $valueDataNew =   rtrim($valueDataNew[1] , $cnt);
            
                $InvisiblePredefineSearchArr[$cnt][$valueDataNew] = $saveData[$valueData] ;
            }
            if(strpos($valueData , 'PredefineSearchForRange_') !== false){
                $cnt  = substr($valueData, -1);
                $valueDataNew = explode('PredefineSearchForRange_' ,$valueData );
                $valueDataNew =   rtrim($valueDataNew[1] , $cnt);
            
                $PredefineSearchForRangeArr[$cnt][$valueDataNew] = $saveData[$valueData] ;
            }

        }
       
        $newTempArr = array();
        foreach($FooterSumArr as $FooterSumArrKey => $FooterSumArrVal){
                // if(isset($FooterSumArrVal['Input_ColumnName']) && $FooterSumArrVal['Input_ColumnName'] != ''){
                //     $FooterSumArrVal['column_name'] = $FooterSumArrVal['Input_ColumnName'] ;
                // }
                unset($FooterSumArrVal['Input_ColumnName']);
                $FooterSumArrVal['column_name'] = $FooterSumArrVal['ColumnName'];
                unset($FooterSumArrVal['ColumnName']);
                $newTempArr[$FooterSumArrVal['column_name']] =  $FooterSumArrVal;
        }
        $saveData['FooterColumnsProperties'] = json_encode($newTempArr);
        $newTempArr = array();
       
        foreach($HighChartColumnArr as $HighChartColumnArrKey => $HighChartColumnArrVal){
                $input = 'labelY'.$HighChartColumnArrKey.'_Input';
                if(isset($HighChartColumnArrVal[$input]) && empty($HighChartColumnArrVal[$input])){
                    unset($HighChartColumnArrVal[$input]);
                }elseif(isset($HighChartColumnArrVal[$input]) && !empty($HighChartColumnArrVal[$input]) ){
                    $HighChartColumnArrVal['label'] = $HighChartColumnArrVal[$input];
                    unset($HighChartColumnArrVal[$input]);
                }

                if(isset($HighChartColumnArrVal['custom_sumY'.$HighChartColumnArrKey]) && empty($HighChartColumnArrVal['custom_sumY'.$HighChartColumnArrKey])){
                    unset($HighChartColumnArrVal['custom_sumY'.$HighChartColumnArrKey]);
                }
                if(isset($HighChartColumnArrVal['hide_secondary_name']) && !empty($HighChartColumnArrVal['hide_secondary_name'])){
                   $HighChartColumnArrVal['hide_secondary_name'] = true;
                }

                if( $HighChartColumnArrKey >= 2 && !isset($HighChartColumnArrVal['is_series']) && !isset($HighChartColumnArrVal['is_secondary'])){
                    $HighChartColumnArrVal['is_series']  = false;
                    $HighChartColumnArrVal['is_secondary']  = false;
                }else if(  $HighChartColumnArrKey >= 2 && !isset($HighChartColumnArrVal['is_series'])){
                    $HighChartColumnArrVal['is_series']  = false;
                    $HighChartColumnArrVal['is_secondary']  = true;
                }else if(   $HighChartColumnArrKey >= 2 && !isset($HighChartColumnArrVal['is_secondary'])){
                    $HighChartColumnArrVal['is_secondary']  = false;
                    $HighChartColumnArrVal['is_series']  = true;
                }

                $newTempArr[$HighChartColumnArrVal['label']] =  $HighChartColumnArrVal;
        }
        $saveData['ChartColumn'] =  empty($newTempArr)?'':json_encode($newTempArr);
        $newTempArr = array();
       
        foreach($HighMapColumnArr as $HighMapColumnArrKey => $HighMapColumnArrVal){
                
                $val = $HighMapColumnArrVal['field'];
                $newTempArr[$val] =  $HighMapColumnArrVal;
               
                if( $HighMapColumnArrKey > 0){
                    $newTempArr[$val]['field'] = 'label'.$HighMapColumnArrVal['field'];
                }
                
        }
        $saveData['MapColumn'] =  empty($newTempArr)?'':json_encode($newTempArr);
        $newTempArr = array();
     
        foreach($HighPieChartColumnArr as $HighPieChartColumnArrKey => $HighPieChartColumnArrVal){
                
                if(isset($HighPieChartColumnArrVal['field'])){

                    $val = $HighPieChartColumnArrVal['field'];
                    if(isset($HighPieChartColumnArrVal['drilldown']) && !empty($HighPieChartColumnArrVal['drilldown'])){
                        $HighPieChartColumnArrVal['drilldown'] = "true";
                    }
                    $newTempArr[$val] =  $HighPieChartColumnArrVal;

                }else{
                    $newTempArr[$HighPieChartColumnArrKey] =  $HighPieChartColumnArrVal;

                }
  
        }
       
        $saveData['PieChartColumn'] =  empty($newTempArr)?'':json_encode($newTempArr);
        $newTempArr = array();
       
        foreach($PredefineSearchArr as $PredefineSearchArrKey => $PredefineSearchArrVal){

            $val = $PredefineSearchArrVal['ColumnName'];
            unset($PredefineSearchArrVal['ColumnName']);
            $PredefineSearchArrVal["bRegex"] = true;
            $newTempArr[$val] =   $PredefineSearchArrVal;
        }
        $saveData['PredefineSearch'] =  empty($newTempArr)?'':json_encode($newTempArr); 
        $newTempArr = array();
       
        foreach($InvisiblePredefineSearchArr as $InvisiblePredefineSearchArrKey => $InvisiblePredefineSearchArrVal){

            $val = $InvisiblePredefineSearchArrVal['ColumnName'];
            unset($InvisiblePredefineSearchArrVal['ColumnName']);
            $newTempArr[$val] = $InvisiblePredefineSearchArrVal;
        }
        $saveData['InvisiblePredefineSearch'] =  empty($newTempArr)?'':json_encode($newTempArr); 
        $newTempArr = array();
        foreach($PredefineSearchForRangeArr as $PredefineSearchForRangeArrKey => $PredefineSearchForRangeArrVal){

            $val = $PredefineSearchForRangeArrVal['ColumnName'];
            unset($PredefineSearchForRangeArrVal['ColumnName']);
            $newTempArr[$val] = $PredefineSearchForRangeArrVal;
        }
        $saveData['PredefineSearchForRange'] = empty($newTempArr)?'':json_encode($newTempArr); 

        $dataSourceId = (isset($saveData['DataSourceId'])) ? $saveData['DataSourceId'] : "";
        $GroupRowsColumn = (isset($saveData['GroupRowsColumn'])) ? $saveData['GroupRowsColumn'] : "";
        $columnsFooter = (isset($saveData['ColumnsFooter'])) ? $saveData['ColumnsFooter'] : "";
        $sumColumnLabel = (isset($saveData['SumColumnLable'])) ? $saveData['SumColumnLable'] : "";
        $HideColumn = (isset($saveData['HideColumn'])) ? $saveData['HideColumn'] : "";
        $PredefineSort = (isset($saveData['PredefineSort'])) ? $saveData['PredefineSort'] : "";
        $ExcludeZeroCol = (isset($saveData['ExcludeZeroCol'])) ? $saveData['ExcludeZeroCol'] : "";
        $ColumnsMatching = (isset($saveData['ColumnsMatching'])) ? $saveData['ColumnsMatching'] : "";
        $ColumnstoBeMatched = (isset($saveData['ColumnsToBeMatched'])) ? $saveData['ColumnsToBeMatched'] : "";
        $ColumnNameColor = (isset($saveData['ColumnNameColor'])) ? $saveData['ColumnNameColor'] : "";
        $EnableLastSearchDF = (isset($saveData['EnableLastSearchDF'])) ? $saveData['EnableLastSearchDF'] : "";

        if ($columns) {
            $columns = implode(',', $columns);
        }
        
        if($EnableLastSearchDF){
            if(in_array( '1', $EnableLastSearchDF) && in_array('2' ,$EnableLastSearchDF ) ){
                $EnableLastSearchDF = '12';
            }else{
                $EnableLastSearchDF = implode(',', $EnableLastSearchDF);
            }
        }
        if ($dataSourceId) {
            $dataSourceId = implode(',', $dataSourceId);
        }
        if ($columnsFooter) {
            if(!in_array($sumColumnLabel,$columnsFooter)){
                $columnsFooter[] = $sumColumnLabel;
            }
            $columnsFooter = rtrim(implode(',', $columnsFooter),',');
        }
        if ($GroupRowsColumn) {
            $GroupRowsColumn = implode(',', $GroupRowsColumn);
        }
        if ($HideColumn) {
            $HideColumn = implode(',', $HideColumn);
        }
        if ($PredefineSort) {
            $PredefineSort = implode(',', $PredefineSort);
        }
        if ($ExcludeZeroCol) {
            $ExcludeZeroCol = implode(',', $ExcludeZeroCol);
        }
        if ($ColumnsMatching) {
            $ColumnsMatching = implode(',', $ColumnsMatching);
        }

        if ($ColumnstoBeMatched) {
            $ColumnstoBeMatched = implode(',', $ColumnstoBeMatched);
        }
        if ($ColumnNameColor) {
            $ColumnNameColor = implode(',', $ColumnNameColor);
        }


        $saveData['Columns'] = $columns;
        $saveData['DataSourceId'] = $dataSourceId;
        $saveData['GroupRowsColumn'] =$GroupRowsColumn;
        $saveData['ColumnsFooter'] = $columnsFooter;
        $saveData['HideColumn'] = $HideColumn;
        $saveData['PredefineSort'] = $PredefineSort;
        $saveData['ExcludeZeroCol'] = $ExcludeZeroCol;
        $saveData['ColumnsMatching'] = $ColumnsMatching;
        $saveData['ColumnstoBeMatched'] = $ColumnstoBeMatched;
        $saveData['ColumnNameColor'] = $ColumnNameColor;
        $saveData['EnableLastSearchDF'] = $EnableLastSearchDF;

        //FooterColumnsProperties
        if( isset($saveData['AllowColumnRowMarking']) && $saveData['AllowColumnRowMarking'] == 1)
        {
            $dataArr = [];
            foreach($_REQUEST['Columns'] as $colKey => $colVal){
            // $total = isset($saveData[$colVal.'_totalNum'])?$saveData[$colVal.'_totalNum']:0;
            $keys  = array_keys($saveData);
            $keyTemp = [];
            foreach($keys as $saveKey => $saveValue){
                    if(strpos($saveValue ,  $colVal.'_FirstParameter_') !== false){
                        $ids = explode( $colVal.'_FirstParameter_' , $saveValue);
                        $keyTemp[] = $ids[1];
                    }
                }
                $cnt = 1;
            
                foreach( $keyTemp as $ke => $i)
                {
                
                    $conName = $colVal.'_Condition_'.$i;
                    $colorName = $colVal.'_Colors_'.$i;
                    if(!empty($saveData[$conName]) && !empty($saveData[$colorName]) ){
                    
                        $dataArr[$colVal][$cnt]['FirstParameter'] = $saveData[$colVal.'_FirstParameter_'.$i];
                        $dataArr[$colVal][$cnt]['Condition'] = $saveData[$colVal.'_Condition_'.$i];
                        $dataArr[$colVal][$cnt]['SecondParameter'] = $saveData[$colVal.'_SecondParameter_'.$i];
                        $dataArr[$colVal][$cnt]['TextColors'] = $saveData[$colVal.'_Colors_'.$i];
                    
                    
                    }
                    $cnt = $cnt +1;
                }
                
            }

            $dataArr = json_encode($dataArr);
            
            $saveData['ColorTextMatch'] = $dataArr;
        }

        if( isset($saveData['EnableRowGroupLevel']) && $saveData['EnableRowGroupLevel'] == 1){
            $RowGroupLevelColumns = array();
            if(isset($saveData['RowGroupLevelColumns1'])){
                $RowGroupLevelColumns['level1'] = $saveData['RowGroupLevelColumns1'];
                unset($saveData['RowGroupLevelColumns1']);
            }
            if(isset($saveData['RowGroupLevelColumns2'])){
                $RowGroupLevelColumns['level2'] = $saveData['RowGroupLevelColumns2'];
                unset($saveData['RowGroupLevelColumns2']);
            }
            if(isset($saveData['RowGroupLevelColumns3'])){
                $RowGroupLevelColumns['level3'] = $saveData['RowGroupLevelColumns3'];
                unset($saveData['RowGroupLevelColumns3']);
            }
            if(isset($saveData['RowGroupLevelColumns4'])){
                $RowGroupLevelColumns['level4'] = $saveData['RowGroupLevelColumns4'];
                unset($saveData['RowGroupLevelColumns4']);
            }
            $saveData['RowGroupLevelColumns'] = json_encode( $RowGroupLevelColumns);
        }

        TablePlaceholders::addTable($saveData , 'new');
        header('Location: ' . baseUrl . 'placeholders');
     }
 

    // Add table Action
    public function addTableActionsAction()
    {
        $getDataSource = DataSources::getAllDataSource();
        $getAllPages = User::getAllPagesAsList();
        View::render('administrator/placeholder/add_actions_tables.php', ['getDataSource' => $getDataSource, 'getAllPages' => $getAllPages]);
    }
    // Save table Action
    public function saveTableActionsAction()
    {
        $saveData = $_REQUEST; // Get all Posted data 
        // Model functio  call to save data .
        TablePlaceholders::addTableActions($saveData);
        header('Location: ' . baseUrl . 'placeholders');
    }

     // Add Childrow Action
    public function addChildRowAction()
    {
        
        $getDataSourceTables = Placeholder::getDataSourceTableData('Tables' ,'');
        $getDataSource = DataSources::getAllDataSource();
        $getAllPages = User::getAllPagesAsList();
       
        View::render('administrator/placeholder/add_childrow_tables.php', ['getDataSourceTables' => $getDataSourceTables,'getDataSource' => $getDataSource, 'getAllPages' => $getAllPages]);
    }

     // Save table Action
    public function saveChildRowAction()
    {
         $saveData = $_REQUEST; // Get all Posted data 
         // Model functio  call to save data .
         TablePlaceholders::saveTableActions($saveData);
         header('Location: ' . baseUrl . 'placeholders');
    }
    //Add dynamic 
    function addDynamicForm(){
       
        $getDataSource = DataSources::getAllDataSource();
       
        View::render('administrator/placeholder/add_dynamic_form.php', ['getDataSource'=> $getDataSource]);
   
    }
     // Save Dynamic form 
     public function saveDynamicForm()
     {
          $saveData = $_REQUEST; // Get all Posted data 
          // Model function  call to save data .
         
          if($saveData['CallType'] == '2'){
                $temparr = [];
                $i = 1;
              
                foreach($saveData as $key => $value) {
                    if(strpos($key , 'columnName') !== false)
                    {
                        $i = explode('columnName', $key);
                        $i  = $i[1];
                     
                        if(isset($saveData['columnName'.$i])){
                            //$checkout = $checkout +1;
                            if($saveData['columnName'.$i] != ''){
                                $temparr[$saveData['columnName'.$i]]['columnName'] = $saveData['columnName'.$i] ;
                            }
                            if( $saveData['columnType'.$i] != ''){
                                $temparr[$saveData['columnName'.$i]]['columnType'] = $saveData['columnType'.$i] ;
                            }
                            if($saveData['Default'.$i] != ''){
                                $temparr[$saveData['columnName'.$i]]['Default'] = $saveData['Default'.$i] ;
                            }
                            if( $saveData['maxLenght'.$i] != ''){
                                $temparr[$saveData['columnName'.$i]]['maxLenght'] = $saveData['maxLenght'.$i] ;
                            }
                            if($saveData['check'.$i] != ''){
                                $temparr[$saveData['columnName'.$i]]['check'] = $saveData['check'.$i] ;
                            }
                            if($saveData['displayColumnName'.$i] != ''){
                                $temparr[$saveData['columnName'.$i]]['displayColumnName'] = $saveData['displayColumnName'.$i] ;
                            }
                        }
                    }
                $saveData['DetailColumns'] = json_encode($temparr);
              }
            // if(isset($saveData['columnName1'])){
            //     $checkout = 2;
            //     $temparr = [];
            //     for($i = 1 ; $i < $checkout ; $i++){
            //         if(isset($saveData['columnName'.$i])){
            //             $checkout = $checkout +1;
            //             if($saveData['columnName'.$i] != ''){
            //                 $temparr[$saveData['columnName'.$i]]['columnName'] = $saveData['columnName'.$i] ;
            //             }
            //             if( $saveData['columnType'.$i] != ''){
            //                 $temparr[$saveData['columnName'.$i]]['columnType'] = $saveData['columnType'.$i] ;
            //             }
            //             if($saveData['Default'.$i] != ''){
            //                 $temparr[$saveData['columnName'.$i]]['Default'] = $saveData['Default'.$i] ;
            //             }
            //             if( $saveData['maxLenght'.$i] != ''){
            //                 $temparr[$saveData['columnName'.$i]]['maxLenght'] = $saveData['maxLenght'.$i] ;
            //             }
            //             if($saveData['check'.$i] != ''){
            //                 $temparr[$saveData['columnName'.$i]]['check'] = $saveData['check'.$i] ;
            //             }
            //         }else{
            //             $checkout = 0;
            //         } 
            //     }
               
            // }
            
          }
        
          TablePlaceholders::saveDynamicForm($saveData);
          header('Location: ' . baseUrl . 'placeholders');
     }

    // Load the Add Slider 
	public function addSliderTableAction()
    {
        $getAllTable = Placeholder::getAllTableData("Tables");
        $getAllTableActions = Placeholder::getAllTableData("TableActions");
        View::render('administrator/placeholder/add_silder_table.php', ['getAllTable' =>  $getAllTable , 'getAllTableActions' => $getAllTableActions]);
    }
      // Save Data for Tables in DB
      public function saveSliderTable()
      {
          $saveData = $_REQUEST;
          
          $TabAction = (isset($saveData['TabAction'])) ? $saveData['TabAction'] : "";
          $TabAction2 = (isset($saveData['TabAction2'])) ? $saveData['TabAction2'] : "";

          if ($TabAction) {
              $TabAction = implode(',', $TabAction);
          }
          if ($TabAction2) {
              $TabAction2 = implode(',', $TabAction2);
          }

          $saveData['TabAction'] = $TabAction;
          $saveData['TabAction2'] = $TabAction2;

          TablePlaceholders::addSliderTable($saveData);
          header('Location: ' . baseUrl . 'placeholders');
      }
  
    

}