<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Auth_model extends CI_Model {

    
    function get_user($data)
    {
        $this->db->where('username', $data['username']);
        return $this->db->get('tb_user');
        
    }

    function get_router($user_id)
    {
        $this->db->where('user_id', $user_id);
        $this->db->where('status', 1);
        
        return $this->db->get('tb_user_router');
        
        
    }
}

/* End of file Auth_model.php */
?>