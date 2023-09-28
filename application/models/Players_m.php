<?php

class Players_m extends CI_Model {

	function __construct(){
		parent::__construct();
	}
	
	function player_listing($search_data = array())
	{
		$data["menu"] = "Players";
		$data["menu_item"] = "player_listing";
		$data['title'] = 'Player Listing';
		$data['card_title'] = '<span class="card-icon"><i class="fas fa-user"></i></span><h3 class="card-label"> Player Listing <small>available players</small></h3>';
		$data['breadcrumbs'] = array('Players'=>'secure/listing/player');
		
		$is_download = (isset($search_data['download']) && $search_data['download'] == 'true');
		
		$where = "";
		$orderby = "`player`.`id`";
		
		if(is_array($search_data) && sizeof($search_data) > 0){
			
			if(isset($search_data['sql_sort_column']) && $search_data['sql_sort_column'] != "")
			{
				$orderby = $search_data['sql_sort_column'];
			}
			else
			{
				$orderby = "`player`.`id`";
			}
			
			if(!isset($search_data['sql_sort']))
			{
				$search_data['sql_sort'] = "DESC";
			}
			
			if(isset($search_data['filter']) && $search_data['filter'] != "")
			{
				if(isset($search_data['filterBy']) && $search_data['filterBy'] != "")
				{
					if($search_data['filter'] == 'position')
					{
						$search_data['filter'] = '`player`.`position`';
					}
					
					if($search_data['filter'] == 'name')
					{
						$search_data['filter'] = '`team`.`name`';
					}
					
					$where .= ($where == "" ? " WHERE " : " AND ") . $search_data['filter'] ." = " . $this->db->escape($search_data['filterBy']) . " ";
					
				}
			}
			
			if(isset($search_data['search']) && $search_data['search'] != "")
			{
				$where .= ($where == "" ? " WHERE " : " AND ") . " ( `player`.`name` LIKE " . $this->db->escape("%".$search_data['search']."%") . " OR `player`.`short_name` LIKE " . $this->db->escape("%".$search_data['search']."%")  . " OR LOWER(`player`.`name`) LIKE " . $this->db->escape("%".$search_data['search']."%") . " OR LOWER(`player`.`short_name`) LIKE " . $this->db->escape("%".$search_data['search']."%") . " ) ORDER BY " .  $orderby . " " . $search_data['sql_sort'] ;
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
		
		$sql = "SELECT `player`.`id`,`player`.`name`,`player`.`value`,`player`.`team`,`player`.`jersey_number`,`player`.`position`,`player`.`team_id`,`team`.`name` as `team_name` FROM `player` LEFT JOIN `team` ON `player`.`team_id` = `team`.`id` " . $where ;
		$query = $this->db->query($sql);
		
		$data['total_rows'] = $query->num_rows();
		$config['base_url'] = base_url() . 'secure/listing/player/' . $this->uri->segment(4);
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
			$sql_query = "SELECT `player`.`id`,`player`.`name`,`player`.`value`,`player`.`team`,`player`.`jersey_number`,`player`.`position`,`player`.`team_id`,`team`.`name` as `team_name` FROM `player` LEFT JOIN `team` ON `player`.`team_id` = `team`.`id` " . $where ;
		}
		else
		{
			$sql_query = "SELECT `player`.`id`,`player`.`name`,`player`.`value`,`player`.`team`,`player`.`jersey_number`,`player`.`position`,`player`.`team_id`,`team`.`name` as `team_name` FROM `player` LEFT JOIN `team` ON `player`.`team_id` = `team`.`id` " . $where . $limit ;
		}
		
		// ad($sql_query);
		// exit();
		
		$data['query'] = $this->db->query($sql_query);
		
		$result = $data['query']->result();
		
		// ad($result);
		
		// $player_ids = array_column($result, 'id');
		
		$rows = [];
		
		$data['team'] = $this->Team_m->get_team();
		
		if($this->uri->segment(5) == "")
		{
			$j = 1;
			
		}
		else
		{
			$j = $this->uri->segment(5)+1;
		}
		
		foreach($result as $i=>$res){
			
			if($res->id != '')
			{
				$name = '<input class="form-control quickName" type="text" name="name" value="'.ucwords(strtolower($res->name)).'" id="'.$res->id.'">';
			}
			
			$position = '<select class="form-control quickPosition" name="position"  id="'.$res->id.'"><option disabled selected >Choose position</option>';
			$position .= isset($res->position) && $res->position == 'GK' ? '<option value="GK" selected > GK </option>' : '<option value="GK"> GK </option>' ;							
			$position .= isset($res->position) && $res->position == 'DF' ? '<option value="DF" selected > DF </option>' : '<option value="DF"> DF </option>' ;							
			$position .= isset($res->position) && $res->position == 'MF' ? '<option value="MF" selected > MF </option>' : '<option value="MF"> MF </option>' ;							
			$position .= isset($res->position) && $res->position == 'ST' ? '<option value="ST" selected > ST </option>' : '<option value="ST"> ST </option>' ;							
			$position .='</select>';
			

			$team = '<select class="form-control quickTeam" name="team_id"  id="'.$res->id.'"><option disabled selected >Choose team</option>';
			foreach($data['team'] as $team_row)
				$team .= isset($res->team_id) && $res->team_id == $team_row->id  ? '<option value="'.$team_row->id.'" selected> '. $team_row->name .'</optiom>' : '<option value="'.$team_row->id.'">'.$team_row->name.'</option>';
			$team .='</select>';
			
			$action = '<div class="btn-group" role="group" aria-label="Basic example">';
			
			// $action .= ' <button type="button" id="submit_'. $res->id . '" class="btn btn-icon btn-primary quick_update"><i class="fas fa-bolt"></i></button>';
			$action .= ' <a href="'.base_url().'secure/update_player/'. encrypt_data($res->id) . '" class="btn btn-icon btn-success "><i class="fas fa-user-edit"></i></a>';
			
			$action .= '</div>';
			
			$row = [
				'#' => $j++,
				// 'ID' => 'P'.pad_zero($res->id),
				'Name' => $name,
				'Value' => isset($res->value) && $res->value != '' ? '<input class="form-control quickValue" type="number" min="1" max="100" name="value" value="'.$res->value.'" id="'.$res->id.'">' : '-',
				'Position' => $position,
				'Team' =>$team,
				'Action' => $action,
			];

			$rows[] = $row;
			
		}
	
		if($is_download)
		{
			download_csv($rows, 'players_list'.today().'.csv');
			exit;
		}
		
		$filter = [
			'player.position' => 'Position',
			'team.name' => 'Team',
		];

		$width = [ 
			'#' => 40,
			// 'ID' => 80,
			'Name' => 150,
			'Value' => 100,
			'Position' => 100,
			'Team' => 100,
			'Action' => 100,
		];
		
		$data['actions'] = [
			'<a href="javascript:void();" class="btn btn-info download-button mr-2">Download</a>',
			'<a href="'.base_url().'secure/player_form" class="btn btn-info">Add New Player</a>',
		];
		
		$sort = [
		'#' => '`player`.`id`',
		'Name' => '`player`.`name`',
		'Value' => '`player`.`value`',
		'Position' => '`player`.`position`',
		'Team' => '`team`.`name`',
		];
		
		$center = [
		// '#',
		// 'Value',
		// 'Position',
		'Action',
		];
		
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
			'position' => 'Position',
			'name' => 'Team',
		];
		
		$data['filter'] = $filter;
		
		return $data;
	}
	
	
	function player_form($post = array(), $files = array())
	{
		
                //ad($post);
                //ad($files);
                //exit();
		/* Array
		(
			[id] => 
			[name] => Ikhwan Salihin
			[position] => GK
			[value] => 90
			[team_id] => 46
			[jersey_number] => 10
			[image_url] => https://johorsoutherntigers.my/wp-content/uploads/1997/03/SAFAWI-1-325x400.png
			[status] => 1
			
		) */
		
		$error = array();
		if(isset($post) && sizeof($post) > 0)
		{
			if(isset($post['name']) && $post['name'] == "" )
			{
				$response['result'] = false;
				$response['message'] = "Player name field blank, please fill in to proceed.";
				$response['input'] = "name";
				$response['type'] = "input";
				
				return $response;
			}
			
			if(!isset($post['position']))
			{
				$response['result'] = false;
				$response['message'] = "Player position field empty, please choose player position to proceed.";
				$response['input'] = "position"; 
				$response['type'] = "select";
				
				return $response;
			}
			
			
			if(isset($post['value']) && $post['value'] == "" )
			{
				$response['result'] = false;
				$response['message'] = "Player value field blank, please fill in to proceed.";
				$response['input'] = "value"; 
				$response['type'] = "input";
				
				return $response;
			}
			
			if(!isset($post['team_id']))
			{
				$response['result'] = false;
				$response['message'] = "Player team field empty, please choose player team to proceed.";
				$response['input'] = "team_id"; 
				$response['type'] = "select";
				
				return $response;
			}
			
			if(isset($post['jersey_number']) && $post['jersey_number'] == "" )
			{
				$response['result'] = false;
				$response['message'] = "Player jersey number field blank, please fill in to proceed.";
				$response['input'] = "jersey_number"; 
				$response['type'] = "input";
				
				return $response;
			}
			
			if(isset($post['identity_number']) && $post['identity_number'] == "" )
			{
                            $response['result'] = false;
                            $response['message'] = "Player identity number  field blank, please fill in to proceed.";
                            $response['input'] = "identity_number"; 
                            $response['type'] = "input";

                            return $response;
			}
                        else
                        {
                           if(!preg_match("/^\d{6}-\d{2}-\d{4}$/", trim($post["identity_number"]))) 
                           {
                                $response['result'] = false;
                                $response['message'] = "Player identity number format is incorrect, please fix field to proceed.";
                                $response['input'] = "identity_number"; 
                                $response['type'] = "input";

                                return $response;
                            }
                            else
                            {
                                $explode =  explode('-',$post["identity_number"]);
                                $dob = '19' . substr($explode[0], 0, 2) . '-' . substr($explode[0], 2, 2) . '-' . substr($explode[0], 4, 2);
                            }
                        }
			
			if(isset($post['id']) && $post['id'] == '')
			{
                            $check_player = $this->db->where('name',$post['name'])->where('team_id',$post['team_id'])->limit(1)->get('player');

                            if($check_player->num_rows() > 0)
                            {
                                $sql_team = "SELECT * FROM `team` WHERE `id` = " . $this->db->escape($post['team_id']) . " LIMIT 1";
                                $query_team = $this->db->query($sql_team);

                                if($query_team->num_rows() > 0)
                                {
                                        $team_data = $query_team->row();
                                        $response['message'] = "Player " . $post['name'] . ' from ' . $team_data->name . ' already existed.';
                                }

                                $response['result'] = false;

                                return $response;
                            }
			}
			
			$team_data = $this->db->where('id',$post['team_id'])->limit(1)->get('team')->row();
			
			$team = array();
			
			if(isset($team_data->id) && $team_data->id != '')
			{
				$team = array(
				'id'=>isset($team_data->id) && $team_data->id != '' ? $team_data->id :'',
				'name'=>isset($team_data->name) && $team_data->name != '' ? $team_data->name :'',
				'image_url'=>isset($team_data->image_url) && $team_data->image_url != '' ? $team_data->image_url :'',
				'short_name'=>isset($team_data->short_name) && $team_data->short_name != '' ? $team_data->short_name :'',
				'official_name'=>isset($team_data->official_name) && $team_data->official_name != '' ? $team_data->official_name :'',
				);
				
			}
			
			$db_player = array (
			'name'=>isset($post['name']) && $post['name'] != '' ? $post['name'] :'',
			'position'=>isset($post['position']) && $post['position'] != '' ? $post['position'] :'',
			'value'=>isset($post['value']) && $post['value'] != '' ? $post['value'] :'',
			'team_id'=>isset($post['team_id']) && $post['team_id'] != '' ? $post['team_id'] :'',
			'jersey_number'=>isset($post['jersey_number']) && $post['jersey_number'] != '' ? $post['jersey_number'] :'',
			'identity_number'=>isset($post['identity_number']) && $post['identity_number'] != '' ? $post['identity_number'] :'',
                        'dob'=>$dob != '' ? $dob : '',    
			'team'=>json_encode($team),
			// 'create_by'=>$this->session->userdata('user_id'),
			// 'create_date'=>date("Y-m-d H:i:s"),
			// 'modify_by'=>$this->session->userdata('user_id'),
			// 'modify_date'=>date("Y-m-d H:i:s")
			);
			
			
			if(isset($post['id']) && $post['id'] != '')
			{
				$player = $this->db->where('id',$post['id'])->limit(1)->get('player')->row();
				
				if($player->position != $post['position'])
				{
					$response['result'] = false;
					$response['message'] = "Unable to change player position in the middle of season.";
					return $response;
				}
				// unset($db_player['create_by']);
				// unset($db_player['create_date']);
				$this->db->where('id', $post['id']);
				$error[] = $this->db->update('`player`',$db_player);
				$player_id = $post['id'];
			}
			else
			{
				$error[] = $this->db->insert('player',$db_player);
				$player_id = $this->db->insert_id();
			}
			
			if(isset($error) && in_array(false,$error))
			{
				$response['result'] = false;
				
				$string = 'add';
				
				if(isset($post['id']) && $post['id'] != '')
					$string = 'update';
				
				$response['message'] = "Error Occured, Failed to ". $string ." player.";
				
				return $response;
			}
                        else 
                        {  
                            if(isset($files) && sizeof($files) > 0)
                            {
                                $rs = $this->user_image_upload($files, $player_id, $player->team_id);
                            }
                            
                        }
                        
                        $response['result'] = true;
			
			if(isset($post['id']) && $post['id'] != '')
			{
                            $response['message'] = "Player information successfully updated.";
			}
			else
			{
                            $response['message'] = "New player successfully registered.";
			}
                        
			return $response;
		}
                else
                {
                    $response['result'] = false;
                    $response['message'] = "Error occured, please try again later.";
                }
	}
        
     

