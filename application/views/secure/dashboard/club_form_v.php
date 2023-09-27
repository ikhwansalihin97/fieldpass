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
