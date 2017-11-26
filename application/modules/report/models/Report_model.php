<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Report_model extends CI_Model {

    
    function days()
    {

        $this->db->join('tb_user u', 'u.id = operator_id', 'left');
                
        $this->db->where("date_format(date,'%Y-%m-%d')", "date_format(now(),'%Y-%m-%d')",FALSE);
        $this->db->where('id_router', $this->session->userdata('id_router'));
        $this->db->order_by('date', 'asc');        
        return $this->db->get('tb_transaksi');        
    }

    function periode($data)
    {
        $this->db->select("*");
        $this->db->from('tb_transaksi t');
        $this->db->join('tb_user u', 'u.id = operator_id', 'left');
        $this->db->join('tb_user_group ug', 'ug.id = u.id_group', 'left');
        (isset($data['agen']) && $data['agen'] == "ALL") ? $this->db->where('u.id_group',5) : NULL;
        (isset($data['agen']) && $data['agen'] != "ALL") ? $this->db->where('u.id', $data['agen']) : NULL;
        
        $this->db->where('t.date >=',"STR_TO_DATE('$data[startdate] 00:00:00','%d-%m-%Y %H:%i:%s')",false);        
        $this->db->where('t.date <=',"STR_TO_DATE('$data[finishdate] 23:59:59','%d-%m-%Y %H:%i:%s')",false);
        $this->db->where('id_router', $this->session->userdata('id_router'));
        
        $return = $this->db->get();
        return $return;
    }

    function get_agen()
    {

        $this->db->where('u.id_group', 5);        
        $this->db->order_by('u.tgl_insert', 'asc');
        
        return $this->db->get('tb_user u');
        
    }

    function agen($data)
    {
        $this->db->select("*");
        $this->db->from('tb_transaksi t');
        $this->db->join('tb_user u', 'u.id = operator_id', 'left');
        $this->db->join('tb_user_group ug', 'ug.id = u.id_group', 'left');
        
        $this->db->where('t.date >=',"STR_TO_DATE('$data[startdate] 00:00:00','%d-%m-%Y %H:%i:%s')",false);        
        $this->db->where('t.date <=',"STR_TO_DATE('$data[finishdate] 23:59:59','%d-%m-%Y %H:%i:%s')",false);
        ($data['agen'] != 'ALL') ? $this->db->where('u.id', $data['agen']): NULL;        
        
        $this->db->where('id_router', $this->session->userdata('id_router'));
        
        $return = $this->db->get();
        return $return;
    }

}

/* End of file Report_model.php */
?>