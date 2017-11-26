<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Register_model extends CI_Model {

    function register($data)
    {
        $options = ['cost' => 5,
                    'salt' => mcrypt_create_iv(22, MCRYPT_DEV_URANDOM),
                    ];
        $this->db->db_debug = FALSE;
        $this->db->insert('tb_user', array(
            "username"  => $data['username'],
            "password"  => password($data['password'],$options),
            "email"     => $data['email']
        ));
        $error = $this->db->error();
        if($error['code'] == 1062)
        {
            return false;
        }
        return true;
        
        
    }  

    function usercek($username)
    {
        $this->db->where('username', $username);
        return $this->db->get('tb_user');
        
        
    }

}

/* End of file Register_model.php */
?>