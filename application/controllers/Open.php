<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Open extends CI_Controller {

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
	
	
	public function login()
	{
		security_checking();
		
		if($_POST)
		{		
			$post = $this->input->post();
			
			$rs = $this->User_m->user_verify($post);
			
			if($rs["result"] === true)
			{
				$response['result'] = 'success';
				
				echo json_encode($response);
				return;
			}
			else if($rs["result"] == "banned")
			{
				$response['message'] = "Your account has been banned by admin, Please contact administrator to resolve this issue.";
				$response['result'] = 'failed';
				
				echo json_encode($response);
				return;
			}
			else if($rs["result"] == "wrong password")
			{
				$response['message'] = $rs['message'];
				$response['result'] = 'failed';
				
				echo json_encode($response);
				return;
			}
			else if($rs["result"] == "unregistered")
			{
				$response['message'] = $rs['message'];
				$response['result'] = 'failed';
				
				echo json_encode($response);
				return;
			}
			else
			{
				$response['message'] = "Account not activated, please check your email to validate your account.";
				$response['result'] = 'failed';
				
				echo json_encode($response);
				return;
			}
			
		}
		else
		{
			$this->load->view('public/login_v');
		}
	}
	
	public function sayonara(){
		$this->session->sess_destroy();
		redirect('open/login');
	}
}
