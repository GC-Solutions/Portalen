<?php

namespace App\Models;

use PDO;

/**
 * Example user model
 *
 * PHP version 7.0
 */
class TwoTables extends \Core\Model
{

    /**
     * Get all the users as an associative array
     *
     * @return array
     */
    // Get all TwoTables
    public static function getAllTwoTables()
    {
        $db = static::getDB();
        $sql = "SELECT * FROM TwoTables";
        $stmt = $db->query($sql);
        $data = $stmt->fetchAll();
        return $data;
    }

     // Get Specific Two Tables
    public static function getTwoTable($id)
    {
        $db = static::getDB();
        $sql = "SELECT * FROM TwoTables where ID = '".$id."'";
        $stmt = $db->query($sql);
        $data = $stmt->fetchAll();

        return $data;
    }

    //  Save  Or edit TwoTables
    public static function saveTwoTables()
    {
        $db = static::getDB();

        if (isset($_REQUEST['id']) && !empty($_REQUEST['id'])) {
           
            $sql = "UPDATE TwoTables SET Name = :Name, Description = :Description , commonField = :commonField, TableId = :TableId , TablePageId = :TablePageId WHERE ID= :ID";
            
            $stmt = $db->prepare($sql);
            $stmt->bindParam(':ID', $_REQUEST['id'], PDO::PARAM_STR);
            $stmt->bindParam(':Name', $_REQUEST['Name'], PDO::PARAM_STR);
            $stmt->bindParam(':Description',$_REQUEST['Description'], PDO::PARAM_STR);
            $stmt->bindParam(':commonField', $_REQUEST['commonField'], PDO::PARAM_STR);
            $stmt->bindParam(':TableId', $_REQUEST['TableId'], PDO::PARAM_STR);
            $stmt->bindParam(':TablePageId', $_REQUEST['TablePageId'], PDO::PARAM_STR);
           
            $stmt->execute();

        }else{

            $sql = "INSERT INTO TwoTables(Name, Description , commonField, TableId , TablePageId) VALUES (:Name, :Description, :commonField, :TableId , :TablePageId)";

           
            $stmt = $db->prepare($sql);
            $stmt->bindParam(':Name', $_REQUEST['Name'], PDO::PARAM_STR);
            $stmt->bindParam(':Description',$_REQUEST['Description'], PDO::PARAM_STR);
            $stmt->bindParam(':commonField', $_REQUEST['commonField'], PDO::PARAM_STR);
            $stmt->bindParam(':TableId', $_REQUEST['TableId'], PDO::PARAM_STR);
            $stmt->bindParam(':TablePageId', $_REQUEST['TablePageId'], PDO::PARAM_STR);
            
            $stmt->execute();
           
        }
        return;
    }

    // Delete Address
    public static function deleteTable($id)
    {
        $db = static::getDB();
        $sql = "DELETE FROM TwoTables WHERE ID = ?";
        $q = $db->prepare($sql);
        $response = $q->execute(array($id));
        return $response;
    }
}