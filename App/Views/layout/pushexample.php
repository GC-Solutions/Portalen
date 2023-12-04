<?php include_once realpath(__DIR__) . '/header.php'; ?>
<?php include_once realpath(__DIR__) . '/dropdown.php'; ?>
<?php include_once realpath(__DIR__) . '/styledatatable.php'; ?>

</head>
<!-- END HEAD -->






<body class="page-header-fixed sidemenu-closed-hidelogo page-content-white page-md page-full-width header-white white -sidebar-color logo-white">
    <div class="page-wrapper">
        
        <!-- start header -->
        <div class="page-header navbar navbar-fixed-top">
           <div class="page-header-inner ">

       <!--Navbar-->
       <nav class="mb-1 navbar navbar-expand-lg navbar-light default-color">
                          <a class="navbar-brand" href="<?php echo baseUrl; ?>index.php">
                            <img alt="Smiley face" src="<?php echo baseUrl; ?>assets/images/Logo/Default/bb.png" width="100" height="38">
                          </a>
                          <!-- Collapse button -->
                          <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#basicExampleNav"
                            aria-controls="basicExampleNav" aria-expanded="false" aria-label="Toggle navigation">
                            <span class="navbar-toggler-icon"></span>
                          </button>
                          <!-- Collapsible content -->
                          <div class="collapse navbar-collapse custom-navbar-collapse" id="basicExampleNav">
                            <ul class="navbar-nav mr-auto custom-navbar-nav">

                                <?php
                                //print_r($_SESSION['PageDetails']); exit; 
                            if (isset($_SESSION['PageDetails']) && !empty($_SESSION['PageDetails'])) {
                                foreach ($_SESSION['PageDetails'] as $pageDetails) {
                                    $submenuItem = (isset($pageDetails['ParentPages'])) ? $pageDetails['ParentPages'] : "";
                                    $showAsMenu = (isset($pageDetails['ShowAsMenu'])) ? $pageDetails['ShowAsMenu'] : "";
                                    
                                    if (empty($submenuItem) && $showAsMenu) {
                                        $flag  = 0;
                                        $flagSub  = 0;
                                        $tempArrSubMenu = array();
                                        $tempArrSub1Menu = array();

                                        ?>
                                         <?php foreach ( $_SESSION['PageDetails'] as $submenu) {
                                                    $tempArr= array(); 
                                                    $parentPa = explode(',',$submenu['ParentPageText']);
                                                    if(in_array($pageDetails['PageMenuText'], $parentPa)){
                                                        $flag = 1;
                                                        $tempArr['PageMenuText']= $submenu['PageMenuText'];
                                                        $tempArr['SecondaryPageMenuOrder'] = !empty($submenu['SecondaryPageMenuOrder'])?$submenu['SecondaryPageMenuOrder']:1;
                                                        $tempArr['PageId']= $submenu['PageId'];
                                                        
                                                        array_push($tempArrSubMenu,   $tempArr);
                                                        }
                                                    }

                                                    $keys = array_column($tempArrSubMenu, 'SecondaryPageMenuOrder');
                                                    array_multisort($keys, SORT_ASC, $tempArrSubMenu);

                                                     ?>
                                         <li class="nav-item dropdown" id="navbarDropdown">
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
                                                    <li class="nav-item dropdown titleHover" id="navbarDropdown">
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
                                                    
                                                    $parentPa = explode(',',$submenu1['ParentPageText']);
                                                    if(in_array($submenu['PageMenuText'], $parentPa)){
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
                                                    
                                                    $keys = array_column($tempArrSub1Menu, 'SecondaryChildPageMenuOrder');
                                                    array_multisort($keys, SORT_ASC, $tempArrSub1Menu);

                                                     ?>
                                                    <li class="dropdown-item dropdown-submenu" id="navbarDropdown">
                                                        <a  href="<?php echo baseUrl . 'page?id=' . $submenu['PageId'].'&page_text='.$submenu['PageMenuText']; ?>" class="dropdown-item"> <span class="title"> <?php echo $submenu['PageMenuText']; ?><?php if(isset($flagCheck[$submenu['PageMenuText']]) && $flagCheck[$submenu['PageMenuText']] == 1  ) {?><i class="arrow"></i><?php } ?></span></a>
                                            
                                                    <ul class="dropdown-menu">
                                                    <?php 

                                                    foreach ( $tempArrSub1Menu as $submenu1) {
                                                    if($submenu['PageMenuText'] == $submenu1['ParentPageText']){
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
                            } ?>

                            </ul>
                            
                            <div class="top-menu">                       
                                <ul class="nav navbar-nav pull-right">

	<!-- start notification dropdown -->
    <li class="dropdown dropdown-extended dropdown-notification" id="header_notification_bar">
							<a href="javascript:;" class="dropdown-toggle" data-toggle="dropdown" data-hover="dropdown"
								data-close-others="true">
								<i class="fa fa-bell-o"></i>
								<span class="badge headerBadgeColor1"> 6 </span>
							</a>
							<ul class="dropdown-menu animated swing">
								<li class="external">
									<h3><span class="bold">Notifications</span></h3>
									<span class="notification-label purple-bgcolor">New 6</span>
								</li>
								<li>
									<ul class="dropdown-menu-list small-slimscroll-style" data-handle-color="#637283">
										<li>
											<a href="javascript:;">
												<span class="time">just now</span>
												<span class="details">
													<span class="notification-icon circle deepPink-bgcolor"><i
															class="fa fa-check"></i></span> Congratulations!. </span>
											</a>
										</li>
										<li>
											<a href="javascript:;">
												<span class="time">3 mins</span>
												<span class="details">
													<span class="notification-icon circle purple-bgcolor"><i
															class="fa fa-user o"></i></span>
													<b>John Micle </b>is now following you. </span>
											</a>
										</li>
										<li>
											<a href="javascript:;">
												<span class="time">7 mins</span>
												<span class="details">
													<span class="notification-icon circle blue-bgcolor"><i
															class="fa fa-comments-o"></i></span>
													<b>Sneha Jogi </b>sent you a message. </span>
											</a>
										</li>
										<li>
											<a href="javascript:;">
												<span class="time">12 mins</span>
												<span class="details">
													<span class="notification-icon circle pink"><i
															class="fa fa-heart"></i></span>
													<b>Ravi Patel </b>like your photo. </span>
											</a>
										</li>
										<li>
											<a href="javascript:;">
												<span class="time">15 mins</span>
												<span class="details">
													<span class="notification-icon circle yellow"><i
															class="fa fa-warning"></i></span> Warning! </span>
											</a>
										</li>
										<li>
											<a href="javascript:;">
												<span class="time">10 hrs</span>
												<span class="details">
													<span class="notification-icon circle red"><i
															class="fa fa-times"></i></span> Application error. </span>
											</a>
										</li>
									</ul>
									<div class="dropdown-menu-footer">
										<a href="javascript:void(0)"> All notifications </a>
									</div>
								</li>
							</ul>
						</li>
						<!-- end notification dropdown -->

                                    <!-- start manage user dropdown -->
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
                                                        echo $_SESSION['UserFirstName']; 
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
                                           <ul class="nav navbar-nav pull-right">
                                                <li class="dropdown dropdown-quick-sidebar-toggler">
                                                    <a>FAQ</a>
                                                </li>  
                                            </ul>
                                          
			
                        



                                            
                                
<!-- end manage user dropdown -->
     
                                
                             

                            <!-- Links -->
                          </div>
                        
                          <!-- Collapsible content -->
                        </nav>

                          <!--/.Navbar-->
                          
                          
                          
                          

                    
                </div>  
        </div>  
        <!-- end header --> 
        <?php include_once realpath(__DIR__) . '/btnold.php'; ?>




