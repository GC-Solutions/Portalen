<?php

namespace App\Models;

use PDO;

/**
 * AccessPagePlaceholders model
 *
 * PHP version 7.0
 */
class AccessPagePlaceholders extends \Core\Model
{
    //(Start) Function for fetching specfic user specfic page panels 
    public static function getUserAccessPagePanels($userPageAccessId)
    {
        try {
            // Make Connection with DB 
            $db = static::getDB();
            // Query to fetch data 
            // this query has Inner join with  UserPagePlaceholders .
            $sql = "select UserPagePlaceholders.ID, Panels.Name, UserPagePlaceholders.PlaceholderValue ,UserPagePlaceholders.PlaceholderId,Panels.DataSourceId
                    FROM Panels, UserPagePlaceholders
                    WHERE Panels.ID = UserPagePlaceholders.PlaceholderId AND UserPagePlaceholders.PlaceholderType = 1 AND UserPagePlaceholders.UserPageAccessId ='" . $userPageAccessId . "'";
            // Preapre query to bind parameter with Value 
            $stmt = $db->prepare($sql);
            //Execute Query 
            $stmt->execute();
            // Fetch all Data 
            $data = $stmt->fetchAll();
            return $data;

        } catch (PDOException $e) {
        }
    }
    //(Start) Function for fetching specfic user specfic page Data Tables 
    public static function getUserAccessPageTables($userPageAccessId)
    {
        try {
             // Make Connection with DB 
            $db = static::getDB();
            // Query to fetch data 
            // this query has Inner join with  UserPagePlaceholders .
            $sql = "select UserPagePlaceholders.ID, Tables.Name, UserPagePlaceholders.PlaceholderValue,UserPagePlaceholders.PlaceholderId,Tables.DataSourceId
                    FROM Tables, UserPagePlaceholders
                    WHERE Tables.ID = UserPagePlaceholders.PlaceholderId AND UserPagePlaceholders.PlaceholderType = 2 AND UserPagePlaceholders.UserPageAccessId ='" . $userPageAccessId . "'";
             // Prepare Query to bind value with parameter 
            $stmt = $db->prepare($sql);
            // Execute Query 
            $stmt->execute();
            // Fetch all Data 
            $data = $stmt->fetchAll();
            return $data;

        } catch (PDOException $e) {
        }
    }
     //(Start) Function for fetching specfic user specfic page Graphs 
    public static function getUserAccessPageGraphs($userPageAccessId)
    {
        try {
             // Make Connection with DB 
            $db = static::getDB();
            // Query to fetch data 
            // this query has Inner join with  UserPagePlaceholders .
            $sql = "select UserPagePlaceholders.ID, Graphs.Name, UserPagePlaceholders.PlaceholderValue,UserPagePlaceholders.PlaceholderId,Graphs.DataSourceId
                    FROM Graphs, UserPagePlaceholders
                    WHERE Graphs.ID = UserPagePlaceholders.PlaceholderId AND UserPagePlaceholders.PlaceholderType = 3 AND UserPagePlaceholders.UserPageAccessId ='" . $userPageAccessId . "'";
             // Prepare Query to bind value with parameter 
            $stmt = $db->prepare($sql);
             // Execute Query 
            $stmt->execute();
            // Fetch all Data 
            $data = $stmt->fetchAll();
            return $data;

        } catch (PDOException $e) {
        }
    }
     //(Start) Function for fetching specfic user specfic page Maps
    public static function getUserAccessPageMaps($userPageAccessId)
    {
        try {
             // Make Connection with DB 
            $db = static::getDB();
            // Query to fetch data 
            // this query has Inner join with  UserPagePlaceholders .
            $sql = "select UserPagePlaceholders.ID, Maps.Name, UserPagePlaceholders.PlaceholderValue,UserPagePlaceholders.PlaceholderId,Maps.DataSourceId
                    FROM Maps, UserPagePlaceholders
                    WHERE Maps.ID = UserPagePlaceholders.PlaceholderId AND UserPagePlaceholders.PlaceholderType = '4' AND UserPagePlaceholders.UserPageAccessId ='" . $userPageAccessId . "'";
            // Prepare Query to bind value with parameter 
            $stmt = $db->prepare($sql);
             // Execute Query 
            $stmt->execute();
            // Fetch all Data 
            $data = $stmt->fetchAll();
            return $data;

        } catch (PDOException $e) {
        }
    }
     //(Start) Function for fetching specfic user specfic page Piechart
    public static function getUserAccessPagePieCharts($userPageAccessId)
    {
        try {
             // Make Connection with DB 
            $db = static::getDB();
            // Query to fetch data 
            // this query has Inner join with  UserPagePlaceholders .
            $sql = "select UserPagePlaceholders.ID,PieCharts.Name,UserPagePlaceholders.PlaceholderValue,UserPagePlaceholders.PlaceholderId,PieCharts.DataSourceId
                FROM PieCharts, UserPagePlaceholders 
                WHERE PieCharts.ID = UserPagePlaceholders.PlaceholderId AND UserPagePlaceholders.PlaceholderType = '5' AND UserPagePlaceholders.UserPageAccessId ='" . $userPageAccessId . "'";
             // Prepare Query to bind value with parameter 
            $stmt = $db->prepare($sql);
             // Execute Query 
            $stmt->execute();
            // Fetch all Data 
            $data = $stmt->fetchAll();
            return $data;

        } catch (PDOException $e) {
        }
    }
     //(Start) Function for fetching specfic user specfic page  Send order 
    public static function getUserAccessPageSendOrder($userPageAccessId)
    {
        try {
             // Make Connection with DB 
            $db = static::getDB();
            // Query to fetch data 
            // this query has Inner join with  UserPagePlaceholders .
            $sql = "select UserPagePlaceholders.ID,SendOrders.Name,UserPagePlaceholders.PlaceholderValue,UserPagePlaceholders.PlaceholderId,SendOrders.DataSourceId
                FROM SendOrders, UserPagePlaceholders WHERE SendOrders.ID = UserPagePlaceholders.PlaceholderId AND UserPagePlaceholders.PlaceholderType = '7' AND UserPagePlaceholders.UserPageAccessId ='" . $userPageAccessId . "'";
             // Prepare Query to bind value with parameter 
            $stmt = $db->prepare($sql);
             // Execute Query 
            $stmt->execute();
            // Fetch all Data 
            $data = $stmt->fetchAll();
            return $data;

        } catch (PDOException $e) {
        }
    }
     //(Start) Function for fetching specfic user specfic page product table 
    public static function getUserAccessPageReadData($userPageAccessId)
    {
        try {
             // Make Connection with DB 
            $db = static::getDB();
            // Query to fetch data 
            // this query has Inner join with  UserPagePlaceholders .
            $sql = "select UserPagePlaceholders.ID,MongoTables.Name,UserPagePlaceholders.PlaceholderValue,UserPagePlaceholders.PlaceholderId
                FROM MongoTables, UserPagePlaceholders WHERE MongoTables.ID = UserPagePlaceholders.PlaceholderId AND UserPagePlaceholders.PlaceholderType = '8' AND UserPagePlaceholders.UserPageAccessId ='" . $userPageAccessId . "'";
            // Prepare Query to bind value with parameter 
            $stmt = $db->prepare($sql);
            // Execute Query 
            $stmt->execute();
            // Fetch all Data 
            $data = $stmt->fetchAll();
            return $data;

        } catch (PDOException $e) {
        }
    }

}