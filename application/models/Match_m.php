<?php

class Match_m extends CI_Model {

	function __construct(){
		parent::__construct();
	}
	
	function match_listing($search_data = array())
	{
		$data["menu"] = "Leagues";
		$data["menu_item"] = "matches_listing";
		$data['title'] = 'Match Listing';
		$data['card_title'] = '<span class="card-icon"><i class="fas fa-trophy"></i></span><h3 class="card-label"> Match Listing <small>Fixtures matches</small></h3>';
		$data['breadcrumbs'] = array('Clubs'=>'secure/listing/match');
		
		$is_download = (isset($search_data['download']) && $search_data['download'] == 'true');
		
                $season_id = '';
		if(isset($search_data['extra_filter']) && $search_data['extra_filter'] != '')
		{
			$season_id = $search_data['extra_filter'];
		}
		else
		{
			$get_current_season_name = get_current_season();
			$current_season_data = $this->db->where('name',$get_current_season_name)->limit(1)->get('season')->row();
			
                        if(!is_null($current_season_data))
                            $season_id = $current_season_data->id;
		}
                
                if($season_id != '')
                    $where = "WHERE `fixtures`.`season_id` = " . $this->db->escape($season_id);
                else
                    $where = '';
                
		$orderby = "`fixtures`.`id`";
		
		if(is_array($search_data) && sizeof($search_data) > 0){
			
			if(isset($search_data['sql_sort_column']) && $search_data['sql_sort_column'] != "")
			{
				$orderby = $search_data['sql_sort_column'];
			}
			else
			{
				$orderby = "`fixtures`.`id`";
			}
			
			if(!isset($search_data['sql_sort']))
			{
				$search_data['sql_sort'] = "DESC";
			}
			
			if(isset($search_data['filter']) && $search_data['filter'] != "")
			{
				if(isset($search_data['filterBy']) && $search_data['filterBy'] != "")
				{
					if($search_data['filter'] == 'home_team')
					{
						$search_data['filter'] = '`table_home`.`name`';
						$where .= ($where == "" ? " WHERE " : " AND ") . " ( `table_home`.`name` = " . $this->db->escape($search_data['filterBy']) . " ) ";
					}
					else if($search_data['filter'] == 'away_team')
					{
						$search_data['filter'] = '`table_away`.`name`';
						$where .= ($where == "" ? " WHERE " : " AND ") . " ( `table_away`.`name` = " . $this->db->escape($search_data['filterBy']) . " ) ";
					}
					else
					{
						$where .= ($where == "" ? " WHERE " : " AND ") . $search_data['filter'] ." = " . $this->db->escape($search_data['filterBy']) . " ";
					}
				}
			}
			
			if(isset($search_data['search']) && $search_data['search'] != "")
			{
				$where .= ($where == "" ? " WHERE " : " AND ") . " ( `fixtures`.`home_team_id` LIKE " . $this->db->escape("%".$search_data['search']."%") . " OR `fixtures`.`away_team_id` LIKE " . $this->db->escape("%".$search_data['search']."%")  . " OR `fixtures`.`matchweek` LIKE " . $this->db->escape("%".$search_data['search']."%") . " ) ORDER BY " .  $orderby . " " . $search_data['sql_sort'] ;
			}
			else
			{
				$where .= " ORDER BY " . $orderby . " " . $search_data['sql_sort'] ;
			}
			
		}
		else
		{
			$where .= " ORDER BY " . $orderby . " DESC";
		}
		
		$sql = "SELECT `fixtures`.`id`, `fixtures`.`matchweek`, `fixtures`.`home_team_id`, `fixtures`.`away_team_id`, `fixtures`.`home_team_score`, `fixtures`.`away_team_score`, `fixtures`.`away_team_score`, `fixtures`.`status`, `fixtures`.`date`, `fixtures`.`time`, `table_home`.`name` as `home_team`, `table_away`.`name` as `away_team` FROM `fixtures` LEFT JOIN `team` as `table_home` ON `fixtures`.`home_team_id` = `table_home`.`id` LEFT JOIN `team` as `table_away` ON `fixtures`.`away_team_id` = `table_away`.`id` " . $where ;
		$query = $this->db->query($sql);
		
		$data['total_rows'] = $query->num_rows();
		$config['base_url'] = base_url() . 'secure/listing/match/' . $this->uri->segment(4);
		$config['uri_segment'] = 5;
		$config['total_rows'] = $data['total_rows'];
		$config['per_page'] = 10;
		
		$this->pagination->initialize($config);

		$data['pagination'] = $this->pagination->create_links();
		$data['num_per_page'] = $config['per_page'];
		
		$limit = ' LIMIT 0, ' . $config['per_page'];
		
		if($data['total_rows'] > 0) {
			if($this->uri->segment($config['uri_segment']) AND is_numeric($this->uri->segment($config['uri_segment'])))
			{
				$limit = ' LIMIT ' . $this->uri->segment($config['uri_segment']) . ', ' . $config['per_page'];
			}
			else
			{
				$limit = ' LIMIT 0, ' . $config['per_page'];
			}
		}
		
		if($is_download === true)
		{
			$sql_query = "SELECT `fixtures`.`id`, `fixtures`.`matchweek`, `fixtures`.`home_team_id`, `fixtures`.`away_team_id`, `fixtures`.`home_team_score`, `fixtures`.`away_team_score`, `fixtures`.`away_team_score`, `fixtures`.`status`, `fixtures`.`date`, `fixtures`.`time`, `table_home`.`name` as `home_team`, `table_away`.`name` as `away_team` FROM `fixtures` LEFT JOIN `team` as `table_home` ON `fixtures`.`home_team_id` = `table_home`.`id` LEFT JOIN `team` as `table_away` ON `fixtures`.`away_team_id` = `table_away`.`id` " . $where ;
		}
		else
		{
			$sql_query = "SELECT `fixtures`.`id`, `fixtures`.`matchweek`, `fixtures`.`home_team_id`, `fixtures`.`away_team_id`, `fixtures`.`home_team_score`, `fixtures`.`away_team_score`, `fixtures`.`away_team_score`, `fixtures`.`status`, `fixtures`.`date`, `fixtures`.`time`,`table_home`.`name` as `home_team`, `table_home`.`short_name` as `home_team_short` ,`table_home`.`manager` as `home_manager`, `table_home`.`image_url` as `home_image` , `table_away`.`name` as `away_team`, `table_away`.`short_name` as `away_team_short` ,`table_away`.`manager` as `away_manager`, `table_away`.`image_url` as `away_image` FROM `fixtures` LEFT JOIN `team` as `table_home` ON `fixtures`.`home_team_id` = `table_home`.`id` LEFT JOIN `team` as `table_away` ON `fixtures`.`away_team_id` = `table_away`.`id` " . $where . $limit ;
		}
		
		// ad($sql_query);
		// exit();
		
		$data['query'] = $this->db->query($sql_query);
		
		$result = $data['query']->result();
		
		// ad($result);
		
		// $player_ids = array_column($result, 'id');
		
		$rows = [];
		
		if($this->uri->segment(5) == "")
		{
			$j = 1;
			
		}
		else
		{
			$j = $this->uri->segment(5)+1;
		}
		
		foreach($result as $i=>$res){
			
			$action = '<div class="btn-group" role="group" aria-label="Basic example" style="width:100%;">';
			
			$action .= ' <a href="'.base_url().'secure/update_match/'. encrypt_data($res->id) . '" class="btn btn-outline-primary ">Manage</a>';
			$action .= ' <a href="javascript:void();" fixture-id="'.$res->id.'" class="btn btn-icon btn-outline-danger deleteFixtures"><i class="fas fa-trash-alt"></i></a>';
			
			$action .= '</div>';

			$match = "";
			
			$row = [
				'date' => isset($res->date) && $res->date != '' ?  date("l", strtotime($res->date)) . ', ' . date("d M Y", strtotime($res->date)) : '',
				'matchweek' => isset($res->matchweek) && $res->matchweek != '' ? 'Matchweek ' . $res->matchweek : '-',
				// 'time' => isset($res->time) && $res->time != NULL ? date("H:i a",$res->time) : 'Not Set',
				'home_team' => isset($res->home_team) && $res->home_team != '' ? $res->home_team : '-',
				'home_team_short' => isset($res->home_team_short) && $res->home_team_short != '' ? $res->home_team_short : '-',
				'home_team_id' => isset($res->home_team_id) && $res->home_team_id != '' ? $res->home_team_id : '-',
				'home_team_score' => isset($res->home_team_score) && $res->home_team_score != '' ?$res->home_team_score : '-',
				'away_team_score' => isset($res->away_team_score) && $res->away_team_score != '' ? $res->away_team_score : '-',
				'away_team_id' => isset($res->away_team_id) && $res->away_team_id != '' ? $res->away_team_id : '-',
				'away_team' => isset($res->away_team) && $res->away_team != '' ? $res->away_team : '-',
				'away_team_short' => isset($res->away_team_short) && $res->away_team_short != '' ? $res->away_team_short : '-',
				'away_manager' => isset($res->away_manager) && $res->away_manager != '' ? $res->away_manager : 'No Manager',
				'home_manager' => isset($res->home_manager) && $res->home_manager != '' ? $res->home_manager : 'No Manager',
				'home_image' => isset($res->home_image) && $res->home_image != '' ? base_url() . $res->home_image : '',
				'away_image' => isset($res->away_image) && $res->away_image != '' ? base_url() . $res->away_image : '',
				'status' =>isset($res->status) && $res->status != '' ? ucfirst(strtolower($res->status)) : '-',
				'action' => $action,
			];

			$rows[] = $row;
			
		}
		
		
	
		if($is_download)
		{
			download_csv($rows, 'match_list'.today().'.csv');
			exit;
		}
		
		$filter = [
			'team.name' => 'Home Team',
			'team.name' => 'Away Team',
			'fixtures.matchweek' => 'Matchweek',
		];
		
		$data['actions'] = [
			'<a href="javascript:void();" class="btn btn-info download-button mr-2">Download</a>',
			'<a href="'.base_url().'secure/match_form" class="btn btn-info">Add New Match</a>',
		];
		
		$all_season = $this->db->where('status','1')->get('season')->result();
		
		$html_extra_filter = '<div class="form-group row"><div class="col-md-4"><label>Season</label><select name="" class="form-control extraFilter"><option value="" readonly disabled selected>Choose</option>';
		
		foreach($all_season as $row_season)
		{
			if((isset($search_data['extra_filter']) && $search_data['extra_filter'] == $row_season->id) || $season_id == $row_season->id)
				$selected = 'selected';
			else
				$selected = '';
			
			$html_extra_filter .= '<option value="'.$row_season->id.'" '.$selected.' >'.$row_season->name.'</option>';;
		}
		
		$html_extra_filter .= '</select></div></div>';
		
		$data['extra_filter'] = $html_extra_filter;
		
		$sort = [
		'Date' => '`fixtures`.`date`',
		'Matchweek' => '`fixtures`.`matchweek`',
		'Play Offs' => '`fixtures`.`time`',
		// 'Home' => '`table_home`.`name`',
		// 'Home Score' => '`fixtures`.`home_team_score`',
		// 'Away Score' => '`fixtures`.`away_team_score`',
		// 'Away' => '`table_away`.`name`',
		'Status' => '`fixtures`.`status`',
		];
		
		$data['total'] = $data['total_rows'];
		$data['rows'] = $rows;
		$data['sort'] = $sort;
		
		foreach($filter as $row=> $val)
		{
			$explodeFilter = explode('.',$row);
			$tableName = $explodeFilter[0];
			$columnName = $explodeFilter[1];
			
			$sql_query = "SELECT DISTINCT(`".$columnName."`) FROM `" . $tableName . "`";
			$query = $this->db->query($sql_query)->result();
			
			foreach($query as $a=>$b)
			{
				$bool = true;
				if($columnName == 'name')
				{
					if($bool == true)
					{
						$data['selectFilter']['home_team'][] = ucwords($b->$columnName);
						$bool = false;
					}
					
					if($bool == false)
					{
						$data['selectFilter']['away_team'][] = ucwords($b->$columnName);
					}
						
				}
				else
				{
					$data['selectFilter'][$columnName][] = ucwords($b->$columnName);
				}
			}
		}
		
		$filter = [
			'home_team' => 'Home Team',
			'away_team' => 'Away Team',
			'matchweek' => 'Matchweek',
		];
		
		$data['filter'] = $filter;
		
		// ad($data);
		// exit();
		return $data;
	}
	
