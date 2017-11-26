<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Profile extends CI_Controller {

    
    public function __construct()
    {
        parent::__construct();
        $this->load->model('mikrotik/Mikrotik_model',"mikrotik");
        
    }
    

    public function index()
    {

        $this->benchmark->mark('code_start');
		$data['profiles'] = $this->mikrotik->getProfile();
        $data['limitation'] = $this->mikrotik->getLimitation();
        $data['pf'] = false;
        
        

		$html = $this->load->view('profile', $data, TRUE);
		$this->benchmark->mark('code_end');

        echo json_encode(array("times" =>$this->benchmark->elapsed_time('code_start', 'code_end'),
                               "html"  => $html));
    }

    //tambah profile
    public function addProfile($id = NULL)
    {
        // (!$this->input->is_ajax_request()) ? show_404() : true;
        $post = ($this->input->post()) ? $this->input->post(): NULL;
        $data = array();
        if($post)
        {
            $return = array("code" => 200,
                            "msg"  => "Profile berhasil disimpan",
                            "color"=> "#739E73");
            if(!$this->mikrotik->addProfile($post,$id))
            {
                $return = array("code" => 201,
                                "msg"  => "Profile tidak berhasil disimpan",
                                "color"=> "#b93b3b");
            }

            echo json_encode($return);
            return;

        }

        if($id != NULL)
        {
            $data['profile'] = $this->mikrotik->getProfile($id)->row();
        }

        echo $this->load->view('addProfile', $data,TRUE);
        
    }

    //Delete Profile
    function delProfile($id = NULL)
    {
        $id = decode_url($id,'delprofile');
        $this->mikrotik->delProfile($id);
        $this->index();
        
    }

    //Form Profile Limitations
    function limit($profile = NULL)
    {
        if($profile != NULL)
        {
            $dt  = $this->mikrotik->getProfileLimitationid(decode_url($profile,'limit'));
            $new_data = array();
            $result = array();
            foreach ($dt as $row) {
                $new_data['from_time'] = mitime($row['from-time']);
                $new_data['till_time'] = mitime($row['till-time']);
                $new_data['weekdays']  = explode(",",$row['weekdays']);
                $new_data['id']        = $row['.id'];
                $new_data['limitation']= $row['limitation'];
                $new_data['profile']   = $row['profile'];
    
                $result[] = $new_data;
    
            }
            // echo json_encode($result);
            // exit;
            $data['profile'] = $profile;
            $data['week'] = array("sunday","monday","tuesday","wednesday","thursday","friday","saturday");
            $data['limit'] = $result;
            $data['limitation'] = $this->mikrotik->getLimitation();
            
            $this->load->view('limitprofile', $data);
            
        }
    }

    //tambah profile limitations
    function ProfileLimitation($profile)
    {
        $post = $this->input->post();
        $profile = decode_url($profile,'limit');

        $data = $this->mikrotik->addProfileLimitation($post,$profile);        
        // redirect('profile','refresh');
        echo json_encode($data);
        
    }

    //Page Limitaitons
    public function limitations()
    {

        $this->benchmark->mark('code_start');
		$data['limitations'] = $this->mikrotik->getLimitation();        

		$html = $this->load->view('limitation', $data, TRUE);
		$this->benchmark->mark('code_end');

        echo json_encode(array("times" =>$this->benchmark->elapsed_time('code_start', 'code_end'),
                               "html"  => $html));
    }

    //Menambah limitations
    public function addLimitation($limit = NULL)
    {
        $limit = ($limit != NULL) ? decode_url($limit,"limit") : NULL;
        $data = $this->input->post();
        if($data)
        {
            $return = array("code" => 200,
                            "msg"  => "Limitations berhasil disimpan",
                            "color"=> "#739E73");
            if(!$this->mikrotik->addLimitation($data,$limit))
            {
                $return = array("code" => 201,
                                "msg"  => "Limitations tidak berhasil disimpan",
                                "color"=> "#b93b3b");
            }
            echo json_encode($return);
            return;
        }
        $data['edit'] = ($limit != NULL) ? encode_url($limit,'limit') : NULL;
        $data['limit'] = $this->mikrotik->getLimitationid($limit)->row();

        $this->load->view('addlimitation', $data);
        // $id = $this->input->get("id");
        // $post = ($this->input->post()) ? $this->input->post(): show_404();
        // ((isset($id)) ? $this->mikrotik->addLimitation($post,$id) : $this->mikrotik->addLimitation($post));
        
    }
    //hapus Limitaion
    function delLimitation($id = NULL)
    {
        $id = decode_url($id,"delete");
        $this->mikrotik->delProfileLimitation($id);
        $this->limitations();
        
    }
    
    

    function getProfileAjax()
    {
        (!$this->input->is_ajax_request()) ? show_404() : true;
        echo json_encode($this->mikrotik->getProfile());
    }

    

    

    

    


    //Profile Limitation
    function getProfileLimitation()
    {
        
        // (!$this->input->is_ajax_request()) ? show_404(): true;
        $data  = $this->mikrotik->getProfileLimitationid($this->input->get("profile"));
        $new_data = array();
        $result = array();
        foreach ($data as $row) {
            $new_data['from_time'] = mitime($row['from-time']);
            $new_data['till_time'] = mitime($row['till-time']);
            $new_data['weekdays']  = explode(",",$row['weekdays']);
            $new_data['id']        = $row['.id'];
            $new_data['limitation']= $row['limitation'];
            $new_data['profile']   = $row['profile'];

            $result[] = $new_data;

        }
        // echo json_encode($result);
        // exit;
        $data['profile'] = $this->input->get("profile");
        $data['week'] = array("sunday","monday","tuesday","wednesday","thursday","friday","saturday");
        $data['limit'] = $result;
        $data['limitation'] = $this->mikrotik->getLimitation();
        $this->load->view('ProfileLimitation', $data, FALSE);
    }

}

/* End of file Profile.php */

?>