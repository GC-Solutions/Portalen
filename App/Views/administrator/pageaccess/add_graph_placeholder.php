<?php include_once realpath(__DIR__ . '/../..') . '/layout/Admin_Layout/header_start.php'; ?>

<?php include_once realpath(__DIR__ . '/../..') . '/layout/Admin_Layout/header_menu.php'; ?>
    <div class="page-container">
<?php include_once realpath(__DIR__ . '/../..') . '/layout/Admin_Layout/side_bar.php'; ?>
        <div class="page-content-wrapper">
            <div class="page-content">

                <div class="row">
                    <div class="col-md-12 col-sm-12">
                        <div class="card card-box">
                            <div class="card-head">
                                <header>Add Graph(s) placeholder for <?= $getUserAccessPageDetails['PageMenuText'];?> <?= $userName; ?></header>
                                <button id="panel-button1"
                                        class="mdl-button mdl-js-button mdl-button--icon pull-right"
                                        data-upgraded=",MaterialButton">
                                    <i class="material-icons">more_vert</i>
                                </button>
                                <ul class="mdl-menu mdl-menu--bottom-right mdl-js-menu mdl-js-ripple-effect"
                                    data-mdl-for="panel-button1">
                                    <li class="mdl-menu__item"><i class="material-icons">assistant_photo</i>Action</li>
                                    <li class="mdl-menu__item"><i class="material-icons">print</i>Another action</li>
                                    <li class="mdl-menu__item"><i class="material-icons">favorite</i>Something else here
                                    </li>
                                </ul>
                            </div>
                            <div class="card-body" id="bar-parent1">
                                <form action="<?php echo baseUrl . 'saveuserpageplaceholders'; ?>"
                                      method="post" id="form_sample_1" class="form-horizontal">
                                    <input type="hidden" name="UserId" value="<?php echo $_REQUEST['userAccessId']; ?>">
                                    <input type="hidden" name="UserPageAccessId" value="<?php echo $_REQUEST['pageId']; ?>">
                                    <input type="hidden" name="PlaceholderType" value="3">
                                    <input type="hidden" name="id" value="<?= $id = (isset($getUserPagePlaceholder['ID'])) ? $getUserPagePlaceholder['ID'] : ""; ?>">

                                    <div class="form-body">


                                        <div class="form-group row">
                                            <label class="control-label col-md-3">Graph page placeholder
                                                <span class="required"> * </span>
                                            </label>
                                            <?php
                                            $getPagePanels = $getUserAccessPageDetails['PagePanels'];
                                            $getPagePanels = explode(',', $getPagePanels);
                                            $selectedPlaceholderValue = (isset($getUserPagePlaceholder['PlaceholderValue'])) ? $getUserPagePlaceholder['PlaceholderValue'] : "";
                                            ?>
                                            <div class="col-md-4">
                                                <select class="form-control" required name="PlaceholderValue">
                                                    <option value="">Select</option>
                                                    <?php foreach ($getPagePanels as $eachPanel) {
                                                        $selectedOption = "";
                                                        if($selectedPlaceholderValue == $eachPanel){
                                                            $selectedOption = "selected='selected'";
                                                        }
                                                        ?>
                                                        <option <?= $selectedOption;?>
                                                            value="<?= $eachPanel; ?>"><?= $eachPanel; ?></option>
                                                    <?php } ?>

                                                </select>
                                            </div>
                                        </div>


                                        <div class="form-group row">
                                            <label class="control-label col-md-3">Placeholder content
                                                <span class="required"> * </span>
                                            </label>
                                            <?php
                                                $selectedPlaceholderId = (isset($getUserPagePlaceholder['PlaceholderId'])) ? $getUserPagePlaceholder['PlaceholderId'] : "";
                                            ?>
                                            <div class="col-md-4">
                                                <select class="form-control  select2-multiple" data-maximum-selection-length="1" multiple required name="PlaceholderId">
                                                    <option value="">Select</option>
                                                    <?php foreach ($getAllGraph as $key => $value ) {
                                                        $selectedOption = "";

                                                        if($selectedPlaceholderId == $value['ID']){
                                                            $selectedOption = "selected='selected'";
                                                        }
                                                        ?>
                                                        <option <?= $selectedOption;?>
                                                            value="<?php echo $value['ID']; ?>"><?php echo $value['Name']; ?></option>
                                                    <?php } ?>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <label class="control-label col-md-3">
                                                Action
                                                <span class="required"> * </span>
                                            </label>
                                            <?php
                                                $selectedPlaceholderActionValue = (isset($getUserPagePlaceholder['PlaceholderActionIds'])) ? $getUserPagePlaceholder['PlaceholderActionIds'] : "";
                                            ?>
                                            <div class="col-md-4">
                                                <select name="PlaceholderActionIds" class="form-control">
                                                    <option value=""> Select</option>
                                                    <?php foreach ($getAllGraphActions as $key => $value ) {
                                                            $selectedOption = "";
                                                            if(!empty($selectedPlaceholderActionValue)){
                                                                if($value['ID'] == $selectedPlaceholderActionValue){
                                                                    $selectedOption = "selected='selected'";
                                                                }
                                                            }
                                                        ?>
                                                        <option <?= $selectedOption;?>
                                                            value="<?php echo $value['ID']; ?>"><?php echo $value['Name']; ?></option>
                                                    <?php } ?>
                                                </select>
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
                                                <a class="btn deepPink-bgcolor" a
                                                   href="<?php echo baseUrl . 'pagepanels?pageId=' . $_REQUEST['pageId'] . '&userAccessId=' . $_REQUEST['userAccessId']; ?>">Cancel
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
            </div>
        </div>
    </div>
<?php include_once realpath(__DIR__ . '/../..') . '/layout/Admin_Layout/footer_start.php'; ?>