	function get_match_formdata($match_id = NULL)
	{
		if($match_id != NULL)
		{
			$sql = "SELECT * FROM `fixtures` WHERE `id` = " . $this->db->escape($match_id) . " LIMIT 1";
			$query = $this->db->query($sql);
			
			return $query->num_rows() > 0 ? $query->row_array() : array();
		}
		
		return array();
	}
	
	
	function get_actions_history($fixtures_id = NULL)
	{
		if($fixtures_id != NULL)
		{
			$sql = "SELECT * FROM `player_in_fixtures` WHERE `fixture_id` = " . $this->db->escape($fixtures_id) . " ORDER BY `id` ASC ";
			$query = $this->db->query($sql);
			
			return $query->num_rows() > 0 ? $query->result() : array();
		}
		
		return array();
	}
	
	function get_first_team($fixture_id = NULL)
	{
		if($fixture_id != NULL)
		{
			$sql = "SELECT * FROM `player_in_fixtures` WHERE `fixture_id` = " . $this->db->escape($fixture_id) . " AND `first_team` = 1 ORDER BY `id` ASC ";
			$query = $this->db->query($sql);
			
			return $query->num_rows() > 0 ? $query->result() : array();
		}
		
		return array();
	}
	
	function get_player_involved($data = array())
	{
		$player_data = array();
		
		foreach($data as $row)
		{
			$player = $this->db->where('id',$row->player_id)->limit(1)->get('player')->row();
			$player->first_team = $row->first_team;
			$player_data[$player->id] = $player;
		}

		return $player_data;
	}
	
	
	function get_team_player($team_id = NULL)
	{
		
		if($team_id != NULL)
		{
			$players = $this->db->where('team_id',$team_id)->order_by('position','ASC')->get('player')->result();
			
			return isset($players) && sizeof($players) > 0 ? $players : array();
 		}
		
		return array();
	}
	
