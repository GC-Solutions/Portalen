<?php

namespace App\Models;

use PDO;

/**
 * Parameter model
 *
 * PHP version 7.0
 */
class Parameter extends \Core\Model
{

    /**
     * Get all the Parameter as an associative array
     *
     * @return array
     */


    // delete Parameters 
    public static function deleteParam($id)
    {
        // Make Connection WIth DB 
        $db = static::getDB();
        // Query for Delete Specfic record 
        $sql = "DELETE FROM Parameters WHERE id = '".$id."'";
        // Prepare Query to Bind Parameter with Value 
        $q = $db->prepare($sql);
        // Execute QUery 
        $response = $q->execute();
        return $response;
    }
    // get All  Parameters 
    public static function getAllParameter()
    {
        // Make Connection WIth DB 
        $db = static::getDB();
        // Query to fetch Data 
        $sql = "SELECT * FROM Parameters";
        // Execute Query 
        $stmt = $db->query($sql);
        // Fetch all Data 
        $data = $stmt->fetchAll();
        return $data;
    }
    // get Specific Parameters 
    public static function getParameter($paramId)
    {
        // Make Connection WIth DB 
        $db = static::getDB();
        // fetch specfic data Query 
        $sql = "SELECT * FROM Parameters where id = '".$paramId."'";
        // Execute Query
        $stmt = $db->query($sql);
        // Fetch Data 
        $data = $stmt->fetchAll();
        return $data;
    }
    // FUnction to add new Parameter or edit a Old one.
    public static function addParameter()
    {
        // Make Connection With DB
        $db = static::getDB();
        //(Start) For Update 
        if (isset($_REQUEST['id']) && !empty($_REQUEST['id'])) {
           // Query for Update Query 
            $sql = "UPDATE Parameters SET ParamName = :ParamName, ParamValue = :ParamValue, ParamType = :ParamType, DateUpdated = :DateUpdated WHERE id = :id";
            $currDate = date('Y-m-d'); // Current Date 
            $_REQUEST['ParamType'] = 'Global';
            // Perpare query to bind parameter 
            $stmt = $db->prepare($sql);
            // Parameter Binding 
            $stmt->bindParam(':id', $_REQUEST['id'], PDO::PARAM_STR);
            $stmt->bindParam(':ParamName', $_REQUEST['ParamName'], PDO::PARAM_STR);
            $stmt->bindParam(':ParamValue', $_REQUEST['ParamValue'], PDO::PARAM_STR);
            $stmt->bindParam(':ParamType', $_REQUEST['ParamType'], PDO::PARAM_STR);
            $stmt->bindParam(':DateUpdated', $currDate, PDO::PARAM_STR);
            // Execute Query 
            $stmt->execute();
        }else{
            // Query to insert Data 
            $sql = "INSERT INTO Parameters(ParamName,ParamValue,ParamType,DateCreated, DateUpdated) VALUES (:ParamName,:ParamValue,               :ParamType,:DateCreated,:DateUpdated)";
            $currDate = date('Y-m-d'); // Current Date 
            $_REQUEST['ParamType'] = 'Global';
            // Prepare query to bind parameter 
            $stmt = $db->prepare($sql);
            // Parameter Binding 
            $stmt->bindParam(':ParamName', $_REQUEST['ParamName'], PDO::PARAM_STR);
            $stmt->bindParam(':ParamValue', $_REQUEST['ParamValue'], PDO::PARAM_STR);
            $stmt->bindParam(':ParamType', $_REQUEST['ParamType'], PDO::PARAM_STR);
            $stmt->bindParam(':DateCreated', $currDate, PDO::PARAM_STR);
            $stmt->bindParam(':DateUpdated', $currDate, PDO::PARAM_STR);
            // Execute Query 
            $stmt->execute();
        }
        return;
    }
}
