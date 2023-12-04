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
                    <header>Add graph template</header>
                </div>
                <div class="card-body" id="bar-parent1">
                    <form action="<?php echo baseUrl; ?>save_graph" method="post"
                          class="form-horizontal">
                        <div class="form-body">
                            <input type="hidden" name="id"
                                   value="<?= $id = (isset($getGraphDetails['ID'])) ? $getGraphDetails['ID'] : ""; ?>"/>

                            <div class="form-group row">
                                <label class="control-label col-md-3">
                                    Graph name
                                    <span class="required"> * </span>
                                </label>

                                <div class="col-md-4">
                                    <input type="text" name="Name" required="" data-required="1"
                                           value="<?= $Name = (isset($getGraphDetails['Name'])) ? $getGraphDetails['Name'] : ""; ?>"
                                           class="form-control"/>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="control-label col-md-3">
                                    Graph description
                                </label>

                                <div class="col-md-4">
                                    <input type="text" name="Descriptions" required="" data-required="1"
                                           value="<?= $descriptions = (isset($getGraphDetails['Descriptions'])) ? $getGraphDetails['Descriptions'] : ""; ?>"
                                           class="form-control"/>
                                </div>
                            </div>


                            <div class="form-group row">
                                <label class="control-label col-md-3">
                                    Graph Type
                                    <span class="required"> * </span>
                                </label>

                                <div class="col-md-4">
                                    <?php
                                    $graphType = (isset($getGraphDetails['GraphType'])) ? $getGraphDetails['GraphType'] : "";
                                    ?>
                                    <select name="GraphType" class="form-control" required="">
                                        <option value=""> Select</option>
                                        <option value="1" <?php if ($graphType == 1) {
                                            echo "selected='selected'";
                                        } ?>>Pie Chart
                                        </option>
                                        <option value="2" <?php if ($graphType == 2) {
                                            echo "selected='selected'";
                                        } ?>>Line Chart
                                        </option>
                                        <option value="3" <?php if ($graphType == 3) {
                                            echo "selected='selected'";
                                        } ?>>Column Chart
                                        </option>
                                        <option value="4" <?php if ($graphType == 4) {
                                            echo "selected='selected'";
                                        } ?>>Area Chart
                                        </option>
                                        <option value="5" <?php if ($graphType == 5) {
                                            echo "selected='selected'";
                                        } ?>>Combo Charts
                                        </option>
                                        <option value="6" <?php if ($graphType == 6) {
                                            echo "selected='selected'";
                                        } ?>>Dual axes, line and column
                                        </option>
                                        <option value="7" <?php if ($graphType == 7) {
                                            echo "selected='selected'";
                                        } ?>>Columns, line
                                        </option>
                                          <option value="8" <?php if ($graphType == 8) {
                                            echo "selected='selected'";
                                        } ?>> Drill Down Chart
                                        </option>
                                           <option value="9" <?php if ($graphType == 9) {
                                            echo "selected='selected'";
                                        } ?>> Combo chart
                                        </option>
                                         <option value="10" <?php if ($graphType == 10) {
                                            echo "selected='selected'";
                                        } ?>> Sunbrust chart
                                        </option>
                                        <option value="11" <?php if ($graphType == 11) {
                                            echo "selected='selected'";
                                        } ?>> Dynamic chart
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
                                    <select name="DataSourceId" class="form-control DataSourceId select2-multiple" data-maximum-selection-length="1" multiple >
                                        <option value=""> Select</option>
                                        <?php
                                        if ($getDataSource) {
                                            $getDataSourceId = (isset($getGraphDetails['DataSourceId'])) ? $getGraphDetails['DataSourceId'] : "";
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
                                    Data Table
                                </label>

                                <div class="col-md-4">
                                    <select name="TableId" class="form-control TableId select2-multiple DataTableId" data-maximum-selection-length="1" multiple >
                                        <option value=""> Select</option>
                                        <?php
                                        if ($getDataTable) {
                                            $getDataTableId = (isset($getGraphDetails['TableId'])) ? $getGraphDetails['TableId'] : "";
                                            ?>
                                            <?php foreach ($getDataTable as $key => $getDataTableValue) {
                                                $selected = '';
                                                if ($getDataTableValue['ID'] == $getDataTableId) {
                                                    $selected = 'selected="selected"';
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
                                    X Field
                                    <span class="required"> * </span>
                                </label>

                                <div class="col-md-4">
                                    <input type="text" name="XField" value="<?= $xField = (isset($getGraphDetails['XField'])) ? $getGraphDetails['XField'] : ""; ?>" required="" data-required="1"
                                           class="form-control"/>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="control-label col-md-3">
                                    Y Field
                                    <span class="required"> * </span>
                                </label>

                                <div class="col-md-4">
                                    <input type="text" name="YField" value="<?= $yField = (isset($getGraphDetails['YField'])) ? $getGraphDetails['YField'] : ""; ?>" required="" data-required="1"
                                           class="form-control"/>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="control-label col-md-3">
                                    Z Field
                                </label>

                                <div class="col-md-4">
                                    <input type="text" name="ZField" value="<?= $zField = (isset($getGraphDetails['ZField'])) ? $getGraphDetails['ZField'] : ""; ?>"
                                           class="form-control"/>
                                </div>
                            </div>


                            <div class="form-group row">
                                <label class="control-label col-md-3">
                                    X Label
                                    <span class="required"> * </span>
                                </label>

                                <div class="col-md-4">
                                    <input type="text" name="XFieldLabel" value="<?= $xFieldLabel = (isset($getGraphDetails['XFieldLabel'])) ? $getGraphDetails['XFieldLabel'] : ""; ?>" required="" data-required="1"
                                           class="form-control"/>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="control-label col-md-3">
                                    Y Label
                                    <span class="required"> * </span>
                                </label>

                                <div class="col-md-4">
                                    <input type="text" name="YFieldLabel" value="<?= $yFieldLabel = (isset($getGraphDetails['YFieldLabel'])) ? $getGraphDetails['YFieldLabel'] : ""; ?>" required="" data-required="1"
                                           class="form-control"/>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="control-label col-md-3">
                                    Z Label
                                </label>

                                <div class="col-md-4">
                                    <input type="text" name="ZFieldLabel" value="<?= $zFieldLabel = (isset($getGraphDetails['ZFieldLabel'])) ? $getGraphDetails['ZFieldLabel'] : ""; ?>"
                                           class="form-control"/>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="control-label col-md-3">
                                    Filters
                                    <span class="required"> * </span>
                                </label>

                                <div class="col-md-4">
                                    <input type="text" name="Filters" value="<?= $filters = (isset($getGraphDetails['Filters'])) ? $getGraphDetails['Filters'] : ""; ?>"
                                           class="form-control"/>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="control-label col-md-3">
                                    Header Text
                                    <span class="required"> * </span>
                                </label>

                                <div class="col-md-4">
                                    <input type="text" name="HeadersText" value="<?= $headersText = (isset($getGraphDetails['HeadersText'])) ? $getGraphDetails['HeadersText'] : ""; ?>" required="" data-required="1"
                                           class="form-control"/>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="control-label col-md-3">
                                    De-activate 3D Option
                                </label>

                                <div class="col-md-9">

                                    <div class="col-md-12 padding_none">
                                        <div class="checkboxes" id ='ChangeChkBox'>
                                            <?php
                                            $deactivate3d = (isset($getGraphDetails["Deactivate3d"])) ? $getGraphDetails["Deactivate3d"] : 0;
                                            $checked = "";
                                            if ($deactivate3d) {
                                                $checked = "checked='checked'";
                                            }
                                            ?>
                                            <label>
                                                <input type="checkbox" <?= $checked; ?> name="Deactivate3d"
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