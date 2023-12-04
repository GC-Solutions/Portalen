<?php include_once realpath(__DIR__) . '/../layout/newmenue.php'; ?>
<div class="page-wrapper">
	<!-- start page container -->
    <div class="page-container">
		<!-- start page content -->
		<div class="page-content-wrapper">
			<div class="page-content">
				    <?php include_once realpath(__DIR__) . '/../layout/breadcrum.php'; ?>   				
                <div class="page-title-breadcrumb">
					
					

					<!--Row start -->	 
					<div class="row">
						<!--Content start -->
						<div class="col-md-12 col-sm-12 col-12">
							<div class="card card-box">
							   
									<div class="card-body ">
                                        <div class="row">										 
	                                            
											            <!-- Menu Ticket Start -->
														<div class="col-md-2">
											            <div class="inbox">
													        <div class="inbox-sidebar">
														       <!--<a href="#" data-title="Compose" class="btn red compose-btn btn-block">
																  <i class="fa fa-edit"></i></a>-->
															
															    <ul class="inbox-nav inbox-divider">
																	<?php   foreach ($_SESSION['PageDetails'] as $pageDetails) { 
																		
																		if( $pageDetails['EnableTicketMenuLabel']){ 
																			$path = 'page?id=' . $pageDetails['PageTableID'].'&page_text=' .$pageDetails['PageMenuText']; 
																			?>
																		
																			<li><a  href ="<?php echo $path ;?>"> <?  echo $pageDetails['PageMenuText'] ;?>
																			<?php if( $pageDetails['PageMenuText'] == 'Öppen' || $pageDetails['PageMenuText'] == 'Väntad' || $pageDetails['PageMenuText'] == 'Löst' || $pageDetails['PageMenuText'] == 'Avslutat' || $pageDetails['PageMenuText'] == 'Brådskande' )
																			{ ?>
																				<span class="label mail-counter-style label-info " style="float: right;" id="<?php echo $pageDetails['PageMenuText'];?>">0</span>
																			<?php }
																				 ?>
																			</a></li>																

																	<?php } 
																		} 
																	?>
																	<!-- <li class="active" onclick ="SaveFilterData('Table_1' , 'page?id=1032&page_text=Company%20Tickets')"><a><i class="fa fa-inbox"></i>Tickets <span class="label mail-counter-style label-danger pull-right">2</span></a></li>
																	<li> <a href="#"><i class="fa fa-envelope"></i> Öppen <span class="label mail-counter-style label-danger pull-right">20</span></a></li>
																	<li><a href="#"><i class="fa fa-briefcase"></i> Väntad<span class="label mail-counter-style label-danger pull-right">4</span></a></li>
																	<li><a href="#"><i class="fa fa-briefcase"></i> Löst<span class="label mail-counter-style label-danger pull-right">49</span></a></li>
																	<li><a href="#"><i class="fa fa-briefcase"></i> Avslutat<span class="label mail-counter-style label-danger pull-right">543</span></a></li>
																	<li><a href="#"><i class="fa fa-star"></i> Brådskande<span class="label mail-counter-style label-danger pull-right">4</span></a></li>
																	<li><a href="#"><i class="fa fa-star"></i> Företag<span class="label mail-counter-style label-danger pull-right">169</span></a></li>
																	<li><a href="#"><i class="fa fa-star"></i> Kontakter<span class="label mail-counter-style label-danger pull-right">659</span></a></li>
																 -->
																</ul>
																
																<ul class="nav nav-pills nav-stacked labels-info inbox-divider">
																									
																	<li><h4>Priotering</h4></li>
																	<?php   foreach ($_SESSION['PageDetails'] as $pageDetails) { 
																		
																			if(trim($pageDetails['PageMenuText']) == 'Priotering' &&  $pageDetails['EnableTicketClickFilter'] != '1' ){ 
																				$pathPriority = 'page?id=' . $pageDetails['PageTableID'].'&page_text=' .$pageDetails['PageMenuText']; 
																			} else if ( trim($pageDetails['PageMenuText']) == 'Handlägare'){
																				$pathHandlägare = 'page?id=' . $pageDetails['PageTableID'].'&page_text=' .$pageDetails['PageMenuText']; 
																			} else if (trim($pageDetails['PageMenuText']) == 'Grupp'){
																				$pathGrupp = 'page?id=' . $pageDetails['PageTableID'].'&page_text=' .$pageDetails['PageMenuText']; 
																			}
																		} 
																	?>
																	<li <?php if(!isset($pathPriority)) { ?> onclick="updateFilter('Table_1' , 'Låg' , 3)" <?php } ?>><a  <?php if(isset($pathPriority)) { ?>href="<?php echo $pathPriority.'&columnName=priority&columnValue=1'; ?>" <?php }?>><i class=" fa fa-tags"></i> Låg <span class="label mail-counter-style label-info " style="float: right;" id="Low">0</span></a></li>
																	<li <?php if(!isset($pathPriority)) { ?> onclick="updateFilter('Table_1' , 'Medium' , 3)" <?php } ?>><a  <?php if(isset($pathPriority)) { ?> href="<?php echo $pathPriority.'&columnName=priority&columnValue=2'; ?>" <?php }?> ><i class=" fa fa-tags "></i> Medium <span class="label mail-counter-style label-info " style="float: right;" id="Medium">0</span></a></li>
																	<li  <?php if(!isset($pathPriority)) { ?> onclick="updateFilter('Table_1' , 'Hög' , 3)" <?php } ?>><a  <?php if(isset($pathPriority)) { ?> href="<?php echo $pathPriority.'&columnName=priority&columnValue=3'; ?>" <?php }?>><i class=" fa fa-tags "></i> Hög  <span class="label mail-counter-style label-info " style="float: right;" id="High">0</span></a></li>
																	<li <?php if(!isset($pathPriority)) { ?> onclick="updateFilter('Table_1' , 'Bråskande' , 3)" <?php } ?>><a  <?php if(isset($pathPriority)) { ?> href="<?php echo $pathPriority.'&columnName=priority&columnValue=4'; ?>" <?php }?>><i class=" fa fa-tags "></i> Bråskande  <span class="label mail-counter-style label-info " style="float: right;" id="Urgent">0</span></a></li>
																</ul>
											
