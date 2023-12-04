<?php

namespace App\Models;

use PDO;

/**
 * Example user model
 *
 * PHP version 7.0
 */
class Placeholder extends \Core\Model
{

    public static function addGoogleAPI()
    {
        try {
            $db = static::getDB();

            if (isset($_REQUEST['id']) && !empty($_REQUEST['id'])) {
                $sql = "UPDATE GoogleAPI SET Name = :Name, Descriptions = :Descriptions, SourceAddress = :SourceAddress,  Body = :Body, ,Columns = :Columns , ColumnsProperties = :ColumnsProperties WHERE ID = :ID";

                
                $stmt = $db->prepare($sql);
                $stmt->bindParam(':ID', $_REQUEST['id'], PDO::PARAM_STR);
                $stmt->bindParam(':Name', $_REQUEST['Name'], PDO::PARAM_STR);
                $stmt->bindParam(':Descriptions', $_REQUEST['Descriptions'], PDO::PARAM_STR);
                $stmt->bindParam(':SourceAddress', $_REQUEST['SourceAddress'], PDO::PARAM_STR);
                $stmt->bindParam(':Body', $_REQUEST['Body'], PDO::PARAM_STR);
                $stmt->bindParam(':Columns', $_REQUEST['Columns'], PDO::PARAM_STR);
                $stmt->bindParam(':ColumnsProperties', $_REQUEST['ColumnsProperties'], PDO::PARAM_STR);
                $stmt->execute();
            } else {
                $sql = "INSERT INTO GoogleAPI (Name, Descriptions, SourceAddress, Body, Columns, ColumnsProperties)
                    VALUES (:Name, :Descriptions,:SourceAddress, :Body, :Columns, :ColumnsProperties)";
                $stmt = $db->prepare($sql);
                $stmt->bindParam(':Name', $_REQUEST['Name'], PDO::PARAM_STR);
                $stmt->bindParam(':Descriptions', $_REQUEST['Descriptions'], PDO::PARAM_STR);
                $stmt->bindParam(':SourceAddress', $_REQUEST['SourceAddress'], PDO::PARAM_STR);
                $stmt->bindParam(':Body', $_REQUEST['Body'], PDO::PARAM_STR);
                $stmt->bindParam(':Columns', $_REQUEST['Columns'], PDO::PARAM_STR);
                $stmt->bindParam(':ColumnsProperties', $_REQUEST['ColumnsProperties'], PDO::PARAM_STR);
                $stmt->execute();
            }

        } catch (PDOException $e) {
        }
        return;
    }

    // This FUnction Return all COlumn name thats being set at DataSOurce .
    public static function getColumns($id)
    {
        //Make Connection with DB 
        $db = static::getDB();
        // COndition to add the ID and it value .
        if (!empty($id)) {
            $conditions[] = 'ID = ?';
            $parameters[] = $id;
        }
        // Query to get COlUMN NAme .
        $sql = "SELECT Columns, ApiType , DisplayColumnName , Name FROM DataSource";
        // WHere COndition COncatnation .
        if ($conditions) {
            $sql .= " WHERE " . implode(" AND ", $conditions);
        }
        // Preapre query to bind value with parameter .
        $stmt = $db->prepare($sql);
        // Execute Query .
        $stmt->execute($parameters);
        //Fetch al data 
        $data = $stmt->fetchAll();
        return $data;
    }
   // This Function Delete the record from table . this function takes the table name and ID to delete the entry from that table.
   // this function can be used by multiple tables 
    public static function deleteDataFromTable($tableName, $id)
    {
        // Make Connection for DB 
        $db = static::getDB();
        // Query that take table name from which the an entry should be deleted .
        $sql = "DELETE FROM " . $tableName . " WHERE ID = ?";
        // Prepare query for bind parameter 
        $q = $db->prepare($sql);
        // Excute Query 
        $response = $q->execute(array($id));
        return $response;
    }
    
