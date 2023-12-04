<?php

namespace App\Controllers\Admin\adminUser;

use \Core\View;
use \App\Models\User;
use \App\Models\Page;
use \App\Models\Placeholder;
use \App\Models\Companies;
use \App\Models\PanelPlaceholders;
use \App\Models\PushNotifications;

/**
 * Home controller
 *
 * PHP version 7.0
 */
class Users extends \Core\Controller
{

    /**
     * Show the index page
     *
     * @return void
     */


    public function addAction()
    {
        if (isset($_SESSION['IsAdmin']) && $_SESSION['IsAdmin'] == 1) {
             $getUserGroup = User::getUserGroup($_REQUEST['id']);
            if($getUserGroup){
                $temp = ''; 

                foreach ($getUserGroup as $key => $value) {
                   $temp .= $value['UserEmail'].',';
                }
                unset($getUserGroup);
                $getUserGroup = trim($temp ,',');

            }
            $getFreshDeskUsers = array();
            $getCompanydetail = Companies::getCompanyDetails($_REQUEST['id']);
            if($getCompanydetail[0]['EnableFreshDesk']){

                if($getCompanydetail[0]['selectspecficFreshDeskCompany']){

                    $query = 'select * from Contacts where company_id in ('.$getCompanydetail[0]['FreshDeskCompany'].')';
                }else{
                    $query = 'select * from Contacts  cnt  inner join Companies  comp  on comp.company_id = cnt.company_id';
                }
               
                $getFreshDeskUsers = User::executeQuery($query, 'GCS_Tickets_Portal' , 'Contacts' );
            }
           
            View::render('administrator/users/add.php', ['getFreshDeskUsers' =>  $getFreshDeskUsers ,'getUserGroup' => $getUserGroup]);
        } else {
            header('Location: ' . baseUrl . 'companies');
        }
    }

    public function saveAction()
    {
        
        $AvailableUserGroup = (isset($_REQUEST['AvailableUserGroup'])) ? $_REQUEST['AvailableUserGroup'] : "";
        if ($AvailableUserGroup) {
            $AvailableUserGroup = implode(',', $AvailableUserGroup);
        }
        $_REQUEST['AvailableUserGroup'] = $AvailableUserGroup;
        $AllowedFreshDeskUser = (isset($_REQUEST['AllowedFreshDeskUser'])) ? $_REQUEST['AllowedFreshDeskUser'] : "";
        if ($AllowedFreshDeskUser) {
            $AllowedFreshDeskUser = implode(',', $AllowedFreshDeskUser);
        }
        $_REQUEST['AllowedFreshDeskUser'] = $AllowedFreshDeskUser;
        // $SelectedNotification = (isset($_REQUEST['SelectedNotification'])) ? $_REQUEST['SelectedNotification'] : "";
        // if ($SelectedNotification) {
        //     $SelectedNotification = implode(',', $SelectedNotification);
        // }
        // $_REQUEST['SelectedNotification'] = $SelectedNotification;
        
        User::addUser();
        header('Location: ' . baseUrl . 'editcompany?id=' . $_REQUEST['CompanyID']);
    }

    public function deleteAction()
    {
        if (!empty($_REQUEST['id']) && !empty($_REQUEST['companyId'])) {
            User::deleteUser($_REQUEST['id']);
            header('Location: ' . baseUrl . 'editcompany?id=' . $_REQUEST['companyId']);
        } else {
            header('Location: ' . baseUrl . 'companies');
        }
    }

    public function editAction()
    {
        $getUserDetails = User::getUserDetails($_REQUEST['id']);
        $getCompanydetail = Companies::getCompanyDetails($getUserDetails[0]['CompanyID']);
        $getPushNotification = PushNotifications::getAllpushNotification();
         if(!empty($getCompanydetail[0]['AllowOtherCompanyUser']))
         {
             $getUserGroup = User::getUserGroup('');
         }
         else{
            $getUserGroup = User::getUserGroup($getUserDetails[0]['CompanyID']);
         }
       
        if($getUserGroup){
            $temp = ''; 

            foreach ($getUserGroup as $key => $value) {
               $temp .= $value['UserEmail'].',';
            }
            unset($getUserGroup);
            $getUserGroup = trim($temp ,',');

        }
        $getTotalUsers = Companies::getAllUsers();
        $getFreshDeskUsers = array();
        if($getCompanydetail[0]['EnableFreshDesk']){
            if($getCompanydetail[0]['selectspecficFreshDeskCompany']){
                $query = 'select * from Contacts where company_id in ('.$getCompanydetail[0]['FreshDeskCompany'].')';
            }else{
                $query = 'select * from Contacts  cnt  inner join Companies  comp  on comp.company_id = cnt.company_id';
            }
           
            $getFreshDeskUsers = User::executeQuery($query, 'GCS_Tickets_Portal' , 'Contacts' );
        }
      
        View::render('administrator/users/edit.php', ['getPushNotification' => $getPushNotification , 'getUserDetails' => $getUserDetails, 'getTotalUsers' => $getTotalUsers , 'getUserGroup' => $getUserGroup , 'getFreshDeskUsers' =>  $getFreshDeskUsers]);
    
       // View::render('administrator/users/edit.php', ['getUserDetails' => $getUserDetails, 'getTotalUsers' => $getTotalUsers , 'getUserGroup' => $getUserGroup]);
    }

