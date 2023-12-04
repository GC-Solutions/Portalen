<?php

namespace App\Controllers\Admin\adminPageaccess;

use \Core\View;
use \App\Models\User;
use \App\Models\Companies;
use \App\Models\Placeholder;
use \App\Models\Page;
use \App\Models\TwoTables;
use \App\Models\PanelPlaceholders;
use \App\Models\AccessPagePlaceholders;
use \App\Models\PushNotifications;
/**
 * PageAccess controller
 *
 * PHP version 7.0
 */
class PageAccess extends \Core\Controller
{
    // this Function is used to show all tha pages that user has created . 
    // this function is called at admin side in compaines we route to user and their we can create new pages .
    public function show()
    {
        // Variable Declaration
        $userId = (isset($_REQUEST['id'])) ? $_REQUEST['id'] : "";
        $getUserDetails = User::getUserDetails($userId);
        $userName = "";
        if ($getUserDetails) {
            $getUserDetails = $getUserDetails[0];
            $firstName = (isset($getUserDetails['UserFirstName'])) ? $getUserDetails['UserFirstName'] : "";
            $lastName = (isset($getUserDetails['UserLastName'])) ? $getUserDetails['UserLastName'] : "";
            $userName = $firstName . ' ' . $lastName;
        }
        // get that specfic User Pages 
        $getUserPages = User::getUserPages($userId);
        View::render('administrator/pageaccess/show.php', ['getUserPages' => $getUserPages, 'userName' => $userName]);
    }
    // This Function is used to display all the placholder selected to be displayed on a page .
    public function PagepanelsAction()
    {
        // Variable Declaration
        $userPageAccessId = (isset($_REQUEST['pageId'])) ? $_REQUEST['pageId'] : "";
        $userId = (isset($_REQUEST['userAccessId'])) ? $_REQUEST['userAccessId'] : "";
        $getUserDetails = User::getUserDetails($userId);
        $userName = "";
        if ($getUserDetails) {
            $getUserDetails = $getUserDetails[0];
            $firstName = (isset($getUserDetails['UserFirstName'])) ? $getUserDetails['UserFirstName'] : "";
            $lastName = (isset($getUserDetails['UserLastName'])) ? $getUserDetails['UserLastName'] : "";
            $userName = $firstName . ' ' . $lastName;
        }
        // get Page Detail that will return all the placholder for that page .
        $getUserPageAccessDetails = User::getPageDetails($userPageAccessId);
        if($getUserPageAccessDetails){
            $getUserPageAccessDetails = $getUserPageAccessDetails[0];
        }
        $getUserAccessPagePanels = AccessPagePlaceholders::getUserAccessPagePanels($userPageAccessId);
        $getUserAccessPageTables = AccessPagePlaceholders::getUserAccessPageTables($userPageAccessId);
        $getUserAccessPageGraphs = AccessPagePlaceholders::getUserAccessPageGraphs($userPageAccessId);
        $getUserAccessPageMaps = AccessPagePlaceholders::getUserAccessPageMaps($userPageAccessId);
        $getUserAccessPagePieChart = AccessPagePlaceholders::getUserAccessPagePieCharts($userPageAccessId);
        $getUserAccessPageSendOrder = AccessPagePlaceholders::getUserAccessPageSendOrder($userPageAccessId);
        $getUserAccessPageReadData= AccessPagePlaceholders::getUserAccessPageReadData($userPageAccessId);
        View::render('administrator/pageaccess/panels.php', ['getUserAccessPagePanels' => $getUserAccessPagePanels,
            'userName' => $userName, 'getUserPageAccessDetails' => $getUserPageAccessDetails,
            'getUserAccessPageTables' => $getUserAccessPageTables, 'getUserAccessPageGraphs' => $getUserAccessPageGraphs , 'getUserAccessPageMaps' => $getUserAccessPageMaps ,'getUserAccessPagePieChart' => $getUserAccessPagePieChart , "getUserAccessPageSendOrder"=> $getUserAccessPageSendOrder , 'getUserAccessPageReadData' => $getUserAccessPageReadData]);
    }
    // delete Specfic Placholder from Page .
    public function deleteUserPagePlaceholderAction(){
        $placeholderId = (isset($_REQUEST['id'])) ? $_REQUEST['id'] : "";
        if($placeholderId){
            Placeholder::deleteDataFromTable("UserPagePlaceholders", $placeholderId);
        }
        header('Location: ' . baseUrl . 'pagepanels?pageId=' . $_REQUEST['pageId'] . '&userAccessId=' . $_REQUEST['userAccessId']);
    }
    // this fuction is used to open the placeholder forms.
    public function addPlaceHolderByTypeAction()
    {
        $placeholderType = (isset($_REQUEST['type'])) ? $_REQUEST['type'] : "";
        $userId = (isset($_REQUEST['userAccessId'])) ? $_REQUEST['userAccessId'] : "";
        $pageId = (isset($_REQUEST['pageId'])) ? $_REQUEST['pageId'] : "";
        $getAllPages = User::getAllPages();
        $getUserDetails = User::getUserDetails($userId);
        $userName = "";
        if ($getUserDetails) {
            $getUserDetails = $getUserDetails[0];
            $firstName = (isset($getUserDetails['UserFirstName'])) ? $getUserDetails['UserFirstName'] : "";
            $lastName = (isset($getUserDetails['UserLastName'])) ? $getUserDetails['UserLastName'] : "";
            $userName = $firstName . ' ' . $lastName;
        }
        $getUserAccessPageDetails = User::getPageDetails($pageId);
        if ($getUserAccessPageDetails) {
            $getUserAccessPageDetails = $getUserAccessPageDetails[0];
        }
        if ($placeholderType == 1) {
            $getAllPanels = Placeholder::getAllTableData("Panels");
            $getAllPanelActions = Placeholder::getAllTableData("PanelActions");
            View::render('administrator/pageaccess/add_panel_placeholder.php', ['userName' => $userName,
                'getAllPanelActions' => $getAllPanelActions, 'getAllPanels' => $getAllPanels,
                'getUserAccessPageDetails' => $getUserAccessPageDetails]);
        } else if ($placeholderType == 2) {
            $getAllTable = Placeholder::getAllTableData("Tables");
            $getAllTableActions = Placeholder::getAllTableData("TableActions");
            $getAllSliderTable = Placeholder::getAllTableData("TableSilder");
            View::render('administrator/pageaccess/add_table_placeholder.php', ['userName' => $userName,
                'getAllTableActions' => $getAllTableActions, 'getAllTable' => $getAllTable,
                'getUserAccessPageDetails' => $getUserAccessPageDetails , 'getAllSliderTable' => $getAllSliderTable]);
        } else if ($placeholderType == 3) {
            $getAllGraph = Placeholder::getAllTableData("Graphs");
            $getAllGraphActions = Placeholder::getAllTableData("GraphActions");
            View::render('administrator/pageaccess/add_graph_placeholder.php', ['userName' => $userName,
                'getAllGraphActions' => $getAllGraphActions, 'getAllGraph' => $getAllGraph,
                'getUserAccessPageDetails' => $getUserAccessPageDetails]);
        } else if ($placeholderType == 4) {
            $getAllMaps = Placeholder::getAllTableData("Maps");
            View::render('administrator/pageaccess/add_maps_placeholder.php', ['userName' => $userName, 'getAllMaps' => $getAllMaps,
                'getUserAccessPageDetails' => $getUserAccessPageDetails]);
        } else if ($placeholderType == 5) {
            $getAllPCharts = Placeholder::getAllTableData("PieCharts");
            View::render('administrator/pageaccess/add_piechart_placeholder.php', ['userName' => $userName, 'getAllPCharts' => $getAllPCharts,
                'getUserAccessPageDetails' => $getUserAccessPageDetails]);
        }else if ($placeholderType == 6) {
            $getall2Tables = TwoTables::getAllTwoTables();
            
            View::render('administrator/pageaccess/add_filter_table.php', ['userName' => $userName, 'getall2Tables' => $getall2Tables ,
                'getUserAccessPageDetails' => $getUserAccessPageDetails]);
        }else if ($placeholderType == 7) {
            $getAllsendOrdertab = Placeholder::getAllTableData("SendOrders");
            View::render('administrator/pageaccess/add_sendOrders_placeholder.php', ['userName' => $userName, 'getAllsendOrdertab' => $getAllsendOrdertab,
                'getUserAccessPageDetails' => $getUserAccessPageDetails]);
        }
        else if ($placeholderType == 8) {
            $getAllReadDatatab = Placeholder::getAllTableData("MongoTables");
            View::render('administrator/pageaccess/add_readData_placeholder.php', ['userName' => $userName, 'getAllReadDatatab' => $getAllReadDatatab,
                'getUserAccessPageDetails' => $getUserAccessPageDetails]);
        }
    }
    // Save placeholder Action .
    public function saveUserPagePlaceholdersAction()
    {
        $saveData = $_REQUEST;
        if($_REQUEST['PlaceholderType'] == 2){
           
            $saveData['PlaceholderId'] = explode('-',  $saveData['PlaceholderId'] );
            $saveData['PlaceholderId'] = isset($saveData['PlaceholderId'][0])?$saveData['PlaceholderId'][0]:$saveData['PlaceholderId']; 
           
            if(isset($saveData['PlaceholderActionIds'])){
                $saveData['PlaceholderActionIds'] = implode(',', $saveData['PlaceholderActionIds']);
            } else {
                $saveData['PlaceholderActionIds'] = '';
            }
        }
        PanelPlaceholders::SavePanelPlaceholder($saveData);
        header('Location: ' . baseUrl . 'pagepanels?pageId=' . $_REQUEST['UserPageAccessId'] . '&userAccessId=' . $_REQUEST['UserId']);
    }
    // Save the select combined table for thatpage .
    public function saveUserFilterTableAction()
    {
       
        $res = TwoTables::getTwoTable($_REQUEST['LinkTablename']);
       
        $pageId = explode(',', $res[0]['TablePageId']);
        $tableId = explode(',', $res[0]['TableId']);
        $cnt = 2;
        foreach ($pageId as $key => $value) {
            $saveData = [];
            $saveData['PlaceholderValue'] = $value;
            $saveData['PlaceholderId'] = $tableId[$key];
            $saveData['PlaceholderType'] = 2;
            $saveData['UserPageAccessId'] = $_REQUEST['UserPageAccessId'];
            $saveData['UserId'] = $_REQUEST['UserId'];
            $saveData['TablesId'] = $value;
            $saveData['CommonField'] = $res[0]['commonField'];
           
            if($cnt <= count($pageId))
            {
                 $saveData['Tablelinked'] = $pageId[$cnt-1];
                 $cnt = $cnt + 1;

            }elseif(count($pageId)+1 == $cnt){
                $saveData['Tablelinked'] = $pageId[0];
            }
            
            Placeholder::SaveFilterTable($saveData);
            unset($saveData);
        }
        
        header('Location: ' . baseUrl . 'pagepanels?pageId=' . $_REQUEST['UserPageAccessId'] . '&userAccessId=' . $_REQUEST['UserId']);
    }
    // Delete page
    public function deleteAction()
    {
        Page::deletePageAccess($_REQUEST['pageId']);
        Page::deleteUserPagePlaceholders($_REQUEST['pageId']);
        header('Location: ' . baseUrl . 'userpageaccess?id=' . $_REQUEST['id']);
    }
    // delete placeholder from page 
    public function deleteplaceholderAction()
    {
        Page::deletePlaceholderAccess($_REQUEST['id']);
        header('Location: ' . baseUrl . 'pagepanels?pageId=' . $_REQUEST['pageId'] . '&userAccessId=' . $_REQUEST['userAccessId']);
    }
    public function  deleteFormAction()
    {
        Page::deleteFormAccess($_REQUEST['id']);
        header('Location: ' . baseUrl . 'placeholders');
     }
   
    
    public function addplaceholderaccessAction()
    {
        $allPanels = Page::getDataByTableName('Panel');
        $allPlaceholders = Page::getDataByTableName('Placeholder');
        View::render('administrator/pageaccess/add_placeholder_access.php', ['allPanels' => $allPanels, 'allPlaceholders' => $allPlaceholders]);
    }
    // Edit placeholder Page 
    public function editUserPageAccessAction(){
        $userId = (isset($_REQUEST['id'])) ? $_REQUEST['id'] : "";
        $pageId = (isset($_REQUEST['PageId'])) ? $_REQUEST['PageId'] : "";
        $getAllPages = User::getAllPages();
        $getUserDetails = User::getUserDetails($userId);
        $userName = "";
        if ($getUserDetails) {
            $getUserDetails = $getUserDetails[0];
            $firstName = (isset($getUserDetails['UserFirstName'])) ? $getUserDetails['UserFirstName'] : "";
            $lastName = (isset($getUserDetails['UserLastName'])) ? $getUserDetails['UserLastName'] : "";
            $userName = $firstName . ' ' . $lastName;
        }

        $getUserPages = User::getUserPagesForParentsOption($userId);
        $getPageDetails = Page::getUserAccessPageDetails($pageId);
  
        $getSecondaryUserPages = User::getUserPagesForSecondaryParentsOption($userId,$getUserPages);

        if($getPageDetails){
            $getPageDetails = $getPageDetails[0];
        }
        $pageText = isset($getPageDetails["PageMenuText"]) ? $getPageDetails["PageMenuText"] : '';
        $userAccessPageIds = array();
        $getPushNotification = PushNotifications::getAllpushNotification();
        View::render('administrator/pageaccess/add_page_access.php', ['getAllPages' => $getAllPages,
            'userName' => $userName, 'getPageDetails' => $getPageDetails,
            'getUserPages' => $getUserPages, 'getSecondaryUserPages' => $getSecondaryUserPages, 'userAccessPageIds' => $userAccessPageIds , 'getPushNotification' => $getPushNotification ]);
    }