    function user_image_upload($files = array(), $player_id, $team_id) {
        $user_id = $this->session->userdata('user_id');

        if (!is_dir("uploads"))
            mkdir("uploads", 0777, TRUE);


        if (!is_dir("uploads/player/"))
            mkdir("uploads/player/", 0777, TRUE);
        
            if(!is_dir("uploads/player/".$team_id))
            mkdir("uploads/player/".$team_id, 0777, TRUE);


        $config['upload_path'] = "uploads/player/".$team_id;
        $config['allowed_types'] = 'jpg|jpeg|png|gif';
        $config['max_size'] = '0';

            $this->load->library('upload', $config);

        if (!$this->upload->do_upload("profile_avatar",$player_id)) {

            $upload_error = $this->upload->display_errors();
            return array('result' => false, 'msg' => $upload_error);
        } else {
            $upload_data = $this->upload->data();
                
                $sql = "SELECT * FROM `player` WHERE `id` = " . $this->db->escape($player_id) . " LIMIT 1";
                $query = $this->db->query($sql);

                if(isset($query) && $query->num_rows() > 0)
                {
                    $image_data = $query->row();
                    $image_data = str_replace('https://'.$_SERVER['SERVER_NAME'], '', $image_data);
echo $image_data;die;
                    if($image_data->image_url != "")
                    {
                        if(file_exists($image_data->image_url))
                        {
                            unlink($image_data->image_url);
                        }
                    }

                }
                
                $upload_data["full_path"] = 'https://'.$_SERVER['SERVER_NAME']."/uploads/player/".$team_id."/" . $player_id . "/". $upload_data["file_name"];
                $rs = $this->db->where('id', $player_id)->update('`player`',array('image_url'=>$upload_data["full_path"]));

                if(isset($rs) && $rs == true)
                {
                    return true;
                }
            }
		
	}
	