<!-- 											
																<ul class="nav nav-pills nav-stacked labels-info inbox-divider">
																	
																	<li><h4>Handlägare</h4></li>
																	<?php if($getAllAgents){
																		foreach ($getAllAgents as $key => $value) {  ?>
																			<li><a href="<?php if(isset($pathHandlägare)) {echo $pathHandlägare.'&columnName=agent_id&columnValue='.$value['agent_id'];} ?>"><i class=" fa fa-tags "></i><?php echo  $value['contact_name']; ?></a></li>
																		<?php }

																	}?>
																</ul>
											
																<ul class="nav nav-pills nav-stacked labels-info inbox-divider">
																									
																    <li><h4>Grupp</h4></li>
																    <?php if($getAllGroups){
																		foreach ($getAllGroups as $key => $value) { ?>

																			<li><a href="<?php if(isset($pathGrupp)) {echo $pathGrupp.'&columnName=group_id&columnValue='.$value['group_id']; }?>"><i class=" fa fa-tags "></i><?php echo  $value['group_name']; ?></a></li>
																		<?php }

																	}?>
																</ul> -->
													        </div>
												        </div>
											        </div>
										            <!-- Menu Ticket End -->
										       
										 
										 
												            <!-- Table Start -->
															<div class="col-md-9">
														<div class="table-scrollable">
														<table class="table display table-hover table-checkable order-column full-width" "cellspacing="0" id="Table_1">
																		<thead> <tr></tr></thead>
																	    <tfoot><tr></tr></tfoot>
																	</table>
																</div>	
														     </div>						 
												            <!-- Table Start --> 
                                        </div>
								    </div> 								
							    </div>
						    </div>
						<!--Content start -->
					    </div>       
			        <!--Row end -->	
                    </div>

					 
					 
					 
					 
					 
					 
					 
					 
					 
					 
					 
					 
					 
					 


		 


				     <div id="chartContainer" style="height: 300px; width: 100%;"></div>
				</div>
			</div>
			<!-- end page content -->
		</div>
		<!-- end page container -->
	</div>
</div>
<?php include_once realpath(__DIR__) . '/../layout/footer_start.php'; ?>
