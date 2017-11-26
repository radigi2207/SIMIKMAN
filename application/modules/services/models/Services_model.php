<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Services_model extends CI_Model {

    protected $API ;
    protected $host,$user,$pass,$port,$id_router,$user_id,$hash;
    
    function __construct() {
        parent::__construct(); 
        $this->load->library('RouterosAPI');
		$this->API = new RouterosAPI();
		$this->host = ($this->session->userdata('host'))? $this->session->userdata('host') : "";
		$this->user = ($this->session->userdata('user'))? $this->session->userdata('user') : "";
		$this->pass = ($this->session->userdata('pass'))? $this->session->userdata('pass') : "";
		$this->API->port = ($this->session->userdata('port'))? $this->session->userdata('port') : "";
		$this->id_router = ($this->session->userdata("id_router"))?$this->session->userdata("id_router") : NULL;
        $this->user_id = ($this->session->userdata("user_id"))?$this->session->userdata("user_id") : NULL;
        $this->hash = ($this->session->userdata("hash"))?$this->session->userdata("hash") : NULL;
		
	}

    function bandwidth($id = NULL)
    {
        ($id != NULL) ? $this->db->where('id',$id) : NULL;
        $this->db->where('id_router', $this->id_router);      
        return $this->db->get('tb_bandwidth');
        
    }

    function addBandwidth($data,$id)
    {
        $prof = array() ;
        $prof["name"]    = $data['name'];
        isset($data['rate_limit']) ? $prof['rate-limit'] = $data['rate_limit'] : NULL;
        isset($data['shared_users']) ? $prof['shared-users'] =  $data['shared_users'] : NULL;
        isset($data['address_list']) ? $prof['address-list'] =  $data['address_list'] : NULL;
        $prof["on-login"]   = "/tool fetch url=\"".site_url("mikrotik/hotspot_notif/".$this->hash)."\?type=login&user=\$user&ip=\$address\" keep-result=no;";
        $prof["on-logout"]  =  "/tool fetch url=\"".site_url("mikrotik/hotspot_notif/".$this->hash)."\?type=logout&user=\$user&ip=\$address\" keep-result=no;";

        if($id != NULL)
        {
            $id = decode_url($id,"edit");
            $profile = $this->bandwidth($id);
            if($profile->num_rows() == 1 && $this->open())
            {
                $profile = $profile->row();
                $prof['.id']    = $profile->id_api;

                $this->API->comm("/ip/hotspot/user/profile/set",$prof);
                $this->API->write("/ip/hotspot/user/profile/getall",false);
                $this->API->write("?name=".$prof["name"]);
                $READ = $this->API->read(true);
                if(isset($READ[0]['.id']))
                {
                    $row = $READ[0];
                    $rate_limit = explode("/",$row['rate-limit']);
                    $data = array('name' => $row['name'],
                                  'rate_down'   => byte($rate_limit[0]),
                                  'rate_upload' => byte($rate_limit[1]),
                                  'shared_users'=> $row['shared-users'],
                                  'address_list'=> $row['address-list'],
                                  'id_api'      => $row['.id'],
                                  'id_router'   => $this->id_router
                                 );
                    $this->db->where('id', $id);                    
                    $this->db->update('tb_bandwidth', $data);
                    
                    return true;
                    
                }
            }
            return false;
        }
        else
        {
            if($this->open())
            {
                $this->API->comm("/ip/hotspot/user/profile/add",$prof);
				$this->API->write("/ip/hotspot/user/profile/getall",false);
				$this->API->write("?name=".$prof["name"]);
                $READ = $this->API->read(true);
                if(isset($READ[0]['.id']))
                {
                    $row = $READ[0];
                    $this->db->where('id_api', $row['.id']);
                    $this->db->where('id_router', $this->id_router);
                    $bandwidth = $this->db->get('tb_bandwidth');
                    $rate_limit = explode("/",$row['rate-limit']);
                    $data = array('name' => $row['name'],
                                  'rate_down'   => byte($rate_limit[0]),
                                  'rate_upload' => byte($rate_limit[1]),
                                  'shared_users'=> $row['shared-users'],
                                  'address_list'=> $row['address-list'],
                                  'id_api'      => $row['.id'],
                                  'id_router'   => $this->id_router
                                 );
                    if($bandwidth->num_rows() == 0)
                    {
                        $this->db->insert('tb_bandwidth', $data);
                    }                   
                    return true;
                    
                }

            }
            return false;
        }
    }

    function delBandwidth($id)
    {
        $this->db->trans_begin();
        
        $this->db->where('id_api', $id);
        $this->db->where('id_router', $this->id_router);
        $this->db->delete('tb_bandwidth');

        if($this->open())
		{
			$this->API->write("/ip/hotspot/user/profile/remove",false);
			$this->API->write("=.id=".$id);
            $READ = $this->API->read(true);
            $this->API->write("/ip/hotspot/user/profile/getall",false);
            $this->API->write("?.id=".$id);
            $READ = $this->API->read(true);
            if(!isset($READ[0]['.id']))
                $this->db->trans_commit();
            else
                $this->db->trans_rollback();
		}
		else
		{
			$this->db->trans_rollback();
		}
        
        
    }

    private function open($debug = false)
	{
		

		$this->API->debug = $debug;
		
		if($this->API->connect($this->host,$this->user,$this->pass))
			return true;
		else
			return false;
    }
    

    //check bandwidth name
    function checkBandwidth($data, $col)
    {
        $this->db->where($col, $data);
        $this->db->where('id_router', $this->id_router);
        return $this->db->get('tb_bandwidth');
        
        
    }

}

/* End of file Services_model.php */
?>
