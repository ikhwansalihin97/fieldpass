<?php  if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Array debug
 *
 * @access	public
 * @param	string
 * @return	string
 */	
if(!function_exists("ad")) {
	function ad($data, $write = false){
		//Array Debug. 
		if($write) {
			ob_start();
			print_r($data);
			$output = ob_get_contents();
			ob_end_clean();

			$myFile = "C:/testFile.txt";
			$fh = fopen($myFile, 'a') or die("can't open file");
			
			$date = date("d-m-Y H:i:s") . "\n";
			fwrite($fh, $date);
			fwrite($fh, $output);
			fclose($fh);
		}
		else {
			echo "<pre>";
			print_r($data);
			echo "</pre>";
		}
	}
}

// ------------------------------------------------------------------------

/**
 * Set message for display to browser. Useful for confirming certain process.
 *
 * @access	public
 * @param	string
 * @return	string
 // set_toastr_message('message','type');
 */	
if(!function_exists("set_message")) {
	 function set_message($feedback, $type = 'info')
	{
		#save notice.
		#Message Type: error, info
		
		$obj =& get_instance();
		$obj->session->set_userdata('system-message', $feedback);
		$obj->session->set_userdata('message-type', $type);
		
		if($type == 'info')
		{
			$obj->session->set_userdata('message-icon', 'flaticon2-information');
		}
		
		if($type == 'success')
		{
			$obj->session->set_userdata('message-icon', 'flaticon2-check-mark');
		}
		
		if($type == 'danger')
		{
			$obj->session->set_userdata('message-icon', 'flaticon2-exclamation');
		}
		
		if($type == 'warning')
		{
			$obj->session->set_userdata('message-icon', 'flaticon2-warning');
		}
	}
}


// ------------------------------------------------------------------------

/**
 * Display message to browser.
 *
 * @access	public
 * @param	string
 * @return	string
 */	
if(!function_exists("get_message")) {
	function get_message()
	{
		$obj =& get_instance();
		
		//Display notice.
		if($obj->session->userdata('system-message') != '')
		{ 
			$message_type = $obj->session->userdata('message-type');
			
			#For backward compatiblity. 
			if($message_type == 'error')
				$message_type = 'danger';
			
			echo '<div class="alert alert-custom alert-' . $message_type . ' " role="alert"><div class="alert-icon"><i class="'. $obj->session->userdata('message-icon') . '"></i></div> 
					<div class="alert-text">' . 
					$obj->session->userdata('system-message') .
				'</div>
				<div class="alert-close">
					<button type="button" class="close" data-dismiss="alert" aria-label="Close">
						<span aria-hidden="true"><i class="ki ki-close"></i></span>
					</button>
				</div>
				'
				. '</div>';
				
			$obj->session->unset_userdata('system-message');
			$obj->session->unset_userdata('message-type');
			$obj->session->unset_userdata('message-icon');
		}
	}
}


/**
 * Set toastr message for display to browser. Useful for confirming certain process.
 *
 * @access	public
 * @param	string
 * @return	string
 */	
if(!function_exists("set_toastr_message")) {
	 function set_toastr_message($feedback, $type = 'info')
	{
		#save notice.
		#Message Type: error, info
		
		$obj =& get_instance();
		$obj->session->set_userdata('system-toastr-message', $feedback);
		$obj->session->set_userdata('message-toastr-type', $type);
	}
}


// ------------------------------------------------------------------------




/*
 * Security Checking.
 *
 * @access	public
 * @param	string
 * @return	true or false
 * group 1 => admin
 * group 2 => user
 */	

 
