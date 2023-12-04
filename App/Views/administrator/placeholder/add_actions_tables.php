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
                    <header>Add table action template</header>
                </div>
                <div class="card-body" id="bar-parent1">
                    <form action="<?php echo baseUrl; ?>save_table_actions" method="post"
                          class="form-horizontal">
                        <div class="form-body">


                            <input type="hidden" name="id"
                                   value="<?= $id = (isset($getTableActionDetails['ID'])) ? $getTableActionDetails['ID'] : ""; ?>"/>

                            <div class="form-group row">
                                <label class="control-label col-md-3">
                                    Table name
                                    <span class="required"> * </span>
                                </label>

                                <div class="col-md-4">
                                    <input type="text" name="Name" required="" data-required="1"
                                           value="<?= $Name = (isset($getTableActionDetails['Name'])) ? $getTableActionDetails['Name'] : ""; ?>"
                                           class="form-control"/>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="control-label col-md-3">
                                    Table description
                                    <span class="required"> * </span>
                                </label>

                                <div class="col-md-4">
                                    <input type="text" name="Descriptions" required="" data-required="1"
                                           value="<?= $descriptions = (isset($getTableActionDetails['Descriptions'])) ? $getTableActionDetails['Descriptions'] : ""; ?>"
                                           class="form-control"/>
                                </div>
                            </div>


                            <div class="form-group row">
                                <label class="control-label col-md-3">
                                    Data source
                                    <span class="required"> * </span>
                                </label>

                                <div class="col-md-4">
                                    <select name="DataSourceId" class="form-control DataSourceIdTableAction select2-multiple" data-maximum-selection-length="1" multiple 
                                    required="">
                                        <option value=""> Select</option>
                                        <?php
                                        if ($getDataSource) {
                                            $getDataSourceId = (isset($getTableActionDetails['DataSourceId'])) ? $getTableActionDetails['DataSourceId'] : "";
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
                                    $externalUrl = (isset($getTableActionDetails['ExternalUrl'])) ? $getTableActionDetails['ExternalUrl'] : "";
                                    $externalSelected = '';
                                    if (!empty($externalUrl)) {
                                        $externalSelected = 'selected="selected"';
                                    }
                                    ?>
                                    <select name="PageTargetId" class="form-control PageTargetId" required="">
                                        <option value=""> Select</option>
                                        <option value="0" <?= $externalSelected; ?>>External URL</option>
                                        <?php
                                        if ($getAllPages) {
                                            $getPageTargetId = (isset($getTableActionDetails['PageTargetId'])) ? $getTableActionDetails['PageTargetId'] : "";
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
                                    Select table template action target
                                    <span class="required"> * </span>
                                </label>

                                <div class="col-md-4">
                                    <select name="TableTemplateId" class="form-control TableTemplateId select2-multiple" data-maximum-selection-length="1" multiple required="">
                                        <option value=""> Select</option>
                                        <?php
                                        if (isset($getDataSourceTables) && $getDataSourceTables) {
                                            $selectedTableColumns = "";
                                            $getTableTemplateId = (isset($getTableActionDetails['TableTemplateId'])) ? $getTableActionDetails['TableTemplateId'] : "";
                                            foreach ($getDataSourceTables as $key => $eachTable) {
                                                $selected = '';
                                                if ($getTableTemplateId == $eachTable['ID']) {
                                                    $selected = 'selected="selected"';
                                                    $selectedTableColumns = $eachTable['Columns'];
                                                }
                                                ?>
                                                <option data="<?= $eachTable['Columns']; ?>" <?= $selected; ?>
                                                        value="<?= $eachTable['ID']; ?>"><?= $eachTable['Name']; ?></option>
                                            <?php } ?>
                                        <?php } ?>
                                    </select>
                                </div>
                            </div>


                            <div class="form-group row">
                                <label class="control-label col-md-3">
                                    Table parameter (column)
                                    <span class="required"> * </span>
                                </label>

                                <div class="col-md-4">
                                    <select name="TableParameterColumn" class="form-control TableParameterColumn"
                                            required="">
                                        <option value=""> Select</option>
                                        <?php
                                        if (isset($selectedTableColumns) && $selectedTableColumns) {
                                            $getTableParameterColumn = (isset($getTableActionDetails['TableParameterColumn'])) ? $getTableActionDetails['TableParameterColumn'] : "";
                                            $selectedTableColumns = explode(",", $selectedTableColumns);
                                            foreach ($selectedTableColumns as $columnValue) {
                                                $selected = '';
                                                $selectedTableColumns = "";
                                                if ($getTableParameterColumn == $columnValue) {
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
                                           value="<?= $externalUrl = (isset($getTableActionDetails['ExternalUrl'])) ? $getTableActionDetails['ExternalUrl'] : ""; ?>"
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
                                           value="<?= $actionButtonText = (isset($getTableActionDetails['ActionButtonText'])) ? $getTableActionDetails['ActionButtonText'] : ""; ?>"
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
                                    $actionButtonColor = (isset($getTableActionDetails['ActionButtonColor'])) ? $getTableActionDetails['ActionButtonColor'] : "";
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


                            <div class="form-group row">
                                <label class="control-label col-md-3">
                                    Enter columns you want to make uneditable
                                    <span class="required"> * </span>
                                </label>

                                <div class="col-md-4">
                                    <textarea type="text" name="UneditableColumns"
                                              class="form-control"><?= $uneditableColumns = (isset($getTableActionDetails['UneditableColumns'])) ? $getTableActionDetails['UneditableColumns'] : ""; ?></textarea>
                                </div>
                            </div>

                            <div class="form-group row" style="display: none;">
                                <label class="control-label col-md-3">
                                    Enter columns you want make visible
                                    <span class="required"> * </span>
                                </label>

                                <div class="col-md-4">
                                    <input type="text" name="SourceType"
                                           class="form-control"/>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="control-label col-md-3">
                                    Predefined Update
                                </label>

                                <div class="col-md-9">

                                    <div class="col-md-12 padding_none">
                                        <div class="checkboxes">
                                            <?php
                                            $showAsMenu = (isset($getTableActionDetails["PredefinedUpdate"])) ? $getTableActionDetails["PredefinedUpdate"] : 0;
                                            $checked = "";
                                            if ($showAsMenu) {
                                                $checked = "checked='checked'";
                                            }
                                            ?>
                                            <label>
                                                <input type="checkbox" <?= $checked; ?> name="PredefinedUpdate"
                                                       value="1"/>
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="control-label col-md-3">
                                    Data Source Call
                                </label>

                                <div class="col-md-9">

                                    <div class="col-md-12 padding_none">
                                        <div class="checkboxes">
                                            <?php
                                            $showAsMenu = (isset($getTableActionDetails["DataSourceCall"])) ? $getTableActionDetails["DataSourceCall"] : 0;
                                            $checked = "";
                                            if ($showAsMenu) {
                                                $checked = "checked='checked'";
                                            }
                                            ?>
                                            <label>
                                                <input type="checkbox" <?= $checked; ?> name="DataSourceCall"
                                                       value="1"/>
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="control-label col-md-3">
                                    Download PDF
                                </label>

                                <div class="col-md-9">

                                    <div class="col-md-12 padding_none">
                                        <div class="checkboxes">
                                            <?php
                                            $showAsMenu = (isset($getTableActionDetails["IsPdf"])) ? $getTableActionDetails["IsPdf"] : 0;
                                            $checked = "";
                                            if ($showAsMenu) {
                                                $checked = "checked='checked'";
                                            }
                                            ?>
                                            <label>
                                                <input type="checkbox" <?= $checked; ?> name="IsPdf"
                                                       value="1"/>
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="control-label col-md-3">
                                    Predefined Update and Form Update Redis Update 
                                </label>

                                <div class="col-md-9">

                                    <div class="col-md-12 padding_none">
                                        <div class="checkboxes">
                                            <?php
                                            $PredefinedUpdateRedis = (isset($getTableActionDetails["PredefinedUpdateRedis"])) ? $getTableActionDetails["PredefinedUpdateRedis"] : 0;
                                            $checked = "";
                                            if ($PredefinedUpdateRedis) {
                                                $checked = "checked='checked'";
                                            }
                                            ?>
                                            <label>
                                                <input type="checkbox" <?= $checked; ?> name="PredefinedUpdateRedis"
                                                       value="1"/>
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="offset-md-3 col-md-9">
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