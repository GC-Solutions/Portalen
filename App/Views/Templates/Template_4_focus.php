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

				<div class="row">
					<div class="col-md-12">
						<div class="col-md-4" style="float: left;">
							<div id="Panel_1"></div>
						</div>
						<div class="col-md-4" style="float: left;">
							<div id="Panel_2"></div>
						</div>
						<div class="col-md-4" style="float: left;">
							<div id="Panel_3">
							</div>
						</div>
					</div>
				</div>


				<div class="row">

					<div class="col-md-12">
						<div class="card card-box">
							<div class="card-head">
								<header class="Table_1"></header>
							</div>
							<div class="card-body no-padding height-9">
								<div class="row">
									<div class="table-scrollable">
										<table class="table table-hover table-checkable order-column full-width"
											   id="Table_1"  style="height:80px">
											<thead>
												<tr></tr>
											</thead>
											<tfoot>
												<tr></tr>
											</tfoot>
										</table>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>

				<div class="row">
					<div class="col-md-6">
						<div class="card card-box">
							<div class="card-head">
								<header class="Table_2"></header>
							</div>
							<div class="card-body no-padding height-9">
								<div class="row">
									<div class="table-scrollable">
										<table class="table table-hover table-checkable order-column full-width"
											   id="Table_2"  style="height:180px">
											<thead>
												<tr></tr>
											</thead>
											<tfoot>
												<tr></tr>
											</tfoot>
										</table>
									</div>
								</div>
							</div>
						</div>
					</div>

					<div class="col-md-6">
						<div class="card card-box">
							<div class="card-head">
								<header class="Table_3"></header>
							</div>
							<div class="card-body no-padding height-9">
								<div class="row">
									<div class="table-scrollable">
										<table class="table table-hover table-checkable order-column full-width"
											   id="Table_3"  style="height:180px">
											<thead>
												<tr></tr>
											</thead>
											<tfoot>
												<tr></tr>
											</tfoot>
										</table>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>


				<div class="row">
					<div class="col-md-12">
						<div class="card card-box">
							<div id="Graph_1" class="card-head">
								<header class="graph_title"></header>
								<a class="graph_action"></a>
							</div>
							<div class="col-md-12">
								<div id="Graph_1">
									<div class=""></div>
									<div class="graph_filter"></div>
									<div class="graph" style="height:480px"></div>
								</div>
							</div>
						</div>


					</div>
				</div>









				<div class="row">
					<div class="col-md-12">
						<div class="card card-box">
							<div id="Graph_2" class="card-head">
								<header class="graph_title"></header>
								<a class="graph_action"></a>
							</div>
							<div class="col-md-12">
								<div id="Graph_2">
									<div class=""></div>
									<div class="graph_filter"></div>
									<div class="graph" style="height:480px"></div>
								</div>
							</div>
						</div>


					</div>
				</div>












				<div class="row">

					<div class="col-md-12">
						<div class="card card-box">
							<div class="card-head">
								<header class="Table_4"></header>
							</div>
							<div class="card-body no-padding height-9">
								<div class="row">
									<div class="table-scrollable">
										<table class="table table-hover table-checkable order-column full-width"
											   id="Table_4"  style="height:80px">
											<thead>
												<tr></tr>
											</thead>
											<tfoot>
												<tr></tr>
											</tfoot>
										</table>
									</div>
								</div>
							</div>
						</div>
					</div>























					<div id="chartContainer" style="height: 1500px; width: 1500%;"></div>
				</div>
				<!-- end page content -->

			</div>
			<!-- end page container -->
		</div>
	</div>
	<?php include_once realpath(__DIR__) . '/../layout/footer_start.php'; ?>

