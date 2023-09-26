<?php
$this->load->view('secure/m_header');
?>
	
	<!--begin::Entry-->
	<div class="d-flex flex-column-fluid">
		<!--begin::Container-->
		<div class="container">
		
			<?php
			if($this->uri->segment(3) == 'player')
			{
				$this->load->view('secure/dashboard/quick_player_form_v');
			}
			?>
			<div class="card card-custom">
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
					<div class="row justify-content-end mb-5">
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
					<!--begin::Section-->
					<div class="kt-section">
						<div class="kt-section__content">
							<div class="table-responsive">
								<table class="table table-bordered table-striped">
									<?php 
										if(empty($rows)){
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
											foreach($rows[0] as $header=>$val){
												$w = '';
												
												if(ISSET($sort) AND array_key_exists($header, $sort) != FALSE)
												{
													$s = isset($search_data["sql_sort"]) && $search_data["sql_sort_column"] == $sort[$header] ? '<i class="fa fa-sort-' . strtolower($search_data["sql_sort"]) .' text-dark"> </i>' : '<i class="fa fa-sort text-dark"> </i>';
												}
												
												if(ISSET($width) AND array_key_exists($header, $width) != FALSE) $w = 'style="width: '.$width[$header].'px"';
												if(ISSET($sort) AND array_key_exists($header, $sort) != FALSE) $header = '<a href="javascript:void(0)" class="tbl-sorting" data-col="'. $sort[$header] . '" style="text-decoration:none;color:#3F4254;"> ' . $header .' <span style="text-decoration:none;margin-left:5px;"> ' . $s .'</span></a>';
												echo '<th '.$w.'>'.$header.'</th>';
											}
											echo '</tr></thead>';
											echo '<tbody>';
											foreach($rows as $row){
												echo '<tr>';
												foreach($row as $key=>$val){
													// dd($key);
													$align = '';
													if(ISSET($align_right) AND array_search($key, $align_right) !== FALSE) $align = 'text-right';
													if(ISSET($align_center) AND array_search($key, $align_center) !== FALSE) $align = 'text-center';

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
						<?php echo isset($pagination) ? $pagination : ""; ?>
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
	
	$('.quickName').on('keyup change input',function(e){
		e.preventDefault();
		var name = $(this).attr("name");
		var id = $(this).attr("id");
		var input_value = $(this).val();
		
		clearTimeout(timeout);
          timeout = setTimeout(function() {
              submitData(name,id,input_value);
          }, delay);
	});
	
	$('.quickValue').on('keyup change input',function(e){
		e.preventDefault();
		var name = $(this).attr("name");
		var id = $(this).attr("id");
		var input_value = $(this).val();
		
		
		clearTimeout(timeout);
          timeout = setTimeout(function() {
			
			if(input_value > 100)
			{
				toastr.error('maximum player value exceed 100');
				return;
			}
				
              submitData(name,id,input_value);
          }, delay);
	});
	
	
	$('.quickTeam').on('change',function(e){
		e.preventDefault();
		var name = $(this).attr("name");
		var id = $(this).attr("id");
		var input_value = $(this).val();
		
		clearTimeout(timeout);
          timeout = setTimeout(function() {
			  submitData(name,id,input_value);
          }, delay);
	});
	
	$('.quickPosition').on('change',function(e){
		e.preventDefault();
		var name = $(this).attr("name");
		var id = $(this).attr("id");
		var input_value = $(this).val();
		
		clearTimeout(timeout);
          timeout = setTimeout(function() {
			  submitData(name,id,input_value);
          }, delay);
	});
	
	function submitData(name,id,input_value) {
        
		$.ajax({
			url: baseUrl + 'secure/player_quick_update',
			method: "POST",
			data: {name: name, id: id, input_value : input_value},
			dataType:'json',
			success: function(response){
				
				if(response['result'] == 'success')
				{
					toastr.success(response['message']);
					setTimeout(function(){
						location.reload();
					}, 2000);
				}
				else
				{
					toastr.error(response['message']);
				}
			}
		});
	}
	
});
</script>
<!--begin::Page Scripts(used by this page)-->
<script src="<?php echo base_url();?>template/metronic/dist/assets/js/pages/crud/file-upload/image-input.js?v=<?php echo time();?>"></script>
<!--end::Page Scripts-->
<script type="text/javascript">
$(function() 
{
	$('#js_form_player').submit(function(event){	
		event.preventDefault();
		// var values = $(this).serialize();
		var formData = new FormData($(this)[0]);
		
		var playerID = $('#id').val();
		
		$(":input").removeClass("is-invalid");
		$("select").removeClass("is-invalid");
		
		$.ajax({
			url: baseUrl + 'secure/player_form',
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
						
						if(playerID != '')
						{
							location.reload();
						}
						else
						{
							location.href = baseUrl + 'secure/listing/player';
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
