<?php

namespace App\Models;

use PDO;

/**
 * DataTable Design  model
 *
 * PHP version 7.0
 */
class DataTableDesigns extends \Core\Model
{

    /**
     * Get all the dataTable Design data  as an associative array
     *
     * @return array
     */
    // Get all FIlter
    public static function getAllFilter()
    {
        // Make Connection with DB 
        $db = static::getDB();
        // Query to fetch all Data 
        $sql = "SELECT * FROM TableDesign";
        // Execute Query 
        $stmt = $db->query($sql);
        // Fetch All Data 
        $data = $stmt->fetchAll();
        return $data;
    }

     // Get Specific Filter
    public static function getFilter($id)
    {
        // Make Connection with DB
        $db = static::getDB();
        // Query to fetch data for Specfic record 
        $sql = "SELECT * FROM  TableDesign where ID = '".$id."'";
        // Execute Query 
        $stmt = $db->query($sql);
         // Fetch All Data 
        $data = $stmt->fetchAll();
        return $data;
    }
    //  Save  Or edit  filter
    public static function saveFilter()
    {
         // Make Connection with DB
        $db = static::getDB();
        //(Start) For Update 
        if (isset($_REQUEST['ID']) && !empty($_REQUEST['ID'])) {
            // Query to update
            $sql = "UPDATE TableDesign SET FilterWidth = :FilterWidth , MaxFIlterWidth = :MaxFIlterWidth   WHERE ID= :ID";
            $date = date('Y-m-d'); // Current Date 
            // Prepare query to bind value to parameter 
            $stmt = $db->prepare($sql);
            // Parameter Binding 
            $stmt->bindParam(':FilterWidth', $_REQUEST['FilterWidth'], PDO::PARAM_STR);
            $stmt->bindParam(':MaxFIlterWidth', $_REQUEST['MaxFIlterWidth'], PDO::PARAM_STR);
            $stmt->bindParam(':ID', $_REQUEST['ID'], PDO::PARAM_STR);
            // Excute Query 
            $stmt->execute();
        }
        //(End) For Update 
        //(Start) For new ENtry 
        else{
            // Query to insert new record 
            $sql = "INSERT INTO TableDesign(FilterWidth, MaxFIlterWidth,  DateCreated) VALUES (:FilterWidth, :MaxFIlterWidth, :DateCreated)";
            $date = date('Y-m-d'); // CUrrent date 
            // Prepare Query to bind data 
            $stmt = $db->prepare($sql);
            // Parameter Binding 
            $stmt->bindParam(':FilterWidth', $_REQUEST['FilterWidth'], PDO::PARAM_STR);
            $stmt->bindParam(':MaxFIlterWidth', $_REQUEST['MaxFIlterWidth'], PDO::PARAM_STR);
            $stmt->bindParam(':DateCreated', $date, PDO::PARAM_STR);
            // Execute Query 
            $stmt->execute();
        }
         //(End) For new ENtry 
        return;
    }
    // Delete Filter
    public static function deleteFilter($id)
    {
        // Make Connection with DB
        $db = static::getDB();
        // Query to delete record 
        $sql = "DELETE FROM TableDesign WHERE ID = ?";
        // Prepare query to bind value to parameter 
        $q = $db->prepare($sql);
        // Excute Query 
        $response = $q->execute(array($id));
        return $response;
    }
}