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
                                    <a class="parent-item" href="<?php echo baseUrl;?>addpagetemplate"><i class="fa fa-plus"></i> Add new page template</a>
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
                                    <header>Page templates</header>
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
                                        <th class="center">Page Text</th>
                                        <th class="center">Page Filename</th>
                                        <th class="center">Page Description</th>
                                        <th class="center"></th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php foreach($getAllPages as $pageKey => $pageDetails){?>
                                    <tr onclick="window.location='<?php echo baseUrl;?>addpagetemplate?id=<?=$pageDetails['ID'];?>'">
                                        <td class="center"><?= $pageDetails['PageText'];?></td>
                                        <td class="center"><?= $pageDetails['PageFilename'];?></td>
                                        <td class="center"><?= $pageDetails['PageDescription'];?></td>
                                        <td class="center">
                                            <a href="<?php echo baseUrl;?>addpagetemplate?id=<?=$pageDetails['ID'];?>" class="btn btn-tbl-edit btn-xs">
                                                <i class="fa fa-pencil"></i>
                                            </a>
                                            <a class="btn btn-tbl-delete btn-xs" href="<?php echo baseUrl;?>deletepage?id=<?=$pageDetails['ID'];?>">
                                                <i class="fa fa-trash-o"></i>
                                            </a>
                                        </td>
                                        <?php }?>
                                    </tr>
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