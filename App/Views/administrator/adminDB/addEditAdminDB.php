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
                    <header>Add Admin DB </header>
                </div>
                <div class="card-body" id="bar-parent1">
                    <form action="<?php echo baseUrl; ?>saveAdminDB" method="post" id="form_sample_1" class="form-horizontal">
                        <div class="form-body">
                            <div class="form-group row">
                                <label class="control-label col-md-3"> Name 
                                    <span class="required"> * </span>
                                </label>
                               
                                <div class="col-md-4">
                                    <input type="text" name="Name" value="<?php if(isset($getAdminDB[0]['Name'])) {echo $getAdminDB[0]['Name']; } ?>" required data-required="1"
                                           class="form-control"/>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="control-label col-md-3"> DBtype
                                    <span class="required"> * </span>
                                </label>
                                 <div class="col-md-4">
                                        <?php
                                        $DBType = (isset($getAdminDB[0]['DBType'])) ? $getAdminDB[0]['DBType'] : "";
                                    
                                        ?>
                                        <select name="DBType" id="DBType" class="form-control" >
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
                                            } ?>>MongoDb
                                            </option>
                                        </select>
                                    </div>
                            </div>
                             <div class="form-group row">
                                <label class="control-label col-md-3">Host Name
                                    <span class="required"> * </span>
                                </label>
                               
                                <div class="col-md-4">
                                    <input type="text" name="HostName" value="<?php if(isset($getAdminDB[0]['HostName'])) {echo $getAdminDB[0]['HostName']; } ?>" 
                                           class="form-control"/>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="control-label col-md-3">DB Name
                                    <span class="required"> * </span>
                                </label>
                               
                                <div class="col-md-4">
                                    <input type="text" name="DBName" value="<?php if(isset($getAdminDB[0]['DBName'])) {echo $getAdminDB[0]['DBName']; } ?>" 
                                           class="form-control"/>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="control-label col-md-3">User Name
                                    <span class="required"> * </span>
                                </label>
                               
                                <div class="col-md-4">
                                    <input type="text" name="Username" value="<?php if(isset($getAdminDB[0]['Username'])) {echo $getAdminDB[0]['Username']; } ?>" 
                                           class="form-control"/>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="control-label col-md-3">Password
                                    <span class="required"> * </span>
                                </label>
                               
                                <div class="col-md-4">
                                    <input type="text" name="DBPassword" value="<?php if(isset($getAdminDB[0]['DBPassword'])) {echo $getAdminDB[0]['DBPassword']; } ?>" 
                                           class="form-control"/>
                                </div>
                            </div>

                            </div>

                            <input type="hidden" name="ID" value="<?php if(isset($getAdminDB[0]['ID'])) {echo $getAdminDB[0]['ID']; } ?>">
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