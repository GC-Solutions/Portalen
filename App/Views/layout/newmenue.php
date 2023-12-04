<?php include_once realpath(__DIR__) . '/header.php'; ?>
<?php include_once realpath(__DIR__) . '/dropdown.php'; ?>
<?php include_once realpath(__DIR__) . '/styledatatable.php'; ?>
<link rel="stylesheet" href="//use.fontawesome.com/releases/v5.0.7/css/all.css">
</head>
<!-- END HEAD -->
<?php

function timeAgo($time_ago)
{

    $time_ago = strtotime($time_ago);
    $cur_time   = time();
    $time_elapsed   = $cur_time - $time_ago;
    $seconds    = $time_elapsed ;
    $minutes    = round($time_elapsed / 60 );
    $hours      = round($time_elapsed / 3600);
    $days       = round($time_elapsed / 86400 );
    $weeks      = round($time_elapsed / 604800);
    $months     = round($time_elapsed / 2600640 );
    $years      = round($time_elapsed / 31207680 );
    // Seconds
    if($seconds <= 60){
        return "just now";
    }
    //Minutes
    else if($minutes <=60){
        if($minutes==1){
            return "one minute ago";
        }
        else{
            return "$minutes minutes ago";
        }
    }
    //Hours
    else if($hours <=24){
        if($hours==1){
            return "an hour ago";
        }else{
            return "$hours hrs ago";
        }
    }
    //Days
    else if($days <= 7){
        if($days==1){
            return "yesterday";
        }else{
            return "$days days ago";
        }
    }
    //Weeks
    else if($weeks <= 4.3){
        if($weeks==1){
            return "a week ago";
        }else{
            return "$weeks weeks ago";
        }
    }
    //Months
    else if($months <=12){
        if($months==1){
            return "a month ago";
        }else{
            return "$months months ago";
        }
    }
    //Years
    else{
        if($years==1){
            return "one year ago";
        }else{
            return "$years years ago";
        }
    }
}
?>
<body class="page-header-fixed sidemenu-closed-hidelogo page-content-white page-md page-full-width header-white white -sidebar-color logo-white">
    <div class="page-wrapper">
        
        <!-- start header -->
        <div class="page-header navbar navbar-fixed-top">
           <div class="page-header-inner page-head-desktop">

       <!--Navbar-->
       <nav class="mb-1 navbar navbar-expand-lg navbar-light default-color">
                          <a class="navbar-brand" href="<?php echo baseUrl; ?>index.php">
                            <img alt="Smiley face" src="<?php echo baseUrl; ?>assets/images/Logo/Default/bb.png" width="100" height="38">
                          </a>
                          <!-- Collapse button -->
                          <button class="navbar-toggler closed-button" type="button" data-toggle="collapse" data-target="#basicExampleNav"
                            aria-controls="basicExampleNav" aria-expanded="false" aria-label="Toggle navigation">
                            <span class="navbar-toggler-icon">
                              <i class="fa-solid fa-bars"></i>
                            </span>
                          </button>

                          <button class="navbar-toggler open-button" type="button" data-toggle="collapse" data-target="#basicExampleNav"
                            aria-controls="basicExampleNav" aria-expanded="false" aria-label="Toggle navigation">
                            <span class="navbar-toggler-icon">
                            <i class="fa-solid fa-xmark"></i>
                            </span>
                          </button>
                          <!-- Collapsible content -->
                          <div class="collapse navbar-collapse custom-navbar-collapse" id="basicExampleNav">
                            <ul class="navbar-nav mr-auto custom-navbar-nav">

                                <?php
                                //print_r($_SESSION['PageDetails']); exit; 
                            if (isset($_SESSION['PageDetails']) && !empty($_SESSION['PageDetails'])) {
                                $Var = '';
                                foreach ($_SESSION['PageDetails'] as $pageDetails) {
                                    $submenuItem = (isset($pageDetails['ParentPages'])) ? $pageDetails['ParentPages'] : "";
                                    $showAsMenu = (isset($pageDetails['ShowAsMenu'])) ? $pageDetails['ShowAsMenu'] : "";
                                   // print_r($_SESSION['PageDetails']); exit;
                                    if (empty($submenuItem) && $showAsMenu) {
                                        $flag  = 0;
                                        $flagSub  = 0;
                                        $tempArrSubMenu = array();
                                        $tempArrSub1Menu = array();
                                       
                                        ?>
                                         <?php foreach ( $_SESSION['PageDetails'] as $submenu) {
                                                    $MainPage = $pageDetails['PageMenuText'];
                                                    $tempArr= array(); 
                                                
                                                    $parentPa = isset($submenu['ParentPageText'])?explode(',',$submenu['ParentPageText']):'';
                                                    if($parentPa != '' && in_array($pageDetails['PageMenuText'], $parentPa)){
                                                        $flag = 1;
                                                        $tempArr['PageMenuText']= $submenu['PageMenuText'];
                                                        $tempArr['SecondaryPageMenuOrder'] = !empty($submenu['SecondaryPageMenuOrder'])?$submenu['SecondaryPageMenuOrder']:1;
                                                        $tempArr['PageId']= $submenu['PageId'];
                                                        
                                                        array_push($tempArrSubMenu,   $tempArr);
                                                        }
                                                    }

                                                    if(trim($_GET['page_text']) ==  trim($pageDetails['PageMenuText'] )){
                                                            $Var =  str_replace(' ', '_' , $MainPage);
                                                           
                                                    }
                                                    $keys = array_column($tempArrSubMenu, 'SecondaryPageMenuOrder');
                                                    array_multisort($keys, SORT_ASC, $tempArrSubMenu);

                                                     ?>
                                         <li class="nav-item dropdown <?php  echo str_replace(' ' , '_' , $pageDetails['PageMenuText']); ?>" id="navbarDropdown">
                                                    <?php if ($pageDetails['ParentLinkFlag'] == '1'){?>
                                                     <a class="nav-link " href="#" id="navbarDropdown" role="button" aria-haspopup="true" aria-expanded="false">  
                                                        <span class="title "><?php echo $pageDetails['PageMenuText']; ?><?php if($flag == 1) {?><i class="fa fa-caret-down"></i><?php } ?></span>
                                                    </a> 
                                                <?php }else{?>
                                                    <a class="nav-link " href="<?php echo baseUrl . 'page?id=' . $pageDetails['PageTableID'].'&page_text=' .$pageDetails['PageMenuText']; ?>" id="navbarDropdown" role="button" aria-haspopup="true" aria-expanded="false">  
                                                        <span class="title"><?php echo $pageDetails['PageMenuText']; ?><?php if($flag == 1) {?><i class="fa fa-caret-down"></i><?php } ?></span>
                                                    </a> 
                                                <?php } ?>

                                                    <ul class="dropdown-menu">
                                                 <?php if ($pageDetails['ParentLinkFlag'] == '1'){?>
                                                    <li class="dropdown-item" id="navbarDropdown">
                                                            <a class="dropdown-item" href="<?php echo baseUrl . 'page?id=' . $pageDetails['PageTableID'].'&page_text=' .$pageDetails['PageMenuText']; ?>" id="navbarDropdown" role="button" aria-haspopup="true" aria-expanded="false">  
                                                            <span class="title "><?php echo $pageDetails['PageMenuText']; ?></span>
                                                        </a> 
                                                    </li>
                                                 <?php } ?>
                                            <?php 

                                            foreach ($tempArrSubMenu as $submenu) {
                                                $flagCheck = array();
                                                     ?>
                                                
                                                <?php foreach ( $_SESSION['PageDetails'] as $submenu1) {
                                                    $tempArr= array(); 
                                                    
                                                    $parentPa =isset($submenu1['ParentPageText'])?explode(',',$submenu1['ParentPageText']):'';
                                                    if($parentPa != "" && in_array($submenu['PageMenuText'], $parentPa)){
                                                        //$flagSub = 1;
                                                        $flagCheck[$submenu['PageMenuText']] = 1;
                                                        $tempArr['PageMenuText']= $submenu1['PageMenuText'];
                                                        $tempArr['SecondaryChildPageMenuOrder'] = !empty($submenu1['SecondaryChildPageMenuOrder'])?$submenu1['SecondaryChildPageMenuOrder']:1;
                                                        $tempArr['PageId']= $submenu1['PageId'];
                                                        $tempArr['ParentPageText'] = 
                                                        $submenu1['ParentPageText'];
                                                        array_push($tempArrSub1Menu,   $tempArr);

                                                        }
                                                         
                                                    }
                                                  
                                                    if(trim($_GET['page_text']) ==  trim($submenu['PageMenuText']) ){
                                                       
                                                        $Var =  str_replace(' ', '_' , $MainPage);
                                                       
                                                       
                                                    }
                                                    $keys = array_column($tempArrSub1Menu, 'SecondaryChildPageMenuOrder');
                                                    array_multisort($keys, SORT_ASC, $tempArrSub1Menu);

                                                     ?>
                                                    <li class="dropdown-item dropdown-submenu" id="navbarDropdown">
                                                        <a  href="<?php echo baseUrl . 'page?id=' . $submenu['PageId'].'&page_text='.$submenu['PageMenuText']; ?>" class="dropdown-item"> <span class="title"> <?php echo $submenu['PageMenuText']; ?><?php if(isset($flagCheck[$submenu['PageMenuText']]) && $flagCheck[$submenu['PageMenuText']] == 1  ) {?><i class="arrow"></i><?php } ?></span></a>
                                            
                                                    <ul class="dropdown-menu dropdown-menu-submenu">
                                                    <?php 

                                                    foreach ( $tempArrSub1Menu as $submenu1) {
                                                    if($submenu['PageMenuText'] == $submenu1['ParentPageText']){
                                                        
                                                        if(trim($_GET['page_text']) ==  trim($submenu1['PageMenuText']) ){
                                                            $Var =   str_replace(' ', '_' ,$MainPage);
                                                           
                                                        }
                                                     ?>
                                                        
                                                        <li id="navbarDropdown"> 
                                                            <a href="<?php echo baseUrl . 'page?id=' . $submenu1['PageId'].'&page_text='.$submenu1['PageMenuText']; ?>" class="dropdown-item "> <span class="title"> <?php echo $submenu1['PageMenuText']; ?></span></a>
                                                         </li>
                                                    
                                                    <?php }} ?> 
                                                     </ul>
                                                     </li>
                                        <?php } ?>
                                            </ul>
                                        </li>
                                    <?php }
                                }
                            }   ?>

                            </ul>
                           
                            <div class="top-menu">                       
                                <!-- <ul class="nav navbar-nav pull-right">

                                <?php if (isset($_SESSION['AllowNotification']) && !empty($_SESSION['AllowNotification'])) {?>

                                  
                                    <li class="dropdown dropdown-extended dropdown-notification" id="header_notification_bar">
                                        <a href="javascript:;" class="dropdown-toggle" data-toggle="dropdown" data-hover="dropdown"
                                            data-close-others="true">
                                            <i class="fa fa-bell"></i>
                                            <span class="badge headerBadgeColor1"> <?php print_r(count($_SESSION['NotificationLogs'])); ?></span>
                                        </a>
                                        <ul class="dropdown-menu animated swing">
                                            <li class="external">
                                                <h3><span class="bold">Notifications</span></h3>
                                                <span class="notification-label purple-bgcolor">New <?php print_r(count($_SESSION['NotificationLogs'])); ?></span>
                                            </li>
                                            <li>
                                                <ul class="dropdown-menu-list small-slimscroll-style" data-handle-color="#637283">
                                                    <?php foreach ($_SESSION['NotificationLogs'] as $Notikey => $Notivalue) { ?>
                                                    <li>
                                                        <a  href="<?php if($Notivalue['PageId']){echo baseUrl . 'page?id=' . $Notivalue['PageId'].'&page_text='.$Notivalue['PageMenuText'].'&Noti='.$Notivalue['NotiId'].'&NotiID='.$Notivalue['ID'];} ?>">
                                                            <span class="time">just now</span>
                                                            <span class="details">
                                                                <span class="notification-icon circle deepPink-bgcolor"><i
                                                                        class="fa fa-check"></i></span> <?php echo $Notivalue['NotiDescription'] ;?>   </span>
                                                        </a>
                                                    </li>
                                                    <?php } ?>
                                                
                                                    
                                                </ul>
                                                <div class="dropdown-menu-footer">
                                                    <a href="javascript:void(0)">  </a>
                                                </div>
                                            </li>
                                        </ul>
                                    </li>
                                   
                                    <?php } ?>

                                   
                                <ul class="nav navbar-nav pull-right">
                                          
                                    <li class="dropdown dropdown-user">
                                            <a class="nav-link dropdown-toggle" id="navbarDropdownMenuLink-333" data-toggle="dropdown"
                                       data-close-others="true">    
                                            <span class="username username-hide-on-mobile">  
                                           
                                           
                                           <?php 
                                                    if($_SESSION && isset($_SESSION['ParentUserFirstName']))
                                                    { 
                                                        echo $_SESSION['ParentUserFirstName'] .' AS ('.$_SESSION['UserFirstName'].')'; 
                                                    }
                                                    else{
                                                        //echo $_SESSION['UserFirstName']; 
                                                        echo $_SESSION['UserFirstName'].' '.$_SESSION['UserLastName'];
                                                        
                                                    } ?>
                                            </span>



                                        <i class="fa fa-angle-down"></i>
                                    </a>

                                    <ul class="dropdown-menu dropdown-menu-default animated jello">
                                        
                                        <?php if (isset($_SESSION['ParentAvailableUsers'])){
                                            foreach ($_SESSION['ParentAvailableUsers'] as $key => $value) { ?>

                                            
                                                 <li>
                                                    <a href="<?php echo baseUrl; ?>switchUser?AcccessUser=<?php echo $value; ?>">
                                                    <i class="icon-logout"> </i> <?php echo $value;?>  </a>
                                                </li> 

                                        <?php } }?>

                                           <li>
                                                <li>
                                                    <a href="<?php echo baseUrl; ?>logout">
                                                      <i class="icon-logout"></i> Logout </a>
                                                </li>                                         
                                    </ul>                               
                                </ul>
                                    </li>
                                </ul> -->
                                 
