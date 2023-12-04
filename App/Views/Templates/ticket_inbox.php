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

                           

                        </div>
                    </div>
                </div>



              
                <!-- start ticket content -->
	
					<div class="row">
						<div class="col-md-12">
							<div class="card card-topline-gray">
								<div class="card-body no-padding height-9">
									<div class="inbox">
										<div class="row">
											<div class="col-md-3">
												<div class="inbox-sidebar">
													<a href="email_compose.html" data-title="Compose"
														class="btn red compose-btn btn-block">
														<i class="fa fa-edit"></i> Create a Ticket </a>
													<ul class="inbox-nav inbox-divider">
														<li class="active"><a href="email_inbox.html"><i
																	class="fa fa-inbox"></i> Tickets <span
																	class="label mail-counter-style label-danger pull-right">2</span></a>
														</li>
														<li><a href="#"><i class="fa fa-envelope"></i> Öppen</a>
														</li>
														<li><a href="#"><i class="fa fa-briefcase"></i> Väntad</a>
														</li>
														<li><a href="#"><i class="fa fa-briefcase"></i> Löst</a>
														</li>
														<li><a href="#"><i class="fa fa-briefcase"></i> Avslutat</a>
														</li>
														<li><a href="#"><i class="fa fa-star"></i> Brådskande  </a>
														</li>
														<li><a href="#"><i class=" fa fa-external-link"></i> -
																<span
																	class="label mail-counter-style label-info pull-right">30</span></a>
														</li>
														<li><a href="#"><i class=" fa fa-trash-o"></i> -</a>
														</li>
													</ul>
													<ul class="nav nav-pills nav-stacked labels-info inbox-divider">
														<li>
															<h4>Priotering</h4>
														</li>
														
														<li>
															<a href="#">
																<i class=" fa fa-tags"></i> Låg
															</a>
														</li>
														<li>
															<a href="#">
																<i class=" fa fa-tags "></i> Medium
															</a>
														</li>
														<li>
															<a href="#">
																<i class=" fa fa-tags "></i> Hög
															</a>
														</li>
														<li>
															<a href="#">
																<i class=" fa fa-tags "></i> Bråskande
															</a>
														</li>
													</ul>


													<ul class="nav nav-pills nav-stacked labels-info inbox-divider">
														<li>
															<h4>Handlägare</h4>
														</li>
														<li><a href="#"><i class="fa fa-tags"></i> name</a>
														</li>
														<li>
															<a href="#">
																<i class=" fa fa-tags"></i> name
															</a>
														</li>
														<li>
															<a href="#">
																<i class=" fa fa-tags "></i> name
															</a>
														</li>
														<li>
															<a href="#">
																<i class=" fa fa-tags "></i> name
															</a>
														</li>
														<li>
															<a href="#">
																<i class=" fa fa-tags "></i> name
															</a>
														</li>
													</ul>

													<ul class="nav nav-pills nav-stacked labels-info inbox-divider">
														<li>
															<h4>Grupp</h4>
														</li>
														<li><a href="#"><i class="fa fa-tags"></i> E-handel</a>
														</li>
														<li>
															<a href="#">
																<i class=" fa fa-tags"></i> Fraktsystem
															</a>
														</li>
														<li>
															<a href="#">
																<i class=" fa fa-tags "></i> Garpflöden
															</a>
														</li>
														<li>
															<a href="#">
																<i class=" fa fa-tags "></i> Intregrationer/Formsanpasningar
															</a>
														</li>
														<li>
															<a href="#">
																<i class=" fa fa-tags "></i> Övrigt
															</a>
														</li>
														<li>
															<a href="#">
																<i class=" fa fa-tags "></i> Teknik
															</a>
														</li>
													</ul>
													
												</div>
											</div>
											<div class="col-md-9">
												<div class="inbox-body">
													<div class="inbox-header">
														<div class="mail-option no-pad-left">
															<div class="btn-group group-padding">
																<a class="btn mini tooltips" href="#"
																	data-toggle="dropdown" data-placement="top"
																	data-original-title="Refresh"> <i
																		class=" fa fa-refresh fa-lg"></i>
																</a>
																<a class="btn mini tooltips" href="#"
																	data-original-title="Archive"> <i
																		class=" fa fa-archive fa-lg"></i>
																</a>
																<a class="btn mini tooltips" href="#"
																	data-original-title="Trash"> <i
																		class=" fa fa-trash-o fa-lg"></i>
																</a>
															</div>
															<div class="btn-group res-email-btn">
																<a class="btn mini tooltips" href="#"
																	data-original-title="Folders"> <i
																		class=" fa fa-folder fa-lg"></i>
																</a>
																<a class="btn mini tooltips" href="#"
																	data-original-title="Tag"> <i
																		class=" fa fa-tag fa-lg"></i>
																</a>
															</div>
															<div class="btn-group hidden-phone">
																<a class="btn mini blue-bgcolor" href="#"
																	data-toggle="dropdown" aria-expanded="false"> More
																	<i class="fa fa-angle-down downcolor"></i>
																</a>
																<ul class="dropdown-menu">
																	<li><a href="#"><i class="fa fa-pencil"></i> Mark as
																			Read</a>
																	</li>
																	<li><a href="#"><i class="fa fa-ban"></i>
																			Spam</a>
																	</li>
																	<li class="divider"></li>
																	<li><a href="#"><i class="fa fa-trash-o"></i>
																			Delete</a>
																	</li>
																</ul>
															</div>
															<div class="btn-group pull-right btn-prev-next">
																<button class="btn btn-sm btn-primary" type="button">
																	<i class="fa fa-chevron-left"></i>
																</button>
																<button class="btn btn-sm btn-primary" type="button">
																	<i class="fa fa-chevron-right"></i>
																</button>
															</div>
														</div>
													</div>

														<!-- end ticket side content -->

													<!-- start ticket messseg content -->
													<div class="inbox-body no-pad table-responsive">
														<table class="table table-inbox table-hover">
															<tbody>
																<tr class="unread">
																	<td class="inbox-small-cells">
																		<div class="todo-check pull-left">
																			<input type="checkbox" value="None"
																				id="todo-check1">
																			<label for="todo-check1"></label>
																		</div>
																	</td>
																	<td class="inbox-small-cells"><i
																			class="fa fa-star inbox-started"></i>
																	</td>
																	<td>
																		<a href="#" class="avatar">
																			<img src="assets/img/user/user8.jpg" alt="">
																		</a>
																	</td>

																	<td class="view-message  dont-show">Leena Smith</td>
																	<td class="view-message "><a


																			href="email_compose.html">Jatin I found you
																			on LinkedIn.</a></td>

																			<td class="view-message "><a
																				href="email_compose.html">Tillstånd</a></td>

																			

																			<td class="view-message "><a
																				href="email_compose.html">Grupp</a></td>

																	        <td class="view-message "><a
																		        href="email_compose.html">Handläggare</a></td>
														
															                <td class="view-message "><a
																               href="email_compose.html">Prioritet</a></td>
													                        <td class="view-message "><a
														                   href="email_compose.html">Status</a></td>

																		   <td class="view-message dont-show">Status <span
																			class="label mail-label pull-right">Office</span>
																</td>
											                           </td>
																		<td class="view-message  text-right">10:27 AM</td>
																       </tr>

																	</dic>

													<!-- End ticket messseg content -->

															<!-- start ticket messseg content -->
													<div class="inbox-body no-pad table-responsive">
														<table class="table table-inbox table-hover">
															<tbody>
																<tr class="unread">
																	<td class="inbox-small-cells">
																		<div class="todo-check pull-left">
																			<input type="checkbox" value="None"
																				id="todo-check1">
																			<label for="todo-check1"></label>
																		</div>
																	</td>
																	<td class="inbox-small-cells"><i
																			class="fa fa-star inbox-started"></i>
																	</td>
																	<td>
																		<a href="#" class="avatar">
																			<img src="assets/img/user/user8.jpg" alt="">
																		</a>
																	</td>
																	<td class="view-message  dont-show">Leena Smith</td>
																	<td class="view-message "><a
																			href="email_view.html">Jatin I found you
																			on LinkedIn.</a></td>

																			<td class="view-message "><a
																				href="email_view.html">Tillstånd</a></td>

																			

																			<td class="view-message "><a
																				href="email_view.html">Grupp</a></td>

																	        <td class="view-message "><a
																		        href="email_compose.html">Handläggare</a></td>
														
															                <td class="view-message "><a
																               href="email_compose.html">Prioritet</a></td>
													                        <td class="view-message "><a
														                   href="email_compose.html">Status</a></td>

																		   <td class="view-message dont-show">Status <span
																			class="label mail-label pull-right">Office</span>
																</td>
											                           </td>
																		<td class="view-message  text-right">10:27 AM</td>
																       </tr>

																	</dic>

													<!-- End ticket messseg content -->

																
																
																
															</tbody>
														</table>
													</div>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>

									<!-- end ticket content -->
	
				
		
  



                      

                          
                    </div>
                    <!-- end page content -->

                </div>
                <!-- end page container -->
            </div>
        </div>

        <?php include_once realpath(__DIR__) . '/../layout/footer_start.php'; ?>