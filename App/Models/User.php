<?php

namespace App\Models;

use PDO;
use MongoDB;
use PDOException;
//Use Memcache;
/**
 * Example user model
 *
 * PHP version 7.0
 */
class User extends \Core\Model
{

    /**
     * Get all the users as an associative array
     *
     * @return array
     */
    // Get All USer from DB
    public static function getAll()
    {
        $db = static::getDB();
        $stmt = $db->query('SELECT * FROM Users');
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
	public static function getDataTable($sql , $databaseName)
    {
        $db = Self::getUserDB($databaseName);
        $stmt = $db->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    // This Function is Used to validate the user accordng to email and pass .
    // This function is used on Login Page Normally
    public static function verifyUser($email, $password)
    {
      
        if (!empty($email)) {
            $conditions[] = 'UserEmail = ?';
            $parameters[] = $email;
        }

        if (!empty($password)) {
            // here we are using equality
            $conditions[] = 'UserPassword = ?';
            $parameters[] = $password;
        }
        $sql = "SELECT * FROM Users";
        if ($conditions) {
            $sql .= " WHERE " . implode(" AND ", $conditions);
        }
       
        $db = static::getDB();

        $stmt = $db->prepare($sql);
        
        $stmt->execute($parameters);
        $data = $stmt->fetchAll();
       
        return $data;
    }
    // This Function is Used to validate the user accordng to email .
    public static function verifyGroupUser($email)
    {

        if (!empty($email)) {
            $conditions[] = 'UserEmail = ?';
            $parameters[] = $email;
        }

        $sql = "SELECT * FROM Users";
        if ($conditions) {
            $sql .= " WHERE " . implode(" AND ", $conditions);
        }
        $db = static::getDB();
        $stmt = $db->prepare($sql);
        $stmt->execute($parameters);
        $data = $stmt->fetchAll();
        return $data;
    }

    //This Function get all detail from Pages Tables 
    public static function getAllPagesAsList()
    {
        try {
            $db = static::getDB();
            $sql = "SELECT Pages.PageFilename,Pages.PageText,Pages.ID AS PageTableID FROM Pages";
            $stmt = $db->prepare($sql);
            $stmt->execute();
            $data = $stmt->fetchAll();
            return $data;

        } catch (PDOException $e) {
        }
    }
    //This Function get all pages for a Specific user
    public static function getUserPages($userId)
    {
        try {
            $db = static::getDB();
            $sql = "SELECT Pages.PageFilename,Pages.ID AS PageTableID,Pages.PageText,UserPageAccess.ShowAsMenu,UserPageAccess.ID AS userPageId, UserPageAccess.ParentPages, UserPageAccess.PageMenuText ,UserPageAccess.PageId, UserPageAccess.ParentPageText , UserPageAccess.SecondaryPageMenuOrder , UserPageAccess.SecondaryChildPageMenuOrder,
                UserPageAccess.ParentLinkFlag , UserPageAccess.DefaultFirstPage , UserPageAccess.PageMenuOrder  , UserPageAccess.EnableTicketMenuLabel  , UserPageAccess.EnableTicketClickFilter , UserPageAccess.EnableFixedHeader ,    UserPageAccess.EnableFixedLeftColumn ,  UserPageAccess.ID as UserPageAccessID

			FROM Pages,UserPageAccess
			WHERE UserPageAccess.PageId = Pages.ID AND UserPageAccess.UserId ='" . $userId . "' ORDER BY UserPageAccess.PageMenuOrder ASC";
            $stmt = $db->prepare($sql);
            $stmt->execute();
            $data = $stmt->fetchAll();
            return $data;

        } catch (PDOException $e) {
        }
    }

    public static function getUserPagesForParentsOption($userId)
    {
        try {
            $db = static::getDB();
            $sql = "SELECT Pages.PageFilename,Pages.ID AS PageTableID,Pages.PageText,UserPageAccess.ID AS userPageId, UserPageAccess.ParentPages, UserPageAccess.PageMenuText ,UserPageAccess.PageId
			FROM Pages,UserPageAccess
			WHERE UserPageAccess.PageId = Pages.ID  AND UserPageAccess.ShowAsMenu= '1' AND UserPageAccess.UserId ='" . $userId . "' ORDER BY UserPageAccess.PageMenuOrder ASC";

            $stmt = $db->prepare($sql);
            $stmt->execute();
            $data = $stmt->fetchAll();
            return $data;

        } catch (PDOException $e) {
        }
    }

    public static function getUserPagesForSecondaryParentsOption($userId, $mainData)
    {
    
        try {

            $resultArr =array();

            foreach ($mainData as $key => $value) {
                
                $db = static::getDB();
                $sql = "SELECT Pages.PageFilename,Pages.ID AS PageTableID,Pages.PageText,UserPageAccess.ID AS userPageId, 
                    UserPageAccess.ParentPages, UserPageAccess.PageMenuText ,UserPageAccess.PageId 
                    FROM Pages,UserPageAccess 
                    WHERE UserPageAccess.PageId = Pages.ID  
                    AND UserPageAccess.UserId ='" . $userId . "' AND UserPageAccess.ParentPageText like '%".$value['PageMenuText']."%' ORDER BY UserPageAccess.PageMenuOrder ASC";

                $stmt = $db->prepare($sql);
                $stmt->execute();
                $data = $stmt->fetchAll();
                if(!empty($data))
                {
                    
                    $resultArr = array_merge($resultArr, $data);
                }
            }
            return $resultArr;

        } catch (PDOException $e) {
        }
    }
    // This function Allows to get Data all pages that a user can Access.
    public static function getSelectedUserPages($userId)
    {
        try {
            $db = static::getDB();
            $sql = "SELECT * from UserPageAccess where UserId='" . $userId . "'";
            $stmt = $db->prepare($sql);
            $stmt->execute();
            $data = $stmt->fetchAll();
            return $data;

        } catch (PDOException $e) {
        }
    }
    // This function Allows to get placeholder that a user can Access on a Page.
    public static function getSelectedPagePlaceholders($userId, $pageAccessId)
    {
        try {
            $db = static::getDB();
            $sql = "SELECT * from UserPagePlaceholders where UserId='" . $userId . "' AND UserPageAccessId= '" . $pageAccessId . "'";
            $stmt = $db->prepare($sql);
            $stmt->execute();
            $data = $stmt->fetchAll();
            return $data;

        } catch (PDOException $e) {
        }
    }
    // This function get page detail that what placeholders are linked .
    public static function getPageDetails($userPageAccessId)
    {
        try {
            $db = static::getDB();
            $sql = "SELECT Pages.PagePanels,Pages.PageText,UserPageAccess.ID AS userPageId,UserPageAccess.PageMenuText,UserPageAccess.PageId
			FROM Pages,UserPageAccess
			WHERE UserPageAccess.PageId = Pages.ID AND UserPageAccess.ID ='" . $userPageAccessId . "'";
            $stmt = $db->prepare($sql);
            $stmt->execute();
            $data = $stmt->fetchAll();
            return $data;

        } catch (PDOException $e) {
        }
    }
    // This Function Allows to Add new Users.
    public static function addUser()
    {
        $sql = "INSERT INTO Users(CompanyID,UserFirstName,UserLastName,UserStartDate,UserEndDate,UserEmail,UserPassword,DBParam, UserGroupFlag  ,UserGroupActiveFlag , AvailableUserGroup , DefaultLogin , APIParam , AllowParentDBParam , AllowParentAPIParam ,AllowedFreshDeskUser, EnableFreshDeskUser , SaveFilterBTN )
                VALUES (:CompanyID,:UserFirstName,:UserLastName,:UserStartDate,:UserEndDate,:UserEmail,:UserPassword,:DBParam, :UserGroupFlag, :UserGroupActiveFlag, :AvailableUserGroup , :DefaultLogin , :APIParam , :AllowParentDBParam , :AllowParentAPIParam ,:AllowedFreshDeskUser, :EnableFreshDeskUser, :SaveFilterBTN  )";
        $db = static::getDB();
        $stmt = $db->prepare($sql);

        $stmt->bindParam(':CompanyID', $_REQUEST['CompanyID'], PDO::PARAM_STR);
        $stmt->bindParam(':UserFirstName', $_REQUEST['UserFirstName'], PDO::PARAM_STR);
        $stmt->bindParam(':UserLastName', $_REQUEST['UserLastName'], PDO::PARAM_STR);
        $stmt->bindParam(':UserStartDate', $_REQUEST['UserStartDate'], PDO::PARAM_STR);
        $stmt->bindParam(':UserEndDate', $_REQUEST['UserEndDate'], PDO::PARAM_STR);
        $stmt->bindParam(':UserEmail', $_REQUEST['UserEmail'], PDO::PARAM_STR);
        $stmt->bindParam(':UserPassword', $_REQUEST['UserPassword'], PDO::PARAM_STR);
        $stmt->bindParam(':DBParam', $_REQUEST['DBParam'], PDO::PARAM_STR);
        $stmt->bindParam(':APIParam', $_REQUEST['APIParam'], PDO::PARAM_STR);
        $stmt->bindParam(':UserGroupFlag', $_REQUEST['UserGroupFlag'], PDO::PARAM_STR);
        $stmt->bindParam(':UserGroupActiveFlag', $_REQUEST['UserGroupActiveFlag'], PDO::PARAM_STR);
        $stmt->bindParam(':AvailableUserGroup', $_REQUEST['AvailableUserGroup'], PDO::PARAM_STR);
        $stmt->bindParam(':DefaultLogin', $_REQUEST['DefaultLogin'], PDO::PARAM_STR);
        $stmt->bindParam(':AllowParentDBParam', $_REQUEST['AllowParentDBParam'], PDO::PARAM_STR);
        $stmt->bindParam(':AllowParentAPIParam', $_REQUEST['AllowParentAPIParam'], PDO::PARAM_STR);
        $stmt->bindParam(':AllowedFreshDeskUser', $_REQUEST['AllowedFreshDeskUser'], PDO::PARAM_STR);
        $stmt->bindParam(':EnableFreshDeskUser', $_REQUEST['EnableFreshDeskUser'], PDO::PARAM_STR);
        $stmt->bindParam(':SaveFilterBTN', $_REQUEST['SaveFilterBTN'], PDO::PARAM_STR);

        // $stmt->bindParam(':AllowNotification', $_REQUEST['AllowNotification'], PDO::PARAM_STR);
        // $stmt->bindParam(':SelectedNotification', $_REQUEST['SelectedNotification'], PDO::PARAM_STR);
        // $stmt->bindParam(':pushCronUpdateTime', $_REQUEST['pushCronUpdateTime'], PDO::PARAM_STR);

        $stmt->execute();
        return;
    }
    // This Function Allows to delete Users.
    public static function deleteUser($id)
    {
        $sql = "DELETE FROM Users WHERE UserID = ?";
        $db = static::getDB();
        $q = $db->prepare($sql);
        $response = $q->execute(array($id));
        return $response;
    }
    // This Function Allows to get a specific Users Detail.
    public static function getUserDetails($id)
    {
        if (!empty($id)) {
            $conditions[] = 'UserID = ?';
            $parameters[] = $id;
        }
        $sql = "SELECT * FROM Users";
        if ($conditions) {
            $sql .= " WHERE " . implode(" AND ", $conditions);
        }
        $db = static::getDB();
        $stmt = $db->prepare($sql);
        $stmt->execute($parameters);
        $data = $stmt->fetchAll();
       
        return $data;
    }
    // This Function Allows to get a specific Users Detail by its group .
    public static function getUserGroup($id)
    {
        $conditions = [];
        $parameters = [];
        if (!empty($id)) {
            $conditions[] = 'CompanyID = ?';
            $parameters[] = $id;
        }
        $db = static::getDB();
        $sql = "SELECT * FROM Users Where  UserGroupFlag = '1'";
        if ($conditions) {
            $sql .= " AND " . implode(" AND ", $conditions);
        }
        $stmt = $db->prepare($sql);
        $stmt->execute($parameters);
        $data = $stmt->fetchAll();
        return $data;
    }
    // This Function Allows to get Update Users Detail.
    public static function updateUser()
    {
        $sql = "UPDATE Users SET UserFirstName = :UserFirstName,
            UserLastName = :UserLastName,
            UserStartDate = :UserStartDate,
            UserEndDate = :UserEndDate,
            UserEmail = :UserEmail,
            UserPassword = :UserPassword,
            DBParam  = :DBParam ,
            APIParam = :APIParam,
            Auth  = :Auth ,
            UserGroupFlag = :UserGroupFlag,
            UserGroupActiveFlag = :UserGroupActiveFlag,
            AvailableUserGroup = :AvailableUserGroup,
            DefaultLogin = :DefaultLogin , 
            AllowParentDBParam = :AllowParentDBParam,
            AllowParentAPIParam = :AllowParentAPIParam,
            AllowedFreshDeskUser=:AllowedFreshDeskUser,
            EnableFreshDeskUser = :EnableFreshDeskUser, 
            SelectAllUsers =:SelectAllUsers, 
            SelectSpecficUsers =:SelectSpecficUsers,
            AllowNotification =:AllowNotification , 
            SelectedNotification = :SelectedNotification , 
            pushCronUpdateTime = :pushCronUpdateTime, 
            SaveFilterBTN= :SaveFilterBTN, 
            EnableCacheUser =:EnableCacheUser,
            TimeDurationRedisUser = :TimeDurationRedisUser, 
            TableSelection = :TableSelection, 
            TimeRedisUser=:TimeRedisUser , 
            TimeDurationRedisUserAPI = :TimeDurationRedisUserAPI, 
            TimeRedisUserAPI=:TimeRedisUserAPI , 
            OverwirteCompanySetting =:OverwirteCompanySetting,
            OverwirteUserAndCompanySetting =:OverwirteUserAndCompanySetting,
            DisableAPIDataRedisUser =:DisableAPIDataRedisUser
            WHERE CompanyID = :CompanyID AND UserID = :UserID";
        $db = static::getDB();
        $stmt = $db->prepare($sql);
        $stmt->bindParam(':UserFirstName', $_REQUEST['UserFirstName'], PDO::PARAM_STR);
        $stmt->bindParam(':UserLastName', $_REQUEST['UserLastName'], PDO::PARAM_STR);
        $stmt->bindParam(':UserStartDate', $_REQUEST['UserStartDate'], PDO::PARAM_STR);
        $stmt->bindParam(':UserEndDate', $_REQUEST['UserEndDate'], PDO::PARAM_STR);
        $stmt->bindParam(':UserEmail', $_REQUEST['UserEmail'], PDO::PARAM_STR);
        $stmt->bindParam(':UserPassword', $_REQUEST['UserPassword'], PDO::PARAM_STR);
        $stmt->bindParam(':DBParam', $_REQUEST['DBParam'], PDO::PARAM_STR);
        $stmt->bindParam(':APIParam', $_REQUEST['APIParam'], PDO::PARAM_STR);
        $stmt->bindParam(':Auth', $_REQUEST['Auth'], PDO::PARAM_STR);
        $stmt->bindParam(':UserGroupFlag', $_REQUEST['UserGroupFlag'], PDO::PARAM_STR);
        $stmt->bindParam(':UserGroupActiveFlag', $_REQUEST['UserGroupActiveFlag'], PDO::PARAM_STR);
        $stmt->bindParam(':AvailableUserGroup', $_REQUEST['AvailableUserGroup'], PDO::PARAM_STR);
        $stmt->bindParam(':DefaultLogin', $_REQUEST['DefaultLogin'], PDO::PARAM_STR);
        $stmt->bindParam(':CompanyID', $_REQUEST['CompanyID'], PDO::PARAM_INT);
        $stmt->bindParam(':UserID', $_REQUEST['UserID'], PDO::PARAM_INT);
        $stmt->bindParam(':AllowParentDBParam', $_REQUEST['AllowParentDBParam'], PDO::PARAM_INT);
        $stmt->bindParam(':AllowParentAPIParam', $_REQUEST['AllowParentAPIParam'], PDO::PARAM_INT);
        $stmt->bindParam(':EnableFreshDeskUser', $_REQUEST['EnableFreshDeskUser'], PDO::PARAM_STR);
        $stmt->bindParam(':AllowedFreshDeskUser', $_REQUEST['AllowedFreshDeskUser'], PDO::PARAM_STR);
        $stmt->bindParam(':SelectAllUsers', $_REQUEST['SelectAllUsers'], PDO::PARAM_STR);
        $stmt->bindParam(':SelectSpecficUsers', $_REQUEST['SelectSpecficUsers'], PDO::PARAM_STR);
        $stmt->bindParam(':AllowNotification', $_REQUEST['AllowNotification'], PDO::PARAM_STR);
        $stmt->bindParam(':SelectedNotification', $_REQUEST['SelectedNotification'], PDO::PARAM_STR);
        $stmt->bindParam(':pushCronUpdateTime', $_REQUEST['pushCronUpdateTime'], PDO::PARAM_STR);
        $stmt->bindParam(':SaveFilterBTN', $_REQUEST['SaveFilterBTN'], PDO::PARAM_STR);
        $stmt->bindParam(':EnableCacheUser', $_REQUEST['EnableCacheUser'], PDO::PARAM_STR);
        $stmt->bindParam(':TimeDurationRedisUser', $_REQUEST['TimeDurationRedisUser'], PDO::PARAM_STR);
        $stmt->bindParam(':TableSelection', $_REQUEST['TableSelection'], PDO::PARAM_STR);
        $stmt->bindParam(':TimeRedisUser', $_REQUEST['TimeRedisUser'], PDO::PARAM_STR);
        $stmt->bindParam(':TimeDurationRedisUserAPI', $_REQUEST['TimeDurationRedisUserAPI'], PDO::PARAM_STR);
        $stmt->bindParam(':TimeRedisUserAPI', $_REQUEST['TimeRedisUserAPI'], PDO::PARAM_STR);
        $stmt->bindParam(':OverwirteCompanySetting', $_REQUEST['OverwirteCompanySetting'], PDO::PARAM_STR);
        $stmt->bindParam(':OverwirteUserAndCompanySetting', $_REQUEST['OverwirteUserAndCompanySetting'], PDO::PARAM_STR);
        $stmt->bindParam(':DisableAPIDataRedisUser', $_REQUEST['DisableAPIDataRedisUser'], PDO::PARAM_STR);
        
        
        $stmt->execute();
        return;
    }
    // This Function Allows to get All Pages.
    public static function getAllPages()
    {
        $db = static::getDB();
        $sql = "SELECT * FROM Pages";
        $stmt = $db->query($sql);
        $data = $stmt->fetchAll();
        return $data;
    }

    // This Function Allows Execute the query that are actaully Made and saved at DataSource side.
    public static function executeQuery($query, $databaseName, $Table = '' )
    {
       $db = Self::getUserDB($databaseName);
	
       $data = [];
      if(isset($_SESSION['dataSourceDbType']) && $_SESSION['dataSourceDbType'] == 'mongodb' )

        {
           
            // check for collection whether it exist or not 
           // $query = 'productInfo';
            $command = new MongoDB\Driver\Command(['listCollections' => 1, 'filter' => ['name' => $query]]);
            $result = $db->executeCommand($_SESSION['DBName'], $command)->toArray();
            
            if(empty($result)){
                $command = new MongoDB\Driver\Command(["create" => $query, "autoIndexId" => true]);

                $collection = $db->executeCommand($_SESSION['DBName'], $command)->toArray();

                if($collection[0]->ok)

                {
                    $filter  = [];
                    $options = [];
                    $getData = new MongoDB\Driver\Query($filter, $options);

                    $rows   = $db->executeQuery( $_SESSION['DBName'].'.'.$query, $getData );
                    $data  = $rows->toArray();
                    $data  =  json_decode(json_encode($data), true);
                }
           

            }else{
                
                    $filter  = [];
                    $options = [];
                    $getData = new MongoDB\Driver\Query($filter, $options);

                    $rows   = $db->executeQuery( $_SESSION['DBName'].'.'.$query, $getData );
                    $data  = $rows->toArray();
                    $data  =  json_decode(json_encode($data), true);
                
                   
            }
            
        }else{

                try{
                   
                    $stmt = $db->query($query);
                    $data = $stmt->fetchAll();
                   // print_r($data); exit;
                 }catch(PDOException $e){
                    if( $e->getCode() == '42S02'){
                        $data = 'createTable';
                    }
                       
                    
                 }
              

        }

        return $data;

    }
    public static function AddQuery($query, $databaseName)
    {

        $db = Self::getUserDB($databaseName);
       
        $data = $db->exec($query);
        return $data ;
    }

     public static function AddQueryMongo($table, $doc , $op , $editColName = '' ,  $editCol = '')
    {

        $db = Self::getUserDB($table);
       
        if($op == 'create')
        {
            $filter  = [];
            $options = [];
            $getData = new MongoDB\Driver\Query($filter, $options);
 
            $rows   = $db->executeQuery( $_SESSION['DBName'].'.'.$table, $getData );
            $data  = $rows->toArray();
            $data  =  json_decode(json_encode($data), true);
            if($data){
                $data  =  end($data);
                $count = $data['ID'];
            }else{
                $count = 0;
            }
            
            $bulkWrite=new MongoDB\Driver\BulkWrite;
            foreach ($doc as $key => $value) {
                $count = (int)$count+1;
                $value['ID'] = (string)$count;
                $bulkWrite->insert($value);
            }

            $retval1 = $db->executeBulkWrite($_SESSION['DBName'].'.'.$table, $bulkWrite);
            if($retval1->getInsertedCount())
                return 1;
            else
                return 0;
        }else if($op == 'edit')
        {
            $bulk = new MongoDB\Driver\BulkWrite(['ordered' => false]);
           
            if($editColName != '' && $editCol!= ''){

                $bulk->update([$editColName => $editCol], $doc);
            }
            elseif($doc['ID']){
                $bulk->update(['ID' => $doc['ID']], $doc);
            }else{
                 $bulk->update(array(), $doc, array('multiple'=>true));
            }
           
            $rows   = $db->executeBulkWrite($_SESSION['DBName'].'.'.$table, $bulk);
            
            if($rows)
                return 1;
            else
                return 0; 
        }else if ($op == 'remove'){
            $bulk = new MongoDB\Driver\BulkWrite;
            if($doc['ID'] == 'all')
            {
                $command = new MongoDB\Driver\Command(["drop" => $table]);

                $rows = $db->executeCommand($_SESSION['DBName'],  $command);

            }else{
                $bulk->delete($doc);
                $rows = $db->executeBulkWrite($_SESSION['DBName'].'.'.$table, $bulk);
            }
           
            if($rows)
                return 1;
            else
                return 0; 
        }
       
    }

    // This Function Allows Update User NOWTIME.
   
    public static function updateUserNowTime($id, $nowTime)
    {
        $sql = "UPDATE Users SET NowTime = :NowTime
            WHERE UserID = :UserID";
        $db = static::getDB();

        $stmt = $db->prepare($sql);
        $stmt->bindParam(':NowTime', $nowTime, PDO::PARAM_INT);
        $stmt->bindParam(':UserID', $id, PDO::PARAM_INT);
        $stmt->execute();
        return;
    }
    // This Function allows to keeps a history of LOGS.
    public static function updateUserLog($data)
    {
        $sql = "INSERT INTO UserHistory(UserId,CompanyID,UserName,IPAddress,DateCreated,LastLoginDate,LastLoginTime, UserAgent ,City ,Country)
                VALUES (:UserId,:CompanyID,:UserName,:IPAddress,:DateCreated,:LastLoginDate,:LastLoginTime, :UserAgent ,:City , :Country)";
        $db = static::getDB();
        $stmt = $db->prepare($sql);
        if(isset($_SESSION['ParentUserFirstName'])){
            $username = $_SESSION['ParentUserFirstName']." AS ".$data['UserFirstName'];
            $companyID = $data['CompanyID'];
            $userId = $data['UserID'];
        }else{
            $username = $data['UserFirstName']." ".$data['UserLastName'];
            $companyID = $data['CompanyID'];
            $userId = $data['UserID'];
        }
        $ip = self::getRealIpAddr();

        $currDate = date('Y-m-d H:m:s');
        $date = date('Y-m-d');
        $time = date('H:i:s');
        $UserAgent =  self::getBrowser();
        
        $stmt->bindParam(':CompanyID', $companyID, PDO::PARAM_STR);
        $stmt->bindParam(':UserId', $userId, PDO::PARAM_STR);
        $stmt->bindParam(':UserName', $username, PDO::PARAM_STR);
        $stmt->bindParam(':IPAddress', $ip , PDO::PARAM_STR);
        $stmt->bindParam(':DateCreated', $currDate, PDO::PARAM_STR);
        $stmt->bindParam(':LastLoginDate', $date, PDO::PARAM_STR);
        $stmt->bindParam(':LastLoginTime', $time, PDO::PARAM_STR);
        $stmt->bindParam(':LastLoginTime', $time, PDO::PARAM_STR);
        $stmt->bindParam(':LastLoginTime', $time, PDO::PARAM_STR);
        $stmt->bindParam(':UserAgent', $UserAgent, PDO::PARAM_STR);
        $stmt->bindParam(':City', $data['City'], PDO::PARAM_STR);
        $stmt->bindParam(':Country', $data['Country'], PDO::PARAM_STR);
        $stmt->execute();
        return;
    }
    //This function is used to get the Brwser from which a user has loggedIN .
    public static function getBrowser(){
        $val = '' ;
        if(strpos($_SERVER['HTTP_USER_AGENT'], 'MSIE') !== FALSE)
          $val = 'Internet explorer';
         elseif(strpos($_SERVER['HTTP_USER_AGENT'], 'Trident') !== FALSE) //For Supporting IE 11
            $val ='Internet explorer';
         elseif(strpos($_SERVER['HTTP_USER_AGENT'], 'Firefox') !== FALSE)
           $val = 'Mozilla Firefox';
         elseif(strpos($_SERVER['HTTP_USER_AGENT'], 'Chrome') !== FALSE)
           $val = 'Google Chrome';
         elseif(strpos($_SERVER['HTTP_USER_AGENT'], 'Opera Mini') !== FALSE)
           $val = "Opera Mini";
         elseif(strpos($_SERVER['HTTP_USER_AGENT'], 'Opera') !== FALSE)
           $val ="Opera";
         elseif(strpos($_SERVER['HTTP_USER_AGENT'], 'Safari') !== FALSE)
           $val = "Safari";
         else
           $val = 'Something else';
       return $val;
    }
    // This function return return the IP address of User from where he might have logged IN.
    public static function getRealIpAddr()
    {
        if (!empty($_SERVER['HTTP_CLIENT_IP'])) 
        {
          $ip=$_SERVER['HTTP_CLIENT_IP'];
        }
        elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR']))
        {
          $ip=$_SERVER['HTTP_X_FORWARDED_FOR'];
        }
        else
        {
          $ip=$_SERVER['REMOTE_ADDR'];
        }
        return $ip;
    }
    // to close a connection of DB.
    public static function closeConnection()
    {
        Self::closeConnections();
    }

}
