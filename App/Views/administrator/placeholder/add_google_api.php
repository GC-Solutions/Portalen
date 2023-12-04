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
                    <header>Add Google API</header>
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
                                    Api Call 
                                    <span class="required"> * </span>
                                </label>

                                <div class="col-md-4">
                                    <input type="text" name="SourceAddress" value="<?= $sourceAddress = (isset($dataSourceDetails['SourceAddress'])) ? $dataSourceDetails['SourceAddress'] : "";?>" required="" data-required="1"
                                           class="form-control"/>
                                </div>
                            </div>

                            
                            <div class="form-group row">
                                <label class="control-label col-md-3">
                                    Request Body
                                    <span class="required"></span>
                                </label>

                                <div class="col-md-4">
                                    <textarea type="text" name="Body"
                                           class="form-control">
                                               <?= $placeholder = (isset($dataSourceDetails['Body'])) ? $dataSourceDetails['Body'] : "";?>
                                           </textarea>
                                </div>
                            </div>
                             <div class="form-group row" style="display: none;">
                                <label class="control-label col-md-3">
                                    Request Type
                                    <span class="required"> * </span>
                                </label>

                                <div class="col-md-4">
                                    <select name="RequestType" class="form-control">
                                        <option value="4">Database</option>
                                    </select>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="control-label col-md-3">
                                    Columns
                                    <span class="required"> * </span>
                                </label>

                                <div class="col-md-4">
                                    <input type="text" name="Columns" value="<?= $columns = (isset($dataSourceDetails['Columns'])) ? $dataSourceDetails['Columns'] : "";?>" required="" data-required="1"
                                           class="form-control"/>
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

                            
                        </div>
                        <div class="form-group">
                            <div class="offset-md-3 col-md-9">
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