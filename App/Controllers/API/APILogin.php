<?php

namespace App\Controllers\API;



use \App\Models\Apis;
use \App\Models\Placeholder;
use \App\Models\Page;
use \App\Models\User;
use \App\Models\Companies;
use \App\Models\Execute;
use App\Controllers\DataFormatHelper\DataTableHelper;
use \App\Models\Products;

// this file has the function for User login for API side .

class APILogin extends \Core\Controller
{

	// Function for LOgin Api users .
	public static function loginUser(){

		header('Content-Type: application/json');
	    $headers = apache_request_headers();
	    $getUserDetail= '';
	    $url =  '';
		define('GlobalAuthKey', 'Z2xvYmFsYXV0aEBiYWJjLmFwcDpnaGRmazclOWhmJjRmaCVqIA') ; // == Removed Global Auth (MD5)
	      	// OLD = define('GlobalAuthKey', '54712cecea80d5a149ecb6f0f597e8f6') ; // sam_me@me.com:12345  MD5

		$auth = '';
      
	    $body = file_get_contents("php://input"); // it allows us to tale the json value from body 
	    $body = json_decode( $body ,true);
	    if($body){
	        foreach ($body as $bKey => $bValue) {
	            $_REQUEST[$bKey] = $bValue;
	        }
	    }
      	if(isset($headers['authorization']) || isset($headers['Authorization'])|| isset($_GET['AuthKey'])){
            if(isset($headers['authorization'])){
                $auth =$headers['authorization'];
                
            }else if(isset($headers['Authorization'])){
            $auth =$headers['Authorization'];
            
        }else{
                $auth = $_GET['AuthKey'];
            }
            $user = base64_decode($auth);
            $user = explode(':' , $user);



            $body = file_get_contents("php://input"); 
            if(!empty($body))
            {
               
                $body = json_decode($body , true);
                if( (isset($body['username']) &&  isset($body['password']))){
                    if($body['username'] !=  $user[0] || $body['password'] !=  $user[1] ){
                            echo json_encode(array('Status' => 'Please Enter Correct Authorization Key ')); 
                            exit;
                    }
                }
            }
            
            if (!filter_var($user[0], FILTER_VALIDATE_EMAIL)) {
                $getUserDetail = '';
            }else{
                $getUserDetail = Companies::getSpecficUsers($user[0]);
            }
            
        }
        
         // check for Authorization 
        if(!empty($getUserDetail)){
            self::loginAction();
        }
        else if( empty($getUserDetail) || (!isset($headers['Authorization']))  || (isset($headers['Authorization']) && $headers['Authorization'] != GlobalAuthKey)){
        
            echo json_encode(array('Status' => 'Please Enter Correct Authorization Key ')); 
            exit;

           }else{
               self::loginAction();
           }
      	exit;

	}

	// Login Api 

