<?php

class System_m extends CI_Model {

    function __construct(){
        parent::__construct();
    }
	
    function get_settings_data()
    {
        $data = $this->db->get('setting')->result_array();
        
        // Use array_column to extract 'code' values
        $codes = array_column($data, 'code');

        // Use array_combine to combine 'code' values as keys with the original array as values
        $result = array_combine($codes, $data);
        
        return sizeof($result) > 0 ? $result : array();
    }
    
    function update_setting_data($post = array())
    {
        if(sizeof($post) > 0 )
        {
            foreach($post as $key=>$value)
            {
              $data[] = array(
              'code'=>$key,
              'value'=>$value    
              );
            }
            
            $rs = $this->db->update_batch('setting', $data, 'code');
            
            if($rs)
                $response['result'] = true;
            else
                $response['result'] = false;
            
            return $response;
        }
        else
        {
            return true;
        }
    }
	
	
}
?>