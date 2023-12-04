<?php

namespace App\Models;

use PDO;

/**
 * Push Notification Model
 *
 * PHP version 7.0
 */
class PushNotifications extends \Core\Model
{
    // Get all Push Notification
    public static function getAllPushNotification()
    {
        $db = static::getDB();
        $sql = "SELECT * FROM PushNotification";
        $stmt = $db->query($sql);
        $data = $stmt->fetchAll();
        return $data;
    }

    // Get Specific Push Notification
    public static function getPushNotification($id)
    {
        $db = static::getDB();
        $sql = "SELECT * FROM PushNotification where ID = '".$id."'";
        $stmt = $db->query($sql);
        $data = $stmt->fetchAll();

        return $data;
    }
    public static function addNotification($data){
    try {
        // Make Connection WIth DB 
        $db = static::getDB();
        //(Start) For Update 
        if (isset($data['id']) && !empty($data['id'])) {
            // Query for Update 
            $sql = "UPDATE PushNotification SET Name = :Name, Descriptions = :Descriptions, TableID =:TableID,
              Conditions = :Conditions, MsgType = :MsgType , AllowPopUp = :AllowPopUp , PopUpDescriptions = :PopUpDescriptions WHERE ID = :ID";
              
            // Prepare query for binding parameter
            $stmt = $db->prepare($sql);
            // Parameter Binding 
            $stmt->bindParam(':ID', $data['id'], PDO::PARAM_STR);
            $stmt->bindParam(':Name', $data['Name'], PDO::PARAM_STR);
            $stmt->bindParam(':Descriptions', $data['Descriptions'], PDO::PARAM_STR);
            $stmt->bindParam(':TableID', $data['TableID'], PDO::PARAM_STR);
            $stmt->bindParam(':Conditions', $data['Conditions'], PDO::PARAM_STR);
            $stmt->bindParam(':MsgType', $data['MsgType'], PDO::PARAM_STR);
            $stmt->bindParam(':AllowPopUp', $data['AllowPopUp'], PDO::PARAM_STR);
            $stmt->bindParam(':PopUpDescriptions', $data['PopUpDescriptions'], PDO::PARAM_STR);
           
            // Execute Query 
            $stmt->execute();
        }
        //(End) FOr Update 
        //(Start) For new Entry  
        else {
            // Query 
            
            $sql = "INSERT INTO PushNotification (Name, Descriptions, TableID, Conditions, MsgType, AllowPopUp, PopUpDescriptions)
            VALUES (:Name, :Descriptions, :TableID, :Conditions, :MsgType, :AllowPopUp, :PopUpDescriptions )";

            // Prepare query for binding parameter
            $stmt = $db->prepare($sql);
            // Parameter Binding 
            $stmt->bindParam(':Name', $data['Name'], PDO::PARAM_STR);
            $stmt->bindParam(':Descriptions', $data['Descriptions'], PDO::PARAM_STR);
            $stmt->bindParam(':TableID', $data['TableID'], PDO::PARAM_STR);
            $stmt->bindParam(':Conditions', $data['Conditions'], PDO::PARAM_STR);
            $stmt->bindParam(':MsgType', $data['MsgType'], PDO::PARAM_STR);
            $stmt->bindParam(':AllowPopUp', $data['AllowPopUp'], PDO::PARAM_STR);
            $stmt->bindParam(':PopUpDescriptions', $data['PopUpDescriptions'], PDO::PARAM_STR);

            // Excute Query 
            $stmt->execute();
        }
        //(ENd ) For new Entry 

    } catch (PDOException $e) {
    }
    return;
}

}