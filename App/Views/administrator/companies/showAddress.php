<?php include_once realpath(__DIR__ . '/../..') . '/layout/Admin_Layout/header_start.php'; ?>

<?php include_once realpath(__DIR__ . '/../..') . '/layout/Admin_Layout/header_menu.php'; ?>
    <div class="page-container">
<?php include_once realpath(__DIR__ . '/../..') . '/layout/Admin_Layout/side_bar.php'; ?>
    <div class="page-content-wrapper">
        <div class="page-content">
            <div class="page-bar page-bar-admin">
                <div class="page-title-breadcrumb">
                    <ol class="breadcrumb page-breadcrumb breadcrumb-admin pull-left" style="margin: 5px 10px">
                        <li>
                            <i class="parent-item"></i>
                            <a class="parent-item" href="<?php echo baseUrl; ?>addAddress"><i class="fa fa-plus"></i> Add Address</a>
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
                            <header> All Address</header>
                        </div>

                        <table class="table table-hover table-checkable order-column full-width" id="example4">
                            <thead>
                            <tr>
                                
                                <th class="center">Address name</th>
                                <th class="center">URL</th>
                                <th class="center"></th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php if ($getAllAddress) { ?>
                                <?php foreach ($getAllAddress as $key => $eachAddress) {   ?>
                                    <tr >
                                       <td class="center"><?= $eachAddress['AddressName']; ?></td>
                                       
                                        <td class="center"><?= $eachAddress['Address']; ?></td>
                                       
                                        <td class="center">
                                             
                                            <a href="<?php echo baseUrl; ?>addAddress?ID=<?= $eachAddress['ID']; ?>"
                                               href="" class="btn btn-tbl-edit btn-xs">
                                                <i class="fa fa-pencil"></i>
                                            </a>
                                            <a href="<?php echo baseUrl; ?>deleteAddress?ID=<?= $eachAddress['ID']; ?>"
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
