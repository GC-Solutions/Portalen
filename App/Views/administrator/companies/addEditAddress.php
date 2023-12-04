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
                    <header>Add Address</header>
                </div>
                <div class="card-body" id="bar-parent1">
                    <form action="<?php echo baseUrl; ?>saveAddress" method="post" id="form_sample_1" class="form-horizontal">
                        <div class="form-body">
                            <div class="form-group row">
                                <label class="control-label col-md-3">Address 
                                    <span class="required"> * </span>
                                </label>
                               
                                <div class="col-md-4">
                                    <input type="text" name="Address" value="<?php if(isset($getAddress[0]['Address'])) {echo $getAddress[0]['Address']; } ?>" required data-required="1"
                                           class="form-control"/>
                                </div>
                            </div>
                             <div class="form-group row">
                                <label class="control-label col-md-3">Address Name
                                    <span class="required"> * </span>
                                </label>
                               
                                <div class="col-md-4">
                                    <input type="text" name="AddressName" value="<?php if(isset($getAddress[0]['AddressName'])) {echo $getAddress[0]['AddressName']; } ?>" 
                                           class="form-control"/>
                                </div>
                            </div>

                            </div>

                            <input type="hidden" name="ID" value="<?php if(isset($getAddress[0]['ID'])) {echo $getAddress[0]['ID']; } ?>">
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