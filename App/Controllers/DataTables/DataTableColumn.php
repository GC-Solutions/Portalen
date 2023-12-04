<?php

namespace App\Controllers\DataTables;

use \Core\View;
use App\Models\Page;
use \App\Models\User;
use \App\Models\Companies;
use App\Models\Placeholder;
use \App\Models\DataTableDesigns;
use App\Controllers\DataFormatHelper\DataTableHelper;
use \App\Models\MongoTable;

/**
 * DataTableColumn controller
 
 This file contain a function for getting the datatbale column data .
 this function gives us all the info about the filter that needs to be applied or format of that colum and every info 
 regarding a column .
 
 */

class DataTableColumn extends \Core\Controller
{
    // GLobal Variable
    public $_arrayList = array('ResultList');
    public $retval = array();
    // Function to get the column Name of datatables and also all the options set for datatables .
    // MOST of the Function that are called in that function are called from DataTablerhelper.php file
    public function getTableColumnsAction()
    {
        $placeholderId = (isset($_REQUEST['placeholderId'])) ? $_REQUEST['placeholderId'] : "";
        
        $id = (isset($_REQUEST['id'])) ? $_REQUEST['id'] : "";
        $Mtype = (isset($_REQUEST['Mtype'])) ? $_REQUEST['Mtype'] : "";
        if($Mtype)
        {
            // Code for geting the datatable name from  mongodb API.
            $columnNames = array();
            $arrFeild = [];
            $arrFeild1 = [];
            $getPlaceholderDetails  = MongoTable::getMongotableByID($placeholderId);
            $feilds = json_decode($getPlaceholderDetails[0]['DetailColumns'] , true);
            $arrFeild[] = 'ProductNo';
            foreach ($feilds  as $key => $value) {
                $arrFeild[] = $key;
                $arrFeild1[] = null;
            }
            if(!in_array('minStockStatus', $arrFeild))
            {
                $arrFeild[]='minStockStatus';
            }
            if(!in_array('maxStockStatus', $arrFeild))
            {
                $arrFeild[]='maxStockStatus';
            }
            if ($arrFeild) {
                $columnNames['columnTitle'] = $arrFeild;
                $columnNames['columnDb'] = $arrFeild;
            }
            $columnNames['ProductInfo'] = !empty($getPlaceholderDetails)?$getPlaceholderDetails:''; 
            $columnNames['predefineSearch'] =  $arrFeild1;
            echo json_encode($columnNames);
            exit;
        }else{
            // Code for geting the datatable name for ALL.
            // get Placeholder detail 
            $getPlaceholderDetails = Page::getDatasourceTableDetails($placeholderId); 
            
           
            $columnNames = array();  
            //(Start) if placeholder is present .
            if ($getPlaceholderDetails) {
                 // For Image we perform extra processing as we separte the coma separated value and create 6 new columns for images .
                $imgCheck = explode(',', $getPlaceholderDetails[0]['tableColumns']);
               
                if(in_array('Images', $imgCheck)){
                    // over her in for Loop can change the 6 to increase the number if column for images .
                    for ($i=1; $i <= 10 ; $i++) { 
                            $imgCheck[] = 'Images'.$i;
                    }
                    $getPlaceholderDetails[0]['tableColumns'] = implode(',',  $imgCheck); 
                }
                // For Image we perform extra processing as we separte the coma separated value and create 6 new columns for images .
                if(isset($getPlaceholderDetails[0]['DisplayColumnNames'])){
                    $imgCheck = explode(',', $getPlaceholderDetails[0]['DisplayColumnNames']);
                    $im = [];
                    if(in_array('Images', $imgCheck)){
                        // over her in for Loop can change the 6 to increase the number if column for images .
                        for ($i=1; $i <= 10 ; $i++) { 
                                $imgCheck[] = 'Images'.$i;
                                $im[] = 'Images'.$i;
                        }
                        if($getPlaceholderDetails[0]['ApiType'] != '2'){
                             $getPlaceholderDetails[0]['DisplayColumnNames'] = implode(',',  $imgCheck); 
                       
                            $getPlaceholderDetails[0]['tableColumns'] = $getPlaceholderDetails[0]['tableColumns']. ','. implode(',',  $im); 
                        }
                    }
                }
               
                // (Start) if API type is Multiple Node .
                if($getPlaceholderDetails[0]['ApiType'] == '2'){
                    // For Image we perform extra processing as we separte the coma separated value and create 6 new columns for images .
               
                    $imgCheck = explode(',', $getPlaceholderDetails[0]['DisplayColumnNames']);
                    if(in_array('Images', $imgCheck)){
                        // over her in for Loop can change the 6 to increase the number if column for images .
                        for ($i=1; $i <= 10 ; $i++) { 
                                $imgCheck[] = 'Images'.$i;
                        }
                        $getPlaceholderDetails[0]['DisplayColumnNames'] = implode(',',  $imgCheck); 
                    }
                    // Over here for multiple node the Name of column Might have hypen (-) in it so will perform the check .
                    $imgCheck = explode(',', $getPlaceholderDetails[0]['tableColumns']);
                    foreach($imgCheck as $imgCheckK => $imgCheckV ){
                    	if(strpos($imgCheckV , 'Images'))
                    	{
                    		$nam = explode('-', $imgCheckV);
                    		for ($i=1; $i <= 10 ; $i++) { 
                                $imgCheck[] = $nam[0].'Images'.$i;
                        }
                        $getPlaceholderDetails[0]['tableColumns'] = implode(',',  $imgCheck); 
                    	}
                    }
                }
                // (End) if API type is Multiple Node .
                // Get and set the Table Column Name and Display column Name .
                $columnsList = (isset($getPlaceholderDetails[0]['DisplayColumnNames'])) ? $getPlaceholderDetails[0]['DisplayColumnNames'] : "";
                $columnsListDb = (isset($getPlaceholderDetails[0]['tableColumns'])) ? $getPlaceholderDetails[0]['tableColumns'] : "";
                // Trim the Column Names 
                $columnsList = trim($columnsList);
                $columnsListDb = trim($columnsListDb);

                if (empty($columnsList)) {
                    $columnsList = (isset($getPlaceholderDetails[0]['tableColumns'])) ? $getPlaceholderDetails[0]['tableColumns'] : "";
                }
                $sumColumnLabel = (isset($getPlaceholderDetails[0]['SumColumnLable'])) ? $getPlaceholderDetails[0]['SumColumnLable'] : "";
                // (Start ) explode the column name and create an Array 
               
                if ($columnsList) {
                    $getColumnsList['columnTitle'] = explode(',', $columnsList);
                }
                if ($columnsListDb) {
                    $columnNames['columnDb'] = explode(',', $columnsListDb);
                }
                     $newExplodeColumnsOrder =  [];
                // (End) explode the column name and create an Array 
                //(Start) Processing for column Name and column Alignment 
                if (isset($getColumnsList['columnTitle'])) {
                    foreach ($getColumnsList['columnTitle'] as $eachColumName) {
                        $columnNames['columnTitle'][] = trim($eachColumName);
                    }
                    $sumColumnLabel = trim($sumColumnLabel);
                    if (!empty($sumColumnLabel)) {
                        if (!in_array($sumColumnLabel, $columnNames)) {
                            $columnT = explode(',',$sumColumnLabel);

                            foreach ($columnT as $key => $value) {
                              $columnNames['columnTitle'][] = trim($value);
                              $columnNames['columnDb'][] = trim($value);
                            }
                            
                        }
                        
        
                       
                    }
                   
                    $NewClumnSort = !empty($getPlaceholderDetails[0]['ColumnSort'])?$getPlaceholderDetails[0]['ColumnSort']:'';
                    if($getPlaceholderDetails[0]['EnableAllUpdates'] == 1 ) {
                        $NewClumnSort =  'select,'. $NewClumnSort;
                    }
                    $newExplodeColumnsNamesF =  []; 
                    $newExplodeColumnsNames =  [];
              
                   
                     if(trim($NewClumnSort) != ''){
                        $NewClumnSort = explode(',' , $NewClumnSort );
             $rowConter = 0;
                        foreach ($NewClumnSort as $NewClumnSortKey => $NewClumnSortVal) {
							 $rowConter2 = 0;
                            foreach ($columnNames['columnTitle'] as $key => $value) {
                                if($columnNames['columnTitle'][$key] ==  trim($NewClumnSortVal)  || $columnNames['columnDb'][$key] ==  trim($NewClumnSortVal) )
                                {
                                   
                                    $newExplodeColumnsNames[] =  $columnNames['columnTitle'][$key] ;
                                    $newExplodeColumnsNamesF[] =  $columnNames['columnDb'][$key] ;
                                     $newExplodeColumnsOrder[$rowConter] = $key;
								
                                    break;
                                } 
									$rowConter2++;
                            }
							  $rowConter++;
                        }
                        $columnNames['columnTitle'] = $newExplodeColumnsNames;
                        $columnNames['columnDb'] = $newExplodeColumnsNamesF;
						 	  
                        //$columnNames['columnOrderName'] = $columnNames['columnTitle'];
                    }
                   
                    
                    $getColumnsProperties = $getPlaceholderDetails[0]['ColumnsProperties'];
                    if (isset($getColumnsProperties)) {
                        $columnNames['columnAlignment'] = array();
                        $columnNames['columnAlignment'] = DataTableHelper::columnAlignment($getColumnsProperties,$columnNames['columnDb'],$columnNames['columnDb']);
                    }
                }
                 //(End) Processing for column Name and column Alignment 
                $newExplodeColumns = array();
                // (Start) processing if column Sort is selected at table placeholder 

        $csValue = !empty($getPlaceholderDetails[0]['ColumnSort'])?$getPlaceholderDetails[0]['ColumnSort']:'';
			
                $csValue = json_decode($csValue);
					//$csValue = explode(',', $csValue);
                //$NewClumnSort = !empty($getPlaceholderDetails[0]['ColumnSort'])?$getPlaceholderDetails[0]['ColumnSort']:'';
                $newExplodeColumnsNamesF =  []; 
				 
				 
                if($csValue){ // In case of Json 
                                       foreach ($columnNames['columnTitle'] as $key => $value) {
                            foreach ($csValue as $csK => $csVal) {
                                if($value == $csVal->label)
                                {
                                    $newExplodeColumns[] = ($csVal->columnOrder-1) ;
                                    break;
                                }
                            }
                    }
                }
                else
                {
                    foreach ($columnNames['columnTitle'] as $key => $value) {
                              $newExplodeColumns[] = $key ;
                    }
                }
				             
                // (End) processing if column Sort is selected at table placeholder
              
                $columnNames['columnOrder'] =  $newExplodeColumns; 
				//$columnNames['columnOrder'] =  $newExplodeColumnsOrder;
                // Footer column properties 
                $getColumnsPropertiesFooter = trim($getPlaceholderDetails[0]['FooterColumnsProperties']);
                if (!empty($getColumnsPropertiesFooter)) {
                    $columnNames['footerColumn'] = array();
                   
                    $columnNames['footerColumn'] = DataTableHelper::footerColumnVisibility($getColumnsPropertiesFooter,$columnNames['columnDb']);
               
                }
                // for Denomination Text
                $AdditionalColumnProperties = trim($getPlaceholderDetails[0]['AdditionalColumnProperties']);
                if (!empty($AdditionalColumnProperties)) {
                    $columnNames['AdditionalColumnProperties'] = array();
                    $columnNames['AdditionalColumnProperties'] = DataTableHelper::AdditionalColumnProperties($AdditionalColumnProperties,$columnNames['columnDb']);
                }
                // setting the Chart column properties that will be use by custom Table.js 
                $getChartColumn = trim($getPlaceholderDetails[0]['ChartColumn']);
                if (!empty($getChartColumn)) {
                    $columnNames['chartColumns'] = array();
                    $columnNames['chartColumns'] = DataTableHelper::chartColumnProperties($getChartColumn,$columnNames['columnDb']);
                    if($getPlaceholderDetails[0]['DisplayColumnNames']){
                        foreach($columnNames['chartColumns'] as $chartKey => $chartVal) {
                            
                            $columnNames['chartColumns'][$chartKey]['label'] = $columnNames['columnTitle'][$chartKey];
                        }
                    }
        
                }
                // setting the Map column properties that will be used by custom Table.js 
                $getMapColumn = trim($getPlaceholderDetails[0]['MapColumn']);
                if (!empty($getMapColumn)) {
                    $columnNames['mapColumn'] = array();
                    $columnNames['mapColumn'] = DataTableHelper::mapColumnProperties($getMapColumn,$columnNames['columnDb']);
                }
                // (Start)setting the Pie Chart column properties that will be used by custom Table.js 
                $getPieChartColumn = trim($getPlaceholderDetails[0]['PieChartColumn']);
                $newSumArr =  array();
                if (!empty($getPieChartColumn)) {
                    $sumColumnLabel = isset($sumColumnLabel) ? explode(',', $sumColumnLabel) : '';
                    $columnNames['PieChartColumn'] = array();
                   
                    $newArr = array();

                    $tempVal = json_decode($getPieChartColumn, true); 
                   
                    if(isset($tempVal['PieChartType']) && array_key_exists("PieChartType", $tempVal))
                    {
                        $newArr['PieChartType'] = $tempVal['PieChartType'];
                    }else{
                         $tmp['type'] = 1;
                         $newArr['PieChartType'] =  $tmp;
                    }
                   
                    if(isset($tempVal['PieChartLabel']) &&  array_key_exists("PieChartLabel", $tempVal))
                    {
                        $newArr['PieChartLabel'] = $tempVal['PieChartLabel'];
                    }
                    if(isset($tempVal['CalculationType']) &&  array_key_exists("CalculationType", $tempVal))
                    {
                        $newArr['CalculationType'] = $tempVal['CalculationType'];
                    }
                    $columnNames['PieChartColumn'] = DataTableHelper::PieChartColumnProperties($getPieChartColumn,$columnNames['columnDb'], $sumColumnLabel, $newArr) ;  
               
                }
                // (End)setting the Pie Chart column properties that will be used by custom Table.js 
                // Setting Multiple Select option if selected at placeholder .
                $getFilterColumn = explode(',' , trim($getPlaceholderDetails[0]['AllowMultipleSelectionColumn']));
                if (!empty($getFilterColumn)) {
                    $columnNames['AllowMultipleSelectionColumn'] = array();
                    $columnNames['AllowMultipleSelectionColumn'] = DataTableHelper::filterColumnProperties($getFilterColumn,$columnNames['columnTitle']);
                }
                // Allow multiple select by default flag setting .
                $columnNames['multipleSearchSelectorFlag'] =  !empty($getPlaceholderDetails[0]['multipleSerachSelectorFlag']?trim($getPlaceholderDetails[0]['multipleSerachSelectorFlag']):0);
                // Allow row Group 
                $columnNames['GroupRowsFlag'] =!empty($getPlaceholderDetails[0]['GroupRowsFlag'])?trim($getPlaceholderDetails[0]['GroupRowsFlag']):0;
                // Setting the properties and column on which row group will be applied .
                $getRowGroupColumn = explode(',' , trim($getPlaceholderDetails[0]['GroupRowsColumn']));
                if(!empty($getRowGroupColumn)){
                    $columnNames['GroupRowsColumn'] = array();
        
                    $columnNames['GroupRowsColumn'] = DataTableHelper::rowGroupColumnProperties($getRowGroupColumn,$columnNames['columnTitle'] , $columnNames['columnDb'] );
                    
                }
                // Allow Predefined Search and on which column 
                $getPredefineSearchColumn = trim($getPlaceholderDetails[0]['PredefineSearch']);
                if(!empty($getPredefineSearchColumn)){
                    $columnNames['PredefineSearch'] = array();
                   $columnNames['PredefineSearch'] = DataTableHelper::predefineSearchProperties($getPredefineSearchColumn,$columnNames['columnDb']);
                }
                if(isset( $_SESSION['NotiCheck'])){

                    $columnNames['PredefineSearch'] = array();
                    $notiId = $_SESSION['NotiCheck'] ;
                    $notiData =  Page::getSpecficNotiLogs($notiId);
                    
                    $notiCon = json_decode($notiData[0]['Conditions'] , true);
                    $notiConKey =  array_keys($notiCon);
                    $preSearch = array();
					$LogDate = '';
					if(isset($_SESSION['NotiCheck']) && isset($_SESSION['NotificationlogDate'])){
						$LogDate = $_SESSION['NotificationlogDate'];
					}else {
						$LogDate = $_SESSION['UserLastLogoutDate'];
					}
                    foreach( $notiConKey as $nK => $nV){
                        $notiTemp = array() ;
                       
                        foreach( $notiCon[$nV] as $nCK => $nCV){
                            if(strpos( $nCV['SecondParameter'] , '(LogoutDate)' ) !== false){
                                $nCV['SecondParameter'] = str_replace('(LogoutDate)' , $LogDate , $nCV['SecondParameter'] );
                                

                            }else if(strpos($nCV['SecondParameter'] , '(LogoutTime)' ) !== false){
                               
                                $nCV['SecondParameter'] = str_replace('(LogoutTime)' , $_SESSION['UserLastLogoutTime'] , $nCV['SecondParameter'] );
								

                            }

                            $notiTemp['sSearch'] = $nCV['SecondParameter'] ;
                            $notiTemp['bRegex'] = true;
                           
                        }
   						
                        $preSearch[$nV]  = $notiTemp;
                        
                    }
					if(isset($preSearch['LogTime'])){
						unset($preSearch['LogTime']);
					}
					
                    $getPredefineSearchColumn = json_encode($preSearch);
					
                    $getPredefineSearchColumn =  str_replace('(NowDate)' ,Date('Y-m-d') ,$getPredefineSearchColumn );
                    $columnNames['PredefineSearch'] = DataTableHelper::predefineSearchProperties($getPredefineSearchColumn,$columnNames['columnDb']);
                
                }

                 // Allow Predefined Search on Range Filter  and on which column 
                $getPredefineSearchforRangeFlag = !empty(trim($getPlaceholderDetails[0]['RangePredefineSearchFlag']))?trim($getPlaceholderDetails[0]['RangePredefineSearchFlag']): 0 ;
                $columnNames['RangePredefineSearchFlag'] = $getPredefineSearchforRangeFlag;
                if($getPredefineSearchforRangeFlag){
                    $getPredefineSearchforRange = !empty(trim($getPlaceholderDetails[0]['PredefineSearchForRange']))?trim($getPlaceholderDetails[0]['PredefineSearchForRange']): '1' ;
                    if(!empty($getPredefineSearchforRange)){
                        $columnNames['PredefineSearchForRange'] = array();
                        $columnNames['PredefineSearchForRange'] = DataTableHelper::PredefineSearchforRangeProperties($getPredefineSearchforRange,$columnNames['columnTitle']);
                    }
                }
                // Hide column 
                $getHideColumn = !empty(trim($getPlaceholderDetails[0]['HideColumn']))?explode(',' , trim($getPlaceholderDetails[0]['HideColumn'])): '' ;
                if(!empty($getHideColumn)){
                    $columnNames['HideColumn'] = array();
                    $getHideColumn = array_keys(array_intersect($columnNames['columnTitle'],array_values($getHideColumn)));
                    $columnNames['HideColumn'] = $getHideColumn;

                }
                // predefined Sort 
                $getPredefineSort = !empty(trim($getPlaceholderDetails[0]['PredefineSort']))?array(trim($getPlaceholderDetails[0]['PredefineSort'])): '' ;
                if(!empty($getPredefineSort)){
                    $columnNames['PredefineSort'] = array();
                    $getPredefineSort = array_keys(array_intersect($columnNames['columnDb'],array_values($getPredefineSort)));
                    $columnNames['PredefineSort'] = $getPredefineSort[0];

                }
                // Exclude Zero from excel File on export .
                $getExcludeZeroCol = !empty(trim($getPlaceholderDetails[0]['ExcludeZeroCol']))?(trim($getPlaceholderDetails[0]['ExcludeZeroCol'])): '' ;
                if(!empty($getExcludeZeroCol)){
                    $columnNames['ExcludeZeroCol'] = array();
                    $getExcludeZeroCol =  explode(',', $getExcludeZeroCol);
                    $columnNames['ExcludeZeroCol'] = $getExcludeZeroCol;

                }
                // setting the width of filter 
               
                if(!empty($getPlaceholderDetails[0]['EnableFilterWidth']))
                {
                    

                    $filterWidth = DataTableDesigns::getAllFilter();
                    $columnNames['MinFilterWidth'] = $filterWidth[0]['FilterWidth'];
                    $columnNames['MaxFilterWidth'] = $filterWidth[0]['MaxFIlterWidth'];
                   
                }
                 // setting the width of filter Multiple
                if(!empty($getPlaceholderDetails[0]['AllowSearchAfter3Char']))
                {  
                    $ColSearchAfter3Char = DataTableHelper::AdditionalColumnPropertiesNew($getPlaceholderDetails[0]['ColSearchAfter3Char'],$columnNames['columnDb'] ,$columnNames['columnTitle'] );
                    
                    $columnNames['ColSearchAfter3Char'] =  $ColSearchAfter3Char;
                    $columnNames['AllowSearchAfter3Char'] =!empty($getPlaceholderDetails[0]['AllowSearchAfter3Char'])?trim($getPlaceholderDetails[0]['AllowSearchAfter3Char']):0;;
                   
                }
               
                if(!empty($getPlaceholderDetails[0]['EnableFilterWidth1']))
                {  
                    $CustomColumnWidth = DataTableHelper::AdditionalColumnProperties($getPlaceholderDetails[0]['CustomColumnWidth'],$columnNames['columnDb']);
                    
                    $columnNames['CustomColumnWidth'] =  $CustomColumnWidth;
                    $columnNames['EnableFilterWidth1'] =!empty($getPlaceholderDetails[0]['EnableFilterWidth1'])?trim($getPlaceholderDetails[0]['EnableFilterWidth1']):0;;
                   
                }
   
                // Flag Setting 
                $columnNames['searchFlag'] =   trim($getPlaceholderDetails[0]['SearchFlag']);
                $columnNames['scrollFlag'] =   trim($getPlaceholderDetails[0]['ScrollFlag']);
                $columnNames['RowsCount'] =   trim($getPlaceholderDetails[0]['RowsCount']);
                $columnNames['EnableCrud'] =  trim($getPlaceholderDetails[0]['EnableCrudCSV']);
                $columnNames['TableDesign'] =  trim($getPlaceholderDetails[0]['TableDesign']);
                $columnNames['ScrollWidth'] =  trim($getPlaceholderDetails[0]['ScrollWidth']);
                $columnNames['FooterSumLocation'] =  trim($getPlaceholderDetails[0]['FooterSumLocation']);
                $columnNames['PaginationFlag'] =   !empty($getPlaceholderDetails[0]['PaginationFlag'])?trim($getPlaceholderDetails[0]['PaginationFlag']):0;
                $columnNames['EnableChildRows'] =   !empty($getPlaceholderDetails[0]['EnableChildRows'])?trim($getPlaceholderDetails[0]['EnableChildRows']):0;
                $columnNames['FilterSessionEnable'] =   !empty($getPlaceholderDetails[0]['FilterSessionEnable'])?trim($getPlaceholderDetails[0]['FilterSessionEnable']):0;
                $columnNames['EnableChildRowsRunTym'] =   !empty($getPlaceholderDetails[0]['EnableChildRowsRunTym'])?trim($getPlaceholderDetails[0]['EnableChildRowsRunTym']):0;
                $columnNames['EnableLiveImgSync'] =   !empty($getPlaceholderDetails[0]['EnableLiveImgSync'])?trim($getPlaceholderDetails[0]['EnableLiveImgSync']):0;
                $columnNames['EnableExcelBtn'] =   !empty($getPlaceholderDetails[0]['EnableExcelBtn'])?trim($getPlaceholderDetails[0]['EnableExcelBtn']):0;
                $columnNames['XMLdownload'] =   !empty($getPlaceholderDetails[0]['XMLdownload'])?trim($getPlaceholderDetails[0]['XMLdownload']):0;
                $columnNames['TableType'] =   !empty($getPlaceholderDetails[0]['TableType'])?trim($getPlaceholderDetails[0]['TableType']):1;
                $columnNames['LiveReportSync'] =   !empty($getPlaceholderDetails[0]['LiveReportSync'])?trim($getPlaceholderDetails[0]['LiveReportSync']):0;
                $columnNames['AllowDynamicForm'] =   !empty($getPlaceholderDetails[0]['AllowDynamicForm'])?trim($getPlaceholderDetails[0]['AllowDynamicForm']):0;
                $columnNames['EnableFormOnActionBTN'] =   !empty($getPlaceholderDetails[0]['EnableFormOnActionBTN'])?trim($getPlaceholderDetails[0]['EnableFormOnActionBTN']):0;
                $columnNames['AllowColumnRowMarking'] =   !empty($getPlaceholderDetails[0]['AllowColumnRowMarking'])?trim($getPlaceholderDetails[0]['AllowColumnRowMarking']):0;
                $columnNames['EnableSideBar'] =   !empty($getPlaceholderDetails[0]['EnableSideBar'])?trim($getPlaceholderDetails[0]['EnableSideBar']):0;
                $columnNames['EnableOnclickBtn'] =   !empty($getPlaceholderDetails[0]['EnableOnclickBtn'])?trim($getPlaceholderDetails[0]['EnableOnclickBtn']):0;
                $columnNames['AllowDataGrouping'] =   !empty($getPlaceholderDetails[0]['AllowDataGrouping'])?trim($getPlaceholderDetails[0]['AllowDataGrouping']):0;
                $columnNames['EnableCheckBoxes'] =   !empty($getPlaceholderDetails[0]['EnableCheckBoxes'])?trim($getPlaceholderDetails[0]['EnableCheckBoxes']):0;
                $columnNames['SaveFilterBTN'] =   isset($_SESSION['SaveFilterBTN'])?trim($_SESSION['SaveFilterBTN']):0;
                $columnNames['PredefinedUpdateRedisTab'] =   isset($getPlaceholderDetails[0]['PredefinedUpdateRedisTab'])?trim($getPlaceholderDetails[0]['PredefinedUpdateRedisTab']):0;
                $columnNames['AllowPDFImport'] =   isset($getPlaceholderDetails[0]['AllowPDFImport'])?trim($getPlaceholderDetails[0]['AllowPDFImport']):0;
                $columnNames['AllowExcelImport'] =   isset($getPlaceholderDetails[0]['AllowExcelImport'])?trim($getPlaceholderDetails[0]['AllowExcelImport']):0;
				$columnNames['NotiColumnMarking'] =   isset($getPlaceholderDetails[0]['NotiColumnMarking'])?trim($getPlaceholderDetails[0]['NotiColumnMarking']):0;
				$columnNames['AllowEnterSearch'] =   isset($getPlaceholderDetails[0]['AllowEnterSearch'])?trim($getPlaceholderDetails[0]['AllowEnterSearch']):0;
				
                if($getPlaceholderDetails[0]['AllowDataGrouping']){
                    $columnNames['DataGroupingJson'] = !empty($getPlaceholderDetails[0]['DataGroupingJson'])?json_decode($getPlaceholderDetails[0]['DataGroupingJson'], true):[];
                }
                if($getPlaceholderDetails[0]['TableType'] == '4' || $getPlaceholderDetails[0]['TableType'] == '5'){
                    
                    if($getPlaceholderDetails[0]['TableType'] == '4' ){
                        $getSilders = Page::getSlidertableD1($placeholderId ,$id , $_SESSION['UserID']);
                    }else if ($getPlaceholderDetails[0]['TableType'] == '5' ){
                        $getSilders = Page::getSlidertableD2($placeholderId ,$id , $_SESSION['UserID']);
                    }
                   
                  
                    if($getSilders){
                        $columnNames['EnableSideBar'] = 1;
                        
                        if($getPlaceholderDetails[0]['TableType'] == '5' ){
                            $getDataUrl = baseUrl . 'generateTable?id=' . $getPlaceholderDetails[0]['ID'] . '&placeholderId=' . $getSilders[0]['TableSideBar'];
                        
                        }else{
                            $getDataUrl = baseUrl . 'generateTable?id=' . $getPlaceholderDetails[0]['ID'] . '&placeholderId=' . $getSilders[0]['TableSideBar'].'&'.$getPlaceholderDetails[0]['Placeholder'].'=';
                        }
                       // print_r( $getDataUrl); exit;

                        //$getDataUrl = baseUrl . 'generateTable?id=' . $getPlaceholderDetails[0]['ID'] . '&placeholderId=' . $getSilders[0]['TableSideBar'].'&'.$getPlaceholderDetails[0]['KeyColumn'].'=';
                        $columnNames['TableSideBar'] =   !empty($getSilders[0]['TableSideBar'])?trim($getDataUrl):'';
                        $RouteNameText = array($getPlaceholderDetails[0]['Placeholder']);
                        $RouteIndex = array();
                        $RouteIndex =   array_keys(array_intersect($columnNames['columnTitle'],array_values($RouteNameText)));
    
                        $columnNames['RouteColumnIndex'] = $RouteIndex[0];
                        $columnNames['TabAction'] = !empty($getSilders[0]['TabAction'])?trim($getSilders[0]['TabAction']):'';
                        if($getPlaceholderDetails[0]['TableType'] == '4' ){
                            $getDataUrl = baseUrl . 'generateTable?id=' . $getPlaceholderDetails[0]['ID'] . '&placeholderId=' . $getSilders[0]['TableSideBar2'].'&'.$getPlaceholderDetails[0]['Placeholder'].'=';
                            $columnNames['TableSideBar2'] =   !empty($getSilders[0]['TableSideBar2'])?trim($getDataUrl):'';
                            $RouteNameText = array($getPlaceholderDetails[0]['Placeholder']);
                            $RouteIndex = array();
                            $RouteIndex =   array_keys(array_intersect($columnNames['columnTitle'],array_values($RouteNameText)));
                            $columnNames['RouteColumnIndex2'] = $RouteIndex[0];
                            $columnNames['TabAction2'] = !empty($getSilders[0]['TabAction2'])?trim($getSilders[0]['TabAction2']):'';
                            //$columnNames['SilderDesign'] = !empty($getPlaceholderDetails[0]['SilderDesign'])?trim($getPlaceholderDetails[0]['SilderDesign']):0;
                        
                        }
                       
    
                    }   
                }
                if($getPlaceholderDetails[0]['EnableAllUpdates'] == 1 ) {
                    $columnNames['SelectPredefinedNames'] =   !empty($getPlaceholderDetails[0]['SelectPredefinedNames'])?trim($getPlaceholderDetails[0]['SelectPredefinedNames']):'';
                
                    $getTableActionDetails = Page::getTableActionDetails($id);
    
                    $tableActionDetails = array();
                    //(Start) processing for Action Button 
                    if ($getTableActionDetails ) {
                        
                        $getTableActionIds = (isset($getTableActionDetails[0]['PlaceholderActionIds'])) ? $getTableActionDetails[0]['PlaceholderActionIds'] : "";
                    
                        if ($getTableActionIds) {
                            $tableActionDetails = Page::getTableActionDetailsByIdIN($getTableActionIds);
                            
                        }
                    }
                   
                    //(End) processing for Action Button 
                    if( $tableActionDetails){
                        foreach( $tableActionDetails as $newKey => $newVal){
                           
                            if($newVal['PredefinedUpdate'] == 1 ){

                                foreach ($columnNames['columnTitle'] as $colKey => $colVal) {
                                    if(trim($colVal) == trim($newVal['TableParameterColumn']) || trim($columnNames['columnDb'][$colKey]) == trim($newVal['TableParameterColumn']) ){
                                        $columnNames['PredefinedUpdateId'] = $colKey;
                                        $columnNames['PredefinedUpdateName'] =  $newVal['TableParameterColumn'] ;
                                        $columnNames['EnableAllUpdates'] = 1;
                                        break ;
                                    }
                                }
    
                                
                                break ; 
                            }
                        }
                        
                    }
                        
                    
    
                }

                
                //$columnNames[''] =   !empty($getPlaceholderDetails[0]['AllowColumnRowMarking'])?trim($getPlaceholderDetails[0]['AllowColumnRowMarking']):0;
               
                if(($getPlaceholderDetails[0]['NotiColumnMarking'] == 1 )){
					
                    if(isset($_SESSION['NotiCheck'])){
                           
                    $columnNames['ColoringType'] =   !empty($getPlaceholderDetails[0]['ColoringType'])?trim($getPlaceholderDetails[0]['ColoringType']):'1';
                    $ColoringJsonText = trim($getPlaceholderDetails[0]['ColoringJsonText']);
                    if (!empty($ColoringJsonText)) {
                        $columnNames['ColoringJsonText'] = array();
                        $columnNames['ColoringJsonText'] = DataTableHelper::chartColumnProperties($ColoringJsonText,$columnNames['columnTitle']);
                    }
						
                    //if($getPlaceholderDetails[0]['ColumnNameColor']){
                        
                        $newCOlarr = [];
						$columnNames['ColumnNameColor'] = array();
                        if($getPlaceholderDetails[0]['ColorTextMatch']){
                           
                            $getPlaceholderDetails[0]['ColorTextMatch'] = DataTableHelper::chartColumnProperties($getPlaceholderDetails[0]['ColorTextMatch'],$columnNames['columnDb']);
                            $newCOlarr = $getPlaceholderDetails[0]['ColorTextMatch'];
                            $getPlaceholderDetails[0]['ColorTextMatchKey'] =  array();
                            $getKey = array_keys($getPlaceholderDetails[0]['ColorTextMatch']);
                            
                            
                                foreach( $getKey as $k => $v){
                                   
                                    if($columnNames['ColumnNameColor']){
                                        $columnNames['ColorTextMatchKey'][$v] = $columnNames['ColumnNameColor'][$k];
                                    }else{
                                        $columnNames['ColorTextMatchKey'][$v] = $v;
                                    }
                                }
                                
                        }else{
                            $ColumnNameColor = array(trim($getPlaceholderDetails[0]['ColumnNameColor']));
							$newArrTitle = array();
							$newArrTitle = $columnNames['columnTitle'];

							if(isset($columnNames['HideColumn'])){

								$newArrTitle = $columnNames['columnTitle'];

								$arrKeys = array_keys( $columnNames['columnTitle']);
								foreach($columnNames['HideColumn'] as $hideKey => $hideCol){
										if(in_array($hideCol ,  $arrKeys)){
												unset($newArrTitle[$hideCol]);
										}
								}
							}
							$newArrTitle = array_values($newArrTitle);

							$columnNames['ColumnNameColor'] = array();
							$columnNames['ColumnNameColor'] =array_keys(array_intersect($newArrTitle,array_values($ColumnNameColor)));

                            foreach($columnNames['ColumnNameColor'] as $colKey=> $colVal){
                                if(strpos( $getPlaceholderDetails[0]['SecondParameter'], '(LogoutDate)' ) !== false){
                                    $getPlaceholderDetails[0]['SecondParameter'] = str_replace('(LogoutDate)' , $_SESSION['UserLastLogoutDate'] , $getPlaceholderDetails[0]['SecondParameter'] );
                                    
    
                                }else if(strpos($getPlaceholderDetails[0]['SecondParameter'] , '(LogoutTime)' ) !== false){
                                   
                                    $getPlaceholderDetails[0]['SecondParameter'] = str_replace('(LogoutTime)' , $_SESSION['UserLastLogoutTime'] , $getPlaceholderDetails[0]['SecondParameter'] );
    
                                }
                                $newCOlarr[$colVal]['Condition'] = $getPlaceholderDetails[0]['Condition'];
                                $newCOlarr[$colVal]['SecondParameter'] = $getPlaceholderDetails[0]['SecondParameter'];
                                $newCOlarr[$colVal]['TextColors'] = $getPlaceholderDetails[0]['Colors'];
                               
                            }
                        }
                        
                        foreach($newCOlarr as $colKey=> $colVal){
                           foreach ($colVal as $k => $v) {
                                if( strpos($v['SecondParameter'], '(LogoutDate)' ) !== false){
                                    $newCOlarr[$colKey][$k]['SecondParameter'] = str_replace('(LogoutDate)' , $_SESSION['UserLastLogoutDate'] , $newCOlarr[$colKey][$k]['SecondParameter'] );
                                   
                                }else if(strpos($v['SecondParameter'], '(LogoutTime)' ) !== false){
                                   
                                    //$newCOlarr[$colKey][$k]['SecondParameter'] = str_replace('(LogoutTime)' , $_SESSION['UserLastLogoutTime'] , $v['SecondParameter'] );
    
                                }
                           }
                            
                        }
                        
                        unset($columnNames['ColumnNameColor']);
                        $columnNames['ColumnNameColor'] = $newCOlarr;
                        
                        $columnNames['ColorSettingType'] =   !empty($getPlaceholderDetails[0]['ColorSettingType'])?trim($getPlaceholderDetails[0]['ColorSettingType']):'';
                    
                         
                     //}   
                    }
                    
                }
                else if($columnNames['AllowColumnRowMarking'] == 1)
                {
                    
                    $columnNames['ColoringType'] =   !empty($getPlaceholderDetails[0]['ColoringType'])?trim($getPlaceholderDetails[0]['ColoringType']):'1';
                    $ColoringJsonText = trim($getPlaceholderDetails[0]['ColoringJsonText']);
                    if (!empty($ColoringJsonText)) {
                        $columnNames['ColoringJsonText'] = array();
                        $columnNames['ColoringJsonText'] = DataTableHelper::chartColumnProperties($ColoringJsonText,$columnNames['columnTitle']);
                    }
                    if($getPlaceholderDetails[0]['ColumnNameColor']){
                        $ColumnNameColor = array(trim($getPlaceholderDetails[0]['ColumnNameColor']));
                        $newArrTitle = array();
                        if($columnsList)
                        {
                            $newArrTitle = $columnNames['columnDb'];
                        }else{
                            $newArrTitle = $columnNames['columnTitle'];
                        }
                       
                        if(isset($columnNames['HideColumn'])){
                            if($columnsList)
                            {
                                $newArrTitle = $columnNames['columnDb'];
                            }else{
                                $newArrTitle = $columnNames['columnTitle'];
                            }
                            $arrKeys = array_keys( $columnNames['columnTitle']);
                            foreach($columnNames['HideColumn'] as $hideKey => $hideCol){
                                    if(in_array($hideCol ,  $arrKeys)){
                                            unset($newArrTitle[$hideCol]);
                                    }
                            }
                        }
                        $newArrTitle = array_values($newArrTitle);
                       
                        $columnNames['ColumnNameColor'] = array();
                        $columnNames['ColumnNameColor'] =array_keys(array_intersect($newArrTitle,array_values($ColumnNameColor)));
                        
                        $newCOlarr = [];
                        if($getPlaceholderDetails[0]['ColorTextMatch']){
                            $getPlaceholderDetails[0]['ColorTextMatch'] = DataTableHelper::chartColumnProperties($getPlaceholderDetails[0]['ColorTextMatch'],$columnNames['columnDb']);
                            $newCOlarr = $getPlaceholderDetails[0]['ColorTextMatch'];
                            $getPlaceholderDetails[0]['ColorTextMatchKey'] =  array();
                            $getKey = array_keys($getPlaceholderDetails[0]['ColorTextMatch']);
                           
                                foreach( $getKey as $k => $v){
                                    
                                    if($columnNames['ColumnNameColor']){
                                        $columnNames['ColorTextMatchKey'][$v] = $columnNames['ColumnNameColor'][$k];
                                    }else{
                                        $columnNames['ColorTextMatchKey'][$v] = $v;
                                    }
                                }
                           
                        }else{
                            foreach($columnNames['ColumnNameColor'] as $colKey=> $colVal){
                                $newCOlarr[$colVal]['Condition'] = $getPlaceholderDetails[0]['Condition'];
                                $newCOlarr[$colVal]['SecondParameter'] = $getPlaceholderDetails[0]['SecondParameter'];
                                $newCOlarr[$colVal]['TextColors'] = $getPlaceholderDetails[0]['Colors'];
                               
                            }
                        }
                        
                        unset($columnNames['ColumnNameColor']);
                        $columnNames['ColumnNameColor'] = $newCOlarr;
                        
                        $columnNames['ColorSettingType'] =   !empty($getPlaceholderDetails[0]['ColorSettingType'])?trim($getPlaceholderDetails[0]['ColorSettingType']):'';
                    
                        
                     }   
                }

                if($columnNames['AllowDynamicForm']){
                    $gettable1  = Placeholder::getSendOrdertable($getPlaceholderDetails[0]['DynamicFormName']);
                    $columnNames['DesignType'] =  !empty($gettable1[0]['DesignType'])?trim($gettable1[0]['DesignType']):0;
                    $columnNames['OldDesignBtnTitle'] =   !empty($gettable1[0]['OldDesignBtnTitle'])?trim($gettable1[0]['OldDesignBtnTitle']):'';
                    $columnNames['NewDesignBtnTitle'] =   !empty($gettable1[0]['NewDesignBtnTitle'])?trim($gettable1[0]['NewDesignBtnTitle']):'';
                    
                }
                $columnNames['NameOrgBtn'] =   !empty($getPlaceholderDetails[0]['NameOrgBtn'])?trim($getPlaceholderDetails[0]['NameOrgBtn']):'';
                $columnNames['NameLastBtn'] =   !empty($getPlaceholderDetails[0]['NameLastBtn'])?trim($getPlaceholderDetails[0]['NameLastBtn']):'';
                $columnNames['EnableLastSearchDF'] =   !empty($getPlaceholderDetails[0]['EnableLastSearchDF'])?trim($getPlaceholderDetails[0]['EnableLastSearchDF']):0;
             
                $columnNames['EnableRowGroupLevel'] =!empty($getPlaceholderDetails[0]['EnableRowGroupLevel'])?trim($getPlaceholderDetails[0]['EnableRowGroupLevel']):0;
              
                 $RowGroupLevelColumns = json_decode( $getPlaceholderDetails[0]['RowGroupLevelColumns'] , true);
                
                if(!empty($RowGroupLevelColumns)){
                    $columnNames['RowGroupLevelColumn'] = array();
                    $newRW  = array(); //$val = array();
                    foreach ($RowGroupLevelColumns as $key => $value) {
                        $val = explode(',', $value);
                        $temData =  $rowGroupColumnKeys = array_intersect($columnNames['columnDb'],array_values($val));
                        $temData = array_keys($temData);
                        
                        array_push( $newRW , $temData[0] );
                    }
                    $columnNames['RowGroupLevelColumn'] = $newRW;
                }
               
                if( $getPlaceholderDetails[0]['EnableChildRows']){
                    $key = array_search('Pack' , $columnNames['columnTitle']);
                    unset($columnNames['columnTitle'][$key]);
                }
                $gettable  = MongoTable::getMongotable($getPlaceholderDetails[0][0]);
                $columnNames['ProductInfo'] = !empty($gettable)?$gettable:''; 
                $columnNames['PredefineSortOrder'] =   isset($getPlaceholderDetails[0]['PredefineSortOrder'])?trim($getPlaceholderDetails[0]['PredefineSortOrder']):'asc';
                $columnNames['rowId'] = '';
                // For Editable Table need to set the Row ID 
                if($getPlaceholderDetails[0]['TableType'] == '2')
                {
                    $id  = json_encode(array('ID' => 0));
                    $columnNames['rowId'] = DataTableHelper::footerColumnVisibility( $id  ,$columnNames['columnDb']);
                    $columnNames['rowId'] = array_keys($columnNames['rowId']);
                   
                    $columnNames['rowId'] =  isset($columnNames['rowId'][0])?$columnNames['rowId'][0]:'';
                }
               
                echo json_encode($columnNames);
                exit;
            }
             //(End) if placeholder is present .
        }
        echo "";
        exit;
    }

    




}