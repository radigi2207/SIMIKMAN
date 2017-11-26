<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Setting extends CI_Controller {

    
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Setting_model', 'setting');
        $this->load->model('mikrotik/Mikrotik_model','mikrotik');
        
        
        
    }
    

    public function index()
    {
        $this->mikrotik->syncron();
    }
    

    function admin()
    {
        $post = $this->input->post();
        if($post)
        {
            $return = array("code" => 200,
                            "msg"  => "Data user berhasil disimpan",
                            "color"=> "#739E73");
            if(!$this->setting->updateUser($post))
            {
                $return = array("code" => 201,
                                "msg"  => "Data user tidak berhasil disimpan",
                                "color"=> "#b93b3b");
            }
            echo json_encode($return);
            return;
        }
        $this->benchmark->mark('code_start');
		$data['user']     = $this->setting->getUser()->row();
        
        

		$html = $this->load->view('admin', $data, TRUE);
        
		$this->benchmark->mark('code_end');

        echo json_encode(array("times" =>$this->benchmark->elapsed_time('code_start', 'code_end'),
                               "html"  => $html));
    }
    //routes
    public function radius()
    {
        $this->benchmark->mark('code_start');
		$data['routers']     = $this->setting->getRadius();
        
        

		$html = $this->load->view('radius', $data, TRUE);
        
		$this->benchmark->mark('code_end');

        echo json_encode(array("times" =>$this->benchmark->elapsed_time('code_start', 'code_end'),
                               "html"  => $html));
        
        
        // $this->load->view('theme', $page, FALSE);
        
    }

    function addRadius($id = NULL)
    {
        $post = $this->input->post();
        $data = array();
        if($post)
        {

            $this->mikrotik->addRadius($post,$id);
            
            $this->radius();
            return;
        }
        elseif($id != NULL)
        {
            $data['id_api'] = $id;
            $id = decode_url($id,'edit');
            $data['radius'] = $this->setting->getRadius($id)->row();
            
        }
        $this->load->view('addRadius', $data, FALSE);
        
        
    }

    function delRadius($id = NULL)
    {
        if($id != NULL)
        {
            $id = decode_url($id,'delradius');
            $this->mikrotik->delRadius($id);
        }
        $this->radius();
        return;
    }
    
    function cekname($edit = NULL)
    {
        if($edit != NULL)
        {
            echo "true";
            return;
        }
        $data = $this->setting->getRadius($this->input->get("name"));
        if($data->num_rows() == 1)
            echo "false";
        else
            echo "true";
        return;
    }


    function cekip($edit = NULL)
    {
        if($edit != NULL)
        {
            echo "true";
            return;
        }
        $data = $this->setting->cekRadius($this->input->get("ip"),'ip');
        if($data->num_rows() == 1)
            echo "false";
        else
            echo "true";
        return;
    }


    function routerset()
    {
        $get = $this->input->get();
        echo json_encode($this->setting->setRouter($get));
    }

    function router()
    {
        $this->benchmark->mark('code_start');
		$data['routers']     = $this->setting->getRouter();
        
        

		$html = $this->load->view('router', $data, TRUE);
        
		$this->benchmark->mark('code_end');

        echo json_encode(array("times" =>$this->benchmark->elapsed_time('code_start', 'code_end'),
                               "html"  => $html));
    }

    function addRouter($id = NULL)
    {
        $post = $this->input->post();
        $data = array();
        if($post)
        {
            if($id == NULL)
            {

                $return = array("code" => 200,
                                "msg"  => "Router baru berhasil ditambahkan",
                                "color"=> "#739E73");
                if($this->mikrotik->check_conn($post))
                {
                    $this->session->set_userdata($post);
                    $router = $this->mikrotik->save_router($post)->row();
    
                    $sess = array('hash' => $router->hash);
                    $this->session->set_userdata($sess);
    
                    logs("Admin","[Router]: settings Saved Successfully");
    
                    $package = $this->mikrotik->checkPackage();
                    foreach ($package as $row) {
                        switch ($row['name']) {
                            case 'user-manager':
                                $this->mikrotik->regUser($router->id);
                                $this->mikrotik->syncron($router->id);
                                logs("Admin","[Router]: Synchronization User Successfully");
                                break;
                            
                            default:
                                # code...
                                break;
                        }
                    }
                    
                }
                else
                {
                    $return = array("code" => 201,
                                    "msg"  => "Router baru tidak berhasil disimpan.",
                                    "color"=> "#b93b3b");
                }
                    
                
            }
            else
            {
                $return = array("code" => 200,
                                "msg"  => "Konfigurasi Router berhasil diperbaharui",
                                "color"=> "#739E73");

                $id = decode_url($id,'edit');
                if($this->mikrotik->check_conn($post))
                {
                    $this->mikrotik->editRouter($post,$id);
                    
                }
                else
                {
                    $return = array("code" => 201,
                                    "msg"  => "Tidak bisa menyimpan konfigurasi router baru.",
                                    "color"=> "#b93b3b");
                }

            }
            
            echo json_encode($return);
            return;
            
        }
        elseif($id != NULL)
        {
            $id = decode_url($id,'edit');
            $data['id_api'] = $id;
            
            $data['router'] = $this->setting->getRouter($id)->row();
            
        }
        $this->load->view('addRouter', $data, FALSE);
    }

    function delRouter($id = NULL)
    {
        if($id != NULL)
        {
            $id = decode_url($id,'delrouter');
            echo $this->setting->delRouter($id);
        }
        $this->router();
        return;
    }

    function nameRouter($edit = NULL)
    {
        if($edit != NULL)
        {
            echo "true";
            return;
        }
        $data = $this->setting->cekRouter($this->input->get("name"),"name");
        if($data->num_rows() == 1)
            echo "false";
        else
            echo "true";
        return;
    }


    function cekipRouter($edit = NULL)
    {
        if($edit != NULL)
        {
            echo "true";
            return;
        }
        $data = $this->setting->cekRouter($this->input->get("host"),'host');
        if($data->num_rows() == 1)
            echo "false";
        else
            echo "true";
        return;
    }

}

/* End of file Setting.php */
?>