    public static function GetDynamicForm()
    {
        // Make Connection for DB 
        $db = static::getDB();
        $sql = " select * from  SendOrders   where dynamicForm = '1'  ";
        $stmt = $db->query($sql);
        $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $data;
    }
    // Function to Add Dynamic Forms 
    public static function addSendOrdersTable($data)
    {
        try {
            $db = static::getDB();

            if (isset($data['id']) && !empty($data['id'])) {
                $sql = "UPDATE GraphActions SET Name = :Name, Descriptions = :Descriptions, DataSourceId = :DataSourceId,
                        PageTargetId = :PageTargetId, ExternalUrl = :ExternalUrl,
                        ActionButtonText = :ActionButtonText, ActionButtonColor = :ActionButtonColor WHERE ID = :ID";
                $stmt = $db->prepare($sql);
                $stmt->bindParam(':ID', $data['id'], PDO::PARAM_STR);
                $stmt->bindParam(':Name', $data['Name'], PDO::PARAM_STR);
                $stmt->bindParam(':Descriptions', $data['Descriptions'], PDO::PARAM_STR);
                $stmt->bindParam(':PageTargetId', $data['PageTargetId'], PDO::PARAM_STR);
                $stmt->bindParam(':DataSourceId', $data['DataSourceId'], PDO::PARAM_STR);
                $stmt->bindParam(':ExternalUrl', $data['ExternalUrl'], PDO::PARAM_STR);
                $stmt->bindParam(':ActionButtonText', $data['ActionButtonText'], PDO::PARAM_STR);
                $stmt->bindParam(':ActionButtonColor', $data['ActionButtonColor'], PDO::PARAM_STR);
                $stmt->execute();
            } else {
                $sql = "INSERT INTO SendOrders (Name, Description, DetailColumns , DetailColumnsOrderColumn , DateCreated , DataSourceId )
                    VALUES (:Name, :Description, :DetailColumns , :DetailColumnsOrderColumn , :DateCreated , :DataSourceId )";
                $date =  date('Y-m-d');
                $stmt = $db->prepare($sql);
                $stmt->bindParam(':Name', $data['Name'], PDO::PARAM_STR);
                $stmt->bindParam(':Description', $data['Description'], PDO::PARAM_STR);
                $stmt->bindParam(':DetailColumns', $data['DetailColumns'], PDO::PARAM_STR);
                $stmt->bindParam(':DetailColumnsOrderColumn', $data['DetailColumnsOrderColumn'], PDO::PARAM_STR);               
                $stmt->bindParam(':DataSourceId', $data['DataSourceId'], PDO::PARAM_STR);
                $stmt->bindParam(':DateCreated', $date, PDO::PARAM_STR);

                $stmt->execute();
            }

        } catch (PDOException $e) {
        }
        return;
    }

    public static function getSendOrdertable($id)
    {
        $db = static::getDB();
         if (!empty($id)) {
            $conditions[] = 'ID = ?';
            $parameters[] = $id;
        }
        $sql = "SELECT * FROM SendOrders";
        if ($conditions) {
            $sql .= " WHERE " . implode(" AND ", $conditions);
        }
        $stmt = $db->prepare($sql);
        $stmt->execute($parameters);
        $data = $stmt->fetchAll();
        return $data;

    }
    public static function getTableDetails($tableName, $id)
    {
        $db = static::getDB();
        if (!empty($id)) {
            $conditions[] = 'ID = ?';
            $parameters[] = $id;
        }
        $sql = "SELECT * FROM " . $tableName;
        if ($conditions) {
            $sql .= " WHERE " . implode(" AND ", $conditions);
        }
        $stmt = $db->prepare($sql);
        $stmt->execute($parameters);
        $data = $stmt->fetchAll();
        return $data;
    }
    public static function  getTableDetailsNew($tableName, $id)
    {
        $db = static::getDB();
        if (!empty($id)) {
            $conditions[] = 'ID = ? ';
            $parameters[] = $id;
        }
        $sql = "SELECT * FROM " . $tableName;
        if ($conditions) {
            $sql .= " WHERE " . implode(" AND ", $conditions)  ;
            $sql .= "And NewTableFlag = '1'";
        }
       
        $stmt = $db->prepare($sql);
        $stmt->execute($parameters);
        $data = $stmt->fetchAll();
        return $data;
    }
   
