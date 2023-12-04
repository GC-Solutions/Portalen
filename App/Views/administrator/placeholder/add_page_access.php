<?php include_once realpath(__DIR__ . '/../..') . '/layout/Admin_Layout/header_start.php'; ?>

<?php include_once realpath(__DIR__ . '/../..') . '/layout/Admin_Layout/header_menu.php'; ?>
    <div class="page-container">
<?php include_once realpath(__DIR__ . '/../..') . '/layout/Admin_Layout/side_bar.php'; ?>
        <div class="page-content-wrapper">
            <div class="page-content">
                <div class="page-bar">
                    <div class="page-title-breadcrumb">
                        <h3>Add page access</h3>
                    </div>
                </div>


                <div class="row">
                    <div class="col-md-12 col-sm-12">
                        <div class="card card-box">
                            <div class="card-head">
                                <header>Add page access to User(_____)</header>

                            </div>
                            <div class="card-body" id="bar-parent1">
                                <form action="<?php echo baseUrl;?>saveuserpageaccess" method="post" id="form_sample_1" class="form-horizontal">
                                    <input type="hidden" name="UserID" value="<?php echo $_REQUEST['id'];?>">
                                    <div class="form-body">


                                        <div class="form-group row">
                                            <label class="control-label col-md-3">Select
                                                <span class="required"> * </span>
                                            </label>

                                            <div class="col-md-4">
                                                <select class="form-control" name="PageID" required>
                                                    <option value="">Select Page</option>
                                                    <?php foreach ($getAllPages as $pageDetails) { ?>
                                                        <option value="<?php echo $pageDetails['ID'];?>"><?php echo $pageDetails['PageText'];?></option>
                                                    <?php } ?>
                                                </select>
                                            </div>
                                        </div>


                                    </div>
                                    <div class="form-group">
                                        <div class="offset-md-3 col-md-9">
                                            <div class="btn-group">
                                                <button type="submit" id="addRow" class="btn btn-info">
                                                    Add <i class="fa fa-plus"></i>
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
<?php // include_once 'layout/footer_start.php'; ?>