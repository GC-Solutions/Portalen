<?php

namespace App\Controllers\Home;

use App\Models\Companies;
use App\Models\Page;
use \Core\View;
use \App\Models\User;
use \App\Models\Parameter;
use App\Controllers\DataTables\DataTables;
/**
 * Home controller
 *
 * PHP version 7.0
 This is the main File that conatain the index function that check if the user has logged in or not 
 this file contain logout function 
 Also the function that switch the USer from One ACCount to Another .

 */
class Home extends \Core\Controller
{

    /**
     * Show the index page
     *
     * @return void
     */

    // First function called by the system it checks if the user is logged in or not and take it to default dashboard page .
    public function indexAction()
    {

        if (isset($_SESSION) && isset($_SESSION['username']) && $_SESSION['password']) {
            $this->dashboardAction();
        } else {
            
            View::render('Home/index.php');
        }
    }
    
   // This function  is called when the dashboard page need to be set .
    public static function dashboardAction()
    {
        if (isset($_SESSION) && isset($_SESSION['IsAdmin']) && $_SESSION['IsAdmin'] == 1) {
            header('Location: ' . baseUrl . 'companies');
            exit();
        } else if (isset($_SESSION['userPageAccess']) && COUNT($_SESSION['userPageAccess']) > 0) {
            $pageText = '';
            $pageText2 = '';
            if (isset($_SESSION['PageDetails']) && !empty($_SESSION['PageDetails'])){
                foreach ($_SESSION['PageDetails'] as $pageDetails) {
                    if(isset($pageDetails['DefaultFirstPage']) ){
                         $pageText = $pageDetails['PageMenuText'];
                         break;
                    }
                    else if(isset($pageDetails['PageTableID']) && $pageDetails['PageTableID'] === $_SESSION['userPageAccess'][0]) {
                        if(empty($pageText2))
                            $pageText2 = $pageDetails['PageMenuText'];
                        //break;
                    }
                }
            }
            if(empty($pageText))
            {
                $pageText = $pageText2;
            }
            
            header('Location: ' . baseUrl . 'page?id=' . $_SESSION['userPageAccess'][0].'&page_text='.$pageText);
        } else {
            View::render('500.html', []);
            exit();
        }
    }
    // this function is called at the start in this function all the pages that are accessible by the user ar set in the seesion and over all thing regarding to it are set in it .
    public function pageAction()
    {
       
        $pageId = (isset($_REQUEST['id'])) ? $_REQUEST['id'] : "";
        $pageText = (isset($_REQUEST['page_text'])) ? $_REQUEST['page_text'] : "";
        
        $getUserDetails = User::getUserDetails($_SESSION['UserID']);
        
        if (!in_array($pageId, $_SESSION['userPageAccess'])) {
            View::render('access_denied.php', []);
            exit();
        }

        $userPageDetails = Page::getPageDetails($pageId);
        $getSubmenus = array();

        if ($getUserDetails) {
            $getCompanyDetails = Companies::getCompanyDetails($getUserDetails[0]['CompanyID']);
            $getSubmenus = Page::getSubmenus($pageId, $_SESSION['UserID'], $pageText);
        }
      
        if(isset($_GET['NotiID'])){
            Page::updateNotiLogs($_GET['NotiID']);
			$NotiData = Page::getSpecficNotificationLogs($_GET['NotiID']);
			if(isset($NotiData[0]['LogDate'])){
				$date=date_create($NotiData[0]['dateCreated']);
				$date = date_format($date,"ymd");
				//$date = $NotiData[0]['LogDate'];
				$_SESSION['NotificationlogDate'] = $date;
			}
			
        }
        
        
        $_SESSION['NotificationLogs'] = Page::getNotiLogs();
       

        $getPagePlaceholders = Page::getPagePlaceholders($pageId, $_SESSION['UserID'], $pageText);
        foreach ( $getPagePlaceholders as $key => $value) {
            if(    strpos($value['PlaceholderValue'] ,'Table_') !== false ){
                $getTableActionDetails = Page::getTableActionDetails( $value['ID']);
                if ($getTableActionDetails) {
                     
                $getTableActionIds = (isset( $getTableActionDetails[0]['PlaceholderActionIds'])) ?  $getTableActionDetails[0]['PlaceholderActionIds'] : "";
               
                    if ($getTableActionIds) {
                        $tableActionDetails = Page::getTableActionDetailsByIdIN($getTableActionIds);
                       
                        if ($tableActionDetails) {
                            $curr_Page = $_SESSION['currentPageName'];
        
                            $breadcrumb = '';
                            $lastName = '';
                            $lastNamekey = '';
                            foreach ($_SESSION['PageDetails'] as $pageKey => $pageDetails ) { 	
                                
                                if( isset($pageDetails['PageMenuText']) && trim($pageDetails['PageMenuText']) == trim($curr_Page))
                                {
                                    $breadcrumb = '<li><a class="parent-item" href="'. baseUrl . 'page?id=' . $pageDetails['PageTableID'].'&page_text=' .$pageDetails['PageMenuText'].'" >'.$pageDetails['PageMenuText'].'</a></li>';
                                    if( isset($pageDetails['ParentPageText']) && $pageDetails['ParentPageText'] != '')
                                    {
                                        foreach ($_SESSION['PageDetails'] as $subpage ) {
                                            
                                            if( isset($subpage['PageMenuText']) && (strpos($pageDetails['ParentPageText'],$subpage['PageMenuText']) !== false))
                                            {
                                            
                                                $breadcrumb = '<li><a class="parent-item" href="'. baseUrl . 'page?id=' . $subpage['PageTableID'].'&page_text=' .$subpage['PageMenuText'].'" >'.$subpage['PageMenuText'].'</a></li>&nbsp;<i class="fa fa-angle-right" ></i>&nbsp;'.$breadcrumb;
                
                                                 foreach ($_SESSION['PageDetails'] as $subpage1 ) {
                                                    
                                                    if( isset($subpage1['PageMenuText']) && strpos($subpage['ParentPageText'],$subpage1['PageMenuText']) !== false)
                                                    {
                
                                                        $breadcrumb = '<li><a class="parent-item" href="'. baseUrl . 'page?id=' . $subpage1['PageTableID'].'&page_text=' .$subpage1['PageMenuText'].'">'.$subpage1['PageMenuText'].'</a></li>&nbsp;<i class="fa fa-angle-right" ></i>&nbsp;'.$breadcrumb;
                                                    }
                                                }
                
                                            }
                                        }
                                    }      
                                }
                                
                                if( isset($pageDetails['PageTableID']) && $pageDetails['PageTableID'] ==  $tableActionDetails[0]['PageTargetId'] ){
                                    $lastName = $pageDetails['PageMenuText'];
                                    $lastNamekey = $pageKey;
                                }
                
                            }
                            $breadcrumb = $breadcrumb .'&nbsp;<i class="fa fa-angle-right" ></i>&nbsp;<li>'. $lastName.'</li>';
                            $_SESSION['PageDetails'][$lastNamekey][$lastName.'_BTN'] =  $breadcrumb;
                        }
                    }
                }
            }
           
        }
      
        $getPagePanelGraph = Page::getPagePanelGraph($pageId, $_SESSION['UserID'], $pageText);

       
        $panelGraphIds = array();
        $graphDiscription = array();
        $mapDiscription = array();
        $pieDiscription = array();


        foreach($getPagePanelGraph as $value) {
            if(isset($value['PlaceholderId']) && $value['PlaceholderType'] == 1){
                $panelGraphIds[] = (int)$value['PlaceholderId'];
            }
            if(isset($value['PlaceholderId']) && $value['PlaceholderType'] == 3){
                $placeHoldrGraphId = (int)$value['PlaceholderId'];
                $getPageGraphDescription = Page::getGraphDetails($placeHoldrGraphId);
                if(empty($getPageGraphDescription))
                   {
                    $getPageGraphDescription=Page::getGraphDetailsTable($placeHoldrGraphId);
                   }
                
                $zAxisLabel = '';
                if (isset($getPageGraphDescription[0]['ZFieldLabel']) && !empty($getPageGraphDescription[0]['ZFieldLabel'])) {
                    $zAxisLabel = $getPageGraphDescription[0]['ZFieldLabel'];
                }
                $zAxisColumn = '';
                if (isset($getPageGraphDescription[0]['ZField']) && !empty($getPageGraphDescription[0]['ZField'])) {
                    $zAxisColumn = $getPageGraphDescription[0]['ZField'];
                }
               
                $graphLabels = array('graph_title' => $getPageGraphDescription[0]['HeadersText'],
                    'graph_labels' => array('X' => $getPageGraphDescription[0]['XFieldLabel'], 'Y' => $getPageGraphDescription[0]['YFieldLabel'], 'Y2' => $zAxisLabel, 'Y3' => $zAxisLabel,'Y4' => $zAxisLabel),
                    'graph_axis_column' => array('xAxisColumn' => $getPageGraphDescription[0]['XField'], 'yAxisColumn' => $getPageGraphDescription[0]['YField'], 'zAxis' => $zAxisColumn),
                    'graph_id' => $value['PlaceholderValue'],'TableId' => $getPageGraphDescription[0]['TableId'], 'graph_type' =>$getPageGraphDescription[0]['GraphType'],'Deactivate3d' => $getPageGraphDescription[0]['Deactivate3d']);
                $graphDiscription[$placeHoldrGraphId] = $graphLabels;
            } if(isset($value['PlaceholderId']) && $value['PlaceholderType'] == 5){
                $placeHoldrPieId = (int)$value['PlaceholderId'];
                $getPageGraphDescription = Page::getPieDetails($placeHoldrPieId);
                
                if(empty($getPageGraphDescription))
                   {
                        $getPageGraphDescription=Page::getPieDetailsTable($placeHoldrPieId);   
                    }  

                
                $pieLabels = array('pie_id' => $value['PlaceholderValue'],'TableId' => $getPageGraphDescription[0]['TableId'], "CalculationType" => $getPageGraphDescription[0]['CalculationType'] , "DisplayType" =>  $getPageGraphDescription[0]['DisplayType'] , "pieType" =>  $getPageGraphDescription[0]['PieChartType'] , "ShowPieLabel" =>  $getPageGraphDescription[0]['ShowLabel']);
                $pieDiscription[$placeHoldrPieId] = $pieLabels;
            }if(isset($value['PlaceholderId']) && $value['PlaceholderType'] == 4 ){
                $placeHoldrMapId = (int)$value['PlaceholderId'];
                $getPageGraphDescription = Page::getMapsDetails($placeHoldrMapId);
                
                if(empty($getPageGraphDescription))
                   {
                        $getPageGraphDescription=Page::getMapsDetailsTable($placeHoldrMapId);   
                    }  

               
                $MapsLabels = array('Map_id' => $value['PlaceholderValue'],'TableId' => $getPageGraphDescription[0]['TableId'],  "MapType" =>  $getPageGraphDescription[0]['MapType'] );
                $mapDiscription[$placeHoldrMapId] = $MapsLabels;
            }
        }
       
        /*echo json_encode(array('graph_title' => $graphTitle, 'graph_labels' => $graphLabels, 'filter_column' => $filterColumn,
            'graph_data' => '', 'graph_type' => $graphType,));*/
        
        $panelGraphIds = json_encode($panelGraphIds, JSON_UNESCAPED_SLASHES);
        $graphDiscription = json_encode($graphDiscription, JSON_UNESCAPED_SLASHES);
        $pieDiscription = json_encode($pieDiscription, JSON_UNESCAPED_SLASHES);
        $mapDiscription =  json_encode($mapDiscription, JSON_UNESCAPED_SLASHES);

        $liveSyncStatus = Page::getPageLiveSyncStatus($pageId ,  $_SESSION['UserID']);
        $liveSyncTime = !empty($liveSyncStatus[0]['LiveSyncTime'])?$liveSyncStatus[0]['LiveSyncTime']:0;
        $liveSyncStatus = !empty($liveSyncStatus[0]['LiveSyncFlag'])?$liveSyncStatus[0]['LiveSyncFlag']:0;

        if(isset($_SESSION['syncFlag']) && isset($_SESSION['syncTime']))
        {
            unset($_SESSION['syncFlag']);
            unset($_SESSION['syncTime']);

            $_SESSION['syncFlag'] = $liveSyncStatus;
            $_SESSION['syncTime'] =  $liveSyncTime;

        }else
        {
            $_SESSION['syncFlag'] = $liveSyncStatus;
            $_SESSION['syncTime'] =  $liveSyncTime;
        }
        // from here 
        $customVariable =  Page::getCustomVariable(); 
       
        if($userPageDetails[0]['PageFilename'] == 'ticketfresh'){
            $this->getTicketInfo($getPagePlaceholders , $userPageDetails , $getCompanyDetails);
        }else if( (trim($userPageDetails[0]['PageFilename']) == 'Freshdesk_CT') || (trim($userPageDetails[0]['PageFilename']) == 'FreshDesk_CT_Focus')){
          
            $getAllAgents = Page::getAllAgents($getCompanyDetails[0]['CompanyBPDb']);
            $getAllGroups = Page::getAllGroups($getCompanyDetails[0]['CompanyBPDb']);

            if( $getCompanyDetails[0]['selectAllFreshDeskCompany'] ){
                if($getUserDetails[0]['SelectSpecficUsers']){
                    $selectedUser = $getUserDetails[0]['AllowedFreshDeskUser'] ;
                    $getAllComp = Page::getCompanyFreshDesk($getCompanyDetails[0]['CompanyBPDb'] ,  $selectedUser );
                    $getAllComp = implode(', ', array_column( $getAllComp , 'company_id'));
                    $_SESSION['FreshDeskCompanyCheck'] = $getAllComp;
                  
                }else{
                    $_SESSION['FreshDeskCompanyCheck'] = $getCompanyDetails[0]['selectAllFreshDeskCompany'];
                }
            }else{
                $_SESSION['FreshDeskCompanyCheck'] = $getCompanyDetails[0]['selectAllFreshDeskCompany']? $getCompanyDetails[0]['selectAllFreshDeskCompany']:$getCompanyDetails[0]['FreshDeskCompany'];
            }
           
            
            View::render($userPageDetails[0]['PageFilename'] . '.php', ['getAllAgents' => $getAllAgents ,  'getAllGroups' => $getAllGroups , 'getPagePlaceholders' => $getPagePlaceholders, 'getSubmenus' => $getSubmenus, 'getCompanyDetails' => $getCompanyDetails,'getUserDetails' => $getUserDetails, 'panelGraphIds' => $panelGraphIds, 'graphDiscription' => $graphDiscription,'pieDiscription' => $pieDiscription , 'customVariable' => $customVariable , 'mapDiscription' => $mapDiscription]);
        }else{
            View::render($userPageDetails[0]['PageFilename'] . '.php', ['getPagePlaceholders' => $getPagePlaceholders, 'getSubmenus' => $getSubmenus, 'getCompanyDetails' => $getCompanyDetails,'getUserDetails' => $getUserDetails, 'panelGraphIds' => $panelGraphIds, 'graphDiscription' => $graphDiscription,'pieDiscription' => $pieDiscription , 'customVariable' => $customVariable , 'mapDiscription' => $mapDiscription]);
   
        }
   }    
    
