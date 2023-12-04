<?php include_once realpath(__DIR__) . '/../layout/newmenue.php'; ?>
<div class="page-wrapper">
    <!-- start page container -->
    <div class="page-container">


        <!-- start page content -->


        <div class="page-content-wrapper">
  <div class="page-content">
	             
	<?php include_once realpath(__DIR__) .'/../layout/submenus.php'; ?>

						
                 	<div class="page-title">

								
											<?php 
											if ($_SESSION) {
		                                echo $_SESSION['currentPageName'];
		                            } ?>
								
							</div>       
        
                <!-- start widget -->
			
<div class="page-title-breadcrumb">
                        
                        
						   <!--Del 1 -->  
												  
												  
									  <div class="row">
										  <div class="col-md-12 col-sm-12 col-12">
											  <div class="card card-box">
												  <div class="card-head">
													  <header class="Table_1"></header>
													  <div class="tools">
														 <a class="fa fa-repeat btn-color box-refresh" href="javascript:;"></a>
														 <a class="t-collapse btn-color fa fa-chevron-down"  aria-hidden="true" href="javascript:;"></a>
														 <a class="t-close btn-color fa fa-times" href="javascript:;"></a>
													 </div>
												  </div>
						  <!--panel start --> 
												  <div class="card-body no-padding height-9">
													  <div class="row">
						  
													  
													  <div class="col-md-4 col-sm-12 col-12" style="float: left;">
													  <div id="Panel_1"></div>
												  </div>
												  
												   <div class="col-md-4 col-sm-12 col-12" style="float: left;">
													  <div id="Panel_2"></div>
												  </div>
												  
												  <div class="col-md-4 col-sm-12 col-12" style="float: left;">
													  <div id="Panel_3"></div>
												  </div>
						  
												   </div>
																	  
						  <!--panel end -->  
						  <!--Graph Start --> 					
											  
											  <div class="col-md-12 col-sm-12 col-12">
												<div class="card-body no-padding height-9">
												  <div id="GraphHC_1"></div></div>
												   </div>
						  <!--Graph end --> 					
						   <!--Table start -->                             
											   <div class="table-responsive">
													<table class="table table-hover table-checkable order-column full-width"
												  		 id="Table_1"  style="height:80px">
																  <thead align="center"> <tr></tr></thead>
																<tfoot><tr></tr></tfoot>
															  </table>
														  </div>
						  <!--Table end -->       
														  
												  </div>
											   </div>
										  </div>
											  </div>
 <!--Del 2 -->  


 

			<div class="row">
				<div class="col-md-12 col-sm-12 col-12">
					<div class="card-box">

						<div class="card-body ">
							<div class = "mdl-tabs mdl-js-tabs">
								<div class = "mdl-tabs__tab-bar tab-left-side">
									<a href = "#tab4-panel" class = "mdl-tabs__tab tabs_three is-active" >
										<header class="Table_2"></header>
									</a>
									
									<a href = "#tab5-panel" class = "mdl-tabs__tab tabs_three">
										<header class="Table_3"></header>
									</a>
									<a href = "#tab6-panel" class = "mdl-tabs__tab tabs_three">
										<header class="Table_4"></header>
									</a>
									<a href = "#tab7-panel" class = "mdl-tabs__tab tabs_three">
										<header class="Table_5"></header>
									</a>
								</div>



								<div class = "mdl-tabs__panel is-active p-t-20" id = "tab4-panel">
								<div class="row">

						    
<div class="col-md-4 col-sm-12 col-12" style="float: left;">
<div id="Panel_4"></div>
</div>

<div class="col-md-4 col-sm-12 col-12" style="float: left;">
<div id="Panel_5"></div>
</div>

<div class="col-md-4 col-sm-12 col-12" style="float: left;">
<div id="Panel_6"></div>
</div>



</div>
				



<div class="col-md-12 col-sm-12 col-12">
<div class="card-body no-padding height-9">
<div id="GraphHC_2"></div></div>
</div>

									<div class="table-responsive">
										<table class="table table-hover table-checkable order-column full-width"
												   id="Table_2"  style="height:80px">
												   <thead align="center"> <tr></tr></thead>
																<tfoot><tr></tr></tfoot>
															  </table>


									</div>

								</div>









								<div class = "mdl-tabs__panel p-t-20" id = "tab5-panel">
								<div class="row">

						    
<div class="col-md-4 col-sm-12 col-12" style="float: left;">
<div id="Panel_7"></div>
</div>

<div class="col-md-4 col-sm-12 col-12" style="float: left;">
<div id="Panel_8"></div>
</div>

<div class="col-md-4 col-sm-12 col-12" style="float: left;">
<div id="Panel_9"></div>
</div>



</div>
				



<div class="col-md-12 col-sm-12 col-12">
<div class="card-body no-padding height-9">
<div id="GraphHC_3"></div></div>
</div>
<div class="table-responsive">
										<table class="table table-hover table-checkable order-column full-width"
												   id="Table_3"  style="height:80px">
												   <thead align="center"> <tr></tr></thead>
																<tfoot><tr></tr></tfoot>
															  </table>

									</div>

								</div>




								<div class = "mdl-tabs__panel p-t-20" id = "tab6-panel">
								<div class="row">

						    
<div class="col-md-4 col-sm-12 col-12" style="float: left;">
<div id="Panel_10"></div>
</div>

<div class="col-md-4 col-sm-12 col-12" style="float: left;">
<div id="Panel_11"></div>
</div>

<div class="col-md-4 col-sm-12 col-12" style="float: left;">
<div id="Panel_12"></div>
</div>



</div>
				



<div class="col-md-12 col-sm-12 col-12">
<div class="card-body no-padding height-9">
<div id="GraphHC_4"></div></div>
</div>



<div class="table-responsive">
										<table class="table table-hover table-checkable order-column full-width"
												   id="Table_4"  style="height:80px">
												   <thead align="center"> <tr></tr></thead>
																<tfoot><tr></tr></tfoot>
															  </table>

									</div>

								</div>

								<div class = "mdl-tabs__panel p-t-20" id = "tab7-panel">
								<div class="row">

						    
<div class="col-md-4 col-sm-12 col-12" style="float: left;">
<div id="Panel_13"></div>
</div>

<div class="col-md-4 col-sm-12 col-12" style="float: left;">
<div id="Panel_14"></div>
</div>

<div class="col-md-4 col-sm-12 col-12" style="float: left;">
<div id="Panel_15"></div>
</div>



</div>
				



<div class="col-md-12 col-sm-12 col-12">
<div class="card-body no-padding height-9">
<div id="GraphHC_5"></div></div>
</div>
<div class="table-responsive">
										<table class="table table-hover table-checkable order-column full-width"
												   id="Table_5"  style="height:80px">
												   <thead align="center"> <tr></tr></thead>
																<tfoot><tr></tr></tfoot>
															  </table>

									</div>

								</div>


							</div>
						</div>
					</div>
				</div>
			</div>
			





























			<div id="chartContainer" style="height: 100%; width: 1500%;"></div>
		</div>
	</div>
				<!-- end page content -->

			</div>
			<!-- end page container -->
		</div>
	</div>
	<?php include_once realpath(__DIR__) . '/../layout/footer_start.php'; ?>

