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
                            <a class="parent-item" href="<?php echo baseUrl; ?>addFilterWidth"><i class="fa fa-plus"></i> Add Filter Width</a>
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
                            <header>Filter Width</header>
                        </div>

                        <table class="table table-hover table-checkable order-column full-width" id="example4">
                            <thead>
                            <tr>
                                <th class="center">ID</th>
                                <th class="center"> Min Width</th>
                                <th class="center"> Max Width</th>
                               
                                <th class="center"></th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php if ($getAllFilter) { ?>
                                <?php foreach ($getAllFilter as $key => $eachfilter) {   ?>
                                    <tr >
                                       
                                        <td class="center"><?= $eachfilter['ID']; ?></td>
                                        <td class="center"><?= $eachfilter['FilterWidth']; ?></td>
                                        <td class="center"><?= $eachfilter['MaxFIlterWidth']; ?></td>
                                        
                                        
                                       
                                        <td class="center">
                                             
                                            <a href="<?php echo baseUrl; ?>addFilterWidth?ID=<?= $eachfilter['ID']; ?>"
                                               href="" class="btn btn-tbl-edit btn-xs">
                                                <i class="fa fa-pencil"></i>
                                            </a>
                                            <a href="<?php echo baseUrl; ?>deleteFilterWidth?ID=<?= $eachfilter['ID']; ?>"
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
