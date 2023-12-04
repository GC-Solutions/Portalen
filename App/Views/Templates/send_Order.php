<?php include_once realpath(__DIR__) . '/../layout/newmenue.php'; ?>
<div class="page-wrapper">
    <!-- start page container -->
<div class="page-container">
        <!-- start page content -->
<div class="page-content-wrapper">
  <div class="page-content">
<?php include_once realpath(__DIR__) . '/../layout/breadcrum.php'; ?>        

			
<div class="page-title-breadcrumb">
                  
 <!--Del 1 -->  
                  
			<div class="row" >
				<div class="col-md-12 col-sm-12 col-12">
					<div class="card card-box">	
						<div class="card-head">
							<header class="Table_1"></header>
							
                        <form action="<?php echo baseUrl; ?>saveSendOrderData" method="post"
                              class="form-horizontal" enctype="multipart/form-data">
                           
                           
                            <?php if ($apiData) {
                                foreach ($apiData as $key => $eachRow) { ?>
                                    <div class="form-body">

                                        <?php if($eachRow->columnType == 'textField')
                                        { ?>
                                            <div class="form-group row">
                                            <label class="control-label col-md-5">
                                                <?= $key;?>
                                            </label>

                                           
                                            <div class="col-md-5">
                                                <input type="text" name="<?= $key;?>" value="" class="form-control"/>
                                            </div>
                                        </div>
                                        <?php } elseif($eachRow->columnType == 'file') { ?>
                                            <div class="form-group row">
                                                <label class="control-label col-md-5">
                                                    <?= $key;?>
                                                </label>
                                                <div class="col-md-5">
                                                    <input type="file" name="<?= $key;?>" >
                                                </div>
                                        </div>
                                         <?php } ?>
                                    </div>
                               
                           <?php } } ?>
                            <div class="form-body">
                                <div class="form-group">
                                    <div class="offset-md-5 col-md-7">
                                        <div class="btn-group">
                                            <button type="submit" class="btn btn-danger">
                                                Update
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
						</div>

                     </div>
                </div>
			                      
                <!-- <div id="chartContainer" style="height: 300px; width: 100%;"></div>-->
            </div>

            <!-- end page content -->

        </div>
        <!-- end page container -->
    </div>
</div>
<?php include_once realpath(__DIR__) . '/../layout/footer_start.php'; ?>



