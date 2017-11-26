
<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Admin extends CI_Controller {

    
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Admin_model',"admin");
        $this->load->model('mikrotik/Mikrotik_model','mikrotik');
        $this->load->model('mikrotik/Monitor_model','monitor');
        
        
    }
    
    public function index()
	{
		if(!empty($this->session->userdata('login')) && $this->session->userdata('login'))
		{
            if($this->session->userdata("status") == "ACTIVE")
            {
                
                $this->load->view('theme');
            }
            else
                
                redirect('register/router','refresh');
                
			return;
		}
		redirect(site_url('admin/login'));
		
	}
    public function dasbord()
    {
        // (!$this->input->is_ajax_request()) ? show_404():true;
        
        $this->benchmark->mark('code_start');
		$dasbord = $this->admin->dasbord();
        $data['paket']      = $dasbord['statistik_paket'];
        $data['user']       = $dasbord['count_user'];
        $data['logs']       = $dasbord['logs'];
        $data['userlogin']  = $dasbord['userlogin'];
        $data['interface']  = $this->monitor->getInterface();
        $data['sysinfo']    = $this->monitor->systemInfo();
        $data['pendapatan'] = $dasbord['pendapatan'];
        $data['routerboard']= $this->monitor->routerboard();
        

		$html = $this->load->view('dasbord', $data, TRUE);
		$this->benchmark->mark('code_end');

        echo json_encode(array("times" =>$this->benchmark->elapsed_time('code_start', 'code_end'),
                               "html"  => $html));
    }

    function profile($user)
    {
        echo $user;
    }

    public function msg()
    {
        echo json_encode($this->monitor->routerboard());
    }

    public function monitorInterface()
    {
        $interface = $this->input->get("interface");
        $m = $this->monitor->monitorInterface($interface);
        $return = array();
        $data = array('rx' => $m['rx-bits-per-second'],
                      'tx' => $m['tx-bits-per-second'],
                      'interface' => $m['name']);
        array_push($return,$data);
        echo json_encode($return);
    }

    function donasi()
    {
        // 0066425258100
        $this->benchmark->mark('code_start');
        $html = $this->load->view('donasi', [], TRUE);
		$this->benchmark->mark('code_end');

        echo json_encode(array("times" =>$this->benchmark->elapsed_time('code_start', 'code_end'),
                               "html"  => $html));
    }

}

/* End of file Admin.php */
?>