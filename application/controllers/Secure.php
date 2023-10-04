<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Secure extends CI_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see https://codeigniter.com/userguide3/general/urls.html
	 */
	function __construct(){
		parent::__construct();
		
		
            if($this->uri->segment(2) == "listing" && $this->input->post())
            {
                    $search_data = array(
                            'search' => trim($this->input->post('search_name')),
                            'extra_filter' => trim($this->input->post('extra_filter')),
                            'date_filter' => trim($this->input->post('date_filter')),
                            'filter' => trim($this->input->post('filter')),
                            'filterBy' => trim($this->input->post('filterBy')),
                            'sql_sort_column' => trim($this->input->post('sql_sort_column')),
                            'sql_sort' => trim($this->input->post('sql_sort')),
                            'download' => trim($this->input->post('download'))
                    );


                    redirect('secure/listing/'. $this->uri->segment(3) .'/'.encrypt_data($search_data));
            }
            
            if($this->uri->segment(2) == "update_club" && $this->input->post())
            {
                $search_data = array(
                    'search' => trim($this->input->post('search_name')),
                    'extra_filter' => trim($this->input->post('extra_filter')),
                    'date_filter' => trim($this->input->post('date_filter')),
                    'filter' => trim($this->input->post('filter')),
                    'filterBy' => trim($this->input->post('filterBy')),
                    'sql_sort_column' => trim($this->input->post('sql_sort_column')),
                    'sql_sort' => trim($this->input->post('sql_sort')),
                    'download' => trim($this->input->post('download'))
                );


                redirect('secure/update_club/'. $this->uri->segment(3) .'/'.encrypt_data($search_data));
            }
	}
	
	public function index()
	{
            redirect('secure/dashboard');
	}
	
	public function dashboard()
	{
		
		$data['title'] = 'Dashboard';
		$data['brief'] = 'Liga Kita Dashboard';
		$data['menu'] = 'dashboard';
                
                $data['match_calendar'] = $this->Match_m->match_calendar_data();
                
		$this->load->view('secure/dashboard/dashboard_v',$data);
	}
	
	
	function listing($modelKey = NULL, $encrypted = "")
	{
		if($encrypted == "")
		{
			$encrypted = encrypt_data(array());
			redirect('secure/listing/'. $modelKey .'/'. $encrypted);
		}
		else
		{	
                    $search_data = decrypt_data($encrypted);

                    if(is_array($search_data))
                    {
                            if(isset($search_data['sql_sort_column']) != '') 
                            {
                                    if($search_data['sql_sort'] == 'up')
                                    {
                                            $search_data['sql_sort'] = 'ASC';
                                    }
                                    else
                                    {
                                            $search_data['sql_sort'] = "DESC";
                                    }
                            }


                            $key = $modelKey;

                            $models = [
                                    'player' => 'Players_m',
                                    'team' => 'Team_m',
                                    'match' => 'Match_m',
                            ];

                            $model = $models[$key];

                            $method = $key.'_listing';

                            $data = $this->$model->$method($search_data);

                            if(isset($search_data['sql_sort_column']) != '') 
                            {
                                    if($search_data['sql_sort'] == 'ASC')
                                    {
                                            $search_data['sql_sort'] = 'down';
                                    }
                                    else
                                    {
                                            $search_data['sql_sort'] = "up";
                                    }
                            }

                            $data['search_data'] = $search_data;
                    }
                    else
                    {
                            redirect('secure/listing/'. $modelKey .'/'. $encrypted);
                    }
		}
		
		if($key != 'match')
                    $this->load->view('secure/dashboard/listing_v', $data);
		else
                    $this->load->view('secure/dashboard/match_listing_v', $data);
	}
	
	function player_form()
	{
		$data["menu"] = "Players";
		$data["sub_menu"] = "player_form";
		$data["menu_item"] = "player_form";
		$data['title'] = 'Player Form';
		$data['card_title'] = '<span class="card-icon"><i class="fas fa-user"></i></span> Player Form';
		$data['breadcrumbs'] = array('Players'=>'secure/listing/player','New Player'=>'secure/player_form');
		
		if($this->input->is_ajax_request())
		{		
			$response = $this->Players_m->player_form($this->input->post(),$_FILES);
			
			$data['form_data'] = $this->input->post();
			
			if(isset($response['result']) && $response['result'] != false)
				$response['result'] = 'success';
			else
				$response['result'] = 'failed';
			
			echo json_encode($response);
			return;
		}
		
		$data['team'] = $this->Team_m->get_team();
                
                $this->load->view('secure/dashboard/player_form_v.php', $data);
	}
	
	function player_quick_update()
	{
		if($this->input->is_ajax_request())
		{	
			$response = $this->Players_m->player_quick($this->input->post());
			
			if(isset($response['result']) && $response['result'] != false)
				$response['result'] = 'success';
			else
				$response['result'] = 'failed';
			
			
			
			echo json_encode($response);
			return;
		}
	}
	
	function update_player($encrypted_playerid = NULL)
	{
		
		if($encrypted_playerid != NULL)
		{
                    $player_id = decrypt_data($encrypted_playerid);

                    $result = check_by_id($player_id, 'player');

                    if($result == false)
                    {
                            set_toastr_message('Error occured, player id missing.','error');
                            redirect('secure/listing/player');
                    }

                    $data['form_data'] = $this->Players_m->get_player_formdata($player_id);

                    $data["menu"] = "Players";
                    $data["sub_menu"] = "player_form";
                    $data["menu_item"] = "update_player_form";
                    $data['title'] = 'Update Player Form';
                    $data['card_title'] = '<span class="card-icon"><i class="fas fa-user"></i></span>Update Player Form';
                    $data['breadcrumbs'] = array('Players'=>'secure/listing/player','Update Player'=>'secure/player_form');
                    $data['team'] = $this->Team_m->get_team();
                    
                    $data['match_history'] = $this->Players_m->player_match_history($player_id);
                    
                    $this->load->view('secure/dashboard/player_form_v.php', $data);
		}
	}
	
	function bulk_player()
	{
		$data["menu"] = "Players";
		$data["sub_menu"] = "player_form";
		$data["menu_item"] = "bulk_player";
		$data['title'] = 'Player Bulk Upload';
		$data['card_title'] = '<span class="card-icon"><i class="fas fa-user"></i></span> Player Bulk Upload';
		$data['breadcrumbs'] = array('Players'=>'secure/listing/player','Player Bulk Upload'=>'secure/bulk_player');
		
		if($this->input->is_ajax_request())
		{		
			$tableData = $this->Players_m->bulk_player($_FILES);
			
			$response['result'] = 'info';
			$response['tableData'] = $tableData;
			
			echo json_encode($response);
			return;
		}
		
		$data['team'] = $this->Team_m->get_team();
		
		$this->load->view('secure/dashboard/bulk_player_v.php', $data);
	}
	
	
	function club_form()
	{
		$data["menu"] = "Clubs";
		$data["sub_menu"] = "club_form";
		$data["menu_item"] = "club_form";
		$data['title'] = 'Club Form';
		$data['card_title'] = '<span class="card-icon"><i class="fas fa-shield-alt"></i></span> Club Form';
		$data['breadcrumbs'] = array('Clubs'=>'secure/listing/team','New Player'=>'secure/club_form');
		
		if($this->input->is_ajax_request())
		{		
			$response = $this->Team_m->club_form($this->input->post(),$_FILES);
			
			$data['form_data'] = $this->input->post();
			
			if(isset($response['result']) && $response['result'] != false)
				$response['result'] = 'success';
			else
				$response['result'] = 'failed';
			
			echo json_encode($response);
			return;
		}
		
		$data['season'] = get_all_season();
		
		$this->load->view('secure/dashboard/club_form_v.php', $data);
	}
	
	function update_club($encrypted_id = NULL, $encrypted = NULL)
	{
            
            if($encrypted_id != NULL)
            {

                $team_id = decrypt_data($encrypted_id);

                $result = check_by_id($team_id, 'team');

                if($result == false)
                {
                        set_toastr_message('Error occured, team id missing.','error');
                        redirect('secure/listing/team');
                }

                if($encrypted == "")
                {
                        $encrypted = encrypt_data(array());
                        redirect('secure/update_club/'. $encrypted_id .'/'. $encrypted);
                }
                else
                {

                    $search_data = decrypt_data($encrypted);

                    if(is_array($search_data))
                    {
                            if(isset($search_data['sql_sort_column']) != '') 
                            {
                                    if($search_data['sql_sort'] == 'up')
                                    {
                                            $search_data['sql_sort'] = 'ASC';
                                    }
                                    else
                                    {
                                            $search_data['sql_sort'] = "DESC";
                                    }
                            }

                        $data['player_list'] = $this->Players_m->get_club_player($team_id,$search_data);

                        if(isset($search_data['sql_sort_column']) != '') 
                        {
                                if($search_data['sql_sort'] == 'ASC')
                                {
                                        $search_data['sql_sort'] = 'down';
                                }
                                else
                                {
                                        $search_data['sql_sort'] = "up";
                                }
                        }

                        $data['search_data'] = $search_data;

                        //ad($data['player_list']);
                        //exit();
                    }

                }

                $data['form_data'] = $this->Team_m->get_team_formdata($team_id);

                $data["menu"] = "Clubs";
                $data["sub_menu"] = "club_form";
                $data["menu_item"] = "update_club_form";
                $data['title'] = 'Update Club Form';
                $data['card_title'] = '<span class="card-icon"><i class="fas fa-shield-alt"></i></span>Update Club Form';
                $data['breadcrumbs'] = array('Clubs'=>'secure/listing/team','Update Club'=>'secure/club_form');
                $data['season'] = get_all_season();
                $data['team_season'] = get_team_season_by_team_id($team_id);



                $this->load->view('secure/dashboard/club_form_v.php', $data);
            }
	}
	
	function update_match($encrypted_id = NULL)
	{
		
		if($encrypted_id != NULL)
		{
			$fixtures_id = decrypt_data($encrypted_id);
			
			$result = check_by_id($fixtures_id, 'fixtures');

			if($result == false)
			{
				set_toastr_message('Error occured, match id missing.','error');
				redirect('secure/listing/match');
			}
			
			$data['form_data'] = $this->Match_m->get_match_formdata($fixtures_id);
			
			$data['home_team_info'] = $this->Match_m->get_team_name($data['form_data']['home_team_id']);
			$data['away_team_info'] =  $this->Match_m->get_team_name($data['form_data']['away_team_id']);
			
			$data['action_history'] = $this->Match_m->get_actions_history($fixtures_id);
			$data['first_team'] = $this->Match_m->get_first_team($fixtures_id);
			$data['player_involved'] = $this->Match_m->get_player_involved($data['action_history']);
			
			$data['home_player'] = $this->Match_m->get_team_player($data['form_data']['home_team_id']);
			$data['away_player'] = $this->Match_m->get_team_player($data['form_data']['away_team_id']);
			
			$data['disabled_team_change'] = 'disabled';
			
			$data['available_home_subs'] = array();
			$data['available_away_subs'] = array();
			
			if(in_array($data['form_data']['status'],array('history','ongoing')))
			{				
				foreach($data['home_player'] as $home_key=>$home_value)
				{
					
					if(array_key_exists($home_value->id,$data['player_involved']))
					{
						if($data['player_involved'][$home_value->id]->first_team != 1)
							unset($data['home_player'][$home_key]);
					}
					else
					{
						$data['available_home_subs'][] = $data['home_player'][$home_key];
						unset($data['home_player'][$home_key]);
					}
				}
				
				foreach($data['away_player'] as $away_key=>$away_value)
				{
					
					if(array_key_exists($away_value->id,$data['player_involved']))
					{
						if($data['player_involved'][$away_value->id]->first_team != 1)
							unset($data['away_player'][$away_key]);
					}
					else
					{
						$data['available_away_subs'][] = $data['away_player'][$away_key];
						unset($data['away_player'][$away_key]);
					}
				}
			}
			
			$data["menu"] = "Leagues";
			$data["sub_menu"] = "match_form";
			$data["menu_item"] = "update_match_form";
			$data['title'] = 'Update Match Form';
			$data['card_title'] = '<span class="card-icon"><i class="fas fa-trophy"></i></span>Update Match Form';
			$data['breadcrumbs'] = array('Matches'=>'secure/listing/match','Update Match'=>'secure/update_match/' . $encrypted_id);
			$data['season'] = get_all_season();
			$data['team'] = $this->Team_m->get_team();
			
			$this->load->view('secure/dashboard/match_form_v.php', $data);
		}
	}
	
	
	function match_form()
	{
		if($this->input->is_ajax_request())
		{	
			$response = $this->Match_m->match_form($this->input->post());
			
			$data['form_data'] = $this->input->post();
			
			if(isset($response['result']) && $response['result'] != false)
				$response['result'] = 'success';
			else
				$response['result'] = 'failed';
			
			echo json_encode($response);
			return;
		}
		
		$data["menu"] = "Leagues";
		$data["sub_menu"] = "match_form";
		$data["menu_item"] = "match_form";
		$data['title'] = 'Match Form';
		$data['card_title'] = '<span class="card-icon"><i class="fas fa-trophy"></i></span>Match Form';
		$data['breadcrumbs'] = array('Matches'=>'secure/listing/match','New Match'=>'secure/match_form/');
		$data['season'] = get_all_season();
		$data['team'] = $this->Team_m->get_team();
		$data['disabled_team_change'] = '';
		
		$this->load->view('secure/dashboard/match_form_v.php', $data);
	}
	
	function delete_action()
	{
		if($this->input->is_ajax_request())
		{	
			$response = $this->Match_m->delete_action($this->input->post());
			
			$data['form_data'] = $this->input->post();
			
			if(isset($response['result']) && $response['result'] != false)
				$response['result'] = 'success';
			else
				$response['result'] = 'failed';
			
			echo json_encode($response);
			return;
		}
		
		redirect('dashboard');
	}
	
	function check_fixtures($fixture_id = NULL)
	{
		if($fixture_id != NULL)
		{
			$fixture = $this->db->where('id',$fixture_id)->limit(1)->get('fixtures')->row();
			
			ad($fixture);
			
			$decode = json_decode($fixture->actions);
			
			ad($decode);
			
			$decode_home = json_decode($decode->home);
			$decode_away = json_decode($decode->away);

			ad($decode_home);
			ad($decode_away);
			
		}
		else
		{
			echo 'no fixture id<br>';
		}
		
		exit('end');
	}
	
	function delete_match()
	{
		if($this->input->is_ajax_request())
		{	
			$response = $this->Match_m->delete_fixture($this->input->post('id'));
			
			if(isset($response['result']) && $response['result'] != false)
				$response['result'] = 'success';
			else
				$response['result'] = 'failed';
			
			echo json_encode($response);
			return;
		}
		
		redirect('dashboard');
	}

}
