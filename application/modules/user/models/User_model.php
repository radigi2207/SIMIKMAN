<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User_model extends CI_Model {

    function add_user($data)
    {
        return $this->db->insert("tb_user_hotspot",$data);
    }

    function getUser($id = NULL)
    {

        $this->db->select("u.*");
        $this->db->from("tb_userman u");
        $this->db->where("id_router", $this->session->userdata("id_router"));
        ($id != NULL) ? $this->db->where('id', $id) : false;
        $this->db->order_by("tgl_insert","ASC");
        $data = $this->db->get();
        return $data;
    }

    function cekuser($data,$type)
    {
        $this->db->select("u.*");
        $this->db->from("tb_userman u");
        $this->db->where("id_router", $this->session->userdata("id_router"));
        $this->db->where($type, $data);
        $data = $this->db->get();
        return $data;
    }

    

}

/* End of file User_model.php */
?>