    public function updateAction()
    {
        $AvailableUserGroup = (isset($_REQUEST['AvailableUserGroup'])) ? $_REQUEST['AvailableUserGroup'] : "";
        if ($AvailableUserGroup) {
            $AvailableUserGroup = implode(',', $AvailableUserGroup);
        }
        $_REQUEST['AvailableUserGroup'] = $AvailableUserGroup;
        $AllowedFreshDeskUser = (isset($_REQUEST['AllowedFreshDeskUser'])) ? $_REQUEST['AllowedFreshDeskUser'] : "";
        if ($AllowedFreshDeskUser) {
            $AllowedFreshDeskUser = implode(',', $AllowedFreshDeskUser);
        }
        $_REQUEST['AllowedFreshDeskUser'] = $AllowedFreshDeskUser;
        $SelectedNotification = (isset($_REQUEST['SelectedNotification'])) ? $_REQUEST['SelectedNotification'] : "";
        if ($SelectedNotification) {
            $SelectedNotification = implode(',', $SelectedNotification);
        }
        $_REQUEST['SelectedNotification'] = $SelectedNotification;
        
        
        User::updateUser();
        header('Location: ' . baseUrl . 'editcompany&id=' . $_REQUEST['CompanyID']);
    }
    public function copyUserSettingsAction()
    {
        $userId = (isset($_REQUEST['UserId'])) ? $_REQUEST['UserId'] : "";
        $fromUserId = (isset($_REQUEST['selectedUserId'])) ? $_REQUEST['selectedUserId'] : "";

        $getUserPages = User::getSelectedUserPages($fromUserId);

        Page::deleteByTableAndColumnInfo('UserPageAccess', 'UserId', $userId);
        Page::deleteByTableAndColumnInfo('UserPagePlaceholders', 'UserId', $userId);

        if ($getUserPages) {
            
            foreach ($getUserPages as $key => $value) {
                $data = array();
                
                $data['PageId'] = $value['PageId'];
                $data['PageMenuText'] = $value['PageMenuText'];
                $data['PageMenuOrder'] = $value['PageMenuOrder'];
                $data['UserId'] = $userId;
                $data['ParentPages'] = explode(',', $value['ParentPages']);
                $data['LiveSyncTime'] = $value['LiveSyncTime'];
                $data['LiveSyncFlag'] = $value['LiveSyncFlag'];
                $data['ShowAsMenu'] = $value['ShowAsMenu'];
                $data['ParentPageText'] = $value['ParentPageText'];
                $data['SecondaryPageMenuOrder'] = $value['SecondaryPageMenuOrder'];
                $data['SecondaryChildPageMenuOrder'] = $value['SecondaryChildPageMenuOrder'];
                $data['ParentLinkFlag'] = $value['ParentLinkFlag'];
                if ($value['UserId'] != $userId) {
                    $userPageAccessId = Page::addUserPageAccess($data);
                    $getPagePlaceholders = User::getSelectedPagePlaceholders($fromUserId, $value['ID']);

                    foreach ($getPagePlaceholders as $placeholderKey => $placeholderValue) {
                        $placeholderData = array();
                        $placeholderData['PlaceholderValue'] = $placeholderValue['PlaceholderValue'];
                        $placeholderData['PlaceholderId'] = $placeholderValue['PlaceholderId'];
                        $placeholderData['PlaceholderActionIds'] = $placeholderValue['PlaceholderActionIds'];
                        $placeholderData['PlaceholderType'] = $placeholderValue['PlaceholderType'];
                        $placeholderData['UserPageAccessId'] = $userPageAccessId;
                        $placeholderData['UserId'] = $userId;
                        if ($placeholderValue['UserId'] != $userId) {
                            PanelPlaceholders::SavePanelPlaceholder($placeholderData);
                        }
                    }

                }
            }
            exit;    
        }
    }
}