<!-- end manage user dropdown -->
     
                            <!-- Links -->
                          </div>

                          <!-- Collapsible content -->
                        </nav>

                        <a class="navbar-brand-tablet" href="<?php echo baseUrl; ?>index.php">
                            <img alt="Smiley face" src="<?php echo baseUrl; ?>assets/images/Logo/Default/bb.png" width="88" height="33">
                          </a>

                          <!--/.Navbar-->
                </div>  

                

                <!-- NEW dropdown -->
                <!-- <nav class="drop-nav">
                    <div class="drop-btn">
                        Drop Down<span class="fas fa-caret-down"></span>
                    </div>
                    <div class="wrapper-dropdown">
   
                        <ul class="menu-bar">
                            <li><a href="#">
                                <div class="icon"><span class="fas fa-home"></span></div>
                                Home
                            </a></li>
                            <li class="settings-item"><a href="#">
                                <div class="icon"><span class="fas fa-home"></span></div>
                                Settings <i class="fas fa-angle-right"></i>
                            </a></li>
                            <li class="help-item"><a href="#">
                                <div class="icon"><span class="fas fa-home"></span></div>
                                Help <i class="fas fa-angle-right"></i>
                            </a></li>
                            <li><a href="#">
                                <div class="icon"><span class="fas fa-home"></span></div>
                                About us
                            </a></li>
                        </ul> -->

                        <!--Settings Menu-items -->