if(!function_exists("security_checking")) {
	function security_checking($group = false) {
		$obj =& get_instance();
		#If group is being specified
		if($group !== false) {
			if(is_array($group)) {
				$found = FALSE;
				foreach($group AS $key => $value) {
					if($obj->session->userdata('group_type') == $value)
						$found = TRUE;
				}
				
			}
			else
				$found = ($obj->session->userdata('group_type') == $group) ? TRUE : FALSE;
			
			if($found == false)
			{
				redirect('secure');
			}
			
			if($found == TRUE AND $obj->session->userdata('logged_in') == TRUE)
				return true;
			else  {
				if($obj->session->userdata('logged_in') == TRUE &&  in_array($obj->session->userdata('group_type'),array('root','employee','customer'))){
					// redirect('secure');
					return true;
				}
				else
					redirect('open/login');
				exit();
			}
		}
		#General checking for already logged in without specifying group type
		else {
			
			if($obj->session->userdata('logged_in') == TRUE AND $obj->session->userdata('group_type') != '')
			{
				if($obj->uri->segment(1) == 'secure')
					return true;
				else
					redirect('secure');
				
			}
			else
			{
				
				if($obj->session->userdata('logged_in') == TRUE)
				{
					if($obj->uri->segment(1) == 'secure')
						return true;
					else
						redirect('secure');
				}
				else
				{
					if($obj->uri->segment(1) == 'open' || $obj->uri->segment(2) == 'login' || $obj->uri->segment(1) == 'login')
						return true;
					else
						redirect('open/login');
				}
			}
			
		}
	}
}



if(!function_exists("sendmail")) {
	function sendmail($subject = null, $body = null, $to = null, $cc = array())
	{
		$CI =& get_instance();
		$CI->load->library('phpmailer_lib');
        
        // PHPMailer object
		$mail = $CI->phpmailer_lib->load();
		// echo ADMIN_EMAIL_SMTP_SECURE . "=====" . ADMIN_EMAIL_HOST . "====" . ADMIN_EMAIL_PORT . "====" . ADMIN_SMTP_EMAIL . "=====". ADMIN_EMAIL_PASS; exit;
		//require 'phpmailer/class.phpmailer.php';
		// require_once 'phpmailer/PHPMailerAutoload.php';
		
		// $mail             = new PHPMailer();
		
	// 	$body             = $mail->getFile('contents.html');
	// 	$body             = eregi_replace("[\]",'',$body);
		
		$mail->IsSMTP();
		$mail->SMTPAuth   = true;                  // enable SMTP authentication
		$mail->SMTPSecure = ADMIN_EMAIL_SMTP_SECURE;                 // sets the prefix to the server
		$mail->Host       = ADMIN_EMAIL_HOST;      // sets GMAIL as the SMTP server
		$mail->Port       = ADMIN_EMAIL_PORT;                   // set the SMTP port for the GMAIL server
		$mail->SMTPDebug  = 0;                   // set the SMTP port for the GMAIL server

		$mail->AddEmbeddedImage('template/images/custom_image.png', 'logo');
		$mail->AddEmbeddedImage('template/metronic/dist/assets/media/bg/bg-4g.jpg', 'bg');

		$mail->SMTPOptions = array(
				'ssl' => array(
					'verify_peer' => false,
					'verify_peer_name' => false,
					'allow_self_signed' => true
				)
		);
		
		$mail->Username   = ADMIN_SMTP_EMAIL;  // GMAIL username
		$mail->Password   = ADMIN_EMAIL_PASS;            // GMAIL password
		
		$mail->From       = ADMIN_SMTP_EMAIL;
		$mail->FromName   = "Atletico";
		
		$mail->Subject    = $subject;
		
		$mail->Body       = "" . $body; //HTML Body
		$mail->AltBody    = "To view the message, please use an HTML compatible email viewer!"; // optional, comment out and test
		$mail->WordWrap   = 50; // set word wrap
		
		$mail->MsgHTML($mail->Body);
		
		$mail->AddAddress($to);
		
		$bcc = array(
			'ikhwansalihin97@gmail.com' => 'Ikhwan Salihin',
		);
		if(count($cc) > 0){
			foreach($cc as $email => $name){
				if($email != '');
					$mail->AddCC($email, $name);
			}
		}
		if(count($bcc) > 0){
			foreach($bcc as $email => $name){
			   $mail->AddBCC($email, $name);
			}
		}
		// $mail->AddAttachment("images/phpmailer.gif");             // attachment
		
		$mail->IsHTML(true); // send as HTML
		
		if(!$mail->Send())
			return $mail->ErrorInfo;
		else 
			return true;
			
		return false;
	}
}

if(!function_exists("encrypt_base64")) {
	function encrypt_base64($data = ""){
		if($data != ""){
			return trim(base64_encode($data), '=.');
		}
	}
	
}

if(!function_exists("decrypt_base64")) {
	function decrypt_base64($encrypted_data = ""){
		if($encrypted_data != ""){
			return base64_decode($encrypted_data);
		}
	}
}

