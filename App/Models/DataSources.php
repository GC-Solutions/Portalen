<?php

namespace App\Models;

use PDO;

/**
 * DataSource model
 *
 * PHP version 7.0
 */
class DataSources  extends \Core\Model
{
     // FUnction to FEtch all dataa SOurce of all types 
     public static function getAllDataSource()
     {
         // Make Connection WIth DB 
         $db = static::getDB();
         // Query to Fetch all Data 
         $sql = "SELECT * FROM DataSource";
         // Execute Query 
         $stmt = $db->query($sql);
         // Fetch All Data 
         $data = $stmt->fetchAll();
         return $data;
     }
      // FUnction to FEtch all dataa SOurce of all types 
      public static function getSpecficDataSource($id)
      {
          // Make Connection WIth DB 
          $db = static::getDB();
          // Query to Fetch all Data 
          $sql = "SELECT * FROM DataSource where ID = '".$id."'";
          // Execute Query 
          $stmt = $db->query($sql);
          // Fetch All Data 
          $data = $stmt->fetchAll();
          return $data;
      }
    // Add and Edit DataSource Call For DB 
    public static function addDataSource()
    {
        try {
            // Make COnnection with DB 
            $db = static::getDB();
            //(STart) for Update 
            if (isset($_REQUEST['id']) && !empty($_REQUEST['id'])) {
                // Query  for update Data source for DB call 
                $sql = "UPDATE DataSource SET Name = :Name, Descriptions = :Descriptions, SourceAddress = :SourceAddress, SourceAddress_2 = :SourceAddress_2,
                        RequestType = :RequestType, Body = :Body, Body_2 = :Body_2, updateDataSource = :updateDataSource , RequestType_2 = :RequestType_2 ,Columns = :Columns ,
                         Placeholder = :Placeholder, KeyColumn = :KeyColumn, ColumnsProperties = :ColumnsProperties , ApiType = :ApiType , DisplayColumnName = :DisplayColumnName ,
                          DBType = :DBType , ExternalAPIReq =:ExternalAPIReq , GetColumnName=:GetColumnName , GetValueName=:GetValueName , AllowCustomTable=:AllowCustomTable , customTable=:customTable , Headers=:Headers , columnNameDialog=:columnNameDialog WHERE ID = :ID";
                // Variable Declaration and Initialization    
                $body2 = (isset($_REQUEST['Body_2'])) ? $_REQUEST['Body_2'] : "";
                $sourceAddress2 = (isset($_REQUEST['SourceAddress_2'])) ? $_REQUEST['SourceAddress_2'] : "";
                $requestType2 = (isset($_REQUEST['RequestType_2'])) ? $_REQUEST['RequestType_2'] : "";
                $updateDataSource = (isset($_REQUEST['updateDataSource'])) ? $_REQUEST['updateDataSource'] : 0;
                $Headers = (isset($_REQUEST['Headers'])) ? $_REQUEST['Headers'] : '';
                $AllowCustomTable = '';
                $customTable = '';
                if(isset($_REQUEST['customTable']) && !empty($_REQUEST['customTable'])){
                    $AllowCustomTable = '1';
                    $_REQUEST['AllowCustomTable'] = '1';
                    $customTable = $_REQUEST['customTable'];
                }
                // Prepare Query to Bind Parameter with value . 
                $stmt = $db->prepare($sql);
                // Paramter binding with value 
                $stmt->bindParam(':ID', $_REQUEST['id'], PDO::PARAM_STR);
                $stmt->bindParam(':Name', $_REQUEST['Name'], PDO::PARAM_STR);
                $stmt->bindParam(':Descriptions', $_REQUEST['Descriptions'], PDO::PARAM_STR);
                $stmt->bindParam(':SourceAddress', $_REQUEST['SourceAddress'], PDO::PARAM_STR);
                $stmt->bindParam(':SourceAddress_2', $sourceAddress2, PDO::PARAM_STR);
                $stmt->bindParam(':RequestType', $_REQUEST['RequestType'], PDO::PARAM_STR);
                $stmt->bindParam(':RequestType_2', $requestType2, PDO::PARAM_STR);
                $stmt->bindParam(':updateDataSource', $updateDataSource, PDO::PARAM_INT);
                $stmt->bindParam(':Body', $_REQUEST['Body'], PDO::PARAM_STR);
                $stmt->bindParam(':Body_2', $body2, PDO::PARAM_STR);
                $stmt->bindParam(':Columns', $_REQUEST['Columns'], PDO::PARAM_STR);
                $stmt->bindParam(':Placeholder', $_REQUEST['Placeholder'], PDO::PARAM_STR);
                $stmt->bindParam(':KeyColumn', $_REQUEST['KeyColumn'], PDO::PARAM_STR);
                $stmt->bindParam(':ColumnsProperties', $_REQUEST['ColumnsProperties'], PDO::PARAM_STR);
                $stmt->bindParam(':ApiType', $_REQUEST['ApiType'], PDO::PARAM_STR);
                $stmt->bindParam(':DisplayColumnName', $_REQUEST['DisplayColumnName'], PDO::PARAM_STR);
                $stmt->bindParam(':DBType', $_REQUEST['DBType'], PDO::PARAM_STR);
                $stmt->bindParam(':ExternalAPIReq', $_REQUEST['ExternalAPIReq'], PDO::PARAM_STR);
                $stmt->bindParam(':GetColumnName', $_REQUEST['GetColumnName'], PDO::PARAM_STR);
                $stmt->bindParam(':GetValueName', $_REQUEST['GetValueName'], PDO::PARAM_STR);
                $stmt->bindParam(':AllowCustomTable', $_REQUEST['AllowCustomTable'], PDO::PARAM_STR);
                $stmt->bindParam(':customTable', $_REQUEST['customTable'], PDO::PARAM_STR);
                $stmt->bindParam(':Headers',  $Headers, PDO::PARAM_STR);
                $stmt->bindParam(':columnNameDialog',  $_REQUEST['columnNameDialog'], PDO::PARAM_STR);
                
                
                
                
                // Execute Query
                $stmt->execute();
            } else {
                // Query to insert new entry 
                $sql = "INSERT INTO DataSource (Name, Descriptions, SourceAddress, SourceAddress_2, RequestType, RequestType_2, Body, Body_2, Columns, Placeholder, KeyColumn, updateDataSource, ColumnsProperties, ApiType, DisplayColumnName, DBType, ExternalAPIReq , customTable , dbNewColumns , GetColumnName , GetValueName , AllowCustomTable , Headers , columnNameDialog)
                    VALUES (:Name, :Descriptions, :SourceAddress, :SourceAddress_2, :RequestType, :RequestType_2 ,:Body, :Body_2, :Columns, :Placeholder, :KeyColumn, :updateDataSource, :ColumnsProperties, :ApiType, :DisplayColumnName, :DBType, :ExternalAPIReq , :customTable , :dbNewColumns , :GetColumnName ,  :GetValueName, :AllowCustomTable , :Headers, :columnNameDialog)";
                 // Prepare Query to Bind Parameter with value . 
                $stmt = $db->prepare($sql);
                 // Variable Declaration and Initialization   
                $body2 = (isset($_REQUEST['Body_2'])) ? $_REQUEST['Body_2'] : "";
                $sourceAddress2 = (isset($_REQUEST['SourceAddress_2'])) ? $_REQUEST['SourceAddress_2'] : "";
                $requestType2 = (isset($_REQUEST['RequestType_2'])) ? $_REQUEST['RequestType_2'] : "";
                $updateDataSource = (isset($_REQUEST['updateDataSource'])) ? $_REQUEST['updateDataSource'] : 0;
                $Headers = (isset($_REQUEST['Headers'])) ? $_REQUEST['Headers'] : '';
                $AllowCustomTable = '';
                $customTable = '';
                if(isset($_REQUEST['customTable']) && !empty($_REQUEST['customTable'])){
                    $AllowCustomTable = '1';
                    $customTable = $_REQUEST['customTable'];
                }
                // Paramter binding with value 
                $stmt->bindParam(':Name', $_REQUEST['Name'], PDO::PARAM_STR);
                $stmt->bindParam(':Descriptions', $_REQUEST['Descriptions'], PDO::PARAM_STR);
                $stmt->bindParam(':SourceAddress', $_REQUEST['SourceAddress'], PDO::PARAM_STR);
                $stmt->bindParam(':SourceAddress_2', $sourceAddress2, PDO::PARAM_STR);
                $stmt->bindParam(':RequestType', $_REQUEST['RequestType'], PDO::PARAM_STR);
                $stmt->bindParam(':RequestType_2', $requestType2, PDO::PARAM_STR);
                $stmt->bindParam(':updateDataSource', $updateDataSource, PDO::PARAM_INT);
                $stmt->bindParam(':Body', $_REQUEST['Body'], PDO::PARAM_STR);
                $stmt->bindParam(':Body_2', $body2, PDO::PARAM_STR);
                $stmt->bindParam(':Placeholder', $_REQUEST['Placeholder'], PDO::PARAM_STR);
                $stmt->bindParam(':KeyColumn', $_REQUEST['KeyColumn'], PDO::PARAM_STR);
                $stmt->bindParam(':Columns', $_REQUEST['Columns'], PDO::PARAM_STR);
                $stmt->bindParam(':ColumnsProperties', $_REQUEST['ColumnsProperties'], PDO::PARAM_STR);
                $stmt->bindParam(':ApiType', $_REQUEST['ApiType'], PDO::PARAM_STR);
                $stmt->bindParam(':DisplayColumnName', $_REQUEST['DisplayColumnName'], PDO::PARAM_STR);
                $stmt->bindParam(':DBType', $_REQUEST['DBType'], PDO::PARAM_STR);
                $stmt->bindParam(':ExternalAPIReq', $_REQUEST['ExternalAPIReq'], PDO::PARAM_STR);
                $stmt->bindParam(':customTable', $_REQUEST['customTable'], PDO::PARAM_STR);
                $stmt->bindParam(':dbNewColumns', $_REQUEST['dbNewColumns'], PDO::PARAM_STR);
                $stmt->bindParam(':GetColumnName', $_REQUEST['GetColumnName'], PDO::PARAM_STR);
                $stmt->bindParam(':GetValueName', $_REQUEST['GetValueName'], PDO::PARAM_STR);
                $stmt->bindParam(':AllowCustomTable', $AllowCustomTable, PDO::PARAM_STR);
                $stmt->bindParam(':Headers', $Headers, PDO::PARAM_STR);
                $stmt->bindParam(':columnNameDialog', $_REQUEST['columnNameDialog'], PDO::PARAM_STR);

                
                // Execute Query
                $stmt->execute();
            }

        } catch (PDOException $e) {
        }
        return;
    }
    // Function to GEt all DataSOurce that Allow to create a Custom Table in DB 
    public static function getAllDataSourceEdit()
    {
        // Make COnnection with DB 
        $db = static::getDB();
        // Query to Fetch Data where Custom Table is present .
        $sql = "SELECT * FROM DataSource  where DBName != '' or AllowCustomTable = '1'";
        // Execute QUery 
        $stmt = $db->query($sql);
        // Fetch All Data 
        $data = $stmt->fetchAll();
        return $data;
    }
    // Function that fetch all dataSource that are used for creation of API 
    public static function getAllDataSourceApi()
    {
        // Make Connection with DB 
        $db = static::getDB();
        // Query to fetch data
        $sql = "SELECT * FROM DataSource where updateDataSource = '1' ";
        // Execute Query 
        $stmt = $db->query($sql);
        // fetch all data 
        $data = $stmt->fetchAll();
        return $data;
    }
    // function to get all Info about all type of Data sources 
    public static function getDataSourceDetails($id)
    {
        // Make a DB Connection 
        $db = static::getDB();
        // COndition to assign ID and value to parameters 
        if (!empty($id)) {
            $conditions[] = 'ID = ?';
            $parameters[] = $id;
        }
        // Query 
        $sql = "SELECT * FROM DataSource";
        // Concatnate where clause with query 
        if ($conditions) {
            $sql .= " WHERE " . implode(" AND ", $conditions);
        }
        // Preapre query for bind parameter 
        $stmt = $db->prepare($sql);
        // Execute Query 
        $stmt->execute($parameters);
        // fetch data 
        $data = $stmt->fetchAll();
        return $data;
    }
     // FUnctio to delete data sources
     public static function deleteDataSource($id)
     {
         // Make Connection with DB
         $db = static::getDB();
         // Query to Delete Data Source 
         $sql = "DELETE FROM DataSource WHERE ID = ?";
         // prepare query for bind parameter 
         $q = $db->prepare($sql);
         // Excute Query 
         $response = $q->execute(array($id));
         return $response;
     }
}