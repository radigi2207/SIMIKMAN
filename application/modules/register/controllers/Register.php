<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Register extends CI_Controller {
    
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Register_model','register');
        $this->load->model('mikrotik/Mikrotik_model','mikrotik');
        
        
    }
    

    public function index()
    {
        $data = $this->input->post();
        if(!empty($data))
        {
            ($this->register->register($data));
            {
                $this->session->set_flashdata("register_msg","Terimakasih akun anda sudah berhasil registrasi silahkan <a href='".site_url("admin")."'>login</a>!");
            }
            // echo json_encode($data);
            
           

        }
        
        $this->load->view('sig-up',[], FALSE);
    }

    function usercek()
    {
        $get = $this->input->get();
        if($this->encrypt->decode($get['key'],$get['time']) == 'qazwsxedc')
        {
            if($this->register->usercek($get['username'])->num_rows() != 0)
            {
                echo "false";
            }
            else
                echo "true";
        }
        else
            echo "false";
    }

    function router()
    {
             
        $post = $this->input->post();
        if($post)
        {
            $return = array("code" => 200,
                            "msg"  => "Router baru berhasil ditambahkan",
                            "color"=> "#739E73");
            if($this->mikrotik->check_conn($post))
            {
                $this->session->set_userdata($post);
                $post['name'] = "Router 1";
                $post['status'] = 1;
                $router = $this->mikrotik->save_router($post)->row();

                $sess = array('hash' => $router->hash);
                $this->session->set_userdata($hash);

                logs("Admin","[Router]: settings Saved Successfully");
                $this->session->set_userdata("status","ACTIVE");
                

                $package = $this->mikrotik->checkPackage();
                foreach ($package as $row) {
                    switch ($row['name']) {
                        case 'user-manager':
                            $this->mikrotik->regUser();
                            $this->mikrotik->sessionUser();
                            logs("Admin","[Router]: Synchronization User Successfully");
                            break;
                        
                        default:
                            # code...
                            break;
                    }
                }
                redirect("admin#dasbord");
            }
            else
            {
                $this->session->set_flashdata("router_failed","Konfigurasi router yang anda masukan tidak bisa terhubung silahkan ulangi kembali!");
            }
            
        }
        $data['config'] = $post;
        $this->load->view('router', $data, FALSE);                
    }
}

/* End of file Register.php */
?>