    public static function getDataSourceTableData($tableName, $dataSourceId)
    {
        $db = static::getDB();
        if (isset($dataSourceId)) {
            $conditions[] = 'DataSourceId = ?';
            $parameters[] = $dataSourceId;
        }
        $sql = "SELECT * FROM " . $tableName;
        // if ($conditions) {
        //    // $sql .= " WHERE " . implode(" AND ", $conditions);
        // }
        $stmt = $db->prepare($sql);
        $stmt->execute($parameters);
        $data = $stmt->fetchAll();
        return $data;
    }

    public static function getAllTableData($tableName)
    {
        $db = static::getDB();
        if($tableName == 'Tables') {
            $sql = "SELECT * FROM " . $tableName ." where (NewTableFlag IS NULL or NewTableFlag = 0)";
            //$sql = "SELECT * FROM " . $tableName;
        }else {
            $sql = "SELECT * FROM " . $tableName;
        }
       
        $stmt = $db->query($sql);
        $data = $stmt->fetchAll();
        return $data;
    }
    public static function getAllTableDataNew($tableName)
    {
        $db = static::getDB();
        $sql = "SELECT * FROM " . $tableName ." where NewTableFlag = '1'";
        $stmt = $db->query($sql);
        $data = $stmt->fetchAll();
        return $data;
    }
    public static function getAllCustomSetting()
    {
        $db = static::getDB();
        $sql = "SELECT * FROM Tables where EnableFilterWidth1 = '1'  " ;
        $stmt = $db->query($sql);
        $data = $stmt->fetchAll();
        return $data;
    }

