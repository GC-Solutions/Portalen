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
                    <form action="<?php echo baseUrl; ?>save_new_table" method="post" class="form-horizontal">
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

                                <div class="col-lg-9">
                                    <!-- <textarea name="FooterColumnsProperties"
                                              class="form-control"> <?= $FooterColumnsProperties = (isset($getTableDetails['FooterColumnsProperties'])) ? $getTableDetails['FooterColumnsProperties'] : ""; ?></textarea>
                                 -->
                                 <div id="MainFooterDiv">

                                 </div>
                                 <input type ="hidden" name="footerSumPro" id="footerSumPro" value="0"  />
                                 <button  type="button"  onclick="AddFooterCallBack()" >  Add Column Footer Sum property </button>          
                                 <button  type="button"  onclick="DeleteFooterCallBack()" >  Delete Footer Sum  </button>
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

                                <div class="col-lg-9">
                                    <!-- <textarea name="ChartColumn"
                                              class="form-control"> <?= $chartColumn = (isset($getTableDetails['ChartColumn'])) ? $getTableDetails['ChartColumn'] : ""; ?></textarea>
                                 -->
                                    <div id = "MainHighChartColumn">

                                    </div>
                                 <input type ="hidden" name="HighChartColumnTotal" id="HighChartColumnTotal" value="1"  />
                                 <input type ="hidden" name="HighChartXColumnTotal" id="HighChartXColumnTotal" value="1"  />
                                
                                 <button  id = "MainHighChartBtn" type="button"  onclick="AddHighChartColumn()" >  Add Graph Axis Column   </button>          
                                 <button style="display:none;"  id = "YaxisHighChartBtn" type="button"  onclick="AddHighChartColumn('Y')" > Add more Y Axis  </button>          
                                 <button style="display:none;"  id = "XaxisHighChartBtn" type="button"  onclick="AddHighChartColumn('X')" > Add more X Axis  </button>          
                                   
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="control-label col-md-3">
                                    HighMap Column
                                    <span class="required"> * </span>
                                </label>

                                <div class="col-md-4">
                                    <!-- <textarea name="MapColumn"
                                              class="form-control"> <?= $MapColumn = (isset($getTableDetails['MapColumn'])) ? $getTableDetails['MapColumn'] : ""; ?></textarea>
                                 -->
                                <div id = "MainHighMapColumn">

                                </div>
                                <input type ="hidden" name="HighMapColumnTotal" id="HighMapColumnTotal" value="0"  />
                                <button  id = "MainHighMapBtn" type="button"  onclick="AddHighMapColumn()" >  Add Map Column   </button>          
                                 
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="control-label col-md-3">
                                    Pie Chart Column
                                    <span class="required"> * </span>
                                </label>

                                <div class="col-md-4">
                                    <!-- <textarea name="PieChartColumn"
                                              class="form-control"> <?= $PieChartColumn = (isset($getTableDetails['PieChartColumn'])) ? $getTableDetails['PieChartColumn'] : ""; ?></textarea>
                                 -->
                                    <div id = "MainHighPieChartColumn">

                                    </div>
                                    <input type ="hidden" name="HighPieChartColumnTotal" id="HighPieChartColumnTotal" value="0"  />
                                    <button  type="button"  onclick="AddHighPieChartColumn()" >  Add Pie Chart Column   </button>          
                                    
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
                                <?php $LevelsColumn  = isset($getTableDetails["RowGroupLevelColumns"] )?json_decode($getTableDetails["RowGroupLevelColumns"] , true): ' ' ;
                               
                                ?>
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
                                                        
                                                            if ($LevelsColumn != ' ' && $value == $LevelsColumn['level1']) {
                                                                $selected = 'selected="selected"';
                                                                }
                                                            echo '<option value= "' . $value . '"' . $selected . '>' . $value . '</option>';
                                                        }
                                                    
                                                // }
                                                    ?>
                                                <?php } ?>
                                            </select>
                                            
                                        </div>
                                        <div class="col-md-3">
                                                    <button  type="button" id = "AddLevel" onclick="AddRowLevel('2')" >  Add more Levels</button> 
                                            </div>
                                    </div>
                                </div>
                                <div id = 'RowGroupLevel2' <?php if(isset($LevelsColumn) && $LevelsColumn == ' '  )  { ?>style="display:none;" <?php } ?> >
                                    <div class="form-group row" >     
                                        <label class="control-label col-md-3">
                                            Level 2
                                        </label>

                                        <div class="col-md-4">
                                            <select name="RowGroupLevelColumns2" id="GroupRowsColumn2"
                                                class="form-control select2-multiple dataSourceColumns" data-reorder="1" multiple data-maximum-selection-length="1" >
                                                <option value="">Select</option>
                                               
                                                    <?php if ($existingColumnsOfGroupRowLevel) {
                                                    foreach ($existingColumnsOfGroupRowLevel as $key => $value) {
                                                                $selected = "";
                                                                $value = trim($value);
                                                                if ($LevelsColumn != ' ' && $value == $LevelsColumn['level2']) {
                                                                    $selected = 'selected="selected"';
                                                                }
                                                                echo '<option value= "' . $value . '"' . $selected . '>' . $value . '</option>';
                                                            }
                                                        
                                                        ?>
                                                    <?php } ?>
                                                    
                                                    ?>
                                              
                                            </select>
                                           
                                        </div>
                                        <div class="col-md-3">
                                                    <button  type="button" id = "AddLevel" onclick="AddRowLevel('3')" >  Add more Levels</button> 
                                            </div>
                                    </div>
                                </div>
                                <div id = 'RowGroupLevel3' <?php if(isset($LevelsColumn) && $LevelsColumn == ' '   )  { ?>style="display:none;" <?php } ?>>
                                    <div class="form-group row" >     
                                        <label class="control-label col-md-3">
                                            Level 3
                                        </label>

                                        <div class="col-md-4">
                                            <select name="RowGroupLevelColumns3" id="GroupRowsColumn3"
                                                class="form-control select2-multiple dataSourceColumns" data-reorder="1" multiple data-maximum-selection-length="1" >
                                                <option value="">Select</option>
                                                <?php if ($existingColumnsOfGroupRowLevel) {
                                                 foreach ($existingColumnsOfGroupRowLevel as $key => $value) {
                                                            $selected = "";
                                                            $value = trim($value);
                                                        
                                                            if ($LevelsColumn != ' ' && $value == $LevelsColumn['level3']) {
                                                                $selected = 'selected="selected"';
                                                                }
                                                            echo '<option value= "' . $value . '"' . $selected . '>' . $value . '</option>';
                                                        }
                                                  
                                                    ?>
                                                <?php } ?>
                                            </select>
                                            
                                        </div>
                                        <div class="col-md-3">
                                                    <button  type="button" id = "AddLevel" onclick="AddRowLevel('4')" >  Add more Levels</button> 
                                            </div>
                                    </div>
                                </div>
                                <div id = 'RowGroupLevel4' <?php if( $LevelsColumn == ' ' )  { ?>style="display:none;" <?php } ?>>
                                    <div class="form-group row" >     
                                        <label class="control-label col-md-3">
                                            Level 4
                                        </label>

                                        <div class="col-md-4">
                                            <select name="RowGroupLevelColumns4" id="GroupRowsColumn4"
                                                class="form-control select2-multiple dataSourceColumns" data-reorder="1" multiple data-maximum-selection-length="1" >
                                                <option value="">Select</option>
                                                <?php if ($existingColumnsOfGroupRowLevel) {
                                                    
                                                        foreach ($existingColumnsOfGroupRowLevel as $key => $value) {
                                                            $selected = "";
                                                            $value = trim($value);
                                                        
                                                            if ($LevelsColumn != ' ' && $value == $LevelsColumn['level4']) {
                                                                $selected = 'selected="selected"';
                                                                }
                                                            echo '<option value= "' . $value . '"' . $selected . '>' . $value . '</option>';
                                                        }
                                                    
                                               
                                                    ?>
                                                <?php } ?>
                                            </select>
                                        </div>
                                        <div class="col-md-3">
                                                    <button  type="button" id = "AddLevel" onclick="AddRowLevel('5')" >  Add more Levels</button> 
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
                                <div class="col-lg-9">
                                    <!-- <textarea name="PredefineSearch"
                                              class="form-control"> <?= $PredefineSearch = (isset($getTableDetails['PredefineSearch'])) ? $getTableDetails['PredefineSearch'] : ""; ?></textarea>
                                 -->
                                    <div id = "MainPredefineSearchDiv">
                                    </div>
                                    <input type ="hidden" name="PredefineSearchTotal" id="PredefineSearchTotal" value="0"  />
                                    <button  type="button"  onclick="AddPredefineSearch()" >  Add Predefined Search </button>          
                                   
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="control-label col-md-3">
                                    Invisible Predefine Search value
                                </label>
                                <div class="col-lg-9">
                                    <!-- <textarea name="InvisiblePredefineSearch"
                                              class="form-control"> <?= $InvisiblePredefineSearch = (isset($getTableDetails['InvisiblePredefineSearch'])) ? $getTableDetails['InvisiblePredefineSearch'] : ""; ?></textarea>
                                 -->
                                 <input type ="hidden" name="InvisiblePredefineSearchTotal" id="InvisiblePredefineSearchTotal" value="0"  />
                                   
                                   <button  type="button"  onclick="AddInvisiblePredefineSearch()" >  Add Invisible Predefined Search </button>          
                                   <div id = "MainInvisiblePredefineSearchDiv">

                                   </div>
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
                                <div class="col-lg-9">
                                    <!-- <textarea name="PredefineSearchForRange"
                                              class="form-control"> <?= $PredefineSearch = (isset($getTableDetails['PredefineSearchForRange'])) ? $getTableDetails['PredefineSearchForRange'] : ""; ?></textarea>
                                    -->
                                    <input type ="hidden" name="PredefineSearchForRangeTotal" id="PredefineSearchForRangeTotal" value="0"  />
                                   
                                   <button  type="button"  onclick="AddPredefineSearchForRange()" >  Add  Predefined Search For Range  </button>          
                                   <div id = "MainPredefineSearchForRangeDiv">

                                   </div>     
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
                                   Enable on row click instead of Action button 
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

