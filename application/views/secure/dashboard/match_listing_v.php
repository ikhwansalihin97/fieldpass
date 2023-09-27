<?php
$this->load->view('secure/m_header');
?>
	
	<!--begin::Entry-->
	<div class="d-flex flex-column-fluid">
		<!--begin::Container-->
		<div class="container">
			<div class="card card-custom  gutter-b">
				<div class="card-header">
					<div class="card-title">
						<?php echo isset($card_title) && $card_title != '' ? $card_title : 'Please Set Card Title';?>
					</div>
					<div class="card-toolbar">
						<?php
						$urlAction = base_url() . $this->uri->segment(1) . '/' . $this->uri->segment(2) .'/'. $this->uri->segment(3);
						?>
						<form action ="<?php echo isset($urlAction) && $urlAction != '' ? $urlAction : '#';?>" method="POST" class="search-form">
								<div class="input-group">
									<input type="text" name="search_name" value="<?php echo isset($search_data["search"]) ? $search_data['search'] : '';?>" class="form-control" placeholder="Search for...">
									<input type="hidden" class="extraFilter" name="extra_filter" value="<?php echo isset($search_data["extra_filter"]) ? $search_data["extra_filter"] : '';?>" />
									<input type="hidden" class="dateFilter" name="date_filter" value="<?php echo isset($search_data["date_filter"]) ? $search_data["date_filter"] : date("m/d/Y");?>" />
									<input type="hidden" class="filterselectValue" name="filter" value="<?php echo isset($search_data["filter"]) ? $search_data["filter"] : '';?>" />
									<input type="hidden" class="filterselectbyValue" name="filterBy" value="<?php echo isset($search_data["filterBy"]) ? $search_data["filterBy"] : '';?>" />
									<input type="hidden" name="sql_sort" value="<?php echo isset($search_data["sql_sort"]) ? $search_data["sql_sort"] : '';?>" />
									<input type="hidden" name="sql_sort_column" value="<?php echo isset($search_data["sql_sort_column"]) ? $search_data["sql_sort_column"] : '';?>" class="sql-sort-column" />
									<input type="hidden" name="download" value="false" />
									<span class="input-group-append">
										<button class="btn btn-secondary" type="submit" style="z-index:0;">
											Go!
										</button>
									</span>
								</div>
						</form>
					</div>
				</div>
				<div class="card-body">
					<?php 
						echo isset($total_rows) ? "<span class='label label-xl label-inline label-pill label-success'> Total Data : " . $total_rows . "</span>" : '';
					?>
					<div class="row justify-content-end mt-5 mb-5">
						<button class="btn btn-outline-secondary btn-wide mr-2 submitfilterForm" type="button" disabled>Filter <i class="flaticon-search"></i></button>
						<a class="btn btn-outline-secondary btn-wide mr-6" href="<?php echo base_url() . "secure/" . $this->uri->segment(2) . '/' . $this->uri->segment(3);?>">Clear Filter <i class="flaticon-interface-1"></i></a>
					</div>
					<?php 
					if(isset($extra_filter))
					{
						echo $extra_filter;
					}
					?>
					<div class="form-group row">
						<?php
						echo isset($date_filter) && $date_filter != '' ? $date_filter : '';
						?>
						<div class="col-md-4">
							<label>Filter By</label>
							<select name="filterSelect" class="form-control filterSelect">
								<option value="" readonly disabled selected>Choose</option>
							<?php
								foreach($filter as $value=>$label){
									$selected = '';
									
									
									if(isset($search_data["filter"]) && $search_data["filter"] == $value)
									{
										$selected = 'selected';
									}
									
									echo '<option value="'.$value.'" '.$selected.'>'.$label.'</option>';
								}
							?>
							</select>
						</div>
					<?php
						if(isset($selectFilter) && is_array($selectFilter) && sizeof($selectFilter) > 0)
						{ 
							foreach($selectFilter as $row=>$val)
							{		
					?>
							<div class="col-md-4 filterBySelect" id="<?php echo $row;?>" style="<?php echo isset($search_data["filter"]) && $search_data["filter"] == $row ? '' : 'display:none';?>">
								<label><?php echo ucwords(str_replace('_',' ',$row));?></label>
								<select class="form-control filterBy">
								<option value="" readonly disabled selected>Choose</option>
								<?php
								foreach($val as $a=>$b)
								{
									if($b != "")
									{
										echo isset($search_data["filterBy"]) &&  $search_data["filterBy"] == $b ? '<option data-select="'.$b.'" value="'.$b.'" selected >'. $b . '</option>' : '<option data-select="'.$b.'" value="'.$b.'" >'. $b . '</option>';
									}
									// echo '<option value="'.$b.'" >'. $b . '</option>';
								}
								?>
								</select>
							</div>
					<?php
							}
						}
					?>
					</div>
					
				</div>
				
			</div>
				
				<?php 
					if(empty($rows)){
						echo '<div class="card card-custom wave wave-animate wave-danger mb-8 mb-lg-0  gutter-b">
								 <div class="card-body">
								  <div class="d-flex align-items-center p-5">
								   <div class="mr-6">
									<span class="svg-icon svg-icon-danger svg-icon-4x">
									<!--begin::Svg Icon | path:C:\wamp64\www\keenthemes\legacy\metronic\theme\html\demo8\dist/../src/media/svg/icons\General\Sad.svg-->
									<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
										<g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
											<rect x="0" y="0" width="24" height="24"/>
											<rect fill="#000000" opacity="0.3" x="2" y="2" width="20" height="20" rx="10"/>
											<path d="M6.16794971,14.5547002 C5.86159725,14.0951715 5.98577112,13.4743022 6.4452998,13.1679497 C6.90482849,12.8615972 7.52569784,12.9857711 7.83205029,13.4452998 C8.9890854,15.1808525 10.3543313,16 12,16 C13.6456687,16 15.0109146,15.1808525 16.1679497,13.4452998 C16.4743022,12.9857711 17.0951715,12.8615972 17.5547002,13.1679497 C18.0142289,13.4743022 18.1384028,14.0951715 17.8320503,14.5547002 C16.3224187,16.8191475 14.3543313,18 12,18 C9.64566871,18 7.67758127,16.8191475 6.16794971,14.5547002 Z" fill="#000000" transform="translate(12.000000, 15.499947) scale(1, -1) translate(-12.000000, -15.499947) "/>
										</g>
									</svg>
									<!--end::Svg Icon-->
									</span>
								   </div>
								   <div class="d-flex flex-column">
									<a href="#" class="text-dark text-hover-primary font-weight-bold font-size-h4 mb-3">
									No Data Available
									</a>
									<div class="text-dark-75">
									There is currently no data available for this list.
									</div>
								   </div>
								  </div>
								 </div>
								</div>';
					}else{
									
						// ad($rows[0]);
						// ad($rows);
						foreach($rows as $header=>$val){
							//ad($val);
					?>		
							<!--begin::Card-->
							<div class="card card-custom gutter-b hide-mobile">
								<div class="card-body">
									<!--begin::Top-->
									<div class="d-flex">
										<!--begin: Info-->
										<div class="flex-grow-1">
											<!--begin::Title-->
											<div class="d-flex align-items-center justify-content-between flex-wrap mt-2">
												<!--begin::User-->
												<div class="col-md-3 col-sm-12 mr-3">
													
													<div class="d-flex justify-content-end flex-wrap">
														
														<?php
														$array_symbol_color =array("primary","success","danger","warning","info","dark");
														?>
                                                                                                                <!--begin::Pic-->
                                                                                                                <div class="flex-shrink-0 mr-7">
                                                                                                                <?php
                                                                                                                if(isset($val['home_image']) && $val['home_image'] != '')
                                                                                                                {
                                                                                                                ?>
                                                                                                                    <div class="symbol symbol-50 symbol-lg-120">
                                                                                                                        <img alt="Pic" src="<?php echo $val['home_image'];?>"/>
                                                                                                                    </div>
                                                                                                                <?php
                                                                                                                }
                                                                                                                else
                                                                                                                {
                                                                                                                ?>
                                                                                                                    <div class="symbol symbol-50 symbol-lg-120 symbol-light-<?php echo $array_symbol_color[array_rand($array_symbol_color)];?>">
                                                                                                                        <span class="font-size-h3 symbol-label font-weight-boldest"><?php echo isset($val['home_team_short']) && $val['home_team_short'] != '' ? $val['home_team_short'] :'';?></span>
                                                                                                                    </div>
                                                                                                                <?php
                                                                                                                }
                                                                                                                ?>
                                                                                                                </div>
														<!--end::Pic-->
													</div>
													<!--begin::Contacts-->
													<div class="justify-content-end d-flex flex-wrap my-2">
														<a href="#" class="d-flex align-items-center text-dark text-hover-primary font-size-h5 font-weight-bold mr-lg-8 mr-5 mb-lg-0 mb-2"><?php echo isset($val['home_team']) && $val['home_team'] != '' ? $val['home_team'] :'';?> <i class="flaticon2-correct text-success icon-md ml-2"></i> </a>
													</div>
													<!--end::Contacts-->
												</div>
												<!--begin::User-->
												<!--begin::User-->
												<div class="col-md-3 col-sm-12">
													<!--begin::Contacts-->
													<div class="justify-content-between d-flex flex-wrap m-5" >
														<a href="#" class="btn btn-icon <?php echo isset($val['home_team_score']) && $val['home_team_score'] != '' && $val['home_team_score'] > $val['away_team_score'] ?  'btn-success' : 'btn-danger';?> ">
															<?php echo isset($val['home_team_score']) && $val['home_team_score'] != '' ? $val['home_team_score'] : '0';?>
														</a>
														<h2>VS</h2>
														<a href="#" class="btn btn-icon <?php echo isset($val['away_team_score']) && $val['away_team_score'] != '' && $val['away_team_score'] > $val['home_team_score'] ?  'btn-success' : 'btn-danger';?>">
															<?php echo isset($val['away_team_score']) && $val['away_team_score'] != '' ? $val['away_team_score'] : '0';?> 
														</a>
													</div>
													<div class="justify-content-center d-flex flex-wrap my-2">
														
														<a href="#" class="text-muted text-hover-primary font-weight-bold mr-lg-8 mr-5 mb-lg-0 mb-2">
														<span class="svg-icon svg-icon-md svg-icon-gray-500 mr-1">
														<!--begin::Svg Icon | path:C:\wamp64\www\keenthemes\legacy\metronic\theme\html\demo1\dist/../src/media/svg/icons\General\Clipboard.svg-->
														<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
															<g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
																<rect x="0" y="0" width="24" height="24"/>
																<path d="M8,3 L8,3.5 C8,4.32842712 8.67157288,5 9.5,5 L14.5,5 C15.3284271,5 16,4.32842712 16,3.5 L16,3 L18,3 C19.1045695,3 20,3.8954305 20,5 L20,21 C20,22.1045695 19.1045695,23 18,23 L6,23 C4.8954305,23 4,22.1045695 4,21 L4,5 C4,3.8954305 4.8954305,3 6,3 L8,3 Z" fill="#000000" opacity="0.3"/>
																<path d="M11,2 C11,1.44771525 11.4477153,1 12,1 C12.5522847,1 13,1.44771525 13,2 L14.5,2 C14.7761424,2 15,2.22385763 15,2.5 L15,3.5 C15,3.77614237 14.7761424,4 14.5,4 L9.5,4 C9.22385763,4 9,3.77614237 9,3.5 L9,2.5 C9,2.22385763 9.22385763,2 9.5,2 L11,2 Z" fill="#000000"/>
																<rect fill="#000000" opacity="0.3" x="7" y="10" width="5" height="2" rx="1"/>
																<rect fill="#000000" opacity="0.3" x="7" y="14" width="9" height="2" rx="1"/>
															</g>
														</svg>
														<!--end::Svg Icon-->
														</span><?php echo isset($val['matchweek']) && $val['matchweek'] != '' ? $val['matchweek'] : '';?></a>
														<a href="#" class="text-muted text-hover-primary font-weight-bold">
														<span class="svg-icon svg-icon-md svg-icon-gray-500 mr-1">
															<!--begin::Svg Icon | path:C:\wamp64\www\keenthemes\legacy\metronic\theme\html\demo1\dist/../src/media/svg/icons\Code\Info-circle.svg-->
															<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
																<g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
																	<rect x="0" y="0" width="24" height="24"/>
																	<circle fill="#000000" opacity="0.3" cx="12" cy="12" r="10"/>
																	<rect fill="#000000" x="11" y="10" width="2" height="7" rx="1"/>
																	<rect fill="#000000" x="11" y="7" width="2" height="2" rx="1"/>
																</g>
															</svg>
															<!--end::Svg Icon-->
														</span><?php echo isset($val['status']) && $val['status'] != '' ? $val['status'] :'';?></a>
														<a href="#" class="text-muted text-hover-primary font-weight-bold mr-lg-8 mr-5 mb-lg-0 mb-2">
														<span class="svg-icon svg-icon-md svg-icon-gray-500 mr-1">
															<!--begin::Svg Icon | path:C:\wamp64\www\keenthemes\legacy\metronic\theme\html\demo1\dist/../src/media/svg/icons\Home\Clock.svg-->
															<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
																<g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
																	<rect x="0" y="0" width="24" height="24"/>
																	<path d="M12,22 C7.02943725,22 3,17.9705627 3,13 C3,8.02943725 7.02943725,4 12,4 C16.9705627,4 21,8.02943725 21,13 C21,17.9705627 16.9705627,22 12,22 Z" fill="#000000" opacity="0.3"/>
																	<path d="M11.9630156,7.5 L12.0475062,7.5 C12.3043819,7.5 12.5194647,7.69464724 12.5450248,7.95024814 L13,12.5 L16.2480695,14.3560397 C16.403857,14.4450611 16.5,14.6107328 16.5,14.7901613 L16.5,15 C16.5,15.2109164 16.3290185,15.3818979 16.1181021,15.3818979 C16.0841582,15.3818979 16.0503659,15.3773725 16.0176181,15.3684413 L11.3986612,14.1087258 C11.1672824,14.0456225 11.0132986,13.8271186 11.0316926,13.5879956 L11.4644883,7.96165175 C11.4845267,7.70115317 11.7017474,7.5 11.9630156,7.5 Z" fill="#000000"/>
																</g>
															</svg>
															<!--end::Svg Icon-->
														</span><?php echo isset($val['date']) && $val['date'] != '' ? $val['date'] :'';?></a>
													</div>
													<!--end::Contacts-->
												</div>
												<!--begin::User-->
												<!--begin::User-->
												<div class="col-md-3 col-sm-12 ml-3" >
													
													<div class="d-flex justify-content-start flex-wrap">
                                                                                                                <!--begin::Pic-->
														<div class="flex-shrink-0 mr-7">
                                                                                                                <?php
                                                                                                                if(isset($val['away_image']) && $val['away_image'] != '')
                                                                                                                {
                                                                                                                ?>
                                                                                                                    <div class="symbol symbol-50 symbol-lg-120">
                                                                                                                        <img alt="Pic" src="<?php echo $val['away_image'];?>"/>
                                                                                                                    </div>
                                                                                                                <?php
                                                                                                                }
                                                                                                                else
                                                                                                                {
                                                                                                                ?>
                                                                                                                    <div class="symbol symbol-50 symbol-lg-120 symbol-light-<?php echo $array_symbol_color[array_rand($array_symbol_color)];?>">
                                                                                                                        <span class="font-size-h3 symbol-label font-weight-boldest"><?php echo isset($val['away_team_short']) && $val['away_team_short'] != '' ? $val['away_team_short'] :'';?></span>
                                                                                                                    </div>
                                                                                                                <?php
                                                                                                                }
                                                                                                                ?>
                                                                                                                </div>
														<!--end::Pic-->
														
													</div>
													<!--begin::Contacts-->
													<div class="d-flex flex-wrap my-2">
														<a href="#" class="d-flex align-items-center text-dark text-hover-primary font-size-h5 font-weight-bold mr-lg-8 mr-5 mb-lg-0 mb-2"><i class="flaticon2-correct text-success icon-md mr-2"></i><?php echo isset($val['away_team']) && $val['away_team'] != '' ?  ' ' . $val['away_team'] :'';?></a>
													</div>
													<!--end::Contacts-->
												</div>
												<!--begin::User-->
											</div>
											<!--end::Title-->
										</div>
										<!--end::Info-->
									</div>
									<!--end::Top-->
									<!--begin::Separator-->
									<div class="separator separator-solid my-7"></div>
									<?php
									/* 
									<!--end::Separator-->
									<!--begin::Bottom-->
									<div class="d-flex align-items-center flex-wrap">
										<!--begin: Item-->
										<div class="d-flex align-items-center flex-lg-fill mr-5 my-1">
											<span class="mr-4">
												<i class="flaticon-piggy-bank icon-2x text-muted font-weight-bold"></i>
											</span>
											<div class="d-flex flex-column text-dark-75">
												<span class="font-weight-bolder font-size-sm">Earnings</span>
												<span class="font-weight-bolder font-size-h5">
												<span class="text-dark-50 font-weight-bold">$</span>249,500</span>
											</div>
										</div>
										<!--end: Item-->
										<!--begin: Item-->
										<div class="d-flex align-items-center flex-lg-fill mr-5 my-1">
											<span class="mr-4">
												<i class="flaticon-confetti icon-2x text-muted font-weight-bold"></i>
											</span>
											<div class="d-flex flex-column text-dark-75">
												<span class="font-weight-bolder font-size-sm">Expenses</span>
												<span class="font-weight-bolder font-size-h5">
												<span class="text-dark-50 font-weight-bold">$</span>164,700</span>
											</div>
										</div>
										<!--end: Item-->
										<!--begin: Item-->
										<div class="d-flex align-items-center flex-lg-fill mr-5 my-1">
											<span class="mr-4">
												<i class="flaticon-pie-chart icon-2x text-muted font-weight-bold"></i>
											</span>
											<div class="d-flex flex-column text-dark-75">
												<span class="font-weight-bolder font-size-sm">Net</span>
												<span class="font-weight-bolder font-size-h5">
												<span class="text-dark-50 font-weight-bold">$</span>782,300</span>
											</div>
										</div>
										<!--end: Item-->
										<!--begin: Item-->
										<div class="d-flex align-items-center flex-lg-fill mr-5 my-1">
											<span class="mr-4">
												<i class="flaticon-file-2 icon-2x text-muted font-weight-bold"></i>
											</span>
											<div class="d-flex flex-column flex-lg-fill">
												<span class="text-dark-75 font-weight-bolder font-size-sm">73 Tasks</span>
												<a href="#" class="text-primary font-weight-bolder">View</a>
											</div>
										</div>
										<!--end: Item-->
										<!--begin: Item-->
										<div class="d-flex align-items-center flex-lg-fill mr-5 my-1">
											<span class="mr-4">
												<i class="flaticon-chat-1 icon-2x text-muted font-weight-bold"></i>
											</span>
											<div class="d-flex flex-column">
												<span class="text-dark-75 font-weight-bolder font-size-sm">648 Comments</span>
												<a href="#" class="text-primary font-weight-bolder">View</a>
											</div>
										</div>
										<!--end: Item-->
										<!--begin: Item-->
										<!--end: Item-->
									</div>
									<!--end::Bottom-->
									 */
									?>
									<div class="d-flex align-items-center flex-lg-fill my-1">
										<?php echo isset($val['action']) && $val['action'] != '' ? $val['action'] :'';?>
									</div>
								</div>
							</div>
							<!--end::Card-->

							<!--begin::Card-->
							<div class="card card-custom gutter-b show-mobile">
								<!--begin::Body-->
								<div class="card-body text-center pt-4">
									<!--begin::User-->
									<div class="mt-7">
										<div class="symbol symbol-lg-75 symbol-circle symbol-primary">
											<span class="font-size-h3 font-weight-boldest"><?php echo isset($val['home_team']) && $val['home_team'] != '' ? $val['home_team'] :'';?></span>
										</div>
									</div>
									<!--end::User-->
									
									<div class="my-2">
										VS
									</div>
									
									<!--begin::User-->
									<div class="mb-4">
										<div class="symbol symbol-lg-75 symbol-circle symbol-primary">
											<span class="font-size-h3 font-weight-boldest"><?php echo isset($val['away_team']) && $val['away_team'] != '' ?  ' ' . $val['away_team'] :'';?></span>
										</div>
									</div>
									<!--end::User-->
									
									<!--begin::Label-->
									<span class="label label-inline label-lg label-light-primary btn-sm font-weight-bold"><?php echo isset($val['status']) && $val['status'] != '' ? $val['status'] :'';?></span>
									<!--end::Label-->
									<!--begin::Info-->
									<div class="mt-2 mb-7">
										<div class="d-flex justify-content-between align-items-center">
											<span class="text-dark-75 font-weight-bolder mr-2">Matchweek:</span>
											<a href="#" class="text-muted text-hover-primary"><?php echo isset($val['matchweek']) && $val['matchweek'] != '' ? $val['matchweek'] : '';?></a>
										</div>
										<div class="d-flex justify-content-between align-items-cente my-1">
											<span class="text-dark-75 font-weight-bolder mr-2">Date:</span>
											<a href="#" class="text-muted text-hover-primary"><?php echo isset($val['date']) && $val['date'] != '' ? $val['date'] :'';?></a>
										</div>
										<div class="d-flex justify-content-between align-items-center">
											<span class="text-dark-75 font-weight-bolder mr-2">Score:</span>
											<span class="text-muted font-weight-bold">
											<?php echo isset($val['home_team_short']) && $val['home_team_short'] != '' ? $val['home_team_short'] :'';?>
											<?php echo isset($val['home_team_score']) && $val['home_team_score'] != '' ? $val['home_team_score'] : '0';?>
											:
											<?php echo isset($val['away_team_score']) && $val['away_team_score'] != '' ? $val['away_team_score'] : '0';?> 
											<?php echo isset($val['away_team_short']) && $val['away_team_short'] != '' ? $val['away_team_short'] :'';?>
											</span>
										</div>
									</div>
									<!--end::Info-->
									<!--begin::Buttons-->
									<div class="mt-9 ">
										<?php echo isset($val['action']) && $val['action'] != '' ? $val['action'] :'';?>
									</div>
									<!--end::Buttons-->
								</div>
								<!--end::Body-->
							</div>
							<!--end::Card-->
						<?php
						}
						
					}
				?>
				
				<!--begin::Pagination-->
				<?php
				if(isset($pagination) && $pagination != '')
				{
				?>
				<div class="card card-custom">
					<div class="card-body py-7">
						<!--begin::Pagination-->
						<div class="d-flex justify-content-end flex-wrap">
							<div class="d-flex align-items-center">
								<?php echo isset($pagination) ? $pagination : ""; ?>
							</div>
						</div>
						<!--end:: Pagination-->
					</div>
				</div>
				<?php
				}
				?>
				<!--end::Pagination-->
		</div>
		<!--end::Container-->
	</div>
	<!--end::Entry-->
	