	function get_team_name($team_id = NULL)
	{
		
		if($team_id != NULL)
		{
			$team = $this->db->where('id',$team_id)->limit(1)->get('team')->row();
			
			return isset($team) ? $team : array();
 		}
		
		return array();
	}
	
	function match_form($post = array())
	{
		if(isset($post) && sizeof($post) > 0)
		{

			// ad($post);
			// exit('s');
			/* Array
			(
				[id] => 281
				[matchweek] => 22
				[date] => 02/25/2023
				[home_team_id] => 62
				[away_team_id] => 58
				[home_team_score] => 1
				[away_team_score] => 0
				[home_team_penalty] => 
				[away_team_penalty] => 
				[status] => history
				[season_id] => 6
				[player] => Array  
					(
						[0] => 148
						[1] => 214
						[2] => 518
						[3] => 111
						[4] => 136
						[5] => 218
						[6] => 141
						[7] => 224
						[8] => 144
						[9] => 484
						[10] => 146
						[11] => 326
						[12] => 406
						[13] => 328
						[14] => 268
						[15] => 341
						[16] => 345
						[17] => 232
						[18] => 154
						[19] => 338
						[20] => 134
						[21] => 230
					)

				[home_sub_out] => 140
				[home_sub_in] => 213
				[sub_time] => 91
				[player_action_id] => 524
				[action] => score
				[action_time] => 89
				[type] => freekick
				[home_lineup_change_out] => 10
				[away_lineup_change_out] => 138
				[home_lineup_change_in] => 23
				[away_lineup_change_in] => 154
			) */
			
			if(isset($post['matchweek']) && $post['matchweek'] == '')
			{
				$response['result'] = false;
				$response['message'] = "Matchweek name field blank, please fill in to proceed.";
				$response['input'] = "name";
				$response['type'] = "input";
				
				return $response;
			}
			
			if(isset($post['date']) && $post['date'] == '')
			{
				$response['result'] = false;
				$response['message'] = "Matchweek date field blank, please fill in to proceed.";
				$response['input'] = "date";
				$response['type'] = "input";
				
				return $response;
			}
			
			if(!isset($post['home_team_id']))
			{
				$response['result'] = false;
				$response['message'] = "Home team field empty, please choose home team to proceed.";
				$response['input'] = "home_team_id"; 
				$response['type'] = "select";
				
				return $response;
			}
			
			if(!isset($post['away_team_id']))
			{
				$response['result'] = false;
				$response['message'] = "Away team field empty, please choose away team to proceed.";
				$response['input'] = "away_team_id"; 
				$response['type'] = "select";
				
				return $response;
			}
			
			if(!isset($post['status']))
			{
				$response['result'] = false;
				$response['message'] = "Status field empty, please choose match status to proceed.";
				$response['input'] = "status"; 
				$response['type'] = "select";
				
				return $response;
			}
			else if($post['status'] == 'ongoing' && isset($post['player']) && sizeof($post['player']) < 22)
			{
				$response['result'] = false;
				$response['message'] = "Cannot start match, lineup is not complete. please complete to proceed.";
				
				return $response;
			}
			
			if(!isset($post['season_id']))
			{
				$response['result'] = false;
				$response['message'] = "Season field empty, please choose match season to proceed.";
				$response['input'] = "season_id"; 
				$response['type'] = "input";
				
				return $response;
			}
			
			/* 
			[name] => 22
			[home_team_id] => 62
			[away_team_id] => 58
			[home_team_score] => 1
			[away_team_score] => 0
			[home_team_penalty] => 
			[away_team_penalty] => 
			[status] => history
			[season_id] => 6
			*/
			
			$get_current_season_name = get_current_season();
			$current_season_data = $this->db->where('name',$get_current_season_name)->limit(1)->get('season')->row();
                        $season_id = $current_season_data->id;
			
			$general_information = array(
			'matchweek'=>isset($post['matchweek']) && $post['matchweek'] != '' ? trim($post['matchweek']) :'',
			'date'=>isset($post['date']) && $post['date'] != '' ? date("Y-m-d",strtotime($post['date'])) :'',
			'home_team_id'=>isset($post['home_team_id']) && $post['home_team_id'] != '' ? trim($post['home_team_id']) :'',
			'away_team_id'=>isset($post['away_team_id']) && $post['away_team_id'] != '' ? trim($post['away_team_id']) :'',
			'home_team_score'=>isset($post['home_team_score']) && $post['home_team_score'] != '' ? trim($post['home_team_score']) :NULL,
			'away_team_score'=>isset($post['away_team_score']) && $post['away_team_score'] != '' ? trim($post['away_team_score']) :NULL,
			'home_team_penalty'=>isset($post['home_team_penalty']) && $post['home_team_penalty'] != '' ? trim($post['home_team_penalty']) : NULL,
			'away_team_penalty'=>isset($post['away_team_penalty']) && $post['away_team_penalty'] != '' ? trim($post['away_team_penalty']) : NULL,
			'status'=>isset($post['status']) && $post['status'] != '' ? trim($post['status']) : NULL,
			'season_id'=>isset($post['season_id']) && $post['season_id'] != '' ? trim($post['season_id']) : $season_id,
			'created_at'=>date("Y-m-d H:i:s"),
			'updated_at'=>date("Y-m-d H:i:s"),
 			);
			
			
			if(isset($post['id']) && $post['id'] != '')
			{
				$player = $this->db->where('id',$post['id'])->limit(1)->get('player')->row();
				
				unset($general_information['created_at']);
				$this->db->where('id', $post['id']);
				$error[] = $this->db->update('`fixtures`',$general_information);
				
			}
			else
			{
				$error[] = $this->db->insert('fixtures',$general_information);
				$match_id = $this->db->insert_id();
			}
			
			//player involved
			
			if(isset($post['player']) && is_array($post['player']) && sizeof($post['player']) > 0)
			{
				$player_result = $this->player($post['player'],$post['id']);
				
				if($player_result['result'] == false)
				{
					return $player_result;
				}
			}
			/* 
			[home_sub_out] => 140
			[home_sub_in] => 213
			[sub_time] => 91
			[player_action_id] => 524
			[action] => score
			[action_time] => 89
			[type] => freekick 
			*/
			
			if(isset($post['home_sub_out']) && $post['home_sub_out'] != '' && isset($post['home_sub_in']) && $post['home_sub_in'] != '' )
			{
				$substitution_result = $this->substitution($post['home_sub_out'],$post['home_sub_in'],$post['sub_time'], $post['id']);				
				
				if($substitution_result['result'] == false)
				{
					return $substitution_result;
				}
			}
			
			if(isset($post['away_sub_out']) && $post['away_sub_out'] != '' && isset($post['away_sub_in']) && $post['away_sub_in'] != '' )
			{
				$substitution_result = $this->substitution($post['away_sub_out'],$post['away_sub_in'],$post['sub_time'], $post['id']);				
				
				if($substitution_result['result'] == false)
				{
					return $substitution_result;
				}
			}
			if(isset($post['action']) && $post['action'] != '')
			{
				if($post['action'] == 'score')
					$action_result = $this->update_action($post['player_action_id'],$post['action'],$post['type'],$post['action_time'],$post['id']);
				else
					$action_result = $this->update_action($post['player_action_id'],$post['action'],NULL,$post['action_time'],$post['id']);
				
				if($action_result['result'] == false)
				{
					return $action_result;
				}

				$update_fixture_actions = $this->update_match_actions($post['id']);

				if($update_fixture_actions['result'] == false)
				{
					return $update_fixture_actions;
				}
			}else{
				$update_fixture_actions = $this->update_match_actions($post['id']);
			}
			
			// [home_lineup_change_out] => 10
			// [away_lineup_change_out] => 138
			// [home_lineup_change_in] => 23
			// [away_lineup_change_in] => 154
			
			if(isset($post['home_lineup_change_out']) && isset($post['home_lineup_change_in']) && $post['home_lineup_change_out'] != '' && $post['home_lineup_change_in'] != '')
			{
				$lineup_change_result = $this->lineup_change($post['home_lineup_change_out'],$post['home_lineup_change_in'], $post['id']);				
				
				if($lineup_change_result['result'] == false)
				{
					return $lineup_change_result;
				}
			}
			
			if(isset($post['away_lineup_change_out']) && isset($post['away_lineup_change_in']) && $post['away_lineup_change_out'] != '' && $post['away_lineup_change_in'] != '')
			{
				$lineup_change_result = $this->lineup_change($post['away_lineup_change_out'],$post['away_lineup_change_in'], $post['id']);				
				
				if($lineup_change_result['result'] == false)
				{
					return $lineup_change_result;
				}
			}
			
			// if(isset($post['status']) && $post['status'] == 'history')
			// {
				// calculate score and fantasy point
				// $calculate_result = $this->calculate($post['id']);
				
				// if($calculate_result['result'] == false)
				// {
					// return $calculate_result;
				// }
			// }
			
			
			
			$response['result'] = true;
			
			if(isset($post['id']) && $post['id'] != '')
			{
				$response['message'] = "Match information successfully updated.";
			}
			else
			{
				$response['message'] = "New match successfully registered.";
			}
			return $response;
			
		}
	}
	
