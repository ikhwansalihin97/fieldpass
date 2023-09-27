<!--begin::Card-->
<div class="card card-custom gutter-b example example-compact">
	<div class="card-header">
		<h3 class="card-title">
			<span class="card-icon"><i class="fas fa-user"></i></span> Player Form
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
                    <div class="row">
                        <div class="col-lg-6">
                                <button type="reset" class="btn btn-secondary">Cancel</button>
                        </div>
                        <div class="col-lg-6 text-lg-right">
                                <button type="submit" class="btn btn-primary mr-2"><?php echo isset($form_data['id']) && $form_data['id'] != '' ? 'Update' : 'Submit';?></button>
                        </div>
                    </div>
		</div>
	</form>
	<!--end::Form-->
</div>
<!--end::Card-->