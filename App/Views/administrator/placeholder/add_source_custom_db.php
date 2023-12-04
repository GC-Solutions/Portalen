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
                    <header>Add Data Source Table Database</header>
                </div>
                <div class="card-body" id="bar-parent1">
                    <form action="<?php echo baseUrl; ?>saveDataSource" method="post" class="form-horizontal">
                        <div class="form-body">
                            <input type="hidden" name="id" value="<?= $id = (isset($dataSourceDetails['ID'])) ? $dataSourceDetails['ID'] : "";?>">
                            <div class="form-group row">
                                <label class="control-label col-md-3">
                                    Name
                                    <span class="required"> * </span>
                                </label>

                                <div class="col-md-4">
                                    <input type="text" name="Name" required="" data-required="1" value="<?= $name = (isset($dataSourceDetails['Name'])) ? $dataSourceDetails['Name'] : "";?>" class="form-control"/>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="control-label col-md-3">
                                    Descriptions
                                    <span class="required"> * </span>
                                </label>

                                <div class="col-md-4">
                                    <input type="text" name="Descriptions" value="<?= $descriptions = (isset($dataSourceDetails['Descriptions'])) ? $dataSourceDetails['Descriptions'] : "";?>" required="" data-required="1"
                                           class="form-control"/>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="control-label col-md-3">
                                    Create Table
                                    <span class="required"> * </span>
                                </label>

                                <div class="col-md-4">
                                    <input type="text" name="customTable" value="<?= $customTable = (isset($dataSourceDetails['customTable'])) ? $dataSourceDetails['customTable'] : "";?>" required="" data-required="1"
                                           class="form-control"/>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="control-label col-md-3">
                                    Query string
                                    <span class="required"> * </span>
                                </label>

                                <div class="col-md-4">
                                    <input type="text" name="SourceAddress" value="<?= $sourceAddress = (isset($dataSourceDetails['SourceAddress'])) ? $dataSourceDetails['SourceAddress'] : "";?>" required="" data-required="1"
                                           class="form-control"/>
                                </div>
                            </div>

                            <div class="form-group row" style="display: none;">
                                <label class="control-label col-md-3">
                                    Request Type
                                    <span class="required"> * </span>
                                </label>

                                <div class="col-md-4">
                                    <select name="RequestType" class="form-control">
                                        <option value="3">Database</option>
                                    </select>
                                </div>
                            </div>

                              <div class="form-group row">
                                <label class="control-label col-md-3">
                                    DB Type 
                                    
                                </label>

                                <div class="col-md-4">
                                    <?php
                                    $DBType = (isset($dataSourceDetails['DBType'])) ? $dataSourceDetails['DBType'] : "";
                                    ?>
                                    <select name="DBType" class="form-control" required="">
                                        <option value=""> Select</option>
                                        <option value="sqlsrv" <?php if ($DBType == 'sqlsrv') {
                                            echo "selected='selected'";
                                        } ?>>SQL SERVER
                                        </option>
                                        <option value="mysql" <?php if ($DBType == 'mysql') {
                                            echo "selected='selected'";
                                        } ?>>MY SQL
                                        </option>
                                         <option value="pgsql" <?php if ($DBType == 'pgsql') {
                                            echo "selected='selected'";
                                        } ?>>Postgre SQL
                                        </option>
                                          <option value="mongodb" <?php if ($DBType == 'mongodb') {
                                            echo "selected='selected'";
                                        } ?>>Mongo DB
                                        </option>
                                    </select>
                                </div>
                            </div>


                            <div class="form-group row">
                                <label class="control-label col-md-3">
                                    Parameter
                                    <span class="required"></span>
                                </label>

                                <div class="col-md-4">
                                    <input type="text" name="Placeholder" value="<?= $placeholder = (isset($dataSourceDetails['Placeholder'])) ? $dataSourceDetails['Placeholder'] : "";?>"
                                           class="form-control"/>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="control-label col-md-3">
                                     Create Columns
                                    <span class="required"> * </span>
                                </label>

                                <div class="col-md-4">
                                    <input type="text" name="Columns" value="<?= $columns = (isset($dataSourceDetails['Columns'])) ? $dataSourceDetails['Columns'] : "";?>" required="" data-required="1"
                                           class="form-control"/>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="control-label col-md-3">
                                    Db Columns datatype
                                    <span class="required"> * </span>
                                </label>

                                <div class="col-md-4">
                                    <textarea name="dbNewColumns"
                                              class="form-control"> <?= $dbNewColumns = (isset($dataSourceDetails['dbNewColumns'])) ? $dataSourceDetails['dbNewColumns'] : ""; ?></textarea>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="control-label col-md-3">
                                    Columns Properties
                                    <span class="required"> * </span>
                                </label>

                                <div class="col-md-4">
                                    <textarea name="ColumnsProperties"
                                              class="form-control"> <?= $ColumnsProperties = (isset($dataSourceDetails['ColumnsProperties'])) ? $dataSourceDetails['ColumnsProperties'] : ""; ?></textarea>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="control-label col-md-3">
                                    Set Key column
                                    <span class="required"> * </span>
                                </label>

                                <div class="col-md-4">
                                    <input type="text" name="KeyColumn" value="<?= $keyColumn = (isset($dataSourceDetails['KeyColumn'])) ? $dataSourceDetails['KeyColumn'] : "";?>" required="" data-required="1"
                                           class="form-control"/>
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
                                    <a class="btn deepPink-bgcolor" href="<?php echo baseUrl; ?>data_source">Cancel
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