    public static function updatePlaceholder()
    {
        $db = static::getDB();
        $sql = "UPDATE Placeholder SET ID = :ID,
            PlaceholderName = :PlaceholderName,
            SourceType = :SourceType,
            FileName = :FileName,
            Description = :Description,
            CallType = :CallType,
            CreateSourceType = :CreateSourceType,
            UpdateSourceType = :UpdateSourceType,
            GetSingleSourceType = :GetSingleSourceType,
            ColumnsList = :ColumnsList,
            KeyColumn = :KeyColumn,
            RequestType = :RequestType,
            RequestBody = :RequestBody,
            DisplayColumnNames = :DisplayColumnNames,
            DetailFilterBody = :DetailFilterBody,
            DetailColumnsList = :DetailColumnsList,
            EditFieldsList = :EditFieldsList,
            ExecptToEditFields = :ExecptToEditFields,
            DetailSourceType = :DetailSourceType,
            DetailKeyColumn = :DetailKeyColumn,
            DetailDisplayColumnNames = :DetailDisplayColumnNames,
            ChartColumnsList = :ChartColumnsList,
            DetailMainIndex = :DetailMainIndex,
            MapFieldName = :MapFieldName
            WHERE PlaceholderID = :PlaceholderID";
        $stmt = $db->prepare($sql);
        $stmt->bindParam(':ID', $_REQUEST['ID'], PDO::PARAM_STR);
        $stmt->bindParam(':PlaceholderName', $_REQUEST['PlaceholderName'], PDO::PARAM_STR);
        $stmt->bindParam(':FileName', $_REQUEST['File'], PDO::PARAM_STR);
        $stmt->bindParam(':SourceType', $_REQUEST['SourceType'], PDO::PARAM_STR);
        $stmt->bindParam(':Description', $_REQUEST['Description'], PDO::PARAM_STR);
        $stmt->bindParam(':CallType', $_REQUEST['CallType'], PDO::PARAM_STR);
        $stmt->bindParam(':PlaceholderID', $_REQUEST['PlaceholderID'], PDO::PARAM_INT);
        $stmt->bindParam(':CreateSourceType', $_REQUEST['CreateSourceType'], PDO::PARAM_STR);
        $stmt->bindParam(':UpdateSourceType', $_REQUEST['UpdateSourceType'], PDO::PARAM_STR);
        $stmt->bindParam(':GetSingleSourceType', $_REQUEST['GetSingleSourceType'], PDO::PARAM_STR);
        $stmt->bindParam(':ColumnsList', $_REQUEST['ColumnsList'], PDO::PARAM_STR);
        $stmt->bindParam(':KeyColumn', $_REQUEST['KeyColumn'], PDO::PARAM_STR);
        $stmt->bindParam(':RequestType', $_REQUEST['RequestType'], PDO::PARAM_STR);
        $stmt->bindParam(':RequestBody', $_REQUEST['RequestBody'], PDO::PARAM_STR);
        $stmt->bindParam(':DisplayColumnNames', $_REQUEST['DisplayColumnNames'], PDO::PARAM_STR);
        $stmt->bindParam(':DetailFilterBody', $_REQUEST['DetailFilterBody'], PDO::PARAM_STR);
        $stmt->bindParam(':DetailColumnsList', $_REQUEST['DetailColumnsList'], PDO::PARAM_STR);
        $stmt->bindParam(':EditFieldsList', $_REQUEST['EditFieldsList'], PDO::PARAM_STR);
        $stmt->bindParam(':ExecptToEditFields', $_REQUEST['ExecptToEditFields'], PDO::PARAM_STR);
        $stmt->bindParam(':DetailSourceType', $_REQUEST['DetailSourceType'], PDO::PARAM_STR);
        $stmt->bindParam(':DetailKeyColumn', $_REQUEST['DetailKeyColumn'], PDO::PARAM_STR);
        $stmt->bindParam(':DetailDisplayColumnNames', $_REQUEST['DetailDisplayColumnNames'], PDO::PARAM_STR);
        $stmt->bindParam(':ChartColumnsList', $_REQUEST['ChartColumnsList'], PDO::PARAM_STR);
        $stmt->bindParam(':DetailMainIndex', $_REQUEST['DetailMainIndex'], PDO::PARAM_STR);
        $stmt->bindParam(':MapFieldName', $_REQUEST['MapFieldName'], PDO::PARAM_STR);
        $stmt->execute();
        return;
    }

