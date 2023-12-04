<?php 
    $check = 0;
 if($check == 1){?>
<!-- start sidebar menu -->
<div class="sidebar-container">
    <div class="sidemenu-container navbar-collapse collapse fixed-menu">
        <div id="remove-scroll">
            <ul class="sidemenu page-header-fixed p-t-20" data-keep-expanded="false" data-auto-scroll="true">
	                <!--//data-slide-speed="1000"-->
                
                <?php if (isset($_SESSION) && isset($_SESSION['IsAdmin']) && $_SESSION['IsAdmin'] == 1) { ?>
                    <li class="nav-item">
                        
                        <ul class="sub-menu">
                            <?php

                            if (isset($_SESSION['PageDetails']) && !empty($_SESSION['PageDetails'])) {
                                foreach ($_SESSION['PageDetails'] as $pageDetails) {
                                    $submenuItem = (isset($pageDetails['ParentPages'])) ? $pageDetails['ParentPages'] : "";
                                    $showAsMenu = (isset($pageDetails['ShowAsMenu'])) ? $pageDetails['ShowAsMenu'] : "";
                                    if (empty($submenuItem) && $showAsMenu) {
                                        ?>
                                        <li class="nav-item">
                                            <a href="<?php echo baseUrl . 'page?id=' . $pageDetails['PageTableID'].'&page_text=' .$pageDetails['PageMenuText']; ?>"
                                               class="nav-link ">
                                                <span class="title"><?php echo $pageDetails['PageMenuText']; ?></span>
                                            </a>
                                        </li>
                                    <?php }
                                }
                            } ?>
                        </ul>
                    </li>
                <?php } else if (isset($_SESSION['PageDetails']) && !empty($_SESSION['PageDetails'])) {

                    foreach ($_SESSION['PageDetails'] as $pageDetails) {
                        $submenuItem = (isset($pageDetails['ParentPages'])) ? $pageDetails['ParentPages'] : "";
                        $showAsMenu = (isset($pageDetails['ShowAsMenu'])) ? $pageDetails['ShowAsMenu'] : "";

                        $pageId = (isset($_REQUEST['id'])) ? $_REQUEST['id'] : "";
                        $activePage = "";
                        if ($pageId == $pageDetails['PageTableID']) {
                            //$activePage = "active";
                        }

                        if (empty($submenuItem) && $showAsMenu) {
                            ?>
                            <li class="nav-item <?= $activePage; ?>">
                                <a href="<?php echo baseUrl . 'page?id=' . $pageDetails['PageTableID'].'&page_text=' .$pageDetails['PageMenuText']; ?>">
                                    <i class="material-icons">store_mall_directory</i>
                                    <span class="title"><?php echo $pageDetails['PageMenuText']; ?></span>
                                </a>
                            </li>
                        <?php }
                    }
                } ?>

                <?php if (isset($_SESSION) && isset($_SESSION['IsAdmin']) && $_SESSION['IsAdmin'] == 1) { ?>

                    <?php
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
                    ?>
                    <li class="nav-item <?= $companiesLink; ?>">
                        <a href="<?php echo baseUrl; ?>companies" class="nav-link nav-toggle">
                            <i class="material-icons">assignment_ind</i>
                            <span class="selected"></span>
                            <span class="title">Companies</span>
                        </a>
                    </li>

                    <li class="nav-item <?= $placeholderLink; ?>">
                        <a href="<?php echo baseUrl; ?>placeholders" class="nav-link nav-toggle">
                            <i class="material-icons">store_mall_directory</i>
                            <span class="title">Placeholders</span>
                        </a>
                    </li>
                    <li class="nav-item <?= $dataSource; ?>">
                        <a href="<?php echo baseUrl; ?>data_source" class="nav-link nav-toggle">
                            <i class="material-icons">store_mall_directory</i>
                            <span class="selected"></span>
                            <span class="title">Data source template</span>
                        </a>
                    </li>
                    <li class="nav-item <?= $menusLink; ?>">
                        <a href="<?php echo baseUrl; ?>pagetemplates" class="nav-link nav-toggle">
                            <i class="material-icons">store_mall_directory</i>
                            <span class="selected"></span>
                            <span class="title">Page templates</span>
                        </a>
                    </li>
                     <li class="nav-item <?= $parameter; ?>">
                        <a href="<?php echo baseUrl; ?>parameter" class="nav-link nav-toggle">
                            <i class="material-icons">store_mall_directory</i>
                            <span class="selected"></span>
                            <span class="title">Parameter</span>
                        </a>
                    </li>
                     <li class="nav-item <?=  $api ; ?>">
                        <a href="<?php echo baseUrl; ?>api" class="nav-link nav-toggle">
                            <i class="material-icons">store_mall_directory</i>
                            <span class="selected"></span>
                            <span class="title">API</span>
                        </a>
                    </li>
                    <li class="nav-item <?= $address; ?>">
                        <a href="<?php echo baseUrl; ?>address" class="nav-link nav-toggle">
                            <i class="material-icons">store_mall_directory</i>
                            <span class="selected"></span>
                            <span class="title">Address</span>
                        </a>
                    </li>
                    <li class="nav-item <?= $twoTables; ?>">
                        <a href="<?php echo baseUrl; ?>twoTable" class="nav-link nav-toggle">
                            <i class="material-icons">store_mall_directory</i>
                            <span class="selected"></span>
                            <span class="title">Linking Tables</span>
                        </a>
                    </li>
                    <li class="nav-item <?= $adminDB; ?>">
                        <a href="<?php echo baseUrl; ?>adminDB" class="nav-link nav-toggle">
                            <i class="material-icons">store_mall_directory</i>
                            <span class="selected"></span>
                            <span class="title">Admin DB</span>
                        </a>
                    </li>
                    <li class="nav-item <?= $images; ?>">
                        <a href="<?php echo baseUrl; ?>images" class="nav-link nav-toggle">
                            <i class="material-icons">store_mall_directory</i>
                            <span class="selected"></span>
                            <span class="title">Images</span>
                        </a>
                    </li>
                    <li class="nav-item <?= $design; ?>">
                        <a href="<?php echo baseUrl; ?>dataTableDesign" class="nav-link nav-toggle">
                            <i class="material-icons">store_mall_directory</i>
                            <span class="selected"></span>
                            <span class="title">Table Design </span>
                        </a>
                    </li>
                <?php } ?>
            </ul>
        </div>
    </div>
</div>
<!-- end sidebar menu -->
<?php } ?>

