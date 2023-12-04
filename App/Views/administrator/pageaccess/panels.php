<?php include_once realpath(__DIR__ . '/../..') . '/layout/Admin_Layout/header_start.php'; ?>

<?php include_once realpath(__DIR__ . '/../..') . '/layout/Admin_Layout/header_menu.php'; ?>
    <div class="page-container">
<?php include_once realpath(__DIR__ . '/../..') . '/layout/Admin_Layout/side_bar.php'; ?>
        <div class="page-content-wrapper">

            <div class="page-content">
                <div class="page-bar">
                    <div class="page-title-breadcrumb">


                        <h3>User Page Configuration</h3>

                        <ol class="breadcrumb page-breadcrumb pull-left" style="margin: 5px 10px">
                            <li><i class="parent-item"></i>
                                <a class="parent-item" href="<?php echo baseUrl; ?>addplaceholderbytype?type=1&pageId=<?php echo $_REQUEST['pageId'].'&userAccessId='.$_REQUEST['userAccessId']; ?>">Add panel placeholder</a>
                            </li>
                            &nbsp;
                        </ol>

                        <ol class="breadcrumb page-breadcrumb pull-left" style="margin: 5px 10px">
                            <li><i class="parent-item"></i>
                                <a class="parent-item" href="<?php echo baseUrl; ?>addplaceholderbytype?type=2&pageId=<?php echo $_REQUEST['pageId'].'&userAccessId='.$_REQUEST['userAccessId']; ?>">Add table placeholder</a>
                            </li>
                            &nbsp;
                        </ol>

                        <ol class="breadcrumb page-breadcrumb pull-left" style="margin: 5px 10px">
                            <li><i class="parent-item"></i>
                                <a class="parent-item" href="<?php echo baseUrl; ?>addplaceholderbytype?type=3&pageId=<?php echo $_REQUEST['pageId'].'&userAccessId='.$_REQUEST['userAccessId']; ?>">Add graph placeholder</a>
                            </li>
                            &nbsp;
                        </ol>

                        <ol class="breadcrumb page-breadcrumb pull-left" style="margin: 5px 10px">
                            <li><i class="parent-item"></i>
                                <a class="parent-item" href="<?php echo baseUrl; ?>addplaceholderbytype?type=4&pageId=<?php echo $_REQUEST['pageId'].'&userAccessId='.$_REQUEST['userAccessId']; ?>">Add Maps placeholder</a>
                            </li>
                            &nbsp;
                        </ol>
                        <ol class="breadcrumb page-breadcrumb pull-left" style="margin: 5px 10px">
                            <li><i class="parent-item"></i>
                                <a class="parent-item" href="<?php echo baseUrl; ?>addplaceholderbytype?type=5&pageId=<?php echo $_REQUEST['pageId'].'&userAccessId='.$_REQUEST['userAccessId']; ?>">Add Pie Charts placeholder</a>
                            </li>
                            &nbsp;
                        </ol>
                        <ol class="breadcrumb page-breadcrumb pull-left" style="margin: 5px 10px">
                            <li><i class="parent-item"></i>
                                <a class="parent-item" href="<?php echo baseUrl; ?>addplaceholderbytype?type=6&pageId=<?php echo $_REQUEST['pageId'].'&userAccessId='.$_REQUEST['userAccessId']; ?>">Add 2 Tabe Filter</a>
                            </li>
                            &nbsp;
                        </ol>
                        <ol class="breadcrumb page-breadcrumb pull-left" style="margin: 5px 10px">
                            <li><i class="parent-item"></i>
                                <a class="parent-item" href="<?php echo baseUrl; ?>addplaceholderbytype?type=7&pageId=<?php echo $_REQUEST['pageId'].'&userAccessId='.$_REQUEST['userAccessId']; ?>">Add send orders</a>
                            </li>
                            &nbsp;
                        </ol>
                        <ol class="breadcrumb page-breadcrumb pull-left" style="margin: 5px 10px">
                            <li><i class="parent-item"></i>
                                <a class="parent-item" href="<?php echo baseUrl; ?>addplaceholderbytype?type=8&pageId=<?php echo $_REQUEST['pageId'].'&userAccessId='.$_REQUEST['userAccessId']; ?>">Add read uploaded Data</a>
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
                                <header>Placeholders for <?= $getUserPageAccessDetails['PageMenuText'];?> <?= $userName;?></header>
                            </div>

                            <div class="row p-b-20">
                                <div class="col-md-6 col-sm-6 col-6">
                                    <div class="btn-group">

                                    </div>
                                </div>
                            </div>
                            <table class="table table-hover table-checkable order-column full-width" id="example4">
                                <thead>
                                <tr>
                                    <th class="center">Selected Panel</th>
                                    <th class="center">Selected placeholder</th>
                                    <th class="center"></th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php if ($getUserAccessPagePanels) {
                                    foreach ($getUserAccessPagePanels as $panelDetails) { ?>
                                        <tr onclick="window.location='<?php echo baseUrl . 'edituserpageplaceholder?type=1&pageId='.$_REQUEST['pageId'].'&userAccessId='.$_REQUEST['userAccessId'].'&id='.$panelDetails['ID'];?>'">
                                            <td class="center"><?php echo $panelDetails['Name'];?></td>
                                            <td class="center"><?php echo $panelDetails['PlaceholderValue'];?></td>
                                            <td class="center">

                                                <a href="<?php echo baseUrl . 'edituserpageplaceholder?type=1&pageId='.$_REQUEST['pageId'].'&userAccessId='.$_REQUEST['userAccessId'].'&id='.$panelDetails['ID'];?>"
                                                   class="btn btn-tbl-edit btn-xs">
                                                    <i class="fa fa-pencil"></i>
                                                </a>

                                                <a class="btn btn-tbl-delete btn-xs" href="<?php echo baseUrl. 'deleteuserpageplaceholder?pageId='.$_REQUEST['pageId'].'&userAccessId='.$_REQUEST['userAccessId'].'&id='.$panelDetails['ID'];?>">
                                                    <i class="fa fa-trash-o "></i>
                                                </a>
                                                <a href="<?php echo baseUrl . 'editplaceholder?id='.$panelDetails['PlaceholderId'].'&type=1';?>"
                                                   class="btn btn-tbl-edit btn-xs">
                                                   P
                                                </a>
                                                <a href="<?php echo baseUrl .'edit_data_source?id='.$panelDetails['DataSourceId']?>"
                                                   class="btn btn-tbl-edit btn-xs">
                                                   D
                                                </a>
                                            </td>
                                        </tr>
                                    <?php }
                                } ?>

                                <?php if ($getUserAccessPageTables) {
                                    foreach ($getUserAccessPageTables as $tableDetails) {  ?>
                                        <tr onclick="window.location='<?php echo baseUrl . 'edituserpageplaceholder?type=2&pageId='.$_REQUEST['pageId'].'&userAccessId='.$_REQUEST['userAccessId'].'&id='.$tableDetails['ID'];?>'">
                                            <td class="center"><?php echo $tableDetails['Name'];?></td>
                                            <td class="center"><?php echo $tableDetails['PlaceholderValue'];?></td>
                                            <td class="center">
                                                <a href="<?php echo baseUrl . 'edituserpageplaceholder?type=2&pageId='.$_REQUEST['pageId'].'&userAccessId='.$_REQUEST['userAccessId'].'&id='.$tableDetails['ID'];?>"
                                                   class="btn btn-tbl-edit btn-xs">
                                                    <i class="fa fa-pencil"></i>
                                                </a>
                                                <a class="btn btn-tbl-delete btn-xs" href="<?php echo baseUrl. 'deleteuserpageplaceholder?pageId='.$_REQUEST['pageId'].'&userAccessId='.$_REQUEST['userAccessId'].'&id='.$tableDetails['ID'];?>">
                                                    <i class="fa fa-trash-o "></i>
                                                </a>
                                                <a href="<?php echo baseUrl . 'editplaceholder?id='.$tableDetails['PlaceholderId'].'&type=2';?>"
                                                   class="btn btn-tbl-edit btn-xs">
                                                   P
                                                </a>
                                                <a href="<?php echo baseUrl .'edit_data_source?id='.$tableDetails['DataSourceId']?>"
                                                   class="btn btn-tbl-edit btn-xs">
                                                   D
                                                </a>
                                            </td>
                                        </tr>
                                    <?php }
                                } ?>

                                <?php if ($getUserAccessPageGraphs) {
                                    foreach ($getUserAccessPageGraphs as $graphDetails) { ?>
                                        <tr onclick="window.location='<?php echo baseUrl . 'edituserpageplaceholder?type=3&pageId='.$_REQUEST['pageId'].'&userAccessId='.$_REQUEST['userAccessId'].'&id='.$graphDetails['ID'];?>'">
                                            <td class="center"><?php echo $graphDetails['Name'];?></td>
                                            <td class="center"><?php echo $graphDetails['PlaceholderValue'];?></td>
                                            <td class="center">
                                                <a href="<?php echo baseUrl . 'edituserpageplaceholder?type=3&pageId='.$_REQUEST['pageId'].'&userAccessId='.$_REQUEST['userAccessId'].'&id='.$graphDetails['ID'];?>"
                                                   class="btn btn-tbl-edit btn-xs">
                                                    <i class="fa fa-pencil"></i>
                                                </a>
                                                <a class="btn btn-tbl-delete btn-xs" href="<?php echo baseUrl. 'deleteuserpageplaceholder?pageId='.$_REQUEST['pageId'].'&userAccessId='.$_REQUEST['userAccessId'].'&id='.$graphDetails['ID'];?>">
                                                    <i class="fa fa-trash-o "></i>
                                                </a>
                                                <a href="<?php echo baseUrl . 'editplaceholder?id='.$graphDetails['PlaceholderId'].'&type=3';?>"
                                                   class="btn btn-tbl-edit btn-xs">
                                                   P
                                                </a>
                                                <a href="<?php echo baseUrl .'edit_data_source?id='.$graphDetails['DataSourceId']?>"
                                                   class="btn btn-tbl-edit btn-xs">
                                                   D
                                                </a>
                                            </td>
                                        </tr>
                                    <?php }
                                } ?>

                                <?php if ($getUserAccessPageMaps) {
                                    foreach ($getUserAccessPageMaps as $mapsDetails) { ?>
                                        <tr onclick="window.location='<?php echo baseUrl . 'edituserpageplaceholder?type=4&pageId='.$_REQUEST['pageId'].'&userAccessId='.$_REQUEST['userAccessId'].'&id='.$mapsDetails['ID'];?>'">
                                            <td class="center"><?php echo $mapsDetails['Name'];?></td>
                                            <td class="center"><?php echo $mapsDetails['PlaceholderValue'];?></td>
                                            <td class="center">
                                                <a href="<?php echo baseUrl . 'edituserpageplaceholder?type=4&pageId='.$_REQUEST['pageId'].'&userAccessId='.$_REQUEST['userAccessId'].'&id='.$mapsDetails['ID'];?>"
                                                   class="btn btn-tbl-edit btn-xs">
                                                    <i class="fa fa-pencil"></i>
                                                </a>
                                                <a class="btn btn-tbl-delete btn-xs" href="<?php echo baseUrl. 'deleteuserpageplaceholder?pageId='.$_REQUEST['pageId'].'&userAccessId='.$_REQUEST['userAccessId'].'&id='.$mapsDetails['ID'];?>">
                                                    <i class="fa fa-trash-o "></i>
                                                </a>
                                                <a href="<?php echo baseUrl . 'editplaceholder?id='.$mapsDetails['PlaceholderId'].'&type=4';?>"
                                                   class="btn btn-tbl-edit btn-xs">
                                                   P
                                                </a>
                                                <a href="<?php echo baseUrl .'edit_data_source?id='.$mapsDetails['DataSourceId']?>"
                                                   class="btn btn-tbl-edit btn-xs">
                                                   D
                                                </a>
                                            </td>
                                        </tr>
                                    <?php }
                                } ?>
                                <?php if ($getUserAccessPagePieChart) {
                                    foreach ($getUserAccessPagePieChart as $pieChartDetails) { ?>
                                        <tr onclick="window.location='<?php echo baseUrl . 'edituserpageplaceholder?type=5&pageId='.$_REQUEST['pageId'].'&userAccessId='.$_REQUEST['userAccessId'].'&id='.$pieChartDetails['ID'];?>'">
                                            <td class="center"><?php echo $pieChartDetails['Name'];?></td>
                                            <td class="center"><?php echo $pieChartDetails['PlaceholderValue'];?></td>
                                            <td class="center">
                                                <a href="<?php echo baseUrl . 'edituserpageplaceholder?type=5&pageId='.$_REQUEST['pageId'].'&userAccessId='.$_REQUEST['userAccessId'].'&id='.$pieChartDetails['ID'];?>"
                                                   class="btn btn-tbl-edit btn-xs">
                                                    <i class="fa fa-pencil"></i>
                                                </a>
                                                <a class="btn btn-tbl-delete btn-xs" href="<?php echo baseUrl. 'deleteuserpageplaceholder?pageId='.$_REQUEST['pageId'].'&userAccessId='.$_REQUEST['userAccessId'].'&id='.$pieChartDetails['ID'];?>">
                                                    <i class="fa fa-trash-o "></i>
                                                </a>
                                                <a href="<?php echo baseUrl . 'editplaceholder?id='.$pieChartDetails['PlaceholderId'].'&type=5';?>"
                                                   class="btn btn-tbl-edit btn-xs">
                                                   P
                                                </a>
                                                <a href="<?php echo baseUrl .'edit_data_source?id='.$pieChartDetails['DataSourceId']?>"
                                                   class="btn btn-tbl-edit btn-xs">
                                                   D
                                                </a>
                                            </td>
                                        </tr>
                                    <?php }
                                } ?>
                                <?php if ($getUserAccessPageSendOrder) {
                                    foreach ($getUserAccessPageSendOrder as $sendOrderDetails) { ?>
                                        <tr onclick="window.location='<?php echo baseUrl . 'edituserpageplaceholder?type=7&pageId='.$_REQUEST['pageId'].'&userAccessId='.$_REQUEST['userAccessId'].'&id='.$sendOrderDetails['ID'];?>'">
                                            <td class="center"><?php echo $sendOrderDetails['Name'];?></td>
                                            <td class="center"><?php echo $sendOrderDetails['PlaceholderValue'];?></td>
                                            <td class="center">
                                                <a href="<?php echo baseUrl . 'edituserpageplaceholder?type=7&pageId='.$_REQUEST['pageId'].'&userAccessId='.$_REQUEST['userAccessId'].'&id='.$sendOrderDetails['ID'];?>"
                                                   class="btn btn-tbl-edit btn-xs">
                                                    <i class="fa fa-pencil"></i>
                                                </a>
                                                <a class="btn btn-tbl-delete btn-xs" href="<?php echo baseUrl. 'deleteuserpageplaceholder?pageId='.$_REQUEST['pageId'].'&userAccessId='.$_REQUEST['userAccessId'].'&id='.$sendOrderDetails['ID'];?>">
                                                    <i class="fa fa-trash-o "></i>
                                                </a>
                                                <a href="<?php echo baseUrl . 'editplaceholder?id='.$mapsDetails['PlaceholderId'].'&type=4';?>"
                                                   class="btn btn-tbl-edit btn-xs">
                                                   P
                                                </a>
                                                <a href="<?php echo baseUrl .'edit_data_source?id='.$mapsDetails['DataSourceId']?>"
                                                   class="btn btn-tbl-edit btn-xs">
                                                   D
                                                </a>
                                            </td>
                                        </tr>
                                    <?php }
                                } ?>
                                <?php if ($getUserAccessPageReadData) {
                                    foreach ($getUserAccessPageReadData as $ReadData) { ?>
                                        <tr onclick="window.location='<?php echo baseUrl . 'edituserpageplaceholder?type=8&pageId='.$_REQUEST['pageId'].'&userAccessId='.$_REQUEST['userAccessId'].'&id='.$ReadData['ID'];?>'">
                                            <td class="center"><?php echo $ReadData['Name'];?></td>
                                            <td class="center"><?php echo $ReadData['PlaceholderValue'];?></td>
                                            <td class="center">
                                                <a href="<?php echo baseUrl . 'edituserpageplaceholder?type=8&pageId='.$_REQUEST['pageId'].'&userAccessId='.$_REQUEST['userAccessId'].'&id='.$ReadData['ID'];?>"
                                                   class="btn btn-tbl-edit btn-xs">
                                                    <i class="fa fa-pencil"></i>
                                                </a>
                                                <a class="btn btn-tbl-delete btn-xs" href="<?php echo baseUrl. 'deleteuserpageplaceholder?pageId='.$_REQUEST['pageId'].'&userAccessId='.$_REQUEST['userAccessId'].'&id='.$ReadData['ID'];?>">
                                                    <i class="fa fa-trash-o "></i>
                                                </a>
                                                <a href="<?php echo baseUrl . 'editplaceholder?id='.$mapsDetails['PlaceholderId'].'&type=4';?>"
                                                   class="btn btn-tbl-edit btn-xs">
                                                   P
                                                </a>
                                                <a href="<?php echo baseUrl .'edit_data_source?id='.$mapsDetails['DataSourceId']?>"
                                                   class="btn btn-tbl-edit btn-xs">
                                                   D
                                                </a>
                                            </td>
                                        </tr>
                                    <?php }
                                } ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- end page content -->

    <!-- end page content -->
<?php include_once realpath(__DIR__ . '/../..') . '/layout/Admin_Layout/footer_start.php'; ?>