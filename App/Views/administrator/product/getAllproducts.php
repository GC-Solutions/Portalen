<?php include_once realpath(__DIR__ . '/../..') . '/layout/Admin_Layout/header_start.php'; ?>

<?php include_once realpath(__DIR__ . '/../..') . '/layout/Admin_Layout/header_menu.php'; ?>
    <div class="page-container">
<?php include_once realpath(__DIR__ . '/../..') . '/layout/Admin_Layout/side_bar.php'; ?>
            <div class="page-content-wrapper">

                <div class="page-content">
                  

                    <div class="row">
                        <div class="col-sm-12">
                            <div class="card-box">
                                <div class="card-head">
                                    <header>All Products</header>
                                </div>

                                <div class="row p-b-20">
                                    <div class="col-md-6 col-sm-6 col-6">
                                        <div class="btn-group">

                                        </div>
                                    </div>
                                    <div class="col-md-6 col-sm-6 col-6">
                                        <div class="btn-group pull-right">

                                        </div>
                                    </div>
                                </div>
                                <table class="table table-hover table-checkable order-column full-width" id="example4">
                                    <thead>
                                    <tr>
                                        <th class="center">productNO</th>
                                        <th class="center">Name</th>
                                        <th class="center">Description</th>
                                       
                                        <th class="center"></th>
                                    </tr>
                                    </thead>
                                    <!-- <tbody>
                                        <?php foreach($getAllCompanies as $companyKey => $companyDetail){?>
                                                <tr onclick="window.location='<?php echo baseUrl;?>editcompany?id=<?=$companyDetail['CompanyID'];?>'">
                                                    <td class="center"><?= $companyDetail['CompanyID'];?></td>
                                                    <td class="center"><?= $companyDetail['CompanyName'];?></td>
                                                    <td class="center"><?= $companyDetail['CompanyEmail'];?></td>
                                                   
                                                    <td class="center">
                                                        <a href="<?php echo baseUrl;?>add?productNO=<?=$companyDetail['CompanyID'];?>" class="btn btn-tbl-edit btn-xs">
                                                            <i class="fa fa-pencil"></i>
                                                        </a>
                                                       
                                                    </td>
                                                </tr>

                                        <?php }?>
                                    </tbody> -->
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- end page content -->
<?php include_once realpath(__DIR__ . '/../..') . '/layout/Admin_Layout/footer_start.php'; ?>