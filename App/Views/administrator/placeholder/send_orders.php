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
                    <header>Add Send Orders template</header>
                </div>
                <div class="card-body" id="bar-parent1">
                    <form action="<?php echo baseUrl; ?>save_SendOrders" method="post" class="form-horizontal">
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
                                    <input type="text" name="Description" required="" data-required="1"
                                           value="<?= $descriptions = (isset($getTableDetails['Descriptions'])) ? $getTableDetails['Descriptions'] : ""; ?>"
                                           class="form-control"/>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="control-label col-md-3">
                                    Data source
                                    <span class="required"> * </span>
                                </label>

                                <div class="col-md-4">
                                
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
                              
                                </div>
                            </div>
                            <div class="form-group row" >
                                <label class="control-label col-md-3">
                                   Column Names and their types 
                                    <span class="required"> * </span>
                                </label>

                                <div class="col-md-4">
                                  <textarea name="DetailColumns"
                                            class="form-control"> <?= $DetailColumns = (isset($getTableDetails['DetailColumns'])) ? $getTableDetails['DetailColumns'] : ""; ?></textarea>
                                </div>
                            </div>

                            <div class="form-group row" >
                                <label class="control-label col-md-3">
                                   Order Row Columns 
                                    <span class="required"> * </span>
                                </label>

                                <div class="col-md-4">
                                  <textarea name="DetailColumnsOrderColumn"
                                            class="form-control"> <?= $DetailColumnsOrderColumn = (isset($getTableDetails['DetailColumnsOrderColumn'])) ? $getTableDetails['DetailColumnsOrderColumn'] : ""; ?></textarea>
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