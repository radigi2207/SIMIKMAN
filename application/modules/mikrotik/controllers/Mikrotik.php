<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Mikrotik extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Mikrotik_model', 'mikrotik');
    }

    public function index()
    {
        //$this->mikrotik->profileLimitation();
        $this->config->set_item('csrf_protection',FALSE);
        $data = $this->input->get();
        if($this->mikrotik->check_conn($data))
        {
            $this->session->set_userdata($data);
            $this->mikrotik->save_router($data);
            logs("Admin","[Router]: settings Saved Successfully");
            $this->session->set_userdata("status","ACTIVE");
            $data = array('msg'     => 'Koneksi Sukses',
                          'class'   => 'text-success',
                          'kode'    => 200 );
            $session = array();
            $this->gen_user_first();
            
            
        }
        else
        {
            $data = array('msg'     => 'Koneksi Gagal',
                          'class'   => 'text-danger',
                          'kode'    => 505 );
        }
        echo json_encode($data);
        // echo strlen(strpos("radi","0"));
    }


    function x()
    {
        echo json_encode($this->mikrotik->x());
    }
    function session($user_id = NULL)
    {
        echo json_encode($this->mikrotik->sessionUser($user_id));
    }

    function hotspot_notif($user_id = NULL)
    {
        $get = $this->input->get();
        
        $this->mikrotik->setUserStatus($get,$user_id);
    }
    
    function gen_user_first()
    {
        $this->mikrotik->regUser();
        $this->mikrotik->sessionUser();
        $this->mikrotik->genRouter();
        logs("Admin","[Router]: Synchronization User Successfully");

    }
    function systemInfo()
    {
        echo json_encode($this->mikrotik->systemInfo());
    }

    function disconnect()
    {
        $this->benchmark->mark('code_start');

		$html = $this->load->view('errors/html/disconnect',[], TRUE);
		$this->benchmark->mark('code_end');

        echo json_encode(array("times" =>$this->benchmark->elapsed_time('code_start', 'code_end'),
                               "html"  => $html));
    }

}

/* End of file Controllername.php */
?>