<?php

namespace App\Models;

use PDO;

/**
 * PanelPlaceholders model
 *
 * PHP version 7.0
 */
class MapPlaceholders extends \Core\Model
{
    public static function addMaps($data)
    {
        try {
            // Make Connection with DB 
            $db = static::getDB();
            //(Start) For Update 
            if (isset($data['id']) && !empty($data['id'])) {
                // Query to Update a record 
                $sql = "UPDATE Maps SET Name = :Name, Descriptions = :Descriptions, MapType = :MapType, DataSourceId = :DataSourceId,               CustomSumFormula = :CustomSumFormula,  Columns = :Columns,
                    CustomNameLabel = :CustomNameLabel, Fields = :Fields, HeadersText = :HeadersText, TableId = :TableId WHERE ID = :ID";
                // Prepare a query to bind parameter 
                $stmt = $db->prepare($sql);
                // Parameter Binding
                $stmt->bindParam(':ID', $data['id'], PDO::PARAM_STR);
                $stmt->bindParam(':Name', $data['Name'], PDO::PARAM_STR);
                $stmt->bindParam(':Descriptions', $data['Descriptions'], PDO::PARAM_STR);
                $stmt->bindParam(':MapType', $data['MapType'], PDO::PARAM_STR);
                $stmt->bindParam(':DataSourceId', $data['DataSourceId'], PDO::PARAM_STR);
                $stmt->bindParam(':Fields', $data['Fields'], PDO::PARAM_STR);
                $stmt->bindParam(':CustomSumFormula', $data['CustomSumFormula'], PDO::PARAM_STR);
                $stmt->bindParam(':Columns', $data['Columns'], PDO::PARAM_STR);
                $stmt->bindParam(':CustomNameLabel', $data['CustomNameLabel'], PDO::PARAM_STR);
                $stmt->bindParam(':HeadersText', $data['HeadersText'], PDO::PARAM_STR);
                $stmt->bindParam(':TableId', $data['TableId'], PDO::PARAM_STR);
                // Execute query 
                $stmt->execute();
            } 
            //(ENd ) for Update 
            // (Start) for new entry 
            else {
                // Query to insert new entry 
                $sql = "INSERT INTO Maps (Name, Descriptions, MapType, DataSourceId, Fields, CustomSumFormula, Columns , CustomNameLabel ,HeadersText, TableId)
                    VALUES (:Name, :Descriptions, :MapType, :DataSourceId, :Fields, :CustomSumFormula, :Columns , :CustomNameLabel , :HeadersText, :TableId)";
                  // Prepare a query to bind parameter 
                $stmt = $db->prepare($sql);
                // Parameter Binding
                $stmt->bindParam(':Name', $data['Name'], PDO::PARAM_STR);
                $stmt->bindParam(':Descriptions', $data['Descriptions'], PDO::PARAM_STR);
                $stmt->bindParam(':MapType', $data['MapType'], PDO::PARAM_STR);
                $stmt->bindParam(':DataSourceId', $data['DataSourceId'], PDO::PARAM_STR);
                $stmt->bindParam(':Fields', $data['Fields'], PDO::PARAM_STR);
                $stmt->bindParam(':CustomSumFormula', $data['CustomSumFormula'], PDO::PARAM_STR);
                $stmt->bindParam(':Columns', $data['Columns'], PDO::PARAM_STR);
                $stmt->bindParam(':CustomNameLabel', $data['CustomNameLabel'], PDO::PARAM_STR);
                $stmt->bindParam(':HeadersText', $data['HeadersText'], PDO::PARAM_STR);
                $stmt->bindParam(':TableId', $data['TableId'], PDO::PARAM_STR);
                 // Execute query 
                $stmt->execute();
            }

        } catch (PDOException $e) {
        }
        return;
    }

}