	function update_match_actions($fixture_id = NULL)
	{
		if($fixture_id != NULL)
		{
			$response['result'] = true;
			
			$player = $this->db->where('fixture_id',$fixture_id)->get('player_in_fixtures')->result();
			$fixture = $this->db->where('id',$fixture_id)->limit(1)->get('fixtures')->row();
			
			$home = array();
			$away = array();
			foreach($player as $players)
			{
				$player_data = $this->db->where('id',$players->player_id)->limit(1)->get('player')->row();
				
				if($players->team_id == $fixture->home_team_id)
				{
					$array = array(
					'team'=>'home',
					'action'=>json_decode($players->action),
					'role'=>isset($players->first_team) && $players->first_team == 1 ? 'first' : 'sub',
					'fantasy_points'=>0,
					'subwith'=>isset($players->subwith) && $players->subwith != NULL ? $players->subwith : NULL,
					'basic_fantasy_point'=>isset($players->basic_fantasy_point) && $players->basic_fantasy_point != 0 ? $players->basic_fantasy_point : 0,
					'fantasy_point'=>isset($players->fantasy_point) && $players->fantasy_point != 0 ? $players->fantasy_point : 0,
					'player_rating'=>isset($players->player_rating) && $players->player_rating != 0 ? $players->player_rating : 0,
					);
					$home[] = array_merge((array)$player_data,$array);
				}
				else
				{
					$array = array(
					'team'=>'away',
					'action'=>json_decode($players->action),
					'role'=>isset($players->first_team) && $players->first_team == 1 ? 'first' : 'sub',
					'fantasy_points'=>0,
					'subwith'=>isset($players->subwith) && $players->subwith != NULL ? $players->subwith : NULL,
					'basic_fantasy_point'=>isset($players->basic_fantasy_point) && $players->basic_fantasy_point != 0 ? $players->basic_fantasy_point : 0,
					'fantasy_point'=>isset($players->fantasy_point) && $players->fantasy_point != 0 ? $players->fantasy_point : 0,
					'player_rating'=>isset($players->player_rating) && $players->player_rating != 0 ? $players->player_rating : 0,
					);
					$away[] = array_merge((array)$player_data,$array);
				}
			}
			
			$match_actions = array(
			'home'=>json_encode($home),
			'away'=>json_encode($away),
			);
			
			$result = $this->db->where('id',$fixture_id)->update('fixtures',array('actions'=>json_encode($match_actions),'updated_at'=>date("Y-m-d H:i:s")));
			
			if($result == false)
			{
				$response['result'] = false;
				$response['message'] = "Error occured while updating match fixture actions";
				
				return $response;
			}

			return $response;
			
		}
		else
		{
			$response['result'] = false;
			$response['message'] = 'Error occured while updating match fixture actions, fixture id missing';
			return $response;
		}
	}
	
