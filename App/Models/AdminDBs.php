<?php

namespace App\Models;

use PDO;

/**
 * AdminDB  model
 *
 * PHP version 7.0
 */
class AdminDBs extends \Core\Model
{
    /**
     * Get all the data  as an associative array
     *
     * @return array
     */
    // Get all AdminDB
    public static function getAllAdminDB()
    {
        // Make Connection with DB 
        $db = static::getDB();
        // Query to Fetch all data 
        $sql = "SELECT * FROM AdminDB";
        // Excute Query 
        $stmt = $db->query($sql);
        // Fetch All data 
        $data = $stmt->fetchAll();
        return $data;
    }

     // Get Specific Addresses
    public static function getAdminDB($id)
    {
        // Make Connection With DB 
        $db = static::getDB();
        // Query to get spoecfic Data 
        $sql = "SELECT * FROM AdminDB where ID = '".$id."'";
          // Excute Query 
        $stmt = $db->query($sql);
        // Fetch Data 
        $data = $stmt->fetchAll();
        return $data;
    }

    //  Save  Or edit  Admin DB
    public static function saveAdminDB()
    {
        // Make Connection with DB 
        $db = static::getDB();
        // (Start) For Update 
        if (isset($_REQUEST['ID']) && !empty($_REQUEST['ID'])) {
            //Query 
            $sql = "UPDATE AdminDB SET Name = :Name , HostName = :HostName , DBName = :DBName, Username = :Username , DBPassword = :DBPassword , DBType=:DBType   WHERE ID= :ID";
            // Preapre Squery to bind data 
            $stmt = $db->prepare($sql);
            // Binding parameter(Column ) with values 
            $stmt->bindParam(':Name', $_REQUEST['Name'], PDO::PARAM_STR);
            $stmt->bindParam(':HostName', $_REQUEST['HostName'], PDO::PARAM_STR);
            $stmt->bindParam(':DBName', $_REQUEST['DBName'], PDO::PARAM_STR);
            $stmt->bindParam(':Username', $_REQUEST['Username'], PDO::PARAM_STR);
            $stmt->bindParam(':DBPassword', $_REQUEST['DBPassword'], PDO::PARAM_STR);
            $stmt->bindParam(':DBType', $_REQUEST['DBType'], PDO::PARAM_STR);
            $stmt->bindParam(':ID', $_REQUEST['ID'], PDO::PARAM_STR);
            // Execute QUery 
            $stmt->execute();

        }
        //(End) FOr Update
        //(Start ) for Insert new ENtry 
        else{
            // Query 
            $sql = "INSERT INTO AdminDB(Name, HostName, DBName, Username , DBPassword, DBType) VALUES (:Name, :HostName, :DBName, :Username , :DBPassword, :DBType)";
            // Preapre query to bind data .
            $stmt = $db->prepare($sql);
             // Binding parameter(Column ) with values 
            $stmt->bindParam(':Name', $_REQUEST['Name'], PDO::PARAM_STR);
            $stmt->bindParam(':HostName', $_REQUEST['HostName'], PDO::PARAM_STR);
            $stmt->bindParam(':DBName', $_REQUEST['DBName'], PDO::PARAM_STR);
            $stmt->bindParam(':Username', $_REQUEST['Username'], PDO::PARAM_STR);
            $stmt->bindParam(':DBPassword', $_REQUEST['DBPassword'], PDO::PARAM_STR);
            $stmt->bindParam(':DBType', $_REQUEST['DBType'], PDO::PARAM_STR);
            // Execute QUery 
            $stmt->execute();
        }
         //(End) for Insert new ENtry 
        return;
    }
    // Delete AdminDB
    public static function deleteAdminDB($id)
    {
        // Make Connection with DB
        $db = static::getDB();
        // Query 
        $sql = "DELETE FROM AdminDB WHERE ID = ?";
          // Preapre query .
        $q = $db->prepare($sql);
        // Execute Query 
        $response = $q->execute(array($id));
        return $response;
    }
}