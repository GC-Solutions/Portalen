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
                    <header>Add table template</header>
                </div>
                <div class="card-body" id="bar-parent1">
                    <form action="<?php echo baseUrl; ?>save_table" method="post" class="form-horizontal">
                        <div class="form-body">
                            <input type="hidden" name="id"
                                   value="<?= $id = (isset($getTableDetails['ID'])) ? $getTableDetails['ID'] : ""; ?>"/>

                            <div class="form-group row">
                                <label class="control-label col-md-3">
                                    Table name
                                    <span class="required"> * </span>
                                </label>

                                <div class="col-md-4">
                                    <input type="text" name="Name" required="" data-required="1"
                                           value="<?= $Name = (isset($getTableDetails['Name'])) ? $getTableDetails['Name'] : ""; ?>"
                                           class="form-control"/>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="control-label col-md-3">
                                    Table description
                                </label>

                                <div class="col-md-4">
                                    <input type="text" name="Descriptions" required="" data-required="1"
                                           value="<?= $descriptions = (isset($getTableDetails['Descriptions'])) ? $getTableDetails['Descriptions'] : ""; ?>"
                                           class="form-control"/>
                                </div>
                            </div>


                            <div class="form-group row">
                                <label class="control-label col-md-3">
                                    Table type
                                    <span class="required"> * </span>
                                </label>

                                <div class="col-md-4">
                                    <?php
                                    $tableType = (isset($getTableDetails['TableType'])) ? $getTableDetails['TableType'] : "";
                                    ?>
                                    <select name="TableType" class="form-control TableType" required="">
                                        <option value=""> Select</option>
                                        <option value="3" <?php if ($tableType == 3) {
                                            echo "selected='selected'";
                                        } ?>>Join table
                                        </option>
                                    </select>
                                </div>
                            </div>


                            <div class="form-group row">
                                <label class="control-label col-md-3">
                                    Data source
                                    <span class="required"> * </span>
                                </label>

                                <div class="col-md-4">
                                <?php
                               $tableType = (isset($getTableDetails['TableType'])) ? $getTableDetails['TableType'] : "";
                             
                                if($tableType == 3)
                                    {?>
                                        <select name="DataSourceId[]" class="form-control DataSourceId select2-multiple" multiple required="">
                                        <option value=""> Select</option>
                                        <?php
                                         if ($getDataSource) {
                                            $getDataSourceId = (isset($getTableDetails['DataSourceId'])) ? $getTableDetails['DataSourceId'] : "";
                                           
                                            if(strpos($getDataSourceId, ',') !== false)
                                            {
                                                $temp = $getDataSourceId; 
                                                $getDataSourceId = array();
                                                $getDataSourceId = explode(',', $temp);
                                            }else{
                                                $temp = $getDataSourceId; 
                                                $getDataSourceId = array();
                                                $getDataSourceId[0] = $temp;
                                            }
                                            
                                            $existingColumnsOfDataSource = "";
                                            $existingColumnsOfDataSourceFooter = "";
                                            $existingColumnsOfExcludeZero = "";
                                            $existingColumnsOfGroupRow = "";
                                            $existingColumnsOfHideColumn = "";
                                            $existingColumnsOfPredefineSort = '';
                                            ?>
                                            <?php foreach ($getDataSource as $key => $eachDataSource) {

                                                
                                                $selected = '';
                                               
                                                if (in_array($eachDataSource['ID'], $getDataSourceId)){
                                                    $selected = 'selected="selected"';
                                                    
                                                    $newColumn  = explode( ',' , $eachDataSource["Columns"] ) ;
                                                    
                                                    foreach($newColumn  as $ke => $val){
                                                        $newColumn[$ke] = trim($eachDataSource["Name"]).'-'.trim($val);
                                                    }
                                                    $newColumn = implode(',', $newColumn);
                                                    
                                                    if($existingColumnsOfDataSource != ''){
                                                        $existingColumnsOfDataSource .= ($eachDataSource['ApiType'] == '2') ?$eachDataSource["DisplayColumnName"]:','.$newColumn;
                                                                                                        
                                                    }else{
                                                        $existingColumnsOfDataSource .= ($eachDataSource['ApiType'] == '2') ?$eachDataSource["DisplayColumnName"]:$newColumn;
                                                                                                        
                                                    }
                                                    if($existingColumnsOfDataSourceFooter != ''){
                                                        $existingColumnsOfDataSourceFooter .= (!empty($eachDataSource['ApiType']) && ($eachDataSource['ApiType']) == '2') ?$eachDataSource["DisplayColumnName"]:','.$newColumn;                                                   
                                                    }else{
                                                        $existingColumnsOfDataSourceFooter .= (!empty($eachDataSource['ApiType']) && ($eachDataSource['ApiType']) == '2') ?$eachDataSource["DisplayColumnName"]:$newColumn;                                                    
                                                    }

                                                    if($existingColumnsOfExcludeZero != ''){
                                                        $existingColumnsOfExcludeZero .= (!empty($eachDataSource['ApiType']) && ($eachDataSource['ApiType']) == '2') ?$eachDataSource["DisplayColumnName"]:','.$newColumn;                                                   
                                                    }else{
                                                        $existingColumnsOfExcludeZero .= (!empty($eachDataSource['ApiType']) && ($eachDataSource['ApiType']) == '2') ?$eachDataSource["DisplayColumnName"]:$newColumn;                                                   
                                                    }
                                                    
                                                    
                                                    if($existingColumnsOfGroupRow != ''){
                                                        $existingColumnsOfGroupRow .= (!empty($eachDataSource['ApiType']) && ($eachDataSource['ApiType']) == '2') ?$eachDataSource["DisplayColumnName"]:','.$newColumn;                                                   
                                                    }else{
                                                        $existingColumnsOfGroupRow .= (!empty($eachDataSource['ApiType']) && ($eachDataSource['ApiType']) == '2') ?$eachDataSource["DisplayColumnName"]:$newColumn;                                                   
                                                    }
                                                    
                                                        
                                                    
                                                    if($existingColumnsOfHideColumn != ''){
                                                        $existingColumnsOfHideColumn .= (!empty($eachDataSource['ApiType']) && ($eachDataSource['ApiType']) == '2') ?$eachDataSource["DisplayColumnName"]:','.$newColumn;                                                   
                                                    }else{
                                                        $existingColumnsOfHideColumn .= (!empty($eachDataSource['ApiType']) && ($eachDataSource['ApiType']) == '2') ?$eachDataSource["DisplayColumnName"]:$newColumn;                                                   
                                                    }
                                                    
                                                    if($existingColumnsOfPredefineSort != ''){
                                                            $existingColumnsOfPredefineSort .= (!empty($eachDataSource['ApiType']) && ($eachDataSource['ApiType']) == '2') ?$eachDataSource["DisplayColumnName"]:','.$newColumn;                                                  
                                                    }else{
                                                        $existingColumnsOfPredefineSort .= (!empty($eachDataSource['ApiType']) && ($eachDataSource['ApiType']) == '2') ?$eachDataSource["DisplayColumnName"]:$newColumn;                                                
                                                    }
                                                }
                                                ?>
                                                <option <?= $selected; ?>
                                                    value="<?= $eachDataSource['ID']; ?>"><?= $eachDataSource['Name']; ?></option>
                                            <?php 
                                            } ?>
                                        <?php }  ?>
                                    </select>
                                <?php } else { ?>
                                    <select name="DataSourceId[]" class="form-control DataSourceId select2-multiple" multiple required="">
                                        <option value=""> Select</option>
                                        <?php
                                         if ($getDataSource) {
                                            $getDataSourceId = (isset($getTableDetails['DataSourceId'])) ? $getTableDetails['DataSourceId'] : "";
                                            
                                            $existingColumnsOfDataSource = "";
                                            $existingColumnsOfDataSourceFooter = "";
                                            $existingColumnsOfExcludeZero = "";
                                            $existingColumnsOfGroupRow = "";
                                            $existingColumnsOfHideColumn = "";
                                            $existingColumnsOfPredefineSort = '';
                                            ?>
                                            <?php foreach ($getDataSource as $key => $eachDataSource) {

                                                $selected = '';
                                                if ($getDataSourceId == $eachDataSource['ID']) {
                                                    $selected = 'selected="selected"';
                                                    $existingColumnsOfDataSource = ($eachDataSource['ApiType'] == '2') ?$eachDataSource["DisplayColumnName"]:$eachDataSource["Columns"];
                                                    $existingColumnsOfDataSourceFooter = (!empty($eachDataSource['ApiType']) && ($eachDataSource['ApiType']) == '2') ?$eachDataSource["DisplayColumnName"]:$eachDataSource["Columns"];
                                                    $existingColumnsOfExcludeZero = (!empty($eachDataSource['ApiType']) && ($eachDataSource['ApiType']) == '2') ?$eachDataSource["DisplayColumnName"]:$eachDataSource["Columns"];
                                                    $existingColumnsOfGroupRow = (!empty($eachDataSource['ApiType']) && ($eachDataSource['ApiType']) == '2') ?$eachDataSource["DisplayColumnName"]:$eachDataSource["Columns"];
                                                    $existingColumnsOfHideColumn = (!empty($eachDataSource['ApiType']) && ($eachDataSource['ApiType']) == '2') ?$eachDataSource["DisplayColumnName"]:$eachDataSource["Columns"];
                                                    $existingColumnsOfPredefineSort= (!empty($eachDataSource['ApiType']) && ($eachDataSource['ApiType']) == '2') ?$eachDataSource["DisplayColumnName"]:$eachDataSource["Columns"];
                                                }
                                                ?>
                                                <option <?= $selected; ?>
                                                    value="<?= $eachDataSource['ID']; ?>"><?= $eachDataSource['Name']; ?></option>
                                            <?php 
                                            } ?>
                                        <?php } ?>
                                    </select>
                                <?php } ?>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="control-label col-md-3">
                                    Display Column Names
                                    <span class="required"> * </span>
                                </label>

                                <div class="col-md-4">
                                  <textarea name="DisplayColumnNames"
                                            class="form-control"> <?= $displayColumnNames = (isset($getTableDetails['DisplayColumnNames'])) ? $getTableDetails['DisplayColumnNames'] : ""; ?></textarea>
                                </div>
                            </div>

                            <div class="form-group row" style="display: none;">
                                <label class="control-label col-md-3">
                                    Display Detail Column Names
                                    <span class="required"> * </span>
                                </label>

                                <div class="col-md-4">
                                  <textarea name="DisplayDetailColumnNames"
                                            class="form-control"> <?= $displayDetailColumnNames = (isset($getTableDetails['DisplayDetailColumnNames'])) ? $getTableDetails['DisplayDetailColumnNames'] : ""; ?></textarea>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="control-label col-md-3">
                                    Columns that need to be combined for matching
                                    <span class="required"> * </span>
                                </label>

                                <div class="col-md-4">
                                    <select name="ColumnsMatching[]" id="multiple"
                                            class="form-control select2-multiple dataSourceColumns" data-reorder="1" multiple
                                            required="">
                                        <option value="">Select</option>
                                        <?php
                                        
                                         if ($existingColumnsOfDataSource) {
                                            $getTableColumns = $getTableDetails['ColumnsMatching'];
                                           
                                           
                                            if ($getTableColumns) {
                                                $getTableColumns = explode(',', $getTableColumns);
                                            }
                                            
                                            $existingColumnsOfDataSource = explode(',', $existingColumnsOfDataSource);
                                          
                                            if ($existingColumnsOfDataSource) {
                                                foreach ($existingColumnsOfDataSource as $key => $value) {
                                                    $selected = "";
                                                    $value = trim($value);
                                                    if (in_array($value, $getTableColumns)) {
                                                        $selected = 'selected="selected"';
                                                    }

                                                    echo '<option value= "'. $value . '"'. $selected . '>' . $value . '</option>';

                                                }
                                            }
                                            ?>
                                        <?php } ?>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="control-label col-md-3">
                                    Columns
                                    <span class="required"> * </span>
                                </label>

                                <div class="col-md-4">
                                    <select name="Columns[]" id="multiple"
                                            class="form-control select2-multiple dataSourceColumns" data-reorder="1" multiple
                                            required="">
                                        <option value="">Select</option>
                                        <?php
                                        
                                         if ($existingColumnsOfDataSource) {
                                            $getTableColumns = $getTableDetails['Columns'];
                                           
                                           
                                            if ($getTableColumns) {
                                                $getTableColumns = explode(',', $getTableColumns);
                                            }
                                            
                                            $existingColumnsOfDataSource = explode(',', $existingColumnsOfDataSource);
                                          
                                            if ($existingColumnsOfDataSource) {
                                                foreach ($existingColumnsOfDataSource as $key => $value) {
                                                    $selected = "";
                                                    $value = trim($value);
                                                    if (in_array($value, $getTableColumns)) {
                                                        $selected = 'selected="selected"';
                                                    }

                                                    echo '<option value= "'. $value . '"'. $selected . '>' . $value . '</option>';

                                                }
                                            }
                                            ?>
                                        <?php } ?>
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
                                    $sumType = (isset($getTableDetails['SumType'])) ? $getTableDetails['SumType'] : "";
                                    ?>
                                    <select name="SumType" class="form-control" required="">
                                        <option value="">Select</option>
                                        <option value="1" <?php if ($sumType == 1) {
                                            echo "selected='selected'";
                                        } ?>>+ Sum all values from a column
                                        </option>
                                        <option value="2" <?php if ($sumType == 2) {
                                            echo "selected='selected'";
                                        } ?>>Custom sum
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
                                           value="<?= $customSumFormula = (isset($getTableDetails['CustomSumFormula'])) ? $getTableDetails['CustomSumFormula'] : ""; ?>"
                                           class="form-control"/>
                                </div>
                            </div>


                            <div class="form-group row">
                                <label class="control-label col-md-3">
                                    Sum column label
                                </label>

                                <div class="col-md-4">
                                    <input type="text" name="SumColumnLable"
                                           value="<?= $sumColumnLable = (isset($getTableDetails['SumColumnLable'])) ? $getTableDetails['SumColumnLable'] : ""; ?>"
                                           class="form-control"/>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="control-label col-md-3">
                                    Column Sorting 
                                </label>

                                <div class="col-md-4">
                                    <textarea name="ColumnSort"
                                              class="form-control"> <?= $ColumnSort = (isset($getTableDetails['ColumnSort'])) ? $getTableDetails['ColumnSort'] : ""; ?></textarea>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="control-label col-md-3">
                                    Add footer callback
                                </label>

                                <div class="col-md-9">

                                    <div class="col-md-12 padding_none">
                                        <div class="checkboxes" id ='ChangeChkBox'>
                                            <?php
                                            $isFootCallBack = (isset($getTableDetails["IsFooterCallback"])) ? $getTableDetails["IsFooterCallback"] : 0;
                                            $checked = "";
                                            if ($isFootCallBack) {
                                                $checked = "checked='checked'";
                                            }
                                            ?>
                                            <label>
                                                <input type="checkbox" <?= $checked; ?> name="IsFooterCallback"
                                                       value="1"/>
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="control-label col-md-3">
                                    Footer call back text
                                </label>

                                <div class="col-md-4">
                                    <input type="text" name="FootCallBackText"
                                           value="<?= $footCallBackText = (isset($getTableDetails['FootCallBackText'])) ? $getTableDetails['FootCallBackText'] : ""; ?>"
                                           class="form-control"/>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="control-label col-md-3">
                                    Columns Footer
                                    <span class="required"> * </span>
                                </label>

                                <div class="col-md-4">
                                    <select name="ColumnsFooter[]" id="ColumnsFootermultiple"
                                            class="form-control select2-multiple dataSourceColumns" data-reorder="1" multiple
                                            required="">
                                        <option value="">Select</option>
                                        <?php if ($existingColumnsOfDataSourceFooter) {
                                            $getTableColumnsFooter = isset($getTableDetails['ColumnsFooter'])? $getTableDetails['ColumnsFooter']:[];


                                            if ($getTableColumnsFooter) {
                                                $getTableColumnsFooter = explode(',', $getTableColumnsFooter);
                                            }
                                            $existingColumnsOfDataSourceFooter = explode(',', $existingColumnsOfDataSourceFooter);
                                            if ($existingColumnsOfDataSourceFooter) {
                                                foreach ($existingColumnsOfDataSourceFooter as $key => $value) {
                                                    $selected = "";
                                                    $value = trim($value);
                                                 
                                                    if (!empty($getTableColumnsFooter) && in_array($value, $getTableColumnsFooter)) {
                                                        $selected = 'selected="selected"';
                                                    }
                                                   
                                                    echo '<option value= "'. $value .'"' . $selected . '>' . $value . '</option>';
                                                }
                                                
                                            }
                                            ?>
                                        <?php } ?>
                                    </select>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="control-label col-md-3">
                                    FooterCallback Column Properties
                                    <span class="required"> * </span>
                                </label>

                                <div class="col-md-4">
                                    <textarea name="FooterColumnsProperties"
                                              class="form-control"> <?= $FooterColumnsProperties = (isset($getTableDetails['FooterColumnsProperties'])) ? $getTableDetails['FooterColumnsProperties'] : ""; ?></textarea>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="control-label col-md-3">
                                    Additional Column Properties
                                    <span class="required"> * </span>
                                </label>

                                <div class="col-md-4">
                                    <textarea name="AdditionalColumnProperties"
                                              class="form-control"> <?= $AdditionalColumnsProperties = (isset($getTableDetails['AdditionalColumnProperties'])) ? $getTableDetails['AdditionalColumnProperties'] : ""; ?></textarea>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="control-label col-md-3">
                                    HighChart Column
                                    <span class="required"> * </span>
                                </label>

                                <div class="col-md-4">
                                    <textarea name="ChartColumn"
                                              class="form-control"> <?= $chartColumn = (isset($getTableDetails['ChartColumn'])) ? $getTableDetails['ChartColumn'] : ""; ?></textarea>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="control-label col-md-3">
                                    HighMap Column
                                    <span class="required"> * </span>
                                </label>

                                <div class="col-md-4">
                                    <textarea name="MapColumn"
                                              class="form-control"> <?= $MapColumn = (isset($getTableDetails['MapColumn'])) ? $getTableDetails['MapColumn'] : ""; ?></textarea>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="control-label col-md-3">
                                    Pie Chart Column
                                    <span class="required"> * </span>
                                </label>

                                <div class="col-md-4">
                                    <textarea name="PieChartColumn"
                                              class="form-control"> <?= $PieChartColumn = (isset($getTableDetails['PieChartColumn'])) ? $getTableDetails['PieChartColumn'] : ""; ?></textarea>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="control-label col-md-3">
                                    Columns which will allow multiple selection for filter
                                </label>
                                <div class="col-md-4">
                                    <textarea name="AllowMultipleSelectionColumn"
                                              class="form-control"> <?= $AllowMultipleSelectionColumn = (isset($getTableDetails['AllowMultipleSelectionColumn'])) ? $getTableDetails['AllowMultipleSelectionColumn'] : ""; ?></textarea>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="control-label col-md-3">
                                    Set Multiple Secrch Selector as Default
                                </label>

                                <div class="col-md-9">

                                    <div class="col-md-12 padding_none">
                                        <div class="checkboxes" id="ChangeChkBox">
                                            <?php
                                            $multipleSerachSelectorFlag = (isset($getTableDetails["multipleSerachSelectorFlag"])) ? $getTableDetails["multipleSerachSelectorFlag"] : 0;
                                            $checked = "";
                                            if ($multipleSerachSelectorFlag) {
                                                $checked = "checked='checked'";
                                            }
                                            ?>
                                            <label>
                                                <input type="checkbox" <?= $checked; ?> name="multipleSerachSelectorFlag" value="1"/>
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                         

                            <div class="form-group row">
                                <label class="control-label col-md-3">
                                    Columns which will be used for Row Grouping
                                </label>

                                <div class="col-md-4">
                                    <select name="GroupRowsColumn[]" id="GroupRowsColumn"
                                            class="form-control select2-multiple dataSourceColumns" data-reorder="1" multiple
                                            >
                                        <option value="">Select</option>
                                        <?php if ($existingColumnsOfGroupRow) {
                                            $getTableColumnsRowGroup = isset($getTableDetails['GroupRowsColumn'])? $getTableDetails['GroupRowsColumn']:'';


                                            if ($getTableColumnsRowGroup) {
                                                $getTableColumnsRowGroup = explode(',', $getTableColumnsRowGroup);
                                            }
                                            $existingColumnsOfGroupRow = explode(',', $existingColumnsOfGroupRow);
                                            if ($existingColumnsOfGroupRow) {
                                                foreach ($existingColumnsOfGroupRow as $key => $value) {
                                                    $selected = "";
                                                    $value = trim($value);
                                                    if (!empty($getTableColumnsRowGroup) && in_array($value, $getTableColumnsRowGroup)) {
                                                        $selected = 'selected="selected"';
                                                        }
                                                    echo '<option value= "' . $value . '"' . $selected . '>' . $value . '</option>';
                                                }
                                            }
                                            ?>
                                        <?php } ?>
                                    </select>
                                    <small id="rowGroup" class="form-text text-muted">First value will always be select as default</small>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="control-label col-md-3">
                                    Set Row Group 
                                </label>

                                <div class="col-md-9">

                                    <div class="col-md-12 padding_none">
                                        <div class="checkboxes" id="ChangeChkBox">
                                            <?php
                                            $rowGroupFlag = (isset($getTableDetails["GroupRowsFlag"])) ? $getTableDetails["GroupRowsFlag"] : 0;
                                            $checked = "";
                                            if ($rowGroupFlag) {
                                                $checked = "checked='checked'";
                                            }
                                            ?>
                                            <label>
                                                <input type="checkbox" <?= $checked; ?> name="GroupRowsFlag" value="1"/>
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div> 
                            <div class="form-group row">
                                <label class="control-label col-md-3">
                                    Press Enter for Fast High Chart Generation
                                </label>

                                <div class="col-md-9">

                                    <div class="col-md-12 padding_none">
                                        <div class="checkboxes" id="ChangeChkBox">
                                            <?php
                                            $SearchFlag = (isset($getTableDetails["SearchFlag"])) ? $getTableDetails["SearchFlag"] : 0;
                                            $checked = "";
                                            if ($SearchFlag) {
                                                $checked = "checked='checked'";
                                            }
                                            ?>
                                            <label>
                                                <input type="checkbox" <?= $checked; ?> name="SearchFlag" value="1"/>
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="control-label col-md-3">
                                    Predefine Search
                                </label>
                                <div class="col-md-4">
                                    <textarea name="PredefineSearch"
                                              class="form-control"> <?= $PredefineSearch = (isset($getTableDetails['PredefineSearch'])) ? $getTableDetails['PredefineSearch'] : ""; ?></textarea>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="control-label col-md-3">
                                    Invisible Predefine Search value
                                </label>
                                <div class="col-md-4">
                                    <textarea name="InvisiblePredefineSearch"
                                              class="form-control"> <?= $InvisiblePredefineSearch = (isset($getTableDetails['InvisiblePredefineSearch'])) ? $getTableDetails['InvisiblePredefineSearch'] : ""; ?></textarea>
                                </div>
                            </div>
                             <div class="form-group row">
                                <label class="control-label col-md-3">
                                    Allow predefine Search on Range Filter
                                </label>

                                <div class="col-md-9">
                                    <div class="col-md-12 padding_none">
                                        <div class="checkboxes" id="ChangeChkBox">
                                            <?php
                                            $rangePredefineSearchFlag = (isset($getTableDetails["RangePredefineSearchFlag"])) ? $getTableDetails["RangePredefineSearchFlag"] : 0;
                                            $checked = "";
                                            if ($rangePredefineSearchFlag) {
                                                $checked = "checked='checked'";
                                            }
                                            ?>
                                            <label>
                                                <input type="checkbox" <?= $checked; ?> name="RangePredefineSearchFlag" value="1"/>
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="control-label col-md-3">
                                    Predefine Search for Range Filter
                                </label>
                                <div class="col-md-4">
                                    <textarea name="PredefineSearchForRange"
                                              class="form-control"> <?= $PredefineSearch = (isset($getTableDetails['PredefineSearchForRange'])) ? $getTableDetails['PredefineSearchForRange'] : ""; ?></textarea>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="control-label col-md-3">
                                   Predefine Sort
                                </label>

                                <div class="col-md-4">
                                    <select name="PredefineSort[]" id="PredefineSort" class="form-control select2-multiple dataSourceColumns" 
                                    data-maximum-selection-length="1" 
                                    data-reorder="1" multiple
                                            >
                                        <option value="">Select</option>
                                        <?php if ($existingColumnsOfPredefineSort) {
                                            $getTablePredefineSortColumn = isset($getTableDetails['PredefineSort'])? $getTableDetails['PredefineSort']:'';


                                            if ($getTablePredefineSortColumn) {
                                                $getTablePredefineSortColumn = explode(',', $getTablePredefineSortColumn);
                                            }
                                            $existingColumnsOfPredefineSort = explode(',', $existingColumnsOfPredefineSort);
                                            if ($existingColumnsOfPredefineSort) {
                                                foreach ($existingColumnsOfPredefineSort as $key => $value) {
                                                    $selected = "";
                                                    $value = trim($value);
                                                    if (!empty($getTablePredefineSortColumn) && in_array($value, $getTablePredefineSortColumn)) {
                                                        $selected = 'selected="selected"';
                                                        }
                                                    echo '<option value=' . $value . ' ' . $selected . '>' . $value . '</option>';
                                                }
                                            }
                                            ?>
                                        <?php } ?>
                                    </select>
                                
                                </div>
                            </div>
                          
                            <div class="form-group row">
                                <label class="control-label col-md-3">
                                    Order for Predefine Sort
                                </label>

                                <div class="col-md-4">
                                    <select name="PredefineSortOrder" id="PredefineSortOrder"
                                            class="form-control dataSourceColumns"  data-reorder="1" 
                                            >
                                        <?php $selected1 = '' ;
                                            $selected = ''; ?>
                                        <option value="">Select</option>
                                        <?php 


                                        if(isset($getTableDetails['PredefineSortOrder']) && $getTableDetails['PredefineSortOrder'] == 'desc'){
                                            $selected = 'selected="selected"';
                                        } 

                                        if(empty($selected))
                                        {
                                            $selected1 = 'selected="selected"';
                                        }

                                        
                                        
                                        ?>
                                        <option value= "asc" <?php echo $selected1; ?> >Asc</option>
                                        <option value="desc" <?php echo $selected ;?> >Desc</option>;
                                           
                                    </select>
                                </div>
                            </div>
                          
                            <div class="form-group row">
                                <label class="control-label col-md-3">
                                    Hide Columns
                                </label>

                                <div class="col-md-4">
                                    <select name="HideColumn[]" id="HideColumn"
                                            class="form-control select2-multiple dataSourceColumns"  data-reorder="1" multiple
                                            >
                                        <option value="">Select</option>
                                        <?php if ($existingColumnsOfHideColumn) {
                                            $getTableColumnsHideColumn = isset($getTableDetails['HideColumn'])? $getTableDetails['HideColumn']:'';


                                            if ($getTableColumnsHideColumn) {
                                                $getTableColumnsHideColumn = explode(',', $getTableColumnsHideColumn);
                                            }
                                            $existingColumnsOfHideColumn = explode(',', $existingColumnsOfHideColumn);
                                            if ($existingColumnsOfHideColumn) {
                                                foreach ($existingColumnsOfHideColumn as $key => $value) {
                                                    $selected = "";
                                                    $value = trim($value);
                                                    if (!empty($getTableColumnsHideColumn) && in_array($value, $getTableColumnsHideColumn)) {
                                                        $selected = 'selected="selected"';
                                                        }
                                                    echo '<option value= "' . $value . '"' . $selected . '>' . $value . '</option>';
                                                }
                                            }
                                            ?>
                                        <?php } ?>
                                    </select>
                                
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="control-label col-md-3">
                                    Include zero from these column
                                </label>

                                <div class="col-md-4">
                                    <select name="ExcludeZeroCol[]" id="ExcludeZeroMultiple"
                                            class="form-control select2-multiple dataSourceColumns" data-reorder="1" multiple
                                            >
                                        <option value="">Select</option>
                                        <?php if ($existingColumnsOfExcludeZero) {
                                            $getTableExcludeZero = isset($getTableDetails['ExcludeZeroCol'])? $getTableDetails['ExcludeZeroCol']:'';


                                            if ($getTableExcludeZero) {
                                                $getTableExcludeZero = explode(',', $getTableExcludeZero);
                                            }
                                            $existingColumnsOfExcludeZero = explode(',', $existingColumnsOfExcludeZero);
                                            if ($existingColumnsOfExcludeZero) {
                                                foreach ($existingColumnsOfExcludeZero as $key => $value) {
                                                    $selected = "";
                                                    $value = trim($value);
                                                    if (!empty($getTableExcludeZero) && in_array($value, $getTableExcludeZero)) {
                                                        $selected = 'selected="selected"';
                                                    }
                                                    echo '<option value= "' . $value . '"' . $selected . '>' . $value . '</option>';
                                                }
                                            }
                                            ?>
                                        <?php } ?>
                                    </select>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="control-label col-md-3">
                                      No of rows displayed       
                                </label>

                                <div class="col-md-4">
                                    <input type="text" name="RowsCount" 
                                           value="<?= $RowsCount = (isset($getTableDetails['RowsCount'])) ? $getTableDetails['RowsCount'] : ""; ?>"
                                           class="form-control"/>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="control-label col-md-3">
                                    Allow Table Edit 
                                </label>

                                <div class="col-md-9">
                                    <div class="col-md-12 padding_none">
                                        <div class="checkboxes" id="ChangeChkBox">
                                            <?php
                                            $EnableCrudCSV = (isset($getTableDetails["EnableCrudCSV"])) ? $getTableDetails["EnableCrudCSV"] : 0;
                                            $checked = "";
                                            if ($EnableCrudCSV) {
                                                $checked = "checked='checked'";
                                            }
                                            ?>
                                            <label>
                                                <input type="checkbox" <?= $checked; ?> name="EnableCrudCSV" value="1"/>
                                            </label>
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
<script type="text/javascript">
    $('#ChangeChkBox').change(function(){
    if(this.checked)
        $('#ChangeChkBox').val('0');
   else
        $('#ChangeChkBox').val('1');
});
</script>
<?php include_once realpath(__DIR__ . '/../..') . '/layout/Admin_Layout/footer_start.php'; ?>