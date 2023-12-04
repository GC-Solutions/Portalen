<?php

namespace App\Models;

use PDO;

/**
 * Page Template model
 *
 * PHP version 7.0
 */
class PageTemplates extends \Core\Model
{
    /**
     * Get all the Pages template  as an associative array
     *
     * @return array
     */
    // This function Return all the Pages being created now from Pages tableDB.
    public static function getPages()
    {
        // Make Connection With DB 
        $db = static::getDB();
        // QUery to fetch all Data from DB 
        $sql = "SELECT * FROM Pages";
        // Execute Query 
        $stmt = $db->query($sql);
        // Fetch All data 
        $data = $stmt->fetchAll();
        return $data;
    }
    // This function Return detail of specfic page from DB.
    public static function getPageDetails($id)
    {
        // Condition that add the ID and value to parameter if ID is given 
        if (!empty($id)) {
            $conditions[] = 'ID = ?';
            $parameters[] = $id;
        }
        // Query 
        $sql = "SELECT * FROM Pages";
        // Concatnating Where Clause
        if ($conditions) {
            $sql .= " WHERE " . implode(" AND ", $conditions);
        }
        // Make Connection with DB
        $db = static::getDB();
        // Preprea Query to bind value with parameter 
        $stmt = $db->prepare($sql);
        // Execute QUery 
        $stmt->execute($parameters);
        // Fetch All Data 
        $data = $stmt->fetchAll();
        return $data;
    }
    // This function Add new pages As well as Edit pages too .
    public static function savePage()
    {
        // Make Connection with DB
        $db = static::getDB();
        //(Start) For Update 
        if(!empty($_REQUEST['id'])){
            // Query to Update 
            $sql = "UPDATE Pages SET PageText = :PageText,
            PageFilename = :PageFilename,
            PageDescription = :PageDescription,
            PagePanels = :PagePanels
            WHERE ID = :ID";
            try{ 
                // Prepare Query to bind parameter
                $stmt = $db->prepare($sql);
                // Parameter Binding 
                $stmt->bindParam(':PageText', $_REQUEST['PageText'], PDO::PARAM_STR);
                $stmt->bindParam(':PageFilename', $_REQUEST['PageFilename'], PDO::PARAM_STR);
                $stmt->bindParam(':PageDescription', $_REQUEST['PageDescription'], PDO::PARAM_STR);
                $stmt->bindParam(':PagePanels', $_REQUEST['PagePanels'], PDO::PARAM_STR);
                $stmt->bindParam(':ID', $_REQUEST['id'], PDO::PARAM_INT);
                // Excute Query 
                $stmt->execute();
            }catch (Exception $exc){
            }
        }
        //(End) FOr Update 
        //(Start) FOr new ENtry  
        else {
            // Query to insert 
            $sql = "INSERT INTO Pages(PageText,PageFilename,PageDescription,PagePanels)
                    VALUES (:PageText,:PageFilename,:PageDescription,:PagePanels)";
            // // Prepare Query to bind parameter with value
            $stmt = $db->prepare($sql);
            // Parameter Binding
            $stmt->bindParam(':PageText', $_REQUEST['PageText'], PDO::PARAM_STR);
            $stmt->bindParam(':PageFilename', $_REQUEST['PageFilename'], PDO::PARAM_STR);
            $stmt->bindParam(':PageDescription', $_REQUEST['PageDescription'], PDO::PARAM_STR);
            $stmt->bindParam(':PagePanels', $_REQUEST['PagePanels'], PDO::PARAM_STR);
            //Execute Query 
            $stmt->execute();
        }
         //(End) For new ENtry  
        return;
    }
    // this Function delete Pages from DB.
    public static function deletePage($id)
    {
        // Make Connection with DB 
        $db = static::getDB();
        // Query to delete specfic Page 
        $sql = "DELETE FROM Pages WHERE ID = ?";
        // Perpare Query to bind parameter with Value 
        $q = $db->prepare($sql);
        // Excute Query 
        $response = $q->execute(array($id));
        return $response;
    }
}