function ShowColWidth(checkbox){
    if (checkbox.checked)
    {
       $('#ColumnFilterWidth').show();
   }else{
        $('#ColumnFilterWidth').hide();
   }
}
<?php
if(isset($getTableDetails["PieChartColumn"]) &&  $getTableDetails['PieChartColumn'] != '') { 
    
    $PieChartColumn = json_decode($getTableDetails["PieChartColumn"], true);
    $PieChartColumn = array_values($PieChartColumn);
    $PieChartColumnCnt = count($PieChartColumn); 
    for ($num = 0; $num < $PieChartColumnCnt; $num++) { ?>

        <?php if($num >= 0 && $num <= 2 ){ ?>
            var num = 1;
        <?php }else { ?>
           
            var num = <?php echo $num ; ?>;
            var num =  parseInt(num)-1;
            var oldnum =  parseInt(num)-1 ; 
           
        <?php } ?>
      
        var text = document.createElement('div');
        var val = '';
        <?php if($num >= 2 ){ ?>
            val += ' <div id="HighPieChartColumn'+num+'">';
        <?php } ?>
      
        if(num == 1){
            <?php if($num == 0){
                $piechart = isset($PieChartColumn[$num]["type"])?$PieChartColumn[$num]["type"]:1; ?>
                val +=  '<div class="form-group row">'+
                            '<label class="control-label col-md-3">'+
                                ' Pie Chart Type'+
                            '</label>'+
                            '<div class="col-md-4">'+
                                '<select name="HighPieChartColumn_PieChartType" id="HighPieChartColumn_PieChartType"  class="form-control" >'+ 
                                '<option value="1" <?php if($piechart == 1){echo 'selected="selected"' ; }?>>Default or Semi Pie Chart </option>'+   
                                '<option value="2" <?php if($piechart == 2){echo 'selected="selected"' ; }?>>Semi Pie Chart</option>'+   
                                '<option value="3" <?php if($piechart == 3){echo 'selected="selected"' ; }?>>Drill Down Piechart</option>'+     
                                ' </select>'+
                            '</div>'+
                        '</div>';
            <?php }else if($num == 1){ ?>
                    val+=  '<div class="form-group row" >'+
                                '<label class="control-label col-md-3">'+
                                    ' Pie Chart Label'+
                                '</label>'+

                                '<div class="col-md-4">'+
                                        ' <input type="text" name="HighPieChartColumn_PieChartLabel" value="<?php echo isset($PieChartColumn[$num]["label"])?$PieChartColumn[$num]["label"]:''; ?>" class="form-control" />'+
                                '</div>'+
                            '</div>';
            <?php } ?>
                        
        }
        <?php if($num >= 2){ ?>
            val +=      '<div class="form-group row">'+
                            ' <label class="control-label col-md-3">'+
                                'Field '+ num+
                            '</label>'+

                            ' <div class="col-md-4">'+
                                '<select name="HighPieChartColumn_field'+num+'" id="HighPieChartColumn_field'+num+'"  class="form-control  dataSourceColumns" >'+ 
                                ' </select>'+
                            '</div>'+
                        ' </div>'+
                        
                        '<div class="form-group row" style ="display:none;" id ="HighPieChartColumn_drilldown'+num+'">'+
                            '<label class="control-label col-md-3">'+
                                'Drill Down '+
                            '</label>'+

                            '<div class="col-md-4">'+
                                    ' <input type="checkbox" name="HighPieChartColumn_drilldown'+num+'" value="<?php echo isset($PieChartColumn[$num]["drilldown"])?1:''; ?>"  <?php echo isset($PieChartColumn[$num]["drilldown"])?'checked':''; ?>  />'+
                            '</div>'+
                        '</div>'+
                    '</div>';

        //val += '<button  type="button"  onclick="DeleteHighPieChartColumn( \'HighPieChartColumn'+num+'\')" >  Delete High Pie chart Column  </button>';
        <?php } ?>
                    
        text.innerHTML =val;

        if(num == 1){
            
            $( '#MainHighPieChartColumn').append(val);
            var $options = $('#multipleCol option').clone();
            $('#HighPieChartColumn_field'+num).append($options);
            <?php if (isset($PieChartColumn[$num]['field'])){?>
                $('#HighPieChartColumn_field'+num).val("<?php print_r($PieChartColumn[$num]['field']); ?>").change();
            <?php } ?>
        }else{
            $( val ).insertAfter( '#HighPieChartColumn'+oldnum );
            var $options = $('#multipleCol option').clone();
            $('#HighPieChartColumn_field'+num).append($options);
            <?php if (isset($PieChartColumn[$num]['field'])){?>
                $('#HighPieChartColumn_field'+num).val("<?php print_r($PieChartColumn[$num]['field']); ?>").change();
            <?php } ?>    

        }

        var GraphType = document.getElementById('HighPieChartColumn_PieChartType').value;
        if(GraphType == '3'){
            $('#HighPieChartColumn_drilldown'+num).show();
        }else{
            $('#HighPieChartColumn_drilldown'+num).hide();
        }


<?php } 
?>
    document.getElementById('HighPieChartColumnTotal').value = num-2;
<?php }
 ?>
function AddHighPieChartColumn(){
    var num = document.getElementById('HighPieChartColumnTotal').value;
    var oldnum = num;        
    num = parseInt(num)+1;
    document.getElementById('HighPieChartColumnTotal').value = num;      
    var text = document.createElement('div');
    var val = '';
    
    val += '    <div id="HighPieChartColumn'+num+'">';

    if(num == 1){
        val +=      '<div class="form-group row">'+
                        '<label class="control-label col-md-3">'+
                            ' Pie Chart Type'+
                        '</label>'+
                        '<div class="col-md-4">'+
                            '<select name="HighPieChartColumn_PieChartType" id="HighPieChartColumn_PieChartType"  class="form-control" >'+ 
                            '<option value="1">Default Pie Chart </option>'+   
                            '<option value="2">Semi Pie Chart</option>'+   
                            '<option value="3">Drill Down Piechart</option>'+   
                            ' </select>'+
                        '</div>'+
                    '</div>'+
                    '<div class="form-group row" >'+
                        '<label class="control-label col-md-3">'+
                            ' Pie Chart Label'+
                        '</label>'+

                        '<div class="col-md-4">'+
                                ' <input type="text" name="HighPieChartColumn_PieChartLabel" value="" class="form-control" />'+
                        '</div>'+
                    '</div>';
                    
    }
  
    val +=          '<div class="form-group row">'+
                        ' <label class="control-label col-md-3">'+
                            'Field '+ num+
                        '</label>'+

                        ' <div class="col-md-4">'+
                            '<select name="HighPieChartColumn_field'+num+'" id="HighPieChartColumn_field'+num+'"  class="form-control  dataSourceColumns" >'+ 
                            ' </select>'+
                        '</div>'+
                    ' </div>'+
                    
                    '<div class="form-group row" style ="display:none;" id ="HighPieChartColumn_drilldown'+num+'">'+
                        '<label class="control-label col-md-3">'+
                            'Drill Down '+
                        '</label>'+

                        '<div class="col-md-4">'+
                                ' <input type="checkbox" name="HighPieChartColumn_drilldown'+num+'" value="1"  />'+
                        '</div>'+
                    '</div>'+
                '</div>';

    //val += '<button  type="button"  onclick="DeleteHighPieChartColumn( \'HighPieChartColumn'+num+'\')" >  Delete High Pie chart Column  </button>';

                   
    text.innerHTML =val;

    if(num == 1){
        
        $( '#MainHighPieChartColumn').append(val);
    }else{
        $( val ).insertAfter( '#HighPieChartColumn'+oldnum );
    }
   
    var $options = $('#multipleCol option').clone();
    $('#HighPieChartColumn_field'+num).append($options);

    var GraphType = document.getElementById('HighPieChartColumn_PieChartType').value;
    if(GraphType == '3'){
        $('#HighPieChartColumn_drilldown'+num).show();
    }else{
        $('#HighPieChartColumn_drilldown'+num).hide();
    }

}

