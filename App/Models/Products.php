<?php

namespace App\Models;

use PDO;
use MongoDB;
use phpseclib\Crypt\RSA;
use phpseclib\Net\SFTP;


/**
 * Example user model
 *
 * PHP version 7.0
 */
class Products extends \Core\Model
{
	// This Function Allows to Add data in MongoDb
	public static function addProduct()
    {
     
	 
	    $data =$_REQUEST;
	  	// Establish MongoDB Connection
	    //$connection = new MongoDB\Driver\Manager('mongodb://localhost:27017/babcProducts');
			if(isset($_SESSION['CompanyHostName']))
			{
				$dbCr = '';
				
				$hostName = ''; 
	            $dbName =  '';
	            $DBType = '';
	            $uName=  '';
	            $pwd =  '';

           
	            if(isset ($_SESSION['AdminDb']) && count($_SESSION['AdminDb']) > 0  )
	            {
	                
	                foreach ($_SESSION['AdminDb'] as $key => $value) {
	                  
	                            $getadminDB = AdminDBs::getAdminDB($value[0]);
	                          
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
	               

	            }else{
	              
					foreach($_SESSION['CompanyHostName'] as $key => $val)
					{
							 if(array_key_exists('mongodb', $val))
							 {
									$dbCr = $val['mongodb'];

									$dbCr = $dbCr[0];
									$dbCr = explode('|', $dbCr);
									$hostName = explode(':', $dbCr[0]);
									$hostName = $hostName[1].':'. $hostName[2]; 
									
									$dbName = explode(':', $dbCr[1]);
									$dbName =  $dbName[1];
									$uName=explode(':', $dbCr[2]);
									$uName= $uName[1];

									$pwd = explode(':', $dbCr[3]);
									$pwd =  $pwd[1];
									$_SESSION['DBhost'] = $hostName;
		                            $_SESSION['DBName'] = $dbName;
		                            $_SESSION['DBUname'] = $uName;
		                            $_SESSION['pwd'] =  $pwd;
		                            $_SESSION['DBType'] = 'mongodb';

							}		
					}
				}
				$connection = new MongoDB\Driver\Manager('mongodb://'.	$uName.':'.	$pwd.'@'.	$hostName.'/'.	$dbName.'?authSource=admin&keepAlive=true&poolSize=30&autoReconnect=true&socketTimeoutMS=360000&connectTimeoutMS=360000');
	
			}
			else 	{
				$connection = new MongoDB\Driver\Manager('mongodb://root:bt4GGm5dq1SD@34.65.55.199:27017/B2SBC?authSource=admin&keepAlive=true&poolSize=30&autoReconnect=true&socketTimeoutMS=360000&connectTimeoutMS=360000');
	
			}
			
			$ids = [];
	  		//$name  = array_keys($_FILES);
	  		//$name = $_FILES['uploadImage_MongoDB'][0];
			  $name = 'uploadImage_MongoDB';
			 
		  	if(!empty($_FILES[$name]["tmp_name"])){
		  		foreach ($_FILES[$name]["tmp_name"] as $tmpNameKey => $tmpNameValue) {
		  		if($tmpNameValue){
			  		$bulkWrite=new MongoDB\Driver\BulkWrite;
					$doc=array();
			  		$imageId = new MongoDB\BSON\ObjectID;
					$doc = ['_id'=>	$imageId];
					array_push($ids, $imageId);
			  		$doc[$name] = new MongoDB\BSON\Binary(file_get_contents($_FILES[$name]["tmp_name"][$tmpNameKey]), MongoDB\BSON\Binary::TYPE_GENERIC);
			  		$bulkWrite->insert($doc);
					$retval = $connection->executeBulkWrite('B2SBC.ImageInfo', $bulkWrite);
			  	}
			  }
		  	}
		  	$imgUrls = [];
		  	$name = 'uploadImage_Folder';

		  	if(!empty($_FILES[$name]["tmp_name"])){

		  			//$CompanyId = explode('-', $_SESSION['CompanyName']);
		            // $dir = dirname( __FILE__ );
		           
		            // if(baseUrl == 'http://www.babcnew.com/')
		            // {
		            //     $dir = explode('BP', $dir);
		            // }else{
		            //     $dir = explode('bpu', $dir);
		            // }
					
    				$dir    = 'http://212.247.32.103:8082/images/';

		            $CompanyDir = $dir.trim($_SESSION['CompanyName']).'/';
		            $CompanyUserDir = $dir.trim($_SESSION['CompanyName']).'/'.$_SESSION['username'].'/';
						
		            if( is_dir($CompanyDir) === false )
		            {
		                 mkdir($CompanyDir);
		            }
		            if(is_dir($CompanyUserDir) === false){
		                mkdir($CompanyUserDir);
		            }
		           
		            $Imagepath= '';
		            if(!empty($_FILES[$name]['tmp_name'])){
		            	foreach ($_FILES[$name]['name'] as $namekey => $namevalue) {
		            		
		            		$Imagename=$namevalue; 
			            
			                $Imagepath= $CompanyUserDir.$Imagename;
			                $ImagepathSave =$dir.trim($_SESSION['CompanyName']).'/'.$_SESSION['username'].'/'.$Imagename;
			                move_uploaded_file($_FILES[$name]["tmp_name"][$namekey],$Imagepath);
			                array_push($imgUrls, $ImagepathSave);
		            	}
		                
		             }

		  	}

			$bulkWrite=new MongoDB\Driver\BulkWrite;
		  	$doc=array();
		 	  $doc = array(
			  	"userId" => $_SESSION['UserID'],
					"userEmail" => $_SESSION['username'],
					"ImageId" => $ids,
					"ImageUrl" => $imgUrls
					
		  	);
		  	foreach ($data as $key => $value) {
		  		if($key != 'saveDataToMongoDB'){
		  			$doc[$key] = $value;
		  		}
	  		
	  	}  	
		$bulkWrite->insert($doc);
		$retval1 = $connection->executeBulkWrite('B2SBC.productInfo', $bulkWrite);
		if($retval1->getInsertedCount())
			return 1;
		else
			return 0;    
    }
    // This Function Fetch Specfic data in MongoDb
	
    public static function getProduct($select,$id)
    {
     
	    $data =$_REQUEST;
	  	// Establish MongoDB Connection
	    //$connection = new MongoDB\Driver\Manager('mongodb://localhost:27017/babcProducts');
			if(isset($_SESSION['CompanyHostName']))
			{
				$dbCr = '';
				$hostName = ''; 
	            $dbName =  '';
	            $DBType = '';
	            $uName=  '';
	            $pwd =  '';

           
	            if(isset ($_SESSION['AdminDb']) && count($_SESSION['AdminDb']) > 0  )
	            {
	               
	                foreach ($_SESSION['AdminDb'] as $key => $value) {
	                  
	                            $getadminDB = AdminDBs::getAdminDB($value[0]);
	                          
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
	               

	            }else{
	              
					foreach($_SESSION['CompanyHostName'] as $key => $val)
					{
							 if(array_key_exists('mongodb', $val))
							 {
									$dbCr = $val['mongodb'];

									$dbCr = $dbCr[0];
									$dbCr = explode('|', $dbCr);
									$hostName = explode(':', $dbCr[0]);
									$hostName = $hostName[1].':'. $hostName[2]; 
									
									$dbName = explode(':', $dbCr[1]);
									$dbName =  $dbName[1];
									$uName=explode(':', $dbCr[2]);
									$uName= $uName[1];

									$pwd = explode(':', $dbCr[3]);
									$pwd =  $pwd[1];
									$_SESSION['DBhost'] = $hostName;
		                            $_SESSION['DBName'] = $dbName;
		                            $_SESSION['DBUname'] = $uName;
		                            $_SESSION['pwd'] =  $pwd;
		                            $_SESSION['DBType'] = 'mongodb';

							}		
					}
				}
				$connection = new MongoDB\Driver\Manager('mongodb://'.	$uName.':'.	$pwd.'@'.	$hostName.'/'.	$dbName.'?authSource=admin&keepAlive=true&poolSize=30&autoReconnect=true&socketTimeoutMS=360000&connectTimeoutMS=360000');
	
			}
			else 	{
				$connection = new MongoDB\Driver\Manager('mongodb://root:bt4GGm5dq1SD@34.65.55.199:27017/B2SBC?authSource=admin&keepAlive=true&poolSize=30&autoReconnect=true&socketTimeoutMS=360000&connectTimeoutMS=360000');
	
			}

		$filter   = ['ProductNo' => $id];
  	    $options = [ 'projection' => $select, 'limit' => 1  ];
		$query = new MongoDB\Driver\Query($filter, $options);

		$rows   = $connection->executeQuery('B2SBC.productInfo', $query);
		$rowsArr = $rows->toArray();

		if($rowsArr)
			return $rowsArr;
		else
			return 0;    
    }
    // This Function Fetch All  data in MongoDb
	
    public static function getAllProduct($select, $filter , $tableId)
    {
     
	    $data =$_REQUEST;
	  	// Establish MongoDB Connection
	    //$connection = new MongoDB\Driver\Manager('mongodb://localhost:27017/babcProducts');
			if(isset($_SESSION['CompanyHostName']))
			{
				$dbCr = '';
			
				$hostName = ''; 
	            $dbName =  '';
	            $DBType = '';
	            $uName=  '';
	            $pwd =  '';

       
	            if(isset ($_SESSION['AdminDb']) && count($_SESSION['AdminDb']) > 0  )
	            {

	                foreach ($_SESSION['AdminDb'] as $key => $value) {
	                  
	                            $getadminDB = AdminDBs::getAdminDB($value[0]);
	                          
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
	               

	            }else{
	              
					foreach($_SESSION['CompanyHostName'] as $key => $val)
					{
							 if(array_key_exists('mongodb', $val))
							 {
									$dbCr = $val['mongodb'];

									$dbCr = $dbCr[0];
									$dbCr = explode('|', $dbCr);
									$hostName = explode(':', $dbCr[0]);
									$hostName = $hostName[1].':'. $hostName[2]; 
									
									$dbName = explode(':', $dbCr[1]);
									$dbName =  $dbName[1];
									$uName=explode(':', $dbCr[2]);
									$uName= $uName[1];

									$pwd = explode(':', $dbCr[3]);
									$pwd =  $pwd[1];
									$_SESSION['DBhost'] = $hostName;
		                            $_SESSION['DBName'] = $dbName;
		                            $_SESSION['DBUname'] = $uName;
		                            $_SESSION['pwd'] =  $pwd;
		                            $_SESSION['DBType'] = 'mongodb';

							}		
					}
				}
				$connection = new MongoDB\Driver\Manager('mongodb://'.	$uName.':'.	$pwd.'@'.	$hostName.'/'.	$dbName.'?authSource=admin&keepAlive=true&poolSize=30&autoReconnect=true&socketTimeoutMS=360000&connectTimeoutMS=360000');
	
			}
			else 	{
				$connection = new MongoDB\Driver\Manager('mongodb://root:bt4GGm5dq1SD@34.65.55.199:27017/B2SBC?authSource=admin&keepAlive=true&poolSize=30&autoReconnect=true&socketTimeoutMS=360000&connectTimeoutMS=360000');
	
			}
		if(isset($filter['ProductNo'])){
			$newfilter = new \MongoDB\BSON\Regex($filter['ProductNo']);
	  	    
	  	    $filter['ProductNo'] = $newfilter;
  		}
		if($select == 'ALL'){
			$query = new MongoDB\Driver\Query($filter);
		}  else{
			$options = [ 'projection' => $select ]; 
			$query = new MongoDB\Driver\Query($filter, $options);
		}
  	   

		$rows   = $connection->executeQuery($tableId, $query);
		$rowsArr = $rows->toArray();
		
		if($rowsArr)
			return $rowsArr;
		else
			return 0;    
    }
    // This Function Update data in MongoDb
	
    public static function UpdateProduct()
    {
     
	    $data =$_REQUEST;
	  	// Establish MongoDB Connection
			//$connection = new MongoDB\Driver\Manager('mongodb://localhost:27017/babcProducts');
		
			if(isset($_SESSION['CompanyHostName']))
			{
				$dbCr = '';

				$hostName = ''; 
	            $dbName =  '';
	            $DBType = '';
	            $uName=  '';
	            $pwd =  '';

           
            if(isset ($_SESSION['AdminDb']) && count($_SESSION['AdminDb']) > 0  )
            {
                
                foreach ($_SESSION['AdminDb'] as $key => $value) {
                  
                            $getadminDB = AdminDBs::getAdminDB($value[0]);
                          
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
               

            }else{
              
				foreach($_SESSION['CompanyHostName'] as $key => $val)
				{
						 if(array_key_exists('mongodb', $val))
						 {
								$dbCr = $val['mongodb'];

								$dbCr = $dbCr[0];
								$dbCr = explode('|', $dbCr);
								$hostName = explode(':', $dbCr[0]);
								$hostName = $hostName[1].':'. $hostName[2]; 
								
								$dbName = explode(':', $dbCr[1]);
								$dbName =  $dbName[1];
								$uName=explode(':', $dbCr[2]);
								$uName= $uName[1];

								$pwd = explode(':', $dbCr[3]);
								$pwd =  $pwd[1];
								$_SESSION['DBhost'] = $hostName;
	                            $_SESSION['DBName'] = $dbName;
	                            $_SESSION['DBUname'] = $uName;
	                            $_SESSION['pwd'] =  $pwd;
	                            $_SESSION['DBType'] = 'mongodb';

						}		
				}
			}
				$connection = new MongoDB\Driver\Manager('mongodb://'.	$uName.':'.	$pwd.'@'.	$hostName.'/'.	$dbName.'?authSource=admin&keepAlive=true&poolSize=30&autoReconnect=true&socketTimeoutMS=360000&connectTimeoutMS=360000');
	
			}
			else 	{
				$connection = new MongoDB\Driver\Manager('mongodb://root:bt4GGm5dq1SD@34.65.55.199:27017/B2SBC?authSource=admin&keepAlive=true&poolSize=30&autoReconnect=true&socketTimeoutMS=360000&connectTimeoutMS=360000');
	
			}	

		//$bulkWrite=new MongoDB\Driver\BulkWrite;
			if(isset($data['uploadImage']))
			{
				unset($data['uploadImage']);
			}
			if(isset($data['imageId']))
			{	
				$ids = [];
				foreach ($data['imageId'] as $key => $value) {
					
					$imageId = new MongoDB\BSON\ObjectID($value['$oid']);
					array_push($ids, $imageId);
				}
				
				unset($data['imageId']);
				unset($data['EditedImage']);
				
			}else if(isset($data['imageIdOrg'])){
				$ids = [];
				$ids = $data['imageIdOrg'];

			}else{
					$ids = [];
			}
			
	  		//$name  = array_keys($_FILES);

	  	
	  		$name = 'uploadImage_MongoDB';

		  	if(!empty($_FILES[$name]["tmp_name"])){
		  		foreach ($_FILES[$name]["tmp_name"] as $tmpNameKey => $tmpNameValue) {
		  			if($tmpNameValue){
				  		$bulkWrite=new MongoDB\Driver\BulkWrite;
						$doc=array();
				  		$imageId = new MongoDB\BSON\ObjectID;
						$doc = ['_id'=>	$imageId];
						array_push($ids, $imageId);
				  		$doc[$name] = new MongoDB\BSON\Binary(file_get_contents($_FILES[$name]["tmp_name"][$tmpNameKey]), MongoDB\BSON\Binary::TYPE_GENERIC);
				  		$bulkWrite->insert($doc);
						$retval = $connection->executeBulkWrite('B2SBC.ImageInfo', $bulkWrite);
					}
			  	}
		  	}

		  	$imgUrls = [];
		  	$name = 'uploadImage_Folder';

		  		if(!empty($_FILES[$name]["tmp_name"])){


					if($_SESSION['SFTPCredential']){

						$SFTPCredential = explode('|', $_SESSION['SFTPCredential']);
						$hostName =  explode(":", $SFTPCredential[0]);
						$hostName = $hostName[1];
						
						$username = explode(":", $SFTPCredential[1]);
						$username = $username[1];

						$folder = explode(":", $SFTPCredential[2]);
						$folder = $folder[1];

						$privateKeyName = $_SESSION['SFTPKeys'];

				  		$sftp = new SFTP($hostName);

						$Key = new RSA();
						
						// Next load the private key using file_gets_contents to retrieve the key
						$Key->loadKey(file_get_contents(baseUrl.'assets/keys/'.$privateKeyName));
						
						if($sftp->login($username, $Key)){
							
							
							$CompanyDir = 'htdocs/'.$folder.'/'.trim($_SESSION['CompanyName']).'/';

				            $CompanyUserDir = 'htdocs/'.$folder.'/'.trim($_SESSION['CompanyName']).'/'.$_SESSION['username'].'/';
							
				            if( empty($sftp->is_dir($CompanyDir) ) )
				            {
				                $sftp->mkdir( $CompanyDir);
				            }
				            if(   empty($sftp->is_dir($CompanyUserDir)) ){
				                $sftp->mkdir( $CompanyUserDir);
				            }
				
							foreach ($_FILES[$name]['name'] as $namekey => $namevalue) {

								$Imagename= explode('.',$namevalue ); 
								$Imagename=$data['ProductNo'].".".$Imagename[1];
				            	$destination_file = $CompanyUserDir.$Imagename;
								$source_file= $_FILES[$name]["tmp_name"][$namekey];
								
								$sftp->put($destination_file, $source_file , SFTP::SOURCE_LOCAL_FILE );

				            }
							
						}

				  	}else if($_SESSION['FTPCredential']){

		  				$FTPCredential = explode('|', $FTPCredential);

						$ftp_server = explode(':', $FTPCredential[0]);
						$ftp_server = $ftp_server[1];
						
						$ftp_user_name = explode(':', $FTPCredential[1]);
						$ftp_user_name = $ftp_user_name[1];

						$ftp_user_pass = explode(':', $FTPCredential[2]);
						$ftp_user_pass = $ftp_user_pass[1];

						$ftp_folder = explode(':', $FTPCredential[3]);
						$ftp_folder = $ftp_folder[1];

						// set up basic connection
						$conn_id = ftp_connect($ftp_server);

						// login with username and password
						$login_result = ftp_login($conn_id, $ftp_user_name, $ftp_user_pass); 
						ftp_pasv($conn_id, true); 
					
						$CompanyDir = '/'.$ftp_folder.'/'.trim($_SESSION['CompanyName']).'/';

			            $CompanyUserDir =  '/'.$ftp_folder.'/'.trim($_SESSION['CompanyName']).'/'.$_SESSION['username'].'/';
			         
			            if( is_dir($CompanyDir) === false )
			            {
			                ftp_mkdir($conn_id , $CompanyDir);
			            }
			            if(is_dir($CompanyUserDir) === false){
			                ftp_mkdir($conn_id , $CompanyUserDir);
			            }
						
						$destination_file = '/'.$ftp_folder.'/'.trim($_SESSION['CompanyName']).'/'.$_SESSION['username'].'/'.$_FILES['uploadImage_Folder']['name'][0];
						$source_file= $_FILES['uploadImage_Folder']['tmp_name'][0];

						// upload the file
						$upload = ftp_put($conn_id, $destination_file, $source_file, FTP_ASCII); 

						// close the FTP stream 
						ftp_close($conn_id);
					}else if($_SESSION['AllowCompanyFolder']){
						    $dir = dirname( __FILE__ );
		           
				            if(baseUrl == 'http://www.babcnew.com/')
				            {
				                $dir = explode('BP', $dir);
				            }else{
				                $dir = explode('bpu', $dir);
				            }

				            $CompanyDir = $dir[0].'API-IMG/'.trim($_SESSION['CompanyName']).'/';
				            $CompanyUserDir = $dir[0].'API-IMG/'.trim($_SESSION['CompanyName']).'/'.$_SESSION['username'].'/';
				         
				            if( is_dir($CompanyDir) === false )
				            {
				               
				                 mkdir($CompanyDir);
				            }
				            if(is_dir($CompanyUserDir) === false){
				                mkdir($CompanyUserDir);
				            }
				           
				            $Imagepath= '';
				            if(!empty($_FILES[$name]['tmp_name'])){
				            	foreach ($_FILES[$name]['name'] as $namekey => $namevalue) {
				            		
				            		$Imagename=$namevalue; 
					            
					                $Imagepath= $CompanyUserDir.$Imagename;
					                $ImagepathSave = baseUrl.'API-IMG/'.trim($_SESSION['CompanyName']).'/'.$_SESSION['username'].'/'.$Imagename;
					                move_uploaded_file($_FILES[$name]["tmp_name"][$namekey],$Imagepath);
					                array_push($imgUrls, $ImagepathSave);
				            	}
				                
				             }
					 
					}
		  			
		   
			  		
			  
		  	}
		 
		$bulk = new MongoDB\Driver\BulkWrite(['ordered' => false]);
			$doc=array();
		 	  $doc = array(
			  	"userId" => $_SESSION['UserID'],
				"userEmail" => $_SESSION['username'],
				"ImageId" =>  $ids,
				"ImageUrl" => $imgUrls
				
		  	);
		 	
		  	foreach ($data as $key => $value) {
		  		if($key != 'saveDataToMongoDB'){
		  			$doc[$key] = $value;
		  		}
		  	}
		
		$bulk->update(["ProductNo" => $data['ProductNo']], $doc);
		$rows   = $connection->executeBulkWrite('B2SBC.productInfo', $bulk);
		if($rows)
			return 1;
		else
			return 0;    
    }
    // This Function Fetch Images from in MongoDb
	
    public static function getImages($filter){
		
		if(isset($_SESSION['CompanyHostName']))
			{
				$dbCr = '';
				$hostName = ''; 
	            $dbName =  '';
	            $DBType = '';
	            $uName=  '';
	            $pwd =  '';

           
	            if(isset ($_SESSION['AdminDb']) && count($_SESSION['AdminDb']) > 0  )
	            {
	                
	                foreach ($_SESSION['AdminDb'] as $key => $value) {
	                  
	                            $getadminDB = AdminDBs::getAdminDB($value[0]);
	                          
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
	               

	            }else{
	              
					foreach($_SESSION['CompanyHostName'] as $key => $val)
					{
							 if(array_key_exists('mongodb', $val))
							 {
									$dbCr = $val['mongodb'];

									$dbCr = $dbCr[0];
									$dbCr = explode('|', $dbCr);
									$hostName = explode(':', $dbCr[0]);
									$hostName = $hostName[1].':'. $hostName[2]; 
									
									$dbName = explode(':', $dbCr[1]);
									$dbName =  $dbName[1];
									$uName=explode(':', $dbCr[2]);
									$uName= $uName[1];

									$pwd = explode(':', $dbCr[3]);
									$pwd =  $pwd[1];
									$_SESSION['DBhost'] = $hostName;
		                            $_SESSION['DBName'] = $dbName;
		                            $_SESSION['DBUname'] = $uName;
		                            $_SESSION['pwd'] =  $pwd;
		                            $_SESSION['DBType'] = 'mongodb';

							}		
					}
				}
				$connection = new MongoDB\Driver\Manager('mongodb://'.	$uName.':'.	$pwd.'@'.	$hostName.'/'.	$dbName.'?authSource=admin&keepAlive=true&poolSize=30&autoReconnect=true&socketTimeoutMS=360000&connectTimeoutMS=360000');
	
		}
		else 	{
			$connection = new MongoDB\Driver\Manager('mongodb://root:bt4GGm5dq1SD@34.65.55.199:27017/B2SBC?authSource=admin&keepAlive=true&poolSize=30&autoReconnect=true&socketTimeoutMS=360000&connectTimeoutMS=360000');

		}
		$options = [ 'projection' => ['uploadImage' => 1 , 'uploadImage_MongoDB' => 1]];
		$query = new MongoDB\Driver\Query($filter, $options);

		$rows   = $connection->executeQuery('B2SBC.ImageInfo', $query);
		$rowsArr = $rows->toArray();

		if($rowsArr)
			return $rowsArr;
		else
			return 0; 
     }
		
}