        public function delete_user_image($post = array())
	{
            if(isset($post) && sizeof($post) > 0)
            {
                $sql = "SELECT * FROM `player` WHERE `id` = " . $this->db->escape($post["player_id"]) . " LIMIT 1";
                $query = $this->db->query($sql);

                if(isset($query) && $query->num_rows() > 0)
                {
                        $image_data = $query->row();

                        if($image_data->image_url != "")
                        {
                            if(file_exists($image_data->image_url))
                            {
                                $rs = $this->db->where('id', $post["player_id"])->update('`player`',array('image_url'=>NULL));
                                unlink($image_data->image_url);
                                return true;
                            }
                        }

                }

                return false;

            }
		
            return;
	}
        
	
	function get_player_formdata($player_id = NULL)
	{
		if($player_id != NULL)
		{
			$sql = "SELECT * FROM `player` WHERE `id` = " . $this->db->escape($player_id) . " LIMIT 1";
			$query = $this->db->query($sql);
			
			return $query->num_rows() > 0 ? $query->row_array() : array();
		}
		
		return array();
		
	}
	
	function bulk_player($files = array())
	{
            if(isset($files['bulk_player']) && is_array($files['bulk_player']) && sizeof($files['bulk_player']) > 0 )
            {
                if($files['bulk_player']['type'] == "application/vnd.ms-excel" || $files['bulk_player']['type'] == "application/vnd.openxmlformats-officedocument.spreadsheetml.sheet" || $files['bulk_player']['type'] == "text/csv")
                {

                        if(!is_dir("uploads"))
                        mkdir("uploads", 0777, TRUE);

                        if(!is_dir("uploads/temporary"))
                        mkdir("uploads/temporary", 0777, TRUE);

                        if(!is_dir("uploads/temporary/bulk_upload"))
                        mkdir("uploads/temporary/bulk_upload", 0777, TRUE);

                        $config['upload_path'] = "uploads/temporary/bulk_upload";
                        $config['allowed_types'] = '*';
                        $config['max_size'] = '0';
                        $config['max_width'] = '0'; /* max width of the image file */
                        $config['max_height'] = '0'; /* max height of the image file */
                        $config['file_name'] = $files['bulk_player']['name'];

                        $this->load->library('upload', $config);
                        $this->upload->initialize($config);
                        if (!$this->upload->do_upload('bulk_player'))
                        {
                                $params = array('error' => $this->upload->display_errors());
                                set_message($params['error'] . ' filename =>' . $files['bulk_player']['name'] ,'danger');
                                return false;
                        }
                        else
                        {
                                $upload_data = array('upload_data' => $this->upload->data());
                        }

                        $tableString =  $this->excel_upload($upload_data['upload_data']['full_path']);

                }

                delete_files('./uploads/temporary/bulk_upload', TRUE);

                return $tableString;

            }
            else
            {
                    $response['result'] = false;
                    $response['message'] = "No file were uploaded, please choose one file to proceed.";
                    $response['input'] = "value"; 
                    return $response;
            }
	}
	
