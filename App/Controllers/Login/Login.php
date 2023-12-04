<?php
namespace App\Controllers\Login;

use App\Models\Companies;
use App\Models\Page;
use \Core\View;
use \App\Models\User;
use \App\Models\Parameter;
use \App\Controllers\Home\Home;

class Login extends \Core\Controller
{
// This function Perform Login of User 
public function loginAction()
{
   
    $ignoreIpArr = ['127.0.0.1', '81.233.130.113', '81.225.166.75']; 
    //(Start) code part to perform login
    if (isset($_REQUEST['username']) && isset($_REQUEST['password']) || isset($_REQUEST['AcccessUser'])) {

        $userCount = [];
        if (isset($_REQUEST['username']) && isset($_REQUEST['password'])){
                $userName = $_REQUEST['username'];
                $password = $_REQUEST['password'];
               
                $getUserDetails = User::verifyUser($userName, $password);
                
                $userCount = !empty( $getUserDetails[0]['AvailableUserGroup'])?explode(',', $getUserDetails[0]['AvailableUserGroup']):0;
        }else if (isset( $_SESSION['parentUsername']) && isset($_SESSION['parentPassword']) || isset($_REQUEST['AcccessUser']))
        {
              
                $userName =  $_SESSION['parentUsername'];
                $password = $_SESSION['parentPassword'];
                $getUserDetails = User::verifyUser($userName, $password);
               
                if (($getUserDetails[0]['IsAdmin'])) {
                    $getUserPages = User::getUserPages($getUserDetails[0]['UserID']);
                } else {
                    $getUserPages = User::getUserPages($getUserDetails[0]['UserID']);
                }
               
                if(!empty($getUserPages)){
                    $getUserDetails[0]['AvailableUserGroup'] = $getUserDetails[0]['UserEmail'].','. $getUserDetails[0]['AvailableUserGroup'];
                }
	 			
                $AvailableUsers = explode(',' ,$getUserDetails[0]['AvailableUserGroup']);
                $_SESSION['ParentAvailableUsers'] = $AvailableUsers;
			
                if($_REQUEST['AcccessUser'] != $getUserDetails[0]['UserEmail']){
					
                    $_SESSION['ParentUserFirstName'] = $getUserDetails[0]['UserFirstName'];
                    $_SESSION['ParentCompanyID'] = $getUserDetails[0]['CompanyID'];
                    $_SESSION['ParentUserID'] = $getUserDetails[0]['UserID'];
					$_SESSION['ParentDBParamTemp'] = $getUserDetails[0]['DBParam'];
					$_SESSION['ParentAPIParamTemp'] = $getUserDetails[0]['APIParam'];
					
                    if(!empty($getUserDetails[0]['AllowParentDBParam'])){
                        $_SESSION['ParentDBParam'] = $getUserDetails[0]['DBParam'];
                    }
                    if(!empty($getUserDetails[0]['AllowParentAPIParam'])){
                        $_SESSION['ParentAPIParam'] = $getUserDetails[0]['APIParam'];
                    }
	 
                    if(in_array($_REQUEST['AcccessUser'], $AvailableUsers)){
                        $getUserDetails = User::verifyGroupUser($_REQUEST['AcccessUser']);
						
                        $flag = 1;
						 if(empty($getUserDetails[0]['DBParam'])){
                              $getUserDetails[0]['DBParam'] = $_SESSION['ParentDBParamTemp'] ;
                          }
						if(empty($getUserDetails[0]['APIParam'])){
                              $getUserDetails[0]['APIParam'] = $_SESSION['ParentAPIParamTemp'] ;
                         }
                       
                        while($flag)
                        {   
                            if(!empty($getUserDetails[0]['AvailableUserGroup']) && !empty($getUserDetails[0]['UserGroupFlag'] ))
                                {

                                    if(!empty($getUserDetails[0]['AllowParentDBParam']) && !isset($_SESSION['ParentDBParam'])){
                                        $_SESSION['ParentDBParam'] = $getUserDetails[0]['DBParam'];
                                    }
                                    if(!empty($getUserDetails[0]['AllowParentAPIParam']) && !isset($_SESSION['ParentAPIParam'])){
                                        $_SESSION['ParentAPIParam'] = $getUserDetails[0]['APIParam'];
                                    }
                                     $getUserDetails = User::verifyGroupUser($getUserDetails[0]['AvailableUserGroup']); 
                                    if(empty($getUserDetails[0]['DBParam'])){
										  $getUserDetails[0]['DBParam'] = $_SESSION['ParentDBParamTemp'] ;
									  }
									if(empty($getUserDetails[0]['APIParam'])){
										  $getUserDetails[0]['APIParam'] = $_SESSION['ParentAPIParamTemp'] ;
									 }
                                }
                                else{
                                    $flag = 0;
                                }
                            }
                        
                    }
                    
                    
                } 
        }
      
        if($getUserDetails && !empty($getUserDetails[0]['UserGroupActiveFlag']) && !empty($getUserDetails[0]['AvailableUserGroup'])  && count($userCount) == 1 && empty($getUserDetails[0]['DefaultLogin']) && !isset($_REQUEST['AcccessUser']) )
        {
			  
            $_SESSION['parentUsername'] = $_REQUEST['username'];
            $_SESSION['parentPassword'] = $_REQUEST['password'];
            $_SESSION['ParentUserFirstName'] = $getUserDetails[0]['UserFirstName'];
            $_SESSION['ParentCompanyID'] = $getUserDetails[0]['CompanyID'];
            $_SESSION['ParentUserID'] = $getUserDetails[0]['UserID'];
            $_SESSION['ParentAllowNoti'] = $getUserDetails[0]['AllowNotification'];
			$_SESSION['ParentUserLastLogoutDate'] = $getUserDetails[0]['UserLastLogoutDate'];
			$_SESSION['ParentUserLastLogoutTime'] = $getUserDetails[0]['UserLastLogoutTime'];
            $_SESSION['ParentDBParamTemp'] = $getUserDetails[0]['DBParam'];
			$_SESSION['ParentAPIParamTemp']= $getUserDetails[0]['APIParam'] ;
            if(!empty($getUserDetails[0]['AllowParentDBParam'])){
               
                $_SESSION['ParentDBParam'] = $getUserDetails[0]['DBParam'];
            }
           
            if(!empty($getUserDetails[0]['AllowParentAPIParam'])){
                        $_SESSION['ParentAPIParam'] = $getUserDetails[0]['APIParam'];
             }
			

            $getUserDetails = User::verifyGroupUser($userCount[0]);
           
            if(!empty($getUserDetails[0]['AvailableUserGroup']) && !empty($getUserDetails[0]['UserGroupFlag'] ))
                {
                    $getUserDetails = User::verifyGroupUser($getUserDetails[0]['AvailableUserGroup']); 
				    if(empty($getUserDetails[0]['DBParam'])){
						$getUserDetails[0]['DBParam'] = $_SESSION['ParentDBParamTemp'] ;
					}
					if(empty($getUserDetails[0]['APIParam'])){
						$getUserDetails[0]['APIParam'] = $_SESSION['ParentAPIParamTemp'] ;
					}
                    $flag = 1;
                       
                        while($flag)
                        {   
                            if(!empty($getUserDetails[0]['AvailableUserGroup']) && !empty($getUserDetails[0]['UserGroupFlag'] ))
                            {

                                if(!empty($getUserDetails[0]['AllowParentDBParam']) && !isset($_SESSION['ParentDBParam'])){
                                
                                    $_SESSION['ParentDBParam'] = $getUserDetails[0]['DBParam'];
                                }
                                if(!empty($getUserDetails[0]['AllowParentAPIParam']) && !isset($_SESSION['ParentAPIParam'])){

                                    $_SESSION['ParentAPIParam'] = $getUserDetails[0]['APIParam'];
                                }
                                    $getUserDetails = User::verifyGroupUser($getUserDetails[0]['AvailableUserGroup']); 
                                	if(empty($getUserDetails[0]['DBParam'])){
										$getUserDetails[0]['DBParam'] = $_SESSION['ParentDBParamTemp'] ;
									}
									if(empty($getUserDetails[0]['APIParam'])){
										$getUserDetails[0]['APIParam'] = $_SESSION['ParentAPIParamTemp'] ;
									}
                            }
                            else{
                                $flag = 0;
                            }
                        }
                      
                }


        }
        else if ($getUserDetails && !empty($getUserDetails[0]['UserGroupActiveFlag']) && !empty($getUserDetails[0]['AvailableUserGroup']) && !isset($_REQUEST['AcccessUser'])) {
              
            $_SESSION['parentUsername'] = $_REQUEST['username'];
            $_SESSION['parentPassword'] = $_REQUEST['password'];
            
            $_SESSION['parentSaveFilterBTN'] = !empty($getUserDetails[0]['SaveFilterBTN'])?$getUserDetails[0]['SaveFilterBTN']:0;
            
            if (($getUserDetails[0]['IsAdmin'])) {
                $getUserPages = User::getUserPages($getUserDetails[0]['UserID']);
            } else {
                $getUserPages = User::getUserPages($getUserDetails[0]['UserID']);
            }
            
            if(!empty($getUserPages)){
                $getUserDetails[0]['AvailableUserGroup'] = $getUserDetails[0]['UserEmail'].','. $getUserDetails[0]['AvailableUserGroup'];
            }

            View::render('Home/continueAs.php', [
                'AvailableUsers' => $getUserDetails[0]['AvailableUserGroup']]);
            exit();
        }
        // 
        
        if (!$getUserDetails) {
            View::render('Home/index.php', [
                'errorMessage' => 'Invalid credentials'
            ]);
            exit();
        } else {

            if (($getUserDetails[0]['IsAdmin'])) {
                $getUserPages = User::getUserPages($getUserDetails[0]['UserID']);
            } else {
                $getUserPages = User::getUserPages($getUserDetails[0]['UserID']);
            }
           
            $userPageAccess = array();
            $EnableFixedHeader = array();
            $EnableFixedLeftColumn = array();
            foreach ($getUserPages as $userPage) {
                $userPageAccess[] = $userPage['PageTableID'];
                $EnableFixedHeader[$userPage['PageMenuText']] =  $userPage['EnableFixedHeader'];
                $EnableFixedLeftColumn[$userPage['PageMenuText']] =  $userPage['EnableFixedLeftColumn'];
                
            }
            
            if(!isset($_SESSION)){
                session_start();
            }
           
            $currentDateValue = substr(date('Ymd'), 2);
            $_SESSION['userPageAccess'] = $userPageAccess;
            $_SESSION['PageDetails'] = $getUserPages;
            $_SESSION['username'] = $getUserDetails[0]['UserEmail'];
            $_SESSION['password'] = $getUserDetails[0]['UserPassword'];
            $_SESSION['UserFirstName'] = $getUserDetails[0]['UserFirstName'];
            $_SESSION['UserLastName'] = $getUserDetails[0]['UserLastName'];
            $_SESSION['UserID'] = $getUserDetails[0]['UserID'];
            $_SESSION['IsAdmin'] = $getUserDetails[0]['IsAdmin'];
            $_SESSION['CompanyID'] = $getUserDetails[0]['CompanyID'];
            $_SESSION['DBParam'] = isset($_SESSION['ParentDBParam'])?$_SESSION['ParentDBParam']:$getUserDetails[0]['DBParam'];
            $_SESSION['APIParam'] = isset($_SESSION['ParentAPIParam'])?$_SESSION['ParentAPIParam']:$getUserDetails[0]['APIParam'];
			
            $_SESSION['NowTime'] = $currentDateValue;
            $_SESSION['AllowNotification'] = isset($_SESSION['ParentAllowNoti'])? $_SESSION['ParentAllowNoti']:$getUserDetails[0]['AllowNotification'];
            $_SESSION['EnableFixedHeader'] =  $EnableFixedHeader;
            $_SESSION['UserLastLogoutDate'] = isset($_SESSION['ParentUserLastLogoutDate'])?$_SESSION['ParentUserLastLogoutDate']:$getUserDetails[0]['UserLastLogoutDate'];
			$getUserDetails[0]['UserLastLogoutTime'] = isset($_SESSION['ParentUserLastLogoutTime'])?$_SESSION['ParentUserLastLogoutTime']:$getUserDetails[0]['UserLastLogoutTime'];
            if($getUserDetails[0]['UserLastLogoutTime']){
                $getUserDetails[0]['UserLastLogoutTime'] = explode(':' , $getUserDetails[0]['UserLastLogoutTime'] );
                
                array_pop($getUserDetails[0]['UserLastLogoutTime']);
            
                $getUserDetails[0]['UserLastLogoutTime'] = implode(':',$getUserDetails[0]['UserLastLogoutTime'] );
            }
            $_SESSION['UserLastLogoutTime'] =  $getUserDetails[0]['UserLastLogoutTime'];
            
            
            User::updateUserNowTime($getUserDetails[0]['UserID'],$currentDateValue);
           
            if(isset($_SESSION['parentSaveFilterBTN'])){
                $_SESSION['SaveFilterBTN'] =isset($_SESSION['parentSaveFilterBTN'])?$_SESSION['parentSaveFilterBTN']:0;
            }else{
                $_SESSION['SaveFilterBTN'] =!empty($getUserDetails[0]['SaveFilterBTN'])?$getUserDetails[0]['SaveFilterBTN']:0;
            }   

            // if(empty($_SESSION['LogSetFlag']) && !in_array($_SERVER['REMOTE_ADDR'], $ignoreIpArr)){
            //         $Location = file_get_contents('https://www.iplocate.io/api/lookup/'.$_SERVER['REMOTE_ADDR']);
            //         $Location = json_decode($Location);
                   
            //         $getUserDetails[0]['City'] = $Location->city;
            //         $getUserDetails[0]['Country'] = $Location->country;
            //         User::updateUserLog($getUserDetails[0]);
            //         $_SESSION['LogSetFlag'] = 1;
            // }
            $getCompanyDetails = Companies::getCompanyDetails($getUserDetails[0]['CompanyID']);
          
            if ($getCompanyDetails) {
                $_SESSION['CompanyName'] = $getCompanyDetails[0]['CompanyName'];
               
                if($getCompanyDetails[0]['AccountHolderName']){
                    $_SESSION['AccountHolderName'] = $getCompanyDetails[0]['AccountHolderName'];
                    $_SESSION['IBANNumber'] = $getCompanyDetails[0]['IBANNumber'];
                    $_SESSION['BICNumber'] = $getCompanyDetails[0]['BICNumber'];
                    $_SESSION['CreditorID'] = $getCompanyDetails[0]['CreditorID'];
                }
                $_SESSION['BPDB'] = $getCompanyDetails[0]['CompanyBPDb'];
                if(!empty($getCompanyDetails[0]['CompanyDBPass']))
                {
                    $getCompanyDetails[0]['CompanyDBPass'] = json_decode( $getCompanyDetails[0]['CompanyDBPass'] , true);
                    $getCompanyDetails[0]['CompanyDBUserName'] = json_decode( $getCompanyDetails[0]['CompanyDBUserName'] , true);

                    foreach ($getCompanyDetails[0]['CompanyDBUserName'] as $key => $value) {

                          
                        $getCompanyDetails[0]['CompanyDBUserName'][$key][$getCompanyDetails[0]['CompanyDBPass'][$key][0]] = $value;
                        unset( $getCompanyDetails[0]['CompanyDBUserName'][$key][0]);
                    }
                    $_SESSION['CompanyDBPass'] = $getCompanyDetails[0]['CompanyDBPass'];
                
                    $_SESSION['CompanyDBUserName'] = $getCompanyDetails[0]['CompanyDBUserName'];
                    $_SESSION['AdminDb'] = json_decode($getCompanyDetails[0]['AdminDb'] , true);
                    $_SESSION['FTPCredential'] = $getCompanyDetails[0]['FTPCredential'];
                    $_SESSION['AllowCompanyFolder'] = $getCompanyDetails[0]['AllowCompanyFolder'];
                    $_SESSION['SFTPCredential'] = $getCompanyDetails[0]['SFTPCredential'];
                    $_SESSION['SFTPKeys'] = $getCompanyDetails[0]['SFTPKeys'];
                  
                }
                
                if(!empty($getCompanyDetails[0]['CompanyHostName'])){
                    $getCompanyDetails[0]['CompanyHostName'] = json_decode( $getCompanyDetails[0]['CompanyHostName'] , true);
                    $getCompanyDetails[0]['DBType'] = json_decode( $getCompanyDetails[0]['DBType'] , true);

                    foreach ($getCompanyDetails[0]['CompanyHostName'] as $key => $value) {

                        
                        $getCompanyDetails[0]['CompanyHostName'][$key][$getCompanyDetails[0]['DBType'][$key][0]] = $value;
                        unset( $getCompanyDetails[0]['CompanyHostName'][$key][0]);

                       
                    }
                  
                    $_SESSION['DBType'] = $getCompanyDetails[0]['DBType'];
                
                     $_SESSION['CompanyHostName'] = $getCompanyDetails[0]['CompanyHostName'];
                }
                
                //  $server = $_SERVER['DOCUMENT_ROOT'].'/BabcPortal_Other_Assests/Reports/';
                // $CompanyDir =  $server.trim($_SESSION['CompanyName']).'/';
                // $CompanyUserDir =  $server.trim($_SESSION['CompanyName']).'/'.$_SESSION['UserFirstName'].'/';
                // if(is_dir($CompanyUserDir)){
                //     array_map('unlink', glob("$CompanyUserDir/*.*"));
                //     rmdir($CompanyUserDir);
                // }
                    
                $_SESSION['NotificationLogs'] = Page::getNotiLogs(); 
				//print_r($_SESSION['NotificationLogs']); exit;
                $_SESSION['LoggedIn'] = 1;
                $allParameter = Parameter::getAllParameter();
                $_SESSION['AllParameters'] = $allParameter;
                $_SESSION['CacheUser'] = $getCompanyDetails[0]['EnableRedisCompany']?$getCompanyDetails[0]['EnableRedisCompany']:$getUserDetails[0]['EnableCacheUser'];
                
                if($getCompanyDetails[0]['TableSelectionCompany']){
                    $_SESSION['TableSelection'] = $getCompanyDetails[0]['TableSelectionCompany'];
                }else  if($getUserDetails[0]['TableSelection']){
                    $_SESSION['TableSelection'] = $getUserDetails[0]['TableSelection'];
                }else
                {
                    $_SESSION['TableSelection'] = 0;
                }
                $_SESSION['DisableAPIDataRedisUser'] =!empty($getCompanyDetails[0]['DisableAPIDataRedisCompany'])?$getCompanyDetails[0]['DisableAPIDataRedisCompany']:$getUserDetails[0]['DisableAPIDataRedisUser'];

                // print_r($_SESSION); exit;
            }
           
            //print_r($_SESSION); exit;
            Home::dashboardAction();
        }

    }
    //(End) Code part to perform Login
    //(Start) code part that check if user had login and his info is saved in session and session  is not expried yet . 
    else if (isset($_SESSION) && isset($_SESSION['username']) && $_SESSION['password']) {
        Home::dashboardAction();
    }
    //(End) code part that check if user had login and his info is saved in session and session  is not expried yet .  
    //(Start) Code part to remove session and go to index page .
    else {
        session_start();
        session_destroy();
        View::render('Home/index.php', []);
        exit();
    }
     //(End) Code part to remove session and go to index page .
}
    // this function is used to perform the switching betwwen the different user .
    public function switchUserAction()
    {
        
        $parentUser = $_SESSION['parentUsername'] ;
        $parentPassword = $_SESSION['parentPassword'];
        $ParentDBParam = isset($_SESSION['ParentDBParam'])?$_SESSION['ParentDBParam']:'';
        $ParentAPIParam = isset($_SESSION['ParentAPIParam'])?$_SESSION['ParentAPIParam']:'';
		$ParentDBParamTemp = isset($_SESSION['ParentDBParamTemp'])?$_SESSION['ParentDBParamTemp']:'';
        $ParentAPIParamTemp = isset($_SESSION['ParentAPIParamTemp'])?$_SESSION['ParentAPIParamTemp']:'';
        $parentSaveFilterBTN = isset($_SESSION['parentSaveFilterBTN'])?$_SESSION['parentSaveFilterBTN']:0;
       
        session_destroy();
        session_start();
        $_SESSION['parentUsername'] =  $parentUser  ;
        $_SESSION['parentPassword'] =  $parentPassword  ;
        if(!empty($ParentDBParam))
            $_SESSION['ParentDBParam'] = $ParentDBParam ;
        if(!empty($ParentAPIParam))
            $_SESSION['ParentAPIParam'] = $ParentAPIParam ;
		if(!empty($ParentDBParamTemp))
            $_SESSION['ParentDBParamTemp'] = $ParentDBParamTemp ;
        if(!empty($ParentAPIParamTemp))
            $_SESSION['ParentAPIParamTemp'] = $ParentAPIParamTemp ;
        $_SESSION['LogSetFlag'] = 1;
        $_SESSION['parentSaveFilterBTN'] = isset($parentSaveFilterBTN)?$parentSaveFilterBTN:0 ;
        Self::loginAction();
    }
    // Function that destroy the seesion and logout the user .
    public function logoutAction()
    {

        $successMessage = "";
        if (isset($_SESSION) && isset($_SESSION['username']) && $_SESSION['password']) {
            // if(isset($_SESSION['CacheUser']) ){
                
            //     $keyName = $_SESSION['UserID'];
            //     if ($GLOBALS['redisClient']->exists([$keyName]) === 1) {
                   
            //         $GLOBALS['redisClient']->del($keyName);
                    
            //     }
            // }
        
            $UID = isset($_SESSION['ParentUserID'])?$_SESSION['ParentUserID']:$_SESSION['UserID'];
            
            $sql = "update Users set UserLastLogoutDate = '".date('ymd')."', UserLastLogoutTime = '".date('H:i')."' where  UserID = '".$UID."'";
            User::AddQuery($sql, 'BP_Admin10');
            
            session_destroy();
            $successMessage = "user logged out successfully";
        }
        View::render('Home/index.php', ['successMessage' => $successMessage]);
        exit();
    }
}

?>