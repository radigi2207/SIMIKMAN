<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Report extends CI_Controller {

    
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Report_model','report');
        
    }
    

    public function days()
    {
        $this->benchmark->mark('code_start');
        
        
        $data['days'] = $this->report->days();
        $html = $this->load->view('days', $data, TRUE);
        $this->benchmark->mark('code_end');

        echo json_encode(array("times" =>$this->benchmark->elapsed_time('code_start', 'code_end'),
                                "html"  => $html));
    }

    public function periode()
    {
        $this->benchmark->mark('code_start');
        
        
        $data['days'] = $this->report->days();
        $html = $this->load->view('periode', $data, TRUE);
        $this->benchmark->mark('code_end');

        echo json_encode(array("times" =>$this->benchmark->elapsed_time('code_start', 'code_end'),
                                "html"  => $html));
    }

    function get_periode()
    {
        $post = $this->input->get();
        $html = "";
        $data = $this->report->periode($post);
        $i = 1;
        $jml = 0;
        foreach ($data->result_array() as $row) {
            $user = explode("#",$row['deskripsi']);
            $html .= "<tr>";
                $html .= "<td>".$i++."</td>";
                $html .= "<td>[<b>$user[0]</b>] $user[1]</td>";
                $html .= "<td>$row[profile]</td>";
                $html .= "<td>$row[date]</td>";
                $html .= "<td class=text-right>".number_format($row['price'],0,',','.')."</td>";
                $html .= "<td>".ucfirst($row['first_name']." ". $row['last_name'])."</td>";
            $html .= "</tr>";
            $jml += $row['price'];
        }
        $footer = "<tr>";
            $footer .= "<td colspan=4 class=text-center> <strong>JUMLAH</strong></td>";
            $footer .= "<td class=text-right><strong>".number_format($jml,0,',','.')."</strong></td>";
            $footer .= "<td class=text-right></td>";
        $footer .= "</tr>";

        if($data->num_rows() == 0)
        {
            $html = "<tr>";
                $html .= "<td colspan=6 class=text-center><i>tidak ada data ditemukan</i></td>";
            $html .= "</tr>";
        }

        echo json_encode(array("html" => $html,
                               "footer" => $footer));
    }

    function agen()
    {
        $this->benchmark->mark('code_start');
        
        
        $data['days'] = $this->report->days();
        $data['agen'] = $this->report->get_agen();
        $html = $this->load->view('agen', $data, TRUE);
        $this->benchmark->mark('code_end');

        echo json_encode(array("times" =>$this->benchmark->elapsed_time('code_start', 'code_end'),
                                "html"  => $html));
    }

    function get_agen()
    {
        $post = $this->input->get();
        $html = "";
        $data = $this->report->periode($post);
 
        $i = 1;
        $jml = 0;
        foreach ($data->result_array() as $row) {
            $user = explode("#",$row['deskripsi']);
            $html .= "<tr>";
                $html .= "<td>".$i++."</td>";
                $html .= "<td>[<b>$user[0]</b>] $user[1]</td>";
                $html .= "<td>$row[profile]</td>";
                $html .= "<td>$row[date]</td>";
                $html .= "<td class=text-right>".number_format($row['price'],0,',','.')."</td>";
                $html .= "<td>".ucfirst($row['first_name']." ". $row['last_name'])."</td>";
            $html .= "</tr>";
            $jml += $row['price'];
        }
        $footer = "<tr>";
            $footer .= "<td colspan=4 class=text-center> <strong>JUMLAH</strong></td>";
            $footer .= "<td class=text-right><strong>".number_format($jml,0,',','.')."</strong></td>";
            $footer .= "<td class=text-right></td>";
        $footer .= "</tr>";

        if($data->num_rows() == 0)
        {
            $html = "<tr>";
                $html .= "<td colspan=6 class=text-center><i>tidak ada data ditemukan</i></td>";
            $html .= "</tr>";
        }

        echo json_encode(array("html" => $html,
                               "footer" => $footer));
    }

}

/* End of file Report.php */
?>