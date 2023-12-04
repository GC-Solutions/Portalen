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
                            <header>Add Products</header>
                        </div>
                        <div class="card-body" id="bar-parent1">
                            <form action="<?php echo baseUrl;?>saveproduct" method="post" id="form_sample_1" class="form-horizontal" enctype="multipart/form-data">
                                <div class="form-body">
                                    <input type="hidden" value="032156987420" name="productNo">

                                    <div class="form-group row">
                                        <label class="control-label col-md-3">New description 
                                        </label>

                                        <div class="col-md-4">
                                            <input type="text" name="description" required data-required="1" class="form-control"/>
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label class="control-label col-md-3"> Title
                                        </label>

                                        <div class="col-md-4">
                                            <input type="text" name="title" required  data-required="1" class="form-control"/>
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label class="control-label col-md-3">Image name
                                        </label>

                                        <div class="col-md-4">
                                            <input type="text" name="imageName" class="form-control"/>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="control-label col-md-3">product Image
                                        </label>

                                        <div class="col-md-4">
                                            <input type="file" name="image" >
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
                                            <a class="btn deepPink-bgcolor" a href="<?php echo baseUrl;?>editcompany?id=<?= $_REQUEST['id'];?>">Cancel
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