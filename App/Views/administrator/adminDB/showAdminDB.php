<?php include_once realpath(__DIR__ . '/../..') . '/layout/Admin_Layout/header_start.php'; ?>

<?php include_once realpath(__DIR__ . '/../..') . '/layout/Admin_Layout/header_menu.php'; ?>
    <div class="page-container">
<?php include_once realpath(__DIR__ . '/../..') . '/layout/Admin_Layout/side_bar.php'; ?>
    <div class="page-content-wrapper">
        <div class="page-content">
            <div class="page-bar page-bar-admin">
                <div class="page-title-breadcrumb">
                    <ol class="breadcrumb breadcrumb-admin page-breadcrumb pull-left" style="margin: 5px 10px">
                        <li>
                            <i class="parent-item"></i>
                            <a class="parent-item" href="<?php echo baseUrl; ?>addAdminDB"><i class="fa fa-plus"></i> Add AdminDB </a>
                        </li>
                         
                        &nbsp;
                    </ol>

                </div>
            </div>
            <!-- start widget -->

            <div class="row">
                <div class="col-sm-12">
                    <div class="card-box">
                        <div class="card-head">
                            <header> All Admin DB's</header>
                        </div>

                        <table class="table table-hover table-checkable order-column full-width" id="example4">
                            <thead>
                            <tr>
                                
                                <th class="center">Name</th>
                                <th class="center">DB Type</th>
                                <th class="center">Host Name</th>
                                <th class="center">DB Name</th>
                                <th class="center">User Name</th>
                                <th class="center">Password</th>
                                <th class="center"></th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php if ($getAllAdminDB) { ?>
                                <?php foreach ($getAllAdminDB as $key => $eachDB) {   ?>
                                    <tr >
                                        <td class="center"><?= $eachDB['Name']; ?></td>
                                        <td class="center"><?= $eachDB['DBType']; ?></td>
                                       
                                        <td class="center"><?= $eachDB['HostName']; ?></td>
                                        <td class="center"><?= $eachDB['DBName']; ?></td>
                                        <td class="center"><?= $eachDB['Username']; ?></td>
                                        <td class="center"><?= $eachDB['DBPassword']; ?></td>
                                       
                                        <td class="center">
                                             
                                            <a href="<?php echo baseUrl; ?>addAdminDB?ID=<?= $eachDB['ID']; ?>"
                                               href="" class="btn btn-tbl-edit btn-xs">
                                                <i class="fa fa-pencil"></i>
                                            </a>
                                            <a href="<?php echo baseUrl; ?>deleteAdminDB?ID=<?= $eachDB['ID']; ?>"
                                               class="btn btn-tbl-delete btn-xs">
                                                <i class="fa fa-trash-o "></i>
                                            </a>

                                        </td>

                                    </tr>

                                <?php } ?>
                            <?php } ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- end page content -->
    <?php include_once realpath(__DIR__ . '/../..') . '/layout/Admin_Layout/footer_start.php'; ?>
