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
                                <header>Add placeholder access for page (____)</header>
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
                                <form action="<?php echo baseUrl.'saveplaceholderaccess';?>" method="post" id="form_sample_1" class="form-horizontal">
                                    <input type="hidden" name="UserID" value="<?php echo $_REQUEST['userAccessId'];?>">
                                    <input type="hidden" name="PageID" value="<?php echo $_REQUEST['pageId'];?>">
                                    <div class="form-body">


                                        <div class="form-group row">
                                            <label class="control-label col-md-3">Role
                                                <span class="required"> * </span>
                                            </label>

                                            <div class="col-md-4">
                                                <select class="form-control" required name="PanelID">
                                                    <option value="">Select Panel</option>
                                                    <?php foreach ($allPanels as $eachPanel) { ?>
                                                        <option value="<?php echo $eachPanel['ID'];?>"><?php echo $eachPanel['PanelID'];?></option>
                                                    <?php } ?>

                                                </select>
                                            </div>
                                        </div>


                                        <div class="form-group row">
                                            <label class="control-label col-md-3">Role
                                                <span class="required"> * </span>
                                            </label>

                                            <div class="col-md-4">
                                                <select class="form-control" required name="PlaceholderID">
                                                    <option value="">Select placehoder</option>
                                                    <?php foreach ($allPlaceholders as $eachPlaceholder) { ?>
                                                        <option value="<?php echo $eachPlaceholder['PlaceholderID'];?>"><?php echo $eachPlaceholder['ID'];?></option>
                                                    <?php } ?>
                                                </select>
                                            </div>
                                        </div>


                                    </div>
                                    <div class="form-group row">
                                    <label class="control-label col-md-3">
                                    </label>
                                    <div class="col-md-4">
                                            <div class="btn-group">
                                                <button type="submit" class="btn btn-info">
                                                    Add <i class="fa fa-plus"></i>
                                                </button>
                                            </div>
                                            <div class="btn-group">
                                                <a class="btn deepPink-bgcolor" a href="<?php echo baseUrl.'pagepanels?pageId='.$_REQUEST['pageId'].'&userAccessId='.$_REQUEST['userAccessId'];?>">Cancel
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
<?php //include_once 'layout/footer_start.php'; ?>