<?php
$this->load->view('secure/m_footer');
?>
<script type="text/javascript">
$(function() 
{
	//Sorting the table when clicked at the each column
	$(".deleteFixtures").click(function(e){
		e.preventDefault();
		
		var fixture_id = $(this).attr('fixture-id');
		
		Swal.fire({
        title: "Are you sure?",
        text: "You wont be able to revert this!",
        icon: "warning",
        showCancelButton: true,
        confirmButtonText: "Yes, delete it!"
		}).then(function(result) {
			if (result.value) {

				$.ajax({
					url: baseUrl + 'secure/delete_match',
					method: "POST",
					data: {id: fixture_id},
					dataType:'json',
					success: function(response){
						if(response['result'] == 'success')
						{
							Swal.fire({
								title:"Deleted!",
								text:"Fixture match id " + fixture_id + " has been deleted.",
								icon:"success"
							}).then(function() {
								location.reload();
							});
						}
						else
						{
							Swal.fire({
								title:"Error!",
								text:response['message'],
								icon:"warning"
							}).then(function() {
								location.reload();
							});
							
						}
					}
				});
			}
		});
	});
	
	$(".tbl-sorting, .tbl-sorting-asc, .tbl-sorting-desc").click(function() {
		$(".sql-sort-column").val($(this).attr('data-col'));
		$('.search-form').submit();
	});
			
	$(".download-button").click(function() {
		
		$("input[name='download']").val('true');
		$('.search-form').submit();
	});
	
	$(".datepickerFilter").change(function() {
		
		var filterValue = $(this).val();
		$(".dateFilter").val(filterValue);
		$('.search-form').submit();
	});
	
	$(".extraFilter").change(function() {
		
		var filterValue = $(this).val();
		$(".extraFilter").val(filterValue);
		$('.search-form').submit();
	});
	
	$(".filterSelect").change(function() {
			
		var filterValue = $(this).val();
		$(".filterselectbyValue").val('');
		$('.parent-div').css('display','block');
		$('.filterBySelect').css('display','none');
		$("#"+filterValue).css('display','block');
		$("#small"+filterValue).css('display','block');
		$(".filterselectValue").val(filterValue);
		
	});
	
	$(".sortSelect").change(function() {
	
		var sortValue = $(this).val();
		
		$(".sql_sort_column").val('');
		$(".sql_sort_column").val(sortValue);
		$('.search-form').submit();
		
	});
	
	$(".filterBy").change(function() {
		
		
		var filterselectValue = $(this).val();
		
		$('.submitfilterForm').prop('disabled',false);
		$(".filterselectbyValue").val(filterselectValue);
		
	});
	
	$('.submitfilterForm').click(function(){
		
		if($(".filterselectbyValue").val() == "")
		{
			toastr.error("Please select filter value first in order to filter.");
		}
		else
		{
			$('.search-form').submit();
		}
	});
	
});
</script>
<?php
$this->load->view('secure/m_footer_close');
?>
