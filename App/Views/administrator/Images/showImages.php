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
                            <a class="parent-item" href="<?php echo baseUrl; ?>addImages"><i class="fa fa-plus"></i> Add Images </a>
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
                            <header> All Company User Images</header>
                        </div>

                        <table class="table table-hover table-checkable order-column full-width" id="example4">
                            <thead>
                            <tr>
                                
                                <th class="center">Name</th>
                                <th class="center">Company</th>
                                <th class="center">User</th>
                                <th class="center">Image Name</th>
                                
                                <th class="center"></th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php if ($getAllImages) { ?>
                                <?php foreach ($getAllImages as $key => $eachImage) {   ?>
                                    <tr >
                                        <td class="center"><?= $eachImage['Name']; ?></td>
                                        <td class="center"><?= $eachImage['CompanyName']; ?></td>
                                       
                                        <td class="center"><?= $eachImage['UserName']; ?></td>
                                        <td class="center"><?= $eachImage['ImageName']; ?></td>
                                       
                                       
                                        <td class="center">
                                             
                                            <a href="<?php echo baseUrl; ?>addImages?ID=<?= $eachImage['ID']; ?>"
                                               href="" class="btn btn-tbl-edit btn-xs">
                                                <i class="fa fa-pencil"></i>
                                            </a>
                                            <a href="<?php echo baseUrl; ?>deleteImages?ID=<?= $eachImage['ID']; ?>"
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
