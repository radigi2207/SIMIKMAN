<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class page extends CI_Controller {

    public function index()
    {        
        $this->smartadmin->is_ajax();        
        $this->load->view('datatables');        
    }

    public function dasbord()
    {
        $this->load->view('dasbord');
    }

    public function msg()
    {
        echo "hello word";
    }

}

/* End of file page.php */
?>