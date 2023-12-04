<?php

namespace App\Models;

use PDO;
use App\Models\DataSources;

/**
 * TablePlaceholders model
 *
 * PHP version 7.0
 */
class TablePlaceholders extends \Core\Model
{
    // Get all Table Placholder data .
    public static function getAllDataTable()
    {
        // Make COnnection WIth DB 
        $db = static::getDB();
        // Query to Fetch Data 
        $sql = "SELECT ID, Name , Columns FROM Tables";
        // Execute Query 
        $stmt = $db->query($sql);
        // Fetch Data 
        $data = $stmt->fetchAll();
        return $data;
    }

    public static function getTableColumns($id)
    {
         //Make Connection with DB 
        $db = static::getDB();
        // Condition that , if  ID as posted Pamaeter is not  empty . 
        if (!empty($id)) {
            $conditions[] = 'ID = ?';
            $parameters[] = $id;
        }
        // Query 
        $sql = "SELECT Columns FROM Tables";
        if ($conditions) {
            $sql .= " WHERE " . implode(" AND ", $conditions);
        }
        // Prepare Query to bind value with parameter 
        $stmt = $db->prepare($sql);
        //Execute Query 
        $stmt->execute($parameters);
        // Fetch Data 
        $data = $stmt->fetchAll();
        return $data;
    }
    public static function addColumnSetting($data){
        try {
            // Make Connection WIth DB 
            $db = static::getDB();
           
            $sql = "UPDATE Tables SET CustomColumnWidthName=:CustomColumnWidthName, CustomColumnWidthDesc=:CustomColumnWidthDesc, CustomColumnWidth =:CustomColumnWidth , EnableFilterWidth1 = :EnableFilterWidth1 WHERE ID = :ID";
            $stmt = $db->prepare($sql);
            // Parameter Binding 
            $stmt->bindParam(':ID', $data['TableId'], PDO::PARAM_STR);
            $stmt->bindParam(':CustomColumnWidthName', $data['CustomColumnWidthName'], PDO::PARAM_STR); 
            $stmt->bindParam(':CustomColumnWidthDesc', $data['CustomColumnWidthDesc'], PDO::PARAM_STR); 
            $stmt->bindParam(':CustomColumnWidth', $data['CustomColumnWidth'], PDO::PARAM_STR); 
            $stmt->bindParam(':EnableFilterWidth1', $data['EnableFilterWidth1'], PDO::PARAM_STR); 

            // Execute Query 
            $stmt->execute();


        }catch (PDOException $e) {
        }
        return;
    }

    
    public static function addTable($data , $newTab)
    {
        
        try {
            // Make Connection WIth DB 
            $db = static::getDB();
            //(Start) For Update 
            if (isset($data['id']) && !empty($data['id'])) {
                // Query for Update 
                $NewTableFlag = 0;
                if($newTab === 'new'){
                    $NewTableFlag = 1;
                }
                $sql = "UPDATE Tables SET Name = :Name, Descriptions = :Descriptions, TableType = :TableType,
                        DataSourceId = :DataSourceId, SumType = :SumType , CustomSumFormula = :CustomSumFormula,
                         Columns = :Columns, DisplayColumnNames = :DisplayColumnNames, DisplayDetailColumnNames = :DisplayDetailColumnNames, SumColumnLable = :SumColumnLable,
                         ColumnsFooter = :ColumnsFooter, IsFooterCallback = :IsFooterCallback, FootCallBackText = :FootCallBackText, FooterColumnsProperties = :FooterColumnsProperties, ChartColumn = :ChartColumn , MapColumn = :MapColumn , SearchFlag = :SearchFlag , AdditionalColumnProperties = :AdditionalColumnProperties, PieChartColumn = :PieChartColumn , AllowMultipleSelectionColumn = :AllowMultipleSelectionColumn, multipleSerachSelectorFlag = :multipleSerachSelectorFlag , GroupRowsColumn = :GroupRowsColumn , GroupRowsFlag = :GroupRowsFlag , PredefineSearch = :PredefineSearch , HideColumn = :HideColumn , PredefineSort = :PredefineSort , RangePredefineSearchFlag = :RangePredefineSearchFlag , PredefineSearchForRange = :PredefineSearchForRange , PredefineSortOrder =:PredefineSortOrder , ColumnSort = :ColumnSort ,
                          ExcludeZeroCol = :ExcludeZeroCol , RowsCount = :RowsCount , InvisiblePredefineSearch=:InvisiblePredefineSearch , EnableCrudCSV=:EnableCrudCSV ,  EnableDefaultCrudCSV=:EnableDefaultCrudCSV ,  EnableFilterWidth = :EnableFilterWidth, ColumnsMatching = :ColumnsMatching , ColumnstoBeMatched =:ColumnstoBeMatched , TableDesign =:TableDesign , ScrollWidth = :ScrollWidth  , FooterSumLocation=:FooterSumLocation , PaginationFlag = :PaginationFlag , EnableChildRows=:EnableChildRows , FilterSessionEnable =:FilterSessionEnable , EnableChildRowsRunTym =:EnableChildRowsRunTym , EnableLiveImgSync=:EnableLiveImgSync ,EnableExcelBtn=:EnableExcelBtn, XMLdownload=:XMLdownload , 
                          EnableXMLIds=:EnableXMLIds ,LiveReportSync = :LiveReportSync , LiveSyncPostURL = :LiveSyncPostURL , LiveSyncPostBody = :LiveSyncPostBody , AllowDynamicForm =:AllowDynamicForm , DynamicFormName =:DynamicFormName , LiveSyncOnLoad=:LiveSyncOnLoad , NameOrgBtn=:NameOrgBtn , NameLastBtn=:NameLastBtn , EnableLastSearchDF=:EnableLastSearchDF , EnableTxtFile=:EnableTxtFile , EnableFormOnActionBTN=:EnableFormOnActionBTN , AllowColumnRowMarking=:AllowColumnRowMarking , ColoringType=:ColoringType , ColoringJsonText=:ColoringJsonText,
                          ColorSettingType = :ColorSettingType , Colors=:Colors , ColumnNameColor=:ColumnNameColor , FirstParameter=:FirstParameter , Condition=:Condition , SecondParameter=:SecondParameter , ColorTextMatch=:ColorTextMatch , ReportOnLoad=:ReportOnLoad , EnableOnclickBtn=:EnableOnclickBtn , EnableRowGroupLevel =:EnableRowGroupLevel,RowGroupLevelColumns = :RowGroupLevelColumns , NewTableFlag = :NewTableFlag ,  AllowDataGrouping = :AllowDataGrouping ,DataGroupingJson =:DataGroupingJson , AllowSearchAfter3Char=:AllowSearchAfter3Char , ColSearchAfter3Char= :ColSearchAfter3Char , AddZeroForNegVal =:AddZeroForNegVal, ColAddZeroForNegVal=:ColAddZeroForNegVal , NotiColumnMarking= :NotiColumnMarking , EnableAllUpdates=:EnableAllUpdates , SelectPredefinedNames=:SelectPredefinedNames , EnableCacheTable =:EnableCacheTable , TimeDurationRedisTable =:TimeDurationRedisTable , 
                          TimeRedisTable=:TimeRedisTable , DisableReports=:DisableReports , RedisCallType=:RedisCallType , AllowPDFImport =:AllowPDFImport , AllowExcelImport =:AllowExcelImport , AllowJsonSave=:AllowJsonSave , AllowEnterSearch = :AllowEnterSearch WHERE ID = :ID";
               
                if(empty($data['SearchFlag'])){
                    $data['SearchFlag'] = 0;
                }
                if(empty($data['multipleSerachSelectorFlag'])){
                    $data['multipleSerachSelectorFlag'] = 0;
                }        
                // Prepare query for binding parameter
                $stmt = $db->prepare($sql);
                // Parameter Binding 
                $stmt->bindParam(':ID', $data['id'], PDO::PARAM_STR);
                $stmt->bindParam(':Name', $data['Name'], PDO::PARAM_STR);
                $stmt->bindParam(':Descriptions', $data['Descriptions'], PDO::PARAM_STR);
                $stmt->bindParam(':TableType', $data['TableType'], PDO::PARAM_STR);
                $stmt->bindParam(':DataSourceId', $data['DataSourceId'], PDO::PARAM_STR);
                $stmt->bindParam(':SumType', $data['SumType'], PDO::PARAM_STR);
                $stmt->bindParam(':CustomSumFormula', $data['CustomSumFormula'], PDO::PARAM_STR);
                $stmt->bindParam(':Columns', $data['Columns'], PDO::PARAM_STR);
                $stmt->bindParam(':DisplayColumnNames', $data['DisplayColumnNames'], PDO::PARAM_STR);
                $stmt->bindParam(':DisplayDetailColumnNames', $data['DisplayDetailColumnNames'], PDO::PARAM_STR);
                $stmt->bindParam(':SumColumnLable', $data['SumColumnLable'], PDO::PARAM_STR);
                $stmt->bindParam(':ColumnsFooter', $data['ColumnsFooter'], PDO::PARAM_STR);
                $stmt->bindParam(':IsFooterCallback', $data['IsFooterCallback'], PDO::PARAM_STR);
                $stmt->bindParam(':FootCallBackText', $data['FootCallBackText'], PDO::PARAM_STR);
                $stmt->bindParam(':FooterColumnsProperties', $data['FooterColumnsProperties'], PDO::PARAM_STR);
                $stmt->bindParam(':ChartColumn', $data['ChartColumn'], PDO::PARAM_STR);
                $stmt->bindParam(':MapColumn', $data['MapColumn'], PDO::PARAM_STR);
                $stmt->bindParam(':SearchFlag', $data['SearchFlag'], PDO::PARAM_STR);
                $stmt->bindParam(':AdditionalColumnProperties', $data['AdditionalColumnProperties'], PDO::PARAM_STR);
                $stmt->bindParam(':PieChartColumn', $data['PieChartColumn'], PDO::PARAM_STR);
                $stmt->bindParam(':AllowMultipleSelectionColumn', $data['AllowMultipleSelectionColumn'], PDO::PARAM_STR);
                $stmt->bindParam(':multipleSerachSelectorFlag', $data['multipleSerachSelectorFlag'], PDO::PARAM_STR);
                $stmt->bindParam(':GroupRowsColumn', $data['GroupRowsColumn'], PDO::PARAM_STR);
                $stmt->bindParam(':GroupRowsFlag', $data['GroupRowsFlag'], PDO::PARAM_STR);
                $stmt->bindParam(':PredefineSearch', $data['PredefineSearch'], PDO::PARAM_STR);
                $stmt->bindParam(':HideColumn', $data['HideColumn'], PDO::PARAM_STR);
                $stmt->bindParam(':PredefineSort', $data['PredefineSort'], PDO::PARAM_STR);
                $stmt->bindParam(':PredefineSearchForRange', $data['PredefineSearchForRange'], PDO::PARAM_STR);
                $stmt->bindParam(':RangePredefineSearchFlag', $data['RangePredefineSearchFlag'], PDO::PARAM_STR);
                $stmt->bindParam(':PredefineSortOrder', $data['PredefineSortOrder'], PDO::PARAM_STR);
                $stmt->bindParam(':ColumnSort', $data['ColumnSort'], PDO::PARAM_STR);
                $stmt->bindParam(':ExcludeZeroCol', $data['ExcludeZeroCol'], PDO::PARAM_STR);
                $stmt->bindParam(':RowsCount', $data['RowsCount'], PDO::PARAM_STR);
                $stmt->bindParam(':InvisiblePredefineSearch', $data['InvisiblePredefineSearch'], PDO::PARAM_STR);
                $stmt->bindParam(':EnableCrudCSV', $data['EnableCrudCSV'], PDO::PARAM_STR);
                $stmt->bindParam(':EnableDefaultCrudCSV', $data['EnableDefaultCrudCSV'], PDO::PARAM_STR);
                $stmt->bindParam(':ColumnsMatching', $data['ColumnsMatching'], PDO::PARAM_STR);
                $stmt->bindParam(':ColumnstoBeMatched', $data['ColumnstoBeMatched'], PDO::PARAM_STR);
                $stmt->bindParam(':EnableFilterWidth', $data['EnableFilterWidth'], PDO::PARAM_STR);
                $stmt->bindParam(':TableDesign', $data['TableDesign'], PDO::PARAM_STR); 
                $stmt->bindParam(':ScrollWidth', $data['ScrollWidth'], PDO::PARAM_STR);
                $stmt->bindParam(':FooterSumLocation', $data['FooterSumLocation'], PDO::PARAM_STR);
                $stmt->bindParam(':PaginationFlag', $data['PaginationFlag'], PDO::PARAM_STR);
                $stmt->bindParam(':EnableChildRows', $data['EnableChildRows'], PDO::PARAM_STR);
                $stmt->bindParam(':FilterSessionEnable', $data['FilterSessionEnable'], PDO::PARAM_STR);
                $stmt->bindParam(':EnableChildRowsRunTym', $data['EnableChildRowsRunTym'], PDO::PARAM_STR);
                $stmt->bindParam(':EnableLiveImgSync', $data['EnableLiveImgSync'], PDO::PARAM_STR);
                $stmt->bindParam(':EnableExcelBtn', $data['EnableExcelBtn'], PDO::PARAM_STR);
                $stmt->bindParam(':XMLdownload', $data['XMLdownload'], PDO::PARAM_STR);
                $stmt->bindParam(':EnableXMLIds', $data['EnableXMLIds'], PDO::PARAM_STR);
                $stmt->bindParam(':LiveReportSync', $data['LiveReportSync'], PDO::PARAM_STR);
                $stmt->bindParam(':LiveSyncPostURL', $data['LiveSyncPostURL'], PDO::PARAM_STR);
                $stmt->bindParam(':LiveSyncPostBody', $data['LiveSyncPostBody'], PDO::PARAM_STR);
                $stmt->bindParam(':AllowDynamicForm', $data['AllowDynamicForm'], PDO::PARAM_STR);
                $stmt->bindParam(':DynamicFormName', $data['DynamicFormName'], PDO::PARAM_STR);
                $stmt->bindParam(':LiveSyncOnLoad', $data['LiveSyncOnLoad'], PDO::PARAM_STR);
                $stmt->bindParam(':NameOrgBtn', $data['NameOrgBtn'], PDO::PARAM_STR);
                $stmt->bindParam(':NameLastBtn', $data['NameLastBtn'], PDO::PARAM_STR);
                $stmt->bindParam(':EnableLastSearchDF', $data['EnableLastSearchDF'], PDO::PARAM_STR);
                $stmt->bindParam(':EnableTxtFile', $data['EnableTxtFile'], PDO::PARAM_STR);
                $stmt->bindParam(':EnableFormOnActionBTN', $data['EnableFormOnActionBTN'], PDO::PARAM_STR);
                $stmt->bindParam(':AllowColumnRowMarking', $data['AllowColumnRowMarking'], PDO::PARAM_STR); 
                $stmt->bindParam(':ColoringType', $data['ColoringType'], PDO::PARAM_STR); 
                $stmt->bindParam(':ColoringJsonText', $data['ColoringJsonText'], PDO::PARAM_STR); 
                $stmt->bindParam(':ColorSettingType', $data['ColorSettingType'], PDO::PARAM_STR); 
                $stmt->bindParam(':Colors', $data['Colors'], PDO::PARAM_STR); 
                $stmt->bindParam(':ColumnNameColor', $data['ColumnNameColor'], PDO::PARAM_STR); 
                $stmt->bindParam(':FirstParameter', $data['FirstParameter'], PDO::PARAM_STR); 
                $stmt->bindParam(':Condition', $data['Condition'], PDO::PARAM_STR); 
                $stmt->bindParam(':SecondParameter', $data['SecondParameter'], PDO::PARAM_STR); 
                $stmt->bindParam(':ColorTextMatch', $data['ColorTextMatch'], PDO::PARAM_STR); 
                $stmt->bindParam(':ReportOnLoad', $data['ReportOnLoad'], PDO::PARAM_STR); 
                $stmt->bindParam(':EnableOnclickBtn', $data['EnableOnclickBtn'], PDO::PARAM_STR); 
                $stmt->bindParam(':EnableRowGroupLevel', $data['EnableRowGroupLevel'], PDO::PARAM_STR); 
                $stmt->bindParam(':RowGroupLevelColumns', $data['RowGroupLevelColumns'], PDO::PARAM_STR); 
                $stmt->bindParam(':NewTableFlag', $NewTableFlag, PDO::PARAM_STR); 
                $stmt->bindParam(':AllowDataGrouping', $data['AllowDataGrouping'], PDO::PARAM_STR); 
                $stmt->bindParam(':DataGroupingJson',$data['DataGroupingJson'] , PDO::PARAM_STR); 
                $stmt->bindParam(':AllowSearchAfter3Char',$data['AllowSearchAfter3Char'] , PDO::PARAM_STR); 
                $stmt->bindParam(':ColSearchAfter3Char',$data['ColSearchAfter3Char'] , PDO::PARAM_STR); 
                $stmt->bindParam(':AddZeroForNegVal',$data['AddZeroForNegVal'] , PDO::PARAM_STR); 
                $stmt->bindParam(':ColAddZeroForNegVal',$data['ColAddZeroForNegVal'] , PDO::PARAM_STR); 
                $stmt->bindParam(':NotiColumnMarking',$data['NotiColumnMarking'] , PDO::PARAM_STR); 
                $stmt->bindParam(':EnableAllUpdates',$data['EnableAllUpdates'] , PDO::PARAM_STR); 
                $stmt->bindParam(':SelectPredefinedNames',$data['SelectPredefinedNames'] , PDO::PARAM_STR); 
                $stmt->bindParam(':EnableCacheTable',$data['EnableCacheTable'] , PDO::PARAM_STR); 
                $stmt->bindParam(':TimeDurationRedisTable',$data['TimeDurationRedisTable'] , PDO::PARAM_STR); 
                $stmt->bindParam(':TimeRedisTable',$data['TimeRedisTable'] , PDO::PARAM_STR); 
                $stmt->bindParam(':DisableReports',$data['DisableReports'] , PDO::PARAM_STR); 
                $stmt->bindParam(':AllowPDFImport',$data['AllowPDFImport'] , PDO::PARAM_STR); 
                $stmt->bindParam(':AllowExcelImport',$data['AllowExcelImport'] , PDO::PARAM_STR); 
				$stmt->bindParam(':AllowJsonSave',$data['AllowJsonSave'] , PDO::PARAM_STR);
				$stmt->bindParam(':AllowEnterSearch',$data['AllowEnterSearch'] , PDO::PARAM_STR);
				

                if($data['EnableCacheTable'] == 1){
                    $DataSourceData = DataSources::getSpecficDataSource($data['DataSourceId']);
                    $DataSourceData = $DataSourceData[0]['RequestType'];
                    $stmt->bindParam(':RedisCallType', $DataSourceData, PDO::PARAM_STR); 
                }else{
                    $DataSourceData = '';
                    $stmt->bindParam(':RedisCallType', $DataSourceData, PDO::PARAM_STR);
                }
               
                // Execute Query 
                $stmt->execute();
            }
            //(End) FOr Update 
            //(Start) For new Entry  
            else {
                // Query 
                $NewTableFlag = 0;
               
                if($newTab === 'new'){
                   
                    $NewTableFlag = 1;
                }
                
                $sql = "INSERT INTO Tables (Name, Descriptions, TableType, DataSourceId, SumType, CustomSumFormula, Columns, DisplayColumnNames, DisplayDetailColumnNames, SumColumnLable, ColumnsFooter, IsFooterCallback, FootCallBackText, FooterColumnsProperties, ChartColumn , MapColumn , SearchFlag ,AdditionalColumnProperties, PieChartColumn , AllowMultipleSelectionColumn , multipleSerachSelectorFlag ,GroupRowsColumn , GroupRowsFlag, PredefineSearch, HideColumn, PredefineSort , RangePredefineSearchFlag , PredefineSearchForRange , PredefineSortOrder , ColumnSort , ExcludeZeroCol , RowsCount , InvisiblePredefineSearch , EnableCrudCSV , ColumnsMatching ,ColumnstoBeMatched , EnableFilterWidth , EnableDefaultCrudCSV , TableDesign , ScrollWidth ,FooterSumLocation , PaginationFlag , EnableChildRows ,FilterSessionEnable , EnableChildRowsRunTym, EnableLiveImgSync , EnableExcelBtn, XMLdownload , EnableXMLIds ,LiveReportSync , LiveSyncPostURL , LiveSyncPostBody , AllowDynamicForm , DynamicFormName , LiveSyncOnLoad , NameOrgBtn, NameLastBtn, EnableLastSearchDF , EnableTxtFile , EnableFormOnActionBTN , AllowColumnRowMarking , ColoringJsonText, ColoringType , ColorSettingType , Colors,ColumnNameColor,FirstParameter,Condition,SecondParameter , ColorTextMatch , ReportOnLoad , EnableOnclickBtn , EnableRowGroupLevel , RowGroupLevelColumns , NewTableFlag , AllowDataGrouping ,DataGroupingJson , AllowSearchAfter3Char , ColSearchAfter3Char , AddZeroForNegVal, ColAddZeroForNegVal , NotiColumnMarking , EnableAllUpdates , SelectPredefinedNames  ,  EnableCacheTable, TimeDurationRedisTable,TimeRedisTable,  DisableReports, RedisCallType ,  AllowPDFImport , AllowExcelImport , AllowJsonSave, AllowEnterSearch)
                VALUES (:Name, :Descriptions, :TableType, :DataSourceId, :SumType, :CustomSumFormula, :Columns,  :DisplayColumnNames, :DisplayDetailColumnNames, :SumColumnLable, :ColumnsFooter, :IsFooterCallback, :FootCallBackText, :FooterColumnsProperties, :ChartColumn , :MapColumn , :SearchFlag, :AdditionalColumnProperties, :PieChartColumn , :AllowMultipleSelectionColumn ,:multipleSerachSelectorFlag ,:GroupRowsColumn , :GroupRowsFlag,:PredefineSearch, :HideColumn, :PredefineSort , :RangePredefineSearchFlag , :PredefineSearchForRange , :PredefineSortOrder , :ColumnSort , :ExcludeZeroCol , :RowsCount, :InvisiblePredefineSearch , :EnableCrudCSV, :ColumnsMatching , :ColumnstoBeMatched , :EnableFilterWidth , :EnableDefaultCrudCSV , :TableDesign , :ScrollWidth , :FooterSumLocation , :PaginationFlag , :EnableChildRows ,:FilterSessionEnable ,:EnableChildRowsRunTym , :EnableLiveImgSync, :EnableExcelBtn, :XMLdownload , :EnableXMLIds, :LiveReportSync , :LiveSyncPostURL , :LiveSyncPostBody , :AllowDynamicForm , :DynamicFormName , :LiveSyncOnLoad , :NameOrgBtn , :NameLastBtn , :EnableLastSearchDF , :EnableTxtFile , :EnableFormOnActionBTN, :AllowColumnRowMarking,:ColoringJsonText , :ColoringType , :ColorSettingType , :Colors,:ColumnNameColor,:FirstParameter,:Condition,:SecondParameter , :ColorTextMatch , :ReportOnLoad, :EnableOnclickBtn ,:EnableRowGroupLevel , :RowGroupLevelColumns , :NewTableFlag , :AllowDataGrouping , :DataGroupingJson , :AllowSearchAfter3Char , :ColSearchAfter3Char, :AddZeroForNegVal, :ColAddZeroForNegVal, :NotiColumnMarking , :EnableAllUpdates , :SelectPredefinedNames ,  :EnableCacheTable, :TimeDurationRedisTable,:TimeRedisTable,  :DisableReports, :RedisCallType ,  :AllowPDFImport , :AllowExcelImport ,:AllowJsonSave, :AllowEnterSearch )";
              
                if(empty($data['SearchFlag'])){
                    $data['SearchFlag'] = 0;
                }
                // if(empty($data['ScrollFlag'])){
                //     $data['ScrollFlag'] = 0;
                // }
                if(empty($data['multipleSerachSelectorFlag'])){
                    $data['multipleSerachSelectorFlag'] = 0;
                }
                // Prepare query for binding parameter
                $stmt = $db->prepare($sql);
                // Parameter Binding 
                $stmt->bindParam(':Name', $data['Name'], PDO::PARAM_STR);
                $stmt->bindParam(':Descriptions', $data['Descriptions'], PDO::PARAM_STR);
                $stmt->bindParam(':TableType', $data['TableType'], PDO::PARAM_STR);
                $stmt->bindParam(':DataSourceId', $data['DataSourceId'], PDO::PARAM_STR);
                $stmt->bindParam(':SumType', $data['SumType'], PDO::PARAM_STR);
                $stmt->bindParam(':CustomSumFormula', $data['CustomSumFormula'], PDO::PARAM_STR);
                $stmt->bindParam(':Columns', $data['Columns'], PDO::PARAM_STR);
                $stmt->bindParam(':DisplayColumnNames', $data['DisplayColumnNames'], PDO::PARAM_STR);
                $stmt->bindParam(':DisplayDetailColumnNames', $data['DisplayDetailColumnNames'], PDO::PARAM_STR);
                $stmt->bindParam(':SumColumnLable', $data['SumColumnLable'], PDO::PARAM_STR);
                $stmt->bindParam(':ColumnsFooter', $data['ColumnsFooter'], PDO::PARAM_STR);
                $stmt->bindParam(':IsFooterCallback', $data['IsFooterCallback'], PDO::PARAM_STR);
                $stmt->bindParam(':FootCallBackText', $data['FootCallBackText'], PDO::PARAM_STR);
                $stmt->bindParam(':FooterColumnsProperties', $data['FooterColumnsProperties'], PDO::PARAM_STR);
                $stmt->bindParam(':ChartColumn', $data['ChartColumn'], PDO::PARAM_STR);
                $stmt->bindParam(':MapColumn', $data['MapColumn'], PDO::PARAM_STR);
                $stmt->bindParam(':SearchFlag', $data['SearchFlag'], PDO::PARAM_STR);
                $stmt->bindParam(':AdditionalColumnProperties', $data['AdditionalColumnProperties'], PDO::PARAM_STR);
                $stmt->bindParam(':PieChartColumn', $data['PieChartColumn'], PDO::PARAM_STR);
                $stmt->bindParam(':AllowMultipleSelectionColumn', $data['AllowMultipleSelectionColumn'], PDO::PARAM_STR);
                $stmt->bindParam(':multipleSerachSelectorFlag', $data['multipleSerachSelectorFlag'], PDO::PARAM_STR);
                $stmt->bindParam(':GroupRowsColumn', $data['GroupRowsColumn'], PDO::PARAM_STR);
                $stmt->bindParam(':GroupRowsFlag', $data['GroupRowsFlag'], PDO::PARAM_STR);
                $stmt->bindParam(':PredefineSearch', $data['PredefineSearch'], PDO::PARAM_STR);
                $stmt->bindParam(':HideColumn', $data['HideColumn'], PDO::PARAM_STR);
                $stmt->bindParam(':PredefineSort', $data['PredefineSort'], PDO::PARAM_STR);
                 $stmt->bindParam(':PredefineSearchForRange', $data['PredefineSearchForRange'], PDO::PARAM_STR);
                $stmt->bindParam(':RangePredefineSearchFlag', $data['RangePredefineSearchFlag'], PDO::PARAM_STR);
                //$stmt->bindParam(':ScrollFlag', $data['ScrollFlag'], PDO::PARAM_STR);
                
                $stmt->bindParam(':PredefineSortOrder', $data['PredefineSortOrder'], PDO::PARAM_STR);
                $stmt->bindParam(':ColumnSort', $data['ColumnSort'], PDO::PARAM_STR);
                $stmt->bindParam(':ExcludeZeroCol', $data['ExcludeZeroCol'], PDO::PARAM_STR);
                $stmt->bindParam(':RowsCount', $data['RowsCount'], PDO::PARAM_STR);
                $stmt->bindParam(':InvisiblePredefineSearch', $data['InvisiblePredefineSearch'], PDO::PARAM_STR);
                $stmt->bindParam(':EnableCrudCSV', $data['EnableCrudCSV'], PDO::PARAM_STR);
                $stmt->bindParam(':ColumnsMatching', $data['ColumnsMatching'], PDO::PARAM_STR);
                $stmt->bindParam(':ColumnstoBeMatched', $data['ColumnstoBeMatched'], PDO::PARAM_STR);
                $stmt->bindParam(':EnableFilterWidth', $data['EnableFilterWidth'], PDO::PARAM_STR);
                $stmt->bindParam(':EnableDefaultCrudCSV', $data['EnableDefaultCrudCSV'], PDO::PARAM_STR);
                $stmt->bindParam(':TableDesign', $data['TableDesign'], PDO::PARAM_STR); 
                $stmt->bindParam(':ScrollWidth', $data['ScrollWidth'], PDO::PARAM_STR);
                $stmt->bindParam(':FooterSumLocation', $data['FooterSumLocation'], PDO::PARAM_STR);
                $stmt->bindParam(':PaginationFlag', $data['PaginationFlag'], PDO::PARAM_STR);
                $stmt->bindParam(':EnableChildRows', $data['EnableChildRows'], PDO::PARAM_STR);
                $stmt->bindParam(':FilterSessionEnable', $data['FilterSessionEnable'], PDO::PARAM_STR);
                $stmt->bindParam(':EnableChildRowsRunTym', $data['EnableChildRowsRunTym'], PDO::PARAM_STR);
                $stmt->bindParam(':EnableLiveImgSync', $data['EnableLiveImgSync'], PDO::PARAM_STR);
                $stmt->bindParam(':EnableExcelBtn', $data['EnableExcelBtn'], PDO::PARAM_STR);
                $stmt->bindParam(':XMLdownload', $data['XMLdownload'], PDO::PARAM_STR);
                $stmt->bindParam(':EnableXMLIds', $data['EnableXMLIds'], PDO::PARAM_STR);
                $stmt->bindParam(':LiveReportSync', $data['LiveReportSync'], PDO::PARAM_STR);
                $stmt->bindParam(':LiveSyncPostURL', $data['LiveSyncPostURL'], PDO::PARAM_STR);
                $stmt->bindParam(':LiveSyncPostBody', $data['LiveSyncPostBody'], PDO::PARAM_STR);
                $stmt->bindParam(':AllowDynamicForm', $data['AllowDynamicForm'], PDO::PARAM_STR);
                $stmt->bindParam(':DynamicFormName', $data['DynamicFormName'], PDO::PARAM_STR);
                $stmt->bindParam(':LiveSyncOnLoad', $data['LiveSyncOnLoad'], PDO::PARAM_STR);
                $stmt->bindParam(':NameOrgBtn', $data['NameOrgBtn'], PDO::PARAM_STR);
                $stmt->bindParam(':NameLastBtn', $data['NameLastBtn'], PDO::PARAM_STR);
                $stmt->bindParam(':EnableLastSearchDF', $data['EnableLastSearchDF'], PDO::PARAM_STR);
                $stmt->bindParam(':EnableTxtFile', $data['EnableTxtFile'], PDO::PARAM_STR);
                $stmt->bindParam(':EnableFormOnActionBTN', $data['EnableFormOnActionBTN'], PDO::PARAM_STR);
                $stmt->bindParam(':AllowColumnRowMarking', $data['AllowColumnRowMarking'], PDO::PARAM_STR); 
                $stmt->bindParam(':ColoringType', $data['ColoringType'], PDO::PARAM_STR); 
                $stmt->bindParam(':ColoringJsonText', $data['ColoringJsonText'], PDO::PARAM_STR); 
                $stmt->bindParam(':ColorSettingType', $data['ColorSettingType'], PDO::PARAM_STR); 
                $stmt->bindParam(':Colors', $data['Colors'], PDO::PARAM_STR); 
                $stmt->bindParam(':ColumnNameColor', $data['ColumnNameColor'], PDO::PARAM_STR); 
                $stmt->bindParam(':FirstParameter', $data['FirstParameter'], PDO::PARAM_STR); 
                $stmt->bindParam(':Condition', $data['Condition'], PDO::PARAM_STR); 
                $stmt->bindParam(':SecondParameter', $data['SecondParameter'], PDO::PARAM_STR); 
                $stmt->bindParam(':ColorTextMatch', $data['ColorTextMatch'], PDO::PARAM_STR); 
                $stmt->bindParam(':ReportOnLoad', $data['ReportOnLoad'], PDO::PARAM_STR); 
                $stmt->bindParam(':EnableOnclickBtn', $data['EnableOnclickBtn'], PDO::PARAM_STR); 
                $stmt->bindParam(':EnableRowGroupLevel', $data['EnableRowGroupLevel'], PDO::PARAM_STR); 
                $stmt->bindParam(':RowGroupLevelColumns', $data['RowGroupLevelColumns'], PDO::PARAM_STR); 
                $stmt->bindParam(':NewTableFlag', $NewTableFlag, PDO::PARAM_STR); 
                $stmt->bindParam(':AllowDataGrouping', $data['AllowDataGrouping'], PDO::PARAM_STR); 
                $stmt->bindParam(':DataGroupingJson', $data['DataGroupingJson'], PDO::PARAM_STR); 
                $stmt->bindParam(':AllowSearchAfter3Char', $data['AllowSearchAfter3Char'], PDO::PARAM_STR); 
                $stmt->bindParam(':ColSearchAfter3Char', $data['ColSearchAfter3Char'], PDO::PARAM_STR); 
                $stmt->bindParam(':AddZeroForNegVal', $data['AddZeroForNegVal'], PDO::PARAM_STR); 
                $stmt->bindParam(':ColAddZeroForNegVal', $data['ColAddZeroForNegVal'], PDO::PARAM_STR); 
                $stmt->bindParam(':NotiColumnMarking',$data['NotiColumnMarking'] , PDO::PARAM_STR); 
                $stmt->bindParam(':EnableAllUpdates',$data['EnableAllUpdates'] , PDO::PARAM_STR); 
                $stmt->bindParam(':SelectPredefinedNames',$data['SelectPredefinedNames'] , PDO::PARAM_STR); 
                $stmt->bindParam(':EnableCacheTable',$data['EnableCacheTable'] , PDO::PARAM_STR); 
                $stmt->bindParam(':TimeDurationRedisTable',$data['TimeDurationRedisTable'] , PDO::PARAM_STR); 
                $stmt->bindParam(':TimeRedisTable',$data['TimeRedisTable'] , PDO::PARAM_STR); 
                $stmt->bindParam(':DisableReports',$data['DisableReports'] , PDO::PARAM_STR); 
                $stmt->bindParam(':AllowPDFImport',$data['AllowPDFImport'] , PDO::PARAM_STR); 
                $stmt->bindParam(':AllowExcelImport',$data['AllowExcelImport'] , PDO::PARAM_STR); 
				$stmt->bindParam(':AllowJsonSave',$data['AllowJsonSave'] , PDO::PARAM_STR); 
				$stmt->bindParam(':AllowEnterSearch',$data['AllowEnterSearch'] , PDO::PARAM_STR); 
				
                if($data['EnableCacheTable'] == 1){
                    $DataSourceData = DataSources::getSpecficDataSource($data['DataSourceId']);
                    $DataSourceData = $DataSourceData[0]['RequestType'];
                    $stmt->bindParam(':RedisCallType', $DataSourceData, PDO::PARAM_STR); 
                }else{
                    $DataSourceData = '';
                    $stmt->bindParam(':RedisCallType', $DataSourceData, PDO::PARAM_STR);
                }
               
                // Excute Query 
                $stmt->execute();
            }
            //(ENd ) For new Entry 

        } catch (PDOException $e) {
        }
        return;
    }
     //(Start) Function to add table Action 
     public static function addTableActions($data)
     {
         try {
             // Make Connection with DB 
             $db = static::getDB();
             //(Start) for Update 
             if (isset($data['id']) && !empty($data['id'])) {
                 // QUery to update a record 
                 $sql = "UPDATE TableActions SET Name = :Name, Descriptions = :Descriptions, DataSourceId = :DataSourceId,
                         PageTargetId = :PageTargetId, TableTemplateId = :TableTemplateId,
                         TableParameterColumn = :TableParameterColumn, ExternalUrl = :ExternalUrl,
                         ActionButtonText = :ActionButtonText, ActionButtonColor = :ActionButtonColor,
                         UneditableColumns = :UneditableColumns,
                         PredefinedUpdate = :PredefinedUpdate,
                         DataSourceCall = :DataSourceCall,
                         IsPdf = :IsPdf , 
                         PredefinedUpdateRedis = :PredefinedUpdateRedis
                          WHERE ID = :ID";
                 // Prepare query to bind parameter 
                 $stmt = $db->prepare($sql);
                 // Parameter Binding 
                 $stmt->bindParam(':ID', $data['id'], PDO::PARAM_STR);
                 $stmt->bindParam(':Name', $data['Name'], PDO::PARAM_STR);
                 $stmt->bindParam(':Descriptions', $data['Descriptions'], PDO::PARAM_STR);
                 $stmt->bindParam(':PageTargetId', $data['PageTargetId'], PDO::PARAM_STR);
                 $stmt->bindParam(':DataSourceId', $data['DataSourceId'], PDO::PARAM_STR);
                 $stmt->bindParam(':TableTemplateId', $data['TableTemplateId'], PDO::PARAM_STR);
                 $stmt->bindParam(':TableParameterColumn', $data['TableParameterColumn'], PDO::PARAM_STR);
                 $stmt->bindParam(':ExternalUrl', $data['ExternalUrl'], PDO::PARAM_STR);
                 $stmt->bindParam(':ActionButtonText', $data['ActionButtonText'], PDO::PARAM_STR);
                 $stmt->bindParam(':ActionButtonColor', $data['ActionButtonColor'], PDO::PARAM_STR);
                 $stmt->bindParam(':UneditableColumns', $data['UneditableColumns'], PDO::PARAM_STR);
                 $stmt->bindParam(':PredefinedUpdate', $data['PredefinedUpdate'], PDO::PARAM_STR);
                 $stmt->bindParam(':DataSourceCall', $data['DataSourceCall'], PDO::PARAM_STR);
                 $stmt->bindParam(':IsPdf', $data['IsPdf'], PDO::PARAM_STR);
                 $stmt->bindParam(':PredefinedUpdateRedis', $data['PredefinedUpdateRedis'], PDO::PARAM_STR);
                
                 
                 // Execute Query 
                 $stmt->execute();
             }
             // (End) for Update
             //(Start) for new entry  
             else {
                 // QUery to add new record 
                 $sql = "INSERT INTO TableActions (Name, Descriptions, PageTargetId, DataSourceId, TableTemplateId, TableParameterColumn, ExternalUrl, ActionButtonText, ActionButtonColor, UneditableColumns, PredefinedUpdate, DataSourceCall, IsPdf , PredefinedUpdateRedis)
                     VALUES (:Name, :Descriptions, :PageTargetId, :DataSourceId, :TableTemplateId, :TableParameterColumn, :ExternalUrl, :ActionButtonText, :ActionButtonColor, :UneditableColumns, :PredefinedUpdate, :DataSourceCall, :IsPdf , :PredefinedUpdateRedis)";
                 // Prepare query to bind parameter 
                 $stmt = $db->prepare($sql);
                 $stmt->bindParam(':Name', $data['Name'], PDO::PARAM_STR);
                 $stmt->bindParam(':Descriptions', $data['Descriptions'], PDO::PARAM_STR);
                 $stmt->bindParam(':PageTargetId', $data['PageTargetId'], PDO::PARAM_STR);
                 $stmt->bindParam(':DataSourceId', $data['DataSourceId'], PDO::PARAM_STR);
                 $stmt->bindParam(':TableTemplateId', $data['TableTemplateId'], PDO::PARAM_STR);
                 $stmt->bindParam(':TableParameterColumn', $data['TableParameterColumn'], PDO::PARAM_STR);
                 $stmt->bindParam(':ExternalUrl', $data['ExternalUrl'], PDO::PARAM_STR);
                 $stmt->bindParam(':ActionButtonText', $data['ActionButtonText'], PDO::PARAM_STR);
                 $stmt->bindParam(':ActionButtonColor', $data['ActionButtonColor'], PDO::PARAM_STR);
                 $stmt->bindParam(':UneditableColumns', $data['UneditableColumns'], PDO::PARAM_STR);
                 $stmt->bindParam(':PredefinedUpdate', $data['PredefinedUpdate'], PDO::PARAM_STR);
                 $stmt->bindParam(':DataSourceCall', $data['DataSourceCall'], PDO::PARAM_STR);
                 $stmt->bindParam(':IsPdf', $data['IsPdf'], PDO::PARAM_STR);
                 $stmt->bindParam(':PredefinedUpdateRedis', $data['PredefinedUpdateRedis'], PDO::PARAM_STR);

                 // Excute Query 
                 $stmt->execute();
             }
 
         } catch (PDOException $e) {
             echo $e->getMessage();
             exit;
         }
         return;
     }
      //(Start) Function to save table Action 
      public static function saveTableActions($data)
      {
          try {
              // Make Connection with DB 
              $db = static::getDB();
              //(Start) for Update 
              if (isset($data['id']) && !empty($data['id'])) {
                  // QUery to update a record 
                  $sql = "UPDATE ChildRowAction SET Name = :Name, Descriptions = :Descriptions, DataSourceId = :DataSourceId,
                          TableTemplateId = :TableTemplateId,
                          TableParameterColumn = :TableParameterColumn
                           WHERE ID = :ID";
                  // Prepare query to bind parameter 
                  $stmt = $db->prepare($sql);
                  // Parameter Binding 
                  $stmt->bindParam(':ID', $data['id'], PDO::PARAM_STR);
                  $stmt->bindParam(':Name', $data['Name'], PDO::PARAM_STR);
                  $stmt->bindParam(':Descriptions', $data['Descriptions'], PDO::PARAM_STR);
                 
                  $stmt->bindParam(':DataSourceId', $data['DataSourceId'], PDO::PARAM_STR);
                  $stmt->bindParam(':TableTemplateId', $data['TableTemplateId'], PDO::PARAM_STR);
                  $stmt->bindParam(':TableParameterColumn', $data['TableParameterColumn'], PDO::PARAM_STR);
                 
                  // Execute Query 
                  $stmt->execute();
              }
              // (End) for Update
              //(Start) for new entry  
              else {
                  // QUery to add new record 
                  $sql = "INSERT INTO ChildRowAction (Name, Descriptions,  DataSourceId, TableTemplateId, TableParameterColumn)
                      VALUES (:Name, :Descriptions,  :DataSourceId, :TableTemplateId, :TableParameterColumn)";
                  // Prepare query to bind parameter 
                  $stmt = $db->prepare($sql);
                  $stmt->bindParam(':Name', $data['Name'], PDO::PARAM_STR);
                  $stmt->bindParam(':Descriptions', $data['Descriptions'], PDO::PARAM_STR);
                  
                  $stmt->bindParam(':DataSourceId', $data['DataSourceId'], PDO::PARAM_STR);
                  $stmt->bindParam(':TableTemplateId', $data['TableTemplateId'], PDO::PARAM_STR);
                  $stmt->bindParam(':TableParameterColumn', $data['TableParameterColumn'], PDO::PARAM_STR);
                  
                  // Excute Query 
                  $stmt->execute();
              }
  
          } catch (PDOException $e) {
              echo $e->getMessage();
              exit;
          }
          return;
      }
      //(Start) Function to save dynamic Form  
      public static function saveDynamicForm($data)
      {
          try {
              // Make Connection with DB 
              $db = static::getDB();
              //(Start) for Update 
              if (isset($data['id']) && !empty($data['id'])) {
                  // QUery to update a record 
                  $sql = "UPDATE SendOrders SET Name = :Name, Description = :Description, 
                    DetailColumns = :DetailColumns ,    HiddenColumns = :HiddenColumns , DesignType =:DesignType, ActionButton =:ActionButton , AllReadOnly=:AllReadOnly , CallType=:CallType , SelectionType = :SelectionType
                    WHERE ID = :ID";
                  // Prepare query to bind parameter 
                  $stmt = $db->prepare($sql);
                  // Parameter Binding 
                $stmt->bindParam(':ID', $data['id'], PDO::PARAM_STR);
                $stmt->bindParam(':Name', $data['Name'], PDO::PARAM_STR);
                $stmt->bindParam(':Description', $data['Description'], PDO::PARAM_STR);
                $stmt->bindParam(':DetailColumns', $data['DetailColumns'], PDO::PARAM_STR);
                //$stmt->bindParam(':DetailColumnsOrderColumn', $data['DetailColumnsOrderColumn'], PDO::PARAM_STR);               
               
                $stmt->bindParam(':ActionButton',  $data['ActionButton'], PDO::PARAM_STR);
                $stmt->bindParam(':DesignType', $data['DesignType'], PDO::PARAM_STR);
                $stmt->bindParam(':HiddenColumns',  $data['HiddenColumns'], PDO::PARAM_STR);
                $stmt->bindParam(':AllReadOnly',  $data['AllReadOnly'], PDO::PARAM_STR);
                $stmt->bindParam(':CallType',  $data['CallType'], PDO::PARAM_STR);
                $stmt->bindParam(':SelectionType',  $data['SelectionType'], PDO::PARAM_STR);
                // $stmt->bindParam(':OldDesignBtnTitle',  $data['OldDesignBtnTitle'], PDO::PARAM_STR);
                // $stmt->bindParam(':NewDesignBtnTitle',  $data['NewDesignBtnTitle'], PDO::PARAM_STR);
                
                
                  // Execute Query 
                  $stmt->execute();
              }
              // (End) for Update
              //(Start) for new entry  
              else {
                $sql = "INSERT INTO SendOrders (Name, Description, DetailColumns  , DateCreated , HiddenColumns , DesignType, ActionButton , dynamicForm , AllReadOnly , CallType , SelectionType)
                    VALUES (:Name, :Description, :DetailColumns , :DateCreated , :HiddenColumns , :DesignType , :ActionButton , :dynamicForm, :AllReadOnly , :CallType ,  :SelectionType  )";
                $date =  date('Y-m-d');
                $stmt = $db->prepare($sql);
                $form = 1;
                $stmt->bindParam(':Name', $data['Name'], PDO::PARAM_STR);
                $stmt->bindParam(':Description', $data['Description'], PDO::PARAM_STR);
                $stmt->bindParam(':DetailColumns', $data['DetailColumns'], PDO::PARAM_STR);
                //$stmt->bindParam(':DetailColumnsOrderColumn', $data['DetailColumnsOrderColumn'], PDO::PARAM_STR);               
                $stmt->bindParam(':DateCreated', $date, PDO::PARAM_STR);
                $stmt->bindParam(':ActionButton',  $data['ActionButton'], PDO::PARAM_STR);
                $stmt->bindParam(':DesignType', $data['DesignType'], PDO::PARAM_STR);
                $stmt->bindParam(':HiddenColumns',  $data['HiddenColumns'], PDO::PARAM_STR);
                $stmt->bindParam(':dynamicForm',   $form, PDO::PARAM_STR);
                $stmt->bindParam(':AllReadOnly',  $data['AllReadOnly'], PDO::PARAM_STR);
                $stmt->bindParam(':CallType',  $data['CallType'], PDO::PARAM_STR);
                $stmt->bindParam(':SelectionType',  $data['SelectionType'], PDO::PARAM_STR);
                // $stmt->bindParam(':OldDesignBtnTitle',  $data['OldDesignBtnTitle'], PDO::PARAM_STR);
                // $stmt->bindParam(':NewDesignBtnTitle',  $data['NewDesignBtnTitle'], PDO::PARAM_STR);
                
                
                
                // Execute Query 
                $stmt->execute();
                
              }
  
          } catch (PDOException $e) {
              echo $e->getMessage();
              exit;
          }
          return;
      }
      // Save data for Slider
      public static function addSliderTable($data)
      {
          
          try {
              // Make Connection WIth DB 
              $db = static::getDB();
              //(Start) For Update 
              if (isset($data['id']) && !empty($data['id'])) {
                  // Query for Update 
                
                  $sql = "UPDATE TableSilder SET Name = :Name, Descriptions = :Descriptions,
                         TableSideBar=:TableSideBar , TabAction =:TabAction , TableSideBar2=:TableSideBar2 , TabAction2 =:TabAction2 ,SilderDesign=:SilderDesign  WHERE ID = :ID";
                    
                  // Prepare query for binding parameter
                  $stmt = $db->prepare($sql);
                  // Parameter Binding 
                  $stmt->bindParam(':ID', $data['id'], PDO::PARAM_STR);
                  $stmt->bindParam(':Name', $data['Name'], PDO::PARAM_STR);
                  $stmt->bindParam(':Descriptions', $data['Descriptions'], PDO::PARAM_STR);
                  $stmt->bindParam(':TableSideBar', $data['TableSideBar'], PDO::PARAM_STR);
                  $stmt->bindParam(':TabAction', $data['TabAction'], PDO::PARAM_STR);
                  $stmt->bindParam(':TableSideBar2', $data['TableSideBar2'], PDO::PARAM_STR);
                  $stmt->bindParam(':TabAction2', $data['TabAction2'], PDO::PARAM_STR);
                  $stmt->bindParam(':SilderDesign', $data['SilderDesign'], PDO::PARAM_STR);
                  
                  
                  // Execute Query 
                  $stmt->execute();
              }
              //(End) FOr Update 
              //(Start) For new Entry  
              else {
                  // Query 
                  $sql = "INSERT INTO TableSilder (Name, Descriptions,  TableSideBar , TabAction , TableSideBar2 , TabAction2 , SilderDesign )
                      VALUES (:Name, :Descriptions,  :TableSideBar, :TabAction , :TableSideBar2, :TabAction2 ,:SilderDesign)";
                
                  // Prepare query for binding parameter
                  $stmt = $db->prepare($sql);
                  // Parameter Binding 
                  $stmt->bindParam(':Name', $data['Name'], PDO::PARAM_STR);
                  $stmt->bindParam(':Descriptions', $data['Descriptions'], PDO::PARAM_STR);
                  $stmt->bindParam(':TableSideBar', $data['TableSideBar'], PDO::PARAM_STR);
                  $stmt->bindParam(':TabAction', $data['TabAction'], PDO::PARAM_STR);
                  $stmt->bindParam(':TableSideBar2', $data['TableSideBar2'], PDO::PARAM_STR);
                  $stmt->bindParam(':TabAction2', $data['TabAction2'], PDO::PARAM_STR);
                  $stmt->bindParam(':SilderDesign', $data['SilderDesign'], PDO::PARAM_STR);
                  
                  
                  
                  
        
                  // Excute Query 
                  $stmt->execute();
              }
              //(ENd ) For new Entry 
  
          } catch (PDOException $e) {
          }
          return;
      }
        // Get all SliderTable Placholder data .
        public static function getAllSliderTable()
        {
        // Make COnnection WIth DB 
        $db = static::getDB();
        // Query to Fetch Data 
        $sql = "SELECT ID, Name , Columns FROM TableSilder";
        // Execute Query 
        $stmt = $db->query($sql);
        // Fetch Data 
        $data = $stmt->fetchAll();
        return $data;
    }
}
