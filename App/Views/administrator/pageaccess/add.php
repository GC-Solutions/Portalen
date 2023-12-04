<?php include_once realpath(__DIR__ . '/../..') . '/layout/Admin_Layout/header_start.php'; ?>

<?php include_once realpath(__DIR__ . '/../..') . '/layout/Admin_Layout/header_menu.php'; ?>
    <div class="page-container">
<?php include_once realpath(__DIR__ . '/../..') . '/layout/Admin_Layout/side_bar.php'; ?>
    <div class="page-content-wrapper">
        <div class="page-content">
            <div class="page-bar">
                <div class="page-title-breadcrumb">
                    <div class=" pull-left">
                        <div class="page-title">Create Company User</div>
                    </div>
                </div>
            </div>


            <div class="row">
                <div class="col-md-12 col-sm-12">
                    <div class="card card-box">
                        <div class="card-head">
                            <header>Create Company User</header>
                        </div>
                        <div class="card-body" id="bar-parent1">
                            <form action="<?php echo baseUrl;?>saveuser" method="post" id="form_sample_1" class="form-horizontal">
                                <div class="form-body">
                                    <input type="hidden" value="<?php echo $_REQUEST['id'];?>" name="CompanyID">

                                    <div class="form-group row">
                                        <label class="control-label col-md-3">Name
                                            <span class="required"> * </span>
                                        </label>

                                        <div class="col-md-4">
                                            <input type="text" name="UserFirstName" required data-required="1" class="form-control"/>
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label class="control-label col-md-3">Lastname
                                            <span class="required"> * </span>
                                        </label>

                                        <div class="col-md-4">
                                            <input type="text" name="UserLastName" required  data-required="1" class="form-control"/>
                                        </div>
                                    </div>


                                    <div class="form-group row">
                                        <label class="control-label col-md-3">Start Date
                                            <span class="required"> * </span>
                                        </label>

                                        <div class="col-md-4">
                                            <input type="text" name="UserStartDate"  data-required="1" required class="form-control"/>
                                        </div>
                                    </div>


                                    <div class="form-group row">
                                        <label class="control-label col-md-3">End Date
                                            <span class="required"> * </span>
                                        </label>

                                        <div class="col-md-4">
                                            <input type="text" name="UserEndDate" data-required="1" required class="form-control"/>
                                        </div>
                                    </div>


                                    <div class="form-group row">
                                        <label class="control-label col-md-3">Email
                                            <span class="required"> * </span>
                                        </label>

                                        <div class="col-md-4">
                                            <input type="email" name="UserEmail" data-required="1" required class="form-control"/>
                                        </div>
                                    </div>


                                    <div class="form-group row">
                                        <label class="control-label col-md-3">Password
                                            <span class="required"> * </span>
                                        </label>

                                        <div class="col-md-4">
                                            <input type="password" name="UserPassword" required data-required="1" class="form-control"/>
                                        </div>
                                    </div>


                                </div>
                                <div class="form-group">
                                    <div class="offset-md-3 col-md-9">
                                        <div class="btn-group">
                                            <button type="submit" id="addRow" class="btn btn-info">
                                                Skapa <i class="fa fa-plus"></i>
                                            </button>
                                        </div>
                                        <div class="btn-group">
                                            <a class="btn deepPink-bgcolor" a href="<?php echo baseUrl;?>editcompany?id=<?= $_REQUEST['id'];?>">Ångra
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
<?php //include_once 'layout/footer_start.php'; ?>