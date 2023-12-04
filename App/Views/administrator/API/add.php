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
                    <header>Add API</header>
                </div>
                <div class="card-body" id="bar-parent1">
                    <form action="<?php echo baseUrl; ?>saveApi" method="post" id="form_sample_1" class="form-horizontal">
                        <div class="form-body">
                            <div class="form-group row">
                                <label class="control-label col-md-3">API URL 
                                    <span class="required"> * </span>
                                </label>
                               
                                <div class="col-md-4">
                                    <input type="text" name="APIUrl" value="<?php if(isset($APIDetail['APIUrl'])) {echo $APIDetail['APIUrl']; } ?>" required data-required="1"
                                           class="form-control"/>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="control-label col-md-3">
                                    Data Source
                                </label>

                                <div class="col-md-4">
                                    <select name="Tables" class="form-control DataSourceId select2-multiple " data-maximum-selection-length="1" multiple >
                                        <option value=""> Select</option>
                                        <?php
                                        if ($getDataSource) {
                                            $getDataTableId = (isset($APIDetail['Tables'])) ? $APIDetail['Tables'] : "";
                                            //$existingColumnsOfDataTable = "";
                                            ?>
                                            <?php foreach ($getDataSource as $key => $getDataTableValue) {
                                                $selected = '';
                                                if ($getDataTableValue['ID'] == $getDataTableId) {
                                                    $selected = 'selected="selected"';
                                                    //$existingColumnsOfDataTable = $getDataTableValue["Columns"];
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
                                    Data Table
                                </label>

                                <div class="col-md-4">
                                    <select name="Tables" class="form-control TableId select2-multiple DataTableId" data-maximum-selection-length="1" multiple >
                                        <option value=""> Select</option>
                                        <?php
                                        if ($getDataTable) {
                                            $getDataTableId = (isset($APIDetail['Tables'])) ? $APIDetail['Tables'] : "";
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
                                    
                                </label>

                                <div class="col-md-4">
                                    <select name="Fields[]" id="multiple"
                                            class="form-control select2-multiple dataSourceColumns dataTableColumns"   multiple
                                           >
                                        <option value="">Select</option>
                                        <?php  if (!empty($existingColumnsOfDataTable)) {
                                            $getTableColumns = (!empty($APIDetail['Fields'])) ? $APIDetail['Fields'] : array();
                                            if ($getTableColumns) {
                                                $getTableColumns = explode(',', $getTableColumns);
                                            }
                                            
                                            $existingColumnsOfDataTable = explode(',', $existingColumnsOfDataTable);
                                          

                                            if ($existingColumnsOfDataTable) {
                                                foreach ($existingColumnsOfDataTable as $key => $value) {
                                                    $selected = "";
                                                    
                                                    if (in_array($value, $getTableColumns)) {
                                                        $selected = 'selected="selected"';
                                                    }
                                                    $value = trim($value);
                                                    echo '<option value="' . $value . '"' . $selected . '>' . $value . '</option>';
                                                }
                                            } ?>
                                        <?php }?>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="control-label col-md-3">
                                    Add API Data of Another API
                                </label>

                                <div class="col-md-4">
                                    <select name="linkedApi" class="form-control TableId select2-multiple DataTableId" data-maximum-selection-length="1" multiple >
                                        <option value=""> Select</option>
                                        <?php
                                        if ($getAllAPI) {
                                            $getAllAPIID = (isset($APIDetail['getAllAPI'])) ? $APIDetail['getAllAPI'] : "";
                                           
                                            ?>
                                            <?php foreach ($getAllAPI as $key => $getAllAPIValue) {
                                                $selected = '';
                                                if ($getAllAPIValue['ID'] == $getAllAPIID) {
                                                    $selected = 'selected="selected"';
                                                    
                                                }
                                                ?>
                                                <option <?= $selected; ?>
                                                    value="<?= $getAllAPIValue['ID']; ?>"><?= $getAllAPIValue['APIUrl']; ?></option>
                                            <?php } ?>
                                        <?php } ?>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="control-label col-md-3">
                                    Show Focus Page
                                </label>
                                <div class="col-md-9">
                                    <div class="col-md-12 padding_none">
                                        <div class="checkboxes" id ='ChangeChkBox'>
                                            <?php
                                            $showFocusPage = (isset($APIDetail["showFocusPage"])) ? $APIDetail["showFocusPage"] : 0;
                                            $checked = "";
                                            if ($showFocusPage) {
                                                $checked = "checked='checked'";
                                            }
                                            ?>
                                            <label>
                                                <input type="checkbox" <?= $checked; ?> name="showFocusPage"
                                                       value="1"/>
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="control-label col-md-3">
                                    Parameter for FocusPage
                                    
                                </label>

                                <div class="col-md-4">
                                    <select name="parameterFocusPage[]" id="multiple"
                                            class="form-control select2-multiple dataSourceColumns dataTableColumns" data-reorder="1" multiple
                                            >
                                        <option value="">Select</option>
                                        <?php if (!empty($existingColumnsOfDataTable)) {
                                            
                                            $getTableColumns = $APIDetail['parameterFocusPage'];
                                            if ($getTableColumns) {
                                                $getTableColumns = explode(',', $getTableColumns);
                                            }
                                            
                                            if ($existingColumnsOfDataTable) {
                                                foreach ($existingColumnsOfDataTable as $key => $value) {
                                                    $selected = "";
                                                    $value = trim($value);
                                                    if($getTableColumns){
                                                        if (in_array($value, $getTableColumns)) {
                                                            $selected = 'selected="selected"';
                                                        }
                                                    }
                                                    echo '<option value= "' . trim($value) . '"' . $selected . '>' . trim($value) . '</option>';
                                                    
                                                    
                                                }
                                            }
                                            ?>
                                        <?php } ?>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group row">
                                            <label class="control-label col-md-3">
                                                Action(s) on rows (multiple selections)
                                            </label>
                                            <?php
                                            $selectedPlaceholderActionValue = (isset($APIDetail['PlaceholderActionIds'])) ? $APIDetail['PlaceholderActionIds'] : "";

                                            if ($selectedPlaceholderActionValue) {
                                                $selectedPlaceholderActionValue = explode(',', $selectedPlaceholderActionValue);
                                            }
                                            ?>
                                            <div class="col-md-4">
                                                <select name="PlaceholderActionIds[]" id="multiple"
                                                        class="form-control select2-multiple dataSourceColumns"
                                                        multiple>
                                                    <option value=""> Select</option>
                                                    <?php foreach ($getAllTableActions as $key => $value) {
                                                        $selectedOption = "";
                                                        if (!empty($selectedPlaceholderActionValue)) {
                                                            if (in_array($value['ID'], $selectedPlaceholderActionValue)) {
                                                                $selectedOption = "selected='selected'";
                                                            }
                                                        }
                                                        ?>
                                                        <option <?= $selectedOption; ?>
                                                            value="<?php echo $value['ID']; ?>"><?php echo $value['Name']; ?></option>
                                                    <?php } ?>
                                                </select>
                                            </div>
                                        </div>
                            <div class="form-group row">
                                <label class="control-label col-md-3">
                                    Request Type
                                    <span class="required"> * </span>
                                </label>

                                <div class="col-md-4">
                                    <?php
                                    $RequestType = (isset($APIDetail['RequestType'])) ? $APIDetail['RequestType'] : "";
                                    ?>
                                    <select name="RequestType" class="form-control" required="">
                                        <option value=""> Select</option>
                                        <option value="1" <?php if ($RequestType == 1) {
                                            echo "selected='selected'";
                                        } ?>>GET
                                        </option>
                                        <option value="2" <?php if ($RequestType == 2) {
                                            echo "selected='selected'";
                                        } ?>>POST
                                        </option>
                                        <option value="3" <?php if ($RequestType == 3) {
                                            echo "selected='selected'";
                                        } ?>>PUT
                                        </option>
                                        <option value="4" <?php if ($RequestType == 4) {
                                            echo "selected='selected'";
                                        } ?>>Delete
                                        </option>
                                    </select>
                                </div>
                            </div>
                             <div class="form-group row">
                                <label class="control-label col-md-3">
                                    Body  
                                </label>

                                <div class="col-md-4">
                                    <textarea name="Body" 
                                           class="form-control"> <?= $body = (isset($APIDetail['Body'])) ? $APIDetail['Body'] : ""; ?></textarea>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="control-label col-md-3">Edit Column for Update(PUT)
                                </label>
                               
                                <div class="col-md-4">
                                    <input type="text" name="EditColumn" value="<?php if(isset($APIDetail['EditColumn'])) {echo $APIDetail['EditColumn']; } ?>" 
                                           class="form-control"/>
                                </div>
                            </div>
                             <div class="form-group row">
                                <label class="control-label col-md-3">Available UserGroup as FocusLink or Array
                                </label>
                               
                                <div class="col-md-4">
                                     <?php
                                    $UserLoginFocusLink = (isset($APIDetail['UserLoginFocusLink'])) ? $APIDetail['UserLoginFocusLink'] : "";
                                    ?>
                                    <select name="UserLoginFocusLink" class="form-control" >
                                        <option value=""> Select</option>
                                        <option value="1" <?php if ($UserLoginFocusLink == 1) {
                                            echo "selected='selected'";
                                        } ?>>Array
                                        </option>
                                        <option value="2" <?php if ($UserLoginFocusLink == 2) {
                                            echo "selected='selected'";
                                        } ?>>Focus Link
                                        </option>
                                        
                                    </select>
                                </div>
                            </div>

                            <input type="hidden" name="id" value="<?php if(isset($APIDetail['ID'])) {echo $APIDetail['ID']; } ?>">
                        </div>
                        <div class="form-group">
                            <div class="offset-md-3 col-md-9">
                                <div class="btn-group">
                                    <button type="submit" class="btn btn-info">
                                        Save <i class="fa fa-plus"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
<?php include_once realpath(__DIR__ . '/../..') . '/layout/Admin_Layout/footer_start.php'; ?>