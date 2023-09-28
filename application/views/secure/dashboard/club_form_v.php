<?php
$this->load->view('secure/m_header');
?>
	
	<!--begin::Entry-->
	<div class="d-flex flex-column-fluid">
		<!--begin::Container-->
		<div class="container">
			<!--begin::Card-->
			<div class="card card-custom gutter-b example example-compact">
				<div class="card-header">
					<h3 class="card-title">
						<?php echo isset($card_title) && $card_title != '' ? $card_title : 'Please Set Card Title';?>
					</h3>
					<div class="card-toolbar">
						<div class="example-tools justify-content-center">
							
						</div>
					</div>
				</div>
				<!--begin::Form-->
				<form class="form" method="POST" action="<?php echo base_url() .'secure/club_form';?>" id="js_form_player">
					<div class="card-body">
                                                <div class="form-group row">
                                                    <div class="col-lg-12 col-xl-12">
                                                        <?php
                                                        $default_image = base_url() . 'template/metronic/dist/assets/media/users/blank.png';
                                                        if(isset($form_data['image_url']) && $form_data['image_url'] != '' )
                                                            $image_url = base_url() . $form_data['image_url'];
                                                        else
                                                            $image_url = base_url() . 'template/metronic/dist/assets/media/users/blank.png';
                                                        ?>
                                                        <div class="image-input image-input-empty image-input-outline" id="kt_image_5" style="background-image: url(<?php echo isset($image_url) && $image_url != '' ? $image_url : $default_image;?>)">
                                                            <div class="image-input-wrapper"></div>
                                                            <label class="btn btn-xs btn-icon btn-circle btn-white btn-hover-text-primary btn-shadow" data-action="change" data-toggle="tooltip" title="" data-original-title="Change avatar">
                                                                <i class="fa fa-pen icon-sm text-muted"></i>
                                                                <input type="file" name="profile_avatar" accept=".png, .jpg, .jpeg" />
                                                                <input type="hidden" name="profile_avatar_remove" />
                                                            </label>
                                                            <span class="btn btn-xs btn-icon btn-circle btn-white btn-hover-text-primary btn-shadow" data-action="cancel" data-toggle="tooltip" title="Cancel avatar">
                                                                <i class="ki ki-bold-close icon-xs text-muted"></i>
                                                            </span>
                                                            <span class="btn btn-xs btn-icon btn-circle btn-white btn-hover-text-primary btn-shadow" data-action="remove" data-toggle="tooltip" title="Remove avatar">
                                                                <i class="ki ki-bold-close icon-xs text-muted"></i>
                                                            </span>
                                                        </div>
                                                        <span class="form-text text-muted"></span>
                                                    </div>
                                                </div>
						<div class="form-group row">
							<div class="col-lg-6">
								<label>Club Name:</label>
								<input type="hidden" class="form-control " id="id" name="id" value="<?php echo isset($form_data['id']) && $form_data['id'] != '' ? $form_data['id'] : '';?>"/>
								<input type="text" class="form-control" placeholder="Enter club name" name="name" value="<?php echo isset($form_data['name']) && $form_data['name'] != '' ? $form_data['name'] : '';?>" />
								
								<span class="form-text text-muted">Please enter club name</span>
							</div>
							<div class="col-lg-6">
								<label>Manager:</label>
								<div class="input-group">
									<input type="text" class="form-control" placeholder="Enter club manager name" name="manager" value="<?php echo isset($form_data['manager']) && $form_data['manager'] != '' ? $form_data['manager'] : '';?>" />
									<div class="input-group-append"><span class="input-group-text"><i class="fas fa-user-tie"></i></span></div>
								</div>
								<span class="form-text text-muted">Please enter club manager</span>
							</div>
						</div>
						<div class="form-group row">
							<div class="col-lg-6">
								<label>Short Name:</label>
								<div class="input-group">
									<input type="text" class="form-control" placeholder="Enter club short name" name="short_name" value="<?php echo isset($form_data['short_name']) && $form_data['short_name'] != '' ? $form_data['short_name'] : '';?>" />
									<div class="input-group-append"><span class="input-group-text"><i class="fas fa-hashtag"></i></span></div>
								</div>
								<span class="form-text text-muted">Please club shot name</span>
							</div>
						</div>
						<div class="form-group row">
							<label class="col-3 col-form-label">Season:</label>
							<div class="col-12 col-form-label">
								<div class="checkbox-inline">
									<?php
									if(isset($team_season))
										$season_id = array_column($team_season, 'season_id');
									
									if(isset($season) && is_array($season) && sizeof($season) > 0)
										foreach($season as $key_season=>$value_season)
											echo isset($season_id) && in_array($value_season->id, $season_id)  ? '<label class="checkbox"><input type="checkbox" name="season[]" value="'.$value_season->id.'" checked="checked" /><span></span>' . $value_season->name .'</label>' : '<label class="checkbox"><input type="checkbox" name="season[]" value="'.$value_season->id.'" /><span></span>' . $value_season->name .'</label>';
									
									?>
									
								</div>
								<span class="form-text text-muted">Checkboxes for season</span>
							</div>
						</div>
					</div>
					<div class="card-footer">
						<div class="d-flex justify-content-between">
							<div class="mr-2">
								<button type="reset" class="btn btn-secondary">Cancel</button>
							</div>
							<div class="text-lg-right">
								<button type="submit" class="btn btn-primary mr-2"><?php echo isset($form_data['id']) && $form_data['id'] != '' ? 'Update' : 'Submit';?></button>
							</div>
						</div>
					</div>
				</form>
				<!--end::Form-->
			</div>
			<!--end::Card-->
                        
                        <div class="card card-custom">
				<div class="card-header">
					<div class="card-title">
                                            <?php echo isset($form_data['name']) && $form_data['name'] != '' ? ucwords(strtolower($form_data['name'])) . ' Players' : '';?>
					</div>
					<div class="card-toolbar">
						<?php
						$urlAction = base_url() . $this->uri->segment(1) . '/' . $this->uri->segment(2) .'/'. $this->uri->segment(3) . '/'. $this->uri->segment(4);
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
						echo isset($player_list['total_rows']) ? "<span class='label label-xl label-inline label-pill label-success'> Total Data : " . $player_list['total_rows'] . "</span>" : '';
					?>
					<div class="row justify-content-end mb-5">
						<button class="btn btn-outline-secondary btn-wide mr-2 submitfilterForm" type="button" disabled>Filter <i class="flaticon-search"></i></button>
						<a class="btn btn-outline-secondary btn-wide mr-6" href="<?php echo base_url() . "secure/" . $this->uri->segment(2) . '/' . $this->uri->segment(3);?>">Clear Filter <i class="flaticon-interface-1"></i></a>
					</div>
					<?php 
					if(isset($player_list['extra_filter']))
					{
						echo $player_list['extra_filter'];
					}
					?>
					<div class="form-group row">
						<?php
						echo isset($player_list['date_filter']) && $player_list['date_filter'] != '' ? $player_list['date_filter'] : '';
						?>
						<div class="col-md-4">
							<label>Filter By</label>
							<select name="filterSelect" class="form-control filterSelect">
								<option value="" readonly disabled selected>Choose</option>
							<?php
								foreach($player_list['filter'] as $value=>$label){
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
						if(isset($player_list['selectFilter']) && is_array($player_list['selectFilter']) && sizeof($player_list['selectFilter']) > 0)
						{ 
							foreach($player_list['selectFilter'] as $row=>$val)
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
					<!--begin::Section-->
					<div class="kt-section">
						<div class="kt-section__content">
							<div class="table-responsive">
								<table class="table table-bordered table-striped">
									<?php 
										if(empty($player_list['rows'])){
											echo '<div class="card card-custom wave wave-animate wave-danger mb-8 mb-lg-0">
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
														
											echo '<thead><tr>';
											foreach($player_list['rows'][0] as $header=>$val){
												$w = '';
												
												if(ISSET($player_list['sort']) AND array_key_exists($header, $player_list['sort']) != FALSE)
												{
													$s = isset($search_data["sql_sort"]) && $search_data["sql_sort_column"] == $player_list['sort'][$header] ? '<i class="fa fa-sort-' . strtolower($search_data["sql_sort"]) .' text-dark"> </i>' : '<i class="fa fa-sort text-dark"> </i>';
												}
												
												if(ISSET($player_list['width']) AND array_key_exists($header, $player_list['width']) != FALSE) $w = 'style="width: '.$player_list['width'][$header].'px"';
												if(ISSET($player_list['sort']) AND array_key_exists($header, $player_list['sort']) != FALSE) $header = '<a href="javascript:void(0)" class="tbl-sorting" data-col="'. $player_list['sort'][$header] . '" style="text-decoration:none;color:#3F4254;"> ' . $header .' <span style="text-decoration:none;margin-left:5px;"> ' . $s .'</span></a>';
												echo '<th '.$w.'>'.$header.'</th>';
											}
											echo '</tr></thead>';
											echo '<tbody>';
											foreach($player_list['rows'] as $row){
												echo '<tr>';
												foreach($row as $key=>$val){
													// dd($key);
													$align = '';
													if(ISSET($player_list['align_right']) AND array_search($key, $player_list['align_right']) !== FALSE) $align = 'text-right';
													if(ISSET($player_list['align_center']) AND array_search($key, $player_list['align_center']) !== FALSE) $align = 'text-center';

													echo '<td class="'.$align.'">'.$val.'</td>';
												}
												echo '</tr>';
											}
											echo '</tbody>';

										}
									?>
								</table>
							</div>
						</div>
					</div>
					<!--end::Section-->
				</div>
				<div class="card-footer d-flex justify-content-end">
                                        <?php echo isset($player_list['pagination']) ? $player_list['pagination'] : ""; ?>
                                        <!--
                                        <a href="#" class="btn btn-light-primary font-weight-bold">Manage</a>
                                        <a href="#" class="btn btn-outline-secondary font-weight-bold">Learn more</a>
                                        -->
				</div>
			</div>
		</div>
		<!--end::Container-->
	</div>
	<!--end::Entry-->

		
	


<?php
$this->load->view('secure/m_footer');
?>
<!--begin::Page Scripts(used by this page)-->
<script src="<?php echo base_url();?>template/metronic/dist/assets/js/pages/crud/file-upload/image-input.js?v=<?php echo time();?>"></script>
<!--end::Page Scripts-->

<script type="text/javascript">
$(function() 
{
	var timeout;
	var delay = 2000; 
	//Sorting the table when clicked at the each column
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

<script type="text/javascript">
$(function() 
{
	$('#js_form_player').submit(function(event){	
		event.preventDefault();
		// var values = $(this).serialize();
		var formData = new FormData($(this)[0]);
		
		var clubID = $('#id').val();
		
		$(":input").removeClass("is-invalid");
		$("select").removeClass("is-invalid");
		
		$.ajax({
			url: baseUrl + 'secure/club_form',
			method: "POST",
			data: formData,
			dataType:'json',
			async: false,
			cache: false,
			contentType: false,
			enctype: 'multipart/form-data',
			processData: false,
			success: function(response){
				if(response['result'] == 'success')
				{
					toastr.success(response['message']);
					setTimeout(function(){
						
						if(clubID != '')
						{
							location.reload();
						}
						else
						{
							location.href = baseUrl + 'secure/listing/team';
						}
						
					}, 2000);
				}
				else
				{
					toastr.error(response['message']);
					if(response['type'] == 'input')
						$("input[name='"+response['input']+"']").addClass("is-invalid");
					else
						$("#"+response['input']).addClass("is-invalid");
					
				}
			}
		});
	});
	
});
</script>
<?php
$this->load->view('secure/m_footer_close');
?>
