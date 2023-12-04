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
                                        <option value="1" <?php if ($tableType == 1) {
                                            echo "selected='selected'";
                                        } ?>>Ordinary table
                                        </option>
                                        <option value="2" <?php if ($tableType == 2) {
                                            echo "selected='selected'";
                                        } ?>>Editable tabel
                                        </option>
                                        <option value="3" <?php if ($tableType == 3) {
                                            echo "selected='selected'";
                                        } ?>>Join table
                                        </option>
                                        <option value="4" <?php if ($tableType == 4) {
                                            echo "selected='selected'";
                                        } ?>>Slider Table
                                        </option>
                                        <option value="5" <?php if ($tableType == 5) {
                                            echo "selected='selected'";
                                        } ?>>Slider Table 2
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
                                            $existingColumnsOfGroupRowLevel = "";
                                            $existingColumnsOfGroupRowLevelAddmore = "";
                                            $existingColumnsOfHideColumn = "";
                                            $existingColumnsOfPredefineSort = '';
                                            $existingColumnsOfColWidth = '';
                                            $existingColumnsOfDataGroup= '';
                                            $existingColumnsOfAllow3charSearch = '';
                                            
                                            
                                            ?>
                                            <?php foreach ($getDataSource as $key => $eachDataSource) {
                                                
                                                
                                                $selected = '';
                                               
                                                if (in_array($eachDataSource['ID'], $getDataSourceId)){
                                                    $selected = 'selected="selected"';
                                                    
                                                   
                                                    if($eachDataSource['ApiType'] == '2')
                                                    {
                                                        $newColumn  = explode( ',' , $eachDataSource["DisplayColumnName"]) ;
                                                        foreach($newColumn  as $ke => $val){
                                                            $newColumn[$ke] = trim($eachDataSource["Name"]).'-'.trim($val);
                                                        }
                                                        $newColumn = implode(',', $newColumn);
                                                    }else{
                                                        $newColumn  = explode( ',' , $eachDataSource["Columns"] ) ;
                                                        foreach($newColumn  as $ke => $val){
                                                            $newColumn[$ke] = trim($eachDataSource["Name"]).'-'.trim($val);
                                                        }
                                                        $newColumn = implode(',', $newColumn);
                                                      
                                                    }
                                                    
                                                    if($existingColumnsOfDataSource != ''){
                                                        $existingColumnsOfDataSource .= ','.$newColumn;
                                                                                                        
                                                    }else{
                                                        $existingColumnsOfDataSource .= $newColumn;
                                                                                                        
                                                    }
                                                    if($existingColumnsOfDataSourceFooter != ''){
                                                        $existingColumnsOfDataSourceFooter .= ','.$newColumn;                                                   
                                                    }else{
                                                        $existingColumnsOfDataSourceFooter .= $newColumn;                                                    
                                                    }

                                                    if($existingColumnsOfExcludeZero != ''){
                                                        $existingColumnsOfExcludeZero .= ','.$newColumn;                                                   
                                                    }else{
                                                        $existingColumnsOfExcludeZero .= $newColumn;                                                   
                                                    }
                                                    if( $existingColumnsOfColWidth != ''){
                                                        $existingColumnsOfColWidth .= ','.$newColumn;                                                   
                                                    }else{
                                                        $existingColumnsOfColWidth .= $newColumn;                                                   
                                                    }
                                                    
                                                   
                                                    if($existingColumnsOfGroupRow != ''){
                                                        $existingColumnsOfGroupRow .= ','.$newColumn;                                                   
                                                    }else{
                                                        $existingColumnsOfGroupRow .= $newColumn;                                                   
                                                    }
                                                    if($existingColumnsOfGroupRowLevel != ''){
                                                        $existingColumnsOfGroupRowLevel .= ','.$newColumn;                                                   
                                                    }else{
                                                        $existingColumnsOfGroupRowLevel .= $newColumn;                                                   
                                                    }
                                                   
                                                    if($existingColumnsOfGroupRowLevelAddmore != ''){
                                                        $existingColumnsOfGroupRowLevelAddmore .= ','.$newColumn;                                                   
                                                    }else{
                                                        $existingColumnsOfGroupRowLevelAddmore .= $newColumn;                                                   
                                                    }
                                                    if($existingColumnsOfDataGroup != ''){
                                                        $existingColumnsOfDataGroup .= ','.$newColumn;                                                   
                                                    }else{
                                                        $existingColumnsOfDataGroup .= $newColumn;                                                   
                                                    }
                                                    if($existingColumnsOfAllow3charSearch != ''){
                                                        $existingColumnsOfAllow3charSearch .= ','.$newColumn;                                                   
                                                    }else{
                                                        $existingColumnsOfAllow3charSearch .= $newColumn;                                                   
                                                    }
                                                    
                                                    if($existingColumnsOfHideColumn != ''){
                                                        $existingColumnsOfHideColumn .= ','.$newColumn;                                                   
                                                    }else{
                                                        $existingColumnsOfHideColumn .= $newColumn;                                                   
                                                    }
                                                    
                                                    if($existingColumnsOfPredefineSort != ''){
                                                            $existingColumnsOfPredefineSort .= ','.$newColumn;                                                  
                                                    }else{
                                                        $existingColumnsOfPredefineSort .= $newColumn;                                                
                                                    }
                                                }
                                                ?>
                                                <option <?= $selected; ?>
                                                    value="<?= $eachDataSource['ID']; ?>"><?= $eachDataSource['Name']; ?></option>
                                            <?php 
                                            }   ?>
                                        <?php } ?>
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
                                            $existingColumnsOfGroupRowLevel = "";
                                            $existingColumnsOfGroupRowLevelAddmore = "";
                                            $existingColumnsOfHideColumn = "";
                                            $existingColumnsOfPredefineSort = '';
                                            $existingColumnsOfColorMarking = '';
                                            $existingColumnsOfColWidth = '';
                                            $existingColumnsOfDataGroup='';
                                            $existingColumnsOfAllow3charSearch = '';
                                            
                                                    
                                            ?>
                                            <?php foreach ($getDataSource as $key => $eachDataSource) {

                                                $selected = '';
                                                if ($getDataSourceId == $eachDataSource['ID']) {
                                                    $selected = 'selected="selected"';
                                                    $existingColumnsOfDataSource = ($eachDataSource['ApiType'] == '2') ?$eachDataSource["DisplayColumnName"]:$eachDataSource["Columns"];
                                                    $existingColumnsOfDataSourceFooter = (!empty($eachDataSource['ApiType']) && ($eachDataSource['ApiType']) == '2') ?$eachDataSource["DisplayColumnName"]:$eachDataSource["Columns"];
                                                    $existingColumnsOfExcludeZero = (!empty($eachDataSource['ApiType']) && ($eachDataSource['ApiType']) == '2') ?$eachDataSource["DisplayColumnName"]:$eachDataSource["Columns"];
                                                    $existingColumnsOfGroupRow = (!empty($eachDataSource['ApiType']) && ($eachDataSource['ApiType']) == '2') ?$eachDataSource["DisplayColumnName"]:$eachDataSource["Columns"];
                                                    $existingColumnsOfGroupRowLevel = (!empty($eachDataSource['ApiType']) && ($eachDataSource['ApiType']) == '2') ?$eachDataSource["DisplayColumnName"]:$eachDataSource["Columns"];
                                                    $existingColumnsOfGroupRowLevelAddmore = (!empty($eachDataSource['ApiType']) && ($eachDataSource['ApiType']) == '2') ?$eachDataSource["DisplayColumnName"]:$eachDataSource["Columns"];
                                                    $existingColumnsOfHideColumn = (!empty($eachDataSource['ApiType']) && ($eachDataSource['ApiType']) == '2') ?$eachDataSource["DisplayColumnName"]:$eachDataSource["Columns"];
                                                    $existingColumnsOfPredefineSort= (!empty($eachDataSource['ApiType']) && ($eachDataSource['ApiType']) == '2') ?$eachDataSource["DisplayColumnName"]:$eachDataSource["Columns"];
                                                    $existingColumnsOfColorMarking= (!empty($eachDataSource['ApiType']) && ($eachDataSource['ApiType']) == '2') ?$eachDataSource["DisplayColumnName"]:$eachDataSource["Columns"];
                                                    $existingColumnsOfColWidth = (!empty($eachDataSource['ApiType']) && ($eachDataSource['ApiType']) == '2') ?$eachDataSource["DisplayColumnName"]:$eachDataSource["Columns"];
                                                    $existingColumnsOfDataGroup= (!empty($eachDataSource["DisplayColumnName"])) ?$eachDataSource["DisplayColumnName"]:$eachDataSource["Columns"];
                                                    $existingColumnsOfAllow3charSearch= (!empty($eachDataSource['ApiType']) && ($eachDataSource['ApiType']) == '2') ?$eachDataSource["DisplayColumnName"]:$eachDataSource["Columns"];
                                                   // $existingColumnsOfD= (!empty($eachDataSource['ApiType']) && ($eachDataSource['ApiType']) == '2') ?$eachDataSource["DisplayColumnName"]:$eachDataSource["Columns"];
                                                    
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
                                    Columns that need to be combined for matching (Join Table)
                                    
                                </label>

                                <div class="col-md-4">
                                    <select name="ColumnsMatching[]" id="multiple"
                                            class="form-control select2-multiple dataSourceColumns" data-reorder="1" multiple
                                            >
                                        <option value="">Select</option>
                                        <?php
                                        
                                         if ($existingColumnsOfDataSource) {
                                            $getTableColumns = $getTableDetails['ColumnsMatching'];
                                           
                                           
                                            if ($getTableColumns) {
                                                $getTableColumns = explode(',', $getTableColumns);
                                            }
                                            
                                            $existingColumnsOfDataSource1 = explode(',', $existingColumnsOfDataSource);
                                          
                                            if ($existingColumnsOfDataSource1) {
                                                foreach ($existingColumnsOfDataSource1 as $key => $value) {
                                                    $selected = "";
                                                    $value = trim($value);
                                                    if (!empty($getTableColumns) && in_array($value, $getTableColumns)) {
                                                        $selected = 'selected="selected"';
                                                    }

                                                    echo '<option value= "'. $value . '"'. $selected . '>' . $value . '</option>';

                                                }
                                            }
                                            ?>
                                        <?php } ?>
                                    </select>
                                </div>
                                <div class="col-md-4">
                                    <select name="ColumnsToBeMatched[]" id="multiple"
                                            class="form-control select2-multiple dataSourceColumns" data-reorder="1" multiple
                                            >
                                        <option value="">Select</option>
                                        <?php
                                        
                                         if ($existingColumnsOfDataSource) {
                                            $getTableColumns = '';
                                            $getTableColumns = $getTableDetails['ColumnsToBeMatched'];
                                           
                                           
                                            if ($getTableColumns) {
                                                $getTableColumns = explode(',', $getTableColumns);
                                            }
                                            
                                            $existingColumnsOfDataSource1 = explode(',', $existingColumnsOfDataSource);
                                          
                                            if ($existingColumnsOfDataSource1) {
                                                foreach ($existingColumnsOfDataSource1 as $key => $value) {
                                                    $selected = "";
                                                    $value = trim($value);
                                                    if (!empty($getTableColumns) && in_array($value, $getTableColumns)) {
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
                                    <select name="Columns[]" id="multipleCol"
                                            class="form-control select2-multiple dataSourceColumns" data-reorder="1" multiple
                                            required="">
                                        <option value="">Select</option>
                                        <?php
                                        $getTableColumns = '';
                                         if ($existingColumnsOfDataSource) {
                                            $getTableColumns = $getTableDetails['Columns'];
                                           
                                           
                                            if ($getTableColumns) {
                                                $getTableColumns = explode(',', $getTableColumns);
                                                $TempexistingColumnsOfDataSource = explode(',', $existingColumnsOfDataSource);
                                                //$DiffCol = array_diff($TempexistingColumnsOfDataSource , $getTableColumns);
                                                $DiffCol = array();
                                                foreach ($TempexistingColumnsOfDataSource as $DSkey => $DSvalue) {
                                                        if(!in_array(trim($DSvalue), $getTableColumns)){
                                                            $DiffCol[] = trim($DSvalue);
                                                        }
                                                }
                                               
                                                $existingColumnsOfDataSource = array_merge($getTableColumns , $DiffCol) ;

                                            }else{
                                                $existingColumnsOfDataSource = explode(',', $existingColumnsOfDataSource);
                                            }
                                         
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
                                    <input type="button" value="Select All Column"  onclick="selectAll()"> 
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
                                   
                                </label>

                                <div class="col-md-4">
                                    <select name="ColumnsFooter[]" id="ColumnsFootermultiple"
                                            class="form-control select2-multiple dataSourceColumns" data-reorder="1" multiple
                                            >
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
                                    Enable Sigle Row Group 
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
                            <div class="form-group row" id = 'SingleRowGroup'>
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
                                    Enable Levels
                                </label>

                                <div class="col-md-9">

                                    <div class="col-md-12 padding_none">
                                        <div class="checkboxes" id="ChangeChkBox">
                                            <?php
                                            $EnableRowGroupLevel = (isset($getTableDetails["EnableRowGroupLevel"])) ? $getTableDetails["EnableRowGroupLevel"] : 0;
                                            $checked = "";
                                            if ($EnableRowGroupLevel) {
                                                $checked = "checked='checked'";
                                            }
                                            ?>
                                            <label>
                                                <input type="checkbox" <?= $checked; ?> name="EnableRowGroupLevel" value="1"   onchange="ShowRowLevel(this)"/>
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div> 
                            <div id = 'MainDiv' <?php if (!isset($getTableDetails["EnableRowGroupLevel"]) ) { ?>style="display:none" <?php } ?>>
                                <?php $LevelsColumn  = isset($getTableDetails["RowGroupLevelColumns"] )?json_decode($getTableDetails["RowGroupLevelColumns"] , true): '' ;
                                $key =1;
                                ?>
                                
                                <?php if($LevelsColumn && $LevelsColumn != '' ) {
                                    $cnt = 1;
                                    
                                    $existingColumnsOfGroupRowLevel = isset($existingColumnsOfGroupRowLevel)?explode(',', $existingColumnsOfGroupRowLevel):'';
                                    
                                                                
                                    foreach($LevelsColumn as $LevelsColumnKey => $LevelsColumnVal){ ?>
                                        <div id = 'RowGroupLevel<?php echo $cnt;?>'>
                                            <div class="form-group row" >     
                                                <label class="control-label col-md-3">
                                                    Level <?php echo $cnt;?>
                                                </label>

                                                <div class="col-md-4">
                                                    <select name="RowGroupLevelColumns<?php echo $cnt;?>" id="GroupRowsColumn<?php echo $cnt;?>"
                                                        class="form-control select2-multiple dataSourceColumns" data-reorder="1" multiple data-maximum-selection-length="1" >
                                                        <option value="">Select</option>
                                                        <?php if ($existingColumnsOfGroupRowLevel) {
                                                            
                                                                foreach ($existingColumnsOfGroupRowLevel as $key => $value) {
                                                                    $selected = "";
                                                                    $value = trim($value);
                                                                
                                                                    if ( isset($LevelsColumn['level'.$cnt]) && $LevelsColumn != ' ' && $value == $LevelsColumn['level'.$cnt]) {
                                                                        $selected = 'selected="selected"';
                                                                        }
                                                                    echo '<option value= "' . $value . '"' . $selected . '>' . $value . '</option>';
                                                                }
                                                            
                                                        
                                                            ?>
                                                        <?php } ?>
                                                    </select>
                                                    
                                                </div>
                                                
                                            </div>
                                        </div>
                                <?php $cnt = $cnt+1; } $key = $cnt -1;
                                } else { ?>
                                    <div id = 'RowGroupLevel1'>
                                        <div class="form-group row" >     
                                            <label class="control-label col-md-3">
                                                Level 1
                                            </label>

                                            <div class="col-md-4">
                                                <select name="RowGroupLevelColumns1" id="GroupRowsColumn"
                                                    class="form-control select2-multiple dataSourceColumns" data-reorder="1" multiple data-maximum-selection-length="1" >
                                                    <option value="">Select</option>
                                                    <?php if ($existingColumnsOfGroupRowLevel) {
                                                        
                                                        $existingColumnsOfGroupRowLevel = explode(',', $existingColumnsOfGroupRowLevel);
                                                        //if ($existingColumnsOfGroupRow) {
                                                            foreach ($existingColumnsOfGroupRowLevel as $key => $value) {
                                                                $selected = "";
                                                                $value = trim($value);
                                                            
                                                                if ( isset($LevelsColumn['level1']) && $LevelsColumn != ' ' && $value == $LevelsColumn['level1']) {
                                                                    $selected = 'selected="selected"';
                                                                    }
                                                                echo '<option value= "' . $value . '"' . $selected . '>' . $value . '</option>';
                                                            }
                                                        
                                                    // }
                                                        ?>
                                                    <?php } ?>
                                                </select>
                                                
                                            </div>
                                            
                                        </div>
                                    </div>
                                <?php } ?>
                                <div class="form-group row">
                                    <label class="control-label col-md-3">
                                        
                                    </label>

                                    <div class="col-md-9">
                                    <input type="hidden" name="RowGroupLevelCount"  id="RowGroupLevelCount" value="<?php echo $key;?>"  class="form-control"/>
                                    <button  type="button" id = "AddLevel" onclick="AddRowLevel()" >  Add more Levels</button> 
                                    <button  type="button" id = "DeleteLevel" onclick="DeleteRowLevel()" > Delete Levels</button> 
                                            
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
                                            $getTableColumnsRowGroup = isset($getTableDetails['PredefineSort'])? $getTableDetails['PredefineSort']:'';


                                            if ($getTableColumnsRowGroup) {
                                                $getTableColumnsRowGroup = explode(',', $getTableColumnsRowGroup);
                                            }
                                            $existingColumnsOfPredefineSort = explode(',', $existingColumnsOfPredefineSort);
                                            if ($existingColumnsOfPredefineSort) {
                                                foreach ($existingColumnsOfPredefineSort as $key => $value) {
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
                                    Allow CSV Import
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
                            <div class="form-group row">
                                <label class="control-label col-md-3">
                                    Check only if you want to use the Default DB table to be Editable
                                </label>

                                <div class="col-md-9">
                                    <div class="col-md-12 padding_none">
                                        <div class="checkboxes" id="ChangeChkBox">
                                            <?php
                                            $EnableCrudCSV = (isset($getTableDetails["EnableDefaultCrudCSV"])) ? $getTableDetails["EnableCrudCSV"] : 0;
                                            $checked = "";
                                            if ($EnableCrudCSV) {
                                                $checked = "checked='checked'";
                                            }
                                            ?>
                                            <label>
                                                <input type="checkbox" <?= $checked; ?> name="EnableDefaultCrudCSV" value="1"/>
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="control-label col-md-3">
                                    Allow Custom Filter Width for all Column 
                                </label>

                                <div class="col-md-9">
                                    <div class="col-md-12 padding_none">
                                        <div class="checkboxes" id="ChangeChkBox">
                                            <?php
                                            $EnableFilterWidth = (isset($getTableDetails["EnableFilterWidth"])) ? $getTableDetails["EnableFilterWidth"] : 0;
                                            $checked = "";
                                            if ($EnableFilterWidth) {
                                                $checked = "checked='checked'";
                                            }
                                            ?>
                                            <label>
                                                <input type="checkbox" <?= $checked; ?> name="EnableFilterWidth" value="1"/>
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                           

                            <div class="form-group row">
                                <label class="control-label col-md-3">
                                   Table Design 
                                </label>

                                <div class="col-md-4">
                                    <select name="TableDesign" id="TableDesign"
                                            class="form-control  "  data-reorder="1" 
                                            onchange="showScrollFields(this.value);" >
                                            <?php 
                                             $selected = '';
                                            if ( isset($getTableDetails["TableDesign"]) &&  $getTableDetails['TableDesign'] != '') {
                                                 $selected = 'selected="selected"';
                                            } ?>
                                        <option value="" <?php echo  $selected?> >Select</option>
                                        <option value="0" <?php if( isset($getTableDetails["TableDesign"]) && $getTableDetails['TableDesign'] == 0){ echo  $selected ;}?>>Ordinay</option>
                                        <option value="1" <?php if( isset($getTableDetails["TableDesign"]) && $getTableDetails['TableDesign'] == 1){ echo  $selected ;}?>>Scroll</option>
                                        
                                        
                                    </select>
                                
                                </div>
                            </div>
                            <div class="form-group row" id="ScrollDesignWidth" style="display:none">
                                <label class="control-label col-md-3">
                                   Table Scroll Height
                                </label>

                                <div class="col-md-4">
                                    <input type="text" name="ScrollWidth" 
                                           value="<?= $ScrollWidth = (isset($getTableDetails['ScrollWidth'])) ? $getTableDetails['ScrollWidth'] : ""; ?>"
                                           class="form-control"/>
                                </div>
                            </div>
                            <div class="form-group row" id="FooterSumLocation" style="display:none" >
                                <label class="control-label col-md-3">
                                  Footer Sum Location
                                </label>

                                <div class="col-md-4">
                                    <select name="FooterSumLocation" 
                                            class="form-control  "  data-reorder="1" 
                                            >
                                            <?php 
                                             $selected = '';
                                            if ( isset($getTableDetails["FooterSumLocation"]) &&  $getTableDetails['FooterSumLocation'] != '') {
                                                 $selected = 'selected="selected"';
                                            } ?>
                                        <option value="" <?php echo  $selected?> >Select</option>
                                        <option value="0" <?php if( isset($getTableDetails["FooterSumLocation"]) && $getTableDetails['FooterSumLocation'] == 0){ echo  $selected ;}?>>Header</option>
                                        <option value="1" <?php if( isset($getTableDetails["FooterSumLocation"]) && $getTableDetails['FooterSumLocation'] == 1){ echo  $selected ;}?>>Bottom</option>
                                        
                                        
                                    </select>
                                
                                </div>
                            </div>
                            <div class="form-group row" id="PaginationFlag" style="display:none" >
                                <label class="control-label col-md-3">
                                    Hide Pagination
                                </label>

                                <div class="col-md-9">
                                    <div class="col-md-12 padding_none">
                                        <div class="checkboxes" id="ChangeChkBox">
                                            <?php
                                            $PaginationFlag = (isset($getTableDetails["PaginationFlag"])) ? $getTableDetails["PaginationFlag"] : 0;
                                            $checked = "";
                                            if ($PaginationFlag) {
                                                $checked = "checked='checked'";
                                            }
                                            ?>
                                            <label>
                                                <input type="checkbox" <?= $checked; ?> name="PaginationFlag" value="1"/>
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="control-label col-md-3">
                                    Allow child rows (Default)
                                </label>

                                <div class="col-md-9">
                                    <div class="col-md-12 padding_none">
                                        <div class="checkboxes" id="ChangeChkBox">
                                            <?php
                                            $EnableChildRows = (isset($getTableDetails["EnableChildRows"])) ? $getTableDetails["EnableChildRows"] : 0;
                                            $checked = "";
                                            if ($EnableChildRows) {
                                                $checked = "checked='checked'";
                                            }
                                            ?>
                                            <label>
                                                <input type="checkbox" <?= $checked; ?> name="EnableChildRows" value="1"/>
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div> 
                            <div class="form-group row">
                                <label class="control-label col-md-3">
                                    Allow child rows (at run tym on click )
                                </label>

                                <div class="col-md-9">
                                    <div class="col-md-12 padding_none">
                                        <div class="checkboxes" id="ChangeChkBox">
                                            <?php
                                            $EnableChildRowsRunTym = (isset($getTableDetails["EnableChildRowsRunTym"])) ? $getTableDetails["EnableChildRowsRunTym"] : 0;
                                            $checked = "";
                                            if ($EnableChildRowsRunTym) {
                                                $checked = "checked='checked'";
                                            }
                                            ?>
                                            <label>
                                                <input type="checkbox" <?= $checked; ?> name="EnableChildRowsRunTym" value="1"/>
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div> 
                            <div class="form-group row">
                                <label class="control-label col-md-3">
                                    Filter Session Enable 
                                </label>

                                <div class="col-md-9">
                                    <div class="col-md-12 padding_none">
                                        <div class="checkboxes" id="ChangeChkBox">
                                            <?php
                                            $FilterSessionEnable = (isset($getTableDetails["FilterSessionEnable"])) ? $getTableDetails["FilterSessionEnable"] : 0;
                                            $checked = "";
                                            if ($FilterSessionEnable) {
                                                $checked = "checked='checked'";
                                            }
                                            ?>
                                            <label>
                                                <input type="checkbox" <?= $checked; ?> name="FilterSessionEnable" value="1"/>
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="control-label col-md-3">
                                    Enable Live Img Sync
                                </label>

                                <div class="col-md-9">
                                    <div class="col-md-12 padding_none">
                                        <div class="checkboxes" id="ChangeChkBox">
                                            <?php
                                            $EnableLiveImgSync = (isset($getTableDetails["EnableLiveImgSync"])) ? $getTableDetails["EnableLiveImgSync"] : 0;
                                            $checked = "";
                                            if ($EnableLiveImgSync) {
                                                $checked = "checked='checked'";
                                            }
                                            ?>
                                            <label>
                                                <input type="checkbox" <?= $checked; ?> name="EnableLiveImgSync" value="1"/>
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="control-label col-md-3">
                                    Show Excel + PAC button 
                                </label>

                                <div class="col-md-9">
                                    <div class="col-md-12 padding_none">
                                        <div class="checkboxes" id="ChangeChkBox">
                                            <?php
                                            $EnableExcelBtn = (isset($getTableDetails["EnableExcelBtn"])) ? $getTableDetails["EnableExcelBtn"] : 0;
                                            $checked = "";
                                            if ($EnableExcelBtn) {
                                                $checked = "checked='checked'";
                                            }
                                            ?>
                                            <label>
                                                <input type="checkbox" <?= $checked; ?> name="EnableExcelBtn" value="1"/>
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="control-label col-md-3">
                                    Enable XML download
                                </label>

                                <div class="col-md-9">
                                    <div class="col-md-12 padding_none">
                                        <div class="checkboxes" id="ChangeChkBox">
                                            <?php
                                            $XMLdownload = (isset($getTableDetails["XMLdownload"])) ? $getTableDetails["XMLdownload"] : 0;
                                            $checked = "";
                                            if ($XMLdownload) {
                                                $checked = "checked='checked'";
                                            }
                                            ?>
                                            <label>
                                                <input type="checkbox" <?= $checked; ?> name="XMLdownload" value="1"/>
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="control-label col-md-3">
                                     Use Dynamic Form 
                                </label>

                                <div class="col-md-9">
                                    <div class="col-md-12 padding_none">
                                        <div class="checkboxes" id="ChangeChkBox">
                                            <?php
                                            $AllowDynamicForm = (isset($getTableDetails["AllowDynamicForm"])) ? $getTableDetails["AllowDynamicForm"] : 0;
                                            $checked = "";
                                            if ($AllowDynamicForm) {
                                                $checked = "checked='checked'";
                                            }
                                            ?>
                                            <label>
                                                <input type="checkbox" <?= $checked; ?> name="AllowDynamicForm" value="1"/>
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group row"  >
                                <label class="control-label col-md-3">
                                        Dynamic Form
                                </label>

                                <div class="col-md-4">
                                    <select name="DynamicFormName" 
                                            class="form-control  "  data-reorder="1" 
                                            >
                                            <?php 
                                             $selected = '';
                                             $formdata = isset($getTableDetails["DynamicFormName"])?$getTableDetails["DynamicFormName"]: '';
                                            if (isset($getTableDetails["DynamicFormName"]) &&  $getTableDetails['DynamicFormName'] != '') {
                                                 $selected = 'selected="selected"';
                                            } ?>
                                        <option value="" <?php echo  $selected?> >Select</option>
                                        <?php foreach($GetDynamicForm as $dynmicKey => $dynamicVal){?>
                                            <option value="<?php echo $dynamicVal['ID']?>" <?php if( isset($getTableDetails["DynamicFormName"]) && $dynamicVal['ID'] ==  $formdata){ echo  $selected ;}?>><?= $dynamicVal['Name'] ;?></option>
                                       
                                        <?php } ?>
                                        
                                        
                                    </select>
                                
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="control-label col-md-3">
                                     Use Dynamic Form For Action Button
                                </label>

                                <div class="col-md-9">
                                    <div class="col-md-12 padding_none">
                                        <div class="checkboxes" id="ChangeChkBox">
                                            <?php
                                            $EnableFormOnActionBTN = (isset($getTableDetails["EnableFormOnActionBTN"])) ? $getTableDetails["EnableFormOnActionBTN"] : 0;
                                            $checked = "";
                                            if ($EnableFormOnActionBTN) {
                                                $checked = "checked='checked'";
                                            }
                                            ?>
                                            <label>
                                                <input type="checkbox" <?= $checked; ?> name="EnableFormOnActionBTN" value="1"/>
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="form-group row"  >
                                <label class="control-label col-md-3">
                                         Orignal form Button Title 
                                </label>
                                <div class="col-md-4">
                                    <input type="text" name="NameOrgBtn" 
                                           value="<?= $Name = (isset($getTableDetails['NameOrgBtn'])) ? $getTableDetails['NameOrgBtn'] : ""; ?>"
                                           class="form-control"/>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="control-label col-md-3">
                                    Enable One of dynamic form search 
                                </label>
                                <div class="col-md-4">
                                        <!-- <select name="EnableLastSearchDF" class="form-control"  data-reorder="1" >
                                                <?php 
                                                $selected = '';
                                                $EnableLastSearchDF = isset($getTableDetails["EnableLastSearchDF"])?$getTableDetails["EnableLastSearchDF"]: '';
                                                if (isset($getTableDetails["EnableLastSearchDF"]) &&  $getTableDetails['EnableLastSearchDF'] != '') {
                                                    $selected = 'selected="selected"';
                                                } ?>
                                            <option value="" <?php echo  $selected?> >Select</option>
                                            <option value="1" <?php if( isset($getTableDetails["EnableLastSearchDF"]) && $getTableDetails["EnableLastSearchDF"] ==  '1'){ echo  $selected ;}?> >Original Selection </option>
                                            <option value="2" <?php if( isset($getTableDetails["EnableLastSearchDF"]) && $getTableDetails["EnableLastSearchDF"] ==  '2'){ echo  $selected ;}?> >Make Selection</option>
                                        </select> -->

                                        <select name="EnableLastSearchDF[]" id="EnableLastSearchDF"
                                                class="form-control select2-multiple " data-reorder="1" multiple
                                                >
                                            <?php 
                                            $selected = '';
                                            $EnableLastSearchDF = isset($getTableDetails["EnableLastSearchDF"])?$getTableDetails["EnableLastSearchDF"]: '';
                                            if (isset($getTableDetails["EnableLastSearchDF"]) &&  $getTableDetails['EnableLastSearchDF'] != '') {
                                                $selected = 'selected="selected"';
                                            } ?>
                                            
                                            <option value="1" <?php if( isset($getTableDetails["EnableLastSearchDF"]) && $getTableDetails["EnableLastSearchDF"] ==  '1' || (isset($getTableDetails["EnableLastSearchDF"]) && $getTableDetails["EnableLastSearchDF"] == '12')){ echo  $selected ;}?> >Make Selection </option>
                                            <option value="2" <?php if( isset($getTableDetails["EnableLastSearchDF"]) && $getTableDetails["EnableLastSearchDF"] ==  '2' || ( isset($getTableDetails["EnableLastSearchDF"]) && $getTableDetails["EnableLastSearchDF"] == '12') ){ echo  $selected ;}?> >Original Selection</option>
                                        
                                
                                        </select>
                                    
                                </div>

                            </div>
                            <div class="form-group row"  id="lastSeacrhBtn" >
                                <label class="control-label col-md-3">
                                         Last search form Button Title 
                                </label>
                                <div class="col-md-4">
                                    <input type="text" name="NameLastBtn" 
                                           value="<?= $Name = (isset($getTableDetails['NameLastBtn'])) ? $getTableDetails['NameLastBtn'] : ""; ?>"
                                           class="form-control"/>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="control-label col-md-3">
                                    Enable Live Report Sync
                                </label>

                                <div class="col-md-9">
                                    <div class="col-md-12 padding_none">
                                        <div class="checkboxes" id="ChangeChkBox">
                                            <?php
                                            $LiveReportSync = (isset($getTableDetails["LiveReportSync"])) ? $getTableDetails["LiveReportSync"] : 0;
                                            $checked = "";
                                            if ($LiveReportSync) {
                                                $checked = "checked='checked'";
                                            }
                                            ?>
                                            <label>
                                                <input type="checkbox" <?= $checked; ?> name="LiveReportSync" value="1"/>
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="control-label col-md-3">
                                    Live Sync OnLoad
                                </label>

                                <div class="col-md-9">
                                    <div class="col-md-12 padding_none">
                                        <div class="checkboxes" id="ChangeChkBox">
                                            <?php
                                            $LiveSyncOnLoad = (isset($getTableDetails["LiveSyncOnLoad"])) ? $getTableDetails["LiveSyncOnLoad"] : 0;
                                            $checked = "";
                                            if ($LiveSyncOnLoad) {
                                                $checked = "checked='checked'";
                                            }
                                            ?>
                                            <label>
                                                <input type="checkbox" <?= $checked; ?> name="LiveSyncOnLoad" value="1"/>
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="control-label col-md-3">
                                   Save data in Cache (text file)
                                </label>

                                <div class="col-md-9">
                                    <div class="col-md-12 padding_none">
                                        <div class="checkboxes" id="ChangeChkBox">
                                            <?php
                                            $EnableTxtFile = (isset($getTableDetails["EnableTxtFile"])) ? $getTableDetails["EnableTxtFile"] : 0;
                                            $checked = "";
                                            if ($EnableTxtFile) {
                                                $checked = "checked='checked'";
                                            }
                                            ?>
                                            <label>
                                                <input type="checkbox" <?= $checked; ?> name="EnableTxtFile" value="1"/>
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="control-label col-md-3">
                                   Load data from Cache (text file) from Start
                                </label>

                                <div class="col-md-9">
                                    <div class="col-md-12 padding_none">
                                        <div class="checkboxes" id="ChangeChkBox">
                                            <?php
                                            $ReportOnLoad = (isset($getTableDetails["ReportOnLoad"])) ? $getTableDetails["ReportOnLoad"] : 0;
                                            $checked = "";
                                            if ($ReportOnLoad) {
                                                $checked = "checked='checked'";
                                            }
                                            ?>
                                            <label>
                                                <input type="checkbox" <?= $checked; ?> name="ReportOnLoad" value="1"/>
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="form-group row">
                                <label class="control-label col-md-3">
                                   Enable column or row color Marking
                                </label>

                                <div class="col-md-9">
                                    <div class="col-md-12 padding_none">
                                        <div class="checkboxes" id="ChangeChkBox">
                                            <?php
                                            $AllowColumnRowMarking = (isset($getTableDetails["AllowColumnRowMarking"])) ? $getTableDetails["AllowColumnRowMarking"] : 0;
                                            $checked = "";
                                            if ($AllowColumnRowMarking) {
                                                $checked = "checked='checked'";
                                            }
                                            ?>
                                            <label>
                                                <input type="checkbox" <?= $checked; ?> name="AllowColumnRowMarking" value="1" onchange="showDiv('colorType')"/>
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div  id = 'colorType' style='display:none;'>
                                            
                                <div class="form-group row">
                                    <label class="control-label col-md-3">
                                        Allow marking on Column on push Notification 
                                    </label>

                                    <div class="col-md-9">
                                        <div class="col-md-12 padding_none">
                                            <div class="checkboxes" id="ChangeChkBox">
                                                <?php
                                                $NotiColumnMarking = (isset($getTableDetails["NotiColumnMarking"])) ? $getTableDetails["NotiColumnMarking"] : 0;
                                                $checked = "";
                                                if ($NotiColumnMarking) {
                                                    $checked = "checked='checked'";
                                                }
                                                ?>
                                                <label>
                                                    <input type="checkbox" <?= $checked; ?> name="NotiColumnMarking" value="1" />
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group row"  >
                                    <label class="control-label col-md-3">
                                        Select Type
                                    </label>

                                    <div class="col-md-4">
                                        <select name="ColorSettingType" class="form-control"  data-reorder="1" >
                                                <?php 
                                                $selected = '';
                                                $ColoringType = isset($getTableDetails["ColorSettingType"])?$getTableDetails["ColorSettingType"]: '';
                                                if (isset($getTableDetails["ColorSettingType"]) &&  $getTableDetails['ColorSettingType'] != '') {
                                                    $selected = 'selected="selected"';
                                                } ?>
                                            <option value="" <?php echo  $selected?> >Select</option>
                                            <option value="1" <?php if( isset($getTableDetails["ColorSettingType"]) && $getTableDetails["ColorSettingType"] ==  '1'){ echo  $selected ;}?> >Generic</option>
                                            <option value="2" <?php if( isset($getTableDetails["ColorSettingType"]) && $getTableDetails["ColorSettingType"] ==  '2'){ echo  $selected ;}?> >Numeric</option>
                                            <option value="3" <?php if( isset($getTableDetails["ColorSettingType"]) && $getTableDetails["ColorSettingType"] ==  '3'){ echo  $selected ;}?> >Text</option>
                                            <option value="4" <?php if( isset($getTableDetails["ColorSettingType"]) && $getTableDetails["ColorSettingType"] ==  '4'){ echo  $selected ;}?> >Date</option>
                                            <option value="5" <?php if( isset($getTableDetails["ColorSettingType"]) && $getTableDetails["ColorSettingType"] ==  '5'){ echo  $selected ;}?> >Json</option>
                                        </select>
                                    
                                    </div>
                                </div>
                                
                    
                                <div class="form-group row"  >
                                    <label class="control-label col-md-3">
                                            Implement Color marking On 
                                    </label>

                                    <div class="col-md-4">
                                        <select name="ColoringType" class="form-control"  data-reorder="1" >
                                                <?php 
                                                $selected = '';
                                                $ColoringType = isset($getTableDetails["ColoringType"])?$getTableDetails["ColoringType"]: '';
                                                if (isset($getTableDetails["ColoringType"]) &&  $getTableDetails['ColoringType'] != '') {
                                                    $selected = 'selected="selected"';
                                                } ?>
                                            <option value="" <?php echo  $selected?> >Select</option>
                                            <option value="1" <?php if( isset($getTableDetails["ColoringType"]) && $getTableDetails["ColoringType"] ==  '1'){ echo  $selected ;}?> >On Column Text</option>
                                            <option value="2" <?php if( isset($getTableDetails["ColoringType"]) && $getTableDetails["ColoringType"] ==  '2'){ echo  $selected ;}?> >On Whole Column </option>
                                            <option value="3" <?php if( isset($getTableDetails["ColoringType"]) && $getTableDetails["ColoringType"] ==  '3'){ echo  $selected ;}?> >On Whole Row</option>
                                            <option value="4" <?php if( isset($getTableDetails["ColoringType"]) && $getTableDetails["ColoringType"] ==  '4'){ echo  $selected ;}?> >On column Box</option>
                                        
                                        </select>
                                    
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label class="control-label col-md-3">
                                        Columns on which coloring should be applied 
                                    
                                    </label>

                                    <div class="col-md-4">
                                        <select name="ColumnNameColor[]" id="ColumnNameColormultiple"
                                                class="form-control select2-multiple dataSourceColumns" data-reorder="1" multiple
                                                onChange='getSelectedOptions()'>
                                            <option value="">Select</option>
                                            <?php if (isset($existingColumnsOfColorMarking)) {
                                                $ColumnNameColor = isset($getTableDetails['ColumnNameColor'])? $getTableDetails['ColumnNameColor']:[];


                                                if ($ColumnNameColor) {
                                                    $ColumnNameColor = explode(',', $ColumnNameColor);
                                                }
                                                $existingColumnsOfColorMarking = explode(',', $existingColumnsOfColorMarking);
                                                if ($existingColumnsOfColorMarking) {
                                                    foreach ($existingColumnsOfColorMarking as $key => $value) {
                                                        $selected = "";
                                                        $value = trim($value);
                                                    
                                                        if (!empty($ColumnNameColor) && in_array($value, $ColumnNameColor)) {
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
                                <div id='ColorBtn'>

                                </div>
                                <div id='ColorConditions'>

                                </div>
                              
                             
                           
                                <div class="form-group row">
                                    <label class="control-label col-md-3">
                                        Coloring column or row json Setting
                                        
                                    </label>

                                    <div class="col-md-4">
                                    <textarea name="ColoringJsonText"
                                                class="form-control"> <?= $ColoringJsonText = (isset($getTableDetails['ColoringJsonText'])) ? $getTableDetails['ColoringJsonText'] : ""; ?></textarea>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="control-label col-md-3">
                                   Enable Action button on onclick row instead of having on first column 
                                </label>

                                <div class="col-md-9">
                                    <div class="col-md-12 padding_none">
                                        <div class="checkboxes" id="ChangeChkBox">
                                            <?php
                                            $EnableOnclickBtn = (isset($getTableDetails["EnableOnclickBtn"])) ? $getTableDetails["EnableOnclickBtn"] : 0;
                                            $checked = "";
                                            if ($EnableOnclickBtn) {
                                                $checked = "checked='checked'";
                                            }
                                            ?>
                                            <label>
                                                <input type="checkbox" <?= $checked; ?> name="EnableOnclickBtn" value="1" />
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="control-label col-md-3">
                                   Enable Data Grouping 
                                </label>

                                <div class="col-md-9">
                                    <div class="col-md-12 padding_none">
                                        <div class="checkboxes" id="ChangeChkBox">
                                            <?php
                                            $AllowDataGrouping = (isset($getTableDetails["AllowDataGrouping"])) ? $getTableDetails["AllowDataGrouping"] : 0;
                                            $checked = "";
                                            if ($AllowDataGrouping) {
                                                $checked = "checked='checked'";
                                            }
                                            ?>
                                            <label>
                                                <input type="checkbox" <?= $checked; ?> name="AllowDataGrouping" value="1" onclick="showGrouping(this)"/>
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div id = "DataGrouping" style="display:none;">
                            <?php $DataGroupingJson  = isset($getTableDetails["DataGroupingJson"] )?json_decode($getTableDetails["DataGroupingJson"] , true): '' ;
                                $key =1;
                                ?>
                                
                                <?php if($DataGroupingJson && $DataGroupingJson != '') {
                                    
                                        $existingColumnsOfDataGroup = !empty($getTableDetails["ColumnSort"])?explode(',', $getTableDetails["ColumnSort"]):explode(',',$getTableDetails["Columns"]);
                                        

                                        foreach ($DataGroupingJson as $keyData => $valueData) {?>
                                               <div id = 'DataGroup<?php echo $keyData; ?>'>
                                                    <div class="form-group row" >     
                                                        <label class="control-label col-md-3">
                                                            Data Group <?php echo $keyData; ?>
                                                        </label>
                                                        
                                                        <div class="col-md-4">
                                                            <select name="StartDataGroup<?php echo $keyData; ?>" id="StartDataGroup<?php echo $keyData; ?>" class="form-control dataSourceColumns"  data-reorder="1" >
                                                                <option value="">Select</option>
                                                                <?php if ($existingColumnsOfDataGroup) {
                                                                         
                                                                        foreach ($existingColumnsOfDataGroup as $keystart => $valuestart) {
                                                                            $selected = "";
                                                                            $value = trim($value);
                                                                           
                                                                            if ( isset($valueData['start'])  && $valueData['start'] == $keystart) {
                                                                               
                                                                                $selected = 'selected="selected"';
                                                                                }
                                                                            echo '<option value= "' .  $valuestart . '"' . $selected . '>' .  $valuestart . '</option>';
                                                                        }
                                                             
                                                                    ?>
                                                                <?php } ?>
                                                            </select>
                                                            
                                                        </div>
                                                        <div class="col-md-4">
                                                            <select name="EndDataGroup<?php echo $keyData; ?>" id="EndDataGroup<?php echo $keyData; ?>" class="form-control dataSourceColumns"  data-reorder="1" >
                                                                <option value="">Select</option>
                                                                <?php if ($existingColumnsOfDataGroup) {
                                                                         
                                                                         foreach ($existingColumnsOfDataGroup as $keystart => $valuestart) {
                                                                             $selected = "";
                                                                             $value = trim($value);
                                                                         
                                                                             if ( isset($valueData['End'])  && $valueData['End'] == $keystart) {
                                                                                print_r($valueData['End']);
                                                                                print_r($keystart);
                                                                                print_r($existingColumnsOfDataGroup);
                                                                                print_r($value ); 
                                                                                 $selected = 'selected="selected"';
                                                                                 }
                                                                             echo '<option value= "' .  $valuestart . '"' . $selected . '>' .  $valuestart . '</option>';
                                                                         }
                                                              
                                                                     ?>
                                                                 <?php } ?>
                                                            </select>
                                                            
                                                        </div>
                                                        
                                                    </div>
                                                </div>  
                                    <?php $key = $keyData;}
                                } else { ?>
                                    <div id = 'DataGroup0'>
                                        
                                    </div>
                                <?php $key = 0;} ?>
                                <div class="form-group row">
                                    <label class="control-label col-md-3">
                                        
                                    </label>

                                    <div class="col-md-9">
                                    <input type="hidden" name="DataGroupCount"  id="DataGroupCount" value="<?php echo $key;?>"  class="form-control"/>
                                    <button  type="button" id = "Add_DataGroup" onclick="AddDataGroup()" >  Add Data Group </button> 
                                    <button  type="button" id = "Delete_DataGroup" onclick="DeleteDataGroup()" > Delete Data Group</button> 
                                            
                                    </div>
                                </div>            
                            </div>
                            <div class="form-group row">
                                <label class="control-label col-md-3">
                                   Enable Normal Search after 3 character  
                                </label>

                                <div class="col-md-9">
                                    <div class="col-md-12 padding_none">
                                        <div class="checkboxes" id="ChangeChkBox">
                                            <?php
                                            $AllowSearchAfter3Char = (isset($getTableDetails["AllowSearchAfter3Char"])) ? $getTableDetails["AllowSearchAfter3Char"] : 0;
                                            $checked = "";
                                            if ($AllowSearchAfter3Char) {
                                                $checked = "checked='checked'";
                                            }
                                            ?>
                                            <label>
                                                <input type="checkbox" <?= $checked; ?> name="AllowSearchAfter3Char" value="1" onchange="Show3CharDiv(this)"/>
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group row" id="col3Div" style="display:none">
                                <label class="control-label col-md-3">
                                   Column  on which search after 3 character will be implemented 
                                </label>
                                <div class="col-md-4">
                                    <textarea name="ColSearchAfter3Char"
                                              class="form-control"> <?= $ColSearchAfter3Char = (isset($getTableDetails['ColSearchAfter3Char'])) ? $getTableDetails['ColSearchAfter3Char'] : ""; ?></textarea>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="control-label col-md-3">
                                    Show zero instead of Negative Values 
                                </label>

                                <div class="col-md-9">
                                    <div class="col-md-12 padding_none">
                                        <div class="checkboxes" id="ChangeChkBox">
                                            <?php
                                            $AddZeroForNegVal = (isset($getTableDetails["AddZeroForNegVal"])) ? $getTableDetails["AddZeroForNegVal"] : 0;
                                            $checked = "";
                                            if ($AddZeroForNegVal) {
                                                $checked = "checked='checked'";
                                            }
                                            ?>
                                            <label>
                                                <input type="checkbox" <?= $checked; ?> name="AddZeroForNegVal" value="1" onchange="ShowNegDiv(this)"/>
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group row" id="colNegDiv" style="display:none">
                                <label class="control-label col-md-3">
                                   Column on which zero should be shown instaed of Negative 
                                </label>
                                <div class="col-md-4">
                                    <textarea name="ColAddZeroForNegVal"
                                              class="form-control"> <?= $ColAddZeroForNegVal = (isset($getTableDetails['ColAddZeroForNegVal'])) ? $getTableDetails['ColAddZeroForNegVal'] : ""; ?></textarea>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="control-label col-md-3">
                                    Update Multiple Value at Same Time
                                </label>

                                <div class="col-md-9">
                                    <div class="col-md-12 padding_none">
                                        <div class="checkboxes" id="ChangeChkBox">
                                            <?php
                                            $EnableAllUpdates = (isset($getTableDetails["EnableAllUpdates"])) ? $getTableDetails["EnableAllUpdates"] : 0;
                                            $checked = "";
                                            if ($EnableAllUpdates) {
                                                $checked = "checked='checked'";
                                            }
                                            ?>
                                            <label>
                                                <input type="checkbox" <?= $checked; ?> name="EnableAllUpdates" value="1" />
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group row" id="predefinedALlVal" >
                                <label class="control-label col-md-3">
                                        Predefined Actions 
                                </label>

                                <div class="col-md-4">
                                    <?php
                                        $SelectPredefinedNames = (isset($getTableDetails['SelectPredefinedNames'])) ? $getTableDetails['SelectPredefinedNames'] : "";
                                      
                                        if($SelectPredefinedNames){
                                            $SelectPredefinedNames = explode(',' , $SelectPredefinedNames) ;
                                        }
                                   ?>
                             
                                    <select name="SelectPredefinedNames[]" id="SelectPredefinedNames"
                                            class="form-control select2-multiple " data-reorder="1" multiple
                                            >
                                        <option value="">Select</option>
                                        <?php 
                                      
                                            foreach ($getPredefinedVal as $pkey => $pvalue) {
                                                $selected = "";
                                                $pvalue = trim($pvalue['ActionButtonText']);
                                                
                                                if (!empty($SelectPredefinedNames) && in_array($pvalue, $SelectPredefinedNames)) {
                                                    $selected = 'selected="selected"';
                                                }
                                                
                                                echo '<option value= "'. $pvalue .'"' . $selected . '>' . $pvalue . '</option>';
                                            }
                                           
                                        ?>
                                    </select>
                                </div>
                                <?php  ?>
                            </div>
							 <div class="form-group row">
                                <label class="control-label col-md-3">
                                   Enable Saving Data in JsonRedis
                                </label>

                                <div class="col-md-1">
                                    <div class="col-md-12 padding_none">
                                        <div class="checkboxes" >
                                            <?php
                                            $AllowJsonSave = (isset($getTableDetails["AllowJsonSave"])) ? $getTableDetails["AllowJsonSave"] : 0;
                                            $checked = "";
                                            if ($AllowJsonSave) {
                                                $checked = "checked='checked'";
                                            }
                                            ?>
                                            <label>
                                                <input type="checkbox" <?= $checked; ?> name="AllowJsonSave" id="AllowJsonSave" value="1"/>
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
								 <div class="form-group row">
                                <label class="control-label col-md-3">
                                   Disable Saving data from JsonRedis Incase of Global activation:
                                </label>

                                <div class="col-md-1">
                                    <div class="col-md-12 padding_none">
                                        <div class="checkboxes" >
                                            <?php
                                            $DisableJsonSaveGlobal = (isset($getTableDetails["DisableJsonSaveGlobal"])) ? $getTableDetails["DisableJsonSaveGlobal"] : 0;
                                            $checked = "";
                                            if ($DisableJsonSaveGlobal) {
                                                $checked = "checked='checked'";
                                            }
                                            ?>
                                            <label>
                                                <input type="checkbox" <?= $checked; ?> name="DisableJsonSaveGlobal" id="DisableJsonSaveGlobal" value="1"/>
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="control-label col-md-3">
                                    Allow Redis on this Table 
                                </label>

                                <div class="col-md-1">
                                    <div class="col-md-12 padding_none">
                                        <div class="checkboxes" >
                                            <?php
                                            $EnableCacheTable = (isset($getTableDetails["EnableCacheTable"])) ? $getTableDetails["EnableCacheTable"] : 0;
                                            $checked = "";
                                            if ($EnableCacheTable) {
                                                $checked = "checked='checked'";
                                            }
                                            ?>
                                            <label>
                                                <input type="checkbox" <?= $checked; ?> name="EnableCacheTable" id="EnableCacheTable" value="1"/>
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="control-label col-md-3"> Time Duration for Redis to be Active
                                </label>
                               
                                <div class="col-md-4">
                                    <input type="text" name="TimeDurationRedisTable" id="TimeDurationRedisTable"  value="<?php if(!empty($getTableDetails['TimeDurationRedisTable'])){echo $getTableDetails['TimeDurationRedisTable'];} ?>" class="form-control"/>
                                    
                                </div>
                                 
                            </div>
                            <div class="form-group row">
                                <label class="control-label col-md-3"> Time CLock for Redis to be Active 
                                </label>
                               
                                <div class="col-md-4">
                                    <input type="text" name="TimeRedisTable" id="TimeRedisTable"  value="<?php if(!empty($getTableDetails['TimeRedisTable'])){echo $getTableDetails['TimeRedisTable'];} ?>" class="form-control"/>
                                    
                                </div>
                                 
                            </div>

                            <div class="form-group row">
                                <label class="control-label col-md-3">
                                    Disable Redis on report Tables
                                </label>

                                <div class="col-md-1">
                                    <div class="col-md-12 padding_none">
                                        <div class="checkboxes" >
                                            <?php
                                            $RedisCallType = (isset($getTableDetails["DisableReports"])) ? $getTableDetails["DisableReports"] : 0;
                                            $checked = "";
                                            if ($RedisCallType) {
                                                $checked = "checked='checked'";
                                            }
                                            ?>
                                            <label>
                                                <input type="checkbox" <?= $checked; ?> name="DisableReports" id="DisableReports" value="1"/>
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="control-label col-md-3">
                                   Enabl PDF Import
                                </label>

                                <div class="col-md-1">
                                    <div class="col-md-12 padding_none">
                                        <div class="checkboxes" >
                                            <?php
                                            $AllowPDFImport = (isset($getTableDetails["AllowPDFImport"])) ? $getTableDetails["AllowPDFImport"] : 0;
                                            $checked = "";
                                            if ($AllowPDFImport) {
                                                $checked = "checked='checked'";
                                            }
                                            ?>
                                            <label>
                                                <input type="checkbox" <?= $checked; ?> name="AllowPDFImport" id="AllowPDFImport" value="1"/>
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="control-label col-md-3">
                                    Enable Excel Import
                                </label>

                                <div class="col-md-1">
                                    <div class="col-md-12 padding_none">
                                        <div class="checkboxes" >
                                            <?php
                                            $AllowExcelImport = (isset($getTableDetails["AllowExcelImport"])) ? $getTableDetails["AllowExcelImport"] : 0;
                                            $checked = "";
                                            if ($AllowExcelImport) {
                                                $checked = "checked='checked'";
                                            }
                                            ?>
                                            <label>
                                                <input type="checkbox" <?= $checked; ?> name="AllowExcelImport" id="AllowExcelImport" value="1"/>
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
							 <div class="form-group row">
                                <label class="control-label col-md-3">
                                    Enable Enter on search bar 
                                </label>

                                <div class="col-md-1">
                                    <div class="col-md-12 padding_none">
                                        <div class="checkboxes" >
                                            <?php
                                            $AllowEnterSearch = (isset($getTableDetails["AllowEnterSearch"])) ? $getTableDetails["AllowEnterSearch"] : 0;
                                            $checked = "";
                                            if ($AllowEnterSearch) {
                                                $checked = "checked='checked'";
                                            }
                                            ?>
                                            <label>
                                                <input type="checkbox" <?= $checked; ?> name="AllowEnterSearch" id="AllowEnterSearch" value="1"/>
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                           
                           <!-- <div class="form-group row">
                                <label class="control-label col-md-3">
                                    Live Sync Post URL
                                   
                                </label>

                                <div class="col-md-4">
                                    <input type="text" name="LiveSyncPostURL" 
                                           value="<?= $LiveSyncPostURL = (isset($getTableDetails['LiveSyncPostURL'])) ? $getTableDetails['LiveSyncPostURL'] : ""; ?>"
                                           class="form-control"/>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="control-label col-md-3">
                                     Live Sync Post Body
                                    
                                </label>

                                <div class="col-md-4">
                                    <input type="text" name="LiveSyncPostBody" 
                                           value="<?= $LiveSyncPostBody = (isset($getTableDetails['LiveSyncPostBody'])) ? $getTableDetails['LiveSyncPostBody'] : ""; ?>"
                                           class="form-control"/>
                                </div>
                            </div> -->
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
<script type="text/javascript">


 var jar = 1;
 function ShowRowLevel(checkbox){
    if (checkbox.checked)
    {
       $('#MainDiv').show();
   }else{
        $('#MainDiv').hide();
   }
}
function Show3CharDiv(checkbox){
    if (checkbox.checked)
    {
       $('#col3Div').show();
   }else{
        $('#col3Div').hide();
   }
}
function ShowNegDiv(checkbox){
    if (checkbox.checked)
    {
       $('#colNegDiv').show();
   }else{
        $('#colNegDiv').hide();
   }
}



function showGrouping(checkbox){
    if (checkbox.checked)
    {
       $('#DataGrouping').show();
   }else{
        $('#DataGrouping').hide();
   }
}


function ShowColWidth(checkbox){
    if (checkbox.checked)
    {
       $('#ColumnFilterWidth').show();
   }else{
        $('#ColumnFilterWidth').hide();
   }
}
function AddDataGroup(){
    var num = document.getElementById('DataGroupCount').value;
    var oldnum = num ;        
    num = parseInt(num)+1;
    document.getElementById('DataGroupCount').value = num;
    var text = document.createElement('div');
 
    var val = '';
    
    val += '    <div id = "DataGroup'+num+'">'+
                    '<div class="form-group row" >   '+  
                        '<label class="control-label col-md-3">'+
                           'Data Group '+num+
                        '</label>'+

                        '<div class="col-md-4">'+
                            '<select name="StartDataGroup'+num+'" id="StartDataGroup'+num+'"  class="form-control dataSourceColumns"  data-reorder="1" > '+
                            
                            '</select>'+
                            
                        '</div>'+
                        '<div class="col-md-4">'+
                            '<select name="EndDataGroup'+num+'" id="EndDataGroup'+num+'"  class="form-control dataSourceColumns"  data-reorder="1" >'+
                             
                            '</select>'+
                            
                        '</div>'+
                        
                    '</div>'+
                '</div>';


                   
    text.innerHTML =val;

    $( val ).insertAfter('#DataGroup'+oldnum );
    var $options = $('#multipleCol option').clone();
    $('#StartDataGroup'+num).append($options);
    var $options = $('#multipleCol option').clone();
    $('#EndDataGroup'+num).append($options);
}

function DeleteDataGroup(){
    var id =  parseInt(document.getElementById("DataGroupCount").value);
   
    if(id >= 1 ){
        document.getElementById("DataGroupCount").value = id-1;
        document.getElementById("DataGroup"+id).remove();
       
    }

}
function AddNewColWDiv(){
   
    var num = document.getElementById('TotalColumns').value;
    var oldnum = num;        
    num = parseInt(num)+1;
    alert(num);
    document.getElementById('TotalColumns').value = num;
    var text = document.createElement('div');
 
    var val = '';
    
    val += '    <div id="ColumnFilterWidth'+num+'">'+
                                    '<div class="form-group row">'+
                                       ' <label class="control-label col-md-3">'+
                                           ' Select column name and its width in px'+
                                        '</label>'+

                                       ' <div class="col-md-4">'+
                                            '<select name="ColumnWidthName'+num+'" id="ColumnWidthName'+num+'"  class="form-control  dataSourceColumns" >'+
                                              
                                               
                                              
                                           ' </select>'+
                                        '</div>'+
                                   ' </div>'+
                                    '<div class="form-group row">'+
                                        '<label class="control-label col-md-3">'+
                                            
                                        '</label>'+

                                        '<div class="col-md-4">'+
                                         '   <input type="text" name="ColumnWidth'+num+'"  value="" class="form-control"/>'+
                                        '</div>'+
                                    '</div>'+
                                '</div>';


                   
                    text.innerHTML =val;
                   
                    $( val ).insertAfter( '#ColumnFilterWidth'+oldnum );
                    var $options = $('#ColumnWidthName1 option').clone();
                    console.log($options);
                    $('#ColumnWidthName'+num).append($options);
                  

}
 
  <?php 
      
    if ( isset($getTableDetails["TableDesign"]) &&  $getTableDetails['TableDesign'] == '1') {?>
        $('#ScrollDesignWidth').show();
        $('#FooterSumLocation').show();
        $('#PaginationFlag').show();
        
   <?php } ?>
   <?php 
    if ( isset($getTableDetails["AllowSearchAfter3Char"]) &&  $getTableDetails['AllowSearchAfter3Char'] == '1') {?>
        $('#col3Div').show();
   <?php } ?>
   <?php 
      if ( isset($getTableDetails["AddZeroForNegVal"]) &&  $getTableDetails['AddZeroForNegVal'] == '1') {?>
          $('#colNegDiv').show();
     <?php } ?>
    <?php 
       if ( isset($getTableDetails["AllowDataGrouping"]) &&  $getTableDetails['AllowDataGrouping'] == '1') {?>
           $('#DataGrouping').show();
    <?php } ?>
   <?php 
       
       if ( isset($getTableDetails["AllowColumnRowMarking"]) &&  $getTableDetails['AllowColumnRowMarking'] == '1') {?>
           $('#colorType').show();
      <?php } ?>

function AddRowLevel(){
        id = parseInt(document.getElementById('RowGroupLevelCount').value);
        id=id+1;
        if(id > 4 ){
            alert("only 4 levels Allowed");
        }else{
            // document.getElementById("RowGroupLevelCount").value = id;
            // $('#RowGroupLevel'+id).show();
            var num =id;
            var oldnum = id-1;        
           
            document.getElementById('RowGroupLevelCount').value = num;
            var text = document.createElement('div');
        
            var val = '';
            val += '   <div id = "RowGroupLevel'+num+'" > '+
                            '<div class="form-group row" >  '+   
                                '<label class="control-label col-md-3">'+
                                '   Level '+num+
                                '</label>'+

                                '<div class="col-md-4">'+
                                    
                                    '<select name="RowGroupLevelColumns'+num+'" id="GroupRowsColumn'+num+'"  class="form-control dataSourceColumns"  data-reorder="1"  >'+
                                ' </select>'+
                                    
                                '</div>'+
                               
                            '</div>'+
                        '</div>  ';


                   
            text.innerHTML =val;
            
            $( val ).insertAfter( '#RowGroupLevel'+oldnum );
            var $options = $('#multipleCol option').clone();
            $('#GroupRowsColumn'+num).append($options);
        }        
}

function DeleteRowLevel(){
    var id =  parseInt(document.getElementById("RowGroupLevelCount").value);
    console.log(id);
    if(id <= 4 && id > 1 ){
        document.getElementById("RowGroupLevelCount").value = id-1;
        document.getElementById("RowGroupLevel"+id).remove();
       
    }
}     
  
<?php
    if(isset($getTableDetails["ColorTextMatch"])){ ?>
        var opts = [],
        opt;
        $("#ColorBtn").children().remove();
        var dats = $("#ColumnNameColormultiple").val();
        $.each(dats, function ( datsKey, datsValue) {
            if(document.getElementById('#condition'+datsValue) !== true){
                opts.push('condition'+datsValue);
            }
            
        });
        $.each(opts, function ( datsKey, datsValue) {
            $("#"+datsValue).remove();
            
        });
        $.each(dats, function ( datsKey, datsValue) {

            let btn = document.createElement("button");
            btn.innerHTML = "Condition for "+datsValue;
            btn.name = datsValue;
            btn.id = datsValue;
            btn.type="button";
            btn.onclick = function () { newConditionFields(datsValue)};
            $('#ColorBtn').append(btn);
        });
            
            <?php
                $ColorTextMatch = json_decode($getTableDetails["ColorTextMatch"] , true); 
               
                foreach ($ColorTextMatch as $ColorTextMatchkey => $ColorTextMatchvalue) { 
                    ksort($ColorTextMatchvalue);
                   
                    foreach($ColorTextMatchvalue as $innerkey => $innerValue){ ?>
                       
                        var textValue = "<?php echo $ColorTextMatchkey; ?>";
                        var textkey = "<?php echo $innerkey; ?>";
                        var text = document.createElement('div');
                        text.id = "condition"+textValue+textkey;
                        var IDNew = "condition"+textValue+textkey;
                        var val = '';

                        val += ' <div id ="'+IDNew+'"> <div class="form-group row"  >'+
                                    ' <label class="control-label col-md-3">Select '+textValue+' Color'+textkey+' </label>'+

                                        '<div class="col-md-4">'+
                                        '<select name="'+textValue+'_Colors_'+textkey+'" class="form-control"  data-reorder="1" >'+
                                                    <?php 
                                                    $selected = '';
                                                    $ColoringType = isset($innerValue["TextColors"])?$innerValue["TextColors"]: '';
                                                    if (isset($innerValue["TextColors"]) &&  $innerValue['TextColors'] != '') {
                                                        $selected = 'selected="selected"';
                                                    } ?>
                                                '<option value="" <?php echo  $selected?> >Select</option>'+
                                                '<option value="red" <?php if($ColoringType == 'red') {echo  $selected ;} ?> >Red</option>'+
                                                '<option value="lightgreen" <?php if($ColoringType == 'lightgreen') {echo  $selected ;}?>>Green</option>'+
                                                '<option value="skyblue" <?php if($ColoringType == 'skyblue') {echo  $selected ;}?>  >Blue</option>'+
                                                '<option value="LightCoral" <?php if($ColoringType == 'LightCoral') {echo  $selected ;}?>  >White Red</option>'+
                                                '<option value="Yellow" <?php if($ColoringType == 'Yellow') {echo  $selected ;}?>  >Yellow</option>'+
                                                '<option value="orange" <?php if($ColoringType == 'orange') {echo  $selected ;}?>  >Orange</option>'+
                                                '<option value="mediumseagreen" <?php if($ColoringType == 'mediumseagreen') {echo  $selected ;}?>  >Medium Sea Green</option>'+
                                                '<option value="firebrick" <?php if($ColoringType == 'firebrick') {echo  $selected ;}?>  >Fire Brick</option>'+
                                                '<option value="#C4A484" <?php if($ColoringType == '#C4A484') {echo  $selected ;}?>  >Light Brow</option>'+
                                                
                                            '</select>'+
                                        
                                        '</div>'+
                                                '</div>';

                        val += ' <div class="form-group row" >'+
                                        '<label class="control-label col-md-3"> '+textValue+'Rule '+textkey+' </label>'+
                                        '<div class="col-md-9" id="rules">'+
                                            '<div class="col-md-3">'+
                                                '<input placeholder="first parameter" type="text" name="'+textValue+'_FirstParameter_'+textkey+'"  id="FirstParameter" value="<?php if($innerValue["FirstParameter"] != ''){ print_r($innerValue['FirstParameter']);}?>"  class="form-control"  <?php if($innerValue["FirstParameter"] == ''){ ?> readonly <?php }?> />'+
                                            '</div>'+
                                            '<div class="col-md-3">'+
                                                '<select name="'+textValue+'_Condition_'+textkey+'" class="form-control" onchange="InBetween(\''+textkey+'\' ,  \''+textValue+'\' , this )"  id="Condition">'+
                                                    '<option value=""> Select</option>'+
                                                    '<option value="="  <?php if( isset($innerValue["Condition"]) && $innerValue["Condition"] ==  '='){ echo  'selected="selected"' ;}?> >  is Equal</option>'+
                                                    '<option value="!=" <?php if( isset($innerValue["Condition"]) && $innerValue["Condition"] ==  '!='){ echo  'selected="selected"' ;}?> > is Not Equal</option>'+
                                                    '<option value=">" <?php if( isset($innerValue["Condition"]) && $innerValue["Condition"] ==  '>'){ echo  'selected="selected"' ;}?> > is Greater</option>'+
                                                    '<option value="<" <?php if( isset($innerValue["Condition"]) && $innerValue["Condition"] ==  '<'){ echo  'selected="selected"' ;}?>  > is Less then </option>'+
                                                    '<option value=">="  <?php if( isset($innerValue["Condition"]) && $innerValue["Condition"] ==  '>='){ echo  'selected="selected"' ;}?> > is Greater then and equal to </option>'+
                                                    '<option value="<="  <?php if( isset($innerValue["Condition"]) && $innerValue["Condition"] ==  '>='){ echo  'selected="selected"' ;}?> > is Less then and equal to </option>'+
                                                    '<option value="<="  <?php if( isset($innerValue["Condition"]) && $innerValue["Condition"] ==  '>='){ echo  'selected="selected"' ;}?> > is Less then and equal to </option>'+   
                                                    '<option value="InBetween"  <?php if( isset($innerValue["Condition"]) && $innerValue["Condition"] ==  'InBetween'){ echo  'selected="selected"' ;}?> > In Between </option>'+
                                                
                                                '</select>'+
                                            '</div>'+
                                            '<div class="col-md-3">'+
                                                '<input placeholder="Second parameter" type="text" name="'+textValue+'_SecondParameter_'+textkey+'"  value="<?php print_r($innerValue['SecondParameter']);?>"  class="form-control"/>'+
                                            '</div>'+
                                            '<div class="col-md-3">'+
                                                '<button  type="button" id = "'+textValue+'_AddMorePara" onclick="Addnewpara(\''+textkey+'\' ,  \''+textValue+'\')" >  Add more Parameter for'+textValue+'</button> '+
                                                '<button  type="button" id = "'+textValue+'_DeletePara" onclick="Deletepara(\''+textkey+'\' ,  \''+textValue+'\')"  > Delete Parameter '+textkey+' for'+textValue+'</button> '+
                                       
                                            '</div>'+
                                        '</div>'+
                                    '</div></div>';
                                    val += '<input type ="hidden" name="'+textValue+'_totalNum" id="'+textValue+'_totalNum" value="'+textkey+'"  />'

                                

                        text.innerHTML =val;
                        if(textkey == '1')
                        {
                            $('#ColorConditions').append(val);
                        }else{
                            var IDNews = "condition"+textValue+(parseInt(textkey)-1);
                            //$('#'+IDNew).append(val);
                            $( val ).insertAfter( '#'+IDNews );
                        }
                          
                    <?php    
                        }
                    }
                ?>
    <?php } ?>
function Deletepara(num , para){
    document.getElementById("condition"+para+num).remove();
}
function getSelectedOptions() {
  var opts = [],
    opt;
    $("#ColorBtn").children().remove();
    var dats = $("#ColumnNameColormultiple").val();
    $.each(dats, function ( datsKey, datsValue) {
        if(document.getElementById('#condition'+datsValue) !== true){
            opts.push('condition'+datsValue);
        }
        
    });
    $.each(opts, function ( datsKey, datsValue) {
        $("#"+datsValue).remove();
        
    });
    $.each(dats, function ( datsKey, datsValue) {

        let btn = document.createElement("button");
        btn.innerHTML = "Condition for "+datsValue;
        btn.name = datsValue;
        btn.id = datsValue;
        btn.type="button";
        btn.onclick = function() { newConditionFields(datsValue);}; 
        $('#ColorBtn').append(btn);
    });
}

function newConditionFields (datsValue) {
        
        var element =  document.getElementById("condition"+datsValue+'1');
        if (typeof(element) != 'undefined' && element != null)
        {
        }else{
            
            var text = document.createElement('div');
            text.id = "condition"+datsValue+'1';
            var IDss = "condition"+datsValue+'1';
            var val = '';

            val += '  <div id ="'+IDss+'"><div class="form-group row"  >'+
                           ' <label class="control-label col-md-3">Select '+datsValue+' Color  1 </label>'+

                            '<div class="col-md-4">'+
                               '<select name="'+datsValue+'_Colors_1" class="form-control"  data-reorder="1" >'+
                                        <?php 
                                        $selected = '';
                                        $ColoringType = isset($getTableDetails["Colors"])?$getTableDetails["Colors"]: '';
                                        if (isset($getTableDetails["Colors"]) &&  $getTableDetails['Colors'] != '') {
                                            $selected = 'selected="selected"';
                                        } ?>
                                    '<option value="" <?php echo  $selected?> >Select</option>'+
                                    '<option value="red"  >Red</option>'+
                                    '<option value="lightgreen">Green</option>'+
                                    '<option value="skyblue"  >Blue</option>'+
                                    '<option value="LightCoral"  >White Red</option>'+
                                    '<option value="Yellow">Yellow</option>'+
                                    '<option value="orange" >Orange</option>'+
                                    '<option value="mediumseagreen" >Medium Sea Green</option>'+
                                    '<option value="firebrick" >Fire Brick</option>'+
                                    '<option value="#C4A484" >Light Brow</option>'+
                                                
                                                
                                                
                                '</select>'+
                            
                            '</div>'+
                                    '</div>';

            val += ' <div class="form-group row" >'+
                            '<label class="control-label col-md-3"> '+datsValue+'Rule 1 </label>'+
                            '<div class="col-md-9" id="rules">'+
                                '<div class="col-md-3">'+
                                    '<input placeholder="first parameter" type="text" name="'+datsValue+'_FirstParameter_1"  id="FirstParameter" value=""  class="form-control" readonly />'+
                                '</div>'+
                                '<div class="col-md-3">'+
                                    '<select name="'+datsValue+'_Condition_1" class="form-control" onchange="InBetween(\'1\' ,  \''+datsValue+'\' , this)"  id="Condition">'+
                                        '<option value=""> Select</option>'+
                                        '<option value="="   >  is Equal</option>'+
                                        '<option value="!=" > is Not Equal</option>'+
                                        '<option value=">"  > is Greater</option>'+
                                        '<option value="<" <?php if( isset($getTableDetails["Condition"]) && $getTableDetails["Condition"] ==  '<'){ echo  'selected="selected"' ;}?>  > is Less then </option>'+
                                        '<option value=">="  <?php if( isset($getTableDetails["Condition"]) && $getTableDetails["Condition"] ==  '>='){ echo  'selected="selected"' ;}?> > is Greater then and equal to </option>'+
                                        '<option value="<="  <?php if( isset($getTableDetails["Condition"]) && $getTableDetails["Condition"] ==  '>='){ echo  'selected="selected"' ;}?> > is Less then and equal to </option>'+
                                        '<option value="<="  <?php if( isset($getTableDetails["Condition"]) && $getTableDetails["Condition"] ==  '>='){ echo  'selected="selected"' ;}?> > is Less then and equal to </option>'+   
                                        '<option value="InBetween"  <?php if( isset($getTableDetails["Condition"]) && $getTableDetails["Condition"] ==  'InBetween'){ echo  'selected="selected"' ;}?> > In Between </option>'+
                                    
                                    '</select>'+
                                '</div>'+
                                '<div class="col-md-3">'+
                                    '<input placeholder="Second parameter" type="text" name="'+datsValue+'_SecondParameter_1"  value=""  class="form-control"/>'+
                                '</div>'+
                                '<div class="col-md-3">'+
                                    '<button  type="button" id = "'+datsValue+'_AddMorePara" onclick="Addnewpara(\'1\' ,  \''+datsValue+'\')" >  Add more Parameter for'+datsValue+'</button> '+
                                    '<button  type="button" id = "'+datsValue+'_DeletePara" onclick="Deletepara(\'1\' ,  \''+datsValue+'\')"  > Delete Parameter 1 for'+datsValue+'</button> '+
                                '</div>'+
                            '</div>'+
                        '</div> </div>';
                        
                        val += '<input type ="hidden" name="'+datsValue+'_totalNum" id="'+datsValue+'_totalNum" value="1"  />'

                    

            text.innerHTML =val;
            $('#ColorConditions').append(val);
        }
   
};

function Addnewpara(num , datsValue){
       
        var element =  document.getElementById(datsValue+'_totalNum');
        if (typeof(element) != 'undefined' && element != null)
        {
            num = document.getElementById(datsValue+'_totalNum').value ;
            //num= parseInt(num);
        }
                    var IDNew = "condition"+datsValue+num;
                    
                    num= parseInt(num)+1;
                    var text = document.createElement('div');
                    text.id = "condition"+datsValue+num;
                    var IDNew1 = "condition"+datsValue+num;
                    var val = '';

                    val += ' <div id ="'+IDNew1+'"><div class="form-group row"  >'+
                                   ' <label class="control-label col-md-3">Select '+datsValue+' Color '+num+' </label>'+

                                    '<div class="col-md-4">'+
                                       '<select name="'+datsValue+'_Colors_'+num+'" class="form-control"  data-reorder="1" >'+
                                                <?php 
                                                $selected = '';
                                                $ColoringType = isset($getTableDetails["Colors"])?$getTableDetails["Colors"]: '';
                                                if (isset($getTableDetails["Colors"]) &&  $getTableDetails['Colors'] != '') {
                                                    $selected = 'selected="selected"';
                                                } ?>
                                            '<option value="" <?php echo  $selected?> >Select</option>'+
                                            '<option value="red"  >Red</option>'+
                                            '<option value="lightgreen">Green</option>'+
                                            '<option value="skyblue"  >Blue</option>'+
                                            '<option value="LightCoral"  >White Red</option>'+
                                            '<option value="Yellow"  >Yellow</option>'+
                                            '<option value="orange" >Orange</option>'+
                                            '<option value="mediumseagreen"  >Medium Sea Green</option>'+
                                            '<option value="firebrick" >Fire Brick</option>'+
                                            '<option value="#C4A484" >Light Brow</option>'+
                                                 
                                                
                                        '</select>'+
                                    
                                    '</div>'+
                                            '</div>';

                    val += ' <div class="form-group row" >'+
                                    '<label class="control-label col-md-3"> '+datsValue+'Rule '+num+'  </label>'+
                                    '<div class="col-md-9" id="rules">'+
                                        '<div class="col-md-3">'+
                                            '<input placeholder="first parameter" type="text" name="'+datsValue+'_FirstParameter_'+num+'"  id="FirstParameter" value=""  class="form-control" readonly />'+
                                        '</div>'+
                                        '<div class="col-md-3">'+
                                            '<select name="'+datsValue+'_Condition_'+num+'" class="form-control" onchange="InBetween(\''+num+'\' ,  \''+datsValue+'\' , this)"  id="Condition">'+
                                                '<option value=""> Select</option>'+
                                                '<option value="="   >  is Equal</option>'+
                                                '<option value="!=" > is Not Equal</option>'+
                                                '<option value=">"  > is Greater</option>'+
                                                '<option value="<" <?php if( isset($getTableDetails["Condition"]) && $getTableDetails["Condition"] ==  '<'){ echo  'selected="selected"' ;}?>  > is Less then </option>'+
                                                '<option value=">="  <?php if( isset($getTableDetails["Condition"]) && $getTableDetails["Condition"] ==  '>='){ echo  'selected="selected"' ;}?> > is Greater then and equal to </option>'+
                                                '<option value="<="  <?php if( isset($getTableDetails["Condition"]) && $getTableDetails["Condition"] ==  '>='){ echo  'selected="selected"' ;}?> > is Less then and equal to </option>'+
                                                '<option value="<="  <?php if( isset($getTableDetails["Condition"]) && $getTableDetails["Condition"] ==  '>='){ echo  'selected="selected"' ;}?> > is Less then and equal to </option>'+   
                                                '<option value="InBetween"  <?php if( isset($getTableDetails["Condition"]) && $getTableDetails["Condition"] ==  'InBetween'){ echo  'selected="selected"' ;}?> > In Between </option>'+
                                            
                                            '</select>'+
                                        '</div>'+
                                        '<div class="col-md-3">'+
                                            '<input placeholder="Second parameter" type="text" name="'+datsValue+'_SecondParameter_'+num+'"  value=""  class="form-control"/>'+
                                        '</div>'+
                                        '<div class="col-md-3">'+
                                            '<button  type="button" id = "'+datsValue+'_AddMorePara" onclick="Addnewpara(\''+num+'\' ,  \''+datsValue+'\')"  > Add more Parameter for'+datsValue+'</button> '+
                                            '<button  type="button" id = "'+datsValue+'_DeletePara" onclick="Deletepara(\''+num+'\' ,  \''+datsValue+'\')"  > Delete Parameter '+num+' for'+datsValue+'</button> '+
                                        '</div>'+
                                    '</div>'+
                                '</div>';
                        
                    document.getElementById(datsValue+'_totalNum').value = num;
                    text.innerHTML =val;
                   
                    //$('#'+IDNew).append(val);
                    $( val ).insertAfter( '#'+IDNew );
                   //$('#ColorConditions').append(val);
                    
}



function InBetween(num , para , el){

    if(el.value == 'InBetween'){
        $('input[name="'+para+'_FirstParameter_'+num+'"]').attr("readonly", false);
    }
}
function selectAll(){
    $("#multipleCol > option").prop("selected","selected");// Select All Options
        $("#multipleCol").trigger("change");
}
    $('#ChangeChkBox').change(function(){
    if(this.checked)
        $('#ChangeChkBox').val('0');
   else
        $('#ChangeChkBox').val('1');
});
function showScrollFields(value){
   if(value == 1)
   {
       $('#ScrollDesignWidth').show();
       $('#FooterSumLocation').show();
       $('#PaginationFlag').show();
     
   }else{
        $('#ScrollDesignWidth').hide();
        $('#FooterSumLocation').hide();
        $('#PaginationFlag').hide();
   }
}
function showDiv(box) {
    var chboxs = document.getElementById(box).style.display;
    var vis = "none";
        if(chboxs=="none"){
         vis = "block"; }
        if(chboxs=="block"){
         vis = "none"; }
    document.getElementById(box).style.display = vis;
}

function showSideBar(box) {
    var chboxs = document.getElementById(box).style.display;
    var vis = "none";
        if(chboxs=="none"){
         vis = "block"; }
        if(chboxs=="block"){
         vis = "none"; }
    document.getElementById(box).style.display = vis;
}
</script>
<?php include_once realpath(__DIR__ . '/../..') . '/layout/Admin_Layout/footer_start.php'; ?>
