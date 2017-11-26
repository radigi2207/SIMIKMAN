<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Telegram_model extends CI_Model {
    protected $API ;
    public function __construct()
    {
        parent::__construct();
        $this->load->library('RouterosAPI');
		$this->API = new RouterosAPI();
    }

    function register($data, $update = false)
    {

        $user = $this->db->select("*")
                         ->from("tb_user")
                         ->where("id_telegram",$data['chat']['id'])
                         ->get();
        
        if($user->num_rows() == 0 && !$update)
        {
            $insert = array('first_name' => $data['chat']['first_name'],
                            'last_name'  => $data['chat']['last_name'],
                            'password'   => $data['chat']['pass'],
                            'username'   => $data['chat']['id'],
                            'id_group'   => 5,
                            'id_telegram'=> $data['chat']['id'],
                            "id"         => $data['chat']['id']
                        );
            $this->db->insert("tb_user",$insert);
            return true;
        }
        elseif($update)
        {
            $this->db->set("first_name", $data['chat']['first_name']);
            $this->db->set("last_name", $data['chat']['last_name']);
            
            $this->db->where("id_telegram",$data['chat']['id']);
            $this->db->update("tb_user");
            return true;
        }
        else
            return false;
            

    }
    function chat($update_id,$message)
    {
        $data = array("update_id" => $update_id,
                      "message_id"=> $message['message_id'],
                      "from_id"   => $message['from']['id'],
                      "chat_id"   => $message['chat']['id'],
                      "date"      => $message['date'],
                      "text"      => $message['text']);
        $this->db->insert("tb_chat",$data);
    }

    function check_user($id)
    {
        $this->db->join('tb_agen_router a', 'a.id_telegram = u.id_telegram', 'left');
        
        $this->db->where('u.id_telegram', $id);
        return $this->db->get('tb_user u');
    }

    function getProfile($id_router, $kode = NULL)
    {
        $this->db->join('tb_kode_profile kp', 'kp.profile_id = p.id');
        $this->db->where('p.id_router',$id_router);
        ($kode != NULL) ? $this->db->where('kp.kode', $kode) : NULL;        
        $this->db->order_by('p.price', 'asc');
        return $this->db->get('tb_profile p');
    }

    function saveSession($data)
    {
        return $this->db->insert('tb_telegram_session',$data);
        

    }

    function checkSession($id)
    {
        $this->db->where('id_counter', $id);
        $this->db->order_by('id', 'desc');
        return $this->db->get('tb_telegram_session',1);
        
    }

    function sessionStop($id)
    {
        $this->db->set('next_step', false);
        $this->db->where('id', $id);
        $this->db->update('tb_telegram_session');
        
        
    }

    function regUser($data)
    {
        $id_router  = $data['id_router'];
        $profile    = $data['profile'];
        $price      = $data['price'];
        $op_id      = $data['op_id'];
        unset($data['price']);
        unset($data['profile']);
        unset($data['id_router']);
        unset($data['op_id']);
        $this->db->where('id',$id_router);
        $router = $this->db->get('tb_user_router')->row();
        
        $this->API->debug = false;
        $this->API->port = $router->port;
        if($this->API->connect($router->host,$router->user,$router->pass))
        {
            $data['comment'] = "add by telegram";
            $data['customer'] 	= $router->user;
            $this->API->comm("/tool/user-manager/user/add",$data);
            $this->API->comm("/tool/user-manager/user/create-and-activate-profile",
                            array(	"customer" => $data['customer'],
                                    "profile"  => $profile,
                                    "numbers"  => $data['username']));

            $this->API->write("/tool/user-manager/user/getall",false);
            $this->API->write("?username=$data[username]");
            $READ = $this->API->read(true);
    
            if(count($READ) == 1  && isset($READ[0]['.id']))
            {
                $row = $READ[0];
                $data = array(	"id"		=> NULL,
                                "id_api"=> $row['.id'],
                                "customer" 	=> $row['customer'],
                                "actual_profile" => (isset($row['actual-profile']))?$row['actual-profile']:"",
                                "username" 	=> $row['username'],
                                "password" 	=> $row['password'],
                                "download"	=> (isset($row['download-used']))?$row['download-used']:"",
                                "upload"	=> (isset($row['upload-used']))?$row['upload-used']:"",
                                "time_used"	=> (isset($row['uptime-used']))?$row['uptime-used']:"",
                                "disabled"	=> $row['disabled'],
                                "comment"	=> isset($row['comment'])?	$row['comment'] : "",
                                "first_name"=> (isset($row['first-name']))?$row['first-name']:"",
                                "last_name"	=> (isset($row['last-name']))?$row['last-name']:"",
                                "no_tlp"	=> (isset($row['phone']))?$row['phone']:"",
                                "alamat"	=> (isset($row['location']))?$row['location']:"",
                                "status"	=> (isset($row['active']))?$row['active']:false,
                                "id_router"	=> $id_router,
                                "email"		=> isset($row['email'])? $row['email'] : ""
    
                );

                $this->db->insert("tb_userman",$data);

                $return = array("ok"    => true,
                                "result"=> "Registrasi user berhasil \n".
                                           "Voucher $profile \n".
                                           "Username : $row[username] \n".
                                           "Password : $row[password] \n".
                                           "ID trx TEL".now());
                $user_id = $this->db->insert_id();
                $fname = (isset($row['first-name']))?$row['first-name']:"";
                $lname = (isset($row['last-name']))?$row['last-name']:"";
                $transaksi = array( 'user_id' => $user_id,
                                    'id_router'=> $id_router,
                                    'status'   => 'INACTIVE',
                                    'profile'  => (isset($row['actual-profile']))?$row['actual-profile']:"",
                                    'price'    => $price,
                                    'operator_id'=> $op_id,
                                    'deskripsi'=> $row['username']."#".$fname." ". $lname
                                );

                $this->db->insert('tb_transaksi', $transaksi);
                
            }
            else
            {
                $return = array("ok"    => false,
                                "result"=> "Registrasi user Gagal \n".
                                           "ID trx TEL".now());
            }
        }
        else
        {
            $return = array("ok"    => false,
                            "result"=> "Server Offline \n".
                                       "ID trx TEL".now());
        }
        
        return $return;
        
    }

}

/* End of file Telegram_model.php */
?>