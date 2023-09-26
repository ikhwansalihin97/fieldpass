<?php

class Team_m extends CI_Model {

	function __construct(){
		parent::__construct();
	}
	
	function team_listing($search_data = array())
	{
		$data["menu"] = "Clubs";
		$data["menu_item"] = "club_listing";
		$data['title'] = 'Clubs Listing';
		$data['card_title'] = '<span class="card-icon"><i class="fas fa-user"></i></span><h3 class="card-label"> Clubs Listing <small>available clubs</small></h3>';
		$data['breadcrumbs'] = array('Clubs'=>'secure/listing/team');
		
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
                    $where = "WHERE `team_season`.`season_id` = " . $this->db->escape($season_id);
                else
                    $where = '';
                $orderby = "`team`.`id`";
		
		if(is_array($search_data) && sizeof($search_data) > 0){
			
			if(isset($search_data['sql_sort_column']) && $search_data['sql_sort_column'] != "")
			{
				$orderby = $search_data['sql_sort_column'];
			}
			else
			{
				$orderby = "`team`.`id`";
			}
			
			if(!isset($search_data['sql_sort']))
			{
				$search_data['sql_sort'] = "DESC";
			}
			
			if(isset($search_data['filter']) && $search_data['filter'] != "")
			{
				if(isset($search_data['filterBy']) && $search_data['filterBy'] != "")
				{
					if($search_data['filter'] == 'manager')
					{
						$search_data['filter'] = '`team`.`manager`';
					}
					
					$where .= ($where == "" ? " WHERE " : " AND ") . $search_data['filter'] ." = " . $this->db->escape($search_data['filterBy']) . " ";
					
				}
			}
			
			if(isset($search_data['search']) && $search_data['search'] != "")
			{
				$where .= ($where == "" ? " WHERE " : " AND ") . " ( `team`.`name` LIKE " . $this->db->escape("%".$search_data['search']."%") . " OR `team`.`short_name` LIKE " . $this->db->escape("%".$search_data['search']."%")  . " OR `team`.`manager` LIKE " . $this->db->escape("%".$search_data['search']."%") . " ) ORDER BY " .  $orderby . " " . $search_data['sql_sort'] ;
			}
			else
			{
				$where .= "ORDER BY " . $orderby . " " . $search_data['sql_sort'] ;
			}
			
		}
		else
		{
			$where .= "ORDER BY " . $orderby . " DESC";
		}
		
		$sql = "SELECT `team`.`id`,`team`.`image_url`,`team`.`name`,`team`.`short_name`,`team`.`manager`,`team`.`status`, `team_season`.`season_id` FROM `team` LEFT JOIN `team_season` ON `team`.`id` = `team_season`.`team_id` " . $where ;
		$query = $this->db->query($sql);
		
		$data['total_rows'] = $query->num_rows();
		$config['base_url'] = base_url() . 'secure/listing/team/' . $this->uri->segment(4);
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
			$sql_query = "SELECT `team`.`id`,`team`.`image_url`,`team`.`name`,`team`.`short_name`,`team`.`manager`,`team`.`status`, `team_season`.`season_id` FROM `team` LEFT JOIN `team_season` ON `team`.`id` = `team_season`.`team_id` " . $where ;
		}
		else
		{
			$sql_query = "SELECT `team`.`id`,`team`.`image_url`,`team`.`name`,`team`.`short_name`,`team`.`manager`,`team`.`status`, `team_season`.`season_id` FROM `team` LEFT JOIN `team_season` ON `team`.`id` = `team_season`.`team_id` " . $where . $limit ;
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
		
                    $name = '';
                    if($res->image_url != '')
                    {
                        $name = '<div class="symbol mr-3">
                                    <img alt="Pic" src="' . base_url() . $res->image_url . '"/>
                                </div>';
                    }

                    if($res->id != '')
                    {
                        $name .= '<a href="'.base_url().'secure/update_club/'. encrypt_data($res->id) .'">'. $res->name .'</a> <small>[' . $res->short_name . ']</small>';
                    }

//                        ad($name);

                    $action = '<div class="btn-group" role="group" aria-label="Basic example">';

                    $action .= ' <a href="'.base_url().'secure/update_club/'. encrypt_data($res->id) . '" class="btn btn-icon btn-outline-success "><i class="fas fa-pencil-alt"></i></a>';

                    $action .= '</div>';

                    $row = [
                            '#' => $j++,
                            // 'ID' => 'P'.pad_zero($res->id),
                            'Name' => $name,
                            'Short Name' => isset($res->short_name) && $res->short_name != '' ? $res->short_name : '-',
                            'Manager' => isset($res->manager) && $res->manager != '' ? ucwords(strtolower($res->manager)) : '-',
                            'Status' =>isset($res->status) && $res->status != '' && $res->status == 1 ? '<span class="label label-xl label-info label-pill label-inline mr-2">active</span>' : '<span class="label label-xl label-warning label-pill label-inline mr-2">inactive</span>',
                            'Action' => $action,
                    ];

                    $rows[] = $row;
			
		}
	