function DeleteHighPieChartColumn(id){
    var CountNum = document.getElementById('HighPieChartColumnTotal').value;
    if(CountNum > 1){
        document.getElementById('HighPieChartColumnTotal').value = CountNum - 1;
        $('#'+id).remove();
    }
}
function AddHighMapColumn(){
    var num = document.getElementById('HighMapColumnTotal').value;
    var oldnum = num;        
    num = parseInt(num)+1;
    document.getElementById('HighMapColumnTotal').value = num;      
    var text = document.createElement('div');
    if(num == 1){

        var val = '';
        val += ' <div id="HighMapColumn'+num+'">'+
                    '<div class="form-group row">'+
                        ' <label class="control-label col-md-3">'+
                            ' Select Code Column Name'+ num+
                        '</label>'+

                        ' <div class="col-md-4">'+
                            '<select name="HighMapColumn_field0" id="HighMapColumn_ColumnName'+num+'"  class="form-control  dataSourceColumns" >'+ 
                            ' </select>'+
                        '</div>'+
                    ' </div>'+
                    '<div class="form-group row">'+
                        '<label class="control-label col-md-3">'+
                         'label '+
                        '</label>'+

                        '<div class="col-md-4">'+
                            '   <input type="text" name="HighMapColumn_label0"  value="code" class="form-control" readonly />'+
                        '</div>'+
                    '</div>'+
                    '<div class="form-group row">'+
                        '<label class="control-label col-md-3">'+
                         'Title'+
                        '</label>'+

                        '<div class="col-md-4">'+
                            '   <input type="text" name="HighMapColumn_title0"  value="" class="form-control"/>'+
                        '</div>'+
                    '</div>'+
                    '<div class="form-group row">'+
                        '<label class="control-label col-md-3">'+
                            'Select Column'+
                        '</label>'+

                        '<div class="col-md-4">'+
                            '<select name="HighMapColumn_field'+num+'" id="HighMapColumn_ColumnNamet'+num+'"  class="form-control  dataSourceColumns" >'+ 
                            ' </select>'+
                        '</div>'+
                    '</div>'+
                    '<div class="form-group row">'+
                        '<label class="control-label col-md-3">'+
                         'label'+
                        '</label>'+

                        '<div class="col-md-4">'+
                            '   <input type="text" name="HighMapColumn_label'+num+'"  value="y" class="form-control" readonly/>'+
                        '</div>'+
                    '</div>'+
                   
                '</div>';
    }else{
        var val = '';
        val += ' <div id="HighMapColumn'+num+'">'+
                    '<div class="form-group row">'+
                        '<label class="control-label col-md-3">'+
                            'Select Column'+
                        '</label>'+

                        '<div class="col-md-4">'+
                            '<select name="HighMapColumn_field'+num+'" id="HighMapColumn_ColumnName'+num+'"  class="form-control  dataSourceColumns" >'+ 
                            ' </select>'+
                        '</div>'+
                    '</div>'+
                    '<div class="form-group row">'+
                        '<label class="control-label col-md-3">'+
                                'label'+
                        '</label>'+

                        '<div class="col-md-4">'+
                            '   <input type="text" name="HighMapColumn_label'+num+'"  value="y" class="form-control" readonly/>'+
                        '</div>'+
                    '</div>'+
                   
                '</div>';
         val += '<button  type="button"  onclick="DeleteHighMapColumn( \'HighMapColumn'+num+'\')" >  Delete High Map Column  </button>';


    }           
    text.innerHTML =val;

    if(num == 1){
        
        $( '#MainHighMapColumn').append(val);
        var $options = $('#multipleCol option').clone();
        $('#HighMapColumn_ColumnName'+num).append($options);
        var $options = $('#multipleCol option').clone();
        $('#HighMapColumn_ColumnNamet'+num).append($options);
    }else{

        $( val ).insertAfter( '#HighMapColumn'+oldnum );
        var $options = $('#multipleCol option').clone();
        $('#HighMapColumn_ColumnName'+num).append($options);
    }
    

}
function DeleteHighMapColumn(id){
    var CountNum = document.getElementById('HighMapColumnTotal').value;
    if(CountNum > 1){
        document.getElementById('HighMapColumnTotal').value = CountNum - 1;
        $('#'+id).remove();
    }
}

