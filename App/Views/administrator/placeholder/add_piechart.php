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
                    <header>Add Pie Chart Template</header>
                </div>
                <div class="card-body" id="bar-parent1">
                    <form action="<?php echo baseUrl; ?>save_piechart" method="post"
                          class="form-horizontal">
                        <div class="form-body">
                            <input type="hidden" name="id"
                                   value="<?= $id = (isset($getPieChartDetails['ID'])) ? $getPieChartDetails['ID'] : ""; ?>"/>

                            <div class="form-group row">
                                <label class="control-label col-md-3">
                                    Pie Chart name
                                    <span class="required"> * </span>
                                </label>

                                <div class="col-md-4">
                                    <input type="text" name="Name" required="" data-required="1"
                                           value="<?= $Name = (isset($getPieChartDetails['Name'])) ? $getPieChartDetails['Name'] : ""; ?>"
                                           class="form-control"/>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="control-label col-md-3">
                                    Pie Chart Description
                                </label>

                                <div class="col-md-4">
                                    <input type="text" name="Descriptions" required="" data-required="1"
                                           value="<?= $descriptions = (isset($getPieChartDetails['Descriptions'])) ? $getPieChartDetails['Descriptions'] : ""; ?>"
                                           class="form-control"/>
                                </div>
                            </div>


                            <div class="form-group row">
                                <label class="control-label col-md-3">
                                    Pie Chart Type
                                    <span class="required"> * </span>
                                </label>

                                <div class="col-md-4">
                                    <?php
                                    $mapType = (isset($getPieChartDetails['PieChartType'])) ? $getPieChartDetails['PieChartType'] : "";
                                    ?>
                                    <select name="PieChartType" class="form-control" required="">
                                        <option value=""> Select</option>
                                        <option value="1" <?php if ($mapType == 1) {
                                            echo "selected='selected'";
                                        } ?>>Pie legend
                                        </option>
                                        <option value="2" <?php if ($mapType == 2) {
                                            echo "selected='selected'";
                                        } ?>>Semi Circle Donut
                                        </option>
                                         <option value="3" <?php if ($mapType == 3) {
                                            echo "selected='selected'";
                                        } ?>>Pie Drill Down 
                                        </option>
                                    </select>
                                </div>
                            </div>


                            <div class="form-group row">
                                <label class="control-label col-md-3">
                                    Pie Chart Calculation Type
                                    <span class="required"> * </span>
                                </label>

                                <div class="col-md-4">
                                    <?php
                                    $calType = (isset($getPieChartDetails['CalculationType'])) ? $getPieChartDetails['CalculationType'] : "";
                                    ?>
                                    <select name="CalculationType" class="form-control" required="">
                                        <option value=""> Select</option>
                                        <option value="1" <?php if ($calType == 1) {
                                            echo "selected='selected'";
                                        } ?>>ON one Column
                                        </option>
                                        <option value="2" <?php if ($calType == 2) {
                                            echo "selected='selected'";
                                        } ?>>Two Table Relation 
                                        </option>
                                        <option value="3" <?php if ($calType == 3) {
                                            echo "selected='selected'";
                                        } ?>>Sum of Columns
                                        </option>
                                    </select>
                                </div>
                            </div>

                             <div class="form-group row">
                                <label class="control-label col-md-3">
                                    Pie Chart Display Type
                                    <span class="required"> * </span>
                                </label>

                                <div class="col-md-4">
                                    <?php
                                    $displayType = (isset($getPieChartDetails['DisplayType'])) ? $getPieChartDetails['DisplayType'] : "";
                                    ?>
                                    <select name="DisplayType" class="form-control" required="">
                                        <option value=""> Select</option>
                                        <option value="1" <?php if ($displayType == 1) {
                                            echo "selected='selected'";
                                        } ?>> Percentage
                                        </option>
                                        <option value="2" <?php if ($displayType == 2) {
                                            echo "selected='selected'";
                                        } ?>> Total Sum
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
                                            $getDataSourceId = (isset($getPieChartDetails['DataSourceId'])) ? $getPieChartDetails['DataSourceId'] : "";
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
                                            $getDataTableId = (isset($getPieChartDetails['TableId'])) ? $getPieChartDetails['TableId'] : "";
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
                                    Column
                                    <span class="required"> * </span>
                                </label>

                                <div class="col-md-4">
                                    <select name="Fields[]" id="multiple"
                                            class="form-control select2-multiple dataSourceColumns dataTableColumns" 
                                            multiple
                                            required="">
                                        <option value="">Select</option>
                                        <?php if (!empty($existingColumnsOfDataSource)) {
                                            $getMapsColumns = (!empty($getPieChartDetails['Fields'])) ? $getPieChartDetails['Fields'] : array();
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
                                            $getMapsColumns = (!empty($getPieChartDetails['Fields'])) ? $getPieChartDetails['Fields'] : array();
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
                                            $getMapsColumns = (!empty($getPieChartDetails['Columns'])) ? $getPieChartDetails['Columns'] : array();
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
                                            $getMapsColumns = (!empty($getPieChartDetails['Columns'])) ? $getPieChartDetails['Columns'] : array();
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
                                           value="<?= $CustomNameLabel = (isset($getPieChartDetails['CustomNameLabel'])) ? $getPieChartDetails['CustomNameLabel'] : ""; ?>"
                                           class="form-control"/>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="control-label col-md-3">
                                    Custom sum formula (+ - * /)
                                </label>

                                <div class="col-md-4">
                                    <input type="text" name="CustomSumFormula"
                                           value="<?= $customSumFormula = (isset($getPieChartDetails['CustomSumFormula'])) ? $getPieChartDetails['CustomSumFormula'] : ""; ?>"
                                           class="form-control"/>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="control-label col-md-3">
                                    Header Text
                                    <span class="required"> * </span>
                                </label>

                                <div class="col-md-4">
                                    <input type="text" name="HeadersText" value="<?= $headersText = (isset($getPieChartDetails['HeadersText'])) ? $getPieChartDetails['HeadersText'] : ""; ?>" required="" data-required="1"
                                           class="form-control"/>
                                </div>
                            </div>
                             <div class="form-group row">
                                <label class="control-label col-md-3">
                                    Show Pie Chart Label As Default
                                </label>

                                <div class="col-md-9">

                                    <div class="col-md-12 padding_none">
                                        <div class="checkboxes" id="ChangeChkBox">
                                            <?php
                                            $showLabel = (isset($getTableDetails["ShowLabel"])) ? $getTableDetails["ShowLabel"] : 0;
                                            $checked = "";
                                            if ($showLabel) {
                                                $checked = "checked='checked'";
                                            }
                                            ?>
                                            <label>
                                                <input type="checkbox" <?= $checked; ?> name="ShowLabel" value="1"/>
                                            </label>
                                        </div>
                                    </div>
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