		if($is_download)
		{
			download_csv($rows, 'clubs_list'.today().'.csv');
			exit;
		}
		
		$filter = [
			'team.manager' => 'Manager',
			// 'team.name' => 'Team',
		];

		$width = [ 
			'#' => 40,
			// 'ID' => 80,
			'Name' => 150,
			'Short Name' => 100,
			'Manager' => 150,
			'Status' => 100,
			'Action' => 100,
		];
		
		$center = [
			'Status',
			'Action'
		];
		
		$data['actions'] = [
			'<a href="javascript:void();" class="btn btn-info download-button mr-2">Download</a>',
			'<a href="'.base_url().'secure/club_form" class="btn btn-info">Add New Club</a>',
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
		'#' => '`team`.`id`',
		'Name' => '`team`.`name`',
		'Short Name' => '`team`.`short_name`',
		'Manager' => '`team`.`manager`',
		'Status' => '`team`.`status`',
		];
		
		/* $center = [
		'#',
		'Value',
		'Position',
		'Action',
		]; */
		
		$data['total'] = $data['total_rows'];
		$data['rows'] = $rows;
		$data['width'] = $width;
		$data['align_center'] = $center;
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
				
				$data['selectFilter'][$columnName][] = ucwords($b->$columnName);
				
			}
		}
		
		$filter = [
			'manager' => 'Manager',
			// 'name' => 'Team',
		];
		
		$data['filter'] = $filter;
		
		return $data;
	}
	
	
	function club_form($post = array(), $files = array())
	{
            /*
            Array
            (
                    [id] => 65
                    [name] => SABAH
                    [manager] => Kurniawan
                    [short_name] => SAB
                    [status] => 1
                    [season] => Array
                            (
                                    [0] => 4
                                    [1] => 6
                            )

            )
            */

            $error = array();
            if(isset($post) && sizeof($post) > 0)
            {
                if(isset($post['name']) && $post['name'] == "" )
                {
                        $response['result'] = false;
                        $response['message'] = "Club name field blank, please fill in to proceed.";
                        $response['input'] = "name";
                        $response['type'] = "input";

                        return $response;
                }

                if(isset($post['short_name']) && $post['short_name'] == "" )
                {
                        $response['result'] = false;
                        $response['message'] = "Club short name field blank, please fill in to proceed.";
                        $response['input'] = "short_name";
                        $response['type'] = "input";

                        return $response;
                }

                if(!isset($post['status']))
                {
                        $response['result'] = false;
                        $response['message'] = "Club status field empty, please choose club status to proceed.";
                        $response['input'] = "status"; 
                        $response['type'] = "select";

                        return $response;
                }


                if(isset($post['manager']) && $post['manager'] == "" )
                {
                        $response['result'] = false;
                        $response['message'] = "Club manager field blank, please fill in to proceed.";
                        $response['input'] = "manager"; 
                        $response['type'] = "input";

                        return $response;
                }



                $db_team = array (
                'name'=>isset($post['name']) && $post['name'] != '' ? $post['name'] :'',
                'short_name'=>isset($post['short_name']) && $post['short_name'] != '' ? $post['short_name'] :'',
                'status'=>isset($post['status']) && $post['status'] != '' ? $post['status'] :'',
                'manager'=>isset($post['manager']) && $post['manager'] != '' ? $post['manager'] :'',
                // 'created_by'=>$this->session->userdata('user_id'),
                'created_at'=>date("Y-m-d H:i:s"),
                // 'modify_by'=>$this->session->userdata('user_id'),
                'updated_at'=>date("Y-m-d H:i:s")
                );


                if(isset($post['id']) && $post['id'] != '')
                {
                        unset($db_team['created_at']);
                        $this->db->where('id', $post['id']);
                        $error[] = $this->db->update('`team`',$db_team);
                        $team_id = $post['id'];
                }
                else
                {
                        $error[] = $this->db->insert('team',$db_team);
                        $team_id = $this->db->insert_id();
                        $post['id'] = $team_id;
                }

                if(isset($post['season']) && is_array($post['season']) && sizeof($post['season']) > 0)
                {

                    $get_all_team_season = $this->db->where('team_id',$post['id'])->get('team_season');

                    foreach($get_all_team_season->result() as $row_season)
                    {
                            if(!in_array($row_season->season_id,$post['season']))
                                    $this->db->delete('team_season', array('id' => $row_season->id));
                    }

                    foreach($post['season'] as $season_value)
                    {
                        $team_season_check = $this->db->where('team_id',$post['id'])->where('season_id',$season_value)->limit(1)->get('team_season');

                        if($team_season_check->num_rows() == 0)//season id and team id does not exist
                        {
                            //insert team and season id into team season tableName
                            $db_season = array(
                                    'team_id'=>$post['id'],
                                    'season_id'=>$season_value,
                            );

                            $error[] = $this->db->insert('team_season',$db_season);
                        }
                    }
                }

                if(isset($error) && in_array(false,$error))
                {
                        $response['result'] = false;

                        $string = 'add';

                        if(isset($post['id']) && $post['id'] != '')
                                $string = 'update';

                        $response['message'] = "Error Occured, Failed to ". $string ." club.";

                        return $response;
                }
                else 
                {  

                    if(isset($files) && sizeof($files) > 0)
                    {
                        $rs = $this->team_image_upload($files, $team_id);
                    }

                }

                $response['result'] = true;

                if(isset($post['id']) && $post['id'] != '')
                {
                        $response['message'] = "Club information successfully updated.";
                }
                else
                {
                        $response['message'] = "New club successfully registered.";
                }
                return $response;
            }
	}
        
        function team_image_upload($files = array(), $team_id)
	{
            $user_id = $this->session->userdata('user_id');

            if(!is_dir("uploads"))
            mkdir("uploads", 0777, TRUE);

            if(!is_dir("uploads/team"))
            mkdir("uploads/team", 0777, TRUE);

            if(!is_dir("uploads/team/" . $team_id))
            mkdir("uploads/team/" . $team_id , 0777, TRUE);

            $config['upload_path'] = "uploads/team/" . $team_id;
            $config['allowed_types'] = 'jpg|jpeg|png|gif';
            $config['max_size'] = '0';

            $this->load->library('upload', $config);

            if(!$this->upload->do_upload("profile_avatar"))
            {
                $upload_error = $this->upload->display_errors();
                return array('result'=>false,'msg'=>$upload_error);

            }
            else
            {
                $upload_data = $this->upload->data();
                
                
                $sql = "SELECT * FROM `team` WHERE `id` = " . $this->db->escape($team_id) . " LIMIT 1";
                $query = $this->db->query($sql);

                if(isset($query) && $query->num_rows() > 0)
                {
                    $image_data = $query->row();

                    if($image_data->image_url != "")
                    {
                        if(file_exists($image_data->image_url))
                        {
                            unlink($image_data->image_url);
                        }
                    }

                }
                
                $upload_data["full_path"] = "uploads/team/" . $team_id . "/". $upload_data["file_name"];
                
                $rs = $this->db->where('id', $team_id)->update('`team`',array('image_url'=>$upload_data["full_path"]));

                if(isset($rs) && $rs == true)
                {
                    return true;
                }
            }
		
	}
	
        public function delete_team_image($post = array())
	{
            if(isset($post) && sizeof($post) > 0)
            {
                $sql = "SELECT * FROM `team` WHERE `id` = " . $this->db->escape($post["team_id"]) . " LIMIT 1";
                $query = $this->db->query($sql);

                if(isset($query) && $query->num_rows() > 0)
                {
                    $image_data = $query->row();

                    if($image_data->image_url != "")
                    {
                        if(file_exists($image_data->image_url))
                        {
                            $rs = $this->db->where('id', $post["team_id"])->update('`team`',array('image_url'=>NULL));
                            unlink($image_data->image_url);
                            return true;
                        }
                    }

                }

                return false;

            }
		
            return;
	}
	
	
	function get_team_formdata($team_id = NULL)
	{
		if($team_id != NULL)
		{
			$sql = "SELECT * FROM `team` WHERE `id` = " . $this->db->escape($team_id) . " LIMIT 1";
			$query = $this->db->query($sql);
			
			return $query->num_rows() > 0 ? $query->row_array() : array();
		}
		
		return array();
		
	}
	
	public function get_team($team_id = NULL)
	{
		if($team_id != NULL)
			$sql = "SELECT * FROM `team` WHERE `id` = " . $this->db->escape($team_id) . " LIMIT 1";
		else
			$sql = "SELECT * FROM `team` ORDER BY `team`.`name` ASC";
		
		$query = $this->db->query($sql);
		
		return $query->result() > 0 ? $query->result() : array();
	}
	
	
}
?>