	public function excel_upload($files)
	{	
		if(file_exists($files))
		{
			set_time_limit(0);
			include APPPATH . 'libraries/PHPExcel/PHPExcel.php';
			$objPHPExcel = PHPExcel_IOFactory::load($files);

			$dataArr = array();

			foreach ($objPHPExcel->getWorksheetIterator() as $worksheet)
			{
				$worksheetTitle     = $worksheet->getTitle();
				$highestRow         = $worksheet->getHighestRow(); // e.g. 10
				$highestColumn      = $worksheet->getHighestColumn(); // e.g 'F'
				$highestColumnIndex = PHPExcel_Cell::columnIndexFromString($highestColumn);

				for ($row = 3; $row <= $highestRow; ++ $row) {
					for ($col = 0; $col < $highestColumnIndex; ++ $col) {
						$cell = $worksheet->getCellByColumnAndRow($col, $row);
						$val = $cell->getValue();
						$dataArr[$row][$col] = $val;
					}
				}
			}
			
                        
//                        ad($dataArr);
//                        exit();

			$error = array();
			$insert = array();
			#$keyArray = array('Name','Value','Position','Team ID','Jersey Number','Image URL');
                        $keyArray = array('Excel ID','Fullname','Age','Identification Card','Jersey Number','Position','FP','Team','Image Link','Nickname');
			$insertBatch = [];
			$countRow = 0;
			foreach($dataArr as $key=>$row)
			{
				$countRow++;
                                
				$error_string = '';
				
                                //SCL template must have, Name, Age, IC, Jersey, Position, Team;
				if($row[1] == '' || $row[2] == '' || $row[3] == '' || $row[4] == '' || $row[5] == '' || $row[7] == '')
				{
					$errorKey = array();
					
					for($i=0; $i <= 9; $i++)
					{
						if($row[$i] == '')
						{
							$errorKey[] = $keyArray[$i]; 
						}
					}
					
					$error_string .= implode(',',$errorKey) . ' field is empty';
					$row['feedback'] = $error_string;
					$row['row'] = $countRow;
					
					$error[] = $row;
				}
				else
				{
                                    //first try to change full name to short name
                                    $desired_name = $this->short_name($row[1]);

                                     $basic_pos = array("GK", "DF", "MF", "ST");
                                        if(!in_array(trim($row[5]),$basic_pos))
                                        {
                                             $response['result'] = false;
                                            $response['message'] = "Invalid Position: ".trim($row[5]);
                                            $response['input'] = "position"; 
                                            $response['type'] = "input";

                                            return $response;
                                        }
                                    $basic_position = $this->basic_position(trim($row[5]));
                                    
                                    $value = $row[6] * 10;
                                    
                                    
                                    $team_exist = true;
                                    
                                    $sql_team = "SELECT * FROM `team` WHERE `name` = " . $this->db->escape($row[7]) . " LIMIT 1";
                                    $query = $this->db->query($sql_team);
                                    
                                    if($query->num_rows() == 0)//team id not found
                                    {
                                            $response['result'] = false;
                                         $response['message'] = "Team not found: ".$this->db->escape($row[7]);
                                         $response['input'] = "team_id"; 
                                         $response['type'] = "input";

                                         return $response;
                                         
                                            //insert the team
                                            $team_name = explode(' ',$row[7]);
                                            
                                            $short_team_name = '';
                                            foreach($team_name as $row_team_name)
                                            {
                                                if($row_team_name == 'FC')
                                                {
                                                    $short_team_name .= $row_team_name;
                                                }
                                                else
                                                {
                                                    $short_team_name .= substr($row_team_name, 0, 1);
                                                }
                                            }
                                            
                                            $db_team = array(
                                            'name'=>isset($row[7]) && $row[7] != '' ? strtoupper($row[7]) :'',
                                            'short_name'=>isset($short_team_name) && $short_team_name != '' ? strtoupper($short_team_name) :'',
                                            'status'=>1,
                                            'created_at'=>date("Y-m-d H:i:s"),
                                            'updated_at'=>date("Y-m-d H:i:s")
                                            );
                                            
                                            $this->db->insert('team',$db_team);
                                            $team_id = $this->db->insert_id();
                                            
                                            $team_exist = false;
                                            
                                    }
                                    else
                                    {
                                        $team_data = $query->row(); 
                                    }
                                    
                                    if($team_exist == true)
                                    {
                                        $team_id = $team_data->id;
                                        $team_name = $team_data->name;
                                    }
                                    
                                    $check_player = $this->db->where('name',$desired_name)->where('dob',$row[2])->where('identity_number',$row[3])->where('jersey_number',$row[4])->where('team_id',$team_id)->limit(1)->get('player');
                                    
                                    if($check_player->num_rows() > 0)
                                    {
                                        $row['feedback'] = 'Player ' . $desired_name . ' from ' . $team_name . ' already existed';
                                        $row['row'] = $countRow;
                                        $error[] = $row;
                                        continue;
                                    }
                                   
                                    if(!is_numeric($row[4])) //value not int for jersey number
                                    {
                                        
                                        $row['feedback'] = 'Jersey number provided isnt numeric';
                                        $row['row'] = $countRow;
                                        $error[] = $row;
                                        continue;
                                    }
                                    
                                    
                                    if(!preg_match("/^\d{6}-\d{2}-\d{4}$/", trim($row[3]))) 
                                    {
                                         $response['result'] = false;
                                         $response['message'] = "Player identity number format is incorrect, please fix field to proceed.";
                                         $response['input'] = "identity_number"; 
                                         $response['type'] = "input";

                                         return $response;
                                         
                                        $row['feedback'] = 'Player identity number format is incorrect';
                                        $row['row'] = $countRow;
                                        $error[] = $row;
                                        continue;
                                     }
                                     else
                                     {
                                         $explode =  explode('-',$row[3]);
                                         $dob = '19' . substr($explode[0], 0, 2) . '-' . substr($explode[0], 2, 2) . '-' . substr($explode[0], 4, 2);
                                     }

                                    
                                    $feedback_array = array($desired_name,$value,$basic_position,$team_id,$row[4],$row[8]);
                                    $feedback_array['feedback'] = 'Data Uploaded Succesfully';
                                    $feedback_array['row'] = $countRow;
                                    
                                    $insert[] = $feedback_array;
                                    
                                   

                                    $db_player = array (
                                    'name'=>isset($desired_name) && $desired_name != '' ? $desired_name :'',
                                    'value'=>isset($value) && $value != '' ? $value :'',
                                    'position'=>isset($basic_position) && $basic_position != '' ? strtoupper($basic_position) :'',
                                    'team_id'=>isset($team_id) && $team_id != '' ? $team_id :'',
                                    'dob'=>isset($dob) && $dob != '' ? $dob :'',
                                    'identity_number'=>isset($row[3]) && $row[3] != '' ? $row[3] :'',
                                    'jersey_number'=>isset($row[4]) && $row[4] != '' ? $row[4] :'',
                                    'image_url'=>isset($row[8]) && $row[8] != '' ? $row[8] :'',
                                    'short_name'=>isset($row[9]) && $row[9] != '' ? $row[9] :'',
                                    );

                                    $insertBatch[] = $db_player;
                                    
					
				}
			}
                        
			if(!empty($insertBatch)) $this->db->insert_batch('player', $insertBatch);
			
			$returnArray['error'] = $error;
			$returnArray['success'] = $insert;
			
			$arrayMerge = array_merge($insert,$error);
			
			$tableString = '';
			foreach($arrayMerge as $mergeValue)
			{
				$feedbackColor = 'green';
				
				if($mergeValue['feedback'] != 'Data Uploaded Succesfully')
				{
					$feedbackColor = 'red';
				}
				
				$tableString .= '<tr style="color:'.$feedbackColor.'"><td>' . $mergeValue['row'] . '</td><td> Name : ' . $mergeValue[0] . ', Value = ' . $mergeValue[1] . ', Position = ' . $mergeValue[2] . ', Team ID = ' . $mergeValue[3] . ', Jersey Number = ' . $mergeValue[4] . ', Image URL = ' . $mergeValue[5] . '</td><td>' . $mergeValue['feedback'] . '</td>';
			}
			
			
			return $tableString;
		}
		else
		{
			return false;
		}

	}
        
