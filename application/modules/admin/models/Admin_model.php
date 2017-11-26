<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Admin_model extends CI_Model {

    

    function dasbord()
    {
        $this->db->select("SUM(download) AS 'download', SUM(upload) AS 'upload', UNIX_TIMESTAMP(date_created) AS 'datetime'")
                 ->from("tb_sessionuser")
                 ->where("id_router", $this->session->userdata("id_router"))
                 ->where("DATE_FORMAT(date_created,'%Y%m')", "DATE_FORMAT(now(),'%Y%m')",false);
        
        $data['statistik_paket'] = $this->db->get()->row();

        $this->db->select("SUM(IF(status = 1,1,0)) AS 'aktif', count(status) AS 'count'")
                 ->where("id_router", $this->session->userdata("id_router"))
                 ->from("tb_userman");
        $data['count_user'] = $this->db->get()->row();

        //logs
        $this->db->where('user_id', $this->session->userdata("user_id"))
                 ->where("type","Admin")
                 ->order_by('date', 'desc');
        $data['logs'] = $this->db->get('tb_logs',5)->result_array();

        //Log User
        $this->db->where('user_id', $this->session->userdata("user_id"))
                 ->where("type","User")
                 ->order_by('date', 'desc');
        $data['userlogin'] = $this->db->get('tb_logs',5)->result_array();

        //pendapatan
        $this->db->select("SUM(IF(date_format(now(),'%y/%m/%d') = date_format(t.date,'%y/%m/%d'), t.price,0)) 'hari_ini',
                          SUM(IF(date_format(now(),'%y/%m') = date_format(t.date,'%y/%m'), t.price,0)) 'bulan_ini'")
                 ->join("tb_user_router r","r.id = t.id_router")
                 ->where("r.user_id", $this->session->userdata("user_id"));
        $data['pendapatan'] = $this->db->get('tb_transaksi t')->row();        
        
        
       
        return $data;
    }
}

/* End of file Admin_model.php */

?>