<?php

namespace App\Models;

use PDO;

/**
 * MongoTable model
 *
 * PHP version 7.0
 */
class MongoTable extends \Core\Model
{
    //(Start) function to add or edit new custom table for extra info 
    public static function addMongoTable($data)
    {
        try {
            // Make Connection with DB 
            $db = static::getDB();
            // (Start) For Update 
            if (isset($data['id']) && !empty($data['id'])) {
                // Query to update  record 
                $sql = "UPDATE MongoTables SET Name = :Name, Description = :Description, RelatedDataTables = :RelatedDataTables, DetailColumns = :DetailColumns,
                        DateUpdated = :DateUpdated WHERE ID = :ID";
                $date =  date('Y-m-d'); // Current Date
                // Prepare query to bind parameter 
                $stmt = $db->prepare($sql);
                // Parameter binding
                $stmt->bindParam(':ID', $data['id'], PDO::PARAM_STR);
                $stmt->bindParam(':Name', $data['Name'], PDO::PARAM_STR);
                $stmt->bindParam(':Description', $data['Description'], PDO::PARAM_STR);
                $stmt->bindParam(':DetailColumns', $data['DetailColumns'], PDO::PARAM_STR);
                $stmt->bindParam(':RelatedDataTables', $data['RelatedDataTables'], PDO::PARAM_STR);
                $stmt->bindParam(':DateUpdated', $date, PDO::PARAM_STR);
               // Excute Query 
                $stmt->execute();
            }
            //(End) For Update
            //(Start) FOr new Entry 
             else {
                // Query to Add a new record 
                $sql = "INSERT INTO MongoTables (Name, Description, DetailColumns , RelatedDataTables , DateCreated , DateUpdated )
                    VALUES (:Name, :Description, :DetailColumns , :RelatedDataTables , :DateCreated , :DateUpdated)";
                $date =  date('Y-m-d'); // Current Date 
                // Prepare query to bind Parameter with value 
                $stmt = $db->prepare($sql);
                // Parameter Binding 
                $stmt->bindParam(':Name', $data['Name'], PDO::PARAM_STR);
                $stmt->bindParam(':Description', $data['Description'], PDO::PARAM_STR);
                $stmt->bindParam(':DetailColumns', $data['DetailColumns'], PDO::PARAM_STR);
                $stmt->bindParam(':RelatedDataTables', $data['RelatedDataTables'], PDO::PARAM_STR);
                $stmt->bindParam(':DateCreated', $date, PDO::PARAM_STR);
                $stmt->bindParam(':DateUpdated', $date, PDO::PARAM_STR);
                // Execute Query 
                $stmt->execute();
            }
             //(End) FOr new Entry 
        } catch (PDOException $e) {
        }
        return;
    }
    // (Start) Function to fetch specfic table by related table as where condition .
    public static function getMongotable($id)
    {
         // Make Connection with DB 
        $db = static::getDB();
        // condition and parameter value variable initialtion 
         if (!empty($id)) {
            $conditions[] = 'RelatedDataTables = ?';
            $parameters[] = $id;
        }
        // Query to fetch data 
        $sql = "SELECT * FROM MongoTables";
        // Apply where condition 
        if ($conditions) {
            $sql .= " WHERE " . implode(" AND ", $conditions);
        }
        // Prepare Quer for parameter binding 
        $stmt = $db->prepare($sql);
        // Execute query 
        $stmt->execute($parameters);
        // Fetch Data 
        $data = $stmt->fetchAll();
        return $data;

    }
     // (Start) Function to fetch specfic table by ID as where condition .
    public static function getMongotableByID($id)
    {
         // Make Connection with DB 
        $db = static::getDB();
         // condition and parameter value variable initialtion 
         if (!empty($id)) {
            $conditions[] = 'ID = ?';
            $parameters[] = $id;
        }
         // Query to fetch data 
        $sql = "SELECT * FROM MongoTables";
         // Apply where condition 
        if ($conditions) {
            $sql .= " WHERE " . implode(" AND ", $conditions);
        }
        // Prepare Query for parameter binding 
        $stmt = $db->prepare($sql);
        // Execute query 
        $stmt->execute($parameters);
        // Fetch Data 
        $data = $stmt->fetchAll();
        return $data;
    }
    // (Start) Function to Delete a table 
    public static function deleteMongoTable($id)
    {
        // Make Connection with DB 
        $db = static::getDB();
        //Query to Delete a specfic record 
        $sql = "DELETE FROM MongoTables WHERE ID = '". $id."'";
        // Prepare Query for parameter binding 
        $q = $db->prepare($sql);
        //execute query 
        $response = $q->execute();
        return $response;
    }

}