    public function addAction()
    {
        $userId = (isset($_REQUEST['id'])) ? $_REQUEST['id'] : "";
        $getAllPages = User::getAllPages();
        $getUserDetails = User::getUserDetails($userId);
        $userName = "";
        if ($getUserDetails) {
            $getUserDetails = $getUserDetails[0];
            $firstName = (isset($getUserDetails['UserFirstName'])) ? $getUserDetails['UserFirstName'] : "";
            $lastName = (isset($getUserDetails['UserLastName'])) ? $getUserDetails['UserLastName'] : "";
            $userName = $firstName . ' ' . $lastName;
        }

        $getUserPages = User::getUserPagesForParentsOption($userId);
        $getPageDetails = array();
        $userAccessPageIds = array();
        $getSecondaryUserPages = User::getUserPagesForSecondaryParentsOption($userId,$getUserPages);
        $getPushNotification = PushNotifications::getAllpushNotification();
        View::render('administrator/pageaccess/add_page_access.php', ['getAllPages' => $getAllPages,
            'userName' => $userName, 'getPageDetails' => $getPageDetails,
            'getUserPages' => $getUserPages, 'getSecondaryUserPages' => $getSecondaryUserPages, 'userAccessPageIds' => $userAccessPageIds , 'getPushNotification' =>  $getPushNotification]);
    }

