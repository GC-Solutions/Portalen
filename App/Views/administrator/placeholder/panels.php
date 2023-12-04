<?php include_once realpath(__DIR__ . '/../..') . '/layout/Admin_Layout/header_start.php'; ?>

<?php include_once realpath(__DIR__ . '/../..') . '/layout/Admin_Layout/header_menu.php'; ?>
    <div class="page-container">
<?php include_once realpath(__DIR__ . '/../..') . '/layout/Admin_Layout/side_bar.php'; ?>
        <div class="page-content-wrapper">

            <div class="page-content">
                <div class="page-bar">
                    <div class="page-title-breadcrumb">


                        <h3>Kunder</h3>

                        <ol class="breadcrumb page-breadcrumb pull-left">
                            <li><i class="parent-item"></i>
                                <a class="parent-item" href="<?php echo baseUrl; ?>addplaceholderaccess?pageId=<?php echo $_REQUEST['pageId'].'&userAccessId='.$_REQUEST['userAccessId']; ?>">Add Placeholders Access</a>
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
                                <header>Add placeholder access for page (____)</header>
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
                                    <th class="center">Detaljer</th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php if ($getPlaceHolderAndPanels) {
                                    foreach ($getPlaceHolderAndPanels as $panelDetails) { ?>
                                        <tr>
                                            <td class="center"><?php echo $panelDetails['PanelText'];?></td>
                                            <td class="center"><?php echo $panelDetails[4];?></td>
                                            <td class="center">

                                                <a class="btn btn-tbl-delete btn-xs" href="<?php echo baseUrl. 'deleteplaceholder?pageId='.$_REQUEST['pageId'].'&userAccessId='.$_REQUEST['userAccessId'].'&id='.$panelDetails['ID'];?>">
                                                    <i class="fa fa-trash-o "></i>
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