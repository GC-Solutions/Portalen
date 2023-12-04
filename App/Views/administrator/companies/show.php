<?php include_once realpath(__DIR__ . '/../..') . '/layout/Admin_Layout/header_start.php'; ?>

<?php include_once realpath(__DIR__ . '/../..') . '/layout/Admin_Layout/header_menu.php'; ?>
    <div class="page-container">
<?php include_once realpath(__DIR__ . '/../..') . '/layout/Admin_Layout/side_bar.php'; ?>
            <div class="page-content-wrapper">

                <div class="page-content">
                    <div class="page-bar page-bar-admin">

                        <div class="page-title-breadcrumb">
                            <ol class="breadcrumb breadcrumb-admin page-breadcrumb pull-left">
                                <li>       
                                    <i class="parent-item"></i>             
                                    <a class="parent-item" href="<?php echo baseUrl;?>addcompany"><i class="fa fa-plus"></i> Create new company</a>
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
                                    <header>All Companies</header>
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
                                        <th class="center">Company ID</th>
                                        <th class="center">Name</th>
                                        <th class="center">Email</th>
                                        <th class="center">GIS Key</th>
                                        <th class="center">GIS Token</th>
                                        <th class="center">BABCDB</th>
                                        <th class="center">BPDB</th>
                                        <th class="center">Start Date</th>
                                        <th class="center">End Date</th>
                                        <th class="center"></th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach($getAllCompanies as $companyKey => $companyDetail){?>
                                                <tr onclick="window.location='<?php echo baseUrl;?>editcompany?id=<?=$companyDetail['CompanyID'];?>'">
                                                    <td class="center"><?= $companyDetail['CompanyID'];?></td>
                                                    <td class="center"><?= $companyDetail['CompanyName'];?></td>
                                                    <td class="center"><?= $companyDetail['CompanyEmail'];?></td>
                                                    <td class="center"><?= $companyDetail['CompanyGISKey'];?></td>
                                                    <td class="center"><?= $companyDetail['CompanyGISToken'];?></td>
                                                    <td class="center"><?= $companyDetail['CompanyBABCDb'];?></td>
                                                    <td class="center"><?= $companyDetail['CompanyBPDb'];?></td>
                                                    <td class="center"><?= $companyDetail['CompanyStartDate'];?></td>
                                                    <td class="center"><?= $companyDetail['CompanyEndDate'];?></td>
                                                    <td class="center">
                                                        <a href="<?php echo baseUrl;?>editcompany?id=<?=$companyDetail['CompanyID'];?>" class="btn btn-tbl-edit btn-xs">
                                                            <i class="fa fa-pencil"></i>
                                                        </a>
                                                        <a onclick="return confirm('Are you sure you want to delete this company?');" class="btn btn-tbl-delete btn-xs" href="<?php echo baseUrl;?>deletecompany?id=<?=$companyDetail['CompanyID'];?>">
                                                            <i class="fa fa-trash-o"></i>
                                                        </a>
                                                    </td>
                                                </tr>

                                        <?php }?>
                                    </tbody>
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