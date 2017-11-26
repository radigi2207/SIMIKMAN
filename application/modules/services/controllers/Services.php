<?

defined('BASEPATH') OR exit('No direct script access allowed');

class Services extends CI_Controller {

    
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Services_model','services');
        
    }
    

    public function index()
    {
        
    }

    function hotspot()
    {
        $this->benchmark->mark('code_start');
        

        $html = $this->load->view('Hotspot', [], TRUE);
        $this->benchmark->mark('code_end');

        echo json_encode(array("times" =>$this->benchmark->elapsed_time('code_start', 'code_end'),
                                "html"  => $html));
    }

    function pppoe()
    {

    }

    function bandwidth()
    {
        $this->benchmark->mark('code_start');
        

        $data['bandwidth']  = $this->services->bandwidth();

        $html = $this->load->view('Bandwidth', $data, TRUE);
        $this->benchmark->mark('code_end');

        echo json_encode(array("times" =>$this->benchmark->elapsed_time('code_start', 'code_end'),
                                "html"  => $html));
    }

    function addBandwidth($id = NULL)
    {
        $post = $this->input->post();
        if($post)
        {
            $post['rate_limit'] = ($post['rate_down'] && $post['rate_upload']) ? $post['rate_down'].$post['rate_down_unit']."/".$post['rate_upload'].$post['rate_upload_unit']:NULL;
            $return = array("code" => 200,
                            "msg"  => "Bandwidth baru berhasil disimpan",
                            "color"=> "#739E73");
            
            if(!$this->services->addBandwidth($post,$id))
            {
                if($id != NULL)
                {
                    $return = array("code" => 201,
                                    "msg"  => "Perubahan Bandwidth tidak berhasil disimpan",
                                    "color"=> "#b93b3b");
                }
                else
                {
                    $return = array("code" => 201,
                                    "msg"  => "Bandwidth baru tidak berhasil disimpan.",
                                    "color"=> "#b93b3b");
                }
                
            }
            elseif($id != NULL)
            {
               
                $return = array("code" => 200,
                                "msg"  => "Perubahan Bandwidth berhasil disimpan",
                                "color"=> "#739E73");

            }
            echo json_encode($return);
            return ;
        }
        $data = array();
        if($id != NULL)
        {
            $id = decode_url($id,'edit');
            $data['bandwidth']  = $this->services->bandwidth($id)->row();
        }
        $this->load->view('AddBandwidth', $data, FALSE);
        
    }

    function delBandwidth($id = NULL)
    {
        if($id != NULL)
        {
            $id = decode_url($id,"del");
            $this->services->delBandwidth($id);
            $this->bandwidth();
            
        }
    }

    function checkBandwidth($col, $edit = NULL)
    {
        $get = $this->input->get('val');
        if($edit != NULL)
        {
            echo "true";
            return;
        }
        $data = $this->services->checkBandwidth($get,$col);
        if($data->num_rows() == 1)
            echo "false";
        else
            echo "true";
        return;
    }

}

/* End of file Service.php */
?>
