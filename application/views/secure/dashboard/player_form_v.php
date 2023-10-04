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
				<form class="form" method="POST" action="<?php echo base_url() .'secure/player_form';?>" id="js_form_player">
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
                                                            <label>Player Name:</label>
                                                            <input type="hidden" class="form-control " id="id" name="id" value="<?php echo isset($form_data['id']) && $form_data['id'] != '' ? $form_data['id'] : '';?>"/>
                                                            <input type="text" class="form-control" placeholder="Enter full name" name="name" value="<?php echo isset($form_data['name']) && $form_data['name'] != '' ? $form_data['name'] : '';?>" />

                                                            <span class="form-text text-muted">Please enter your full name</span>
                                                    </div>
                                                    <div class="col-lg-6">
                                                            <label>Player Position:</label>
                                                            <div class="input-group">
                                                                    <select class="form-control" name="position"  id="position">
                                                                            <option disabled selected >Choose position</option>
                                                                            <option value="GK" <?php echo isset($form_data['position']) && $form_data['position'] == 'GK' ? 'selected' : '';?> >GK</option>
                                                                            <option value="DF" <?php echo isset($form_data['position']) && $form_data['position'] == 'DF' ? 'selected' : '';?> >DF</option>
                                                                            <option value="MF" <?php echo isset($form_data['position']) && $form_data['position'] == 'MF' ? 'selected' : '';?> >MF</option>
                                                                            <option value="ST" <?php echo isset($form_data['position']) && $form_data['position'] == 'ST' ? 'selected' : '';?> >ST</option>
                                                                    </select>
                                                                    <div class="input-group-append"><span class="input-group-text"><i class="fas fa-search-location"></i></span></div>
                                                            </div>
                                                            <span class="form-text text-muted">Please select player position</span>
                                                    </div>
                                            </div>
                                            <div class="form-group row">
                                                    <div class="col-lg-6">
                                                            <label>Value:</label>
                                                            <div class="input-group">
                                                                    <input type="number" class="form-control" placeholder="Enter player value" min="1" max="100" name="value" value="<?php echo isset($form_data['value']) && $form_data['value'] != '' ? $form_data['value'] : '';?>"  />
                                                                    <div class="input-group-append"><span class="input-group-text"><i class="fas fa-money-bill-alt"></i></span></div>
                                                            </div>
                                                            <span class="form-text text-muted">Please enter player value</span>
                                                    </div>
                                                    <div class="col-lg-6">
                                                        <label>Team:</label>
                                                        <div class="input-group">
                                                            <select class="form-control" name="team_id"  id="team_id">
                                                                <option disabled selected >Choose team</option>
                                                                <option value="" > NO CLUB </option>
                                                                <?php
                                                                if(isset($team) && is_array($team) && sizeof($team) > 0)
                                                                {
                                                                    foreach($team as $tkey=>$tvalue)
                                                                        echo isset($form_data['team_id']) && $form_data['team_id'] == $tvalue->id ? '<option value="'.$tvalue->id.'" selected >' . $tvalue->name . '</option>' : '<option value="'.$tvalue->id.'" >' . $tvalue->name . '</option>';
                                                                }
                                                                ?>
                                                            </select>
                                                            <div class="input-group-append"><span class="input-group-text"><i class="fas fa-users"></i></span></div>
                                                        </div>
                                                        <span class="form-text text-muted">Please select player team</span>
                                                    </div>
                                            </div>
                                            <div class="form-group row">
                                                <div class="col-lg-6">
                                                    <label>Jersey Number:</label>
                                                    <div class="input-group">
                                                            <input type="text" class="form-control" placeholder="Enter jersey number" name="jersey_number" value="<?php echo isset($form_data['jersey_number']) && $form_data['jersey_number'] != '' ? $form_data['jersey_number'] : '';?>" />
                                                            <div class="input-group-append"><span class="input-group-text"><i class="fas fa-tshirt"></i></span></div>
                                                    </div>
                                                    <span class="form-text text-muted">Please enter player jersey number</span>
                                                </div>
                                                <div class="col-lg-6">
                                                    <label>Identification Card:</label>
                                                    <div class="input-group">
                                                            <input type="text" class="form-control" placeholder="Enter Identification Card Number" name="identity_number" value="<?php echo isset($form_data['identity_number']) && $form_data['identity_number'] != '' ? $form_data['identity_number'] : '';?>" />
                                                            <div class="input-group-append"><span class="input-group-text"><i class="fas fa-user"></i></span></div>
                                                    </div>
                                                    <span class="form-text text-muted">Please enter player identity number eg: 971109-10-5774</span>
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
                        
                        <?php
                        if(isset($match_history) && is_array($match_history) && sizeof($match_history) > 0){
                            foreach($match_history as $row_match_history)
                            {
                                
                                $match_url = $row_match_history['fixture']->id != '' ? base_url() . 'secure/update_match/' . encrypt_data($row_match_history['fixture']->id) : '#';
                                $home_name = $row_match_history['home']->name . ' (' . $row_match_history['fixture']->home_team_score . ')';
                                $away_name = '(' . $row_match_history['fixture']->away_team_score . ') ' . $row_match_history['away']->name;
                                $season = $row_match_history['season']->name != '' ? $row_match_history['season']->name : date('Y');
                                $match_week = $row_match_history['fixture']->matchweek != '' ? $row_match_history['fixture']->matchweek : 'Not Specified';
                                $score = $row_match_history['action']['score'] != '' ? $row_match_history['action']['score'] : '0';
                                $assist = $row_match_history['action']['assist'] != '' ? $row_match_history['action']['assist'] : '0';
                                $yellow = $row_match_history['action']['yellow'] != '' ? $row_match_history['action']['yellow'] : 'None';
                                $red = $row_match_history['action']['red'] != '' ? $row_match_history['action']['score'] : 'None';
                                $minutes = $row_match_history['action']['minutes'] != '' ? $row_match_history['action']['minutes'] : '0';
                                //ad($row_match_history);
                        ?>
                            <!--begin::Card-->
                            <div class="card card-custom gutter-b ">
                                    <div class="card-body">
                                            <!--begin::Top-->
                                            <div class="d-flex">

                                                    <!--begin: Info-->
                                                    <div class="flex-grow-1">
                                                            <!--begin::Title-->
                                                            <div class="d-flex align-items-center justify-content-between flex-wrap mt-2">
                                                                    <!--begin::User-->
                                                                    <div class="mr-3">
                                                                            <!--begin::Name-->
                                                                            <a href="<?php echo isset($match_url) && $match_url != '' ? $match_url : '#';?>" class="d-flex align-items-center text-dark text-hover-primary font-size-h5 font-weight-bold mr-3" target="_blank">
                                                                                <?php echo isset($home_name) && $home_name != '' ? $home_name : '';?>
                                                                                VS 
                                                                                <?php echo isset($away_name) && $away_name != '' ? $away_name : '';?> 
                                                                                <i class="flaticon2-correct text-success icon-md ml-2"></i>
                                                                            </a>
                                                                            <!--end::Name-->
                                                                            <!--begin::Contacts-->
                                                                            <div class="d-flex flex-wrap my-2">
                                                                                    <a href="<?php echo isset($match_url) && $match_url != '' ? $match_url : '#';?>" target="_blank" class="text-muted text-hover-primary font-weight-bold mr-lg-8 mr-5 mb-lg-0 mb-2">
                                                                                    <span class="svg-icon svg-icon-md svg-icon-gray-500 mr-1">
                                                                                            <!--begin::Svg Icon | path:C:\wamp64\www\keenthemes\legacy\metronic\theme\html\demo1\dist/../src/media/svg/icons\Code\Puzzle.svg-->
                                                                                            <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                                                                                <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                                                                                    <rect x="0" y="0" width="24" height="24"/>
                                                                                                    <path d="M19,11 L20,11 C21.6568542,11 23,12.3431458 23,14 C23,15.6568542 21.6568542,17 20,17 L19,17 L19,20 C19,21.1045695 18.1045695,22 17,22 L5,22 C3.8954305,22 3,21.1045695 3,20 L3,17 L5,17 C6.65685425,17 8,15.6568542 8,14 C8,12.3431458 6.65685425,11 5,11 L3,11 L3,8 C3,6.8954305 3.8954305,6 5,6 L8,6 L8,5 C8,3.34314575 9.34314575,2 11,2 C12.6568542,2 14,3.34314575 14,5 L14,6 L17,6 C18.1045695,6 19,6.8954305 19,8 L19,11 Z" fill="#000000" opacity="0.3"/>
                                                                                                </g>
                                                                                            </svg>
                                                                                            <!--end::Svg Icon-->
                                                                                    </span>Season <?php echo isset($season) && $season != '' ? $season : date('Y');?></a>
                                                                                    <a href="<?php echo isset($match_url) && $match_url != '' ? $match_url : '#';?>" target="_blank" class="text-muted text-hover-primary font-weight-bold mr-lg-8 mr-5 mb-lg-0 mb-2">
                                                                                    <span class="svg-icon svg-icon-md svg-icon-gray-500 mr-1">
                                                                                            <!--begin::Svg Icon | path:C:\wamp64\www\keenthemes\legacy\metronic\theme\html\demo1\dist/../src/media/svg/icons\Code\Git1.svg-->
                                                                                            <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                                                                                <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                                                                                    <rect x="0" y="0" width="24" height="24"/>
                                                                                                    <rect fill="#000000" opacity="0.3" x="11" y="8" width="2" height="9" rx="1"/>
                                                                                                    <path d="M12,21 C13.1045695,21 14,20.1045695 14,19 C14,17.8954305 13.1045695,17 12,17 C10.8954305,17 10,17.8954305 10,19 C10,20.1045695 10.8954305,21 12,21 Z M12,23 C9.790861,23 8,21.209139 8,19 C8,16.790861 9.790861,15 12,15 C14.209139,15 16,16.790861 16,19 C16,21.209139 14.209139,23 12,23 Z" fill="#000000" fill-rule="nonzero"/>
                                                                                                    <path d="M12,7 C13.1045695,7 14,6.1045695 14,5 C14,3.8954305 13.1045695,3 12,3 C10.8954305,3 10,3.8954305 10,5 C10,6.1045695 10.8954305,7 12,7 Z M12,9 C9.790861,9 8,7.209139 8,5 C8,2.790861 9.790861,1 12,1 C14.209139,1 16,2.790861 16,5 C16,7.209139 14.209139,9 12,9 Z" fill="#000000" fill-rule="nonzero"/>
                                                                                                </g>
                                                                                            </svg>
                                                                                            <!--end::Svg Icon-->
                                                                                    </span>Matchweek <?php echo isset($match_week) && $match_week != '' ? $match_week : '';?></a>

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
                                            <!--end::Separator-->
                                            <!--begin::Bottom-->
                                            <div class="d-flex align-items-center flex-wrap">
                                                    <!--begin: Item-->
                                                    <div class="d-flex align-items-center flex-lg-fill mr-5 my-1">
                                                            <span class="mr-4">
                                                                    <i class="flaticon-confetti icon-2x text-success font-weight-bold"></i>
                                                            </span>
                                                            <div class="d-flex flex-column text-dark-75">
                                                                    <span class="font-weight-bolder font-size-sm">Score</span>
                                                                    <span class=" font-weight-bold font-size-h5"><?php echo isset($score) && $score != '' ? $score : '0';?></span>
                                                            </div>
                                                    </div>
                                                    <!--end: Item-->
                                                     <!--begin: Item-->
                                                    <div class="d-flex align-items-center flex-lg-fill mr-5 my-1">
                                                            <span class="mr-4">
                                                                    <i class="flaticon-customer icon-2x text-info font-weight-bold"></i>
                                                            </span>
                                                            <div class="d-flex flex-column text-dark-75">
                                                                    <span class="font-weight-bolder font-size-sm">Assist</span>
                                                                    <span class="font-weight-bold font-size-h5"><?php echo isset($assist) && $assist != '' ? $assist : '0';?></span>
                                                            </div>
                                                    </div>
                                                    <!--end: Item-->
                                                    <!--begin: Item-->
                                                    <div class="d-flex align-items-center flex-lg-fill mr-5 my-1">
                                                            <span class="mr-4">
                                                                    <i class="flaticon-stopwatch icon-2x text-primary font-weight-bold"></i>
                                                            </span>
                                                            <div class="d-flex flex-column text-dark-75">
                                                                    <span class="font-weight-bolder font-size-sm">Minutes Played</span>
                                                                    <span class="font-size-h5 font-weight-bold"><?php echo isset($minutes) && is_int($minutes) ? $minutes . ' min' : $minutes;?></span>
                                                            </div>
                                                    </div>
                                                    <!--end: Item-->
                                                   <!--begin: Item-->
                                                    <div class="d-flex align-items-center flex-lg-fill mr-5 my-1">
                                                            <span class="mr-4">
                                                                    <i class="flaticon-edit-1 icon-2x text-danger font-weight-bold"></i>
                                                            </span>
                                                             <div class="d-flex flex-column text-dark-75">
                                                                    <span class="font-weight-bolder font-size-sm">Red</span>
                                                                    <span class="font-weight-bold font-size-h5"><?php echo isset($red) && $red != '' ? $red : '0';?></span>
                                                            </div>
                                                    </div>
                                                    <!--end: Item-->
                                                   <!--begin: Item-->
                                                    <div class="d-flex align-items-center flex-lg-fill mr-5 my-1">
                                                            <span class="mr-4">
                                                                    <i class="flaticon-file-2 icon-2x text-warning font-weight-bold"></i>
                                                            </span>
                                                             <div class="d-flex flex-column text-dark-75">
                                                                    <span class="font-weight-bolder font-size-sm">Yellow</span>
                                                                    <span class="font-weight-bold font-size-h5"><?php echo isset($yellow) && $yellow != '' ? $yellow : '0';?></span>
                                                            </div>
                                                    </div>
                                                    <!--end: Item-->
                                                    <!--begin: Item-->
                                                    <!--
                                                    <div class="d-flex align-items-center flex-lg-fill mr-5 my-1">
                                                            <span class="mr-4">
                                                                    <i class="flaticon-information icon-2x text-secondary font-weight-bold"></i>
                                                            </span>
                                                             <div class="d-flex flex-column text-dark-75">
                                                                    <span class="font-weight-bolder font-size-sm">Result</span>
                                                                    <span class="font-weight-bold font-size-h5">Win</span>
                                                            </div>
                                                    </div>
                                                    -->
                                                    <!--end: Item-->
                                            </div>
                                            <!--end::Bottom-->
                                    </div>
                            </div>
                            <!--end::Card-->
                        
                        <?php
                            }
                        }
                        ?>
                        
                        
                        
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
