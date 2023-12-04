<?php

namespace App\Models;

use PDO;

/**
 * Apis model
 *
 * PHP version 7.0
 */
class Apis extends \Core\Model
{
    //Function to Fetch All Api from DB
	public static function getAllAPI()
    {
        // Make Connection with DB 
        $db = static::getDB();
        // Query
        $sql = "SELECT * FROM API";
        // Excute Query 
        $stmt = $db->query($sql);
        // Fetch all Data 
        $data = $stmt->fetchAll();
        return $data;
    }
    //Function to Delete Specific Api from DB
    public static function deleteAPI($id)
    {
        // Make Connection with DB 
        $db = static::getDB();
        // QUery to delete specfic record 
        $sql = "DELETE FROM API WHERE ID = ?";
        // prepare query as need to bind a value to parameter .
        $q = $db->prepare($sql);
        // Excute Query .
        $response = $q->execute(array($id));
        return $response;
    }
    //Function to tHAT  Insert  and Update Api in DB
    public static function addAPI()
    {
        // Make Connection with DB 
        $db = static::getDB();
        //(Start) For Update 
        if (isset($_REQUEST['id']) && !empty($_REQUEST['id'])) {
           // QUery to update record on  DB 
            $sql = "UPDATE API SET APIUrl = :APIUrl, Tables = :Tables, RequestType = :RequestType, Authroization = :Authroization , DateUpadtes = :DateUpadtes , Fields= :Fields, showFocusPage=:showFocusPage , parameterFocusPage=:parameterFocusPage , PlaceholderActionIds=:PlaceholderActionIds , linkedApi=:linkedApi WHERE ID= :ID";
            $currDate = date('Y-m-d'); // CUrrent Date 
            // Prepare query to bind paramter to value .
            $stmt = $db->prepare($sql);
            // Binding parameter with value 
            $stmt->bindParam(':ID', $_REQUEST['id'], PDO::PARAM_STR);
            $stmt->bindParam(':APIUrl', $_REQUEST['APIUrl'], PDO::PARAM_STR);
            $stmt->bindParam(':Tables', $_REQUEST['Tables'], PDO::PARAM_STR);
            $stmt->bindParam(':RequestType', $_REQUEST['RequestType'], PDO::PARAM_STR);
            $stmt->bindParam(':Authroization' ,$_REQUEST['Authroization'], PDO::PARAM_STR);
            $stmt->bindParam(':Fields' , $_REQUEST['Fields'], PDO::PARAM_STR);
            $stmt->bindParam(':showFocusPage' , $_REQUEST['showFocusPage'], PDO::PARAM_STR);
            $stmt->bindParam(':parameterFocusPage' , $_REQUEST['parameterFocusPage'], PDO::PARAM_STR);
            $stmt->bindParam(':PlaceholderActionIds' , $_REQUEST['PlaceholderActionIds'], PDO::PARAM_STR);
            $stmt->bindParam(':linkedApi' , $_REQUEST['linkedApi'], PDO::PARAM_STR);
            $stmt->bindParam(':DateUpadtes', $currDate, PDO::PARAM_STR);
            // Execute Query 
            $stmt->execute();
        }
        //(End) For Update  
        //(Start) to Create new entry 
        else{
            // QUery to add a new entry in DB 
            $sql = "INSERT INTO API(APIUrl, Tables, RequestType, Authroization, DateCreated,  DateUpadtes , Fields , showFocusPage , parameterFocusPage , PlaceholderActionIds , linkedApi) VALUES (:APIUrl, :Tables, :RequestType, :Authroization, :DateCreated, :DateUpadtes , :Fields , :showFocusPage , :parameterFocusPage , :PlaceholderActionIds , :linkedApi )";
            $currDate = date('Y-m-d');// Current Time
            // Preapre Query to bind parameter with values 
            $stmt = $db->prepare($sql);
            // Parameter binding with values
            $stmt->bindParam(':APIUrl', $_REQUEST['APIUrl'], PDO::PARAM_STR);
            $stmt->bindParam(':Tables', $_REQUEST['Tables'], PDO::PARAM_STR);
            $stmt->bindParam(':RequestType', $_REQUEST['RequestType'], PDO::PARAM_STR);
            $stmt->bindParam(':Authroization' , $_REQUEST['Authroization'], PDO::PARAM_STR);
            $stmt->bindParam(':Fields' , $_REQUEST['Fields'], PDO::PARAM_STR);
            $stmt->bindParam(':showFocusPage' , $_REQUEST['showFocusPage'], PDO::PARAM_STR);
            $stmt->bindParam(':parameterFocusPage' , $_REQUEST['parameterFocusPage'], PDO::PARAM_STR);
            $stmt->bindParam(':PlaceholderActionIds' , $_REQUEST['PlaceholderActionIds'], PDO::PARAM_STR);
            $stmt->bindParam(':linkedApi' , $_REQUEST['linkedApi'], PDO::PARAM_STR);
            $stmt->bindParam(':DateCreated', $currDate, PDO::PARAM_STR);
            $stmt->bindParam(':DateUpadtes', $currDate, PDO::PARAM_STR);
            // Execute Query 
            $stmt->execute();
        }
        return;
    }
    //Function to that gets Specific Api from DB
    public static function getAPI($APIId)
    {
        // Make Connection with DB 
        $db = static::getDB();
        // Query to fetch specfic data 
        $sql = "SELECT * FROM API where ID = '".$APIId."'";
        // execute Query 
        $stmt = $db->query($sql);
        // Fetch all data 
        $data = $stmt->fetchAll();
        return $data;
    }
    //Function to that gets Specific Api from DB .
    // This function is different from Above as we gets the request type (Post or Get)
    public static function getSpecficAPI($APIURL , $RequestType)
    {
        // Make Connection with DB 
        $db = static::getDB();
         // Query to fetch specfic data with condition having id and request type
        $sql = "SELECT * FROM API where APIUrl = '".$APIURL."' and  RequestType = '".$RequestType."'";
         // execute Query 
        $stmt = $db->query($sql);
         // Fetch all data 
        $data = $stmt->fetchAll();
        return $data;
    }
}

?>