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

<!--MAPS Start --> 					
					
					<div class="col-md-12 col-sm-12 col-12">
                      <div class="card-body no-padding height-9">
                      	  
			             <div id="MapHC_1"></div> </div>
   	                  </div>
<!--MAPS end --> 	





 <!--Table start -->                             
	                                 <div class="table-scrollable">
                                    	<table class="table display table table-checkable order-column full-width" cellspacing="0" id="Table_1">
                                        <thead align="center"> <tr></tr></thead>
									  <tfoot><tr></tr></tfoot>
								 
									  <tbody >
									  </tbody>
                                    </table>
									    <div class="arrow-container">
                                          <div class="left"></div>
                                          <div class="right"></div>
                                        </div>
                                   </div>
    
<!--Table end -->       
                                
                        </div>
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
							   <a class="t-collapse btn-color fa fa-chevron-down"  aria-hidden="true" href="javascript:;"></a>
							   <a class="t-close btn-color fa fa-times" href="javascript:;"></a>
		                   </div>
						</div>

                 <div class="card-body no-padding height-9">
                            <div class="row">

						    
						    <div class="col-md-4 col-sm-12 col-12" style="float: left;">
							<div id="Panel_5"></div>
						</div>
						
                         <div class="col-md-4 col-sm-12 col-12" style="float: left;">
							<div id="Panel_6"></div>
						</div>
						
						<div class="col-md-4 col-sm-12 col-12" style="float: left;">
							<div id="Panel_7"></div>
						</div>
						
						<div class="col-md-4 col-sm-12 col-12" style="float: left;">
							<div id="Panel_8"></div>
						</div>
					</div>
					
					
					<div class="col-md-12 col-sm-12 col-12">
                      <div class="card-body no-padding height-9">
			            <div id="GraphHC_2"></div></div>
   	                  </div>
					
						 <div class="table-scrollable">
                                    	<table class="table display table table-checkable order-column full-width" cellspacing="0" id="Table_2">
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
					<div class="card card-box">
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

						     <div id="Panel_9"></div>
							<div id="Panel_10"></div>
							<div id="Panel_11"></div>
							<div id="Panel_12"></div>
						</div>
					
					
					
					<div class="col-md-8 col-sm-12 col-12">
                      <div class="card-body no-padding height-9">
			            <div id="GraphHC_3"></div></div>
   	                  </div>
					
                                <div class="table">
                                    <table class="table table table-checkable order-column full-width aligment:F" id="Table_3">
                                        <thead align="center"> <tr></tr></thead>
									  <tfoot><tr></tr></tfoot>
                                    </table>
                                </div>
                                
                                
                        </div>
                     </div>
                </div>

                </div>


                <!--<div id="chartContainer" style="height: 300px; width: 100%;"></div>-->
            </div>
            <!-- end page content -->

        </div>
        <!-- end page container -->
    </div>
</div>
<?php include_once realpath(__DIR__) . '/../layout/footer_start.php'; ?>


<script>

let nav = document.querySelector(".table-scrollable");
let left = document.querySelector(".arrow-container .left");
let right = document.querySelector(".arrow-container .right");

let idx;

left.addEventListener("mouseenter", function(){
  idx = setInterval(() => nav.scrollLeft -= 3, 10);
});

left.addEventListener("mouseleave", function(){
  clearInterval(idx);
});

right.addEventListener("mouseenter", function(){
  idx = setInterval(() => nav.scrollLeft += 3, 10);
});

right.addEventListener("mouseleave", function(){
  clearInterval(idx);
});

</script>
