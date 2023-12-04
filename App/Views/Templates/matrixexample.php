<?php include_once realpath(__DIR__) . '/../layout/pushexample.php'; ?>
<div class="page-wrapper">
    <!-- start page container -->
<div class="page-container">
<?php include_once realpath(__DIR__) . '/../layout/help_bar.php'; ?>
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
                  
 

     


                <!-- <div id="chartContainer" style="height: 300px; width: 100%;"></div>-->
            </div>

			<div class="page-bar">
						<div class="page-title-breadcrumb">
						
					</div>
					<div class="row">
                        <div class="col-md-12">
                            <div class="card card-topline-aqua">
                                <div class="card-head">
                                    <header>BASIC TABLE</header>
                                    <div class="tools">
                                        <a class="fa fa-repeat btn-color box-refresh" href="javascript:;"></a>
                                        <a class="t-collapse btn-color fa fa-chevron-down" href="javascript:;"></a>
                                        <a class="t-close btn-color fa fa-times" href="javascript:;"></a>
                                    </div>
                                </div>
                                <div class="card-body ">
                                    <div class="table-scrollable">
                                        <table id="example1" class="display full-width">
                                            <thead>
                                                <tr>
                                                    <th></th>
                                                    <th>2018</th>
                                                    <th>2019</th>
                                                    <th>2020</th>
                                                    <th>2021</th>
                                                    <th>2022</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td>Jan</td>
                                                    <td>20</td>
                                                    <td>20</td>
													<td>20</td>
                                                    <td>20</td>
                                                    <td>20</td>
                                                </tr>
                                                <tr>
                                                    <td>Feb</td>
                                                    <td>20</td>
                                                    <td>20</td>
													<td>20</td>
                                                    <td>20</td>
                                                    <td>20</td>
                                                </tr>
                                                <tr>
                                                    <td>Mar</td>
													<td>20</td>
                                                    <td>20</td>
													<td>20</td>
                                                    <td>20</td>
                                                    <td>20</td>
                                                </tr>
                                                <tr>
                                                    <td>April</td>
													<td>20</td>
                                                    <td>20</td>
													<td>20</td>
                                                    <td>20</td>
                                                    <td>20</td>
                                                </tr>
                                                <tr>
                                                    <td>Maj</td>
                                                    <td>20</td>
                                                    <td>20</td>
													<td>20</td>
                                                    <td>20</td>
                                                    <td>20</td>
                                                </tr>
                                                <tr>
                                                    <td>Jun</td>
													<td>20</td>
                                                    <td>20</td>
													<td>20</td>
                                                    <td>20</td>
                                                    <td>20</td>
                                                </tr>
                                                <tr>
                                                    <td>Jul</td>
                                                    <td>20</td>
                                                    <td>20</td>
													<td>20</td>
                                                    <td>20</td>
                                                    <td>20</td>
                                                </tr>
                                                <tr>
                                                    <td>Agusti</td>
													<td>20</td>
                                                    <td>20</td>
													<td>20</td>
                                                    <td>20</td>
                                                    <td>20</td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

            <!-- end page content -->


			<table class="display full-width">
		
		<thead>
		<tr>
			<th></th>
            <th>2018</th>
			<th>2019</th>
			<th>2020</th>
			<th>2021</th>
			<th>2022</th>
		</tr>
		</thead>
		<tbody>

		<tr>
			<td>Jan</td>
			<td></td>
			<td></td>
			<td></td>
			<td></td>
			<td></td>
		</tr>
		<tr>
			<td>Feb</td>
	    <td></td>
			<td></td>
			<td></td>
			<td></td>
			<td></td>
		</tr>
		<tr>
		<td>Mar</td>
			<td></td>
			<td></td>
			<td></td>
			<td></td>
			<td></td>
		</tr>
		<tr>
			<td>April</td>
			<td></td>
			<td></td>
			<td></td>
			<td></td>
			<td></td>
		</tr>
		<tr>
			<td>Maj</td>
			<td></td>
			<td></td>
			<td></td>
			<td></td>
			<td></td>
		</tr>
		</tbody>
	</table>

        </div>
        <!-- end page container -->
    </div>
</div>
<?php include_once realpath(__DIR__) . '/../layout/footer_start.php'; ?>