	function lineup_change($out = NULL, $in = NULL, $fixture_id = NULL)
	{
		if($out != NULL && $in != NULL && $fixture_id != NULL)
		{
			$response['result'] = true;
			$player_out_data = $this->db->where('player_id',$out)->where('fixture_id',$fixture_id)->limit(1)->get('player_in_fixtures')->row();
			$action_decode = json_decode($player_out_data->action);

			if(isset($action_decode) && sizeof($action_decode) > 0)
			{
				foreach($action_decode as $row_action)
				{
					//check if there is suboff action
					if($row_action->name == 'suboff')
					{
						$update_player = $this->db->where('id',$player_out_data->id)->update('player_in_fixtures',array('player_id'=>$in));
						//update 
						
						if($update_player == false)
						{
							$response['result'] = false;
							$response['message'] = "Database error occured while updating player id.";
							
							return $response;
						}
						
						$player_sub_data = $this->db->where('player_id',$row_action->player_id)->where('fixture_id',$fixture_id)->limit(1)->get('player_in_fixtures')->row();
						
						$update_player = $this->db->where('id',$player_sub_data->id)->update('player_in_fixtures',array('subwith'=>$in));
						
						if($update_player == false)
						{
							$response['result'] = false;
							$response['message'] = "Database error occured while updating player id subwith.";
							
							return $response;
						}
		
					}
				}
				
				return $response;
			}
			else
			{
				//check if player was subbed with someone
				if($player_out_data->sub == 1)
				{
					$player_sub_data = $this->db->where('player_id',$player_out_data->subwith)->where('fixture_id',$fixture_id)->limit(1)->get('player_in_fixtures')->row();
					$action_decode = json_decode($player_sub_data->action);

					if(isset($action_decode) && sizeof($action_decode) > 0)
					{
						$array = array();
						
						foreach($action_decode as $row_action)
						{
							if($row_action->name == 'suboff')
							{
								$player_data = $this->db->where('id',$in)->limit(1)->get('player')->row();
								//change message for player was a sub
								$array[] = array(
								'name'=>'suboff',
								'time'=>$row_action->time,
								'message'=>isset($player_data->name) && $player_data->name != '' ? $player_data->name :'',
								'player_id'=>$in
								);
							}
							else
							{
								$array[] = (array)$row_action;
							}
						}
							
						$update_player = $this->db->where('player_id',$player_out_data->subwith)->where('fixture_id',$fixture_id)->update('player_in_fixtures',array('action'=>json_encode($array)));
						
						if($update_player == false)
						{
							$response['result'] = false;
							$response['message'] = "Database error occured while updating player id.";
							
							return $response;
						}
					}
					
					$update_player = $this->db->where('id',$player_out_data->id)->update('player_in_fixtures',array('player_id'=>$in));
					
					if($update_player == false)
					{
						$response['result'] = false;
						$response['message'] = "Database error occured while updating player id subwith.";
						
						return $response;
					}
					
					return $response;
					
				}
				else
				{
					$update_player = $this->db->where('id',$player_out_data->id)->update('player_in_fixtures',array('player_id'=>$in));
					
					if($update_player == false)
					{
						$response['result'] = false;
						$response['message'] = "Database error occured while updating player id.";
						
						return $response;
					}
				}
				return $response;
			}
		}
	}
	
