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
                            <a class="parent-item" href="<?php echo baseUrl; ?>add_data_source"><i class="fa fa-plus"></i> Add source
                                template API</a>
                        </li>
                        &nbsp;
                    </ol>
                    <ol class="breadcrumb breadcrumb-admin page-breadcrumb pull-left" style="margin: 5px 10px">
                        <li>
                            <i class="parent-item"></i>
                            <a class="parent-item" href="<?php echo baseUrl; ?>add_data_source_database"><i class="fa fa-plus"></i> Add
                                Source Template Database</a>
                        </li>
                        &nbsp;
                    </ol>
                    <ol class="breadcrumb breadcrumb-admin page-breadcrumb pull-left" style="margin: 5px 10px">
                        <li>
                            <i class="parent-item"></i>
                            <a class="parent-item" href="<?php echo baseUrl; ?>add_data_source_get_post"><i class="fa fa-plus"></i> Add source
                                template API GET & POST</a>
                        </li>
                        &nbsp;
                    </ol>
                    <ol class="breadcrumb breadcrumb-admin page-breadcrumb pull-left" style="margin: 5px 10px">
                        <li>
                            <i class="parent-item"></i>
                            <a class="parent-item" href="<?php echo baseUrl; ?>add_data_source_post_api"><i class="fa fa-plus"></i> Add Post API Only</a>
                        </li>
                        &nbsp;
                    </ol>
                    <ol class="breadcrumb breadcrumb-admin page-breadcrumb pull-left" style="margin: 5px 10px">
                        <li>
                            <i class="parent-item"></i>
                            <a class="parent-item" href="<?php echo baseUrl; ?>add_google_api"><i class="fa fa-plus"></i> Add Google API</a>
                        </li>
                        &nbsp;
                    </ol>
                    <ol class="breadcrumb breadcrumb-admin page-breadcrumb pull-left" style="margin: 5px 10px">
                        <li>
                            <i class="parent-item"></i>
                            <a class="parent-item" href="<?php echo baseUrl; ?>add_data_source_custom_db"><i class="fa fa-plus"></i> Add table to be created in DB </a>
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
                            <header>Source table used in placeholders</header>
                        </div>

                        <div class="row p-b-20">
                            <div class="col-md-6 col-sm-6 col-6">
                                <div class="btn-group">

                                </div>
                            </div>
                            <div class="col-md-6 col-sm-6 col-6">

                            </div>
                        </div>
                        <table class="table table-hover table-checkable order-column full-width" id="example4">
                            <thead>
                            <tr>
                                <th class="center">Name</th>
                                <th class="center">Source</th>
                                <th class="center">Description</th>
                                <th class="center"></th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php if ($getDataSource) { ?>
                                <?php foreach ($getDataSource as $key => $eachDataSource) {
                                    $requestType = $eachDataSource['RequestType'];
                                    $source = "Api Call";

                                    if ($requestType == 3) {
                                        $source = "Database Call";
                                    } else if ($eachDataSource['updateDataSource'] == 1) {
                                        $source = "API Get & Post Call";
                                    }
                                    ?>
                                    <tr onclick="window.location='<?php echo baseUrl; ?>edit_data_source?id=<?= $eachDataSource['ID']; ?>'">
                                        <td class="center"><?= $eachDataSource['Name']; ?></td>
                                        <td class="center"><?= $source; ?></td>
                                        <td class="center"><?= $eachDataSource['Descriptions']; ?></td>
                                        <td class="center">
                                            <a href="<?php echo baseUrl; ?>copy_data_source?id=<?= $eachDataSource['ID']; ?>"
                                               href="" class="btn btn-tbl-edit btn-xs">
                                                <i class="fa fa-copy"></i>
                                            </a>
                                            <a href="<?php echo baseUrl; ?>edit_data_source?id=<?= $eachDataSource['ID']; ?>"
                                               href="" class="btn btn-tbl-edit btn-xs">
                                                <i class="fa fa-pencil"></i>
                                            </a>
                                            <a href="<?php echo baseUrl; ?>delete_data_source?id=<?= $eachDataSource['ID']; ?>"
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
