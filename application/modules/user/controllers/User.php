<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->model('user_model','user');
        $this->load->model('mikrotik/mikrotik_model','mikrotik');
        
    }

    public function index()
    {
        $this->benchmark->mark('code_start');
		$data['user_mikrotik']  = $this->user->getUser();
        $data['voucher']        = $this->mikrotik->getProfile();
        

		$html = $this->load->view('user', $data, TRUE);
		$this->benchmark->mark('code_end');

        echo json_encode(array("times" =>$this->benchmark->elapsed_time('code_start', 'code_end'),
                               "html"  => $html));
    }
    public function add($id = NULL)
    {
        $post = $this->input->post();
        if($post)
        {
            if($id != NULL)
            {
                $id = explode("#",decode_url($id,'edit'));
                $return = array("code" => 200,
                                "msg"  => "Perubahan data user berhasil disimpan",
                                "color"=> "#739E73");
            }
                
            else
            {
                $return = array("code" => 200,
                                "msg"  => "user baru berhasil ditambahkan",
                                "color"=> "#739E73");
            }
            
            
            if(!$this->mikrotik->addUser($post,$id))
            {
                if($id != NULL)
                {
                    $return = array("code" => 201,
                                    "msg"  => "Perubahan data user tidak berhasil disimpan",
                                    "color"=> "#b93b3b");
                }
                else
                {
                    $return = array("code" => 201,
                                    "msg"  => "user baru tidak berhasil ditambahkan",
                                    "color"=> "#b93b3b");
                }
                
                
            }
            echo json_encode($return);
            return;
        }
        
        
        $this->benchmark->mark('code_start');

		if($this->input->get('edit'))
        {
            $id = explode("#",decode_url($this->input->get('edit'),'edit'));
            $data['user'] = (is_numeric($id[0])) ? $this->user->getUser($id[0])->row() : array();
            $data['edit'] = $this->input->get('edit');
           
        }
        $data['voucher']        = $this->mikrotik->getProfile();
        

		$html = $this->load->view('adduser', $data, TRUE);
		$this->benchmark->mark('code_end');

        echo json_encode(array("times" =>$this->benchmark->elapsed_time('code_start', 'code_end'),
                               "html"  => $html));
    }

    function transaksi($id = NULL)
    {

        $post = $this->input->post();
        if($post)
        {
            $post['id'] = decode_url($id,'transaksi');
            $this->mikrotik->userTransaksi($post);
            return;
        }
        
        $data['voucher']        = $this->mikrotik->getProfile();
        $data['transaksi']      = $this->mikrotik->userTransaksi(decode_url($id,'transaksi'));
        $data['user']           = $this->user->getUser(decode_url($id,'transaksi'))->row();
        $data['id']             = $id;
        $this->load->view('transaksi', $data, FALSE);
       
    }
    // function add()
    // {
    //     $post = $this->input->post();
    //     $this->mikrotik->addUser($post,false);
    //     logs("Admin","[Admin]: user berhasil ditambahkan");
    //     redirect('user','refresh');
        
    // }

    function del($id = NULL)
    {
        (($id != NULL) ? $this->mikrotik->delUser($id) : false);
        $this->index();
    }

    function user_req()
    {
        $r = array("radi");

        echo json_encode($r);
    }

    function cekuser($type, $edit = NULL)
    {
        if($edit != NULL)
        {
            echo "true";
            return;
        }
        $data = $this->user->cekuser($this->input->get("username"),$type);
        if($data->num_rows() == 1)
            echo "false";
        else
            echo "true";
        return;
    }


}


?>