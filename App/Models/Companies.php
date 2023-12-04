<?php

namespace App\Models;

use PDO;
use \App\Models\User;

/**
 * Companies  model
 *
 * PHP version 7.0
 * Get all the users as an associative array
 * @return array
 */
class Companies extends \Core\Model
{
    // Function that Get all companies
    public static function getAll()
    {
        // Make Connection with DB 
        $db = static::getDB();
        // Query to fetch all Data ffor companies 
        $sql = "SELECT * FROM Company";
        // Execute Query 
        $stmt = $db->query($sql);
        // Fetch all Data 
        $data = $stmt->fetchAll();
        return $data;
    }
    // Get detail of a specific Comapny
    public static function getCompanyDetails($id)
    {
        // Make Connection with DB 
        $db = static::getDB();
        // this Code allows us to add multiple condition parameter and its value . 
        if (!empty($id)) {
            $conditions[] = 'CompanyID = ?';
            $parameters[] = $id;
        }
        // Query 
        $sql = "SELECT * FROM Company";
        // concatenate condition if id is given 
        if ($conditions) {
            $sql .= " WHERE " . implode(" AND ", $conditions);
        }
        //prepare query to bind value .
        $stmt = $db->prepare($sql);
        // Execute query 
        $stmt->execute($parameters);
        // fetch all data 
        $data = $stmt->fetchAll();
       
        if(!empty($data) &&  isset($_SESSION['UserID'])){
           
            $UserData =  User::getUserDetails($_SESSION['UserID']);
           
            if($UserData[0]['EnableFreshDeskUser']){
                $data[0]['CompanyBPDb'] = 'GCS_Tickets_Portal';
            }
        }
       
        return $data;
    }
    // Get detail of a specific Comapny and its related users too .
    public static function getCompaniesDetails($id)
    {
        // Make Connection with DB 
        $db = static::getDB();
        // this Code allows us to add multiple condition parameter and its value .
        if (!empty($id)) {
            $conditions[] = ' u.UserID = ?';
            $parameters[] = $id;
        }
        // Query to get all comapny with inner join on user . 
        // this query will get all those company that have an entry on user table to with same company ID .
        $sql = "SELECT * FROM Company c Inner Join Users u ON c.CompanyID = u.CompanyID";
        // if Contion is applied then this query will get all those company that have an entry on user
        // table to with same company ID  and with the same userid as mention in where Clause.
        if ($conditions) {
            $sql .= " WHERE " . implode(" AND ", $conditions);
        }
        //preapre query to bind value 
        $stmt = $db->prepare($sql);
        //Execute Query
        $stmt->execute($parameters);
        // Fetch All Data 
        $data = $stmt->fetchAll();
        if(!empty($data)){
            
            if($data[0]['EnableFreshDeskUser']){
                $data[0]['CompanyBPDb'] = 'GCS_Tickets_Portal';
            }
        }
        return $data;
    }
    // get Specfic Company Users
    public static function getCompanyUsers($id)
    {
        // Make Connection with DB 
        $db = static::getDB();
        if (!empty($id)) {
            $conditions[] = 'CompanyID = ?';
            $parameters[] = $id;
        }
        $sql = "SELECT * FROM Users";
        if ($conditions) {
            $sql .= " WHERE " . implode(" AND ", $conditions);
        }
        $stmt = $db->prepare($sql);
        $stmt->execute($parameters);
        $data = $stmt->fetchAll();
        return $data;
    }
    // get  All Users
    public static function getAllUsers()
    {
         // Make Connection with DB 
        $db = static::getDB();
        $sql = "SELECT * FROM Users";
        $stmt = $db->prepare($sql);
        $stmt->execute();
        $data = $stmt->fetchAll();
        return $data;
    }
    // get Specific Users
    public static function getSpecficUsers($email)
    {
         // Make Connection with DB 
        $db = static::getDB();
        $sql = "SELECT * FROM Users where UserEmail = '" .$email . "'";

        $stmt = $db->prepare($sql);
        $stmt->execute();
        $data = $stmt->fetchAll();
        return $data;
    }
    // get Total Users
    public static function getTotalUsers($id)
    {
         // Make Connection with DB 
        $db = static::getDB();
        if (!empty($id)) {
            $conditions[] = 'CompanyID = ?';
            $parameters[] = $id;
        }
        $sql = "SELECT count(*) FROM Users";
        if ($conditions) {
            $sql .= " WHERE " . implode(" AND ", $conditions);
        }
        $stmt = $db->prepare($sql);
        // Execute Query 
        $stmt->execute($parameters);
        // will fetch value of first column only 
        $data = $stmt->fetchColumn();
        return $data;
    }
    // delete Specific Company
    public static function deleteCompany($id)
    {
         // Make Connection with DB 
        $db = static::getDB();
        // Query to delete Specfic data .
        $sql = "DELETE FROM Company WHERE CompanyID = ?";
        // prepare query to bind parameter .
        $q = $db->prepare($sql);
        $response = $q->execute(array($id)); // Execute Query 
        return $response;
    }
    // Update Specific Company settings
    public static function updateCompany()
    {
         // Make Connection with DB 
        $db = static::getDB();
        // Update record query 
        $sql = "UPDATE Company SET CompanyName = :CompanyName,
            CompanyGISKey = :CompanyGISKey,
            CompanyGISToken = :CompanyGISToken,
            CompanyBABCDb = :CompanyBABCDb,
            CompanyBPDb = :CompanyBPDb,
            CompanyStartDate = :CompanyStartDate,
            CompanyEndDate = :CompanyEndDate,
            CompanyEmail = :CompanyEmail,
            APIOption = :APIOption, 
            AllowOtherCompanyUser=:AllowOtherCompanyUser, 
            DBType = :DBType,
            CompanyDBPass = :CompanyDBPass,
            CompanyHostName = :CompanyHostName,
            CompanyDBUserName = :CompanyDBUserName,
            DatsourceLinkName= :DatsourceLinkName,
            AdminDb =  :AdminDb , 
            FTPCredential = :FTPCredential,
            SFTPCredential = :SFTPCredential,
            SFTPKeys = :SFTPKeys,
            AllowCompanyFolder = :AllowCompanyFolder,
            AccountHolderName =:AccountHolderName ,
            IBANNumber = :IBANNumber , 
            BICNumber = :BICNumber, 
            CreditorID = :CreditorID,
            EnableOrgId =:EnableOrgId,
            EnableEndtoEndId = :EnableEndtoEndId,
            EndtoEndId = :EndtoEndId,
            OrgId = :OrgId, 
            EnableFreshDesk=:EnableFreshDesk,
            FreshDeskCompany = :FreshDeskCompany, 
            selectAllFreshDeskCompany =:selectAllFreshDeskCompany, 
            selectspecficFreshDeskCompany =:selectspecficFreshDeskCompany,
            EnablePrivateMsg=:EnablePrivateMsg,
            EnableRedisCompany=:EnableRedisCompany , 
            TableSelectionCompany =:TableSelectionCompany , 
            TimeDurationRedisCompany = :TimeDurationRedisCompany , 
            TimeRedisCompany = :TimeRedisCompany, 
            TimeDurationRedisCompanyAPI = :TimeDurationRedisCompanyAPI , 
            TimeRedisCompanyAPI = :TimeRedisCompanyAPI, 
			TimeDurationJson = :TimeDurationJson,
			TimeJson =:TimeJson,
			EnablejsonSaveDataAllUser = :EnablejsonSaveDataAllUser
            WHERE CompanyID = :CompanyID";
        // Prepare query to bind parameter .
        $stmt = $db->prepare($sql);
        // Parameter binding 
        $stmt->bindParam(':CompanyName', $_REQUEST['CompanyName'], PDO::PARAM_STR);
        $stmt->bindParam(':CompanyGISKey', $_REQUEST['CompanyGISKey'], PDO::PARAM_STR);
        $stmt->bindParam(':CompanyGISToken', $_REQUEST['CompanyGISToken'], PDO::PARAM_STR);
        $stmt->bindParam(':CompanyBABCDb', $_REQUEST['CompanyBABCDb'], PDO::PARAM_STR);
        $stmt->bindParam(':CompanyBPDb', $_REQUEST['CompanyBPDb'], PDO::PARAM_STR);
        $stmt->bindParam(':CompanyStartDate', $_REQUEST['CompanyStartDate'], PDO::PARAM_STR);
        $stmt->bindParam(':CompanyEndDate', $_REQUEST['CompanyEndDate'], PDO::PARAM_STR);
        $stmt->bindParam(':CompanyEmail', $_REQUEST['CompanyEmail'], PDO::PARAM_STR);
        $stmt->bindParam(':CompanyID', $_REQUEST['CompanyID'], PDO::PARAM_INT);
        $stmt->bindParam(':APIOption', $_REQUEST['APIOption'], PDO::PARAM_STR);
        $stmt->bindParam(':AllowOtherCompanyUser', $_REQUEST['AllowOtherCompanyUser'], PDO::PARAM_STR);
        $stmt->bindParam(':DBType', $_REQUEST['DBType'], PDO::PARAM_STR);
        $stmt->bindParam(':CompanyHostName', $_REQUEST['CompanyHostName'], PDO::PARAM_STR);
        $stmt->bindParam(':CompanyDBUserName', $_REQUEST['CompanyDBUserName'], PDO::PARAM_STR);
        $stmt->bindParam(':CompanyDBPass', $_REQUEST['CompanyDBPass'], PDO::PARAM_STR);
        $stmt->bindParam(':DatsourceLinkName', $_REQUEST['DatsourceLinkName'], PDO::PARAM_STR);
        $stmt->bindParam(':AdminDb', $_REQUEST['AdminDb'], PDO::PARAM_STR);
        $stmt->bindParam(':AllowCompanyFolder', $_REQUEST['AllowCompanyFolder'], PDO::PARAM_STR);
        $stmt->bindParam(':FTPCredential', $_REQUEST['FTPCredential'], PDO::PARAM_STR);
        $stmt->bindParam(':SFTPCredential', $_REQUEST['SFTPCredential'], PDO::PARAM_STR);
        $stmt->bindParam(':SFTPKeys', $_REQUEST['SFTPKeys'], PDO::PARAM_STR);
        $stmt->bindParam(':AccountHolderName', $_REQUEST['AccountHolderName'], PDO::PARAM_STR);
        $stmt->bindParam(':IBANNumber', $_REQUEST['IBANNumber'], PDO::PARAM_STR);
        $stmt->bindParam(':BICNumber', $_REQUEST['BICNumber'], PDO::PARAM_STR);
        $stmt->bindParam(':CreditorID', $_REQUEST['CreditorID'], PDO::PARAM_STR);
        $stmt->bindParam(':EnableOrgId', $_REQUEST['EnableOrgId'], PDO::PARAM_STR);
        $stmt->bindParam(':OrgId', $_REQUEST['OrgId'], PDO::PARAM_STR);
        $stmt->bindParam(':EnableEndtoEndId', $_REQUEST['EnableEndtoEndId'], PDO::PARAM_STR);
        $stmt->bindParam(':EndtoEndId', $_REQUEST['EndtoEndId'], PDO::PARAM_STR);
        $stmt->bindParam(':EnableFreshDesk', $_REQUEST['EnableFreshDesk'], PDO::PARAM_STR);
        $stmt->bindParam(':FreshDeskCompany', $_REQUEST['FreshDeskCompany'], PDO::PARAM_STR);
        $stmt->bindParam(':selectAllFreshDeskCompany', $_REQUEST['selectAllFreshDeskCompany'], PDO::PARAM_STR);
        $stmt->bindParam(':selectspecficFreshDeskCompany', $_REQUEST['selectspecficFreshDeskCompany'], PDO::PARAM_STR);
        $stmt->bindParam(':EnablePrivateMsg', $_REQUEST['EnablePrivateMsg'], PDO::PARAM_STR);
        $stmt->bindParam(':EnableRedisCompany', $_REQUEST['EnableRedisCompany'], PDO::PARAM_STR);
        $stmt->bindParam(':TableSelectionCompany', $_REQUEST['TableSelectionCompany'], PDO::PARAM_STR);
        $stmt->bindParam(':TimeDurationRedisCompany', $_REQUEST['TimeDurationRedisCompany'], PDO::PARAM_STR);
        $stmt->bindParam(':TimeRedisCompany', $_REQUEST['TimeRedisCompany'], PDO::PARAM_STR);
        $stmt->bindParam(':TimeDurationRedisCompanyAPI', $_REQUEST['TimeDurationRedisCompanyAPI'], PDO::PARAM_STR);
        $stmt->bindParam(':TimeRedisCompanyAPI', $_REQUEST['TimeRedisCompanyAPI'], PDO::PARAM_STR);
		$stmt->bindParam(':TimeDurationJson', $_REQUEST['TimeDurationJson'], PDO::PARAM_STR);
		$stmt->bindParam(':TimeJson', $_REQUEST['TimeJson'], PDO::PARAM_STR);
		$stmt->bindParam(':EnablejsonSaveDataAllUser', $_REQUEST['EnablejsonSaveDataAllUser'], PDO::PARAM_STR);
		

        $stmt->execute(); // Execute Query 
        return;
    }
    // Add New Company settings
    public static function addCompany()
    {
         // Make Connection with DB 
        $db = static::getDB();
        // Query to insert new entry 
        $sql = "INSERT INTO Company(CompanyName,CompanyGISKey,CompanyGISToken,CompanyBABCDb,CompanyBPDb,CompanyStartDate,
                CompanyEndDate,CompanyEmail ,APIOption, AllowOtherCompanyUser, DBType, CompanyHostName, CompanyDBUserName, CompanyDBPass,
                DatsourceLinkName, AdminDb, AllowCompanyFolder, FTPCredential, SFTPCredential,  SFTPKeys ,AccountHolderName , IBANNumber , BICNumber, CreditorID , EnableOrgId , OrgId , EnableEndtoEndId , EndtoEndId) VALUES (:CompanyName,:CompanyGISKey,
                :CompanyGISToken,:CompanyBABCDb,:CompanyBPDb,:CompanyStartDate,:CompanyEndDate,:CompanyEmail,:APIOption, :AllowOtherCompanyUser, :DBType, :CompanyHostName, :CompanyDBUserName, :CompanyDBPass,
                :DatsourceLinkName, :AdminDb, :AllowCompanyFolder, :FTPCredential, :SFTPCredential,  :SFTPKeys  ,:AccountHolderName , :IBANNumber , :BICNumber, :CreditorID , :EnableOrgId, :OrgId, :EnableEndtoEndId, :EndtoEndId) ";
        // Preapre query to bind parameter value .
        $stmt = $db->prepare($sql);
        // parameter binding 
        $stmt->bindParam(':CompanyName', $_REQUEST['CompanyName'], PDO::PARAM_STR);
        $stmt->bindParam(':CompanyGISKey', $_REQUEST['CompanyGISKey'], PDO::PARAM_STR);
        $stmt->bindParam(':CompanyGISToken', $_REQUEST['CompanyGISToken'], PDO::PARAM_STR);
        $stmt->bindParam(':CompanyBABCDb', $_REQUEST['CompanyBABCDb'], PDO::PARAM_STR);
        $stmt->bindParam(':CompanyBPDb', $_REQUEST['CompanyBPDb'], PDO::PARAM_STR);
        $stmt->bindParam(':CompanyStartDate', $_REQUEST['CompanyStartDate'], PDO::PARAM_STR);
        $stmt->bindParam(':CompanyEndDate', $_REQUEST['CompanyEndDate'], PDO::PARAM_STR);
        $stmt->bindParam(':CompanyEmail', $_REQUEST['CompanyEmail'], PDO::PARAM_STR);
        $stmt->bindParam(':APIOption', $_REQUEST['APIOption'], PDO::PARAM_STR);
        $stmt->bindParam(':AllowOtherCompanyUser', $_REQUEST['AllowOtherCompanyUser'], PDO::PARAM_STR);
        $stmt->bindParam(':DBType', $_REQUEST['DBType'], PDO::PARAM_STR);
        $stmt->bindParam(':CompanyHostName', $_REQUEST['CompanyHostName'], PDO::PARAM_STR);
        $stmt->bindParam(':CompanyDBUserName', $_REQUEST['CompanyDBUserName'], PDO::PARAM_STR);
        $stmt->bindParam(':CompanyDBPass', $_REQUEST['CompanyDBPass'], PDO::PARAM_STR);
        $stmt->bindParam(':DatsourceLinkName', $_REQUEST['DatsourceLinkName'], PDO::PARAM_STR);
        $stmt->bindParam(':AdminDb', $_REQUEST['AdminDb'], PDO::PARAM_STR);
        $stmt->bindParam(':AllowCompanyFolder', $_REQUEST['AllowCompanyFolder'], PDO::PARAM_STR);
        $stmt->bindParam(':FTPCredential', $_REQUEST['FTPCredential'], PDO::PARAM_STR);
        $stmt->bindParam(':SFTPCredential', $_REQUEST['SFTPCredential'], PDO::PARAM_STR);
        $stmt->bindParam(':SFTPKeys', $_REQUEST['SFTPKeys'], PDO::PARAM_STR);
        $stmt->bindParam(':AccountHolderName', $_REQUEST['AccountHolderName'], PDO::PARAM_STR);
        $stmt->bindParam(':IBANNumber', $_REQUEST['IBANNumber'], PDO::PARAM_STR);
        $stmt->bindParam(':BICNumber', $_REQUEST['BICNumber'], PDO::PARAM_STR);
        $stmt->bindParam(':CreditorID', $_REQUEST['CreditorID'], PDO::PARAM_STR);
        $stmt->bindParam(':EnableOrgId', $_REQUEST['EnableOrgId'], PDO::PARAM_STR);
        $stmt->bindParam(':OrgId', $_REQUEST['OrgId'], PDO::PARAM_STR);
        $stmt->bindParam(':EnableEndtoEndId', $_REQUEST['EnableEndtoEndId'], PDO::PARAM_STR);
        $stmt->bindParam(':EndtoEndId', $_REQUEST['EndtoEndId'], PDO::PARAM_STR);