        function short_name($name)
        {
            $name_explode = explode(' ',$name);
            
            $desired_name = '';
                                    
            $row_name_count = 0;
            foreach($name_explode as $row_name)
            {
                if(count($name_explode) >= 3)
                {
                    if(in_array($name_explode[2],array('BIN','B.','A/L','ANAK','S/O','B')))
                    {
                        if(in_array($name_explode[0],array('MOHD','MOHAMAD','MUHAMMAD','MOHAMED','MUHAMAD','MOHAMMAD','AHMAD')))
                        {
                            $desired_name = 'M. ' . $name_explode[1];
                        }
                        else
                        {
                            $desired_name = $name_explode[0] . ' ' . $name_explode[1];
                        }
                        break;
                    }
                }
                if($row_name_count > 2 || strlen($desired_name) > 10)
                {
                    break;
                }

                if(in_array($row_name,array('BIN','B.','A/L','ANAK','S/O','B')))
                {
                    break;
                }

                if(in_array($name_explode[$row_name_count],array('MOHD','MOHAMAD','MUHAMMAD','MOHAMED','MUHAMAD','MOHAMMAD','AHMAD')))
                {
    //                                            $desired_name .= $name_explode[$row_name_count];
                    $row_name_count++;
                }
                else
                {

                    $desired_name .= strtoupper($name_explode[$row_name_count]) . ' ';
                    $row_name_count++;
                }

            }
            
            return $desired_name;
        }
        