function ShowInputColumnFtn(num , Axis){
    var checkbox = document.getElementById('ShowInputColumn'+num);
    
    if(Axis == 'X'){
        if(checkbox.checked){
            $('#ColumnNameX'+num+'axisInput').show();
            $('#ColumnNameX'+num+'axisSelect').hide();
        }else{
            $('#ColumnNameX'+num+'axisInput').hide();
            $('#ColumnNameX'+num+'axisSelect').show();
        }
    }
    else {
        if (checkbox.checked)
        {
            $('#ColumnNameY'+num+'axisInput').show();
            $('#ColumnNameY'+num+'axisSelect').hide();
            $('#ColumnSumY'+num+'axis').show();
            
        }else{
            $('#ColumnNameY'+num+'axisInput').hide();
            $('#ColumnNameY'+num+'axisSelect').show();
            $('#ColumnSumY'+num+'axis').hide();
        }
    }
}
function  addXAxisbtn(){
    var GraphType = document.getElementById('GraphType').value;
    if(GraphType == 'DrilldownChart' || GraphType == 'SunbrustChart' ){
        $('#XaxisHighChartBtn').show();
    }
}
<?php 
if (isset($getTableDetails["ChartColumn"]) &&  $getTableDetails['ChartColumn'] != '') {
    $ChartColumn = json_decode($getTableDetails["ChartColumn"], true);
    $ChartColumn = array_values($ChartColumn);
    $ChartColumnCnt = count($ChartColumn); 
    for ($num = 0; $num < $ChartColumnCnt; $num++) { 
        if( $num == 0 || $num >= 2){ ?>
             var text = document.createElement('div');
        <?php }  if($num == 0 || $num == 1){ ?>
            var num = 2;
        <?php }else{ ?>
                var num = <?php echo $num; ?> 
                var oldnum = parseInt(num)-1; 
                //var num = parseInt(oldnum)+1;
        <?php }  ?>
       

        if(num == 2){
        
                var val = '';
                <?php if($num == 0 ){ ?>
                val +=      '<div class="form-group row">'+
                            ' <label class="control-label col-md-3">'+
                                ' Graph Type '+
                            '</label>'+

                            ' <div class="col-md-4">'+
                                '<select name="GraphType" id="GraphType"  class="form-control" onchange="addXAxisbtn()" >'+ 
                                '<option value= "LineChart">Line or Column or other Chart</option>'+
                                '<option value= "DrilldownChart">Drilldown OR Sunbrust Chart</option>'+
                                ' </select>'+
                            '</div>'+
                        ' </div>'+
                        '<div class="form-group row">'+
                            ' <label class="control-label col-md-3">'+
                                ' Column Name '+
                            '</label>'+

                            ' <div class="col-md-4">'+
                                '<select name="HighChartColumn_labelX0" id="ColumnNameXaxis"  class="form-control  dataSourceColumns" >'+ 
                                ' </select>'+
                                '</div>'+
                        ' </div>'+
                        '<div class="form-group row">'+
                            '<label class="control-label col-md-3">'+
                                'Axis'+
                            '</label>'+

                            '<div class="col-md-4">'+
                                '   <input type="text" name="HighChartColumn_axisX0"  value="X"  class="form-control" readonly/>'+
                            '</div>'+
                        '</div>';
                <?php } else if($num == 1 ){ ?>
                val +=      '<div class="form-group row">'+
                            ' <label class="control-label col-md-3">'+
                                ' Column Name ' +
                            '</label>'+

                            ' <div class="col-md-4">'+
                                '<select name="HighChartColumn_labelY1" id="ColumnNameYaxis"  class="form-control  dataSourceColumns" >'+ 
                                ' </select>'+
                            '</div>'+
                        ' </div>'+
                        '<div class="form-group row">'+
                            '<label class="control-label col-md-3">'+
                                'Axis'+
                            '</label>'+

                            '<div class="col-md-4">'+
                                '   <input type="text" name="HighChartColumn_axisY1"  value="Y"  class="form-control" readonly />'+
                            '</div>'+
                        '</div>';
                <?php } else if($num == 2 ){ ?>
                val +=  '<div id= "MoreAxis'+num+'">'+
                        '<div class="form-group row">'+
                            ' <label class="control-label col-md-3">'+
                                'Custom Sum ' +
                            '</label>'+

                            ' <div class="col-md-4">'+
                                    '<input type="checkbox" onchange="ShowInputColumnFtn('+num+')" name="ShowInputColumn'+num+'" id="ShowInputColumn'+num+'"  <?php if(isset($ChartColumn[$num]["custom_sumY".$num])){ ?> checked <?php } ?> value="<?php echo (isset($ChartColumn[$num]["custom_sumY".$num]))?1:''; ?>" />'+
                                '</div>'+
                        ' </div>'+
                        '<div class="form-group row">'+
                            ' <label class="control-label col-md-3">'+
                                ' Column Name '+
                            '</label>'+

                            ' <div class="col-md-4">'+
                                ' <div id = "ColumnNameY'+num+'axisSelect">'+
                                    '<select name="HighChartColumn_labelY'+num+'" id="ColumnNameY'+num+'axis"  class="form-control  dataSourceColumns" >'+ 
                                    ' </select>'+
                                '</div> <div id = "ColumnNameY'+num+'axisInput" style = "display:none;">'+
                                    '<input type="text" name="HighChartColumn_labelY'+num+'_Input"  id= name="HighChartColumn_labelY'+num+'_Input" value="" class="form-control"/>'+
                                '</div>'+
                                '</div>'+
                        ' </div>'+
                        '<div class="form-group row" id = "ColumnSumY'+num+'axis" style = "display:none;">'+
                            ' <label class="control-label col-md-3">'+
                                'Custom Sum Formula'+num+
                            '</label>'+
                            ' <div class="col-md-4">'+
                                    '<input type="text" name="HighChartColumn_custom_sumY'+num+'"  value="<?php echo(isset($ChartColumn[$num]["custom_sumY".$num]))?$ChartColumn[$num]["custom_sumY".$num]:''; ?>" class="form-control"/>'+
                                '</div>'+
                        ' </div>'+
                        '<div class="form-group row">'+
                            '<label class="control-label col-md-3">'+
                                'Axis'+
                            '</label>'+

                            '<div class="col-md-4">'+
                                '   <input type="text" name="HighChartColumn_axisY'+num+'"  value="Y2"  class="form-control" readonly/>'+
                            '</div>'+
                        '</div>'+
                        '<div class="form-group row">'+
                            '<label class="control-label col-md-3">'+
                                'is Series '+
                            '</label>'+

                            '<div class="col-md-4">'+
                                ' <input type="checkbox" name="HighChartColumn_is_seriesY'+num+'" value="<?php echo(isset($ChartColumn[$num]["is_series"]))?1:''; ?>" <?php if(isset($ChartColumn[$num]["is_series"])){ ?> checked <?php } ?> />'+
                            '</div>'+
                        '</div>'+
                        '<div class="form-group row">'+
                            '<label class="control-label col-md-3">'+
                                'is Secondray  '+
                            '</label>'+

                            '<div class="col-md-4">'+
                                ' <input type="checkbox" name="HighChartColumn_is_secondaryY'+num+'" value="<?php echo(isset($ChartColumn[$num]["is_secondary"]))?1:''; ?>"  <?php if(isset($ChartColumn[$num]["is_secondary"])){ ?> checked <?php } ?> />'+
                            '</div>'+
                        '</div>'+
                    '</div>';
                <?php } ?>
        }else{
            var val = '';
            var Axis = '';
            <?php   if(strpos($ChartColumn[$num]["axis"] , 'X1') !== false || strpos($ChartColumn[$num]["axis"] , 'X2') !== false){ ?>
                Axis = 'X' ;
            <?php } ?>
            if(Axis == 'X'){

                val +=  '<div id= "MoreAxis'+num+'">'+
                        '<div class="form-group row">'+
                            ' <label class="control-label col-md-3">'+
                                'Custom Sum '+
                            '</label>'+

                            ' <div class="col-md-4">'+
                                    '<input type="checkbox" onchange="ShowInputColumnFtn('+num+' , \''+Axis+'\')" name="ShowInputColumn'+num+'" id="ShowInputColumn'+num+'"  <?php if(isset($ChartColumn[$num]["custom_sumY".$num])){ ?> checked <?php } ?> value="<?php echo (isset($ChartColumn[$num]["custom_sumY".$num]))?1:''; ?>" />'+
                            '</div>'+
                        ' </div>';
                var num = document.getElementById('HighChartXColumnTotal').value;
                document.getElementById('HighChartColumnTotal').value = oldnum;
                var num1 = document.getElementById('HighChartColumnTotal').value;
                val +=        '<div class="form-group row">'+
                            ' <label class="control-label col-md-3">'+
                                ' Column Name X'+num+
                            '</label>'+

                            ' <div class="col-md-4">'+
                                ' <div id = "ColumnNameX'+num1+'axisSelect">'+
                                    '<select name="HighChartColumn_labelX'+num+'" id="ColumnNameX'+num1+'axis"  class="form-control  dataSourceColumns" >'+ 
                                    ' </select>'+
                                '</div> <div id = "ColumnNameX'+num1+'axisInput" style = "display:none;">'+
                                    '<input type="text" name="HighChartColumn_labelX'+num+'" id ="HighChartColumn_labelX'+num+'"  value="" class="form-control"/>'+
                                '</div>'+
                                '</div>'+
                        ' </div>'+
                        
                        '<div class="form-group row">'+
                            '<label class="control-label col-md-3">'+
                                'Axis X'+num+
                            '</label>'+

                            '<div class="col-md-4">'+
                                '   <input type="text" name="axisX'+num+'"  value="X'+num+'"  class="form-control" readonly />'+
                            '</div>'+
                        
                    '</div>';
                    document.getElementById('HighChartXColumnTotal').value = parseInt(num)+1;
                    var num = document.getElementById('HighChartColumnTotal').value;
            }
            else {
                val +=  '<div id= "MoreAxis'+num+'">'+
                            '<div class="form-group row">'+
                                ' <label class="control-label col-md-3">'+
                                    'Custom Sum '+
                                '</label>'+

                                ' <div class="col-md-4">'+
                                '<input type="checkbox" onchange="ShowInputColumnFtn('+num+')" name="ShowInputColumn'+num+'" id="ShowInputColumn'+num+'"  <?php if(isset($ChartColumn[$num]["custom_sumY".$num])){ ?> checked <?php } ?> value="<?php echo (isset($ChartColumn[$num]["custom_sumY".$num]))?1:''; ?>" />'+
                                '</div>'+
                            ' </div>'+
                            '<div class="form-group row">'+
                                ' <label class="control-label col-md-3">'+
                                    ' Column Name Y'+num+
                                '</label>'+

                                ' <div class="col-md-4">'+
                                ' <div id = "ColumnNameY'+num+'axisSelect">'+
                                        '<select name="HighChartColumn_labelY'+num+'" id="ColumnNameY'+num+'axis"  class="form-control  dataSourceColumns" >'+ 
                                        ' </select>'+
                                    '</div> <div id = "ColumnNameY'+num+'axisInput" style = "display:none;">'+
                                        '<input type="text" name="HighChartColumn_labelY'+num+'_Input" id="HighChartColumn_labelY'+num+'_Input"  value="" class="form-control"/>'+
                                    '</div>'+
                                '</div>'+
                            ' </div>'+
                            '<div class="form-group row" id = "ColumnSumY'+num+'axis" style = "display:none;">'+
                                ' <label class="control-label col-md-3">'+
                                    'Custom Sum Formula'+num+
                                '</label>'+
                                ' <div class="col-md-4">'+
                                        '<input type="text" name="HighChartColumn_custom_sumY'+num+'"  value="<?php echo(isset($ChartColumn[$num]["custom_sumY".$num]))?$ChartColumn[$num]["custom_sumY".$num]:''; ?>" class="form-control"/>'+
                                '</div>'+
                            ' </div>'+
                            '<div class="form-group row">'+
                                '<label class="control-label col-md-3">'+
                                    'Axis Y'+num+
                                '</label>'+

                                '<div class="col-md-4">'+
                                    '   <input type="text" name="HighChartColumn_axisY'+num+'"  value="Y'+num+'"  class="form-control" readonly/>'+
                                '</div>'+
                            '</div>'+
                            '<div class="form-group row">'+
                                '<label class="control-label col-md-3">'+
                                    'is Series Y'+num+
                                '</label>'+

                                '<div class="col-md-4">'+
                                    ' <input type="checkbox" name="HighChartColumn_is_seriesY'+num+'" value="<?php echo(isset($ChartColumn[$num]["is_series"]))?1:''; ?>" <?php if(isset($ChartColumn[$num]["is_series"])){ ?> checked <?php } ?> />'+
                                '</div>'+
                            '</div>'+
                            '<div class="form-group row">'+
                                '<label class="control-label col-md-3">'+
                                    'is Secondray  Y'+num+
                                '</label>'+

                                '<div class="col-md-4">'+
                                    ' <input type="checkbox" name="HighChartColumn_is_secondaryY'+num+'" value="<?php echo(isset($ChartColumn[$num]["is_secondary"]))?1:''; ?>" <?php if(isset($ChartColumn[$num]["is_secondary"])){ ?> checked <?php } ?>  />'+
                                '</div>'+
                            '</div>'+
                            '<div class="form-group row">'+
                                '<label class="control-label col-md-3">'+
                                    'Type Y'+num+
                                '</label>'+

                                '<div class="col-md-4">'+
                                    ' <input type="text" name="HighChartColumn_typeY'+num+'" value="<?php echo(isset($ChartColumn[$num]["type"]))?$ChartColumn[$num]["type"]:''; ?>"  class="form-control"  />'+
                                '</div>'+
                            '</div>'+
                            '<div class="form-group row">'+
                                '<label class="control-label col-md-3">'+
                                    'hide secondary name'+num+
                                '</label>'+

                                '<div class="col-md-4">'+
                                    ' <input type="checkbox" name="HighChartColumn_hide_secondary_nameY'+num+'" value="<?php echo(isset($ChartColumn[$num]["hide_secondary_name"]))?1:''; ?>"  <?php if(isset($ChartColumn[$num]["hide_secondary_name"])){ ?> checked <?php } ?> />'+
                                '</div>'+
                            '</div>'+
                            '<div class="form-group row">'+
                                '<label class="control-label col-md-3">'+
                                    'secondary axis'+num+
                                '</label>'+

                                '<div class="col-md-4">'+
                                    ' <input type="text" name="HighChartColumn_secondary_axisY'+num+'" value="<?php echo(isset($ChartColumn[$num]["secondary_axis"]))?$ChartColumn[$num]["secondary_axis"]:''; ?>"  class="form-control"  />'+
                                '</div>'+
                            '</div>'+
                            
                            
                        '</div>';
            }        
        
        }
        text.innerHTML =val;
       
        if(num == 2){

            $( '#MainHighChartColumn').append(val);
            var $options = $('#multipleCol option').clone();
            $('#ColumnNameYaxis').append($options);

            <?php  if($ChartColumn[$num]['axis'] == 'Y'){ ?>
                    $('#ColumnNameYaxis').val("<?php print_r($ChartColumn[$num]['label']); ?>").change();
            <?php } ?>
        
                            
            var $options = $('#multipleCol option').clone();
            $('#ColumnNameXaxis').append($options);
            <?php  if($ChartColumn[$num]['axis'] == 'X'){ ?>
                $('#ColumnNameXaxis').val("<?php print_r($ChartColumn[$num]['label']); ?>").change();
            <?php } ?> 

            var $options = $('#multipleCol option').clone();
            $('#ColumnNameY'+num+'axis').append($options);

            <?php  if($ChartColumn[$num]['axis'] == 'Y2'){  ?>
                var checkbox = document.getElementById('ShowInputColumn'+num);
                if (typeof(checkbox) != 'undefined' && checkbox != null && checkbox.checked)
                {
                    $('#HighChartColumn_labelY'+num+'_Input').val("<?php print_r($ChartColumn[$num]['label']); ?>");
                    $('#ColumnNameY'+num+'axisInput').show();
                    $('#ColumnNameY'+num+'axisSelect').hide();
                    $('#ColumnSumY'+num+'axis').show();
                    
                }else{
                    $('#ColumnNameY'+num+'axis').val("<?php print_r($ChartColumn[$num]['label']); ?>").change();
                    $('#ColumnNameY'+num+'axisInput').hide();
                    $('#ColumnNameY'+num+'axisSelect').show();
                    $('#ColumnSumY'+num+'axis').hide();
                }
                
            <?php } ?>
            
            
            $('#MainHighChartBtn').hide();
            $('#YaxisHighChartBtn').show();
        }else{
            $( val ).insertAfter( '#MoreAxis'+oldnum );
        
            if(Axis == 'X')
            {
                var $options = $('#multipleCol option').clone();
                $('#ColumnNameX'+num+'axis').append($options);
                var checkbox = document.getElementById('ShowInputColumn'+num);
                if(checkbox.checked){

                    $('#HighChartColumn_labelX'+num).val("<?php print_r($ChartColumn[$num]['label']); ?>");
                    $('#ColumnNameX'+num+'axisInput').show();
                    $('#ColumnNameX'+num+'axisSelect').hide();
                }else{
                    $('#ColumnNameX'+num+'axis').val("<?php print_r($ChartColumn[$num]['label']); ?>").change();
                    $('#ColumnNameX'+num+'axisInput').hide();
                    $('#ColumnNameX'+num+'axisSelect').show();
                }
                
            }else{
                var $options = $('#multipleCol option').clone();
                $('#ColumnNameY'+num+'axis').append($options);
                var checkbox = document.getElementById('ShowInputColumn'+num);
                if (checkbox.checked)
                {
                    <?php //print_r($ChartColumn); print_r($num); exit;?>
                    $('#HighChartColumn_labelY'+num+'_Input').val("<?php print_r($ChartColumn[$num]['label']); ?>");
                    $('#ColumnNameY'+num+'axisInput').show();
                    $('#ColumnNameY'+num+'axisSelect').hide();
                    $('#ColumnSumY'+num+'axis').show();
                    
                }else{
                    $('#ColumnNameY'+num+'axis').val("<?php print_r($ChartColumn[$num]['label']); ?>").change();
                    $('#ColumnNameY'+num+'axisInput').hide();
                    $('#ColumnNameY'+num+'axisSelect').show();
                    $('#ColumnSumY'+num+'axis').hide();
                }
            }
        }
        document.getElementById('HighChartColumnTotal').value = <?php echo $ChartColumnCnt ; ?>;

<?php }
    
}
?>
function AddHighChartColumn(Axis){
    var num = document.getElementById('HighChartColumnTotal').value;
    var oldnum = num;        
    num = parseInt(num)+1;
    
    document.getElementById('HighChartColumnTotal').value = num;  
    var text = document.createElement('div');
    if(num == 2){
       
        var val = '';
        val +=      '<div class="form-group row">'+
                        ' <label class="control-label col-md-3">'+
                            ' Graph Type '+
                        '</label>'+

                        ' <div class="col-md-4">'+
                            '<select name="GraphType" id="GraphType"  class="form-control" onchange="addXAxisbtn()" >'+ 
                            '<option value= "LineChart">Line Chart</option>'+
                            '<option value= "ColumnChart"> Column Chart</option>'+
                            '<option value= "DrilldownChart">Drilldown Chart</option>'+
                            '<option value= "SunbrustChart"> Sunbrust Chart</option>'+
                            '<option value= "ComboChart"> Combo Chart</option>'+
                            ' </select>'+
                        '</div>'+
                    ' </div>'+
                    '<div class="form-group row">'+
                        ' <label class="control-label col-md-3">'+
                            ' Column Name '+
                        '</label>'+

                        ' <div class="col-md-4">'+
                            '<select name="HighChartColumn_labelX0" id="ColumnNameXaxis"  class="form-control  dataSourceColumns" >'+ 
                            ' </select>'+
                            // '<input type="text" name="PredefineSearchForRange_ColumnName'+num+'"  value="" class="form-control"/>'+
                        '</div>'+
                    ' </div>'+
                    '<div class="form-group row">'+
                        '<label class="control-label col-md-3">'+
                            'Axis'+
                        '</label>'+

                        '<div class="col-md-4">'+
                            '   <input type="text" name="HighChartColumn_axisX0"  value="X"  class="form-control" readonly/>'+
                        '</div>'+
                    '</div>'+
                    '<div class="form-group row">'+
                        ' <label class="control-label col-md-3">'+
                            ' Column Name ' +
                        '</label>'+

                        ' <div class="col-md-4">'+
                            '<select name="HighChartColumn_labelY1" id="ColumnNameYaxis"  class="form-control  dataSourceColumns" >'+ 
                            ' </select>'+
                            // '<input type="text" name="PredefineSearchForRange_ColumnName'+num+'"  value="" class="form-control"/>'+
                        '</div>'+
                    ' </div>'+
                    '<div class="form-group row">'+
                        '<label class="control-label col-md-3">'+
                            'Axis'+
                        '</label>'+

                        '<div class="col-md-4">'+
                            '   <input type="text" name="HighChartColumn_axisY1"  value="Y"  class="form-control" readonly />'+
                        '</div>'+
                    '</div>';
        val +=  '<div id= "MoreAxis'+num+'">'+
                    '<div class="form-group row">'+
                        ' <label class="control-label col-md-3">'+
                            'Custom Sum ' +
                        '</label>'+

                        ' <div class="col-md-4">'+
                         '<input type="checkbox" name="ShowInputColumn'+num+'" value="1" id= "ShowInputColumn'+num+'" onchange="ShowInputColumnFtn('+num+')" />'+
                        '</div>'+
                    ' </div>'+
                    '<div class="form-group row">'+
                        ' <label class="control-label col-md-3">'+
                            ' Column Name '+
                        '</label>'+

                        ' <div class="col-md-4">'+
                           ' <div id = "ColumnNameY'+num+'axisSelect">'+
                                '<select name="HighChartColumn_labelY'+num+'" id="ColumnNameY'+num+'axis"  class="form-control  dataSourceColumns" >'+ 
                                ' </select>'+
                            '</div> <div id = "ColumnNameY'+num+'axisInput" style = "display:none;">'+
                                '<input type="text" name="HighChartColumn_labelY'+num+'_Input"  value="" class="form-control"/>'+
                            '</div>'+
                         '</div>'+
                    ' </div>'+
                    '<div class="form-group row" id = "ColumnSumY'+num+'axis" style = "display:none;">'+
                        ' <label class="control-label col-md-3">'+
                            'Custom Sum Formula'+num+
                        '</label>'+
                        ' <div class="col-md-4">'+
                                '<input type="text" name="HighChartColumn_custom_sumY'+num+'"  value="" class="form-control"/>'+
                         '</div>'+
                    ' </div>'+
                    '<div class="form-group row">'+
                        '<label class="control-label col-md-3">'+
                            'Axis'+
                        '</label>'+

                        '<div class="col-md-4">'+
                            '   <input type="text" name="HighChartColumn_axisY'+num+'"  value="Y2"  class="form-control" readonly/>'+
                        '</div>'+
                    '</div>'+
                    '<div class="form-group row">'+
                        '<label class="control-label col-md-3">'+
                            'is Series '+
                        '</label>'+

                        '<div class="col-md-4">'+
                            ' <input type="checkbox" name="HighChartColumn_is_seriesY'+num+'" value="1"  />'+
                        '</div>'+
                    '</div>'+
                    '<div class="form-group row">'+
                        '<label class="control-label col-md-3">'+
                            'is Secondray  '+
                        '</label>'+

                        '<div class="col-md-4">'+
                            ' <input type="checkbox" name="HighChartColumn_is_secondaryY'+num+'" value="1"  />'+
                        '</div>'+
                    '</div>'+
                '</div>';

                   
   
    }else{
        var val = '';
        if(Axis == 'X'){

            val +=  '<div id= "MoreAxis'+num+'">'+
                    '<div class="form-group row">'+
                        ' <label class="control-label col-md-3">'+
                            'Custom Sum '+
                        '</label>'+

                        ' <div class="col-md-4">'+
                         '<input type="checkbox" name="ShowInputColumn"  id="ShowInputColumn'+num+'" value="1" onchange="ShowInputColumnFtn('+num+' , \''+Axis+'\')" />'+
                        '</div>'+
                    ' </div>';
            var num = document.getElementById('HighChartXColumnTotal').value;
            var num1 = document.getElementById('HighChartColumnTotal').value;
            val +=        '<div class="form-group row">'+
                        ' <label class="control-label col-md-3">'+
                            ' Column Name X'+num+
                        '</label>'+

                        ' <div class="col-md-4">'+
                           ' <div id = "ColumnNameX'+num1+'axisSelect">'+
                                '<select name="HighChartColumn_labelX'+num+'" id="ColumnNameX'+num1+'axis"  class="form-control  dataSourceColumns" >'+ 
                                ' </select>'+
                            '</div> <div id = "ColumnNameX'+num1+'axisInput" style = "display:none;">'+
                                '<input type="text" name="HighChartColumn_labelX'+num+'"  value="" class="form-control"/>'+
                            '</div>'+
                         '</div>'+
                    ' </div>'+
                    
                    '<div class="form-group row">'+
                        '<label class="control-label col-md-3">'+
                            'Axis X'+num+
                        '</label>'+

                        '<div class="col-md-4">'+
                            '   <input type="text" name="axisX'+num+'"  value="X'+num+'"  class="form-control" readonly />'+
                        '</div>'+
                   
                '</div>';
                document.getElementById('HighChartXColumnTotal').value = parseInt(num)+1;
                var num = document.getElementById('HighChartColumnTotal').value;
        }
        else {
            val +=  '<div id= "MoreAxis'+num+'">'+
                        '<div class="form-group row">'+
                            ' <label class="control-label col-md-3">'+
                                'Custom Sum '+
                            '</label>'+

                            ' <div class="col-md-4">'+
                            '<input type="checkbox" name="ShowInputColumn'+num+'"  id="ShowInputColumn'+num+'" value="1" onchange="ShowInputColumnFtn('+num+')" />'+
                            '</div>'+
                        ' </div>'+
                        '<div class="form-group row">'+
                            ' <label class="control-label col-md-3">'+
                                ' Column Name Y'+num+
                            '</label>'+

                            ' <div class="col-md-4">'+
                            ' <div id = "ColumnNameY'+num+'axisSelect">'+
                                    '<select name="HighChartColumn_labelY'+num+'" id="ColumnNameY'+num+'axis"  class="form-control  dataSourceColumns" >'+ 
                                    ' </select>'+
                                '</div> <div id = "ColumnNameY'+num+'axisInput" style = "display:none;">'+
                                    '<input type="text" name="HighChartColumn_labelY'+num+'_Input"  value="" class="form-control"/>'+
                                '</div>'+
                            '</div>'+
                        ' </div>'+
                        '<div class="form-group row" id = "ColumnSumY'+num+'axis" style = "display:none;">'+
                            ' <label class="control-label col-md-3">'+
                                'Custom Sum Formula'+num+
                            '</label>'+
                            ' <div class="col-md-4">'+
                                    '<input type="text" name="HighChartColumn_custom_sumY'+num+'"  value="" class="form-control"/>'+
                            '</div>'+
                        ' </div>'+
                        '<div class="form-group row">'+
                            '<label class="control-label col-md-3">'+
                                'Axis Y'+num+
                            '</label>'+

                            '<div class="col-md-4">'+
                                '   <input type="text" name="HighChartColumn_axisY'+num+'"  value="Y'+num+'"  class="form-control" readonly/>'+
                            '</div>'+
                        '</div>'+
                        '<div class="form-group row">'+
                            '<label class="control-label col-md-3">'+
                                'is Series Y'+num+
                            '</label>'+

                            '<div class="col-md-4">'+
                                ' <input type="checkbox" name="HighChartColumn_is_seriesY'+num+'" value="1"  />'+
                            '</div>'+
                        '</div>'+
                        '<div class="form-group row">'+
                            '<label class="control-label col-md-3">'+
                                'is Secondray  Y'+num+
                            '</label>'+

                            '<div class="col-md-4">'+
                                ' <input type="checkbox" name="HighChartColumn_is_secondaryY'+num+'" value="1"  />'+
                            '</div>'+
                        '</div>'+
                        '<div class="form-group row">'+
                            '<label class="control-label col-md-3">'+
                                'Type Y'+num+
                            '</label>'+

                            '<div class="col-md-4">'+
                                ' <input type="text" name="HighChartColumn_typeY'+num+'" value=""  class="form-control"  />'+
                            '</div>'+
                        '</div>'+
                        '<div class="form-group row">'+
                            '<label class="control-label col-md-3">'+
                                'hide secondary name'+num+
                            '</label>'+

                            '<div class="col-md-4">'+
                                ' <input type="checkbox" name="HighChartColumn_hide_secondary_nameY'+num+'" value="1" />'+
                            '</div>'+
                        '</div>'+
                        '<div class="form-group row">'+
                            '<label class="control-label col-md-3">'+
                                'secondary axis'+num+
                            '</label>'+

                            '<div class="col-md-4">'+
                                ' <input type="text" name="HighChartColumn_secondary_axisY'+num+'" value=""  class="form-control"  />'+
                            '</div>'+
                        '</div>'+
                        
                        
                    '</div>';
        }


                   
   
    }
    text.innerHTML =val;

    if(num == 2){
   
        $( '#MainHighChartColumn').append(val);
        var $options = $('#multipleCol option').clone();
        $('#ColumnNameYaxis').append($options);
        var $options = $('#multipleCol option').clone();
        $('#ColumnNameXaxis').append($options);
        var $options = $('#multipleCol option').clone();
        $('#ColumnNameY'+num+'axis').append($options);
        $('#MainHighChartBtn').hide();
        $('#YaxisHighChartBtn').show();
    }else{
        $( val ).insertAfter( '#MoreAxis'+oldnum );
        var $options = $('#multipleCol option').clone();
        if(Axis == 'X')
        {
            $('#ColumnNameX'+num+'axis').append($options);
        }else{
            $('#ColumnNameY'+num+'axis').append($options);
        }
       
       
        
    }
   

}
function AddPredefineSearchForRange(){
    var num = document.getElementById('PredefineSearchForRangeTotal').value;
    var oldnum = num;        
    num = parseInt(num)+1;
    //alert(num);
    document.getElementById('PredefineSearchForRangeTotal').value = num;      
    var text = document.createElement('div');
    var val = '';
    val += '    <div id="PredefineSearchForRange'+num+'">'+
                    '<div class="form-group row">'+
                        ' <label class="control-label col-md-3">'+
                            ' Column Name'+ num+
                        '</label>'+

                        ' <div class="col-md-4">'+
                            '<select name="PredefineSearchForRange_ColumnName'+num+'" id="PredefineSearchForRange_ColumnName'+num+'"  class="form-control  dataSourceColumns" >'+ 
                            ' </select>'+
                            // '<input type="text" name="PredefineSearchForRange_ColumnName'+num+'"  value="" class="form-control"/>'+
                        '</div>'+
                    ' </div>'+
                    '<div class="form-group row">'+
                        '<label class="control-label col-md-3">'+
                         'From '+num+
                        '</label>'+

                        '<div class="col-md-4">'+
                            '   <input type="text" name="PredefineSearchForRange_from'+num+'"  value="" class="form-control"/>'+
                        '</div>'+
                    '</div>'+
                    '<div class="form-group row">'+
                        '<label class="control-label col-md-3">'+
                         'To '+num+
                        '</label>'+

                        '<div class="col-md-4">'+
                            '   <input type="text" name="PredefineSearchForRange_to'+num+'"  value="" class="form-control"/>'+
                        '</div>'+
                    '</div>'+
                   
                '</div>';

    val += '<button  type="button"  onclick="DeletePredefineSearchForRange( \'PredefineSearchForRange'+num+'\')" >  Delete Pre Defined  </button>';

    text.innerHTML =val;

    if(num == 1){
        
        $( '#MainPredefineSearchForRangeDiv').append(val);
    }else{
        $( val ).insertAfter( '#PredefineSearchForRange'+oldnum );
    }
    var $options = $('#multipleCol option').clone();
    $('#PredefineSearchForRange_ColumnName'+num).append($options);

}
function DeletePredefineSearchForRange(id){
    var CountNum = document.getElementById('PredefineSearchForRangeTotal').value;
    if(CountNum > 0){
        document.getElementById('PredefineSearchForRangeTotal').value = CountNum - 1;
        $('#'+id).remove();
    }
}
function AddInvisiblePredefineSearch(){
    var num = document.getElementById('InvisiblePredefineSearchTotal').value;
    var oldnum = num;        
    num = parseInt(num)+1;
    document.getElementById('InvisiblePredefineSearchTotal').value = num;      
    var text = document.createElement('div');
    var val = '';
    val += '    <div id="InvisiblePredefineSearch'+num+'">'+
                    '<div class="form-group row">'+
                        ' <label class="control-label col-md-3">'+
                            ' Column Name'+ num+
                        '</label>'+

                        ' <div class="col-md-4">'+
                            '<select name="InvisiblePredefineSearch_ColumnName'+num+'" id="InvisiblePredefineSearch_ColumnName'+num+'"  class="form-control  dataSourceColumns" >'+
                            ' </select>'+
                            //'<input type="text" name="InvisiblePredefineSearch_ColumnName'+num+'"  value="" class="form-control"/>'+
                        '</div>'+
                    ' </div>'+
                    '<div class="form-group row">'+
                        '<label class="control-label col-md-3">'+
                         'Value To Be Searched '+num+
                        '</label>'+

                        '<div class="col-md-4">'+
                            '   <input type="text" name="InvisiblePredefineSearch_value'+num+'"  value="" class="form-control"/>'+
                        '</div>'+
                    '</div>'+
                   
                '</div>';

    val += '<button  type="button"  onclick="DeleteInvisiblePredefineSearch( \'InvisiblePredefineSearch'+num+'\')" >  Delete Pre Defined  </button>';
     
                   
    text.innerHTML =val;

    if(num == 1){
        
        $( '#MainInvisiblePredefineSearchDiv').append(val);
    }else{
        $( val ).insertAfter( '#InvisiblePredefineSearch'+oldnum );
    }
    
    var $options = $('#multipleCol option').clone();
    $('#InvisiblePredefineSearch_ColumnName'+num).append($options);

}
function DeleteInvisiblePredefineSearch(id){
    var CountNum = document.getElementById('InvisiblePredefineSearchTotal').value;
    if(CountNum > 0){
        document.getElementById('InvisiblePredefineSearchTotal').value = CountNum - 1;
        $('#'+id).remove();
    }
}
function AddPredefineSearch(){
    var num = document.getElementById('PredefineSearchTotal').value;
    var oldnum = num;        
    num = parseInt(num)+1;
    document.getElementById('PredefineSearchTotal').value = num;      
    var text = document.createElement('div');
    var val = '';
    val += '    <div id="PredefineSearch'+num+'">'+
                    '<div class="form-group row">'+
                        ' <label class="control-label col-md-3">'+
                            ' Column Name'+ num+
                        '</label>'+

                        ' <div class="col-md-4">'+
                            
                            '<select name="PredefineSearch_ColumnName'+num+'" id="PredefineSearch_ColumnName'+num+'"  class="form-control  dataSourceColumns" >'+
                            ' </select>'+
                            //'<input type="text" name="PredefineSearch_ColumnName'+num+'"  value="" class="form-control"/>'+
                        '</div>'+
                    ' </div>'+
                    '<div class="form-group row">'+
                        '<label class="control-label col-md-3">'+
                         'Value To Be Searched '+num+
                        '</label>'+

                        '<div class="col-md-4">'+
                            '   <input type="text" name="PredefineSearch_sSearch'+num+'"  value="" class="form-control"/>'+
                        '</div>'+
                    '</div>'+
                   
                '</div>';

    val += '<button  type="button"  onclick="DeletePredefineSearch( \'PredefineSearch'+num+'\')" >  Delete Pre Defined  </button>';            
    text.innerHTML =val;

    if(num == 1){
        
        $( '#MainPredefineSearchDiv').append(val);
    }else{
        $( val ).insertAfter( '#PredefineSearch'+oldnum );
    }
    var $options = $('#multipleCol option').clone();
    $('#PredefineSearch_ColumnName'+num).append($options);

}