    public function admindashboardAction()
    {
        $successMessage = "yes";
        View::render('administrator/dashboard.php', ['successMessage' => $successMessage]);
        exit();
    }
    public function getTicketInfo($getPagePlaceholders , $userPageDetails , $getCompanyDetails ){

        if(isset($_REQUEST['columnName']) && $_REQUEST['columnName'] == 'ticket_id'){
            $ticket = $_REQUEST['columnValue']; 
            $_REQUEST['ticket_id'] =  $_REQUEST['columnValue'];
        }
        //$_REQUEST['ticket_id'] = '3722';
        $_REQUEST['id'] = $getPagePlaceholders[0]['ID'];
        $_REQUEST['placeholderId'] = $getPagePlaceholders[0]['PlaceholderId'];

        $data = DataTables::generateTableAction();
      
        $getAllAgents = Page::getAllAgents($getCompanyDetails[0]['CompanyBPDb']);
        $getAllGroups = Page::getAllGroups($getCompanyDetails[0]['CompanyBPDb']);
        $EnablePrivateMsg = $getCompanyDetails[0]['EnablePrivateMsg'];
      
        View::render($userPageDetails[0]['PageFilename'] . '.php', ['EnablePrivateMsg' =>$EnablePrivateMsg ,'getAllAgents' => $getAllAgents ,  'getAllGroups' => $getAllGroups , 'GetTicketInfo'=> $data['data']]);
   
    }
    
}
