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
                    <header>Add FIlter Width</header>
                </div>
                <div class="card-body" id="bar-parent1">
                    <form action="<?php echo baseUrl; ?>saveFilterWidth" method="post" id="form_sample_1" class="form-horizontal">
                        <div class="form-body">
                            <div class="form-group row">
                                <label class="control-label col-md-3"> Min Filter Width
                                   
                                </label>
                               
                                <div class="col-md-4">
                                    <input type="text" name="FilterWidth" value="<?php if(isset($filterDetail['FilterWidth'])) {echo $filterDetail['FilterWidth']; } ?>" 
                                           class="form-control"/>
                                           <span class="required"> Width should be in px (pixel) </span>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="control-label col-md-3"> Max Filter Width
                                    
                                </label>
                               
                                <div class="col-md-4">
                                    <input type="text" name="MaxFIlterWidth" value="<?php if(isset($filterDetail['MaxFIlterWidth'])) {echo $filterDetail['MaxFIlterWidth']; } ?>" 
                                           class="form-control"/>
                                           <span class="required"> Width should be in px (pixel) </span>
                                </div>
                            </div>

                            <input type="hidden" name="ID" value="<?php if(isset($filterDetail['ID'])) {echo $filterDetail['ID']; } ?>">
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