<?php include_once realpath(__DIR__ . '/../..') . '/layout/Admin_Layout/header_start.php'; ?>

<?php include_once realpath(__DIR__ . '/../..') . '/layout/Admin_Layout/header_menu.php'; ?>
    <div class="page-container">
<?php include_once realpath(__DIR__ . '/../..') . '/layout/Admin_Layout/side_bar.php'; ?>
    <div class="page-content-wrapper">

        <div class="page-content">
            <div class="page-bar">

                <div class="page-title-breadcrumb">
                    <h3>Configure user's pages</h3>
                    <ol class="breadcrumb page-breadcrumb pull-left">
                        <li><i class="parent-item"></i>
                            <a class="parent-item"
                               href="<?php echo baseUrl; ?>addnewpageaccess?id=<?php echo $_REQUEST['id']; ?>">
                                + Add new page
                            </a>
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
                            <header><?= $userName;?></header>
                        </div>
                        <table class="table table-hover table-checkable order-column full-width" id="example4">
                            <thead>
                            <tr>
                                <th class="center">Menu Label</th>
                                <th class="center">Page</th>
                                <th class="center"></th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php echo "<pre>";
                            foreach ($getUserPages as $pageKey => $pageDetails){ ?>
                            <tr onclick="window.location='<?php echo baseUrl; ?>pagepanels?pageId=<?= $pageDetails['userPageId'] . '&userAccessId=' . $_REQUEST['id']; ?>'">
                                <td class="center"><?php echo $pageDetails['PageMenuText']; ?></td>
                                <td class="center"><?php echo $pageDetails['PageText']; ?></td>
                                <td class="center">
                                    <a href="<?php echo baseUrl; ?>edituserpageaccess?PageId=<?= $pageDetails['userPageId'] . '&id=' . $_REQUEST['id']; ?>"
                                       class="btn btn-tbl-edit btn-xs">
                                        <i class="fa fa-pencil"></i>
                                    </a>
                                    <a class="btn btn-tbl-delete btn-xs"
                                       href="<?php echo baseUrl; ?>deleteuserpageaccess?id=<?= $_REQUEST['id'] . '&pageId=' . $pageDetails['userPageId']; ?>">
                                        <i class="fa fa-trash-o"></i>
                                    </a>
                                    <a href="<?php echo baseUrl; ?>pagepanels?pageId=<?= $pageDetails['userPageId'] . '&userAccessId=' . $_REQUEST['id']; ?>"
                                       class="btn btn-tbl-edit btn-xs">
                                        <i class="fa fa-ellipsis-h"></i>
                                    </a>
                                </td>
                                <?php } ?>
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
