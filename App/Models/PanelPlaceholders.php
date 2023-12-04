<?php

namespace App\Models;

use PDO;

/**
 * PanelPlaceholders model
 *
 * PHP version 7.0
 */
class PanelPlaceholders extends \Core\Model
{
    public static function addPanel($data)
    {
        try {
            // Make COnnection WIth DB 
            $db = static::getDB();
            // (Start) Condition  for Update 
            if (isset($data['id']) && !empty($data['id'])) {
                // Query for update an record 
                $sql = "UPDATE Panels SET Name = :Name, Descriptions = :Descriptions, PanelColor = :PanelColor,
                        PanelType = :PanelType, DataSourceId = :DataSourceId, SumType = :SumType , CustomSumFormula = :CustomSumFormula,
                         Columns = :Columns, Title = :Title, ImageName = :ImageName, DenominationText = :DenominationText, TableId = :TableId, ColumnOpr = :ColumnOpr ,  TextDesign2 = :TextDesign2 , ProgressBarD3 = :ProgressBarD3 , AllowDecimalFlag = :AllowDecimalFlag , 
                         EnableGroupRowCal =:EnableGroupRowCal , RowGroupColumnName=:RowGroupColumnName , TimeTableSeparator=:TimeTableSeparator , ColumnDataType=:ColumnDataType  WHERE ID = :ID";
                if(empty($data['DataSourceId']))
                {
                    $data['DataSourceId'] = '0';
                }
                // Prepare query for parameter binding with values 
                $stmt = $db->prepare($sql);
                // Parameter binding 
                $stmt->bindParam(':ID', $data['id'], PDO::PARAM_STR);
                $stmt->bindParam(':Name', $data['Name'], PDO::PARAM_STR);
                $stmt->bindParam(':Descriptions', $data['Descriptions'], PDO::PARAM_STR);
                $stmt->bindParam(':PanelColor', $data['PanelColor'], PDO::PARAM_STR);
                $stmt->bindParam(':PanelType', $data['PanelType'], PDO::PARAM_STR);
                $stmt->bindParam(':DataSourceId', $data['DataSourceId'], PDO::PARAM_STR);
                $stmt->bindParam(':SumType', $data['SumType'], PDO::PARAM_STR);
                $stmt->bindParam(':CustomSumFormula', $data['CustomSumFormula'], PDO::PARAM_STR);
                $stmt->bindParam(':Columns', $data['Columns'], PDO::PARAM_STR);
                $stmt->bindParam(':Title', $data['Title'], PDO::PARAM_STR);
                $stmt->bindParam(':ImageName', $data['ImageName'], PDO::PARAM_STR);
                $stmt->bindParam(':DenominationText', $data['DenominationText'], PDO::PARAM_STR);
                $stmt->bindParam(':TableId', $data['TableId'], PDO::PARAM_STR);
                $stmt->bindParam(':ColumnOpr', $data['ColumnOpr'], PDO::PARAM_STR);
                $stmt->bindParam(':TextDesign2', $data['TextDesign2'], PDO::PARAM_STR);
                $stmt->bindParam(':ProgressBarD3', $data['ProgressBarD3'], PDO::PARAM_STR);
                $stmt->bindParam(':AllowDecimalFlag', $data['AllowDecimalFlag'], PDO::PARAM_STR);
                $stmt->bindParam(':EnableGroupRowCal', $data['EnableGroupRowCal'], PDO::PARAM_STR);
                $stmt->bindParam(':RowGroupColumnName', $data['RowGroupColumnName'], PDO::PARAM_STR);
                $stmt->bindParam(':TimeTableSeparator', $data['TimeTableSeparator'], PDO::PARAM_STR);
                $stmt->bindParam(':ColumnDataType', $data['ColumnDataType'], PDO::PARAM_STR);
               
                // Execute Query 
                $stmt->execute();
            }
             // (End) Condition  for Update 
             //(Start) for new record insertion  
            else {
                // Query for new entry 
                $sql = "INSERT INTO Panels (Name, Descriptions, PanelColor, PanelType, DataSourceId, SumType, CustomSumFormula, Columns, Title, ImageName, DenominationText, TableId, ColumnOpr,  TextDesign2 , ProgressBarD3, AllowDecimalFlag , EnableGroupRowCal, RowGroupColumnName , TimeTableSeparator , ColumnDataType)
                    VALUES (:Name, :Descriptions, :PanelColor, :PanelType, :DataSourceId, :SumType, :CustomSumFormula, :Columns, :Title, :ImageName, :DenominationText, :TableId, :ColumnOpr, :TextDesign2 , :ProgressBarD3, :AllowDecimalFlag , :EnableGroupRowCal, :RowGroupColumnName , :TimeTableSeparator, :ColumnDataType)";
                if(empty($data['DataSourceId']))
                {
                    $data['DataSourceId'] = '0';
                }
                 // Prepare query for parameter binding with values 
                $stmt = $db->prepare($sql);
                // Parameter binding 
                $stmt->bindParam(':Name', $data['Name'], PDO::PARAM_STR);
                $stmt->bindParam(':Descriptions', $data['Descriptions'], PDO::PARAM_STR);
                $stmt->bindParam(':PanelColor', $data['PanelColor'], PDO::PARAM_STR);
                $stmt->bindParam(':PanelType', $data['PanelType'], PDO::PARAM_STR);
                $stmt->bindParam(':DataSourceId', $data['DataSourceId'], PDO::PARAM_STR);
                $stmt->bindParam(':SumType', $data['SumType'], PDO::PARAM_STR);
                $stmt->bindParam(':CustomSumFormula', $data['CustomSumFormula'], PDO::PARAM_STR);
                $stmt->bindParam(':Columns', $data['Columns'], PDO::PARAM_STR);
                $stmt->bindParam(':Title', $data['Title'], PDO::PARAM_STR);
                $stmt->bindParam(':ImageName', $data['ImageName'], PDO::PARAM_STR);
                $stmt->bindParam(':DenominationText', $data['DenominationText'], PDO::PARAM_STR);
                $stmt->bindParam(':TableId', $data['TableId'], PDO::PARAM_STR);
                $stmt->bindParam(':ColumnOpr', $data['ColumnOpr'], PDO::PARAM_STR);
                $stmt->bindParam(':TextDesign2', $data['TextDesign2'], PDO::PARAM_STR);
                $stmt->bindParam(':ProgressBarD3', $data['ProgressBarD3'], PDO::PARAM_STR);
                $stmt->bindParam(':AllowDecimalFlag', $data['AllowDecimalFlag'], PDO::PARAM_STR);
                $stmt->bindParam(':EnableGroupRowCal', $data['EnableGroupRowCal'], PDO::PARAM_STR);
                $stmt->bindParam(':RowGroupColumnName', $data['RowGroupColumnName'], PDO::PARAM_STR);
                $stmt->bindParam(':TimeTableSeparator', $data['TimeTableSeparator'], PDO::PARAM_STR);
                $stmt->bindParam(':ColumnDataType', $data['ColumnDataType'], PDO::PARAM_STR);
                // Execute Query 
                $stmt->execute();
            }
            //(End) for new record insertion  
        } catch (PDOException $e) {
        }
        return;
    }
    //(Start) dunctio to add panel action 
    public static function addPanelActions($data)
    {
        try {
            // Make Connection with DB 
            $db = static::getDB();
            //(Start) for Update
            if (isset($data['id']) && !empty($data['id'])) {
                // Query to update a record 
                $sql = "UPDATE PanelActions SET Name = :Name, Descriptions = :Descriptions, DataSourceId = :DataSourceId,
                        PageTargetId = :PageTargetId, PanelTemplateId = :PanelTemplateId,
                        PanelParameterColumn = :PanelParameterColumn, ExternalUrl = :ExternalUrl,
                        ActionButtonText = :ActionButtonText, ActionButtonColor = :ActionButtonColor WHERE ID = :ID";
                // Prepare Query to bind parameter 
                $stmt = $db->prepare($sql);
                // Parameter binding 
                $stmt->bindParam(':ID', $data['id'], PDO::PARAM_STR);
                $stmt->bindParam(':Name', $data['Name'], PDO::PARAM_STR);
                $stmt->bindParam(':Descriptions', $data['Descriptions'], PDO::PARAM_STR);
                $stmt->bindParam(':PageTargetId', $data['PageTargetId'], PDO::PARAM_STR);
                $stmt->bindParam(':DataSourceId', $data['DataSourceId'], PDO::PARAM_STR);
                $stmt->bindParam(':PanelTemplateId', $data['PanelTemplateId'], PDO::PARAM_STR);
                $stmt->bindParam(':PanelParameterColumn', $data['PanelParameterColumn'], PDO::PARAM_STR);
                $stmt->bindParam(':ExternalUrl', $data['ExternalUrl'], PDO::PARAM_STR);
                $stmt->bindParam(':ActionButtonText', $data['ActionButtonText'], PDO::PARAM_STR);
                $stmt->bindParam(':ActionButtonColor', $data['ActionButtonColor'], PDO::PARAM_STR);
                // Excute Query.
                $stmt->execute();
            } else {
                // Query to add new record
                $sql = "INSERT INTO PanelActions (Name, Descriptions, PageTargetId, DataSourceId, PanelTemplateId, PanelParameterColumn, ExternalUrl, ActionButtonText, ActionButtonColor)
                    VALUES (:Name, :Descriptions, :PageTargetId, :DataSourceId, :PanelTemplateId, :PanelParameterColumn, :ExternalUrl, :ActionButtonText, :ActionButtonColor)";
                // prepare query to bind parameter
                $stmt = $db->prepare($sql);
                // Parameter Binding 
                $stmt->bindParam(':Name', $data['Name'], PDO::PARAM_STR);
                $stmt->bindParam(':Descriptions', $data['Descriptions'], PDO::PARAM_STR);
                $stmt->bindParam(':PageTargetId', $data['PageTargetId'], PDO::PARAM_STR);
                $stmt->bindParam(':DataSourceId', $data['DataSourceId'], PDO::PARAM_STR);
                $stmt->bindParam(':PanelTemplateId', $data['PanelTemplateId'], PDO::PARAM_STR);
                $stmt->bindParam(':PanelParameterColumn', $data['PanelParameterColumn'], PDO::PARAM_STR);
                $stmt->bindParam(':ExternalUrl', $data['ExternalUrl'], PDO::PARAM_STR);
                $stmt->bindParam(':ActionButtonText', $data['ActionButtonText'], PDO::PARAM_STR);
                $stmt->bindParam(':ActionButtonColor', $data['ActionButtonColor'], PDO::PARAM_STR);
                // Excute query 
                $stmt->execute();
            }

        } catch (PDOException $e) {
        }
        return;
    }
    // (Start) Function to get all Panels  (not used )
    public static function getAllPanels()
    {
        // Make connection with DB 
        $db = static::getDB();
        // Query to fetch all data 
        $sql = "SELECT ID, Name, Descriptions FROM Panels";
        // Execute Query 
        $stmt = $db->query($sql);
        // Fetch all data 
        $data = $stmt->fetchAll();
        return $data;
    }

