<?php

namespace App\Models;

use PDO;

/**
 * Addresses user model

 */
class Addresses extends \Core\Model
{
    /**
     * Get all the Address  as an associative array
     *
     * @return array
     */
    // Get all Addresses
    public static function getAllAddress()
    {
        // Make connection with DB 
        $db = static::getDB();
        // Query to fetch all Data 
        $sql = "SELECT * FROM Address"; 
        // Excute the Query 
        $stmt = $db->query($sql);
        // Fetch all Data 
        $data = $stmt->fetchAll();
        return $data;
    }

     // Get Specific Addresses
    public static function getAddress($id)
    {
         // Make connection with DB 
        $db = static::getDB();
        // Query to Fetch specific ID Data 
        $sql = "SELECT * FROM Address where ID = '".$id."'";
        // Excute The query 
        $stmt = $db->query($sql);
        // Fetch all Data 
        $data = $stmt->fetchAll();
        return $data;
    }

    //  Save  Or edit  Addresses
    public static function saveAddress()
    {
        // Make connection with DB 
        $db = static::getDB();
        // (Start)  For update 
        if (isset($_REQUEST['ID']) && !empty($_REQUEST['ID'])) {
            // Query for Update Specfic record
            $sql = "UPDATE Address SET Address = :Address , AddressName =:AddressName WHERE ID= :ID";
            // Prepare the query as we need to bind the data to column names 
            $stmt = $db->prepare($sql); 
            // binding the parameter (Columns) with their values 
            $stmt->bindParam(':ID', $_REQUEST['ID'], PDO::PARAM_STR);
            $stmt->bindParam(':Address', $_REQUEST['Address'], PDO::PARAM_STR);
            $stmt->bindParam(':AddressName', $_REQUEST['AddressName'], PDO::PARAM_STR);
            // Excute the Query 
            $stmt->execute();

        }
        //(End)For Update 
        //(Start) For New Entry 
        else{
            // Query to create a new entry 
            $sql = "INSERT INTO Address(Address, DateCreated , AddressName) VALUES (:Address, :DateCreated, :AddressName)";
            // Current Date
            $currDate = date('Y-m-d');
            // Prepare the query as we need to bind the data to column names 
            $stmt = $db->prepare($sql);
            // binding the parameter (Columns) with their values 
            $stmt->bindParam(':Address', $_REQUEST['Address'], PDO::PARAM_STR);
            $stmt->bindParam(':DateCreated', $currDate, PDO::PARAM_STR);
            $stmt->bindParam(':AddressName', $_REQUEST['AddressName'], PDO::PARAM_STR);
            // Excute the Query 
            $stmt->execute();
           
        }
         //(End) For New Entry 
        return true;
    }

    // Delete Address
    public static function deleteAddress($id)
    {
        // Make connection with DB 
        $db = static::getDB();
        // Query to Dete a record 
        $sql = "DELETE FROM Address WHERE ID = ?";
        // Preapre the query 
        $q = $db->prepare($sql);
        // Excute the Query 
        $response = $q->execute(array($id));
        return $response;
    }
}