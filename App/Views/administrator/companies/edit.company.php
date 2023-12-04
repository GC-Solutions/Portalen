<?php include_once realpath(__DIR__ . '/../..') . '/layout/Admin_Layout/header_start.php'; ?>

<?php include_once realpath(__DIR__ . '/../..') . '/layout/Admin_Layout/header_menu.php'; ?>
    <div class="page-container">
<?php include_once realpath(__DIR__ . '/../..') . '/layout/Admin_Layout/side_bar.php'; ?>
    <div class="page-content-wrapper">
        <div class="page-content">
            <div class="page-bar">
            </div>
            <div class="row">


                <div class="col-sm-12 col-md-3 col-lg-3">
                    <div class="card card-box">
                        <div class="card-body ">
                            <div class="row">

                            </div>
                            <div class="profile-usertitle">
                                <div class="profile-usertitle-name"><?php if ($getCompanyDetails) {
                                        echo $getCompanyDetails[0]['CompanyName'];
                                    } ?></div>
                            </div>
                            <ul class="list-group list-group-unbordered">
                                <li class="list-group-item">
                                    <b>Users</b> <a class="pull-right"><?php echo $getTotalUsers; ?></a>
                                </li>

                            </ul>
                            <!-- END SIDEBAR USER TITLE -->
                            <!-- SIDEBAR BUTTONS -->
                            <div class="profile-userbuttons">
                                <a style="font-size: 13px;" href="<?php echo baseUrl; ?>editcompany?type=editcompany&id=<?= $_REQUEST['id']; ?>"
                                   class="mdl-button mdl-js-button mdl-button--raised mdl-js-ripple-effect m-b-10 btn-circle btn-primary">
                                    Edit Company details
                                </a>
                            </div>
                            <!-- END SIDEBAR BUTTONS -->
                        </div>
                    </div>
                </div>


                <div class="col-sm-12 col-md-9 col-lg-9">
                    <div class="card card-box">
                        <div class="card-head">
                            <div class="row">
                                <div class="col-md-12 offset-md-1">
                                    <a href="<?php echo baseUrl; ?>adduser?id=<?= $_REQUEST['id']; ?>"
                                       class="mdl-button mdl-js-button mdl-button--raised mdl-js-ripple-effect m-b-10 btn-circle btn-primary">
                                        Create New User
                                    </a>
                                </div>
                            </div>
                        </div>
                        <div class="card-head">
                            <header><?= $companyName = (isset($getCompanyDetails[0]['CompanyName'])) ? $getCompanyDetails[0]['CompanyName'] : "";?> Users</header>
                        </div>
                        <div class="card-body ">
                            <div class="table-scrollable">
                                <table class="table table-hover table-checkable order-column full-width" id="example4">
                                    <thead>
                                    <tr>
                                        <th class="center">Name</th>
                                        <th class="center">Last-Name</th>
                                        <th class="center">Email</th>
                                        <th class="center">Password</th>
                                        <th class="center">Start Date</th>
                                        <th class="center">End Date</th>
                                        <th class="center"></th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php if ($getCompanyUsers) {
                                        foreach ($getCompanyUsers as $keys => $eachCompanyUser) { ?>
                                            <tr  onclick="window.location='<?php echo baseUrl; ?>edituser?id=<?= $eachCompanyUser['UserID']; ?>&companyId=<?= $_REQUEST['id']; ?>'">
                                                <td class="center"><?= $eachCompanyUser['UserFirstName']; ?></td>
                                                <td class="center"><?= $eachCompanyUser['UserLastName']; ?></td>
                                                <td class="center"><?= $eachCompanyUser['UserEmail']; ?></td>
                                                <td class="center"><?= str_repeat("*", strlen($eachCompanyUser['UserPassword'])); ?></td>
                                                <td class="center"><?= $eachCompanyUser['UserStartDate']; ?></td>
                                                <td class="center"><?= $eachCompanyUser['UserEndDate']; ?></td>
                                                <td class="center">
                                                    <a href="<?php echo baseUrl; ?>edituser?id=<?= $eachCompanyUser['UserID']; ?>&companyId=<?= $_REQUEST['id']; ?>"
                                                       class="btn btn-tbl-edit btn-xs">
                                                        <i class="fa fa-pencil"></i>
                                                    </a>
                                                    <?php if ($_SESSION['UserID'] != $eachCompanyUser['UserID']) { ?>
                                                        <a onclick="return confirm('Are you sure you want to delete this user?');"
                                                           href="<?php echo baseUrl; ?>deleteuser?id=<?= $eachCompanyUser['UserID']; ?>&companyId=<?= $_REQUEST['id']; ?>"
                                                           class="btn btn-tbl-delete btn-xs">
                                                            <i class="fa fa-trash-o "></i>
                                                        </a>
                                                    <?php } ?>
                                                    <a href="<?php echo baseUrl; ?>userpageaccess?id=<?= $eachCompanyUser['UserID']; ?>"
                                                       class="btn btn-tbl-edit btn-xs">
                                                        <i class="fa fa-ellipsis-h"></i>
                                                    </a>
                                                </td>
                                            </tr>
                                        <?php }
                                    }
                                    ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- end page content -->
    </div>
    <!-- end page container -->
<?php //include_once 'layout/footer_start.php'; ?>