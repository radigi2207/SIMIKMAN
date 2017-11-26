<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Auth extends CI_Controller {

    
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Auth_model', 'auth');
        
    }
    
    function index()
    {
        // if($this->session->userdata("login"))
        // {
        //     redirect("admin#dasbord");
        //     return;
        // }
        $this->config->set_item('csrf_protection',FALSE);
        $data['post'] = ($this->input->get())? $this->input->get() : NULL;// redirect("http://cybers-s.net","refresh");

        $this->load->view('hotspot_login', $data, FALSE);
        
    }

    function forgot()
    {
        $this->load->view('forgot',[], FALSE);
    }

    public function admin()
    {
        $data = $this->input->post();
        $cookie = get_cookie('auth');
        if(isset($cookie) && !$data)
        {
            $auth = $this->encryption->decrypt($cookie);
            $auth = explode("##2304##",$auth);
            $data['username'] = $auth[0];
            $data['id']       = $auth[1];
            $cookie   = true;
        }
        else
            $cookie = false;

        $remember = (isset($data['remember'])) ? true : false ;

        if(!empty($data))
        {
            
            $user = $this->auth->get_user($data);
            if($user->num_rows() == 1)
            {
                $user = $user->row();
                if($cookie && $user->id == $data['id'])
                {                    
                    $url = $this->success($user,$remember);
                    
                    logs("Admin","[Auth]: login success by cookie");
                    redirect($url,'refresh');      

                }
                elseif(password_verify($data['password'],$user->password))
                {
                    $url = $this->success($user,$remember);                    
 
                    logs("Admin","[Auth]: Admin Login Successful");
                    redirect($url,'refresh');     
                }
                else
                {
                    $this->session->set_flashdata("login_failed","Nama pengguna atau kata sandi yang anda masukan tidak terdaftar!");

                }
            }
            else
            {
                $this->session->set_flashdata("login_failed","Nama pengguna atau kata sandi yang anda masukan tidak terdaftar!");
            }
        }
        
        $this->load->view('sig-in',[], FALSE);
        
    }

    function logout()
    {
        logs("Admin","admin Logout Successful");
        $this->session->sess_destroy();
        delete_cookie('auth');
        
        redirect(site_url('auth'));
    }
    private function success($user, $remember)
    {
        $session = array(   'login'    => true,
                            'username' => $user->username,
                            'user_id'  => $user->id,
                            'user_name'=> $user->first_name." ". $user->last_name,
                            'status'   => $user->status,
                            'key'      => random_string('alnum', 16)
                        );

        $this->session->set_userdata($session);
        
        if($user->status == "ACTIVE")
        {
            if($remember)
            {
                
                $val = $this->encryption->encrypt($user->username."##2304##".$user->id);
                $cookie = array('name'   => 'auth',
                            'value'  => $val,
                            'expire' => 24 * 3600,
                            'path'   => '/',
                );
                set_cookie($cookie);
            }
            $router = $this->auth->get_router($user->id);
            if($router->num_rows() != 0)
            {
                $router = $router->row();
                $session['user']    = $router->user;
                $session['pass']    = $router->pass;
                $session['port']    = $router->port;
                $session['host']    = $router->host;
                $session['id_router'] =   $router->id;
                $session['hash']    = $router->hash;
                $this->session->set_userdata($session);
            }
            else
            {
                return site_url('register/router');
            }

            return site_url('admin#dasbord');
        }
        else
        {
            return site_url('router');
        } 
    }
    

}

/* End of file Auth.php */
?>