        function basic_position($pos)
        {
            $basic_pos = array("GK", "DF", "MF", "ST");
            if(in_array($pos,$basic_pos))
            {
                return $pos;
            }
            else
            {
                if($pos == 'AM')
                    return 'MF';
                
                if($pos == 'CB')
                    return 'DF';
                
                if($pos == 'RB')
                    return 'DF';
                
                if($pos == 'DEF')
                    return 'DF';
                
                if($pos == 'RB/CB')
                    return 'DF';
                
                if($pos == 'RB/LB')
                    return 'DF';
                
                if($pos == 'CB/RB')
                    return 'DF';
                
                if($pos == 'LB/RB')
                    return 'DF';
                
                if($pos == 'LB')
                    return 'DF';
                
                if($pos == 'DM')
                    return 'MF';
                
                if($pos == 'RW')
                    return 'MF';
                
                if($pos == 'AM')
                    return 'MF';
                
                if($pos == 'LW')
                    return 'MF';
                
                if($pos == 'CDM')
                    return 'MF';
                
                if($pos == 'MD')
                    return 'MF';
                
                if($pos == 'CM')
                    return 'MF';
                
                if($pos == 'MID')
                    return 'MF';
                
                if($pos == 'CAM')
                    return 'MF';
                
                if($pos == 'RM')
                    return 'MF';
                
                if($pos == 'AMF')
                    return 'MF';
                
                if($pos == 'SLM')
                    return 'MF';
                
                if($pos == 'WG')
                    return 'MF';
                
                if($pos == 'WFW')
                    return 'ST';
                
                if($pos == 'WFG')
                    return 'ST';
                
                if($pos == 'FW')
                    return 'ST';
                
                if($pos == 'FWD')
                    return 'ST';
                
                if($pos == 'CF')
                    return 'ST';
                
                if($pos == 'ST/RW')
                    return 'ST';
                
            }
            
            
        }
	
