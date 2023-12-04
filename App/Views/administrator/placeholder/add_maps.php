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
                    <header>Add Maps template</header>
                </div>
                <div class="card-body" id="bar-parent1">
                    <form action="<?php echo baseUrl; ?>save_maps" method="post"
                          class="form-horizontal">
                        <div class="form-body">
                            <input type="hidden" name="id"
                                   value="<?= $id = (isset($getMapsDetails['ID'])) ? $getMapsDetails['ID'] : ""; ?>"/>

                            <div class="form-group row">
                                <label class="control-label col-md-3">
                                    Map name
                                    <span class="required"> * </span>
                                </label>

                                <div class="col-md-4">
                                    <input type="text" name="Name" required="" data-required="1"
                                           value="<?= $Name = (isset($getMapsDetails['Name'])) ? $getMapsDetails['Name'] : ""; ?>"
                                           class="form-control"/>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="control-label col-md-3">
                                    Map description
                                </label>

                                <div class="col-md-4">
                                    <input type="text" name="Descriptions" required="" data-required="1"
                                           value="<?= $descriptions = (isset($getMapsDetails['Descriptions'])) ? $getMapsDetails['Descriptions'] : ""; ?>"
                                           class="form-control"/>
                                </div>
                            </div>


                            <div class="form-group row">
                                <label class="control-label col-md-3">
                                    Map Type
                                    <span class="required"> * </span>
                                </label>

                                <div class="col-md-4">
                                    <?php
                                    $mapType = (isset($getMapsDetails['MapType'])) ? $getMapsDetails['MapType'] : "";
                                    ?>
                                    <select name="MapType" class="form-control" required="">
                                        <option value=""> Select</option>
                                        <option value="1" <?php if ($mapType == 1) {
                                            echo "selected='selected'";
                                        } ?>>Bubble Map
                                        </option>
                                        <option value="2" <?php if ($mapType == 2) {
                                            echo "selected='selected'";
                                        } ?>>Map With city zipcode (Dots)
                                        </option>
                                        <option value="3" <?php if ($mapType == 3) {
                                            echo "selected='selected'";
                                        } ?>>Map With city
                                        </option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="control-label col-md-3">
                                    Data source
                                    
                                </label>

                                <div class="col-md-4">
                                    <select name="DataSourceId" class="form-control DataSourceId select2-multiple" data-maximum-selection-length="1" multiple >

                                        <option value=""> Select</option>
                                        <?php
                                        if ($getDataSource) {
                                            $getDataTableId = (isset($getMapsDetails['TableId'])) ? $getMapsDetails['TableId'] : "";
                                            $getDataSourceId = (isset($getMapsDetails['DataSourceId']) && $getDataTableId != '') ? $getMapsDetails['DataSourceId'] : "";
                                            $existingColumnsOfDataSource = "";
                                            ?>
                                            <?php foreach ($getDataSource as $key => $eachDataSource) {
                                                $selected = '';
                                                if ($getDataSourceId == $eachDataSource['ID']) {
                                                    $selected = 'selected="selected"';
                                                    $existingColumnsOfDataSource = $eachDataSource["Columns"];
                                                }
                                                ?>
                                                <option <?= $selected; ?>
                                                    value="<?= $eachDataSource['ID']; ?>"><?= $eachDataSource['Name']; ?></option>
                                            <?php }  ?>
                                        <?php } ?>
                                    </select>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="control-label col-md-3">
                                    Data Table
                                </label>

                                <div class="col-md-4">
                                    <select name="TableId" class="form-control TableId select2-multiple DataTableId" data-maximum-selection-length="1" multiple >
                                        <option value=""> Select</option>
                                        <?php
                                        if ($getDataTable) {
                                            $getDataTableId = (isset($getMapsDetails['TableId'])) ? $getMapsDetails['TableId'] : "";
                                            $existingColumnsOfDataTable = "";
                                            ?>
                                            <?php foreach ($getDataTable as $key => $getDataTableValue) {
                                                $selected = '';
                                                if ($getDataTableValue['ID'] == $getDataTableId) {
                                                    $selected = 'selected="selected"';
                                                    $existingColumnsOfDataTable = $getDataTableValue["Columns"];
                                                }
                                                ?>
                                                <option <?= $selected; ?>
                                                    value="<?= $getDataTableValue['ID']; ?>"><?= $getDataTableValue['Name']; ?></option>
                                            <?php } ?>
                                        <?php } ?>
                                    </select>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="control-label col-md-3">
                                    Country/city Column
                                    <span class="required"> * </span>
                                </label>

                                <div class="col-md-4">
                                    <select name="Fields[]" id="multiple"
                                            class="form-control select2-multiple dataSourceColumns dataTableColumns" data-maximum-selection-length="1"  multiple
                                            required="">
                                        <option value="">Select</option>
                                        <?php if (!empty($existingColumnsOfDataSource)) {
                                            $getMapsColumns = (!empty($getMapsDetails['Fields'])) ? $getMapsDetails['Fields'] : array();
                                            if (!empty($getMapsColumns)) {
                                                $getMapsColumns = explode(',', $getMapsColumns);
                                            }
                                            $existingColumnsOfDataSource = explode(',', $existingColumnsOfDataSource);
                                            if ($existingColumnsOfDataSource) {
                                                foreach ($existingColumnsOfDataSource as $key => $value) {
                                                    $selected = "";
                                                    $value = trim($value);
                                               
                                                    if (in_array($value, $getMapsColumns)) {
                                                        $selected = 'selected="selected"';
                                                    }
                                                    echo '<option value=' . $value . ' ' . $selected . '>' . $value . '</option>';
                                                }
                                            
                                            }
                                            }else if (!empty($existingColumnsOfDataTable)) {
                                            $getMapsColumns = (!empty($getMapsDetails['Fields'])) ? $getMapsDetails['Fields'] : array();
                                            if ($getMapsColumns) {
                                                $getMapsColumns = explode(',', $getMapsColumns);
                                            }
                                            $existingColumnsOfDataTable = explode(',', $existingColumnsOfDataTable);
                                            if ($existingColumnsOfDataTable) {
                                                foreach ($existingColumnsOfDataTable as $key => $value) {
                                                    $selected = "";
                                                    $value = trim($value);
                                                    if (in_array($value, $getMapsColumns)) {
                                                        $selected = 'selected="selected"';
                                                    }
                                                    echo '<option value=' . $value . ' ' . $selected . '>' . $value . '</option>';
                                                }
                                            } ?>
                                        <?php }?>
                                    </select>
                                </div>
                            </div>


                            <div class="form-group row">
                                <label class="control-label col-md-3">
                                    Columns for displaying Totals
                                    <span class="required"> * </span>
                                </label>

                                <div class="col-md-4">
                                    <select name="Columns[]" id="multiple"
                                            class="form-control select2-multiple dataSourceColumns dataTableColumns" multiple
                                            required="">
                                        <option value="">Select</option>
                                        <option value="">Select</option>
                                        <?php if ($existingColumnsOfDataSource) {
                                            $getMapsColumns = (!empty($getMapsDetails['Columns'])) ? $getMapsDetails['Columns'] : array();
                                            if ($getMapsColumns) {
                                                $getMapsColumns = explode(',', $getMapsColumns);
                                            }
                                            if(!is_array($existingColumnsOfDataSource))
                                            {
                                                $existingColumnsOfDataSource = explode(',', $existingColumnsOfDataSource);
                                            }
                                           
                                            if ($existingColumnsOfDataSource) {
                                                foreach ($existingColumnsOfDataSource as $key => $value) {
                                                    $selected = "";
                                                    $value = trim($value);
                                                    if (in_array($value, $getMapsColumns)) {
                                                        $selected = 'selected="selected"';
                                                    }
                                                    echo '<option value=' . $value . ' ' . $selected . '>' . $value . '</option>';
                                                }
                                            }
                                            ?>
                                        <?php }else if (!empty($existingColumnsOfDataTable)) {
                                            $getMapsColumns = (!empty($getMapsDetails['Columns'])) ? $getMapsDetails['Columns'] : array();
                                            if ($getMapsColumns) {
                                                $getMapsColumns = explode(',', $getMapsColumns);
                                            }
                                            if(!is_array($existingColumnsOfDataTable))
                                            {
                                                $existingColumnsOfDataTable = explode(',', $existingColumnsOfDataTable);
                                            }
                                            if ($existingColumnsOfDataTable) {
                                                foreach ($existingColumnsOfDataTable as $key => $value) {
                                                    $selected = "";
                                                    $value = trim($value);
                                                    if (in_array($value, $getMapsColumns)) {
                                                        $selected = 'selected="selected"';
                                                    }
                                                    echo '<option value=' . $value . ' ' . $selected . '>' . $value . '</option>';
                                                }
                                            } ?>
                                        <?php }?>
                                    </select>
                                </div>
                            </div>


                            <div class="form-group row">
                                <label class="control-label col-md-3">
                                    Custom sum Field Label
                                </label>

                                <div class="col-md-4">
                                    <input type="text" name="CustomNameLabel"
                                           value="<?= $CustomNameLabel = (isset($getMapsDetails['CustomNameLabel'])) ? $getMapsDetails['CustomNameLabel'] : ""; ?>"
                                           class="form-control"/>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="control-label col-md-3">
                                    Custom sum formula (+ - * /)
                                </label>

                                <div class="col-md-4">
                                    <input type="text" name="CustomSumFormula"
                                           value="<?= $customSumFormula = (isset($getMapsDetails['CustomSumFormula'])) ? $getMapsDetails['CustomSumFormula'] : ""; ?>"
                                           class="form-control"/>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="control-label col-md-3">
                                    Header Text
                                    <span class="required"> * </span>
                                </label>

                                <div class="col-md-4">
                                    <input type="text" name="HeadersText" value="<?= $headersText = (isset($getMapsDetails['HeadersText'])) ? $getMapsDetails['HeadersText'] : ""; ?>" required="" data-required="1"
                                           class="form-control"/>
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