    // Save Panel placeholder
    public static function SavePanelPlaceholder($data)
    {
        // Make Connectio with DB 
        $db = static::getDB();
        //(Start) For update 
        if(!empty($data['id'])){
            // Query to Update 
            $sql = "UPDATE UserPagePlaceholders SET PlaceholderValue = :PlaceholderValue,
            PlaceholderId = :PlaceholderId,
            PlaceholderActionIds = :PlaceholderActionIds,
            PlaceholderType = :PlaceholderType,
            UserPageAccessId = :UserPageAccessId,
            UserId = :UserId,
            SliderDesign=:SliderDesign,
            SliderDesign2=:SliderDesign2
            WHERE ID = :ID";
            $getParentPages = (isset($data['ParentPages']))? $data['ParentPages'] : NULL;
            try{
                // Prepare Query to bind Parameter 
                $stmt = $db->prepare($sql);
                // Parameter Binding
                $stmt->bindParam(':PlaceholderValue', $data['PlaceholderValue'], PDO::PARAM_STR);
                $stmt->bindParam(':PlaceholderId', $data['PlaceholderId'], PDO::PARAM_STR);
                $stmt->bindParam(':PlaceholderActionIds', $data['PlaceholderActionIds'], PDO::PARAM_STR);
                $stmt->bindParam(':PlaceholderType', $data['PlaceholderType'], PDO::PARAM_STR);
                $stmt->bindParam(':UserPageAccessId', $data['UserPageAccessId'], PDO::PARAM_STR);
                $stmt->bindParam(':UserId', $data['UserId'], PDO::PARAM_STR);
                $stmt->bindParam(':SliderDesign', $data['SliderDesign'], PDO::PARAM_STR);
                $stmt->bindParam(':SliderDesign2', $data['SliderDesign2'], PDO::PARAM_STR);
                
                $stmt->bindParam(':ID', $data['id'], PDO::PARAM_INT);
                
                // Execute Query 
                $stmt->execute();
            }catch (Exception $exc){
                echo $exc->getMessage();exit;

            }

        }
        //(End) For update 
        //(Start) For new ENtry   
        else {
            try {
                // Query to insert new Entry 
                $sql = "INSERT INTO UserPagePlaceholders (PlaceholderValue, PlaceholderId, PlaceholderActionIds, PlaceholderType, UserPageAccessId, UserId , SliderDesign,SliderDesign2)
                        VALUES (:PlaceholderValue, :PlaceholderId, :PlaceholderActionIds, :PlaceholderType, :UserPageAccessId, :UserId, :SliderDesign , :SliderDesign2)";
                // Prepare query to bind parameter
                $stmt = $db->prepare($sql);
                // Parameter binding
                $stmt->bindParam(':PlaceholderValue', $data['PlaceholderValue'], PDO::PARAM_STR);
                $stmt->bindParam(':PlaceholderId', $data['PlaceholderId'], PDO::PARAM_STR);
                $stmt->bindParam(':PlaceholderActionIds', $data['PlaceholderActionIds'], PDO::PARAM_STR);
                $stmt->bindParam(':PlaceholderType', $data['PlaceholderType'], PDO::PARAM_STR);
                $stmt->bindParam(':UserPageAccessId', $data['UserPageAccessId'], PDO::PARAM_STR);
                $stmt->bindParam(':UserId', $data['UserId'], PDO::PARAM_STR);
                $stmt->bindParam(':SliderDesign', $data['SliderDesign'], PDO::PARAM_STR);
                $stmt->bindParam(':SliderDesign2', $data['SliderDesign2'], PDO::PARAM_STR);
                
                // Excute Query 
                $stmt->execute();

            } catch (PDOException $e) {
            }
        }
        return;
    }


}