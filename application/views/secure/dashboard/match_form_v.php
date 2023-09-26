<?php
$this->load->view('secure/m_header');
?>
	
	<!--begin::Entry-->
	<div class="d-flex flex-column-fluid">
		<!--begin::Container-->
		<div class="container">
			<!--begin::Card-->
			<div class="card card-custom gutter-b example example-compact">
				<div class="card-header" style="border-bottom:0px;">
					<h3 class="card-title">
						<?php echo isset($card_title) && $card_title != '' ? $card_title : 'Please Set Card Title';?>
						<?php
						echo isset($home_team_info->name) && $home_team_info->name != '' ? ' For ' . $home_team_info->name . ' VS ' :'';
						echo isset($away_team_info->name) && $away_team_info->name != '' ? $away_team_info->name . ' ' :'';
						echo isset($form_data['date']) && $form_data['date'] != '' ? '(' . date("d-m-Y",strtotime($form_data['date'])) . ')' : '';
						?>
					</h3>
				</div>
				<div class="card-header">
					<div class="card-toolbar">
						<ul class="nav nav-light-primary nav-bold nav-pills">
							<li class="nav-item">
								<a class="nav-link active" data-toggle="tab" href="#general_info">
									<span class="nav-icon"><i class="fas fa-tools"></i></span>
									<span class="nav-text">General Information</span>
								</a>
							</li>
							<?php
							if(isset($form_data['id']) && $form_data['id'] != '')
							{
							?>
							<li class="nav-item">
								<a class="nav-link" data-toggle="tab" href="#lineup">
									<span class="nav-icon"><i class="fas fa-users"></i></span>
									<span class="nav-text">Lineup</span>
								</a>
							</li>
							<?php
							if(isset($form_data['status']) && in_array($form_data['status'],array('ongoing','finished','history')))
							{
							?>
							<li class="nav-item">
								<a class="nav-link" data-toggle="tab" href="#subs">
									<span class="nav-icon"><i class="fas fa-users-cog"></i></span>
									<span class="nav-text">Substitution</span>
								</a>
							</li>
							<li class="nav-item">
								<a class="nav-link" data-toggle="tab" href="#action">
									<span class="nav-icon"><i class="fas fa-broadcast-tower"></i></span>
									<span class="nav-text">Action</span>
								</a>
							</li>
							<li class="nav-item">
								<a class="nav-link" data-toggle="tab" href="#history">
									<span class="nav-icon"><i class="fas fa-stopwatch"></i></span>
									<span class="nav-text">Match Timeline</span>
								</a>
							</li>
							<?php
							}
							}
							?>
						</ul>
					</div>
				</div>
				<!--begin::Form-->
				<form class="form" method="POST" action="<?php echo base_url() .'secure/match_form';?>" id="js_form_match">
					<div class="card-body">
						<div class="tab-content">
							<div class="tab-pane fade show active" id="general_info" role="tabpanel" aria-labelledby="general_info">
								<div class="form-group row">
									<div class="col-lg-6">
										<label>Matchweek:</label>
										<input type="hidden" class="form-control " id="id" name="id" value="<?php echo isset($form_data['id']) && $form_data['id'] != '' ? $form_data['id'] : '';?>"/>
										<input type="text" class="form-control" placeholder="Enter matchweek" name="matchweek" value="<?php echo isset($form_data['matchweek']) && $form_data['matchweek'] != '' ? $form_data['matchweek'] : '';?>" />
										
										<span class="form-text text-muted">Please enter your full name</span>
									</div>
									<div class="col-lg-6">
										<label>Date:</label>
										<div class="input-group">
											<input type="text" class="form-control" name="date" value="<?php echo isset($form_data['date']) && $form_data['date'] != '' ? date("m/d/Y",strtotime($form_data['date'])) : '';?>" id="kt_datepicker_1" readonly="readonly" placeholder="Select date" />
											<div class="input-group-append"><span class="input-group-text"><i class="fas fa-calendar-alt"></i></span></div>
										</div>
										<span class="form-text text-muted">Please select match date</span>
									</div>
								</div>
								<div class="form-group row">
									<div class="col-lg-6">
										<label>Home Team:</label>
										<div class="input-group">
											<select class="form-control hometeamSelect" name="home_team_id"  id="home_team_id">
												<option disabled selected >Choose team</option>
													<?php
														if(isset($team) && is_array($team) && sizeof($team) > 0)
														{
															foreach($team as $tkey=>$tvalue)
																echo isset($form_data['home_team_id']) && $form_data['home_team_id'] == $tvalue->id ? '<option value="'.$tvalue->id.'" selected>' . $tvalue->name . '</option>' : '<option value="'.$tvalue->id.'" ' .  $disabled_team_change .' >' . $tvalue->name . '</option>';
														}
													?>
											</select>
											<div class="input-group-append"><span class="input-group-text"><i class="fas fa-users"></i></span></div>
										</div>
										<span class="form-text text-muted">Please select home team</span>
									</div>
									<div class="col-lg-6">
										<label>Away Team:</label>
										<div class="input-group">
											<select class="form-control awayteamSelect" name="away_team_id"  id="away_team_id">
												<option name="disabled" disabled selected >Choose team</option>
													<?php
														if(isset($team) && is_array($team) && sizeof($team) > 0)
														{
															foreach($team as $tkey=>$tvalue)
																echo isset($form_data['away_team_id']) && $form_data['away_team_id'] == $tvalue->id ? '<option value="'.$tvalue->id.'" selected >' . $tvalue->name . '</option>' : '<option value="'.$tvalue->id.'" ' .  $disabled_team_change .' >' . $tvalue->name . '</option>';
														}
													?>
											</select>
											<div class="input-group-append"><span class="input-group-text"><i class="fas fa-users"></i></span></div>
										</div>
										<span class="form-text text-muted">Please select away team</span>
									</div>
								</div>
								<div class="form-group row">
									<div class="col-lg-6">
										<label>Home Score:</label>
										<div class="input-group">
											<input type="text" class="form-control" placeholder="Enter home team score" name="home_team_score" value="<?php echo isset($form_data['home_team_score']) && $form_data['home_team_score'] != '' ? $form_data['home_team_score'] : '';?>" />
											<div class="input-group-append"><span class="input-group-text"><i class="fas fa-futbol"></i></span></div>
										</div>
										<span class="form-text text-muted">Please enter home score</span>
									</div>
									<div class="col-lg-6">
										<label>Away Score:</label>
										<div class="input-group">
											<input type="text" class="form-control" placeholder="Enter away team score" name="away_team_score" value="<?php echo isset($form_data['away_team_score']) && $form_data['away_team_score'] != '' ? $form_data['away_team_score'] : '';?>" />
											<div class="input-group-append"><span class="input-group-text"><i class="fas fa-futbol"></i></span></div>
										</div>
										<span class="form-text text-muted">Please enter away score</span>
									</div>
								</div>
								<div class="form-group row">
									<div class="col-lg-6">
										<label>Home Penalty:</label>
										<div class="input-group">
											<input type="text" class="form-control" placeholder="Enter home team penalty" name="home_team_penalty" value="<?php echo isset($form_data['home_team_penalty']) && $form_data['home_team_penalty'] != '' ? $form_data['home_team_penalty'] : '';?>" />
											<div class="input-group-append"><span class="input-group-text"><i class="fas fa-praying-hands"></i></span></div>
										</div>
										<span class="form-text text-muted">Please enter home team penalty</span>
									</div>
									<div class="col-lg-6">
										<label>Away Penalty:</label>
										<div class="input-group">
											<input type="text" class="form-control" placeholder="Enter away team penalty" name="away_team_penalty" value="<?php echo isset($form_data['home_team_penalty']) && $form_data['home_team_penalty'] != '' ? $form_data['home_team_penalty'] : '';?>" />
											<div class="input-group-append"><span class="input-group-text"><i class="fas fa-praying-hands"></i></span></div>
										</div>
										<span class="form-text text-muted">Please enter away team penalty</span>
									</div>
								</div>
								<div class="form-group row">
									<div class="col-lg-6">
										<label>Match Status:</label>
										<div class="input-group">
											<select class="form-control matchStatus" name="status"  id="status">
												<option disabled selected >Choose status</option>
												<option value="history" <?php echo isset($form_data['status']) && $form_data['status'] == 'history' ? 'selected' : '';?> >History</option>
												<option value="future" <?php echo isset($form_data['status']) && $form_data['status'] == 'future' ? 'selected' : '';?> >Future</option>
												<option value="ongoing" <?php echo isset($form_data['status']) && $form_data['status'] == 'ongoing' ? 'selected' : '';?> >On going</option>
												<option value="current_matchweek" <?php echo isset($form_data['status']) && $form_data['status'] == 'current_matchweek' ? 'selected' : '';?> >Current Matchweek</option>
												<option value="postpone" <?php echo isset($form_data['status']) && $form_data['status'] == 'postpone' ? 'selected' : '';?> >Postpone</option>
												<option value="today" <?php echo isset($form_data['status']) && $form_data['status'] == 'today' ? 'selected' : '';?> >Today</option>
												<option value="post" <?php echo isset($form_data['status']) && $form_data['status'] == 'post' ? 'selected' : '';?> >Post</option>
											</select>
											<div class="input-group-append"><span class="input-group-text"><i class="fas fa-toggle-on"></i></span></div>
										</div>
										<span class="form-text text-muted">Please select match status</span>
									</div>
								</div>
								<div class="form-group row">
									<label class="col-3 col-form-label">Season:</label>
									<div class="col-12 col-form-label">
										<div class="radio-inline">
											<?php
											if(isset($season) && is_array($season) && sizeof($season) > 0)
												foreach($season as $key_season=>$value_season)
													echo isset($form_data['season_id']) && $value_season->id == $form_data['season_id']  ? '<label class="radio"><input type="radio" name="season_id" value="'.$value_season->id.'" checked="checked" /><span></span>' . $value_season->name .'</label>' : '<label class="radio"><input type="radio" name="season_id" value="'.$value_season->id.'" /><span></span>' . $value_season->name .'</label>';
											?>
										</div>
										<span class="form-text text-muted">Checkboxes for season</span>
									</div>
								</div>
							</div>
							<div class="tab-pane fade" id="history" role="tabpanel" aria-labelledby="history">
								<?php
									$time_array = array();
									if(isset($action_history))
									{
										foreach($action_history as $row_history)
										{
											$decode_action = json_decode($row_history->action);
											foreach($decode_action as $row_action)
											{
												$action = array(
												'action_name'=>isset($row_action->name) ? $row_action->name :'',
												'action_type'=>isset($row_action->type) ? $row_action->type :'',
												'action_time'=>isset($row_action->time) ? $row_action->time :'',
												'action_message'=>isset($row_action->message) ? $row_action->message :'',
												'action_player_id'=>isset($row_action->player_id) ? $row_action->player_id :'',
												'id'=>isset($row_history->id) ? $row_history->id :'',
												);
												
												$time_array[$row_action->time][] = array_merge((array)$row_history,$action);
											}
											
											
										}
									}
									
									ksort($time_array);
								?>
								<!--begin::Timeline-->
								<div class="timeline timeline-6 mt-3">
								<?php
								// ad($player_involved);
								$home_subs_out = array();
								$home_mobile_subs_out = array();
								$away_subs_out = array();
								$away_mobile_subs_out = array();
								foreach($time_array as $timeline)
								{
									array_multisort(array_column($timeline, "action_name"), SORT_ASC, $timeline);
									// text-warning = yellow
									// text-success = green
									// text-danger = red
									// text-primary = blue
									// text-info = purple
									
									//font-weight-mormal font-size-lg timeline-content text-muted pl-3 = gray
									//font-weight-bolder text-dark-75 pl-3 font-size-lg = normal
									
									//<a href="#" class="text-primary">#XF-2356</a>
									$assist_text= array('Great','Promising','Brilliant','Timely');
									$goal_text= array('amazing','accurate','world class','incredible','bullet');
									foreach($timeline as $row_timeline)
									{
										$assist = array_rand($assist_text);
										$goal = array_rand($goal_text);
										// ad($row_timeline);
										if(in_array($row_timeline['action_name'],array('assist','score','pen_saved')))
											$color = 'text-success';
										else if($row_timeline['action_name'] == 'suboff')
											$color = 'text-primary';
										else if(in_array($row_timeline['action_name'],array('yellow','owngoal')))
											$color = 'text-warning';
										else if(in_array($row_timeline['action_name'],array('red','pen_missed')))
											$color = 'text-danger';
										
										if($row_timeline['action_name'] == 'suboff')
											$text_class = 'font-weight-mormal font-size-lg timeline-content text-dark pl-3';
										else
											$text_class = 'font-weight-bolder text-dark-75 pl-3 font-size-lg';
								?>
									<!--begin::Item-->
									<div class="timeline-item align-items-start">
										<!--begin::Label-->
										<div class="timeline-label font-weight-bolder text-dark-75 font-size-lg"><?php echo isset($row_timeline['action_time']) && $row_timeline['action_time'] != '' ? $row_timeline['action_time'] . ':00' :'';?></div>
										<!--end::Label-->
										<!--begin::Badge-->
										<div class="timeline-badge">
											<i class="fa fa-genderless <?php echo isset($color) && $color != '' ? $color :'';?> icon-xl"></i>
										</div>
										<!--end::Badge-->
										<!--begin::Text-->
										<div class="<?php echo isset($text_class) && $text_class != '' ? $text_class :'';?>">
										<?php
										if(isset($player_involved[$row_timeline['player_id']]))
										{
											if($row_timeline['action_name'] == 'assist')
												echo isset($player_involved[$row_timeline['player_id']]->jersey_number) && $player_involved[$row_timeline['player_id']]->jersey_number != 0 ?  $assist_text[$assist] . ' assist from <a href="'.base_url().'secure/update_player/'.encrypt_data($row_timeline['player_id']).'" target="_blank">' . $player_involved[$row_timeline['player_id']]->name . ' ('. $player_involved[$row_timeline['player_id']]->jersey_number .') </a>' : $assist_text[$assist] . ' assist from <a href="'.base_url().'secure/update_player/'.encrypt_data($row_timeline['player_id']).'" target="_blank">' . $player_involved[$row_timeline['player_id']]->name . '</a>';
											else if($row_timeline['action_name'] == 'score')
												echo isset($player_involved[$row_timeline['player_id']]->jersey_number) && $player_involved[$row_timeline['player_id']]->jersey_number != 0 ? 'BALL IN THE NET!!! <a href="'.base_url().'secure/update_player/'.encrypt_data($row_timeline['player_id']).'" target="_blank">' . $player_involved[$row_timeline['player_id']]->name . ' ('. $player_involved[$row_timeline['player_id']]->jersey_number .') </a> with ' . $goal_text[$goal] . ' ' . $row_timeline['action_type'] : 'BALL IN THE NET!!! <a href="'.base_url().'secure/update_player/'.encrypt_data($row_timeline['player_id']).'" target="_blank">' . $player_involved[$row_timeline['player_id']]->name . '</a> with ' . $goal_text[$goal] . ' ' . $row_timeline['action_type'];
											else if($row_timeline['action_name'] == 'suboff')
											{
												echo isset($player_involved[$row_timeline['player_id']]->jersey_number) && $player_involved[$row_timeline['player_id']]->jersey_number != 0 ? '<a href="'.base_url().'secure/update_player/'.encrypt_data($row_timeline['player_id']).'" target="_blank">' . $player_involved[$row_timeline['player_id']]->name . ' ('. $player_involved[$row_timeline['player_id']]->jersey_number .') </a> is being substitute with ' : '<a href="'.base_url().'secure/update_player/'.encrypt_data($row_timeline['player_id']).'" target="_blank">' . $player_involved[$row_timeline['player_id']]->name . '</a> is being substitute with ';
												echo isset($player_involved[$row_timeline['action_player_id']]->jersey_number) && $player_involved[$row_timeline['action_player_id']]->jersey_number != 0 ? '<a href="'.base_url().'secure/update_player/'.encrypt_data($row_timeline['action_player_id']).'" target="_blank">' . $player_involved[$row_timeline['action_player_id']]->name . ' ('. $player_involved[$row_timeline['action_player_id']]->jersey_number .') </a>' : '<a href="'.base_url().'secure/update_player/'.encrypt_data($row_timeline['action_player_id']).'" target="_blank">' . $player_involved[$row_timeline['action_player_id']]->name . '</a>';
											}
											else if($row_timeline['action_name'] == 'yellow')
												echo isset($player_involved[$row_timeline['player_id']]->jersey_number) && $player_involved[$row_timeline['player_id']]->jersey_number != 0 ? '<a href="'.base_url().'secure/update_player/'.encrypt_data($row_timeline['player_id']).'" target="_blank">' . $player_involved[$row_timeline['player_id']]->name . ' ('. $player_involved[$row_timeline['player_id']]->jersey_number .') </a> goes into referees book with yellow card shown' : '<a href="'.base_url().'secure/update_player/'.encrypt_data($row_timeline['player_id']).'" target="_blank">' . $player_involved[$row_timeline['player_id']]->name . '</a> goes into referees book with yellow card shown';
											else if($row_timeline['action_name'] == 'red')
												echo isset($player_involved[$row_timeline['player_id']]->jersey_number) && $player_involved[$row_timeline['player_id']]->jersey_number != 0 ?  '<a href="'.base_url().'secure/update_player/'.encrypt_data($row_timeline['player_id']).'" target="_blank">' . $player_involved[$row_timeline['player_id']]->name . ' ('. $player_involved[$row_timeline['player_id']]->jersey_number .') </a> is off from the game red card shown' : '<a href="'.base_url().'secure/update_player/'.encrypt_data($row_timeline['player_id']).'" target="_blank">' . $player_involved[$row_timeline['player_id']]->name . '</a> is off from the game red card shown';
											else if($row_timeline['action_name'] == 'owngoal')
												echo isset($player_involved[$row_timeline['player_id']]->jersey_number) && $player_involved[$row_timeline['player_id']]->jersey_number != 0 ?  'GOAALLLLL! <a href="'.base_url().'secure/update_player/'.encrypt_data($row_timeline['player_id']).'" target="_blank">' . $player_involved[$row_timeline['player_id']]->name . ' ('. $player_involved[$row_timeline['player_id']]->jersey_number .') </a> PUTS IT INTO HIS OWN NET!' : 'GOAALLLLL! <a href="'.base_url().'secure/update_player/'.encrypt_data($row_timeline['player_id']).'" target="_blank">' . $player_involved[$row_timeline['player_id']]->name . '</a> PUTS IT INTO HIS OWN NET!';
											else if($row_timeline['action_name'] == 'pen_missed')
												echo isset($player_involved[$row_timeline['player_id']]->jersey_number) && $player_involved[$row_timeline['player_id']]->jersey_number != 0 ?  'WHAT A SHAME! <a href="'.base_url().'secure/update_player/'.encrypt_data($row_timeline['player_id']).'" target="_blank">' . $player_involved[$row_timeline['player_id']]->name . ' ('. $player_involved[$row_timeline['player_id']]->jersey_number .') </a> miss to score the penalty for his team' : 'WHAT A SHAME! <a href="'.base_url().'secure/update_player/'.encrypt_data($row_timeline['player_id']).'" target="_blank">' . $player_involved[$row_timeline['player_id']]->name . '</a> miss to score the penalty for his team';
											else if($row_timeline['action_name'] == 'pen_saved')
												echo isset($player_involved[$row_timeline['player_id']]->jersey_number) && $player_involved[$row_timeline['player_id']]->jersey_number != 0 ?  'GOOD SAVE! <a href="'.base_url().'secure/update_player/'.encrypt_data($row_timeline['player_id']).'" target="_blank">' . $player_involved[$row_timeline['player_id']]->name . ' ('. $player_involved[$row_timeline['player_id']]->jersey_number .') </a> is not allowing the ball to pass through!' : 'GOOD SAVE! <a href="'.base_url().'secure/update_player/'.encrypt_data($row_timeline['player_id']).'" target="_blank">' . $player_involved[$row_timeline['player_id']]->name . '</a> is not allowing the ball to pass through!';
										
											if($row_timeline['action_name'] == 'suboff')
											{
												// ad($row_timeline);
												// ad($row_timeline['action_player_id']);
												if($player_involved[$row_timeline['action_player_id']]->team_id == $form_data['home_team_id'])
												{
													$home_subs_out[$row_timeline['action_player_id']] = $player_involved[$row_timeline['action_player_id']];
													$home_mobile_subs_out[$row_timeline['action_player_id']] = $player_involved[$row_timeline['action_player_id']];
												}
												
												if($player_involved[$row_timeline['action_player_id']]->team_id == $form_data['away_team_id'])
												{
													$away_subs_out[$row_timeline['action_player_id']] = $player_involved[$row_timeline['action_player_id']];
													$away_mobile_subs_out[$row_timeline['action_player_id']] = $player_involved[$row_timeline['action_player_id']];
												}
											}
											
											echo '<a href="javascript:void();" id="'. $row_timeline['id'] .'" action-name="'.$row_timeline['action_name'].'" class="btn btn-clean btn-hover-light-danger btn-sm btn-icon ml-3 deleteAction" data-container="body" data-toggle="tooltip" data-placement="top" title="Delete this" ><i class="fas fa-times"></i></a>';
										}
										?>
										</div>
										<!--end::Text-->
									</div>
									<!--end::Item-->
								<?php
									}
								}
								?>
								</div>
								<!--end::Timeline-->
							</div>
							<div class="tab-pane fade" id="lineup" role="tabpanel" aria-labelledby="lineup">
								<!--begin::Form-->
								
								<?php
								$home_selected = array();
								$home_mobile_selected = array();
								$away_selected = array();
								$away_mobile_selected = array();
									
								echo '<h3 class="text-dark font-weight-bold mb-10">First Team Lineup:</h3>';
								for($i = 0; $i <=10; $i++)
								{
								?>
								<div class="hide-mobile">
									<div class="form-group row">
										<div class="col-lg-6">
											<?php echo isset($i) && $i == 0 ? '<label>Home Player :</label>' : '';?>
											<select class='form-control homePlayer' <?php echo isset($form_data['status']) && in_array($form_data['status'],array('ongoing','history')) ? 'disabled="disabled"' : '';?> name="player[]" >
												<option disabled selected >Choose player</option>
													<?php
													if(isset($home_player) && is_array($home_player) && sizeof($home_player) > 0)
													{
														$bool = false;
														foreach($home_player as $tkey=>$tvalue)
														{
															$first_team_player_id = array_column($first_team,'player_id');
															
															if(in_array($tvalue->id,$first_team_player_id))
															{
																
																if(!in_array($tvalue->id,$home_selected))
																{
																	
																	if($bool == false)
																	{
																		$home_selected[] = $tvalue->id;
																		
																		$selected = 'selected';
																		$bool = true;
																	}
																	else
																	{
																		$selected = '';
																	}

																	echo isset($tvalue->jersey_number) && $tvalue->jersey_number != 0 ? '<option value="'. $tvalue->id .'" '. $selected .' >' . $tvalue->name . ' (' . $tvalue->jersey_number . ') ' . $tvalue->position . '</option>' : '<option value="'. $tvalue->id .'" '. $selected .' >' . $tvalue->name . ' ' . $tvalue->position  .'</option>';
																	$home_subs_out[$tvalue->id] = $tvalue;
																}
															}
															else
															{
																echo isset($tvalue->jersey_number) && $tvalue->jersey_number != 0 ? '<option value="'.$tvalue->id.'">' . $tvalue->name . ' (' . $tvalue->jersey_number . ')' . $tvalue->position .'</option>' : '<option value="'.$tvalue->id.'">' . $tvalue->name . ' ' . $tvalue->position .'</option>';
															}
														
														}
													}
													?>
											</select>
										</div>
										<div class="col-lg-6">
											<?php echo isset($i) && $i == 0 ? '<label>Away Player :</label>' : '';?>
											<select class="form-control away_player" <?php echo isset($form_data['status']) && in_array($form_data['status'],array('ongoing','history')) ? 'disabled="disabled"' : '';?> name="player[]"  >
												<option disabled selected >Choose player</option>
												<?php
												if(isset($away_player) && is_array($away_player) && sizeof($away_player) > 0)
												{
													$bool = false;
													foreach($away_player as $tkey=>$tvalue)
													{
														$first_team_player_id = array_column($first_team,'player_id');
														
														if(in_array($tvalue->id,$first_team_player_id))
														{
															
															if(!in_array($tvalue->id,$away_selected))
															{
																if($bool == false)
																{
																	$away_selected[] = $tvalue->id;
																	
																	$selected = 'selected';
																	$bool = true;
																}
																else
																{
																	$selected = '';
																}

																echo isset($tvalue->jersey_number) && $tvalue->jersey_number != 0 ? '<option value="'.$tvalue->id.'" '. $selected .' >' . $tvalue->name . ' (' . $tvalue->jersey_number . ') ' . $tvalue->position  .'</option>' : '<option value="'.$tvalue->id.'" '. $selected .' >' . $tvalue->name . ' ' . $tvalue->position  .'</option>';
																$away_subs_out[$tvalue->id] = $tvalue;
															}
														}
														else
														{	
															
															echo isset($tvalue->jersey_number) && $tvalue->jersey_number != 0 ? '<option value="'.$tvalue->id.'">' . $tvalue->name . ' (' . $tvalue->jersey_number . ') ' . $tvalue->position .'</option>' : '<option value="'.$tvalue->id.'">' . $tvalue->name . ' ' . $tvalue->position .'</option>';
														}
													}
												}
												?>
											</select>	
										</div>
									</div>
								</div>
								<?php
								}
								
								echo	'<div class="show-mobile">';
								
								for($i = 0; $i <=10; $i++)
								{
								?>
									<div class="form-group row">
										<div class="col-lg-6">
											<?php echo isset($i) && $i == 0 ? '<label>Home Player :</label>' : '';?>
											<select class='form-control homePlayer' <?php echo isset($form_data['status']) && in_array($form_data['status'],array('ongoing','history')) ? 'disabled="disabled"' : '';?> name="player[]" >
												<option disabled selected >Choose player</option>
													<?php
													if(isset($home_player) && is_array($home_player) && sizeof($home_player) > 0)
													{
														$bool = false;
														foreach($home_player as $tkey=>$tvalue)
														{
															$first_team_player_id = array_column($first_team,'player_id');
															
															if(in_array($tvalue->id,$first_team_player_id))
															{
																
																if(!in_array($tvalue->id,$home_mobile_selected))
																{
																	
																	if($bool == false)
																	{
																		$home_mobile_selected[] = $tvalue->id;
																		
																		$selected = 'selected';
																		$bool = true;
																	}
																	else
																	{
																		$selected = '';
																	}

																	echo isset($tvalue->jersey_number) && $tvalue->jersey_number != 0 ? '<option value="'. $tvalue->id .'" '. $selected .' >' . $tvalue->name . ' (' . $tvalue->jersey_number . ') ' . $tvalue->position . '</option>' : '<option value="'. $tvalue->id .'" '. $selected .' >' . $tvalue->name . ' ' . $tvalue->position  .'</option>';
																	$home_mobile_subs_out[$tvalue->id] = $tvalue;
																}
															}
															else
															{
																echo isset($tvalue->jersey_number) && $tvalue->jersey_number != 0 ? '<option value="'.$tvalue->id.'">' . $tvalue->name . ' (' . $tvalue->jersey_number . ')' . $tvalue->position .'</option>' : '<option value="'.$tvalue->id.'">' . $tvalue->name . ' ' . $tvalue->position .'</option>';
															}
														
														}
													}
													?>
											</select>
										</div>
									</div>
								<?php
								}
								
								for($i = 0; $i <=10; $i++)
								{
								?>
								<div class="form-group row">
									<div class="col-lg-6">
										<?php echo isset($i) && $i == 0 ? '<label>Away Player :</label>' : '';?>
										<select class="form-control away_player" <?php echo isset($form_data['status']) && in_array($form_data['status'],array('ongoing','history')) ? 'disabled="disabled"' : '';?> name="player[]"  >
											<option disabled selected >Choose player</option>
											<?php
											if(isset($away_player) && is_array($away_player) && sizeof($away_player) > 0)
											{
												$bool = false;
												foreach($away_player as $tkey=>$tvalue)
												{
													$first_team_player_id = array_column($first_team,'player_id');
													
													if(in_array($tvalue->id,$first_team_player_id))
													{
														
														if(!in_array($tvalue->id,$away_mobile_selected))
														{
															if($bool == false)
															{
																$away_mobile_selected[] = $tvalue->id;
																
																$selected = 'selected';
																$bool = true;
															}
															else
															{
																$selected = '';
															}

															echo isset($tvalue->jersey_number) && $tvalue->jersey_number != 0 ? '<option value="'.$tvalue->id.'" '. $selected .' >' . $tvalue->name . ' (' . $tvalue->jersey_number . ') ' . $tvalue->position  .'</option>' : '<option value="'.$tvalue->id.'" '. $selected .' >' . $tvalue->name . ' ' . $tvalue->position  .'</option>';
															$away_mobile_subs_out[$tvalue->id] = $tvalue;
														}
													}
													else
													{	
														
														echo isset($tvalue->jersey_number) && $tvalue->jersey_number != 0 ? '<option value="'.$tvalue->id.'">' . $tvalue->name . ' (' . $tvalue->jersey_number . ') ' . $tvalue->position .'</option>' : '<option value="'.$tvalue->id.'">' . $tvalue->name . ' ' . $tvalue->position .'</option>';
													}
												}
											}
											?>
										</select>	
									</div>
								</div>
								
								<?php
								}
								
								echo '</div>';
								
								if(isset($form_data['status']) && in_array($form_data['status'], array('ongoing','history')))
								{
									echo '<div class="separator separator-dashed my-10"></div>';
									echo '<h3 class="text-dark font-weight-bold mb-10">Change First Team Lineup Player:</h3>';
								?>
								<div class="hide-mobile">
									<div class="form-group row">
										<div class="col-lg-6">
											<label>Home Player Out</label>
											<select class="form-control" name="home_lineup_change_out">
												<option disabled selected >Choose player</option>
												<?php
													$new_home_sub = $home_subs_out;
													$new_away_sub = $away_subs_out;
													if(isset($home_subs_out) && is_array($home_subs_out) && sizeof($home_subs_out) > 0)
													{
														array_multisort(array_column($new_home_sub, "position"), SORT_ASC, $new_home_sub);
														foreach($new_home_sub as $tkey=>$tvalue)
														{
															echo isset($tvalue->jersey_number) && $tvalue->jersey_number != 0 ? '<option value="'.$tvalue->id.'" >' . $tvalue->name . ' ('. $tvalue->jersey_number .') ' . $tvalue->position  .'</option>' : '<option value="'.$tvalue->id.'" >' . $tvalue->name . ' ' . $tvalue->position  .'</option>';
														}
													}	
												?>
											</select>
										</div>
										<div class="col-lg-6">
											<label>Away Player Out</label>
											<select class="form-control" name="away_lineup_change_out">
												<option disabled selected >Choose player</option>
												<?php
												if(isset($away_subs_out) && is_array($away_subs_out) && sizeof($away_subs_out) > 0)
													{
														array_multisort(array_column($new_away_sub, "position"), SORT_ASC, $new_away_sub);
														foreach($new_away_sub as $tkey=>$tvalue)
														{
															echo isset($tvalue->jersey_number) && $tvalue->jersey_number != 0 ? '<option value="'.$tvalue->id.'" >' . $tvalue->name . ' ('. $tvalue->jersey_number .') ' . $tvalue->position  .'</option>' : '<option value="'.$tvalue->id.'" >' . $tvalue->name . ' ' . $tvalue->position  .'</option>';
														}
													}	
												?>
											</select>
										</div>
									</div>
									<div class="form-group row">
										<div class="col-lg-6">
											<label>Home Player In</label>
											<select class="form-control" name="home_lineup_change_in">
												<option disabled selected >Choose player</option>
												<?php
												if(isset($available_home_subs) && is_array($available_home_subs) && sizeof($available_home_subs) > 0)
												{
													foreach($available_home_subs as $tkey=>$tvalue)
													{
														echo isset($tvalue->jersey_number) && $tvalue->jersey_number != 0 ? '<option value="'.$tvalue->id.'" >' . $tvalue->name . ' ('. $tvalue->jersey_number .') ' . $tvalue->position  .'</option>' : '<option value="'.$tvalue->id.'" >' . $tvalue->name . ' ' . $tvalue->position  .'</option>';
													}
												}													
												?>
											</select>
										</div>
										<div class="col-lg-6">
											<label>Away Player In</label>
											<select class="form-control" name="away_lineup_change_in">
												<option disabled selected >Choose player</option>
												<?php
												if(isset($available_away_subs) && is_array($available_away_subs) && sizeof($available_away_subs) > 0)
												{
													foreach($available_away_subs as $tkey=>$tvalue)
													{
														echo isset($tvalue->jersey_number) && $tvalue->jersey_number != 0 ? '<option value="'.$tvalue->id.'" >' . $tvalue->name . ' ('. $tvalue->jersey_number .') ' . $tvalue->position  .'</option>' : '<option value="'.$tvalue->id.'" >' . $tvalue->name . ' ' . $tvalue->position  .'</option>';
													}
												}													
												?>
											</select>
										</div>
									</div>
								</div>
								
								<div class="show-mobile">
									<div class="form-group row">
										<div class="col-lg-6">
											<label>Home Player Out</label>
											<select class="form-control" name="home_lineup_change_out">
												<option disabled selected >Choose player</option>
												<?php
													$new_home_sub = $home_mobile_subs_out;
													$new_away_sub = $away_mobile_subs_out;
													if(isset($home_subs_out) && is_array($home_subs_out) && sizeof($home_subs_out) > 0)
													{
														array_multisort(array_column($new_home_sub, "position"), SORT_ASC, $new_home_sub);
														foreach($new_home_sub as $tkey=>$tvalue)
														{
															echo isset($tvalue->jersey_number) && $tvalue->jersey_number != 0 ? '<option value="'.$tvalue->id.'" >' . $tvalue->name . ' ('. $tvalue->jersey_number .') ' . $tvalue->position  .'</option>' : '<option value="'.$tvalue->id.'" >' . $tvalue->name . ' ' . $tvalue->position  .'</option>';
														}
													}	
												?>
											</select>
										</div>
										<div class="col-lg-6">
											<label>Home Player In</label>
											<select class="form-control" name="home_lineup_change_in">
												<option disabled selected >Choose player</option>
												<?php
												if(isset($available_home_subs) && is_array($available_home_subs) && sizeof($available_home_subs) > 0)
												{
													foreach($available_home_subs as $tkey=>$tvalue)
													{
														echo isset($tvalue->jersey_number) && $tvalue->jersey_number != 0 ? '<option value="'.$tvalue->id.'" >' . $tvalue->name . ' ('. $tvalue->jersey_number .') ' . $tvalue->position  .'</option>' : '<option value="'.$tvalue->id.'" >' . $tvalue->name . ' ' . $tvalue->position  .'</option>';
													}
												}													
												?>
											</select>
										</div>
									</div>
									<div class="form-group row">
										<div class="col-lg-6">
											<label>Away Player Out</label>
											<select class="form-control" name="away_lineup_change_out">
												<option disabled selected >Choose player</option>
												<?php
												if(isset($away_subs_out) && is_array($away_subs_out) && sizeof($away_subs_out) > 0)
													{
														array_multisort(array_column($new_away_sub, "position"), SORT_ASC, $new_away_sub);
														foreach($new_away_sub as $tkey=>$tvalue)
														{
															echo isset($tvalue->jersey_number) && $tvalue->jersey_number != 0 ? '<option value="'.$tvalue->id.'" >' . $tvalue->name . ' ('. $tvalue->jersey_number .') ' . $tvalue->position  .'</option>' : '<option value="'.$tvalue->id.'" >' . $tvalue->name . ' ' . $tvalue->position  .'</option>';
														}
													}	
												?>
											</select>
										</div>
										<div class="col-lg-6">
											<label>Away Player In</label>
											<select class="form-control" name="away_lineup_change_in">
												<option disabled selected >Choose player</option>
												<?php
												if(isset($available_away_subs) && is_array($available_away_subs) && sizeof($available_away_subs) > 0)
												{
													foreach($available_away_subs as $tkey=>$tvalue)
													{
														echo isset($tvalue->jersey_number) && $tvalue->jersey_number != 0 ? '<option value="'.$tvalue->id.'" >' . $tvalue->name . ' ('. $tvalue->jersey_number .') ' . $tvalue->position  .'</option>' : '<option value="'.$tvalue->id.'" >' . $tvalue->name . ' ' . $tvalue->position  .'</option>';
													}
												}													
												?>
											</select>
										</div>
									</div>
								</div>
								<?php
								}
								?>
								<!--end::Form-->
							</div>
							<div class="tab-pane fade" id="subs" role="tabpanel" aria-labelledby="subs">
								<?php
								foreach($time_array as $timeline)
								{
									array_multisort(array_column($timeline, "action_name"), SORT_ASC, $timeline);
									
									foreach($timeline as $row_timeline)
									{
										if($row_timeline['action_name'] == 'suboff')
										{
											if($player_involved[$row_timeline['player_id']]->team_id == $form_data['home_team_id'])
												unset($home_subs_out[$row_timeline['player_id']]);
											
											if($player_involved[$row_timeline['player_id']]->team_id == $form_data['away_team_id'])
												unset($away_subs_out[$row_timeline['player_id']]);
										}
									}
								}
								?>
									<div class="form-group row">
										<div class="col-lg-6">
											<label>Home Player Out:</label>
											<select class="form-control home_player_sub" name="home_sub_out">
												<option disabled selected >Choose player</option>
												<?php
												if(isset($home_subs_out) && is_array($home_subs_out) && sizeof($home_subs_out) > 0)
												{
													array_multisort(array_column($home_subs_out, "position"), SORT_ASC, $home_subs_out);
													
													foreach($home_subs_out as $tkey=>$tvalue)
													{
														echo isset($tvalue->jersey_number) && $tvalue->jersey_number != 0 ? '<option value="'.$tvalue->id.'" >' . $tvalue->name . ' ('. $tvalue->jersey_number .') ' . $tvalue->position  .'</option>' : '<option value="'.$tvalue->id.'" >' . $tvalue->name . ' ' . $tvalue->position  .'</option>';
													}
												}													
												?>
											</select>
										</div>
										<div class="col-lg-6">
											<label>Home Player In:</label>
											<select class="form-control home_player_sub" name="home_sub_in">
												<option disabled selected >Choose player</option>
												<?php
												if(isset($available_home_subs) && is_array($available_home_subs) && sizeof($available_home_subs) > 0)
												{
													foreach($available_home_subs as $tkey=>$tvalue)
													{
														echo isset($tvalue->jersey_number) && $tvalue->jersey_number != 0 ? '<option value="'.$tvalue->id.'" >' . $tvalue->name . ' ('. $tvalue->jersey_number .') ' . $tvalue->position  .'</option>' : '<option value="'.$tvalue->id.'" >' . $tvalue->name . ' ' . $tvalue->position  .'</option>';
													}
												}													
												?>
											</select>
										</div>
									</div>
									<div class="form-group row">
										<div class="col-lg-6">
											<label>Away Player Out:</label>
											<select class="form-control away_player_sub" name="away_sub_out"  >
												<option disabled selected >Choose player</option>
												<?php
												if(isset($away_subs_out) && is_array($away_subs_out) && sizeof($away_subs_out) > 0)
												{
													array_multisort(array_column($away_subs_out, "position"), SORT_ASC, $away_subs_out);
													
													foreach($away_subs_out as $tkey=>$tvalue)
													{
														echo isset($tvalue->jersey_number) && $tvalue->jersey_number != 0 ? '<option value="'.$tvalue->id.'" >' . $tvalue->name . ' ('. $tvalue->jersey_number .') ' . $tvalue->position  .'</option>' : '<option value="'.$tvalue->id.'" >' . $tvalue->name . ' ' . $tvalue->position  .'</option>';
													}
												}													
												?>
											</select>
										</div>
										<div class="col-lg-6">
											<label>Away Player In:</label>
											<select class="form-control away_player_sub" name="away_sub_in"  >
												<option disabled selected >Choose player</option>
												<?php
												if(isset($available_away_subs) && is_array($available_away_subs) && sizeof($available_away_subs) > 0)
												{
													foreach($available_away_subs as $tkey=>$tvalue)
													{
														echo isset($tvalue->jersey_number) && $tvalue->jersey_number != 0 ? '<option value="'.$tvalue->id.'" >' . $tvalue->name . ' ('. $tvalue->jersey_number .') ' . $tvalue->position  .'</option>' : '<option value="'.$tvalue->id.'" >' . $tvalue->name . ' ' . $tvalue->position  .'</option>';
													}
												}													
												?>
											</select>
										</div>
									</div>
									<?php
									// ad(array_key_last($time_array));
									?>
									<div class="form-group row">
										<div class="col-lg-6">
											<label>Minutes:</label>
											<input type="number" class="form-control" value="<?php echo array_key_last($time_array) != '' ? array_key_last($time_array)+1 : '01';?>" name="sub_time" <?php echo isset($form_data['id']) && $form_data['id'] != '' ? '' : 'disabled';?> > 
										</div>
									</div>
								<div class="table-responsive-lg">
									<table class="table table-striped">
										<thead>
											<tr>
												<td>#</td>
												<td>Out</td>
												<td>In</td>
												<td style="text-align:center;">Minute</td>
											</tr>
										</thead>
										<tbody>
											<?php
											$count = 0;
											
											if(isset($form_data['home_team_id']) && isset($form_data['away_team_id']))
											{												
												$sub_count[$form_data['home_team_id']] = $count;
												$sub_count[$form_data['away_team_id']] = $count;
											}
											
											foreach($time_array as $timeline)
											{
												array_multisort(array_column($timeline, "action_name"), SORT_ASC, $timeline);
											
												foreach($timeline as $row_timeline)
												{
													// ad($player_involved[$row_timeline['player_id']]->team_id);
													if($row_timeline['action_name'] == 'suboff')
													{
														$sub_count[$player_involved[$row_timeline['player_id']]->team_id] = $sub_count[$player_involved[$row_timeline['player_id']]->team_id] + 1;
														
											?>
														<tr>
															<td>
																<?php echo $sub_count[$player_involved[$row_timeline['player_id']]->team_id];?>
															</td>
															<td>
																<?php echo '<a href="'.base_url().'secure/update_player/'.encrypt_data($row_timeline['player_id']).'" target="_blank">' . $player_involved[$row_timeline['player_id']]->name . '</a> ' . $player_involved[$row_timeline['player_id']]->position;?> 
															</td>
															<td>
																<?php echo '<a href="'.base_url().'secure/update_player/'.encrypt_data($row_timeline['action_player_id']).'" target="_blank">' . $player_involved[$row_timeline['action_player_id']]->name . '</a> ' . $player_involved[$row_timeline['action_player_id']]->position;?>
															</td>
															<td style="text-align:center;">
																<?php echo isset($row_timeline['action_time']) && $row_timeline['action_time'] != '' ? $row_timeline['action_time'] . ':00' :'';?>
															</td>
														</tr>
											<?php
													}
													
													// ad($sub_count);
												}
											}
											?>
											<tr>
												<td colspan=4 style="border:0px;">
													&nbsp
												</td>
											</tr>
											<tr>
												<td colspan=2 style="border:0px;background-color:white;">
												
												</td>
												<td style="text-align:center">
													Home Subs
												</td>
												<td style="text-align:center;">
													<?php echo isset($form_data) ? $sub_count[$form_data['home_team_id']] : '0';?>
												</td>
											</tr>
											<tr>
												<td colspan=2 style="border:0px;background-color:white;">
												
												</td>
												<td style="text-align:center">
													Away Subs
												</td>
												<td style="text-align:center;"> 
													<?php echo isset($form_data) ? $sub_count[$form_data['away_team_id']] : '0';?>
												</td>
											</tr>
										</tbody>
									</table>
								</div>
							</div>
							
							<div class="tab-pane fade" id="action" role="tabpanel" aria-labelledby="action">
									<div class="form-group row">
										<div class="col-lg-6">
											<label>Player:</label>
											<select class="form-control player_action_id " name="player_action_id">
												<option disabled selected >Choose player</option>
												<?php
												if(isset($home_subs_out) && is_array($home_subs_out) && sizeof($home_subs_out) > 0)
												{
													array_multisort(array_column($home_subs_out, "position"), SORT_ASC, $home_subs_out);
													echo '<optgroup label="'.$home_team_info->name.'">';
													foreach($home_subs_out as $tkey=>$tvalue)
													{
														echo isset($tvalue->jersey_number) && $tvalue->jersey_number != 0 ? '<option value="'.$tvalue->id.'" >' . $tvalue->name . ' ('. $tvalue->jersey_number .') ' . $tvalue->position  .'</option>' : '<option value="'.$tvalue->id.'" >' . $tvalue->name . ' ' . $tvalue->position  .'</option>';
													}
													echo '</optgroup>';
												}				
												
												if(isset($away_subs_out) && is_array($away_subs_out) && sizeof($away_subs_out) > 0)
												{
													array_multisort(array_column($away_subs_out, "position"), SORT_ASC, $away_subs_out);
													echo '<optgroup label="'.$away_team_info->name.'">';
													foreach($away_subs_out as $tkey=>$tvalue)
													{
														echo isset($tvalue->jersey_number) && $tvalue->jersey_number != 0 ? '<option value="'.$tvalue->id.'" >' . $tvalue->name . ' ('. $tvalue->jersey_number .') ' . $tvalue->position  .'</option>' : '<option value="'.$tvalue->id.'" >' . $tvalue->name . ' ' . $tvalue->position  .'</option>';
													}
													echo '</optgroup>';
												}													
												?>
											</select>
										</div>
										<div class="col-lg-6">
											<label>Action:</label>
											<select class="form-control action" name="action">
												<option disabled selected >Choose action</option>
												<option value="assist" >Assist</option>
												<option value="score" >Score</option>
												<option value="owngoal" >Owngoal</option>
												<option value="yellow" >Yellow Card</option>
												<option value="red" >Red Card</option>
												<option value="pen_saved" >Saved Penalty</option>
												<option value="pen_missed" >Missed Penalty</option>
											</select>
										</div>
									</div>
									<div class="form-group row">
										<div class="col-lg-6">
											<label>Minutes:</label>
											<input type="number" class="form-control" value="<?php echo array_key_last($time_array)+1;?>" name="action_time" <?php echo isset($form_data['id']) && $form_data['id'] != '' ? '' : 'disabled';?> >
										</div>
										<div class="col-lg-6 scoreType" style="display:none;">
											<label>Type:</label>
											<select class="form-control" name="type">
												<option disabled selected >Choose type</option>
												<option value="heading" >Heading</option>
												<option value="freekick" >Freekick</option>
												<option value="longrange" >Long Range</option>
												<option value="tapin" >Tap In</option>
												<option value="penalty" >Penalty</option>
												<option value="dribbling" >Dribbling</option>
												<option value="other" >Other</option>
											</select>
										</div>
									</div>
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
<script src="<?php echo base_url();?>template/metronic/dist/assets/js/pages/crud/forms/widgets/bootstrap-datepicker.js"></script>
<script src="<?php echo base_url();?>template/metronic/dist/assets/js/pages/crud/forms/widgets/select2.js"></script>
<!--end::Page Scripts-->
<script type="text/javascript">
$(function() 
{
	$('.deleteAction').on('click',function(e){
		e.preventDefault();
		
		var id = $(this).attr('id');
		var action_name = $(this).attr('action-name');
		
		$.ajax({
			url: baseUrl + 'secure/delete_action',
			method: "POST",
			data: {id: id, action_name: action_name},
			dataType:'json',
			success: function(response){
				if(response['result'] == 'success')
				{
					toastr.success(response['message']);
					setTimeout(function(){
							location.reload();
					}, 1000);
				}
				else
				{
					toastr.error(response['message']);
				}
			}
		});
		
	});
	
	$('.selectTwo').select2({
		placeholder: 'Select a player'
	});
		
	$('.action').on('change',function(e){
		e.preventDefault();
		
		var actionValue = $(this).val();
		
		if(actionValue == 'score')
			$('.scoreType').css('display','block');
		else
			$('.scoreType').css('display','none');
			
	});
	
	$('.hometeamSelect').on('change',function(e){
		e.preventDefault();
		
		var teamId = $(this).val();
		
		$('.awayteamSelect option[value=' + teamId +']').attr('disabled','disabled').siblings().removeAttr('disabled');
		$('.awayteamSelect option[name=disabled]').remove();
		
	});
	
	$('.awayteamSelect').on('change',function(e){
		e.preventDefault();
		
		var teamId = $(this).val();
		
		$('.hometeamSelect option[value=' + teamId +']').attr('disabled','disabled').siblings().removeAttr('disabled');
		$('.hometeamSelect option[name=disabled]').remove();
		
	});
	
	
	$('.homePlayer').on('change',function(e){
		
		e.preventDefault();
		
		var playerId = $(this).val();
		
		$('.homePlayer option[name=disabled]').remove();
	
		$('.homePlayer').not(this).find('option[value='+ playerId + ']').prop('disabled',true);
	});
	
	$('.away_player').on('change',function(e){
		
		e.preventDefault();
		
		var playerId = $(this).val();
		
		$('.away_player option[name=disabled]').remove();
	
		$('.away_player').not(this).find('option[value='+ playerId + ']').prop('disabled',true);
	});
	
	$('#js_form_match').submit(function(event){	
		event.preventDefault();
		// var values = $(this).serialize();
		var formData = new FormData($(this)[0]);
		var matchID = $('#id').val();
		$(":input").removeClass("is-invalid");
		$("select").removeClass("is-invalid");
		
		// alert('zas');
		// alert(formData);
		var countPlayer = 0;
		const playerArr = [];
		for (var pair of formData.entries()) {

			if(pair[0] == 'player[]')
			{
				if(playerArr.includes(pair[1]) == false)
				{
					console.log(pair[0]+ ' - ' + pair[1]);
					playerArr[countPlayer] = pair[1]; 
					countPlayer = countPlayer + 1;
				}
			}
			
		}

		var matchStatus = $('.matchStatus').val();
		
		if(countPlayer == 22 && matchStatus != 'ongoing')
		{
			Swal.fire({
				title: "Lineup Complete",
				text: "You may want to change match status!",
				icon: "info",
				showCancelButton: true,
				confirmButtonText: "Yes, change it !",
				cancelButtonText: "No, Proceed !",
				reverseButtons: true
			}).then(function(result) {
				if (result.value) {
					$('.matchStatus option[value=ongoing]').attr('selected','selected');
					return;
				} else if (result.dismiss === "cancel") {
					$.ajax({
						url: baseUrl + 'secure/match_form',
						method: "POST",
						data: formData,
						dataType:'json',
						async: false,
						cache: false,
						contentType: false,
						processData: false,
						success: function(response){
							if(response['result'] == 'success')
							{
								toastr.success(response['message']);
								setTimeout(function(){
									
									if(matchID != '')
									{
										location.reload();
									}
									else
									{
										location.href = baseUrl + 'secure/listing/match';
									}
									
								}, 1000);
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
				}
			});
			
		}
		else
		{
			$.ajax({
				url: baseUrl + 'secure/match_form',
				method: "POST",
				data: formData,
				dataType:'json',
				async: false,
				cache: false,
				contentType: false,
				processData: false,
				success: function(response){
					if(response['result'] == 'success')
					{
						toastr.success(response['message']);
						setTimeout(function(){
							
							if(matchID != '')
							{
								location.reload();
							}
							else
							{
								location.href = baseUrl + 'secure/listing/match';
							}
							
						}, 1000);
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
		}
	});
	
});
</script>
<?php
$this->load->view('secure/m_footer_close');
?>
