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
                    <header>New Placeholder</header>
                    <button id = "panel-button1"
                            class = "mdl-button mdl-js-button mdl-button--icon pull-right"
                            data-upgraded = ",MaterialButton">
                        <i class = "material-icons">more_vert</i>
                    </button>
                </div>
                <div class="card-body" id="bar-parent1">
                    <form action="<?php echo baseUrl;?>saveplaceholder" method="post" id="form_sample_1" class="form-horizontal">
                        <div class="form-body">
                            <div class="form-group row">
                                <label class="control-label col-md-3">Name
                                    <span class="required"> * </span>
                                </label>
                                <div class="col-md-4">
                                    <input type="text" name="PlaceholderName" required data-required="1" class="form-control" /> </div>
                            </div>


                            <div class="form-group row">
                                <label class="control-label col-md-3">ID
                                    <span class="required"> * </span>
                                </label>
                                <div class="col-md-4">
                                    <input type="text" name="ID" required data-required="1" class="form-control" /> </div>
                            </div>

                            <div class="form-group row">
                                <label class="control-label col-md-3">File
                                    <span class="required"> * </span>
                                </label>
                                <div class="col-md-4">
                                    <input type="text" name="File" required data-required="1" class="form-control" /> </div>
                            </div>

                            <div class="form-group row">
                                <label class="control-label col-md-3">Call Type
                                    <span class="required"> * </span>
                                </label>
                                <div class="col-md-4">
                                    <select name="CallType" class="form-control callType" required>
                                        <option value=""> Select Call Type</option>
                                        <option value="1">Database call</option>
                                        <option value="2">Api call</option>
                                        <option value="3">Table api call</option>
                                        <option value="4">Database table call</option>
                                    </select>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="control-label col-md-3">Source Type
                                    <span class="required"> * </span>
                                </label>
                                <div class="col-md-4">
                                    <input type="text" name="SourceType" required data-required="1" class="form-control" /> </div>
                            </div>

                            <div class="form-group row">
                                <label class="control-label col-md-3">Create Source Type
                                    <span class="required"> * </span>
                                </label>
                                <div class="col-md-4">
                                    <input type="text" name="CreateSourceType" required data-required="1" class="form-control" /> </div>
                            </div>

                            <div class="form-group row">
                                <label class="control-label col-md-3">Update Source Type
                                    <span class="required"> * </span>
                                </label>
                                <div class="col-md-4">
                                    <input type="text" name="UpdateSourceType" required data-required="1" class="form-control" /> </div>
                            </div>

                            <div class="form-group row">
                                <label class="control-label col-md-3">Get Single Source Type
                                    <span class="required"> * </span>
                                </label>
                                <div class="col-md-4">
                                    <input type="text" name="GetSingleSourceType" required data-required="1" class="form-control" /> </div>
                            </div>
                            <div class="form-group row">
                                <label class="control-label col-md-3">Detail Source Type
                                    <span class="required"> * </span>
                                </label>
                                <div class="col-md-4">
                                    <input type="text" name="DetailSourceType" required data-required="1" class="form-control" /> </div>
                            </div>
                            <div class="form-group row">
                                <label class="control-label col-md-3">Display Column Names
                                    <span class="required"> * </span>
                                </label>
                                <div class="col-md-4">
                                    <textarea name="DisplayColumnNames" required data-required="1" class="form-control"></textarea> </div>
                            </div>
                            <div class="form-group row">
                                <label class="control-label col-md-3">Detail Display Column Names
                                    <span class="required"> * </span>
                                </label>
                                <div class="col-md-4">
                                    <textarea name="DetailDisplayColumnNames" required data-required="1" class="form-control"></textarea> </div>
                            </div>
                            <div class="form-group row">
                                <label class="control-label col-md-3">Columns List
                                    <span class="required"> * </span>
                                </label>
                                <div class="col-md-4">
                                    <textarea name="ColumnsList" required data-required="1" class="form-control"></textarea> </div>
                            </div>
                            <div class="form-group row">
                                <label class="control-label col-md-3">Detail Columns List
                                    <span class="required"> * </span>
                                </label>
                                <div class="col-md-4">
                                    <textarea name="DetailColumnsList" required data-required="1" class="form-control"></textarea> </div>
                            </div>
                            <div class="form-group row">
                                <label class="control-label col-md-3">Edit Columns List
                                    <span class="required"> * </span>
                                </label>
                                <div class="col-md-4">
                                    <textarea name="EditFieldsList" required data-required="1" class="form-control"></textarea> </div>
                            </div>
                            <div class="form-group row">
                                <label class="control-label col-md-3">Chart Columns List
                                    <span class="required"> * </span>
                                </label>
                                <div class="col-md-4">
                                    <textarea name="ChartColumnsList" required data-required="1" class="form-control"></textarea> </div>
                            </div>
                            <div class="form-group row">
                                <label class="control-label col-md-3">Map Field Key
                                    <span class="required"> * </span>
                                </label>
                                <div class="col-md-4">
                                    <input type="text" name="MapFieldName" required data-required="1" class="form-control" /> </div>
                            </div>
                            <div class="form-group row">
                                <label class="control-label col-md-3">Except To Edit Columns List
                                    <span class="required"> * </span>
                                </label>
                                <div class="col-md-4">
                                    <textarea name="ExecptToEditFields" required data-required="1" class="form-control"></textarea> </div>
                            </div>
                            <div class="form-group row">
                                <label class="control-label col-md-3">Key Column
                                    <span class="required"> * </span>
                                </label>
                                <div class="col-md-4">
                                    <input type="text" name="KeyColumn" required data-required="1" class="form-control" /> </div>
                            </div>
                            <div class="form-group row">
                                <label class="control-label col-md-3">Detail Main Index
                                    <span class="required"> * </span>
                                </label>
                                <div class="col-md-4">
                                    <textarea name="DetailMainIndex" required data-required="1" class="form-control"></textarea> </div>
                            </div>
                            <div class="form-group row">
                                <label class="control-label col-md-3">Detail Key Column
                                    <span class="required"> * </span>
                                </label>
                                <div class="col-md-4">
                                    <input type="text" name="DetailKeyColumn" required data-required="1" class="form-control" /> </div>
                            </div>
                            <div class="form-group row">
                                <label class="control-label col-md-3">Request Type
                                    <span class="required"> * </span>
                                </label>
                                <div class="col-md-4">
                                    <select name="RequestType" class="form-control callType" required>
                                        <option value=""> Select Request Type</option>
                                        <option value="1">GET</option>
                                        <option value="2">POST</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="control-label col-md-3">Request Body
                                    <span class="required"> * </span>
                                </label>
                                <div class="col-md-4">
                                    <textarea name="RequestBody" required data-required="1" class="form-control"></textarea>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="control-label col-md-3">Detail Request Body
                                    <span class="required"> * </span>
                                </label>
                                <div class="col-md-4">
                                    <textarea name="DetailFilterBody" required data-required="1" class="form-control"></textarea>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="control-label col-md-3">Description
                                    <span class="required"> * </span>
                                </label>
                                <div class="col-md-4">
                                    <input type="text" name="Description" required data-required="1" class="form-control" /> </div>
                            </div>


                        </div>
                        <div class="form-group">
                            <div class="offset-md-3 col-md-9">
                                <div class="btn-group">
                                    <button type="submit" id="addRow" class="btn btn-info">
                                        Save <i class="fa fa-plus"></i>
                                    </button>
                                </div>
                                <div class="btn-group">
                                    <a class="btn deepPink-bgcolor" href="<?php echo baseUrl;?>placeholders">Cancel
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
    <script>
        $(document).ready(function () {
            $('.callType').on('change', function()
            {
                if(this.value == 3){
                    $('.call_method').show();
                } else {
                    $('.call_method').hide();
                }
            });
        });
    </script>
<?php //include_once 'layout/footer_start.php'; ?>