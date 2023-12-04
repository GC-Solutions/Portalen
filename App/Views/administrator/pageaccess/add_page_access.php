<?php include_once realpath(__DIR__ . '/../..') . '/layout/Admin_Layout/header_start.php'; ?>

<?php include_once realpath(__DIR__ . '/../..') . '/layout/Admin_Layout/header_menu.php'; ?>
    <div class="page-container">
<?php include_once realpath(__DIR__ . '/../..') . '/layout/Admin_Layout/side_bar.php'; ?>
        <style>
            .checkboxes label {
                display: block;
                float: left;
                padding-right: 10px;
                white-space: nowrap;
            }

            .checkboxes input {
                vertical-align: middle;
                margin: 0px 0 0;
            }

            .checkboxes label span {
                vertical-align: middle;
                padding: 5px;
            }

            .padding_none {
                padding: 0px;
            }
        </style>
        <div class="page-content-wrapper">
            <div class="page-content">
                <div class="row">
                    <div class="col-md-12 col-sm-12">
                        <div class="card card-box">
                            <div class="card-head">
                                <header>Edit page for <?= $userName; ?></header>

                            </div>
                            <div class="card-body" id="bar-parent1">
                                <form action="<?php echo baseUrl; ?>saveuserpageaccess" method="post"
                                      class="form-horizontal">
                                    <input type="hidden" name="UserId"
                                           value="<?= $getUserId = (isset($_REQUEST['id'])) ? $_REQUEST['id'] : ""; ?>">
                                    <input type="hidden" name="id"
                                           value="<?= $getPageId = (isset($_REQUEST['PageId'])) ? $_REQUEST['PageId'] : ""; ?>">

                                    <div class="form-body">
                                        <div class="form-group row">
                                            <label class="control-label col-md-3">Page
                                                <span class="required"> * </span>
                                            </label>

                                            <div class="col-md-4">
                                                <?php
                                                $getPageId = (isset($getPageDetails['PageId'])) ? $getPageDetails['PageId'] : "";
                                                $PageMenuText = (isset($getPageDetails['PageMenuText'])) ? $getPageDetails['PageMenuText'] : "";
                                                ?>
                                                <select class="form-control" name="PageId" required>
                                                    <option value="">Select</option>
                                                    <?php foreach ($getAllPages as $pageDetails) {
                                                        $selectedOption = "";
                                                        if (!empty($getPageId) && $pageDetails['ID'] == $getPageId) {
                                                            $selectedOption = "selected='selected'";
                                                        }
                                                        ?>
                                                        <option <?= $selectedOption; ?>
                                                            value="<?php echo $pageDetails['ID']; ?>"><?php echo $pageDetails['PageText']; ?></option>
                                                    <?php }
                                                    //}
                                                    ?>
                                                </select>
                                            </div>
                                        </div>
                                        <?php if (count($getUserPages) > 0) { ?>
                                            <div class="form-group row">
                                                <label class="control-label col-md-3">
                                                    Select Parent Page
                                                </label>

                                                <div class="col-md-9">

                                                    <div class="col-md-12 padding_none">
                                                        <div class="checkboxes">
                                                            <?php foreach ($getUserPages as $eachPage) {
                                                                $getSubmenus = "";
                                                                if ($getPageDetails) {
                                                                    $getParentPages = $getPageDetails['ParentPages'];
                                                                    $getParentPagesText = $getPageDetails['ParentPageText'];
                                                                }
                                                                /*echo '<pre>';
                                                                print_r($getParentPages);
                                                                echo '<pre>';
                                                                print_r($getParentPagesText);*/
                                                                $getSubmenuArray = array();
                                                                $getSubmenuTextArray = array();
                                                                if (!empty($getParentPages)) {
                                                                    $getSubmenuArray = explode(',', $getParentPages);
                                                                }
                                                                if (!empty($getParentPagesText)) {
                                                                    $getSubmenuTextArray = explode(',', $getParentPagesText);
                                                                }
                                                                $getPageId = (isset($getPageDetails['PageId'])) ? $getPageDetails['PageId'] : "";

                                                                if (isset($_GET['pageId']) && $_GET['pageId'] == $eachPage['PageTableID']) {
                                                                    continue;
                                                                }

                                                                if ($getPageId == $eachPage['PageTableID'] && $PageMenuText == $eachPage['PageMenuText']) {
                                                                    continue;
                                                                }


                                                                $checkboxChecked = "";
                                                                if (count($getSubmenuArray) > 0) {
                                                                    if (in_array($eachPage['PageTableID'], $getSubmenuArray) && in_array($eachPage['PageMenuText'], $getSubmenuTextArray)) {
                                                                        $checkboxChecked = "checked='checked'";
                                                                    }
                                                                }
                                                                ?>
                                                                <label>
                                                                    <input type="checkbox"
                                                                           name="ParentPages[]" <?php echo $checkboxChecked; ?>
                                                                           value="<?php echo $eachPage['PageTableID'].'_'.$eachPage['PageMenuText']; ?>"/><span><?php echo $eachPage['PageMenuText']; ?></span>
                                                                </label>
                                                            <?php } //die;
                                                            ?>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        <?php } ?>

                                         <?php if (count($getSecondaryUserPages) > 0) { ?>
                                            <div class="form-group row">
                                                <label class="control-label col-md-3">
                                                    Select Secondary Parent Page
                                                </label>

                                                <div class="col-md-9">

                                                    <div class="col-md-12 padding_none">
                                                        <div class="checkboxes">
                                                            <?php foreach ($getSecondaryUserPages as $eachPage) {
                                                                $getSubmenus = "";
                                                                if ($getPageDetails) {
                                                                    $getParentPages = $getPageDetails['ParentPages'];
                                                                    $getParentPagesText = $getPageDetails['ParentPageText'];

                                                                }
                                                                /*echo '<pre>';
                                                                print_r($getParentPages);
                                                                echo '<pre>';
                                                                print_r($getParentPagesText);*/
                                                                $getSubmenuArray = array();
                                                                $getSubmenuTextArray = array();
                                                                if (!empty($getParentPages)) {
                                                                    $getSubmenuArray = explode(',', $getParentPages);
                                                                }

                                                                if (!empty($getParentPagesText)) {
                                                                    $getSubmenuTextArray = explode(',', $getParentPagesText);
                                                                }

                                                                $getPageId = (isset($getPageDetails['PageId'])) ? $getPageDetails['PageId'] : "";

                                                                if (isset($_GET['pageId']) && $_GET['pageId'] == $eachPage['PageTableID']) {
                                                                    continue;
                                                                }
                                                                
                                                                if ($getPageId == $eachPage['PageTableID'] && $PageMenuText == $eachPage['PageMenuText']) {
                                                                    continue;
                                                                }


                                                                $checkboxChecked = "";
                                                                if (count($getSubmenuArray) > 0) {
                                                                    if (in_array($eachPage['PageTableID'], $getSubmenuArray) && in_array($eachPage['PageMenuText'], $getSubmenuTextArray)) {
                                                                        $checkboxChecked = "checked='checked'";
                                                                    }
                                                                }
                                                                
                                                                ?>
                                                                <label>
                                                                    <input type="checkbox"
                                                                           name="ParentPages[]" <?php echo $checkboxChecked; ?>
                                                                           value="<?php echo $eachPage['PageTableID'].'_'.$eachPage['PageMenuText']; ?>"/><span><?php echo $eachPage['PageMenuText']; ?></span>
                                                                </label>
                                                            <?php } //die;
                                                            ?>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        <?php } ?>

                                        <div class="form-group row">
                                            <label class="control-label col-md-3">
                                                Page menu label
                                                <span class="required"> * </span>
                                            </label>

                                            <div class="col-md-4">
                                                <input type="text" name="PageMenuText" required="" data-required="1"
                                                       value="<?= $pageMenuOrder = (isset($getPageDetails["PageMenuText"])) ? $getPageDetails["PageMenuText"] : ""; ?>"
                                                       class="form-control"/>
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <label class="control-label col-md-3">
                                                Menu order
                                            </label>

                                            <div class="col-md-4">
                                                <input type="number" min="1" name="PageMenuOrder" required=""
                                                       value="<?= $pageMenuOrder = (isset($getPageDetails["PageMenuOrder"])) ? $getPageDetails["PageMenuOrder"] : ""; ?>"
                                                       class="form-control"/>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="control-label col-md-3">
                                                Secondary Menu order
                                            </label>

                                            <div class="col-md-4">
                                                <input type="number" min="0" name="SecondaryPageMenuOrder" 
                                                       value="<?= $pageMenuOrder = (isset($getPageDetails["SecondaryPageMenuOrder"])) ? $getPageDetails["SecondaryPageMenuOrder"] : ""; ?>"
                                                       class="form-control"/>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="control-label col-md-3">
                                                Third Menu order
                                            </label>

                                            <div class="col-md-4">
                                                <input type="number" min="0" name="SecondaryChildPageMenuOrder" 
                                                       value="<?= $pageMenuOrder = (isset($getPageDetails["SecondaryChildPageMenuOrder"])) ? $getPageDetails["SecondaryChildPageMenuOrder"] : ""; ?>"
                                                       class="form-control"/>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="control-label col-md-3">
                                                First page After Login 
                                            </label>

                                            <div class="col-md-9">

                                                <div class="col-md-12 padding_none">
                                                    <div class="checkboxes">
                                                        <?php
                                                        $DefaultFirstPage = (isset($getPageDetails["DefaultFirstPage"])) ? $getPageDetails["DefaultFirstPage"] : 0;
                                                        $checked = "";
                                                        if ($DefaultFirstPage) {
                                                            $checked = "checked='checked'";
                                                        }
                                                        ?>
                                                        <label>
                                                            <input type="checkbox" <?= $checked; ?> name="DefaultFirstPage"
                                                                   value="1"/>
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="control-label col-md-3">
                                                Show as menu
                                            </label>

                                            <div class="col-md-9">

                                                <div class="col-md-12 padding_none">
                                                    <div class="checkboxes">
                                                        <?php
                                                        $showAsMenu = (isset($getPageDetails["ShowAsMenu"])) ? $getPageDetails["ShowAsMenu"] : 0;
                                                        $checked = "";
                                                        if ($showAsMenu) {
                                                            $checked = "checked='checked'";
                                                        }
                                                        ?>
                                                        <label>
                                                            <input type="checkbox" <?= $checked; ?> name="ShowAsMenu"
                                                                   value="1"/>
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                          <div class="form-group row">
                                            <label class="control-label col-md-3">
                                                Enable / Disable Parent Link
                                            </label>

                                            <div class="col-md-9">

                                                <div class="col-md-12 padding_none">
                                                    <div class="checkboxes">
                                                        <?php
                                                        $parentLinkFlag = (isset($getPageDetails["ParentLinkFlag"])) ? $getPageDetails["ParentLinkFlag"] : 0;
                                                        $checked = "";
                                                        if ($parentLinkFlag) {
                                                            $checked = "checked='checked'";
                                                        }
                                                        ?>
                                                        <label>
                                                            <input type="checkbox" <?= $checked; ?> name="ParentLinkFlag"
                                                                   value="1"/>
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                         <div class="form-group row">
                                            <label class="control-label col-md-3">
                                                Enable / Disable Live Sync
                                            </label>

                                            <div class="col-md-9">

                                                <div class="col-md-12 padding_none">
                                                    <div class="checkboxes">
                                                        <?php
                                                        $LiveSyncFlag = (isset($getPageDetails["LiveSyncFlag"])) ? $getPageDetails["LiveSyncFlag"] : 0;
                                                        $checked = "";
                                                        if ($LiveSyncFlag) {
                                                            $checked = "checked='checked'";
                                                        }
                                                        ?>
                                                        <label>
                                                            <input type="checkbox" <?= $checked; ?> name="LiveSyncFlag"
                                                                   value="1"/>
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                       
                                         <div class="form-group row">
                                            <label class="control-label col-md-3">
                                                Live Sync Time
                                            </label>

                                            <div class="col-md-9">
                                                <div class="col-md-4 padding_none">
                                                    <input type="text" name="LiveSyncTime" 
                                                           value="<?= $LiveSyncTime = (isset($getPageDetails["LiveSyncTime"])) ? $getPageDetails["LiveSyncTime"] : ""; ?>"
                                                           class="form-control"/>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="control-label col-md-3">
                                                Enable Page for ticket design menu
                                            </label>

                                            <div class="col-md-9">

                                                <div class="col-md-12 padding_none">
                                                    <div class="checkboxes">
                                                        <?php
                                                        $EnableTicketMenuLabel = (isset($getPageDetails["EnableTicketMenuLabel"])) ? $getPageDetails["EnableTicketMenuLabel"] : 0;
                                                        $checked = "";
                                                        if ($EnableTicketMenuLabel) {
                                                            $checked = "checked='checked'";
                                                        }
                                                        ?>
                                                        <label>
                                                            <input type="checkbox" <?= $checked; ?> name="EnableTicketMenuLabel"
                                                                   value="1"/>
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group row"  >
                                            <label class="control-label col-md-3">
                                                Notifications Click
                                            </label>
                                            <div class="col-md-4">
                                                     <select name="onClickNoti[]" id="onClickNoti"
                                                            class="form-control select2-multiple" data-reorder="1" multiple  >
                                                        <option value="">Select</option>
                                                        <?php 
                                                            $onClickNoti = isset($getPageDetails['onClickNoti'])?$getPageDetails['onClickNoti']:array();
                                                            if ($onClickNoti) {
                                                                $onClickNoti = explode(',', $onClickNoti);
                                                            }
                                                            foreach ($getPushNotification as $key => $value) {
                                                                $selected = "";
                                                                if (!empty($onClickNoti) && in_array($value['ID'], $onClickNoti)) {
                                                                    $selected = 'selected="selected"';
                                                                }
                                                                echo '<option value= "' . $value['ID'] . '"' . $selected . '>' . $value['Name'] . '</option>';
                                                            }
                                                            
                                                            ?>
                                                        
                                                    </select>
                                            </div>          
                                        </div>
                                        <div class="form-group row">
                                            <label class="control-label col-md-3">
                                                Enable Fixed Header on tables for this Page 
                                            </label>

                                            <div class="col-md-9">

                                                <div class="col-md-12 padding_none">
                                                    <div class="checkboxes">
                                                        <?php
                                                        $EnableFixedHeader = (isset($getPageDetails["EnableFixedHeader"])) ? $getPageDetails["EnableFixedHeader"] : 0;
                                                        $checked = "";
                                                        if ($EnableFixedHeader) {
                                                            $checked = "checked='checked'";
                                                        }
                                                        ?>
                                                        <label>
                                                            <input type="checkbox" <?= $checked; ?> name="EnableFixedHeader"
                                                                   value="1"/>
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="control-label col-md-3">
                                                Enable Fixed Left Column  on tables for this Page 
                                            </label>

                                            <div class="col-md-9">

                                                <div class="col-md-12 padding_none">
                                                    <div class="checkboxes">
                                                        <?php
                                                        $EnableFixedLeftColumn = (isset($getPageDetails["EnableFixedLeftColumn"])) ? $getPageDetails["EnableFixedLeftColumn"] : 0;
                                                        $checked = "";
                                                        if ($EnableFixedLeftColumn) {
                                                            $checked = "checked='checked'";
                                                        }
                                                        ?>
                                                        <label>
                                                            <input type="checkbox" <?= $checked; ?> name="EnableFixedLeftColumn"
                                                                   value="1"/>
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="offset-md-3 col-md-9">
                                                <div class="btn-group">
                                                    <button type="submit" class="btn btn-info">
                                                        Save <i class="fa fa-plus"></i>
                                                    </button>
                                                </div>
                                                <div class="btn-group">
                                                    <a class="btn deepPink-bgcolor"
                                                       href="<?php echo baseUrl; ?>userpageaccess?id=<?php echo $_REQUEST['id']; ?>">Cancel
                                                        <i class="fa fa-angle-down"></i>
                                                    </a>
                                                </div>

                                            </div>
                                        </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- wizard with validation-->
            </div>
        </div>
    </div>
<?php include_once realpath(__DIR__ . '/../..') . '/layout/Admin_Layout/footer_start.php'; ?>