	function player_quick($post = array())
	{
		if(isset($post) && sizeof($post) > 0)
		{
			if(isset($post['name']) && $post['name'] != '')
			{
				$name = $post['name'];
			}
			
			if(isset($post['id']) && $post['id'] != '')
			{
				$id = $post['id'];
			}
			
			
			if(isset($post['input_value']) && $post['input_value'] != '')
			{
				$value = $post['input_value'];
			}
			
			$rs = $this->db->set($name, $value)->where('id', $id)->update('player');
			
			if($rs == true)
			{
				$response['result'] = true;
				$response['message'] = "Player ".$name." field for id ". $id ." updated to ". $value .".";
			}
			else
			{
				$response['result'] = false;
				$response['message'] = "Error occured while updating player data.";
			}
			
			return $response;
		}
	}
        
    function player_match_history($player_id = NULL)
    {
        if($player_id != NULL)
        {
            $player_in_fixtures = $this->db->where('player_id',$player_id)->get('player_in_fixtures')->result();

            $row = array();
            foreach($player_in_fixtures as $row_player_in_fixtures)
            {
                $fixture = $this->db->where('id',$row_player_in_fixtures->fixture_id)->get('fixtures')->row();

                $home = $this->db->where('id',$fixture->home_team_id)->get('team')->row();
                $away = $this->db->where('id',$fixture->away_team_id)->get('team')->row();
                $season = $this->db->where('id',$fixture->season_id)->get('season')->row();
                $action = json_decode($row_player_in_fixtures->action);

                $score = 0;
                $assist = 0;
                $red = 0;
                $yellow = 0;
                $minutes = 0;

                foreach($action as $row_action)
                {
                    if($row_action->name == 'suboff')
                    {
                        $minutes = $row_action->time;
                    }

                    if($row_action->name == 'score')
                    {
                        $score = $score++;
                    }

                    if($row_action->name == 'assist')
                    {
                        $assist = $assist++;
                    }

                    if($row_action->name == 'yellow')
                    {
                        $yellow = $yellow++;
                    }

                    if($row_action->name == 'red')
                    {
                        $red = $red++;
                    }
                }

                $data_array = array(
                    'fixture'=>$fixture,
                    'home'=>$home,
                    'away'=>$away,
                    'season'=>$season,
                    'action'=>array('score'=>$score,'assist'=>$assist,'yellow'=>$yellow,'red'=>$red,'minutes'=>$minutes),
                );

                $row[] = $data_array;
            }

            return $row;
        }
        else {
            return false;
        }
    }
    