function DeletePredefineSearch(id){
    var CountNum = document.getElementById('PredefineSearchTotal').value;
    if(CountNum > 0){
        document.getElementById('PredefineSearchTotal').value = CountNum - 1;
        $('#'+id).remove();
    }
}
function ShowCustomSum(num){

    var checkbox = document.getElementById('FooterSum_perform_custom_sum'+num);
    if(checkbox.checked){
            $('#FSInputColumnName'+num).show();
            $('#FSSelectColumnName'+num).hide();
            $('#FSCustomSum'+num).show();
        }else{
            $('#FSInputColumnName'+num).hide();
            $('#FSSelectColumnName'+num).show();
            $('#FSCustomSum'+num).hide();
        }

}
<?php 
      
    if (isset($getTableDetails["FooterColumnsProperties"]) &&  $getTableDetails['FooterColumnsProperties'] != '') {
            $FooterColumnsProperties = json_decode($getTableDetails["FooterColumnsProperties"], true);
            $FooterColumnsProperties = array_values($FooterColumnsProperties);
            $FooterColumnsPropertiesCnt = count($FooterColumnsProperties); 
            
        for ($num = 0; $num < $FooterColumnsPropertiesCnt; $num++) { 
            
            ?>
                
                var oldnum = <?php echo $num; ?>  
                var num = parseInt(oldnum)+1;

                var text = document.createElement('div');
                var val = '';

                val += '<div id="FooterSumProperty'+num+'">'+
                        '<div class="form-group row">'+
                            '<label class="control-label col-md-3">'+
                                'Perform Custom Sum'+num+
                            '</label>'+

                            '<div class="col-md-4">'+
                                '<input type="checkbox" onchange="ShowCustomSum('+num+')" name="FooterSum_perform_custom_sum'+num+'" id="FooterSum_perform_custom_sum'+num+'"  <?php if(($FooterColumnsProperties[$num]['perform_custom_sum']) == 1){ ?> checked <?php } ?> value="<?php echo ($FooterColumnsProperties[$num]['perform_custom_sum'])?1:''; ?>" />'+
                            '</div>'+
                        '</div>'+
                        '<div class="form-group row">'+
                            ' <label class="control-label col-md-3">'+
                                ' Column Name'+ num+
                            '</label>'+

                            ' <div class="col-md-4" >'+
                                '<div id= "FSSelectColumnName'+num+'">'+
                                    '<select name="FooterSum_ColumnName'+num+'" id="FooterSum_ColumnName'+num+'"   class="form-control dataSourceColumns" >'+
                                    ' </select>'+
                                '</div>'+
                                '<div id= "FSInputColumnName'+num+'" style="display:none;">'+
                                    '<input type="text" id="FooterSum_Input_ColumnName'+num+'" name="FooterSum_Input_ColumnName'+num+'"  value="" class="form-control"/>'+
                                '</div>'+                        
                            '</div>'+
                        ' </div>'+
                        '<div class="form-group row"  id= "FSCustomSum'+num+'" style="display:none;">'+
                            '<label class="control-label col-md-3">'+
                                'Custom Sum Formula'+num+
                            '</label>'+
                            '<div class="col-md-4">'+
                                '   <input type="text" name="FooterSum_custom_sum'+num+'"  value="<?php echo isset($FooterColumnsProperties[$num]['custom_sum'])?$FooterColumnsProperties[$num]['custom_sum']:''; ?>" class="form-control"/>'+
                            '</div>'+
                        '</div>'+
                        '<div class="form-group row">'+
                            '<label class="control-label col-md-3">'+
                            'Sum Type'+num+
                            '</label>'+

                            '<div class="col-md-4">'+
                                '   <input type="text" name="FooterSum_sum_type'+num+'"  value="<?php echo isset($FooterColumnsProperties[$num]['sum_type'])?$FooterColumnsProperties[$num]['sum_type']:''; ?>" class="form-control"/>'+
                            '</div>'+
                        '</div>'+
                        '<div class="form-group row">'+
                            '<label class="control-label col-md-3">'+
                                'Footer Visible'+num+
                            '</label>'+

                            '<div class="col-md-4">'+
                                '   <input type="checkbox" name="FooterSum_footer_visible'+num+'"  value="<?php  echo ($FooterColumnsProperties[$num]['footer_visible'])?1:'';?> <?php if(($FooterColumnsProperties[$num]['footer_visible']) == 1){ ?> checked <?php } ?> "/>'+
                            '</div>'+
                        '</div>'+
                        '<div class="form-group row">'+
                            '<label class="control-label col-md-3">'+
                            'Alignment'+num+
                            '</label>'+

                            '<div class="col-md-4">'+
                                '   <input type="text" name="FooterSum_alignment'+num+'"  value="<?php echo isset($FooterColumnsProperties[$num]['alignment'])?$FooterColumnsProperties[$num]['alignment']:''; ?>" class="form-control"/>'+
                            '</div>'+
                        '</div>'+
                        '<div class="form-group row">'+
                            '<label class="control-label col-md-3">'+
                            'Thousand Sep'+num+
                            '</label>'+

                            '<div class="col-md-4">'+
                                '   <input type="text" name="FooterSum_thousand_sep'+num+'"  value="<?php echo isset($FooterColumnsProperties[$num]['thousand_sep'])?$FooterColumnsProperties[$num]['thousand_sep']:''; ?>" class="form-control"/>'+
                            '</div>'+
                        '</div>'+
                        '<div class="form-group row">'+
                            '<label class="control-label col-md-3">'+
                            'Decimal'+ num+
                            '</label>'+

                            '<div class="col-md-4">'+
                                '   <input type="text" name="FooterSum_decimal'+num+'"  value="<?php echo isset($FooterColumnsProperties[$num]['decimal'])?$FooterColumnsProperties[$num]['decimal']:''; ?>" class="form-control"/>'+
                            '</div>'+
                        '</div>'+
                        '<div class="form-group row">'+
                            '<label class="control-label col-md-3">'+
                            'Decimal Point'+num+
                            '</label>'+

                            '<div class="col-md-4">'+
                                '   <input type="text" name="FooterSum_decimal_point'+num+'"  value="<?php echo isset($FooterColumnsProperties[$num]['decimal_point'])?$FooterColumnsProperties[$num]['decimal_point']:''; ?>" class="form-control"/>'+
                            '</div>'+
                        '</div>'+
                        '<div class="form-group row">'+
                            '<label class="control-label col-md-3">'+
                            'Denomination Text'+num+
                            '</label>'+

                            '<div class="col-md-4">'+
                                '   <input type="text" name="FooterSum_denomination_text'+num+'"  value="<?php echo isset($FooterColumnsProperties[$num]['denomination_text'])?$FooterColumnsProperties[$num]['denomination_text']:''; ?>" class="form-control"/>'+
                            '</div>'+
                        '</div>'+
                    '</div>';           
                    text.innerHTML =val;
                  
                    if(num == 1){
                         
                        $( '#MainFooterDiv').append(val);
                        
                    }else{
                        $( val ).insertAfter( '#FooterSumProperty'+oldnum );
                    }
                    var $options = $('#multipleCol option').clone();
                    $('#FooterSum_ColumnName'+num).append($options);
                    var checkbox = document.getElementById('FooterSum_perform_custom_sum'+num);
                    if(checkbox.checked){

                            $('#FooterSum_Input_ColumnName'+num).val("<?php print_r($FooterColumnsProperties[$num]['column_name']); ?>");
                           
                            $('#FSInputColumnName'+num).show();
                            $('#FSSelectColumnName'+num).hide();
                            $('#FSCustomSum'+num).show();
                        }else{
                           
                            $('#FooterSum_ColumnName'+num).val("<?php print_r($FooterColumnsProperties[$num]['column_name']); ?>").change();
                            $('#FSInputColumnName'+num).hide();
                            $('#FSSelectColumnName'+num).show();
                            $('#FSCustomSum'+num).hide();
                        }
        <?php } ?>
        document.getElementById('footerSumPro').value = <?php echo $FooterColumnsPropertiesCnt ; ?>;
          
<?php } ?>
function AddFooterCallBack(){
    
    var num = document.getElementById('footerSumPro').value;
    var oldnum = num;        
    num = parseInt(num)+1;
    document.getElementById('footerSumPro').value = num;      
    var text = document.createElement('div');

    var val = '';
    
    val += '    <div id="FooterSumProperty'+num+'">'+
                    '<div class="form-group row">'+
                        '<label class="control-label col-md-3">'+
                            'Perform Custom Sum'+num+
                        '</label>'+

                        '<div class="col-md-4">'+
                            '<input type="checkbox" onchange="ShowCustomSum('+num+')" name="FooterSum_perform_custom_sum'+num+'" id="FooterSum_perform_custom_sum'+num+'"  value="1" />'+
                        '</div>'+
                    '</div>'+
                    '<div class="form-group row">'+
                        ' <label class="control-label col-md-3">'+
                            ' Column Name'+ num+
                        '</label>'+

                        ' <div class="col-md-4" >'+
                            '<div id= "FSSelectColumnName'+num+'">'+
                                '<select name="FooterSum_ColumnName'+num+'" id="FooterSum_ColumnName'+num+'"   class="form-control dataSourceColumns"  data-reorder="1"  >'+
                                ' </select>'+
                            '</div>'+
                            '<div id= "FSInputColumnName'+num+'" style="display:none;">'+
                                '<input type="text" name="FooterSum_Input_ColumnName'+num+'"  value="" class="form-control"/>'+
                            '</div>'+                        
                        '</div>'+
                    ' </div>'+
                    '<div class="form-group row"  id= "FSCustomSum'+num+'" style="display:none;">'+
                        '<label class="control-label col-md-3">'+
                            'Custom Sum Formula'+num+
                        '</label>'+
                        '<div class="col-md-4">'+
                            '   <input type="text" name="FooterSum_custom_sum'+num+'"  value="" class="form-control"/>'+
                        '</div>'+
                    '</div>'+
                    '<div class="form-group row">'+
                        '<label class="control-label col-md-3">'+
                         'Sum Type'+num+
                        '</label>'+

                        '<div class="col-md-4">'+
                            '   <input type="text" name="FooterSum_sum_type'+num+'"  value="" class="form-control"/>'+
                        '</div>'+
                    '</div>'+
                    '<div class="form-group row">'+
                        '<label class="control-label col-md-3">'+
                            'Footer Visible'+num+
                        '</label>'+

                        '<div class="col-md-4">'+
                            '   <input type="checkbox" name="FooterSum_footer_visible'+num+'"  value="1"/>'+
                        '</div>'+
                    '</div>'+
                    '<div class="form-group row">'+
                        '<label class="control-label col-md-3">'+
                         'Alignment'+num+
                        '</label>'+

                        '<div class="col-md-4">'+
                            '   <input type="text" name="FooterSum_alignment'+num+'"  value="" class="form-control"/>'+
                        '</div>'+
                    '</div>'+
                    '<div class="form-group row">'+
                        '<label class="control-label col-md-3">'+
                         'Thousand Sep'+num+
                        '</label>'+

                        '<div class="col-md-4">'+
                            '   <input type="text" name="FooterSum_thousand_sep'+num+'"  value="" class="form-control"/>'+
                        '</div>'+
                    '</div>'+
                    '<div class="form-group row">'+
                        '<label class="control-label col-md-3">'+
                         'Decimal'+ num+
                        '</label>'+

                        '<div class="col-md-4">'+
                            '   <input type="text" name="FooterSum_decimal'+num+'"  value="" class="form-control"/>'+
                        '</div>'+
                    '</div>'+
                    '<div class="form-group row">'+
                        '<label class="control-label col-md-3">'+
                         'Decimal Point'+num+
                        '</label>'+

                        '<div class="col-md-4">'+
                            '   <input type="text" name="FooterSum_decimal_point'+num+'"  value="" class="form-control"/>'+
                        '</div>'+
                    '</div>'+
                    '<div class="form-group row">'+
                        '<label class="control-label col-md-3">'+
                         'Denomination Text'+num+
                        '</label>'+

                        '<div class="col-md-4">'+
                            '   <input type="text" name="FooterSum_denomination_text'+num+'"  value="" class="form-control"/>'+
                        '</div>'+
                    '</div>'+
                '</div>';

             
    text.innerHTML =val;

    if(num == 1){
        
        $( '#MainFooterDiv').append(val);
    }else{
        $( val ).insertAfter( '#FooterSumProperty'+oldnum );
    }
    var $options = $('#multipleCol option').clone();
    $('#FooterSum_ColumnName'+num).append($options);

}
function DeleteFooterCallBack(){
    var CountNum = document.getElementById('footerSumPro').value;
    if(CountNum > 0){
        document.getElementById('footerSumPro').value = CountNum - 1;
        id = 'FooterSumProperty'+CountNum;
        $('#'+id).remove();
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
       
       if ( isset($getTableDetails["AllowColumnRowMarking"]) &&  $getTableDetails['AllowColumnRowMarking'] == '1') {?>
           $('#colorType').show();
      <?php } ?>

function AddRowLevel(id){
        id = parseInt(id);
        if(id > 4 ){
            alert("only 4 levels Allowed");
        }else{
            $('#RowGroupLevel'+id).show();
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