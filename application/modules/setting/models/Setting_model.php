<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Setting_model extends CI_Model {

    protected $API ;
    public function __construct()
    {
        parent::__construct();
        $this->load->library('RouterosAPI');
		$this->API = new RouterosAPI();
    }
    
    function getUser()
    {
        $this->db->where('id',$this->session->userdata("user_id"));
        
        return $this->db->get('tb_user');
        
    }

    function updateUser($data)
    {
        $this->db->set("first_name", $data['fname']);
        $this->db->set("last_name", $data['lname']);
        $this->db->set("email", $data['email']);
        if(strlen($data['password']) != 0)
        {
            $options = ['cost' => 5,
                        'salt' => mcrypt_create_iv(22, MCRYPT_DEV_URANDOM),
                        ];
            $this->db->set("password", password($data['password'],$options));
        }
        $this->db->where('id', $this->session->userdata("user_id"));
        $this->db->update('tb_user');
        
        if($this->db->affected_rows())
        {
            return true;
        }
        else
            return false;
            
        
    }

    function cekRadius($name = NULL, $type = NULL)
    {
        $this->db->select('*');
        $this->db->from('tb_radius_server');
        $this->db->where('id_router', $this->session->userdata("id_router"));
        ($name != NULL && $type != NULL) ? $this->db->where($type, $name) : "";        
        return $this->db->get();
    }
    function getRadius($id = NULL )
    {
        $this->db->select('*');
        $this->db->from('tb_radius_server');
        ($id != NULL ) ? $this->db->where('id_api',$id):false;
        $this->db->where('id_router', $this->session->userdata("id_router"));
              
        return $this->db->get();
    }

    //Menambah Router
    function getRouter($id = NULL)
    {
        $this->db->where('user_id', $this->session->userdata("user_id"));
        ($id != NULL) ? $this->db->where('id', $id) : false;        
        return $this->db->get('tb_user_router');
        
        
    }

    function setRouter($data)
    {
        $this->db->trans_begin();
        $this->db->where('id',$data['id_router']);
        $router = $this->db->get('tb_user_router')->row();
        
        $this->API->debug = false;
        $this->API->port = $router->port;
        if($this->API->connect($router->host,$router->user,$router->pass))
        {
            $this->db->where('user_id', $this->session->userdata("user_id"));
            $this->db->set("status",0);
            $this->db->update('tb_user_router');
            

            $this->db->set("status",1);
            $this->db->where('id',$data['id_router']);
            $this->db->update('tb_user_router');

            

            $session['user']    = $router->user;
            $session['pass']    = $router->pass;
            $session['port']    = $router->port;
            $session['host']    = $router->host;
            $session['id_router'] =   $data['id_router'];
            $session['hash']    = $router->hash;
            $this->session->set_userdata($session);
            $this->db->trans_complete();
            $data = array('status' => 200,
                          'msg'    => "Router default berhasil disimpan",
                          'color'  => "#739E73" );
            
        }
            
        else
        {
            $this->db->trans_rollback();
            $data = array('status' => 201,
                          'msg'    => "Maaf perangkat yang anda pilih tidak terhubung",
                          'color'  => "#b93b3b" );

        }

        return $data;
    }

    function delRouter($id)
    {
        $this->db->trans_start();
        
        $this->db->where("id_router", $id);
        $this->db->delete('tb_profile');

        $this->db->where("id_router", $id);
        $this->db->delete('tb_limit');

        $this->db->where("id_router", $id);
        $this->db->delete('tb_radius_server');

        $this->db->where('id',$id);
        $this->db->delete('tb_user_router');

        $this->db->trans_complete();

        return;
    }

    function cekRouter($data,$col)
    {
        $this->db->where($col, $data);

        return $this->db->get('tb_user_router');
        
        
    }

    
}

/* End of file Setting_model.php */
?>