<?

function log_query($query, $id = null,$ket = null, $modul = null)
{
    $CI =& get_instance();
    if($id != null)
    {
        $query = str_replace('VALUES (NULL','VALUES ('.$id,$query);
    }
    $CI->db->insert('tb_log',array('query' => $query, 'ket' => $ket, 'modul' => $modul));
}

function logs($type,$desc, $user_id = NULL, $ip = NULL)
{
    $CI =& get_instance();
    $data = array("id"  => NULL,
                  "type"=> $type,
                  "description" => $desc,
                  "user_id"    => isset($user_id)? $user_id : $CI->session->userdata("user_id"),
                  "ip"         => isset($ip) ? $ip : $CI->input->ip_address());
    $CI->db->insert('tb_logs',$data);
}
?>