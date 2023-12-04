<?php

namespace Core;

use PDO;
use App\Config;
use \App\Models\AdminDBs;
use MongoDB;
use PDOException;
/**
 * Base model
 *
 * PHP version 7.0
 */
abstract class Model
{

    /**
     * Get the PDO database connection
     *
     * @return mixed
     */
    private static $db = null;
    private static $db2 = null;
    private static $dbM = null;
    protected static function getDB()
    {
        static $db = null;
        
        if ($db === null) {
            $db = new PDO("sqlsrv:Server=".Config::DB_HOST.";Database=".Config::DB_NAME.";", "".Config::DB_USER."", "".Config::DB_PASSWORD."");

            // Throw an Exception when an error occurs
            $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        }

        return $db;
    }
    protected static function getUserDB($databaseName)
    {
        static $db2 = null;
        static $dbM = null;
     
        if ($db2 === null || $dbM === null) {
            $hostName = ''; 
            $dbName =  '';
            $DBType = '';
            $uName=  '';
            $pwd =  '';
         
           
            if(isset ($_SESSION['AdminDb']) && count($_SESSION['AdminDb']) > 0 && isset($_SESSION['dataSourceDbType']) )
            {
                foreach ($_SESSION['AdminDb'] as $key => $value) {
                    if($value[0] == $_SESSION['dataSourceDbType']){
                            $getadminDB = AdminDBs::getAdminDB($_SESSION['dataSourceDbType']);
                          
                            $hostName = $getadminDB[0]['HostName']; 
                            $dbName =  $getadminDB[0]['DBName'];
                            $DBType = $getadminDB[0]['DBType'];
                            $uName=  $getadminDB[0]['Username'];
                            $pwd =   $getadminDB[0]['DBPassword'];
                            $_SESSION['DBhost'] = $hostName;
                            $_SESSION['DBName'] = $dbName;
                            $_SESSION['DBUname'] = $uName;
                            $_SESSION['pwd'] =  $pwd;
                            $_SESSION['DBType'] = $DBType;
                    }
                   
                }
               

            }
        
            if(isset($_SESSION['dataSourceDbType']) && ($_SESSION['dataSourceDbType'] == 'mysql' || $_SESSION['dataSourceDbType'] == 'pgsql' || $DBType == 'mysql' || $DBType == 'pgsql'))
            {
                
                $dbCr = '';
                if($hostName == '')
                {
                    foreach($_SESSION['CompanyHostName'] as $key => $val)
                    {
                         if($key == $_SESSION['dataSourceDbType'])
                         {
                            $dbCr = $val[$_SESSION['dataSourceDbType']];

                            $dbCr = $dbCr[0];
                            $dbCr = explode('|', $dbCr);
                            $hostName = explode(':', $dbCr[0]);
                            $hostName = $hostName[1]; 
                            
                            $dbName = explode(':', $dbCr[1]);
                            $dbName =  $dbName[1];
                            $DBType = $_SESSION['dataSourceDbType'];
                            $uName=explode(':', $dbCr[2]);
                            $uName= $uName[1];

                            $pwd = explode(':', $dbCr[3]);
                            $pwd =  $pwd[1];
                            $_SESSION['DBhost'] = $hostName;
                            $_SESSION['DBName'] = $dbName;
                            $_SESSION['DBUname'] = $uName;
                            $_SESSION['pwd'] =  $pwd;
                             $_SESSION['DBType'] = $DBType;

                        }
                            
                    }
                }
                

                $db2 = new PDO($DBType.':host='.$hostName.';dbname='.$dbName,  $uName, $pwd);
                
                $db2->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            }
			else{
                if(isset($_SESSION['dataSourceDbType']) && $_SESSION['dataSourceDbType'] == 'sqlsrv'  || $DBType == 'sqlsrv')
                {
                   
                    $dbCr = '';
                    if(!empty($_SESSION['CompanyHostName']))
                    {
                        foreach($_SESSION['CompanyHostName'] as $key => $val)
                        {
                             if($key == $_SESSION['dataSourceDbType'])
                             {
                                $dbCr = $val[$_SESSION['dataSourceDbType']];

                                $dbCr = $dbCr[0];
                                $dbCr = explode('|', $dbCr);
                                $hostName = explode(':', $dbCr[0]);
                                $hostName = $hostName[1]; 
                                
                                $dbName = explode(':', $dbCr[1]);
                                $dbName =  $dbName[1];
                                $DBType = $_SESSION['dataSourceDbType'];
                                $uName=explode(':', $dbCr[2]);
                                $uName= $uName[1];

                                $pwd = explode(':', $dbCr[3]);
                                $pwd =  $pwd[1];

                            }
                                
                        }
                        $db2 = new PDO("sqlsrv:Server=".$hostName.";Database=".$dbName.";MultipleActiveResultSets=false;connectionpooling=0", "".$uName."", "".$pwd."");
                        $db2->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                    }else{
                        // $db2 = new PDO("sqlsrv:Server=".Config::DB_HOST.";Database=".$databaseName.";MultipleActiveResultSets=false;connectionpooling=0", "".Config::DB_USER."", "".Config::DB_PASSWORD."");
                        // $db2->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                        try{
                            $db2 = new PDO("sqlsrv:Server=".Config::DB_HOST.";Database=".$databaseName.";MultipleActiveResultSets=false;connectionpooling=0", "".Config::DB_USER."", "".Config::DB_PASSWORD."");
                            $db2->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                         }catch(\PDOException $e){
                              
                                echo $e->getMessage();
                                exit;
                         }
                    }
                   
                 
                }else{
                    
                 try{
                    $db2 = new PDO("sqlsrv:Server=".Config::DB_HOST.";Database=".$databaseName.";MultipleActiveResultSets=false;connectionpooling=0", "".Config::DB_USER."", "".Config::DB_PASSWORD."");
                    //$db2->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                 }catch(PDOException $e){
                     
                        echo $e->getMessage();
                        exit;
                 }
                 
                }

                 
            } 



           
        }

        return $db2;
    }


    protected static function closeConnections()
    {
        $db = null;
        $db2 = null;
    }
    protected static function redisConnect(){
        // Connecting to Redis server on localhost
        $redis = new Redis();
        $redis->connect('127.0.0.1', 6379);
        // Check whether server is running or not
        //echo 'Redis is running: ' . $redis->ping() . '<br>'; 
    }
}