        $stmt->execute(); // Execute query 
        return;
    }
    // Function to Add details from Google Api
    public static function updateCompanyForGoogleApi($data)
    {
         // Make Connection with DB 
        $db = static::getDB();
        // (Start) For Update  Access Token only 
        if(isset($data['type']) && ($data['type'] == 'Update') ){
            // Query to update a record 
            $sql = "UPDATE Company SET
            GoogleAccessToken = :GoogleAccessToken
            WHERE CompanyID = :CompanyID";
            // prepare query ti bind value with parameters .
            $stmt = $db->prepare($sql);
            $GoogleAccessToken =  $data['accessToken']['token_type']." ".$data['accessToken']['access_token'];
            // parameter Binding 
            $stmt->bindParam(':GoogleAccessToken', $GoogleAccessToken, PDO::PARAM_STR);
            $stmt->bindParam(':CompanyID', $data['companyId'], PDO::PARAM_INT);
            $stmt->execute(); // Execute query 

        }else
        //(End) For Update Access Token only 
        //(Start) For Update Access token and GoogleAccessRefreshToken
        {
            /// Query to update a record 
            $sql = "UPDATE Company SET
            GoogleAccessToken = :GoogleAccessToken,
            GoogleAccessRefreshToken = :GoogleAccessRefreshToken
            WHERE CompanyID = :CompanyID";
             // prepare query to bind value with parameters 
            $stmt = $db->prepare($sql);

            $GoogleAccessToken =  $data['accessToken']['token_type']." ".$data['accessToken']['access_token'];
            $GoogleAccessRefreshToken = isset($data['accessToken']['refresh_token'])?$data['accessToken']['refresh_token']:"";
             // parameter Binding 
            $stmt->bindParam(':GoogleAccessRefreshToken', $GoogleAccessRefreshToken , PDO::PARAM_STR);
            $stmt->bindParam(':GoogleAccessToken', $GoogleAccessToken, PDO::PARAM_STR);
            $stmt->bindParam(':CompanyID', $data['companyId'], PDO::PARAM_INT);
            $stmt->execute();  // Execute QUery 
        }
        //(End) For Update Access token and GoogleAccessRefreshToken
        return;
    }

}
