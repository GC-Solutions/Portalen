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
                    <header>Add child row  template</header>
                </div>
                <div class="card-body" id="bar-parent1">
                    <form action="<?php echo baseUrl; ?>save_Childrow" method="post"
                          class="form-horizontal">
                        <div class="form-body">


                            <input type="hidden" name="id"
                                   value="<?= $id = (isset($getChildRowActionDetails['ID'])) ? $getChildRowActionDetails['ID'] : ""; ?>"/>

                            <div class="form-group row">
                                <label class="control-label col-md-3">
                                    Table name
                                    <span class="required"> * </span>
                                </label>

                                <div class="col-md-4">
                                    <input type="text" name="Name" required="" data-required="1"
                                           value="<?= $Name = (isset($getChildRowActionDetails['Name'])) ? $getChildRowActionDetails['Name'] : ""; ?>"
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
                                           value="<?= $descriptions = (isset($getChildRowActionDetails['Descriptions'])) ? $getChildRowActionDetails['Descriptions'] : ""; ?>"
                                           class="form-control"/>
                                </div>
                            </div>


                            <div class="form-group row">
                                <label class="control-label col-md-3">
                                    Enable child row Table 
                                    <span class="required"> * </span>
                                </label>

                                <div class="col-md-4">
                                    <select name="DataSourceId" class="form-control DataSourceIdTableAction select2-multiple" data-maximum-selection-length="1" multiple 
                                    required="">
                                        <option value=""> Select</option>
                                        <?php
                                        if (isset($getDataSourceTables) && $getDataSourceTables) {
                                            $getDataSourceId = (isset($getChildRowActionDetails['DataSourceId'])) ? $getChildRowActionDetails['DataSourceId'] : "";
                                            ?>
                                            <?php foreach ($getDataSourceTables as $key => $eachDataSource) {
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
                                    Select table whose data need to be displayed as child row 
                                    <span class="required"> * </span>
                                </label>

                                <div class="col-md-4">
                                    <select name="TableTemplateId" class="form-control TableTemplateId select2-multiple" data-maximum-selection-length="1" multiple required="">
                                        <option value=""> Select</option>
                                        <?php
                                        if (isset($getDataSourceTables) && $getDataSourceTables) {
                                            $selectedTableColumns = "";
                                            $getTableTemplateId = (isset($getChildRowActionDetails['TableTemplateId'])) ? $getChildRowActionDetails['TableTemplateId'] : "";
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
                                            $getTableParameterColumn = (isset($getChildRowActionDetails['TableParameterColumn'])) ? $getChildRowActionDetails['TableParameterColumn'] : "";
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