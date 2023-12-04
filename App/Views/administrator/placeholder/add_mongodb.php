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
                    <header>Add mongoDB template</header>
                </div>
                <div class="card-body" id="bar-parent1">
                    <form action="<?php echo baseUrl; ?>save_mongodb" method="post" class="form-horizontal">
                        <div class="form-body">
                            <input type="hidden" name="id"
                                   value="<?= $id = (isset($getTableDetails[0]['ID'])) ? $getTableDetails[0]['ID'] : ""; ?>"/>

                            <div class="form-group row">
                                <label class="control-label col-md-3">
                                    Table name
                                    <span class="required"> * </span>
                                </label>

                                <div class="col-md-4">
                                    <input type="text" name="Name" required="" data-required="1"
                                           value="<?= $Name = (isset($getTableDetails[0]['Name'])) ? $getTableDetails[0]['Name'] : ""; ?>"
                                           class="form-control"/>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="control-label col-md-3">
                                    Table description
                                </label>

                                <div class="col-md-4">
                                    <input type="text" name="Description" required="" data-required="1"
                                           value="<?= $descriptions = (isset($getTableDetails[0]['Description'])) ? $getTableDetails[0]['Description'] : ""; ?>"
                                           class="form-control"/>
                                </div>
                            </div>
                             <div class="form-group row">
                                <label class="control-label col-md-3">
                                    Related Data Table
                                </label>

                                <div class="col-md-4">
                                    <select name="RelatedDataTables" class="form-control RelatedDataTables select2-multiple DataTableId" data-maximum-selection-length="1" multiple >
                                        <option value=""> Select</option>
                                        <?php
                                        if ($getDataTable) {
                                            $getDataTableId = (isset($getTableDetails[0]['RelatedDataTables'])) ? $getTableDetails[0]['RelatedDataTables'] : "";
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

                            <div class="form-group row" >
                                <label class="control-label col-md-3">
                                   Column Names and their types 
                                    <span class="required"> * </span>
                                </label>

                                <div class="col-md-4">
                                  <textarea name="DetailColumns"
                                            class="form-control"> <?= $DetailColumns = (isset($getTableDetails[0]['DetailColumns'])) ? $getTableDetails[0]['DetailColumns'] : ""; ?></textarea>
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