	function calculate($fixture_id = NULL)
	{
		if($fixture_id != NULL)
		{
			$response['result'] = true;
			
			$fixture_data = $this->db->where('id',$fixture_id)->limit(1)->get('fixtures')->row();
			
			//update concede for player based on fixture data
			if($fixture_data->home_team_score > $fixture_data->away_team_score)
			{
				$this->db->where('fixture_id',$fixture_id)->where('team_id',$fixture_data->away_team_id)->update('player_in_fixtures',array('concede'=>1));
			}
			else if($fixture_data->home_team_score < $fixture_data->away_team_score)
			{
				$this->db->where('fixture_id',$fixture_id)->where('team_id',$fixture_data->home_team_id)->update('player_in_fixtures',array('concede'=>1));
			}
			
			$player_in_fixtures = $this->db->where('fixture_id',$fixture_id)->get('player_in_fixtures')->result();
			
			if(isset($player_in_fixtures) && is_array($player_in_fixtures) && sizeof($player_in_fixtures) > 0 )
			{
				foreach($player_in_fixtures as $row_player)
				{
					
					$player_data = $this->db->where('id',$row_player->player_id)->limit(1)->get('player')->row();
					
					$fantasy = $this->db->where('position',$player_data->position)->limit(1)->get('fantasy_point_position')->row();
					
					$score = 0;
					
					//first_team
					if($row_player->first_team == 1)
						$score = $score + $fantasy->starts;
					
					//sub
					if($row_player->sub == 1)
						$score = $score + $fantasy->sub;
					
					if($row_player->concede == 1)
						$score = $score + $fantasy->concede;
					
					//clean_sheet
					if($row_player->team_id == $fixture_data->home_team_id && $fixture_data->away_team_score == 0)
					{
						$score = $score + $fantasy->clean_sheet;
					}
					else if($row_player->team_id == $fixture_data->away_team_id && $fixture_data->home_team_score == 0)
					{
						$score = $score + $fantasy->clean_sheet;
					}
					
					$action_decode = json_decode($row_player->action);
					
					if(isset($action_decode) && sizeof($action_decode) > 0)
					{
						foreach($action_decode as $row_action_decode)
						{
							if(in_array($row_action_decode->name,array('score','yellow','red','assist','owngoal','pen_missed','pen_saved')))
							{
								$action_name = $row_action_decode->name;
								$score = $score + $fantasy->$action_name;
							}
						}
					}
					
					$update_score = $this->db->where('id',$row_player->id)->update('player_in_fixtures',array('fantasy_point'=>$score,'basic_fantasy_point'=>$score));
					
					if($update_score == false)
					{
						$response['result'] = false;
						$response['message'] = "Database error occured while updating player fantasy point.";
						
						return $response;
					}
					
				}
				
				return $response;
				
			}
		}
	}
	
	function player($player_array = array(), $fixture_id = NULL)
	{
		if(isset($player_array) && is_array($player_array) && sizeof($player_array) > 0 && $fixture_id != 0)
		{
			
			$batch = array();
			$not_first_team = array();
			$first_team = array();
			
			$response['result'] = true;
			// $this->db->where('fixture_id',$fixture_id)->delete('player_in_fixtures');

			foreach($player_array as $row_player)
			{
				$player_data = $this->db->where('id',$row_player)->limit(1)->get('player')->row();
				$fixture_data = $this->db->where('id',$fixture_id)->limit(1)->get('fixtures')->row();
				
				$player_in_fixture_exist = $this->db->where('player_id', $player_data->id)->where('fixture_id',$fixture_id)->limit(1)->get('player_in_fixtures')->result();

				$first_team[] = $player_data->id;
					
				if(is_array($player_in_fixture_exist) && sizeof($player_in_fixture_exist) > 0)
				{
					//dah ada dalam db update jadi first team
					$this->db->where('player_id', $player_data->id)->where('fixture_id',$fixture_id)->update('player_in_fixtures',array('first_team'=>1));
				}
				else
				{   
					$player = array(
					'player_id'=>isset($player_data->id) && $player_data->id != '' ? $player_data->id :'',
					'fixture_id'=>isset($fixture_id) && $fixture_id != '' ? $fixture_id :'',
					'first_team'=>'1',
					'action'=>'[]',
					'team_id'=>isset($player_data->team_id) && $player_data->team_id != '' ? $player_data->team_id :'',
					'season_id'=>isset($fixture_data->season_id) && $fixture_data->season_id != '' ? $fixture_data->season_id :'',
					);
					
					$batch[] = $player;
				}
			}
			
			if(sizeof($batch) > 0)
			{
				$insert_result = $this->db->insert_batch('player_in_fixtures',$batch);
				if($insert_result == false)
				{
					$response['result'] = false;
					$response['message'] = "Database error occured while inserting player lineup.";
					
					return $response;
				}
			}
			
			$get_player_in_fixtures = $this->db->where('fixture_id',$fixture_id)->get('player_in_fixtures')->result();
			
			if(isset($get_player_in_fixtures) && sizeof($get_player_in_fixtures) > 0 && is_array($get_player_in_fixtures))
			{
				foreach($get_player_in_fixtures as $row_player_involved)
				{
					if(!in_array($row_player_involved->player_id,$first_team))
					{
						
						$this->db->where('player_id', $row_player_involved->player_id)->where('fixture_id',$fixture_id)->update('player_in_fixtures',array('first_team'=>0));
					}
				}
			}
			
			return $response;
		}
	}
	
	function substitution($out = NULL, $in = NULL, $time = NULL, $fixture_id = NULL)
	{
		if($out != NULL && $in != NULL && $time != NULL && $fixture_id != NULL)
		{
			$response['result'] = true;
			
			if(isset($time) && isset($time) == '')
			{
				$response['result'] = false;
				$response['message'] = "Substitution minute field blank, please fill in to proceed.";
				$response['input'] = "sub_time";
				$response['type'] = "input";
				
				return $response;
			}
			
			$get_action = $this->db->where('player_id',$out)->where('fixture_id',$fixture_id)->limit(1)->get('player_in_fixtures')->row();
			$action = json_decode($get_action->action);
			
			$get_player_out = $this->db->where('id',$out)->limit(1)->get('player')->row();
			$get_player_in = $this->db->where('id',$in)->limit(1)->get('player')->row();
			
			$array_action_in = array();
			
			$array_action = array();
			
			if(isset($action) && sizeof($action) > 0)
			{
				$array = array(); 
				foreach($action as $row_action)
				{
					$array[] = (array)$row_action;
				}
				
				$array_action[] = array(
				'name'=>'suboff',
				'time'=>isset($time) && $time != '' ? $time :'',
				'message'=>isset($get_player_in->name) && $get_player_in->name != '' ? $get_player_in->name :'',
				'player_id'=>isset($in) && $in != '' ? $in :'',
				);
				
				$merge = array_merge($array,$array_action);
				
				$update_result = $this->db->where('id',$get_action->id)->update('player_in_fixtures',array('action'=>json_encode($merge)));
				
				if($update_result == false)
				{
					$response['result'] = false;
					$response['message'] = "Database error occured while updating player substitution.";
					
					return $response;
				}
				
			}
			else
			{
				$array_action = array(
				'name'=>'suboff',
				'time'=>isset($time) && $time != '' ? $time :'',
				'message'=>isset($get_player_in->name) && $get_player_in->name != '' ? $get_player_in->name :'',
				'player_id'=>isset($in) && $in != '' ? $in :'',
				);
				
				$update_result = $this->db->where('id',$get_action->id)->update('player_in_fixtures',array('action'=>'['.json_encode($array_action).']'));
				
				if($update_result == false)
				{
					$response['result'] = false;
					$response['message'] = "Database error occured while updating player substitution.";
					
					return $response;
				}
			}
			
			$fixture_data = $this->db->where('id',$fixture_id)->limit(1)->get('fixtures')->row();
			
			$array_action_in = array(
			'player_id'=>isset($in) && $in != '' ? $in :'',
			'fixture_id'=>isset($fixture_id) && $fixture_id != '' ? $fixture_id :'',
			'sub'=>'1',
			'subwith'=>isset($out) && $out != '' ? $out :'',
			'action'=>'[]',
			'team_id'=>isset($get_player_in->team_id) && $get_player_in->team_id != '' ? $get_player_in->team_id :'',
			'season_id'=>isset($fixture_data->season_id) && $fixture_data->season_id != '' ? $fixture_data->season_id :'',
			);
			
			$insert_result = $this->db->insert('player_in_fixtures',$array_action_in);
			
			if($insert_result == false)
			{
				$response['result'] = false;
				$response['message'] = "Database error occured while inserting player substitution.";
				
				return $response;
			}
			
			return $response;
		}
	}
	
