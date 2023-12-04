<?php

namespace App\Models;

use PDO;

/**
 * GraphPlaceholders model
 *
 * PHP version 7.0
 */
class GraphPlaceholders extends \Core\Model
{
    //(Start) FUnction to add a new Graph 
    public static function addGraph($data)
    {
        try {
            //Make Connection with DB 
            $db = static::getDB();
            //(Start) for Update 
            if (isset($data['id']) && !empty($data['id'])) {
                // Update record Query 
                $sql = "UPDATE Graphs SET Name = :Name, Descriptions = :Descriptions, GraphType = :GraphType, DataSourceId = :DataSourceId,
                        XField = :XField, YField = :YField , ZField = :ZField,
                        XFieldLabel = :XFieldLabel, YFieldLabel = :YFieldLabel, ZFieldLabel = :ZFieldLabel,
                        Filters = :Filters, HeadersText = :HeadersText, TableId = :TableId , Deactivate3d = :Deactivate3d WHERE ID = :ID";
                if(empty($data['DataSourceId']))
                {
                    $data['DataSourceId'] = '0';
                }
                if(empty($data['Deactivate3d']))
                {
                    $data['Deactivate3d'] = '0';
                }
                // Prepare Query for binding value with parameter .
                $stmt = $db->prepare($sql);
                // parameter bining 
                $stmt->bindParam(':ID', $data['id'], PDO::PARAM_STR);
                $stmt->bindParam(':Name', $data['Name'], PDO::PARAM_STR);
                $stmt->bindParam(':Descriptions', $data['Descriptions'], PDO::PARAM_STR);
                $stmt->bindParam(':GraphType', $data['GraphType'], PDO::PARAM_STR);
                $stmt->bindParam(':DataSourceId', $data['DataSourceId'], PDO::PARAM_STR);
                $stmt->bindParam(':XField', $data['XField'], PDO::PARAM_STR);
                $stmt->bindParam(':YField', $data['YField'], PDO::PARAM_STR);
                $stmt->bindParam(':ZField', $data['ZField'], PDO::PARAM_STR);
                $stmt->bindParam(':XFieldLabel', $data['XFieldLabel'], PDO::PARAM_STR);
                $stmt->bindParam(':YFieldLabel', $data['YFieldLabel'], PDO::PARAM_STR);
                $stmt->bindParam(':ZFieldLabel', $data['ZFieldLabel'], PDO::PARAM_STR);
                $stmt->bindParam(':Filters', $data['Filters'], PDO::PARAM_STR);
                $stmt->bindParam(':HeadersText', $data['HeadersText'], PDO::PARAM_STR);
                $stmt->bindParam(':TableId', $data['TableId'], PDO::PARAM_STR);
                $stmt->bindParam(':Deactivate3d', $data['Deactivate3d'], PDO::PARAM_STR);
                // Excute Query 
                $stmt->execute();
            } 
            else {
                // QUery to insert new entry 
                $sql = "INSERT INTO Graphs (Name, Descriptions, GraphType, DataSourceId, XField, YField, ZField, XFieldLabel, YFieldLabel, ZFieldLabel, Filters, HeadersText, TableId, Deactivate3d)
                    VALUES (:Name, :Descriptions, :GraphType, :DataSourceId, :XField, :YField, :ZField, :XFieldLabel, :YFieldLabel, :ZFieldLabel, :Filters, :HeadersText, :TableId, :Deactivate3d)";
                if(empty($data['DataSourceId']))
                {
                    $data['DataSourceId'] = '0';
                }
                 if(empty($data['Deactivate3d']))
                {
                    $data['Deactivate3d'] = '0';
                }
                // Prepare Query for parameter binding 
                $stmt = $db->prepare($sql);
                // Parameter Binding 
                $stmt->bindParam(':Name', $data['Name'], PDO::PARAM_STR);
                $stmt->bindParam(':Descriptions', $data['Descriptions'], PDO::PARAM_STR);
                $stmt->bindParam(':GraphType', $data['GraphType'], PDO::PARAM_STR);
                $stmt->bindParam(':DataSourceId', $data['DataSourceId'], PDO::PARAM_STR);
                $stmt->bindParam(':XField', $data['XField'], PDO::PARAM_STR);
                $stmt->bindParam(':YField', $data['YField'], PDO::PARAM_STR);
                $stmt->bindParam(':ZField', $data['ZField'], PDO::PARAM_STR);
                $stmt->bindParam(':XFieldLabel', $data['XFieldLabel'], PDO::PARAM_STR);
                $stmt->bindParam(':YFieldLabel', $data['YFieldLabel'], PDO::PARAM_STR);
                $stmt->bindParam(':ZFieldLabel', $data['ZFieldLabel'], PDO::PARAM_STR);
                $stmt->bindParam(':Filters', $data['Filters'], PDO::PARAM_STR);
                $stmt->bindParam(':HeadersText', $data['HeadersText'], PDO::PARAM_STR);
                $stmt->bindParam(':TableId', $data['TableId'], PDO::PARAM_STR);
                $stmt->bindParam(':Deactivate3d', $data['Deactivate3d'], PDO::PARAM_STR);
                // Excute Query 
                $stmt->execute();
            }

        } catch (PDOException $e) {
        }
        return;
    }
    //(Start) FUnction  to add a new pie chart 
    public static function addPieChart($data)
    {
        try {
            // Make connection with DB 
            $db = static::getDB();
            //(Start) for Update 
            if (isset($data['id']) && !empty($data['id'])) {
                // QUery to update a record 
                $sql = "UPDATE PieCharts SET Name = :Name, Descriptions = :Descriptions, PieChartType = :PieChartType, DataSourceId = :DataSourceId, CustomSumFormula = :CustomSumFormula,  Columns = :Columns, CustomNameLabel = :CustomNameLabel, Fields = :Fields, HeadersText = :HeadersText, TableId = :TableId , CalculationType = :CalculationType , DisplayType = :DisplayType , ShowLabel = :ShowLabel WHERE ID = :ID";
                // Prepare query to bind Parameter
                $stmt = $db->prepare($sql);
                // Parameter Binding
                $stmt->bindParam(':ID', $data['id'], PDO::PARAM_STR);
                $stmt->bindParam(':Name', $data['Name'], PDO::PARAM_STR);
                $stmt->bindParam(':Descriptions', $data['Descriptions'], PDO::PARAM_STR);
                $stmt->bindParam(':PieChartType', $data['PieChartType'], PDO::PARAM_STR);
                $stmt->bindParam(':DataSourceId', $data['DataSourceId'], PDO::PARAM_STR);
                $stmt->bindParam(':CustomSumFormula', $data['CustomSumFormula'], PDO::PARAM_STR);
                $stmt->bindParam(':Fields', $data['Fields'], PDO::PARAM_STR);
                $stmt->bindParam(':Columns', $data['Columns'], PDO::PARAM_STR);
                $stmt->bindParam(':CustomNameLabel', $data['CustomNameLabel'], PDO::PARAM_STR);
                $stmt->bindParam(':HeadersText', $data['HeadersText'], PDO::PARAM_STR);
                $stmt->bindParam(':TableId', $data['TableId'], PDO::PARAM_STR);
                $stmt->bindParam(':CalculationType', $data['CalculationType'], PDO::PARAM_STR);
                $stmt->bindParam(':DisplayType', $data['DisplayType'], PDO::PARAM_STR);
                $stmt->bindParam(':ShowLabel', $data['ShowLabel'], PDO::PARAM_STR);
                // Execute Query
                $stmt->execute();
            } else {
                // Query to add a new entry 
                $sql = "INSERT INTO PieCharts (Name, Descriptions, PieChartType, DataSourceId, Fields, CustomSumFormula, Columns , CustomNameLabel ,HeadersText, TableId, CalculationType, DisplayType, ShowLabel)
                    VALUES (:Name, :Descriptions, :PieChartType, :DataSourceId, :Fields, :CustomSumFormula, :Columns , :CustomNameLabel , :HeadersText, :TableId, :CalculationType, :DisplayType, :ShowLabel)";
                // prepare query to bind parameter
                $stmt = $db->prepare($sql);
                // parameter Binding 
                $stmt->bindParam(':Name', $data['Name'], PDO::PARAM_STR);
                $stmt->bindParam(':Descriptions', $data['Descriptions'], PDO::PARAM_STR);
                $stmt->bindParam(':PieChartType', $data['PieChartType'], PDO::PARAM_STR);
                $stmt->bindParam(':DataSourceId', $data['DataSourceId'], PDO::PARAM_STR);
                $stmt->bindParam(':Fields', $data['Fields'], PDO::PARAM_STR);
                $stmt->bindParam(':CustomSumFormula', $data['CustomSumFormula'], PDO::PARAM_STR);
                $stmt->bindParam(':CalculationType', $data['CalculationType'], PDO::PARAM_STR);
                $stmt->bindParam(':Columns', $data['Columns'], PDO::PARAM_STR);
                $stmt->bindParam(':CustomNameLabel', $data['CustomNameLabel'], PDO::PARAM_STR);
                $stmt->bindParam(':HeadersText', $data['HeadersText'], PDO::PARAM_STR);
                $stmt->bindParam(':TableId', $data['TableId'], PDO::PARAM_STR);
                $stmt->bindParam(':DisplayType', $data['DisplayType'], PDO::PARAM_STR);
                $stmt->bindParam(':ShowLabel', $data['ShowLabel'], PDO::PARAM_STR);
                // Execute Query 
                $stmt->execute();
            }

        } catch (PDOException $e) {
        }
        return;
    }
    //(Start) function to add Graph action 
    public static function addGraphActions($data)
    {
        try {
            // Make Connection with DB 
            $db = static::getDB();
            //(Start) for Update 
            if (isset($data['id']) && !empty($data['id'])) {
                // Update Query 
                $sql = "UPDATE GraphActions SET Name = :Name, Descriptions = :Descriptions, DataSourceId = :DataSourceId,
                        PageTargetId = :PageTargetId, ExternalUrl = :ExternalUrl,
                        ActionButtonText = :ActionButtonText, ActionButtonColor = :ActionButtonColor WHERE ID = :ID";
                // prepare query to bind parameter 
                $stmt = $db->prepare($sql);
                // Parameter Binding 
                $stmt->bindParam(':ID', $data['id'], PDO::PARAM_STR);
                $stmt->bindParam(':Name', $data['Name'], PDO::PARAM_STR);
                $stmt->bindParam(':Descriptions', $data['Descriptions'], PDO::PARAM_STR);
                $stmt->bindParam(':PageTargetId', $data['PageTargetId'], PDO::PARAM_STR);
                $stmt->bindParam(':DataSourceId', $data['DataSourceId'], PDO::PARAM_STR);
                $stmt->bindParam(':ExternalUrl', $data['ExternalUrl'], PDO::PARAM_STR);
                $stmt->bindParam(':ActionButtonText', $data['ActionButtonText'], PDO::PARAM_STR);
                $stmt->bindParam(':ActionButtonColor', $data['ActionButtonColor'], PDO::PARAM_STR);
                // Execute Query 
                $stmt->execute();
            }
            //(End) for Update 
             //(Start) for new Entry  
             else {
                 // Add new  Query 
                $sql = "INSERT INTO GraphActions (Name, Descriptions, PageTargetId, DataSourceId, ExternalUrl, ActionButtonText, ActionButtonColor)
                    VALUES (:Name, :Descriptions, :PageTargetId, :DataSourceId, :ExternalUrl, :ActionButtonText, :ActionButtonColor)";
                // prepare query to bind parameter 
                $stmt = $db->prepare($sql);
                // Parameter Binding 
                $stmt->bindParam(':Name', $data['Name'], PDO::PARAM_STR);
                $stmt->bindParam(':Descriptions', $data['Descriptions'], PDO::PARAM_STR);
                $stmt->bindParam(':PageTargetId', $data['PageTargetId'], PDO::PARAM_STR);
                $stmt->bindParam(':DataSourceId', $data['DataSourceId'], PDO::PARAM_STR);
                $stmt->bindParam(':ExternalUrl', $data['ExternalUrl'], PDO::PARAM_STR);
                $stmt->bindParam(':ActionButtonText', $data['ActionButtonText'], PDO::PARAM_STR);
                $stmt->bindParam(':ActionButtonColor', $data['ActionButtonColor'], PDO::PARAM_STR);
                // Execute Query 
                $stmt->execute();
            }

        } catch (PDOException $e) {
        }
        return;
    }
}