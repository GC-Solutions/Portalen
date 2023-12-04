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
	                                                <div class="col-md-2" style="box-shadow: 10px 0 10px -3px #f2f2f2;">
											            <div class="inbox">
													        <div class="inbox-sidebar">
														      <!--<a href="#" data-title="Compose" class="btn red compose-btn btn-block">
                                                                 <i class="fa fa-edit"></i></a>-->
															
															    <ul class="inbox-nav inbox-divider">
																	<?php   foreach ($_SESSION['PageDetails'] as $pageDetails) { 
																		
																		if( $pageDetails['EnableTicketMenuLabel']){ 
																			$path = 'page?id=' . $pageDetails['PageTableID'].'&page_text=' .$pageDetails['PageMenuText']; 
																			?>
																		
																			<li><a href ="<?php echo $path ;?>" > <?  echo $pageDetails['PageMenuText'] ;?> </a></li>																

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
																
																<!-- <ul class="nav nav-pills nav-stacked labels-info inbox-divider">
																									
																	<li><h4>Priotering</h4></li>
																	<?php   foreach ($_SESSION['PageDetails'] as $pageDetails) { 
																		
																			if(trim($pageDetails['PageMenuText']) == 'Priotering'){ 
																				$pathPriority = 'page?id=' . $pageDetails['PageTableID'].'&page_text=' .$pageDetails['PageMenuText']; 
																			} else if ( trim($pageDetails['PageMenuText']) == 'Handlägare'){
																				$pathHandlägare = 'page?id=' . $pageDetails['PageTableID'].'&page_text=' .$pageDetails['PageMenuText']; 
																			} else if (trim($pageDetails['PageMenuText']) == 'Grupp'){
																				$pathGrupp = 'page?id=' . $pageDetails['PageTableID'].'&page_text=' .$pageDetails['PageMenuText']; 
																			}
																		} 
																	?>
																	<li><a href="<?php echo $pathPriority.'&columnName=priority&columnValue=1'; ?>"><i class=" fa fa-tags"></i> Låg</a></li>
																	<li><a href="<?php echo $pathPriority.'&columnName=priority&columnValue=2'; ?>"><i class=" fa fa-tags "></i> Medium</a></li>
																	<li><a href="<?php echo $pathPriority.'&columnName=priority&columnValue=3'; ?>"><i class=" fa fa-tags "></i> Hög</a></li>
																	<li><a href="<?php echo $pathPriority.'&columnName=priority&columnValue=4'; ?>"><i class=" fa fa-tags "></i> Bråskande</a></li>
																</ul> -->
											
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
                                                            <div class="card card-topline-gray">
                                                                <div class="card-body no-padding height-9">
                                                                    <div class="row">
                                                                        <div class="col-md-12">
                                                                            <div class="inbox-body">
                                                                                <div class="inbox-body no-pad">
                                                                                    <section class="mail-list">
                                                                                        <div class="mail-sender">
                                                                                            <div class="mail-heading">
                                                                                              <h4 class="vew-mail-header"><b><?php print_r($GetTicketInfo[0][2]);  ?></b></h4>
                                                                                            </div>
                                                                                          <hr>
                                                                                            <div class="media">
                                                                                              <a href="#" class="pull-left"> <img alt="" src="assets/img/user/user2.jpg" class="img-circle" width="40">
                                                                                              </a>
                                                                                                <div class="media-body">
                                                                                                  <span class="date pull-right">för 13 timmar sedan (<?php print_r($GetTicketInfo[0][4]);  ?>)</span>
                                                                                                  <h4 class="text-primary">  <?php print_r($GetTicketInfo[0][0]);  ?>
                                                                                                       rapporterat via <?php print_r($GetTicketInfo[0][1]);  ?></h4>
                                                                                                  <small class="text-muted">To:
                                                                                                  <?php print_r($GetTicketInfo[0][3]);  ?></small>
                                                                                                </div>
                                                                                            </div>
                                                                                        </div>
                                                                                      
                                                                                      <div class="view-mail">
                                                                                          <p>
                                                                                          <?php print_r($GetTicketInfo[0][5]);  ?>
                                                                                          </p>
                                                                                      </div>
                                                                                        <?php foreach ($GetTicketInfo as $keyTick => $valueTick) {
                                                                                             if($valueTick[7] == 1 && $EnablePrivateMsg == '1'){ ?>
                                                                                                    <div class="view-mail" >
                                                                                                    <div style="background-color:#E8F7FF;">
                                                                                                        <p> <?php echo $valueTick[11] ;?> added a private note</p>
                                                                                                        <p> Notified to: <?php echo $valueTick[10] ;?></p>
                                                                                                        <p>
                                                                                                        <?php print_r($valueTick[8]);  ?>
                                                                                                        </p>
                                                                                                    </div>
                                                                                                    </div>
                                                                                            <?php } else if($valueTick[7] == ''){ ?>
                                                                                                    <div class="view-mail">
                                                                                                        <div style="background-color:#FFFFE8;">
                                                                                                            <p> <?php echo $valueTick[11] ;?> replied</p>
                                                                                                            <p> To: <?php echo $valueTick[10] ;?></p>
                                                                                                            <p>
                                                                                                            <?php print_r($valueTick[8]);  ?>
                                                                                                            </p>
                                                                                                        </div>
                                                                                                    </div>
                                                                                            <?php }
                                                                                        }?>

                                                                                   
                                                                                      <!--  <div class="compose-btn pull-left">
                                                                                          <a href="email_compose.html" class="btn btn-sm btn-primary"><i class="fa fa-reply"></i> Reply</a>
                                                                                          <button class="btn btn-sm btn-default">
                                                                                              <i class="fa fa-arrow-right"></i>Forward
                                                                                          </button>   
                                                                                        </div> --> 
                                                                                    </section>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
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

                     