	function update_action($player_id = NULL, $action = NULL, $action_type = NULL, $action_time = NULL, $fixture_id = NULL)
	{
		if($player_id != NULL && $action != NULL && $action_time != NULL && $fixture_id != NULL)
		{
			$response['result'] = true;
			
			$get_action = $this->db->where('player_id',$player_id)->where('fixture_id',$fixture_id)->limit(1)->get('player_in_fixtures')->row();
			$action_decode = json_decode($get_action->action);
			
			$array_action = array();
			
			$get_player = $this->db->where('id',$player_id)->limit(1)->get('player')->row();
			
			$fixture_data = $this->db->where('id',$fixture_id)->limit(1)->get('fixtures')->row();
			
			if($fixture_data->home_team_score == NULL)
				$update_score = $this->db->where('id',$fixture_id)->update('fixtures',array('home_team_score'=>0));
			
			if($fixture_data->away_team_score == NULL)
				$update_score = $this->db->where('id',$fixture_id)->update('fixtures',array('away_team_score'=>0));
				
			if($action == 'score')
			{

				if($action_type == NULL)
				{
					$response['result'] = false;
					$response['message'] = "Score type is required for action score, please fill in to proceed.";
					$response['input'] = "type";
					$response['type'] = "select";
					
					return $response;
				}
				
				if(isset($action_decode) && sizeof($action_decode) > 0)
				{
					$array = array(); 
					foreach($action_decode as $row_action)
					{
						$array[] = (array)$row_action;
					}
					
					$array_action[] = array(
					'name'=>isset($action) && $action != '' ? $action :'',
					'time'=>isset($action_time) && $action_time != '' ? $action_time :'',
					'type'=>isset($action_type) && $action_type != '' ? trim($action_type) : '',
					);

					$merge = array_merge($array,$array_action);
					
					$update_action = $this->db->where('id',$get_action->id)->update('player_in_fixtures',array('action'=>json_encode($merge)));
				}
				else
				{
					$array_action = array(
					'name'=>isset($action) && $action != '' ? $action :'',
					'time'=>isset($action_time) && $action_time != '' ? $action_time :'',
					'type'=>isset($action_type) && $action_type != '' ? trim($action_type) : '',
					);

					$update_action = $this->db->where('id',$get_action->id)->update('player_in_fixtures',array('action'=>'['.json_encode($array_action).']'));
				}
				
				if($update_action == false)
				{
					$response['result'] = false;
					$response['message'] = "Database error occured while updating player action.";
					
					return $response;
				}
				
				if($fixture_data->home_team_id == $get_action->team_id)
					$update_score = $this->db->where('id',$fixture_id)->update('fixtures',array('home_team_score'=>$fixture_data->home_team_score+1));
				else
					$update_score = $this->db->where('id',$fixture_id)->update('fixtures',array('away_team_score'=>$fixture_data->away_team_score+1));
				
				if($update_score == false)
				{
					$response['result'] = false;
					$response['message'] = "Database error occured while updating match score.";
					
					return $response;
				}
	
				return $response;
			}
			else
			{
				if(isset($action_decode) && sizeof($action_decode) > 0)
				{
					$yellowCount = 0;

					$array = array(); 
					foreach($action_decode as $row_action)
					{
						if($row_action->name == 'yellow')
							$yellowCount++;
						
						$array[] = (array)$row_action;
					}
					
					if($yellowCount == 1 && $action == 'yellow')
					{	
						$new_array = array();
						foreach($array as $row_action)
						{
							
							if($row_action['name'] != 'yellow')
								$new_array[] = $row_action;
						}
						
						$array = array();
						$array = $new_array;
						
						$array_action[] = array(
						'name'=>'red',
						'time'=>isset($action_time) && $action_time != '' ? $action_time :'',
						);
						
					}
					else
					{
						$array_action[] = array(
						'name'=>isset($action) && $action != '' ? $action :'',
						'time'=>isset($action_time) && $action_time != '' ? $action_time :'',
						);
					}
					
					$merge = array_merge($array,$array_action);
					
					$update_action = $this->db->where('id',$get_action->id)->update('player_in_fixtures',array('action'=>json_encode($merge)));
					
					if($update_action == false)
					{
						$response['result'] = false;
						$response['message'] = "Database error occured while updating player action.";
						
						return $response;
					}
					
					if($action == 'owngoal')
					{
						if($fixture_data->home_team_id == $get_action->team_id)
							$update_score = $this->db->where('id',$fixture_id)->update('fixtures',array('away_team_score'=>$fixture_data->away_team_score+1));
						else
							$update_score = $this->db->where('id',$fixture_id)->update('fixtures',array('home_team_score'=>$fixture_data->home_team_score+1));
						
						if($update_score == false)
						{
							$response['result'] = false;
							$response['message'] = "Database error occured while updating match score.";
							
							return $response;
						}
					}
					
					return $response;
				}
				else
				{
					$array_action = array(
					'name'=>isset($action) && $action != '' ? $action :'',
					'time'=>isset($action_time) && $action_time != '' ? $action_time :'',
					);

					$update_action = $this->db->where('id',$get_action->id)->update('player_in_fixtures',array('action'=>'['.json_encode($array_action).']'));
					
					if($update_action == false)
					{
						$response['result'] = false;
						$response['message'] = "Database error occured while inserting player action.";
						
						return $response;
					}
					
					if($action == 'owngoal')
					{
						if($fixture_data->home_team_id == $get_action->team_id)
							$update_score = $this->db->where('id',$fixture_id)->update('fixtures',array('away_team_score'=>$fixture_data->away_team_score+1));
						else
							$update_score = $this->db->where('id',$fixture_id)->update('fixtures',array('home_team_score'=>$fixture_data->home_team_score+1));
						
						if($update_score == false)
						{
							$response['result'] = false;
							$response['message'] = "Database error occured while updating match score.";
							
							return $response;
						}
					}
						
		
					return $response;
				}
				
			}
		}
	}
	
