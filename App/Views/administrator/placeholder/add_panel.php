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
                        <header>Add panel template</header>
                    </div>
                    <div class="card-body" id="bar-parent1">
                        <form action="<?php echo baseUrl; ?>savePanel" method="post" enctype="multipart/form-data"
                              class="form-horizontal">
                            <div class="form-body">
                                <input type="hidden" name="id"
                                       value="<?= $id = (isset($getPanelDetails['ID'])) ? $getPanelDetails['ID'] : ""; ?>"/>
                            </div>
                            <div class="form-group row">
                                <label class="control-label col-md-3">
                                    Name
                                    <span class="required"> * </span>
                                </label>

                                <div class="col-md-4">
                                    <input type="text" name="Name"
                                           value="<?= $Name = (isset($getPanelDetails['Name'])) ? $getPanelDetails['Name'] : ""; ?>"
                                           required="" data-required="1"
                                           class="form-control"/>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="control-label col-md-3">
                                    Description
                                    <span class="required"> * </span>
                                </label>

                                <div class="col-md-4">
                                    <input type="text" name="Descriptions"
                                           value="<?= $descriptions = (isset($getPanelDetails['Descriptions'])) ? $getPanelDetails['Descriptions'] : ""; ?>"
                                           required="" data-required="1"
                                           class="form-control"/>
                                </div>
                            </div>


                            <div class="form-group row">
                                <label class="control-label col-md-3">
                                    Panel Color
                                    <span class="required"> * </span>
                                </label>

                                <div class="col-md-4">
                                    <?php
                                    $panelColor = (isset($getPanelDetails['PanelColor'])) ? $getPanelDetails['PanelColor'] : "";
                                    ?>
                                    <select name="PanelColor" class="form-control" required="">
                                        <option value=""> Select</option>
                                        <option value="1" <?php if ($panelColor == 1) {
                                            echo "selected='selected'";
                                        } ?>>Red
                                        </option>
                                        <option value="2" <?php if ($panelColor == 2) {
                                            echo "selected='selected'";
                                        } ?>>Blue
                                        </option>
                                        <option value="3" <?php if ($panelColor == 3) {
                                            echo "selected='selected'";
                                        } ?>>Green
                                        </option>
                                        <option value="4" <?php if ($panelColor == 4) {
                                            echo "selected='selected'";
                                        } ?>>Yellow
                                        </option>
                                        <option value="5" <?php if ($panelColor == 5) {
                                            echo "selected='selected'";
                                        } ?>>Purple
                                        </option>
                                        <option value="6" <?php if ($panelColor == 6) {
                                            echo "selected='selected'";
                                        } ?>>Orange
                                        </option>
                                        <option value="7" <?php if ($panelColor == 7) {
                                            echo "selected='selected'";
                                        } ?>>DeepPink
                                        </option>
                                        
                                    </select>
                                </div>
                            </div>


                            <div class="form-group row">
                                <label class="control-label col-md-3">
                                    Panel Type
                                    <span class="required"> * </span>
                                </label>

                                <div class="col-md-4">
                                    <?php
                                    $panelType = (isset($getPanelDetails['PanelType'])) ? $getPanelDetails['PanelType'] : "";
                                    ?>
                                    <select name="PanelType" class="form-control" required="">
                                        <option value=""> Select</option>
                                        <option value="1" <?php if ($panelType == 1) {
                                            echo "selected='selected'";
                                        } ?>>Rounded corners
                                        </option>
                                        <option value="2" <?php if ($panelType == 2) {
                                            echo "selected='selected'";
                                        } ?>>Square corners
                                        </option>
                                        <option value="3" <?php if ($panelType == 3) {
                                            echo "selected='selected'";
                                        } ?>>With diagram in it
                                        </option>
                                        <option value="4" <?php if ($panelType == 4) {
                                            echo "selected='selected'";
                                        } ?>> Design 2 
                                        </option>
                                          <option value="5" <?php if ($panelType == 5) {
                                            echo "selected='selected'";
                                        } ?>> Design 3 
                                        </option>
                                        <option value="6" <?php if ($panelType == 4) {
                                            echo "selected='selected'";
                                        } ?>> Design 6 
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
                                             $getDataTableId = (isset($getPanelDetails['TableId'])) ? $getPanelDetails['TableId'] : "";

                                            $getDataSourceId = (isset($getPanelDetails['DataSourceId']) && $getDataTableId == '') ? $getPanelDetails['DataSourceId'] : "";
                                            $existingColumnsOfDataSource = "";
                                            ?>
                                            <?php foreach ($getDataSource as $key => $eachDataSource) {
                                                $selected = '';
                                                if ($getDataSourceId == $eachDataSource['ID']) {
                                                    $selected = 'selected="selected"';
                                                    $existingColumnsOfDataSource = $eachDataSource["Columns"];
                                                }
                                                ?>
                                                <!--- check here-->
                                                <option <?= $selected; ?>
                                                    value="<?= $eachDataSource['ID']; ?>"><?= $eachDataSource['Name']; ?></option>
                                            <?php } ?>
                                        <?php } 
                                       ?>
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
                                            $getDataTableId = (isset($getPanelDetails['TableId'])) ? $getPanelDetails['TableId'] : "";
                                            $existingColumnsOfTableSource = "";
                                            ?>
                                            <?php foreach ($getDataTable as $key => $getDataTableValue) {
                                                $selected = '';
                                                if ($getDataTableValue['ID'] == $getDataTableId) {
                                                    $selected = 'selected="selected"';
                                                    $existingColumnsOfTableSource = $getDataTableValue["Columns"];
                                                }
                                                ?>
                                                <option <?= $selected; ?>
                                                    value="<?= $getDataTableValue['ID']; ?>"><?= $getDataTableValue['Name']; ?></option>
                                            <?php } ?>
                                        <?php }   ?>
                                    </select>
                                </div>
                            </div>


                            <div class="form-group row">
                                <label class="control-label col-md-3">
                                    Sum type
                                    <span class="required"> * </span>
                                </label>

                                <div class="col-md-4">
                                    <?php
                                    $sumType = (isset($getPanelDetails['SumType'])) ? $getPanelDetails['SumType'] : "";
                                    ?>
                                    <select name="SumType" class="form-control" required="">
                                        <option value="">Select</option>
                                        <option value="1" <?php if ($sumType == 1) {
                                            echo "selected='selected'";
                                        } ?>>+ Sum index
                                        </option>
                                        <option value="2" <?php if ($sumType == 2) {
                                            echo "selected='selected'";
                                        } ?>>+ Sum all values from a column
                                        </option>
                                        <option value="3" <?php if ($sumType == 3) {
                                            echo "selected='selected'";
                                        } ?>>Custom sum
                                        </option>
                                        <option value="4" <?php if ($sumType == 4) {
                                            echo "selected='selected'";
                                        } ?>>Custom Row
                                        </option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="control-label col-md-3">
                                    Column Operations
                                </label>

                                <div class="col-md-4">
                                    <?php
                                    $ColumnOpr = (isset($getPanelDetails['ColumnOpr'])) ? $getPanelDetails['ColumnOpr'] : "";
                                    ?>
                                    <select name="ColumnOpr" class="form-control">
                                        <option value="">Select</option>
                                        <option value="1" <?php if ($ColumnOpr == 1) {
                                            echo "selected='selected'";
                                        } ?>>Add
                                        </option>
                                        <option value="2" <?php if ($ColumnOpr == 2) {
                                            echo "selected='selected'";
                                        } ?>>Subtract
                                        </option>
                                        <option value="3" <?php if ($ColumnOpr == 3) {
                                            echo "selected='selected'";
                                        } ?>>Multiply
                                        </option>
                                        <option value="4" <?php if ($ColumnOpr == 4) {
                                            echo "selected='selected'";
                                        } ?>>Divide
                                        </option>
                                    </select>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="control-label col-md-3">
                                    Custom sum formula (+ - * /)
                                </label>

                                <div class="col-md-4">
                                    <input type="text" name="CustomSumFormula"
                                           value="<?= $customSumFormula = (isset($getPanelDetails['CustomSumFormula'])) ? $getPanelDetails['CustomSumFormula'] : ""; ?>"
                                           class="form-control"/>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="control-label col-md-3">
                                    Columns
                                    <span class="required"> * </span>
                                </label>

                                <div class="col-md-4">
                                    <select name="Columns[]" id="multiple"
                                            class="form-control select2-multiple dataSourceColumns dataTableColumns" multiple
                                            required="">
                                        <option value="">Select</option>
                                        <?php if ($existingColumnsOfDataSource) {
                                            $getPanelColumns = $getPanelDetails['Columns'];
                                            if ($getPanelColumns) {
                                                $getPanelColumns = explode(',', $getPanelColumns);
                                            }
                                            $existingColumnsOfDataSource = explode(',', $existingColumnsOfDataSource);
                                            if ($existingColumnsOfDataSource) {
                                                foreach ($existingColumnsOfDataSource as $key => $value) {
                                                    $selected = "";
                                                    $value = trim($value);
                                                    if (in_array($value, $getPanelColumns)) {
                                                        $selected = 'selected="selected"';
                                                    }
                                                    echo '<option value=' . $value . ' ' . $selected . '>' . $value . '</option>';
                                                }
                                            }
                                            ?>
                                        <?php }else if($existingColumnsOfTableSource) { ?>
                                            <?php 
                                             $getPanelColumns = $getPanelDetails['Columns'];
                                            if ($getPanelColumns) {
                                                $getPanelColumns = explode(',', $getPanelColumns);
                                            }
                                            $existingColumnsOfTableSource = explode(',', $existingColumnsOfTableSource);
                                            if ($existingColumnsOfTableSource) {
                                                foreach ($existingColumnsOfTableSource as $key => $value) {
                                                    $selected = "";
                                                    $value = trim($value);
                                                    if (in_array($value, $getPanelColumns)) {
                                                        $selected = 'selected="selected"';
                                                    }
                                                    echo '<option value=' . $value . ' ' . $selected . '>' . $value . '</option>';
                                                }
                                            }}
                                            ?>

                                    </select>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="control-label col-md-3">
                                   Column Sum Format 
                                </label>

                                <div class="col-md-4">
                                    <?php
                                    $ColumnDataType = (isset($getPanelDetails['ColumnDataType'])) ? $getPanelDetails['ColumnDataType'] : "";
                                    ?>
                                    <select name="ColumnDataType" class="form-control" >
                                        <option value=""> Select</option>
                                        <option value="1" <?php if ($ColumnDataType == 1) {
                                            echo "selected='selected'";
                                        } ?>>Sum with Spaces/number format
                                        </option>
                                        <option value="2" <?php if ($ColumnDataType == 2) {
                                            echo "selected='selected'";
                                        } ?>>Sum without Spaces
                                        </option>
                                        
                                    </select>
                                </div>
                            </div>


                            <div class="form-group row">
                                <label class="control-label col-md-3">
                                    Title (Text)
                                    <span class="required"> * </span>
                                </label>

                                <div class="col-md-4">
                                    <input type="text" name="Title"
                                           value="<?= $title = (isset($getPanelDetails['Title'])) ? $getPanelDetails['Title'] : ""; ?>"
                                           required="" data-required="1" class="form-control"/>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="control-label col-md-3">
                                    Denomination (Text)
                                    <span class="required"> * </span>
                                </label>

                                <div class="col-md-4">
                                    <input type="text"
                                           value="<?= $denominationText = (isset($getPanelDetails['DenominationText'])) ? $getPanelDetails['DenominationText'] : ""; ?>"
                                           name="DenominationText" required="" data-required="1"
                                           class="form-control"/>
                                </div>
                            </div>

                             
                             <div class="form-group row">
                                <label class="control-label col-md-3">
                                    Text2 for Design 3 (Text)
                                </label>

                                <div class="col-md-4">
                                    <input type="text"
                                           value="<?= $textDesign2 = (isset($getPanelDetails['TextDesign2'])) ? $getPanelDetails['TextDesign2'] : ""; ?>"
                                           name="TextDesign2" 
                                           class="form-control"/>
                                </div>
                            </div>
                             <div class="form-group row">
                                <label class="control-label col-md-3">
                                    Progress Bar % for Design 3 
                                </label>

                                <div class="col-md-4">
                                    <input type="text"
                                           value="<?= $panelProgress = (isset($getPanelDetails['ProgressBarD3'])) ? $getPanelDetails['ProgressBarD3'] : ""; ?>"
                                           name="ProgressBarD3" 
                                           class="form-control"/>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="control-label col-md-3">
                                    Panel Logo Name
                                    <span class="required"></span>
                                </label>

                                <div class="col-md-4">
                                    <input type="text" value="<?= $getPanelLogoName = (isset($getPanelDetails['ImageName'])) ? $getPanelDetails['ImageName'] : ""; ?>" id="imageUpload" name="ImageName" class="form-control"/>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="control-label col-md-3">
                                    Allow decimal 
                                </label>

                                <div class="col-md-9">
                                    <div class="col-md-12 padding_none">
                                        <div class="checkboxes" id="ChangeChkBox">
                                            <?php
                                            $allowDecimalFlag = (isset($getPanelDetails["AllowDecimalFlag"])) ? $getPanelDetails["AllowDecimalFlag"] : 0;
                                            $checked = "";
                                            if ($allowDecimalFlag) {
                                                $checked = "checked='checked'";
                                            }
                                            ?>
                                            <label>
                                                <input type="checkbox" <?= $checked; ?> name="AllowDecimalFlag" value="1"/>
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="control-label col-md-3">
                                    Enable Row Group Calculation
                                </label>

                                <div class="col-md-9">
                                    <div class="col-md-12 padding_none">
                                        <div class="checkboxes" id="ChangeChkBox">
                                            <?php
                                            $EnableGroupRowCal = (isset($getPanelDetails["EnableGroupRowCal"])) ? $getPanelDetails["EnableGroupRowCal"] : 0;
                                            $checked = "";
                                            if ($EnableGroupRowCal) {
                                                $checked = "checked='checked'";
                                            }
                                            ?>
                                            <label>
                                                <input type="checkbox" <?= $checked; ?> name="EnableGroupRowCal" value="1"/>
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="control-label col-md-3">
                                    Row Group Column
                                    
                                </label>

                                <div class="col-md-4">
                                    <select name="RowGroupColumnName" id="multiple"
                                            class="form-control select2-multiple dataSourceColumns dataTableColumns" 
                                            >
                                        <option value="">Select</option>
                                        <?php if ($existingColumnsOfDataSource) {
                                            $RowGroupColumnName = $getPanelDetails['RowGroupColumnName'];
                                            if ($RowGroupColumnName) {
                                                $RowGroupColumnName = explode(',', $RowGroupColumnName);
                                            }
                                           
                                            if(!is_array( $existingColumnsOfDataSource)){
                                                $existingColumnsOfDataSource = explode(',', $existingColumnsOfDataSource);
                                           }
                                            
                                            if ($existingColumnsOfDataSource) {
                                                foreach ($existingColumnsOfDataSource as $key => $value) {
                                                    $selected = "";
                                                    $value = trim($value);
                                                    if ( $RowGroupColumnName != '' && in_array($value, $RowGroupColumnName)) {
                                                        $selected = 'selected="selected"';
                                                    }
                                                    echo '<option value=' . $value . ' ' . $selected . '>' . $value . '</option>';
                                                }
                                            }
                                            ?>
                                        <?php }else if($existingColumnsOfTableSource) { ?>
                                            <?php 
                                             $RowGroupColumnName = $getPanelDetails['Columns'];
                                            if ($RowGroupColumnName) {
                                                $RowGroupColumnName = explode(',', $RowGroupColumnName);
                                            }
                                           if(!is_array( $existingColumnsOfTableSource)){
                                                $existingColumnsOfTableSource = explode(',', $existingColumnsOfTableSource);
                                           }
                                           
                                            if ($existingColumnsOfTableSource) {
                                                foreach ($existingColumnsOfTableSource as $key => $value) {
                                                    $selected = "";
                                                    $value = trim($value);
                                                    if (in_array($value, $RowGroupColumnName)) {
                                                        $selected = 'selected="selected"';
                                                    }
                                                    echo '<option value=' . $value . ' ' . $selected . '>' . $value . '</option>';
                                                }
                                            }}
                                            ?>

                                    </select>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="control-label col-md-3">
                                    Allow . as Decimal 
                                </label>

                                <div class="col-md-9">
                                    <div class="col-md-12 padding_none">
                                        <div class="checkboxes" id="ChangeChkBox">
                                            <?php
                                            $TimeTableSeparator = (isset($getPanelDetails["TimeTableSeparator"])) ? $getPanelDetails["TimeTableSeparator"] : 0;
                                            $checked = "";
                                            if ($TimeTableSeparator) {
                                                $checked = "checked='checked'";
                                            }
                                            ?>
                                            <label>
                                                <input type="checkbox" <?= $checked; ?> name="TimeTableSeparator" value="1"/>
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
    <!-- end page content -->
<?php include_once realpath(__DIR__ . '/../..') . '/layout/Admin_Layout/footer_start.php'; ?>