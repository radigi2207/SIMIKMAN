<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Frontend extends CI_Controller {

    public function index()
    {
        
    }

    public function register()
    {
        $data['content'] = $this->load->view('register',[], TRUE);        
        
        $this->load->view('theme', $data, FALSE);
        
    }

    public function activity()
    {
        $data['content'] = $this->load->view('register',[], TRUE);        
        
        $this->load->view('theme', $data, FALSE);
    }

}

/* End of file Frontend.php */

?>