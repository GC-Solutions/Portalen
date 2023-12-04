

<?php include_once realpath(__DIR__ . '/../..') . '/layout/dropdown.php'; ?>
<?php include_once realpath(__DIR__ . '/../..') . '/layout/styledatatable.php'; ?>
</head>
<!-- END HEAD -->
<body class="page-header-fixed sidemenu-closed-hidelogo page-content-white page-md page-full-width header-white white -sidebar-color logo-white">

	    <!-- start Menu Header  -->
        <div class="page-header navbar navbar-fixed-top">

           <div class="page-header-inner ">
                 <!-- Start Nav Bar -->
                <nav class="mb-1 navbar navbar-expand-lg navbar-light default-color">
                    <a class="navbar-brand" href="<?php echo baseUrl; ?>index.php">
                        <img alt="Smiley face" src="<?php echo baseUrl; ?>assets/images/Logo/Default/bbvit.png" width="90" height="38">
                    </a>
                    <!-- Collapse button -->
                    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#basicExampleNav"
                    aria-controls="basicExampleNav" aria-expanded="false" aria-label="Toggle navigation">
                    <i class="fas fa-bars"></i>
                    </button>
                    <!-- Collapsible content -->
                    <div class="collapse navbar-collapse custom-navbar-collapse" id="basicExampleNav">
                        <ul class="navbar-nav mr-auto custom-navbar-nav">       
                            <?php if (isset($_SESSION) && isset($_SESSION['IsAdmin']) && $_SESSION['IsAdmin'] == 1) { 
                                        $url = 'http://' . $_SERVER['SERVER_NAME'] . $_SERVER['REQUEST_URI'];
                                        $companiesLink = '';
                                        $placeholderLink = '';
                                        $menusLink = '';
                                        $dataSource = '';
                                        $parameter = '';
                                        $api = '';
                                        $address = '';
                                        $twoTables = '';
                                        $adminDB = '';
                                        $images = '';
                                        $design = '' ;
                                        $notification = '';
                                        if (strpos($url, 'companies') !== false) {
                                            $companiesLink = 'active';
                                        } else if (strpos($url, 'placeholder') !== false) {
                                            $placeholderLink = 'active';
                                        } else if (strpos($url, 'menu') !== false) {
                                            $menusLink = 'active';
                                        } else if (strpos($url, 'data_source') !== false) {
                                            $dataSource = 'active';
                                        }else if (strpos($url, 'parameter') !== false) {
                                            $parameter = 'active';
                                        }
                                        else if (strpos($url, 'api') !== false) {
                                            $api = 'active';
                                        }
                                        else if (strpos($url, 'address') !== false) {
                                            $address = 'active';
                                        }else if (strpos($url, 'twoTable') !== false) {
                                            $twoTables = 'active';
                                        }else if (strpos($url, 'adminDB') !== false) {
                                            $adminDB = 'active';
                                        }else if (strpos($url, 'images') !== false) {
                                            $images = 'active';
                                        }
                                        else if (strpos($url, 'dataTableDesign') !== false) {
                                            $design = 'active';
                                        }
                                        else if (strpos($url, 'pushNotification') !== false) {
                                            $notification = 'active';
                                        }
                                ?>
                                    <li class="nav-item <?= $companiesLink; ?>">
                                        <a href="<?php echo baseUrl; ?>companies" class="nav-link nav-toggle">
                                            <span class="title">Companies</span>
                                        </a>
                                    </li>

                                    <li class="nav-item <?= $placeholderLink; ?>">
                                        <a href="<?php echo baseUrl; ?>placeholders" class="nav-link nav-toggle">
                                            <span class="title">Placeholders</span>
                                        </a>
                                    </li>
                                    <li class="nav-item <?= $dataSource; ?>">
                                        <a href="<?php echo baseUrl; ?>data_source" class="nav-link nav-toggle">
                                            <span class="title">Data source template</span>
                                        </a>
                                    </li>
                                    <li class="nav-item <?= $menusLink; ?>">
                                        <a href="<?php echo baseUrl; ?>pagetemplates" class="nav-link nav-toggle">
                                            <span class="title">Page templates</span>
                                        </a>
                                    </li>
                                    <li class="nav-item <?= $parameter; ?>">
                                        <a href="<?php echo baseUrl; ?>parameter" class="nav-link nav-toggle">
                                            <span class="title">Parameter</span>
                                        </a>
                                    </li>
                                    <li class="nav-item <?=  $api ; ?>">
                                        <a href="<?php echo baseUrl; ?>api" class="nav-link nav-toggle">
                                            <span class="title">API</span>
                                        </a>
                                    </li>
                                    <li class="nav-item <?= $address; ?>">
                                        <a href="<?php echo baseUrl; ?>address" class="nav-link nav-toggle">
                                            <span class="title">Address</span>
                                        </a>
                                    </li>
                                    <li class="nav-item <?= $twoTables; ?>">
                                        <a href="<?php echo baseUrl; ?>twoTable" class="nav-link nav-toggle">
                                            <span class="title">Linking Tables</span>
                                        </a>
                                    </li>
                                    <li class="nav-item <?= $adminDB; ?>">
                                        <a href="<?php echo baseUrl; ?>adminDB" class="nav-link nav-toggle">
                                            <span class="title">Admin DB</span>
                                        </a>
                                    </li>
                                    <li class="nav-item <?= $images; ?>">
                                        <a href="<?php echo baseUrl; ?>images" class="nav-link nav-toggle">
                                            <span class="title">Images</span>
                                        </a>
                                    </li>
                                    <li class="nav-item <?= $design; ?>">
                                        <a href="<?php echo baseUrl; ?>dataTableDesign" class="nav-link nav-toggle">
                                            <span class="title">Table Design </span>
                                        </a>
                                    </li>
                                    <li class="nav-item <?= $notification; ?>">
                                        <a href="<?php echo baseUrl; ?>pushNotification" class="nav-link nav-toggle">
                                            <span class="title">Push Notification </span>
                                        </a>
                                    </li>
                                    <?php } ?>
                                
                        </ul>                                  
                        <ul class="nav navbar-nav pull-right">
                            <!-- start manage user dropdown -->
                            <li class="dropdown dropdown-user">
                                    <a class="nav-link dropdown-toggle" id="navbarDropdownMenuLink-333" data-toggle="dropdown" data-close-others="true">                    
                                        <span class="username username-hide-on-mobile"> <?php if(isset($_SESSION['CompanyName'])){ echo $_SESSION['CompanyName'];}?>-</span>                        
                                        <span class="username username-hide-on-mobile"> <?php if ($_SESSION) {
                                            echo $_SESSION['UserFirstName']; 
                                        } ?></span>
                                        <i class="fa fa-angle-down"></i>
                                    </a>

                                <ul class="dropdown-menu dropdown-menu-default animated jello">
                                    
                                    
                                    <li>
                                            </li><li>
                                            <a href="<?php echo baseUrl; ?>logout">
                                            <i class="icon-logout"></i> Logout </a>
                                        </li>                                         
                                </ul>                               
                            </li>
                        </ul>
                    </div>
                </nav>
                <!-- End Nav Bar -->           
            </div>  

        </div>  
        <!-- End Menu Header --> 