    public static function loginAction()
    {
        $ignoreIpArr = ['127.0.0.1', '81.233.130.113', '81.225.166.75']; 

        if(isset($_SESSION['AccessToken']) && isset($_REQUEST['token']) && ($_REQUEST['token'] == $_SESSION['AccessToken'])){
        	$userName = $_SESSION['UserName'];
            $password =  $_SESSION['Pass'];
            $getUserDetails = User::verifyUser($userName, $password);

            if (!$getUserDetails) {
                
                echo json_encode(array('errorMessage' => 'Invalid credentials')); exit();
            } else {

                
                $data = array();
                $currentDateValue = substr(date('Ymd'), 2);
                if(!isset($_SESSION['AccessToken']))
                 {
                	$token = md5(mt_rand(1, 90000) . 'BABC');
                	$_SESSION['AccessToken'] =  $token;
                	$_SESSION['UserName'] = $_REQUEST['username'];
                	$_SESSION['Pass'] = $_REQUEST['password'];
                	$data['AccessToken']= $token;
                }

                $data['AvailableUserGroup']=$getUserDetails[0]['AvailableUserGroup'];
                $data['username'] = $getUserDetails[0]['UserEmail'];
                $data['CompanyID'] = $getUserDetails[0]['CompanyID'];
                $data['DBParam'] = isset($ParentDBParam)?$ParentDBParam:$getUserDetails[0]['DBParam'];
              
                if(isset($ParentAPIParam))
                {
                  $APIdata1= $ParentAPIParam;
                  $APIdata1 = explode('|', $APIdata1);
                  foreach ($APIdata1 as $key1 => $value1) {
                      $keyVal =  explode(':', $value1);
                      $data[$keyVal[0]] = $keyVal[1];
                  }
                  
                }else
                {
                  $APIdata1= $getUserDetails[0]['APIParam'];
                  if(!empty($APIdata1)){
                    $APIdata1 = explode('|', $APIdata1);
                    foreach ($APIdata1 as $key1 => $value1) {
                        $keyVal =  explode(':', $value1);
                        $data[$keyVal[0]] = $keyVal[1];

                    }
                  }
                  
                  
                }
                if(empty($getUserDetails[0]['Auth']))
                {
                  $authKwy = base64_encode($getUserDetails[0]['UserEmail'].':'.$getUserDetails[0]['UserPassword']);
                }else{
                  $authKwy = $getUserDetails[0]['Auth'];
                }
                $data['AuthorizationAPIkey'] = $authKwy;
                User::updateUserNowTime($getUserDetails[0]['UserID'],$currentDateValue);
                if(!in_array($_SERVER['REMOTE_ADDR'], $ignoreIpArr)){
                    User::updateUserLog($getUserDetails[0]);
                }
                $getCompanyDetails = Companies::getCompanyDetails($getUserDetails[0]['CompanyID']);
                if ($getCompanyDetails) {
                    $data['CompanyName'] = $getCompanyDetails[0]['CompanyName'];
                }
                  
                echo json_encode(array('Data' => $data ,'successMessage' => 'Success Full login'));
                exit;
            }

        }
        else if (isset($_REQUEST['username']) && isset($_REQUEST['password']) || (isset($_REQUEST['parentUsername']) && isset($_REQUEST['parentPassword']) && isset($_REQUEST['childAcc']))) {
           
            $userCount = [];
            if (isset($_REQUEST['username']) && isset($_REQUEST['password'])){
               
                    $userName = $_REQUEST['username'];
                    $password =  $_REQUEST['password'];
                    $getUserDetails = User::verifyUser($userName, $password);
                  
            }else if (isset($_REQUEST['parentUsername']) && isset($_REQUEST['parentPassword']) && isset($_REQUEST['childAcc']))
            {
                
                    $userName =  $_REQUEST['parentUsername'];
                    $password =  $_REQUEST['parentPassword'];
                   
                    $getUserDetails = User::verifyUser($userName, $password);
             
                    $AvailableUsers = explode(',' ,$getUserDetails[0]['AvailableUserGroup']);
                   
                    if($_REQUEST['childAcc'] != $getUserDetails[0]['UserEmail']){
                      if(empty($getUserDetails[0]['AllowParentDBParam'])){
                          $ParentDBParam = $getUserDetails[0]['DBParam'];
                      }
                      if(empty($getUserDetails[0]['AllowParentAPIParam'])){
                          $ParentAPIParam = $getUserDetails[0]['APIParam'];
                      }
                      if(in_array($_REQUEST['childAcc'], $AvailableUsers)){
                            $getUserDetails = User::verifyGroupUser($_REQUEST['childAcc']);
                        }
                    } 
            }            
            if (!$getUserDetails) {
                
                echo json_encode(array('errorMessage' => 'Invalid credentials')); exit();
            } else {

                
                $data = array();
                $currentDateValue = substr(date('Ymd'), 2);
                // if(!isset($_SESSION['AccessToken']))
                //  {
                	$token = md5(mt_rand(1, 90000) . 'BABC');
                	$_SESSION['AccessToken'] =  $token;
                	$_SESSION['UserName'] = isset($_REQUEST['username'])?$_REQUEST['username']:'';
                	$_SESSION['Pass'] = isset($_REQUEST['password'])?$_REQUEST['password']:'';
                	$data['AccessToken']= $token;
                //}
                

                $data['AvailableUserGroup']=$getUserDetails[0]['AvailableUserGroup'];
                $data['username'] = $getUserDetails[0]['UserEmail'];
                $data['CompanyID'] = $getUserDetails[0]['CompanyID'];
                $data['DBParam'] = isset($ParentDBParam)?$ParentDBParam:$getUserDetails[0]['DBParam'];
              
                if(isset($ParentAPIParam))
                {
                  $APIdata1= $ParentAPIParam;
                  $APIdata1 = explode('|', $APIdata1);
                  foreach ($APIdata1 as $key1 => $value1) {
                      $keyVal =  explode(':', $value1);
                      $data[$keyVal[0]] = $keyVal[1];
                  }
                  
                }else
                {
                  $APIdata1= $getUserDetails[0]['APIParam'];
                  if(!empty($APIdata1)){
                    $APIdata1 = explode('|', $APIdata1);
                    foreach ($APIdata1 as $key1 => $value1) {
                        $keyVal =  explode(':', $value1);
                        $data[$keyVal[0]] = $keyVal[1];

                    }
                  }
                  
                  
                }
                if(empty($getUserDetails[0]['Auth']))
                {
                  $authKwy = base64_encode($getUserDetails[0]['UserEmail'].':'.$getUserDetails[0]['UserPassword']);
                }else{
                  $authKwy = $getUserDetails[0]['Auth'];
                }
                $data['AuthorizationAPIkey'] = $authKwy;
                User::updateUserNowTime($getUserDetails[0]['UserID'],$currentDateValue);
                if(!in_array($_SERVER['REMOTE_ADDR'], $ignoreIpArr)){
                    User::updateUserLog($getUserDetails[0]);
                }
                $getCompanyDetails = Companies::getCompanyDetails($getUserDetails[0]['CompanyID']);
                if ($getCompanyDetails) {
                    $data['CompanyName'] = $getCompanyDetails[0]['CompanyName'];
                }
                  
                echo json_encode(array('Data' => $data ,'successMessage' => 'Success Full login'));
                exit;
            }

        } else {
            echo json_encode(array('successMessage' => 'Invalid Credentials'));
            exit();
        }
    }

   // this function destroy the seesion and LOgout the user . 
    public static function logoutUser(){

       session_destroy();
       echo json_encode(array('successMessage' => 'Success Full logout'));
       exit;

    }


}

