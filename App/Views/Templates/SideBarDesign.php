<?php include_once realpath(__DIR__) . '/../layout/newmenue.php'; ?>

<div class="page-wrapper">
    <!-- start page container -->
    <div class="page-container">
        <!-- start page content -->
        <div class="page-content-wrapper">
            <div class="page-content">

                <?php include_once realpath(__DIR__) . '/../layout/breadcrum.php'; ?>


                <!-- Del 1 -->
                <div class="row">
                    <div class="col-md-12 col-sm-12 col-12">
                        <div class="card card-box">
                            <div class="card-head">
                                <header class="Table_1"></header>
                                <div class="tools">
                                    <a class="fa fa-repeat btn-color box-refresh" href="javascript:;"></a>
                                    <a class="t-collapse btn-color fa fa-chevron-down" aria-hidden="true"
                                        href="javascript:;"></a>
                                    <a class="t-close btn-color fa fa-times" href="javascript:;"></a>
                                </div>
                            </div>

                            <!-- panel start -->

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
                            </div>
                            <div class="card-body no-padding height-9">
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
                            </div>
                            <div class="card-body no-padding height-9">
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
                            </div>
                            <div class="card-body no-padding height-9">
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
                            </div>
                            <div class="card-body no-padding height-9">
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
                            </div>
                            <div class="card-body no-padding height-9">
                                <div class="row">


                                    <div class="col-md-4 col-sm-12 col-12" style="float: left;">
                                        <div id="Panel_16"></div>
                                    </div>

                                    <div class="col-md-4 col-sm-12 col-12" style="float: left;">
                                        <div id="Panel_17"></div>
                                    </div>

                                    <div class="col-md-4 col-sm-12 col-12" style="float: left;">
                                        <div id="Panel_18"></div>
                                    </div>

                                </div>
                            </div>
                            <div class="card-body no-padding height-9">
                                <div class="row">


                                    <div class="col-md-4 col-sm-12 col-12" style="float: left;">
                                        <div id="Panel_19"></div>
                                    </div>

                                    <div class="col-md-4 col-sm-12 col-12" style="float: left;">
                                        <div id="Panel_20"></div>
                                    </div>

                                    <div class="col-md-4 col-sm-12 col-12" style="float: left;">
                                        <div id="Panel_21"></div>
                                    </div>

                                </div>
                            </div>

                            <!--panel end -->
                            <!--Graph Start -->

                            <div class="card-body no-padding height-9">
                                <div class="row">


                                    <div class="col-md-5 col-sm-12 col-12" style="">
                                        <div class="card-body no-padding height-9">
                                            <div id="GraphHC_1"></div>
                                        </div>
                                    </div>

                                    <div class="col-md-4 col-sm-12 col-12" style="">
                                        <div class="card-body no-padding height-9">
                                            <div id="PieChartHC_1"></div>
                                        </div>
                                    </div>

                                    <div class="side-bar" style="display: none;">
                                        <h2 class="side-bar-h2">Todays Orders</h2>
                                        <div id="side-bar-box">
                                        </div>
                                    </div>
                                </div>


                            </div>


                            <!--Graph end -->
                            <!--Table start -->
                            <div class="table-scrollable">
                                <table class="table table-checkable order-column full-width" cellspacing="0"
                                    id="Table_1">
                                    <thead align="center">
                                        <tr></tr>
                                    </thead>
                                    <tfoot>
                                        <tr></tr>
                                    </tfoot>
                                </table>
                            </div>
                            <!--Table end -->

                        </div>
                    </div>
                </div>


                <!-- Del 2 -->

                <div class="row">
                    <div class="col-md-12 col-sm-12 col-12">
                        <div class="card card-box">
                            <div class="card-head">
                                <header class="Table_2"></header>
                                <div class="tools">
                                    <a class="fa fa-repeat btn-color box-refresh" href="javascript:;"></a>
                                    <a class="t-collapse btn-color fa fa-chevron-down" aria-hidden="true"
                                        href="javascript:;"></a>
                                    <a class="t-close btn-color fa fa-times" href="javascript:;"></a>
                                </div>
                            </div>

                            <div class="card-body no-padding height-9">
                                <div class="row">


                                    <div class="col-md-4 col-sm-12 col-12" style="float: left;">
                                        <div id="Panel_22"></div>
                                    </div>

                                    <div class="col-md-4 col-sm-12 col-12" style="float: left;">
                                        <div id="Panel_23"></div>
                                    </div>

                                    <div class="col-md-4 col-sm-12 col-12" style="float: left;">
                                        <div id="Panel_24"></div>
                                    </div>


                                </div>


                                <div class="col-md-12 col-sm-12 col-12">
                                    <div class="card-body no-padding height-9">
                                        <div id="GraphHC_19"></div>
                                    </div>
                                </div>

                                
                                    

                                <div class="table-sidebar">

                                <table class="table-scrollable table-scrollable-nav order-column full-width" cellspacing="0" id="Table_2">       
                                            <thead align="center">
                                                <tr></tr>
                                            </thead>
                                            <tfoot>
                                                <tr></tr>
                                            </tfoot>
                                    </table>
                                    
                                    <!-- <button class="side-bar-btn" onclick="toggleNav()">Open</button> -->

                                    <!--Side Bar Table -->
                                    <div id="mySidenav" class="side-bar-table">
                                        <div class="nav-close-header">
                                           <button class="nav-close" onclick="toggleNav()">✖</button>
                                        </div>

                                        <!-- <h3 class="side-bar-2-h2">Side bar</h3> -->
                                    </div>
                                </div>
                            </div>

                            <div id="chartContainer" style="height: 300px; width: 100%;"></div>
                        </div>

                        <!--Del 3 -->
                        <div class="row">
                                <div class="col-md-12 col-sm-12 col-12">
                                    <div class="card card-box">
                                        <div class="card-head">
                                            <header class="Table_3"></header>
                                            <div class="tools">
                                                <a class="fa fa-repeat btn-color box-refresh" href="javascript:;"></a>
                                                <a class="t-collapse btn-color fa fa-chevron-down" aria-hidden="true"
                                                    href="javascript:;"></a>
                                                <a class="t-close btn-color fa fa-times" href="javascript:;"></a>
                                            </div>
                                        </div>

                                        <div class="card-body no-padding height-9">
                                            <div class="row">


                                                <div class="col-md-4 col-sm-12 col-12" style="float: left;">
                                                    <div id="Panel_25"></div>
                                                </div>

                                                <div class="col-md-4 col-sm-12 col-12" style="float: left;">
                                                    <div id="Panel_26"></div>
                                                </div>

                                                <div class="col-md-4 col-sm-12 col-12" style="float: left;">
                                                    <div id="Panel_27"></div>
                                                </div>


                                            </div>

                                            <div class="col-md-8 col-sm-12 col-12">
                                                <div class="card-body no-padding height-9">
                                                    <div id="GraphHC_3"></div>
                                                </div>
                                            </div>

                                            <div class="table">
                                                <table class="table table-checkable order-column full-width aligment:F"
                                                    id="Table_3">
                                                    <thead align="center">
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
                    <!-- end page content -->

                </div>
                <!-- end page container -->
            </div>
        </div>

        <?php include_once realpath(__DIR__) . '/../layout/footer_start.php'; ?>

        <!-- <div class="page-title-breadcrumb"> -->
        <!-- 1  Start -->
        <!--Row Start -->
        <!-- <div class="row"> -->
        <!--Box Start -->
        <!-- <div class="col-md-12 col-sm-12 col-12">
					<div class="card card-box">
						    <div class="card-head">
							       <header class="Table_1"></header>
							    <div class="tools">
		                          <a class="fa fa-repeat btn-color box-refresh" href="javascript:;"></a>
							      <a class="t-collapse btn-color fa fa-chevron-down"  aria-hidden="true" href="javascript:;"></a>
							      <a class="t-close btn-color fa fa-times" href="javascript:;"></a>
		                        </div>
						    </div>
					</div>
                </div> -->
        <!--Box End -->
        <!-- </div> -->
        <!--Row End -->

        <!--Row Start -->
        <!-- <div class="row"> -->
        <!--Box Start -->
        <!-- <div class="col-md-12 col-sm-12 col-12"> -->
        <!-- <div class="card card-box"> -->
        <!-- Panel Start 
						<div class="card-body no-padding height-9">
                            <div class="row">
	                            <div class="col-md-4 col-sm-12 col-12">
						                 <div class="col" id="Panel_1"></div>
						        </div>
                                <div class="col-md-4 col-sm-12 col-12">
						                 <div class="col" id="Panel_2"></div>    
						        </div>
                                <div class="col-md-4 col-sm-12 col-12">
						                 <div class="col" id="Panel_3"></div>    
						        </div>
						    </div>
                        </div> -->
        <!--Panel End -->
        <!-- </div>
                </div> 
                </div> -->
        <!--Box End -->

        <!--Row Start -->
        <!-- <div class="row"> -->

        <!--Box Start -->
        <!-- <div class="col-md-6 col-sm-12 col-12">
					<div class="card card-box"> -->
        <!--Graph Start -->
        <!-- <div class="col-md-12 col-sm-12 col-12" style="float: left;">
                            <div class="card-body no-padding height-9">
			                    <div id="GraphHC_1"></div>
							</div>
   	                    </div> -->
        <!--Graph Start -->
        <!-- </div>
                </div> -->
        <!--Box End -->

        <!--Box Start -->
        <!-- <div class="col-md-6 col-sm-12 col-12">
					<div class="card card-box"> -->
        <!--Pichart Start -->
        <!-- <div class="col-md-12 col-sm-12 col-12">
						    <div class="card-body no-padding height-9">
						    <div id="PieChartHC_1"></div>
						    </div>
					    </div> -->
        <!-- Pichart End
			        </div>
                </div> -->
        <!--Box End -->
        <!-- </div> -->
        <!--Row End -->

        <!--Row Start -->
        <!-- <div class="row"> -->
        <!--Box Start -->
        <!-- <div class="col-md-12 col-sm-12 col-12">
					<div class="card card-box"> -->
        <!--Table Start -->
        <!-- <div class="table-scrollable" >
                            <table class="table-hover" style="width:100%" id="Table_1">
                                <thead  align="left"> <tr></tr></thead>
								<tfoot><tr></tr></tfoot>
                            </table>
                        </div> -->
        <!--Table End -->
        <!-- </div> -->
        <!-- </div> -->
        <!--Box End -->
        <!-- </div> -->
        <!--Row End -->
        <!-- 1  End -->

        <!-- 2  Start -->
        <!--Row Start -->
        <!-- <div class="row"> -->
        <!--Box Start -->
        <!-- <div class="col-md-12 col-sm-12 col-12">
					<div class="card card-box">
						    <div class="card-head">
							       <header class="Table_2"></header>
							    <div class="tools">
		                          <a class="fa fa-repeat btn-color box-refresh" href="javascript:;"></a>
							      <a class="t-collapse btn-color fa fa-chevron-down"  aria-hidden="true" href="javascript:;"></a>
							      <a class="t-close btn-color fa fa-times" href="javascript:;"></a>
		                        </div>
						    </div>
					</div>
                </div> -->
        <!--Box End -->
        <!-- </div> -->
        <!--Row End -->
        <!--Row Start -->
        <!-- <div class="row"> -->
        <!--Box Start -->
        <!-- <div class="col-md-12 col-sm-12 col-12">
					<div class="card card-box"> -->
        <!--Table Start -->
        <!-- <div class="table-scrollable" >
                            <table class="table display" style="width:100%" id="Table_2">
                                <thead  align="left"> <tr></tr></thead>
								<tfoot><tr></tr></tfoot>
                            </table>
                        </div> -->
        <!--Table End -->
        <!-- </div>
                </div> -->
        <!--Box End -->
        <!-- </div> -->
        <!--Row End -->
        <!-- 2  Start -->



        <!-- <div id="chartContainer" style="height: 300px; width: 100%;"></div>
     </div> -->
        <!-- end page content -->
        <!-- </div> -->
        <!-- end page container -->
        <!-- </div>
</div> -->