#ikhwan part####
function encrypt_data($data = "")
{
	return encrypt_base64(serialize($data));
	
}

function filter_data($data = ""){
	
	return encrypt_base64(serialize($data));
	
}

function decrypt_data($data = ""){
	return unserialize(decrypt_base64($data));
}



if(!function_exists('base64url_encode')){
	function base64url_encode($data){
	  return rtrim(strtr(base64_encode($data), '+/', '-_'), '=');
	}
}

if(!function_exists('base64url_decode')){
	function base64url_decode($data) { 
	  return base64_decode(str_pad(strtr($data, '-_', '+/'), strlen($data) % 4, '=', STR_PAD_RIGHT)); 
	} 
}

/**
 * Use for Audit Trail
 */
if(!function_exists("audit_trail")) {
	function audit_trail($sql = null, $filename = null, $function = null, $comment = null) 
	{
		$CI =& get_instance();
		
		$sql = $CI->db->escape($sql);
		$filename = $CI->db->escape($filename);
		$function = $CI->db->escape($function);
		$comment = $CI->db->escape($comment);
		$ip_address = $CI->db->escape($_SERVER['REMOTE_ADDR']);
		$user_id = $CI->db->escape($CI->session->userdata('user_id'));
		
		$sql = "INSERT INTO `audit_trail` SET `sql_str` = $sql, `filename` = $filename, `function` = $function, `comment` = $comment, `ip_address` = $ip_address, `user_id` = $user_id, insert_date = NOW()";
		$query = $CI->db->query($sql);
		
		return false;
		
		// audit_trail($this->db->last_query(), 'admin/user_m.php', 'add_admins', 'insert add admin');

	}
}

function get_csv($location){

	$file = fopen($location, 'r');
	$header = false;

	$csv = [];
	
	while(!feof($file)){
		$line = fgets($file);
		$line = trim($line);
		if($header == false){
			$header = explode(',', $line);
			foreach($header as $key=>$value){
				$header[$key] = (string)trim($value);
			}
		}else{
			$values = explode(',', $line);

			if(count($header) == count($values)){
				$row = array_combine($header, $values);

				$csv[] = $row;
			}
		}
	}



	return $csv;
}

function download_csv($arr, $filename, $autoheader = true){
	header('Content-Type: application/csv');
    header('Content-Disposition: attachment; filename="'.$filename.'";');

    $f = fopen('php://output', 'w');

    if(is_array($arr)){

    	if($autoheader)
    	{		
		    $header = [];
		    $arr = array_values($arr);

		    // dd($arr);
		    $first = (array)$arr[0];
		    foreach($arr[0] as $head=>$val){
		        $header[$head] = $head;
		    }  
		    
		    $head_line[] = $header;

		    $arr = array_merge($head_line, $arr);
    	}
	    // dd($arr);
	    foreach ($arr as $line) {
	        fputcsv($f, (array)$line, ',');
	    }
	}else{
		echo $arr;
	}

    // done!
}

function generate_key(){
	return md5(rand().time());
}

function pad_zero($num){
	return str_pad($num, 4, '0', STR_PAD_LEFT);
}


function check_by_id($id = NULL, $table = NULL)
{
	$CI =& get_instance();
	
	if($id != NULL)
	{
		$num_rows = $CI->db->where('id',$id)->get($table)->num_rows();
		
		return $num_rows > 0 ? true : false;
	}
	else
	{
		return false;
	}
}

//get current season from setting table
function get_current_season()
{
	$CI =& get_instance();
	
	$row = $CI->db->where('name','season')->limit(1)->get('setting')->row();
	
	return isset($row->value) && $row->value != '' ? $row->value : NULL;
}

//get all season from season table
function get_all_season()
{
	$CI =& get_instance();
	
	$result = $CI->db->get('season')->result();
	
	return isset($result) && is_array($result) && sizeof($result) > 0 ? $result : array();
}

//get all season from season table
function get_team_season_by_team_id($team_id = NULL)
{
	$CI =& get_instance();
	
	if($team_id != NULL)
	{
		$result = $CI->db->where('team_id',$team_id)->get('team_season')->result();
	}
	
	return isset($result) && is_array($result) && sizeof($result) > 0 ? $result : array();
}


// ------------------------------------------------------------------------
?>