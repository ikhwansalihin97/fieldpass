<?php

class User_m extends CI_Model {

	function __construct(){
		parent::__construct();
	}
	
	public function user_verify($post = array())
	{
		if(preg_match("/[^@ \t\r\n]+@[^@ \t\r\n]+\.[^@ \t\r\n]+/", trim($post["email"])))
		{
			$sql ="SELECT * FROM `user` WHERE `email` = " . $this->db->escape($post['email']) . " LIMIT 1";
			$query = $this->db->query($sql);
		}
		
		
		if($query->num_rows() > 0)
		{
			$data = $query->row();
			
			if(md5($this->input->post('password')) == $data->password)
			{
				
				if($data->active == 1)
				{				
					$session_data = array(
					'username' => trim($data->firstname),
					'email' => trim($data->email),
					'user_id' => trim($data->id),
					'user_type_id' => trim($data->user_type_id),
					'user_role_id' => trim($data->user_role_id),
					'logged_in' => "TRUE"
					);
					
					/* if($data->group_type == 'employee')
					{
						$get_employee = $this->db->where('id',$data->group_id)->get('employee');
						
						if($get_employee->num_rows() > 0 )
						{
							$employee = $get_employee->row_array();
							
							$session_data['position'] = $employee['position'];
						}
					} */
					
					$this->session->set_userdata($session_data);
					
					$this->db->where('id', $data->id);
					$query = $this->db->update('`user`',array('last_login' => date('Y-m-d H:i:s')));
					
					$return["result"] = true;
					return $return;
				}
				else if($data->active == 0)
				{
					
					$return["result"] = "banned";
					$return["message"] = "Your account has been banned, Please contact administrator to resolve.";
					return $return;
				}
				else //empty == not verify
				{
					$return["result"] = false;
					$return["message"] = "Please validate your email, in order to proceed.";
					return $return;
				}
			
				$return["result"] = true;
				return $return;
				
			}
			else
			{
				$return["result"] = "wrong password";
				$return["message"] = "Password entered doesnt match, Please try again.";
				
				return $return;
			}
			
		}
		else
		{
			
			$return["result"] = "unregistered";
			$return["message"] = "Please register in order to proceed.";
			
			return $return;
			
		}
		
	}
	
	
}
?>