<!-- 
                        <ul class="settings-drop">
                            <li class="arrow-li back-settings-btn"><span class="fas fa-arrow-left"></span>Settings</li>
                            <li><a href="#">
                                <div class="icon"><span class="fas fa-user"></span></div>
                                Personal info
                            </a></li>
                            <li><a href="#">
                                <div class="icon"><span class="fas fa-lock"></span></div>
                                Password
                            </a></li>
                            <li><a href="#">
                                <div class="icon"><span class="fas fa-home"></span></div>
                                Adress <i class="fas fa-angle-right"></i>
                            </a></li>
                            <li><a href="#">
                                <div class="icon"><span class="fas fa-home"></span></div>
                                About us
                            </a></li>
                        </ul> -->

                        <!--Help Menu-items -->

                        <!-- <ul class="help-drop">
                            <li class="arrow-li back-help-btn"><span class="fas fa-arrow-left"></span>Help</li>
                            <li><a href="#">
                                <div class="icon"><span class="fas fa-user"></span></div>
                                Personal info
                            </a></li>
                            <li><a href="#">
                                <div class="icon"><span class="fas fa-lock"></span></div>
                                Password
                            </a></li>
                            <li><a href="#">
                                <div class="icon"><span class="fas fa-home"></span></div>
                                Adress <i class="fas fa-angle-right"></i>
                            </a></li>
                            <li><a href="#">
                                <div class="icon"><span class="fas fa-home"></span></div>
                                About us
                            </a></li>
                        </ul>

                    </div>
                </nav>

                <script>
                    const drop_btn = document.querySelector(".drop-btn");
                    const menu_wrapper = document.querySelector(".wrapper-dropdown");
                    const menu_bar = document.querySelector(".menu-bar");
                    const settings_drop = document.querySelector(".settings-drop");
                    const help_drop = document.querySelector(".help-drop");
                    const settings_item = document.querySelector(".settings-item");
                    const help_item = document.querySelector(".help-item");
                    const back_settings_btn = document.querySelector(".back-settings-btn");
                    const back_help_btn = document.querySelector(".back-help-btn");


                    drop_btn.onclick = (() => {
                        menu_wrapper.classList.toggle("show-drop")
                    })

                    settings_item.onclick = (() => {
                        menu_bar.style.marginLeft = "-400px";
                        setTimeout(() => {
                            settings_drop.style.display = "block";
                        }, 100);
                    })
                    help_item.onclick = (() => {
                        menu_bar.style.marginLeft = "-400px";
                        setTimeout(() => {
                            help_drop.style.display = "block";
                        }, 100);
                    })

                    back_settings_btn.onclick = (() => {
                        menu_bar.style.marginLeft = "0px";
                        settings_drop.style.display = "none";
                    })
                    back_help_btn.onclick = (() => {
                        menu_bar.style.marginLeft = "0px";
                        help_drop.style.display = "none";
                    })
                </script> -->

                
                
                <!-- Breadcrum -->

                <div class="page-bar">
                    <div class="page-title-breadcrumb">
                        <ol class="breadcrumb page-breadcrumb pull-right">
                            <?php 

                            $curr_Page = $_SESSION['currentPageName'];
                        
                            $breadcrumb = '';
                            foreach ($_SESSION['PageDetails'] as $pageDetails ) { 	
                                
                                if( isset($pageDetails['PageMenuText']) && isset($pageDetails[$pageDetails['PageMenuText'].'_BTN']) && trim($pageDetails['PageMenuText']) == trim($curr_Page)){
                                    $breadcrumb = $pageDetails[$pageDetails['PageMenuText'].'_BTN'];
                                    break;
                                }
                                else if( isset($pageDetails['PageMenuText']) && trim($pageDetails['PageMenuText']) == trim($curr_Page))
                                {
                                    $breadcrumb = '<li>'.$curr_Page.'</li>';
                                    if( isset($pageDetails['ParentPageText']) && $pageDetails['ParentPageText'] != '')
                                    {
                                        //print_r($pageDetails['ParentPageText']); exit;
                                        foreach ($_SESSION['PageDetails'] as $subpage ) {
                                            
                                            if( isset($subpage['PageMenuText']) && strpos($pageDetails['ParentPageText'],$subpage['PageMenuText']) !== false)
                                            {
                                                
                                                $breadcrumb = '<li><a class="parent-item" href="'. baseUrl . 'page?id=' . $subpage['PageTableID'].'&page_text=' .$subpage['PageMenuText'].'" >'.$subpage['PageMenuText'].'</a></li>&nbsp;<i class="fa fa-angle-right" ></i>&nbsp;'.$breadcrumb;

                                                foreach ($_SESSION['PageDetails'] as $subpage1 ) {
                                                
                                                    if(isset($subpage1['PageMenuText'])  && strpos($subpage['ParentPageText'],$subpage1['PageMenuText']) !== false)
                                                    {
                                                        //print_r($subpage1['PageMenuText']);
                                                        //print_r($pageDetails['ParentPageText']); exit;
                                                        $breadcrumb = '<li><a class="parent-item" href="'. baseUrl . 'page?id=' . $subpage1['PageTableID'].'&page_text=' .$subpage1['PageMenuText'].'">'.$subpage1['PageMenuText'].'</a></li>&nbsp;<i class="fa fa-angle-right" ></i>&nbsp;'.$breadcrumb;
                                                    }
                                                }

                                            }
                                        }
                                    }      
                                }

                            }
                            echo $breadcrumb;?>
                            
                        </ol> 
                        <ul class="nav navbar-nav pull-right">

                        <?php if (isset($_SESSION['AllowNotification']) && !empty($_SESSION['AllowNotification'])) {
                           // print_r($_SESSION['NotificationLogs']); exit;
                            ?>

                            <!-- start notification dropdown -->
                            <li class="dropdown dropdown-extended dropdown-notification" id="header_notification_bar">
                                <a href="javascript:;" class="dropdown-toggle" data-toggle="dropdown" data-hover="dropdown"
                                    data-close-others="true">
                                    <i class="fa fa-bell"></i>
                                    <span class="badge headerBadgeColor1"> <?php print_r(count($_SESSION['NotificationLogs'])); ?></span>
                                </a>
                                <ul class="dropdown-menu animated swing">
                                    <li class="external">
                                        <h3><span class="bold">Notifications</span></h3>
                                        <span class="notification-label purple-bgcolor">New <?php print_r(count($_SESSION['NotificationLogs'])); ?></span>
                                    </li>
                                    <li>
                                        <ul class="dropdown-menu-list small-slimscroll-style" data-handle-color="#637283">
                                            <?php foreach ($_SESSION['NotificationLogs'] as $Notikey => $Notivalue) { ?>
                                            <li>
                                                <a  href="<?php if($Notivalue['PageId']){echo baseUrl . 'page?id=' . $Notivalue['PageId'].'&page_text='.$Notivalue['PageMenuText'].'&Noti='.$Notivalue['NotiId'].'&NotiID='.$Notivalue['ID'];} ?>">
                                                    <span class="time"><?php echo timeAgo($Notivalue['dateCreated']);  ?></span>
													
                                                    <span class="details">
                                                        <span class="notification-icon circle deepPink-bgcolor"><i
                                                                class="fa fa-check"></i></span> <?php echo $Notivalue['NotiDescription'] ;?>   </span>
                                                </a>
                                            </li>
                                            <?php } ?>
                                        
                                            
                                        </ul>
                                        <div class="dropdown-menu-footer">
                                            <a href="javascript:void(0)">  </a>
                                        </div>
                                    </li>
                                </ul>
                            </li>
                            <!-- end notification dropdown -->
                            <?php } ?>

                            
                            <ul class="nav navbar-nav pull-right">
                                                        
                                                            
                                <li class="dropdown dropdown-user">
                                        <a class="nav-link dropdown-toggle" id="navbarDropdownMenuLink-333" data-toggle="dropdown"
                                    data-close-others="true">    
                                        <!-- <img  class="img-circle " src=""style="background-color: white;border: 13px solid;">                -->
                                        <span class="username username-hide-on-mobile">  
                                        
                                        
                                        <?php 
                                                if($_SESSION && isset($_SESSION['ParentUserFirstName']))
                                                { 
                                                    echo $_SESSION['ParentUserFirstName'] .' AS ('.$_SESSION['UserFirstName'].')'; 
                                                }
                                                else{
                                                    //echo $_SESSION['UserFirstName']; 
                                                    echo $_SESSION['UserFirstName'].' '.$_SESSION['UserLastName'];
                                                    
                                                } ?>
                                        </span>
                    
                    
                    
                                    <i class="fa fa-angle-down"></i>
                                </a>
                    
                                <ul class="dropdown-menu dropdown-menu-default animated jello">
                                    
                                    <?php if (isset($_SESSION['ParentAvailableUsers'])){
                                        foreach ($_SESSION['ParentAvailableUsers'] as $key => $value) { ?>
                    
                                        
                                                <li>
                                                <a href="<?php echo baseUrl; ?>switchUser?AcccessUser=<?php echo $value; ?>">
                                                <i class="icon-logout"> </i> <?php echo $value;?>  </a>
                                            </li> 
                    
                                    <?php } }?>
                    
                                        <li>
                                            <li>
                                                <a href="<?php echo baseUrl; ?>logout">
                                                    <i class="icon-logout"></i> Logout </a>
                                            </li>                                         
                                </ul>                               
                            </ul>
                            </li>
                        </ul>
                        
                    </div>
                </div>			

                <!-- END breadcrum -->

        </div>  
        <script>
           
            var pageTitle = "nav-item.dropdown.<?php echo $Var ; ?>";
            pageTitle = pageTitle.trim()
            pageTitle = pageTitle.replaceAll(" ", ".");
            if('li.' + pageTitle != 'li.nav-item.dropdown.') {
                 $('li.' + pageTitle).addClass("active");
            }
           
        </script>

               
        <!-- end header --> 
        <?php include_once realpath(__DIR__) . '/btnold.php'; ?>




