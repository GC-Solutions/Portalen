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
                            <header>Edit page template</header>
                        </div>
                        <div class="card-body" id="bar-parent1">
                            <form action="<?php echo baseUrl; ?>savepagetemplate" method="post"
                                  class="form-horizontal">
                                <input type="hidden" name="id"
                                       value="<?= $id = (isset($getPageDetails['ID'])) ? $getPageDetails['ID'] : ""; ?>">

                                <div class="form-body">
                                    <div class="form-group row">
                                        <label class="control-label col-md-3">Page Text
                                            <span class="required"> * </span>
                                        </label>

                                        <div class="col-md-4">
                                            <input type="text" name="PageText"
                                                   value="<?= $pageText = (isset($getPageDetails['PageText'])) ? $getPageDetails['PageText'] : ""; ?>"
                                                   required data-required="1" class="form-control"/>
                                        </div>
                                    </div>


                                    <div class="form-group row">
                                        <label class="control-label col-md-3">Page Filename
                                            <span class="required"> * </span>
                                        </label>

                                        <div class="col-md-4">
                                            <input type="text" name="PageFilename"
                                                   value="<?= $pageFilename = (isset($getPageDetails['PageFilename'])) ? $getPageDetails['PageFilename'] : ""; ?>"
                                                   required data-required="1" class="form-control"/>
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label class="control-label col-md-3">Page Description
                                            <span class="required"> * </span>
                                        </label>

                                        <div class="col-md-4">
                                            <input type="text" name="PageDescription"
                                                   value="<?= $pageDesription = (isset($getPageDetails['PageDescription'])) ? $getPageDetails['PageDescription'] : ""; ?>"
                                                   required data-required="1" class="form-control"/>
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label class="control-label col-md-3">Page Panels
                                            <span class="required"> * </span>
                                        </label>

                                        <div class="col-md-4">
                                            <textarea type="text" name="PagePanels" required data-required="1"
                                                      class="form-control"><?= $pagePanels = (isset($getPageDetails['PagePanels'])) ? $getPageDetails['PagePanels'] : ""; ?></textarea>
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
                                                   href="<?php echo baseUrl; ?>pagetemplates">Cancel
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
