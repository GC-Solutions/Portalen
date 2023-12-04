<?php include_once realpath(__DIR__) . '/../layout/newmenue.php'; ?>
<div class="page-wrapper">
    <!-- start page container -->
<div class="page-container">
        <!-- start page content -->
<div class="page-content-wrapper">
  <div class="page-content">
                 	<!-- <div class="page-title" style="margin-top: -33px;">
                 		<div class="row">
                 			<div class="col-md-8 col-sm-8 col-8">
                 				<h2 style="font-size: 14px;float: left;margin: 0px;">
											<?php 
											
											if ($_SESSION) {
		                                echo $_SESSION['currentPageName'];
		                            } ?></h2>
		                	</div>
		                    <div class="col-md-4 col-sm-4 col-4">
					            <ol class="page-title-breadcrumb breadcrumb page-breadcrumb pull-right">
					            	<?php 
					            	$curr_Page = $_SESSION['currentPageName'];
					            	$breadcrumb = '';
					            	foreach ($_SESSION['PageDetails'] as $pageDetails ) {
					            		
					            		if($pageDetails['PageMenuText'] == $curr_Page)
					            		{
					            			
					            			$breadcrumb = '<li>'.$curr_Page.'</li>';
					            			if($pageDetails['ParentPageText'] != '')
					            			{
					            				foreach ($_SESSION['PageDetails'] as $subpage ) {
					            					
					            					if( strpos($pageDetails['ParentPageText'],$subpage['PageMenuText']) !== false)
					            					{
					            						
					            						$breadcrumb = '<li>'.$subpage['PageMenuText'].'</li><i class="fa fa-angle-right" style="line-height: 25px;padding: 0px 6px;"></i>'.$breadcrumb;

					            						 foreach ($_SESSION['PageDetails'] as $subpage1 ) {
							            					
							            					if(strpos($subpage['ParentPageText'],$subpage1['PageMenuText']) !== false)
							            					{

							            						$breadcrumb = '<li>'.$subpage1['PageMenuText'].'</li>&nbsp;<i class="fa fa-angle-right" style="line-height: 25px;padding: 0px 6px;"></i>'.$breadcrumb;
							            					}
							            				}

					            					}
					            				}
					            			}      
					            		}

					            	}
									echo $breadcrumb;?>
									
								</ol> 
					</div></div>			
					</div>  -->
<?php include_once realpath(__DIR__) . '/../layout/breadcrum.php'; ?>        
                <!-- start widget -->
			
				
<div class="page-title-breadcrumb">
                  
 <!--Del 1 -->  
                  
			<div class="row" >
				<div class="col-md-12 col-sm-12 col-12">
					<div class="card card-box" style="display:none"> 
						<div class="card-head">
							<header  class="Table_1"></header>
							<div class="tools">
		                       <a class="fa fa-repeat btn-color box-refresh" href="javascript:;"></a>
							   <a class="t-collapse btn-color fa fa-chevron-down"  aria-hidden="true" href="javascript:;"></a>
							   <a class="t-close btn-color fa fa-times" href="javascript:;"></a>
		                   </div>
						</div>
						<!-- <div  id="FormTable_1"></div>  -->
<!--panel start --> 	
<div id="FormTable_1">
                        <div class="card-body no-padding height-9">
                            <div class="row">

						    <!-- <h1>(testing Var)</h1> -->
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
	                                 <div class="table-scrollable">
                                    	<table class="table display table-hover table-checkable order-column full-width" "cellspacing="0" id="Table_1">
	                                        <thead align="center" id="Table_1_thead"> <tr></tr></thead>
											<tbody align="center" id="Table_1_tbody"> <tr></tr></tbody>
											<tfoot id="Table_1_tfoot"><tr></tr></tfoot>
									  
                                    	</table>
                                    	<div id = "Table_1_pagination">
                                    	</div>

                                   <!--  <table class="table display table-hover table-checkable order-column full-width" "cellspacing="0"  id="Table_1">
                                        <thead align="center" > <tr></tr></thead>
										
										<tfoot ><tr></tr></tfoot>
									  
                                    </table> -->
                                </div>
<!--Table end -->       
                                
                        </div>
                     </div>
                </div>
			</div>
					
					


 <!-- Del 2 -->
                            
			<div class="row" >
				<div class="col-md-12 col-sm-12 col-12">
					<div class="card card-box" style="display:none">
						<div class="card-head">
							<header class="Table_2"></header>
							<div class="tools">
		                       <a class="fa fa-repeat btn-color box-refresh" href="javascript:;"></a>
							   <a class="t-collapse btn-color fa fa-chevron-down"  aria-hidden="true" href="javascript:;"></a>
							   <a class="t-close btn-color fa fa-times" href="javascript:;"></a>
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
					
					
					<div class="col-md-12 col-sm-12 col-12">
                      <div class="card-body no-padding height-9">
			            <div id="GraphHC_2"></div></div>
   	                  </div>
					
						 <div class="table-scrollable">
                                    	<table class="table display table-hover table-checkable order-column full-width" "cellspacing="0" id="Table_2">
                                        <thead align="center"> <tr></tr></thead>
									  <tfoot><tr></tr></tfoot>
                                    </table>
                                </div>
                                
                                
                        </div>
                     </div>
                </div>
                	</div>

                    <!--Del 3 -->  
                        
                        
			<div class="row">
				<div class="col-md-12 col-sm-12 col-12">
					<div class="card card-box" style="display:none"> 
						<div class="card-head">
							<header class="Table_3"></header>
							<div class="tools">
		                       <a class="fa fa-repeat btn-color box-refresh" href="javascript:;"></a>
							   <a class="t-collapse btn-color fa fa-chevron-down"  aria-hidden="true" href="javascript:;"></a>
							   <a class="t-close btn-color fa fa-times" href="javascript:;"></a>
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
					
					
					
					<div class="col-md-8 col-sm-12 col-12">
                      <div class="card-body no-padding height-9">
			            <div id="GraphHC_3"></div></div>
   	                  </div>
					
                                <div class="table">
                                    <table class="table table-hover table-checkable order-column full-width aligment:F" id="Table_3">
                                        <thead align="center"> <tr></tr></thead>
									  <tfoot><tr></tr></tfoot>
                                    </table>
                                </div>
                                
                                
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