    public function saveAction()
    {
        $data = $_REQUEST;
		$OnclickData = (isset($data['onClickNoti'])) ? $data['onClickNoti'] : ""; 
        if ($OnclickData) {
            $OnclickData = implode(',', $OnclickData);
        }
		$data['onClickNoti'] = $OnclickData ;
        Page::addUserPageAccess($data);
        header('Location: ' . baseUrl . 'userpageaccess?id=' . $_REQUEST['UserId']);
    }
    public function saveplaceholderaccessAction()
    {
        Page::addPlaceholderAccess();
        header('Location: ' . baseUrl . 'pagepanels?pageId=' . $_REQUEST['PageID'] . '&userAccessId=' . $_REQUEST['UserID']);
    }
    public function editUserPagePlaceholder()
    {
        $placeholderType = (isset($_REQUEST['type'])) ? $_REQUEST['type'] : "";
        $pageId = (isset($_REQUEST['pageId'])) ? $_REQUEST['pageId'] : "";
        $userId = (isset($_REQUEST['userAccessId'])) ? $_REQUEST['userAccessId'] : "";
        $id = (isset($_REQUEST['id'])) ? $_REQUEST['id'] : "";

        $getUserPagePlaceholder = Placeholder::getUserPagePlaceholders($id);

        if($getUserPagePlaceholder){
            $getUserPagePlaceholder = $getUserPagePlaceholder[0];
        }

        $getAllPages = User::getAllPages();
        $getUserDetails = User::getUserDetails($userId);
        $userName = "";
        if ($getUserDetails) {
            $getUserDetails = $getUserDetails[0];
            $firstName = (isset($getUserDetails['UserFirstName'])) ? $getUserDetails['UserFirstName'] : "";
            $lastName = (isset($getUserDetails['UserLastName'])) ? $getUserDetails['UserLastName'] : "";
            $userName = $firstName . ' ' . $lastName;
        }

        $getUserAccessPageDetails = User::getPageDetails($pageId);
        if ($getUserAccessPageDetails) {
            $getUserAccessPageDetails = $getUserAccessPageDetails[0];
        }

        if ($placeholderType == 1) {
            $getAllPanels = Placeholder::getAllTableData("Panels");
            $getAllPanelActions = Placeholder::getAllTableData("PanelActions");
            View::render('administrator/pageaccess/add_panel_placeholder.php', ['userName' => $userName,
                'getAllPanelActions' => $getAllPanelActions, 'getAllPanels' => $getAllPanels,
                'getUserAccessPageDetails' => $getUserAccessPageDetails, 'getUserPagePlaceholder' => $getUserPagePlaceholder]);
        } else if ($placeholderType == 2) {
            $getAllTable = Placeholder::getAllTableData("Tables");
            $getAllTableActions = Placeholder::getAllTableData("TableActions");
            $getAllSliderTable = Placeholder::getAllTableData("TableSilder");
            View::render('administrator/pageaccess/add_table_placeholder.php', ['userName' => $userName,
                'getAllTableActions' => $getAllTableActions, 'getAllTable' => $getAllTable,
                'getUserAccessPageDetails' => $getUserAccessPageDetails, 'getUserPagePlaceholder' => $getUserPagePlaceholder ,'getAllSliderTable' => $getAllSliderTable]);
        } else if ($placeholderType == 3) {
            $getAllGraph = Placeholder::getAllTableData("Graphs");
            $getAllGraphActions = Placeholder::getAllTableData("GraphActions");
            View::render('administrator/pageaccess/add_graph_placeholder.php', ['userName' => $userName,
                'getAllGraphActions' => $getAllGraphActions, 'getAllGraph' => $getAllGraph,
                'getUserAccessPageDetails' => $getUserAccessPageDetails, 'getUserPagePlaceholder' => $getUserPagePlaceholder]);
        }
        else if ($placeholderType == 4) {
            $getAllMaps = Placeholder::getAllTableData("Maps");
            //$getAllGraphActions = Placeholder::getAllTableData("GraphActions");
            View::render('administrator/pageaccess/add_maps_placeholder.php', ['userName' => $userName,
                'getAllMaps' => $getAllMaps,
                'getUserAccessPageDetails' => $getUserAccessPageDetails, 'getUserPagePlaceholder' => $getUserPagePlaceholder]);
        }
        else if ($placeholderType == 5) {
            $getAllPCharts = Placeholder::getAllTableData("PieCharts");
            //$getAllGraphActions = Placeholder::getAllTableData("GraphActions");
            View::render('administrator/pageaccess/add_piechart_placeholder.php', ['userName' => $userName,
                'getAllPCharts' => $getAllPCharts,
                'getUserAccessPageDetails' => $getUserAccessPageDetails, 'getUserPagePlaceholder' => $getUserPagePlaceholder]);
        }
         else if ($placeholderType == 7) {
            $getAllSendOrdertab = Placeholder::getAllTableData("SendOrders");
            View::render('administrator/pageaccess/add_sendOrders_placeholder.php', ['userName' => $userName,
                'getAllSendOrdertab' => $getAllSendOrdertab,
                'getUserAccessPageDetails' => $getUserAccessPageDetails, 'getUserPagePlaceholder' => $getUserPagePlaceholder]);
        }
    }
}
