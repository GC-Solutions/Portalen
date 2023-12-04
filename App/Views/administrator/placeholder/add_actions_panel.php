<?php include_once realpath(__DIR__ . '/../..') . '/layout/Admin_Layout/header_start.php'; ?>

<?php include_once realpath(__DIR__ . '/../..') . '/layout/Admin_Layout/header_menu.php'; ?>
    <div class="page-container">
<?php include_once realpath(__DIR__ . '/../..') . '/layout/Admin_Layout/side_bar.php'; ?>
    <div class="page-content-wrapper">
    <div class="page-content">
    <div class="row">
        <div class="col-md-12 col-sm-12">
            <div class="card card-box">
                <div class="card-head">
                    <header>Add panel action template</header>
                </div>
                <div class="card-body" id="bar-parent1">
                    <form action="<?php echo baseUrl; ?>save_panel_action" method="post" class="form-horizontal">
                        <div class="form-body">

                            <input type="hidden" name="id"
                                   value="<?= $id = (isset($getPanelActionDetails['ID'])) ? $getPanelActionDetails['ID'] : ""; ?>"/>

                            <div class="form-group row">
                                <label class="control-label col-md-3">
                                    Name
                                    <span class="required"> * </span>
                                </label>

                                <div class="col-md-4">
                                    <input type="text" name="Name" required="" data-required="1"
                                           value="<?= $Name = (isset($getPanelActionDetails['Name'])) ? $getPanelActionDetails['Name'] : ""; ?>"
                                           class="form-control"/>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="control-label col-md-3">
                                    Description
                                    <span class="required"> * </span>
                                </label>

                                <div class="col-md-4">
                                    <input type="text" name="Descriptions" required="" data-required="1"
                                           value="<?= $descriptions = (isset($getPanelActionDetails['Descriptions'])) ? $getPanelActionDetails['Descriptions'] : ""; ?>"
                                           class="form-control"/>
                                </div>
                            </div>


                            <div class="form-group row">
                                <label class="control-label col-md-3">
                                    Data source
                                    <span class="required"> * </span>
                                </label>

                                <div class="col-md-4">
                                    <select name="DataSourceId" class="form-control DataSourceIdPanelAction select2-multiple" data-maximum-selection-length="1" multiple 
                                            required="">
                                        <option value=""> Select</option>
                                        <?php
                                        if ($getDataSource) {
                                            $getDataSourceId = (isset($getPanelActionDetails['DataSourceId'])) ? $getPanelActionDetails['DataSourceId'] : "";
                                            ?>
                                            <?php foreach ($getDataSource as $key => $eachDataSource) {
                                                $selected = '';
                                                if ($getDataSourceId == $eachDataSource['ID']) {
                                                    $selected = 'selected="selected"';
                                                }
                                                ?>
                                                <option <?= $selected; ?>
                                                    value="<?= $eachDataSource['ID']; ?>"><?= $eachDataSource['Name']; ?></option>
                                            <?php } ?>
                                        <?php } ?>
                                    </select>
                                </div>
                            </div>


                            <div class="form-group row">
                                <label class="control-label col-md-3">
                                    Page target
                                    <span class="required"> * </span>
                                </label>

                                <div class="col-md-4">
                                    <?php
                                    $externalUrl = (isset($getPanelActionDetails['ExternalUrl'])) ? $getPanelActionDetails['ExternalUrl'] : "";
                                    $externalSelected = '';
                                    if(!empty($externalUrl)){
                                        $externalSelected = 'selected="selected"';
                                    }
                                    ?>
                                    <select name="PageTargetId" class="form-control PageTargetId" required="">
                                        <option value=""> Select</option>
                                        <option value="0" <?= $externalSelected; ?>>External URL</option>
                                        <?php
                                        if ($getAllPages) {
                                            $getPageTargetId = (isset($getPanelActionDetails['PageTargetId'])) ? $getPanelActionDetails['PageTargetId'] : "";
                                            ?>
                                            <?php foreach ($getAllPages as $key => $eachPage) {
                                                $selected = '';
                                                if ($getPageTargetId == $eachPage['PageTableID']) {
                                                    $selected = 'selected="selected"';
                                                }
                                                ?>
                                                <option <?= $selected; ?>
                                                    value="<?= $eachPage['PageTableID']; ?>"><?= $eachPage['PageText']; ?></option>
                                            <?php } ?>
                                        <?php } ?>
                                    </select>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="control-label col-md-3">
                                    Select panel template action target
                                    <span class="required"> * </span>
                                </label>

                                <div class="col-md-4">
                                    <select name="PanelTemplateId" class="form-control PanelTemplateId select2-multiple" data-maximum-selection-length="1" multiple required="">
                                        <option value=""> Select</option>
                                        <?php
                                        if (isset($getDataSourcePanels) && $getDataSourcePanels) {
                                            $selectedPanelColumns = "";
                                            $getPanelTemplateId = (isset($getPanelActionDetails['PanelTemplateId'])) ? $getPanelActionDetails['PanelTemplateId'] : "";
                                            foreach ($getDataSourcePanels as $key => $eachPanel) {
                                                $selected = '';
                                                if ($getPanelTemplateId == $eachPanel['ID']) {
                                                    $selected = 'selected="selected"';
                                                    $selectedPanelColumns = $eachPanel['Columns'];
                                                }
                                                ?>
                                                <option data="<?= $eachPanel['Columns']; ?>" <?= $selected; ?>
                                                        value="<?= $eachPanel['ID']; ?>"><?= $eachPanel['Name']; ?></option>
                                            <?php } ?>
                                        <?php } ?>
                                    </select>
                                </div>
                            </div>


                            <div class="form-group row">
                                <label class="control-label col-md-3">
                                    panel parameter (column)
                                    <span class="required"> * </span>
                                </label>

                                <div class="col-md-4">
                                    <select name="PanelParameterColumn" class="form-control PanelParameterColumn"
                                            required="">
                                        <option value=""> Select</option>
                                        <?php
                                        if (isset($selectedPanelColumns) && $selectedPanelColumns) {
                                            $getPanelParameterColumn = (isset($getPanelActionDetails['PanelParameterColumn'])) ? $getPanelActionDetails['PanelParameterColumn'] : "";
                                            $selectedPanelColumns = explode(",", $selectedPanelColumns);
                                            foreach ($selectedPanelColumns as $columnValue) {
                                                $selected = '';
                                                if ($getPanelParameterColumn == $columnValue) {
                                                    $selected = 'selected="selected"';
                                                }
                                                ?>
                                                <option <?= $selected; ?>
                                                    value="<?= $columnValue; ?>"><?= $columnValue; ?></option>
                                            <?php } ?>
                                        <?php } ?>
                                    </select>
                                </div>
                            </div>


                            <div class="form-group row">
                                <label class="control-label col-md-3">
                                    External URL
                                    <span class="required"> * </span>
                                </label>

                                <div class="col-md-4">
                                    <input type="text" name="ExternalUrl"
                                           value="<?= $externalUrl = (isset($getPanelActionDetails['ExternalUrl'])) ? $getPanelActionDetails['ExternalUrl'] : ""; ?>"
                                           class="form-control"/>
                                </div>
                            </div>


                            <div class="form-group row">
                                <label class="control-label col-md-3">
                                    Action button text
                                    <span class="required"> * </span>
                                </label>

                                <div class="col-md-4">
                                    <input type="text" name="ActionButtonText" required="" data-required="1"
                                           value="<?= $actionButtonText = (isset($getPanelActionDetails['ActionButtonText'])) ? $getPanelActionDetails['ActionButtonText'] : ""; ?>"
                                           class="form-control"/>
                                </div>
                            </div>


                            <div class="form-group row">
                                <label class="control-label col-md-3">
                                    Action button color
                                    <span class="required"> * </span>
                                </label>

                                <div class="col-md-4">
                                    <?php
                                    $actionButtonColor = (isset($getPanelActionDetails['ActionButtonColor'])) ? $getPanelActionDetails['ActionButtonColor'] : "";
                                    ?>
                                    <select name="ActionButtonColor" class="form-control" required="">
                                        <option value=""> Select</option>
                                        <option value="1" <?php if ($actionButtonColor == 1) {
                                            echo "selected='selected'";
                                        } ?>>Red
                                        </option>
                                        <option value="2" <?php if ($actionButtonColor == 2) {
                                            echo "selected='selected'";
                                        } ?>>Blue
                                        </option>
                                        <option value="3" <?php if ($actionButtonColor == 3) {
                                            echo "selected='selected'";
                                        } ?>>Green
                                        </option>
                                        <option value="4" <?php if ($actionButtonColor == 4) {
                                            echo "selected='selected'";
                                        } ?>>Yellow
                                        </option>
                                    </select>
                                </div>
                            </div>

                        </div>
                        <div class="form-group row">
                                    <label class="control-label col-md-3">
                                    </label>
                                    <div class="col-md-4">
                                <div class="btn-group">
                                    <button type="submit" class="btn btn-info">
                                        Save <i class="fa fa-plus"></i>
                                    </button>
                                </div>
                                <div class="btn-group">
                                    <a class="btn deepPink-bgcolor"
                                       href="<?php echo baseUrl; ?>placeholders">Cancel
                                        <i class="fa fa-angle-down"></i>
                                    </a>
                                </div>

                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
<?php include_once realpath(__DIR__ . '/../..') . '/layout/Admin_Layout/footer_start.php'; ?>