	function delete_action($post = array())
	{
		if(isset($post['id']) && isset($post['action_name']) && $post['id'] != '' && $post['action_name'] != '')
		{
			$response['result'] = true;
			$response['message'] = 'Successfully delete action';
			
			$action = $this->db->where('id',$post['id'])->limit(1)->get('player_in_fixtures')->row();
			$action_decode = json_decode($action->action);
			
			$fixture_data = $this->db->where('id',$action->fixture_id)->limit(1)->get('fixtures')->row();
			
			if(isset($action_decode) && sizeof($action_decode) > 0)
			{
				$array = array(); 
				foreach($action_decode as $row_action)
				{
					if($row_action->name == $post['action_name'])
					{
						if($post['action_name'] == 'suboff')
						{
							$delete_sub = $this->db->where('player_id',$row_action->player_id)->where('fixture_id',$action->fixture_id)->delete('player_in_fixtures');
							
							if($delete_sub == false)
							{
								$response['result'] = false;
								$response['message'] = "Database error occured while deleting sub player.";
								
								return $response;
							}
						}
						
						if($post['action_name'] == 'score')
						{
							if($fixture_data->home_team_id == $action->team_id)
								$update_score = $this->db->where('id',$action->fixture_id)->update('fixtures',array('home_team_score'=>$fixture_data->home_team_score-1));
							else
								$update_score = $this->db->where('id',$action->fixture_id)->update('fixtures',array('away_team_score'=>$fixture_data->away_team_score-1));
							
							if($update_score == false)
							{
								$response['result'] = false;
								$response['message'] = "Database error occured while updating match score.";
								
								return $response;
							}
						}
						
					}
					else
					{
						$array[] = (array)$row_action;
					}
				}
				
				$update_player = $this->db->where('id',$post['id'])->update('player_in_fixtures',array('action'=>json_encode($array)));
				
				if($update_player == false)
				{
					$response['result'] = false;
					$response['message'] = "Database error occured while updating player action.";
					
					return $response;
				}
			}
			
			return $response;
		}
		else
		{
			$response['message'] = 'Required parameter is missing to delete action, please try again.';
			$response['result'] = false;
			
			return $response;
		}
		
	}
	
	function delete_fixture($fixture_id = NULL)
	{
		if(isset($fixture_id) && $fixture_id != NULL)
		{
			$player = $this->db->where('fixture_id',$fixture_id)->get('player_in_fixtures')->result_id;
			$fixture = $this->db->where('id',$fixture_id)->limit(1)->get('fixtures')->result_id;
			
			if($player->num_rows > 0)
			{
				$result = $this->db->where('fixture_id',$fixture_id)->delete('player_in_fixtures');
				
				if($result == false)
				{
					$response['result'] = false;
					$response['message'] = "Database error occured while deleting player in fixtures.";
					
					return $response;
				}
			}
			
			if($fixture->num_rows > 0)
			{
				$result = $this->db->where('id',$fixture_id)->delete('fixtures');
				
				if($result == false)
				{
					$response['result'] = false;
					$response['message'] = "Database error occured while deleting fixtures data.";
					
					return $response;
				}
			}
			
			$response['result'] = true;
			
			return $response;
		}
		else
		{
			$response['message'] = 'Fixture id missing, please try again.';
			$response['result'] = false;
			
			return $response;
		}
	}
        
        function match_calendar_data()
        {
            $fixtures =$this->db->get('fixtures')->result();
            
            $result = array();
            foreach($fixtures as $row_fixtures)
            {
                $home = $this->db->where('id',$row_fixtures->home_team_id)->get('team')->row();
                                
                $away = $this->db->where('id',$row_fixtures->away_team_id)->get('team')->row();
                
                #SAMPLE
                #title: 'Click for Google',
                #url: 'http://google.com/',
                #start: YM + '-28',
                #className: "fc-event-solid-secondary fc-event-light",
                #description: 'Lorem ipsum dolor sit amet, labore'
                
                $title = $home->short_name . ' VS ' . $away->short_name;
                $url = base_url().'secure/update_match/'. encrypt_data($row_fixtures->id);
                $start = $row_fixtures->date;
                $end = $row_fixtures->date;
                
                if(strtotime($row_fixtures->date) < time())
                {
                    $class= 'fc-event-solid-secondary fc-event-light';
                }
                else
                {
                    $class= 'fc-event-success';  
                }
                
                $description =  'Season ' . $row_fixtures->season_id . ', Matchweek ' . $row_fixtures->matchweek . ', Type ' . ucwords(strtolower(str_replace('_',' ' ,$row_fixtures->match_type))) . '.';
                
                $array = array(
                'title'=>$title, 
                'url'=>$url, 
                'start'=>$start, 
                'end'=>$end, 
                'className'=>$class, 
                'description'=>$description, 
                );
                
                $result[] = $array;
                
                
            }
            $data = json_encode($result);
            return $data;
        }
	
	
	
}
?>