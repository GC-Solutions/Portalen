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
							<div class=" pull-left">
								<div class="page-title">Notifications</div>
							</div>
							<ol class="breadcrumb page-breadcrumb pull-right">
								<li><i class="fa fa-home"></i>&nbsp;<a class="parent-item"
										href="index.html">Home</a>&nbsp;<i class="fa fa-angle-right"></i>
								</li>
								<li><a class="parent-item" href="">UI</a>&nbsp;<i class="fa fa-angle-right"></i>
								</li>
								<li class="active">Notifications</li>
							</ol>
						</div>
					</div>
					<div class="row">
						<div class="col-sm-12">
							<div class="card-box">
								<div class="card-head">
									<header>Toast Type</header>
								</div>
								<div class="card-body ">
									<div class="row clearfix jsdemo-notification-button">
										<div class="col-sm-12 col-md-4 col-lg-3">
											<button class="tstInfo btn btn-info">Info Message</button>
										</div>
										<div class="col-sm-12 col-md-4 col-lg-3">
											<button class="tstWarning btn btn-warning">Warning Message</button>
										</div>
										<div class="col-sm-12 col-md-4 col-lg-3">
											<button class="tstSuccess btn btn-success">Success Message</button>
										</div>
										<div class="col-sm-12 col-md-4 col-lg-3">
											<button class="tstError btn btn-danger">Error Message</button>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-sm-12">
							<div class="card-box">
								<div class="card-head">
									<header>More Options</header>
								</div>
								<div class="card-body ">
									<div class="row clearfix jsdemo-notification-button">
										<div class="col-sm-12 col-md-4 col-lg-3">
											<button class="tstSimple btn btn-info">Simple</button>
										</div>
										<div class="col-sm-12 col-md-4 col-lg-3">
											<button class="tstArray btn btn-info">Text Array</button>
										</div>
										<div class="col-sm-12 col-md-4 col-lg-3">
											<button class="tstHtml btn btn-info">Html Text</button>
										</div>
										<div class="col-sm-12 col-md-4 col-lg-3">
											<button class="tstSticky btn btn-info">Sticky</button>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-sm-12">
							<div class="card-box">
								<div class="card-head">
									<header>Toast Animations</header>
								</div>
								<div class="card-body ">
									<div class="row clearfix jsdemo-notification-button">
										<div class="col-sm-12 col-md-4 col-lg-3">
											<button class="tstFade btn btn-info">Fade</button>
										</div>
										<div class="col-sm-12 col-md-4 col-lg-3">
											<button class="tstSlide btn btn-info">Slide</button>
										</div>
										<div class="col-sm-12 col-md-4 col-lg-3">
											<button class="tstPlain btn btn-info">Plain</button>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-sm-12">
							<div class="card-box">
								<div class="card-head">
									<header>Toast Position</header>
								</div>
								<div class="card-body ">
									<div class="row clearfix jsdemo-notification-button">
										<div class="col-sm-12 col-md-4 col-lg-3 p-b-20">
											<button class="tstBtmLeft btn btn-info">Bottom Left</button>
										</div>
										<div class="col-sm-12 col-md-4 col-lg-3 p-b-20">
											<button class="tstBtmRight btn btn-info">Bottom Right</button>
										</div>
										<div class="col-sm-12 col-md-4 col-lg-3 p-b-20">
											<button class="tstBtmCenter btn btn-info">Bottom Center</button>
										</div>
										<div class="col-sm-12 col-md-4 col-lg-3 p-b-20">
											<button class="tstTopLeft btn btn-info">Top Left</button>
										</div>
										<div class="col-sm-12 col-md-4 col-lg-3">
											<button class="tstTopRight btn btn-info">Top Right</button>
										</div>
										<div class="col-sm-12 col-md-4 col-lg-3">
											<button class="tstTopCenter btn btn-info">Top Center</button>
										</div>
										<div class="col-sm-12 col-md-4 col-lg-3">
											<button class="tstMidCenter btn btn-info">Middle Center</button>
										</div>
										<div class="col-sm-12 col-md-4 col-lg-3">
											<button class="tstCustom btn btn-info">Custom Positon</button>
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