    public static function addPlaceholder()
    {
        try {
            $db = static::getDB();
            $sql = "INSERT INTO Placeholder(ID,FileName,PlaceholderName,SourceType,CallType,Description,CreateSourceType,UpdateSourceType, GetSingleSourceType,ColumnsList,KeyColumn,RequestType,RequestBody,DisplayColumnNames,DetailFilterBody,DetailColumnsList,EditFieldsList,ExecptToEditFields,DetailSourceType,DetailKeyColumn,DetailDisplayColumnNames,ChartColumnsList,DetailMainIndex,MapFieldName) VALUES (:ID,:FileName,:PlaceholderName,:SourceType,:CallType,:Description,:CreateSourceType,:UpdateSourceType,
            :GetSingleSourceType,:ColumnsList,:KeyColumn,:RequestType,:RequestBody,:DisplayColumnNames,:DetailFilterBody,:DetailColumnsList,:EditFieldsList,:ExecptToEditFields,:DetailSourceType,:DetailKeyColumn,:DetailDisplayColumnNames,:ChartColumnsList,:DetailMainIndex,:MapFieldName)";
                        $stmt = $db->prepare($sql);
            $stmt->bindParam(':ID', $_REQUEST['ID'], PDO::PARAM_STR);
            $stmt->bindParam(':FileName', $_REQUEST['File'], PDO::PARAM_STR);
            $stmt->bindParam(':PlaceholderName', $_REQUEST['PlaceholderName'], PDO::PARAM_STR);
            $stmt->bindParam(':SourceType', $_REQUEST['SourceType'], PDO::PARAM_STR);
            $stmt->bindParam(':CallType', $_REQUEST['CallType'], PDO::PARAM_STR);
            $stmt->bindParam(':Description', $_REQUEST['Description'], PDO::PARAM_STR);
            $stmt->bindParam(':CreateSourceType', $_REQUEST['CreateSourceType'], PDO::PARAM_STR);
            $stmt->bindParam(':UpdateSourceType', $_REQUEST['UpdateSourceType'], PDO::PARAM_STR);
            $stmt->bindParam(':GetSingleSourceType', $_REQUEST['GetSingleSourceType'], PDO::PARAM_STR);
            $stmt->bindParam(':ColumnsList', $_REQUEST['ColumnsList'], PDO::PARAM_STR);
            $stmt->bindParam(':KeyColumn', $_REQUEST['KeyColumn'], PDO::PARAM_STR);
            $stmt->bindParam(':RequestType', $_REQUEST['RequestType'], PDO::PARAM_STR);
            $stmt->bindParam(':RequestBody', $_REQUEST['RequestBody'], PDO::PARAM_STR);
            $stmt->bindParam(':DisplayColumnNames', $_REQUEST['DisplayColumnNames'], PDO::PARAM_STR);
            $stmt->bindParam(':DetailFilterBody', $_REQUEST['DetailFilterBody'], PDO::PARAM_STR);
            $stmt->bindParam(':DetailColumnsList', $_REQUEST['DetailColumnsList'], PDO::PARAM_STR);
            $stmt->bindParam(':EditFieldsList', $_REQUEST['EditFieldsList'], PDO::PARAM_STR);
            $stmt->bindParam(':ExecptToEditFields', $_REQUEST['ExecptToEditFields'], PDO::PARAM_STR);
            $stmt->bindParam(':DetailSourceType', $_REQUEST['DetailSourceType'], PDO::PARAM_STR);
            $stmt->bindParam(':DetailKeyColumn', $_REQUEST['DetailKeyColumn'], PDO::PARAM_STR);
            $stmt->bindParam(':DetailDisplayColumnNames', $_REQUEST['DetailDisplayColumnNames'], PDO::PARAM_STR);
            $stmt->bindParam(':ChartColumnsList', $_REQUEST['ChartColumnsList'], PDO::PARAM_STR);
            $stmt->bindParam(':DetailMainIndex', $_REQUEST['DetailMainIndex'], PDO::PARAM_STR);
            $stmt->bindParam(':MapFieldName', $_REQUEST['MapFieldName'], PDO::PARAM_STR);
            $stmt->execute();
        } catch (PDOException $e) {
        }
        return;
    }
   
    public static function getPlaceholderDetails($id)
    {
        $db = static::getDB();
        if (!empty($id)) {
            $conditions[] = 'PlaceholderID = ?';
            $parameters[] = $id;
        }
        $sql = "SELECT * FROM Placeholder";
        if ($conditions) {
            $sql .= " WHERE " . implode(" AND ", $conditions);
        }
        $stmt = $db->prepare($sql);
        $stmt->execute($parameters);
        $data = $stmt->fetchAll();
        return $data;
    }

    public static function deletePlacebolder($id)
    {
        $db = static::getDB();
        $sql = "DELETE FROM Placeholder WHERE PlaceholderID = ?";
        $q = $db->prepare($sql);
        $response = $q->execute(array($id));
        return $response;
    }
    

    public static function SaveFilterTable($data)
    {
      
        $db = static::getDB();
        if(!empty($data['id'])){
            $sql = "UPDATE UserPagePlaceholders SET PlaceholderValue = :PlaceholderValue,
            PlaceholderId = :PlaceholderId,
            PlaceholderActionIds = :PlaceholderActionIds,
            PlaceholderType = :PlaceholderType,
            UserPageAccessId = :UserPageAccessId,
            UserId = :UserId
            WHERE ID = :ID";
            $getParentPages = (isset($data['ParentPages']))? $data['ParentPages'] : NULL;
            try{
                $stmt = $db->prepare($sql);
                $stmt->bindParam(':PlaceholderValue', $data['PlaceholderValue'], PDO::PARAM_STR);
                $stmt->bindParam(':PlaceholderId', $data['PlaceholderId'], PDO::PARAM_STR);
                $stmt->bindParam(':PlaceholderActionIds', $data['PlaceholderActionIds'], PDO::PARAM_STR);
                $stmt->bindParam(':PlaceholderType', $data['PlaceholderType'], PDO::PARAM_STR);
                $stmt->bindParam(':UserPageAccessId', $data['UserPageAccessId'], PDO::PARAM_STR);
                $stmt->bindParam(':UserId', $data['UserId'], PDO::PARAM_STR);
                $stmt->bindParam(':ID', $data['id'], PDO::PARAM_INT);
                $stmt->execute();
            }catch (Exception $exc){
                echo $exc->getMessage();exit;

            }

        } else {
            try {

                $sql = "INSERT INTO UserPagePlaceholders (PlaceholderValue, PlaceholderId, PlaceholderActionIds, PlaceholderType, UserPageAccessId, UserId, TablesId, CommonField, Tablelinked)
                        VALUES (:PlaceholderValue, :PlaceholderId, :PlaceholderActionIds, :PlaceholderType, :UserPageAccessId, :UserId , :TablesId , :CommonField , :Tablelinked)";
                $stmt = $db->prepare($sql);
                $stmt->bindParam(':PlaceholderValue', $data['PlaceholderValue'], PDO::PARAM_STR);
                $stmt->bindParam(':PlaceholderId', $data['PlaceholderId'], PDO::PARAM_STR);
                $stmt->bindParam(':PlaceholderActionIds', $data['PlaceholderActionIds'], PDO::PARAM_STR);
                $stmt->bindParam(':PlaceholderType', $data['PlaceholderType'], PDO::PARAM_STR);
                $stmt->bindParam(':UserPageAccessId', $data['UserPageAccessId'], PDO::PARAM_STR);
                $stmt->bindParam(':TablesId', $data['TablesId'], PDO::PARAM_STR);
                $stmt->bindParam(':CommonField', $data['CommonField'], PDO::PARAM_STR);
                $stmt->bindParam(':Tablelinked', $data['Tablelinked'], PDO::PARAM_STR);
                $stmt->bindParam(':UserId', $data['UserId'], PDO::PARAM_STR);
                $stmt->execute();

            } catch (PDOException $e) {
            }
        }
        return;
    }

    
    public static function getUserPagePlaceholders($id)
    {
        $db = static::getDB();
        if (!empty($id)) {
            $conditions[] = 'ID = ?';
            $parameters[] = $id;
        }
        $sql = "SELECT * FROM UserPagePlaceholders";
        if ($conditions) {
            $sql .= " WHERE " . implode(" AND ", $conditions);
        }
        $stmt = $db->prepare($sql);
        $stmt->execute($parameters);
        $data = $stmt->fetchAll();
        return $data;
    }

    public static function getDataTableDescription($id)
    {
        try {
            $db = static::getDB();
            $sql = "select  Tables.Descriptions, Tables.DataSourceId
                    FROM Tables
                    WHERE Tables.ID ='" . $id . "'";
            $stmt = $db->prepare($sql);

            $stmt->execute();
            $data = $stmt->fetchAll();
            return $data;

        } catch (PDOException $e) {
        }
    }
}
