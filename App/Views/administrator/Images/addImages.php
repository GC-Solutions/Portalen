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
                    <header>Add Images </header>
                </div>
                <div class="card-body" id="bar-parent1">
                    <form action="<?php echo baseUrl; ?>saveImage" method="post"  enctype="multipart/form-data" id="form_sample_1" class="form-horizontal">
                        <div class="form-body">
                            <div class="form-group row">
                                <label class="control-label col-md-3"> Name 
                                    <span class="required"> * </span>
                                </label>
                               
                                <div class="col-md-4">
                                    <input type="text" name="Name" value="<?php if(isset($getImage[0]['Name'])) {echo $getImage[0]['Name']; } ?>" required data-required="1"
                                           class="form-control"/>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="control-label col-md-3"> Company
                                    <span class="required"> * </span>
                                </label>
                                <div class="col-md-4">
                                    <select name="CompanyName" 
                                            class="form-control select2 UserCompanyName" data-reorder="1" 
                                            required="">
                                        <option value="">Select</option>
                                        <?php
                                        
                                         // if ($existingColumnsOfDataSource) {
                                         //    $getTableColumns = $getTableDetails['ColumnsMatching'];
                                           
                                          
                                                foreach ($allCompanies as $key => $value) {
                                                    $selected = "";
                                                   
                                                    // if (isset($getImage) && $value == $getImage[0]['CompanyName'])) {
                                                    //     $selected = 'selected="selected"';
                                                    // }

                                                    echo '<option value= "'. $value['CompanyID'].'-'.$value['CompanyName'].'"'. $selected . '>' . $value['CompanyName'] . '</option>';

                                                }
                                            
                                            ?>
                                    
                                    </select>
                              
                                      
                                </div>
                            </div>
                             <div class="form-group row">
                                <label class="control-label col-md-3">User Name
                                    <span class="required"> * </span>
                                </label>
                               
                                <div class="col-md-4">
                                        <select name="UserName" id="multiple"
                                                class="form-control select2 UserColumns" >
                                            <option value="">Select</option>
                                            <?php
                                            
                                           
                                                // $getTableColumns = $getTableDetails['ColumnsMatching'];
                                               
                                               
                                                // if ($getTableColumns) {
                                                //     $getTableColumns = explode(',', $getTableColumns);
                                                // }
                                                
                                                // $existingColumnsOfDataSource = explode(',', $existingColumnsOfDataSource);
                                              
                                            
                                                    // foreach ($existingColumnsOfDataSource as $key => $value) {
                                                    //     $selected = "";
                                                    //     $value = trim($value);
                                                    //     if (in_array($value, $getTableColumns)) {
                                                    //         $selected = 'selected="selected"';
                                                    //     }

                                                    //     echo '<option value= "'. $value . '"'. $selected . '>' . $value . '</option>';

                                                    // }
                                                
                                                ?>
                                         
                                        </select>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="control-label col-md-3">Image Name
                                    <span class="required"> * </span>
                                </label>
                               
                                <div class="col-md-4">
                                    <input type="text" name="ImageName" value="<?php if(isset($getImage[0]['ImageName'])) {echo $getImage[0]['ImageName']; } ?>" 
                                           class="form-control"/>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="control-label col-md-3">Upload Image
                                    <span class="required"> * </span>
                                </label>
                               
                                <div class="col-md-4">
                                    <input type="file" name="ImagePath" >
                                </div>
                            </div>
                           

                            </div>

                            <input type="hidden" name="ID" value="<?php if(isset($getImage[0]['ID'])) {echo $getImage[0]['ID']; } ?>">
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