    function get_club_player($team_id = NULL,$search_data = array())
    {
        if($team_id != NULL)
        {
            $is_download = (isset($search_data['download']) && $search_data['download'] == 'true');

            $where = "WHERE `player`.`team_id` = " . $team_id . ' ';
            $orderby = "`player`.`id`";
            
            if(is_array($search_data) && sizeof($search_data) > 0){

                if(isset($search_data['sql_sort_column']) && $search_data['sql_sort_column'] != "")
                {
                        $orderby = $search_data['sql_sort_column'];
                }
                else
                {
                        $orderby = "`player`.`id`";
                }

                if(!isset($search_data['sql_sort']))
                {
                        $search_data['sql_sort'] = "DESC";
                }

                if(isset($search_data['filter']) && $search_data['filter'] != "")
                {
                    if(isset($search_data['filterBy']) && $search_data['filterBy'] != "")
                    {
                        if($search_data['filter'] == 'position')
                        {
                            $search_data['filter'] = '`player`.`position`';
                        }

                        $where .= ($where == "" ? " WHERE " : " AND ") . $search_data['filter'] ." = " . $this->db->escape($search_data['filterBy']) . " ";

                    }
                }

                if(isset($search_data['search']) && $search_data['search'] != "")
                {
                    $where .= ($where == "" ? " WHERE " : " AND ") . " ( `player`.`name` LIKE " . $this->db->escape("%".$search_data['search']."%") . " OR `player`.`short_name` LIKE " . $this->db->escape("%".$search_data['search']."%")  . " OR LOWER(`player`.`name`) LIKE " . $this->db->escape("%".strtolower($search_data['search'])."%") . " OR LOWER(`player`.`short_name`) LIKE " . $this->db->escape("%".$search_data['search']."%") . " ) ORDER BY " .  $orderby . " " . $search_data['sql_sort'] ;
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

            $sql = "SELECT `player`.`id`,`player`.`name`,`player`.`value`,`player`.`team`,`player`.`jersey_number`,`player`.`position`,`player`.`team_id`,`team`.`name` as `team_name` FROM `player` LEFT JOIN `team` ON `player`.`team_id` = `team`.`id` " . $where ;
            $query = $this->db->query($sql);
            
            $data['total_rows'] = $query->num_rows();
            $config['base_url'] = base_url() . 'secure/update_club/'.encrypt_data($team_id).'/' . $this->uri->segment(4);
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
                    $sql_query = "SELECT `player`.`id`,`player`.`name`,`player`.`value`,`player`.`team`,`player`.`jersey_number`,`player`.`position`,`player`.`team_id`,`team`.`name` as `team_name` FROM `player` LEFT JOIN `team` ON `player`.`team_id` = `team`.`id` " . $where ;
            }
            else
            {
                    $sql_query = "SELECT `player`.`id`,`player`.`name`,`player`.`value`,`player`.`team`,`player`.`jersey_number`,`player`.`position`,`player`.`team_id`,`team`.`name` as `team_name` FROM `player` LEFT JOIN `team` ON `player`.`team_id` = `team`.`id` " . $where . $limit ;
            }

            $data['query'] = $this->db->query($sql_query);

            $result = $data['query']->result();

            
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

                    if($res->id != '')
                    {
                        $name = ucwords(strtolower($res->name));
                    }

                    $action = '<div class="btn-group" role="group" aria-label="Basic example">';

                    // $action .= ' <button type="button" id="submit_'. $res->id . '" class="btn btn-icon btn-primary quick_update"><i class="fas fa-bolt"></i></button>';
                    $action .= ' <a href="'.base_url().'secure/update_player/'. encrypt_data($res->id) . '" class="btn btn-icon btn-success "><i class="fas fa-user-edit"></i></a>';

                    $action .= '</div>';

                    $row = [
                            '#' => $j++,
                            // 'ID' => 'P'.pad_zero($res->id),
                            'Name' => $name,
                            'Value' => isset($res->value) && $res->value != '' ? $res->value : '-',
                            'Position' =>  $res->position,
                            'Action' => $action,
                    ];

                    $rows[] = $row;

            }

            if($is_download)
            {
                    download_csv($rows, 'players_list'.today().'.csv');
                    exit;
            }

            $filter = [
                    'player.position' => 'Position',
            ];

            $width = [ 
                    '#' => 40,
                    // 'ID' => 80,
                    'Name' => 150,
                    'Value' => 100,
                    'Position' => 100,
                    'Action' => 100,
            ];

            $data['actions'] = [
                    '<a href="javascript:void();" class="btn btn-info download-button mr-2">Download</a>',
                    '<a href="'.base_url().'secure/player_form" class="btn btn-info">Add New Player</a>',
            ];

            $sort = [
            '#' => '`player`.`id`',
            'Name' => '`player`.`name`',
            'Value' => '`player`.`value`',
            'Position' => '`player`.`position`',
            ];

            $center = [
            // '#',
            // 'Value',
            // 'Position',
            'Action',
            ];

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
                    'position' => 'Position',
            ];

            $data['filter'] = $filter;

            return $data;
        }
    }
}
?>
