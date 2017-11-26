<?php

function load_stats()
{
    $CI =& get_instance();
    $CI->load->library("RouterosAPI");

    $API = new RouterosAPI();
    if($CI->session->userdata("login") &&
       $CI->uri->segment(1) != "logout" &&
       $CI->uri->segment(1) != "admin" &&
       $CI->uri->segment(1) != "routerSet" &&
       $CI->uri->segment(2) != "router" &&
       $CI->uri->segment(2) != "addRouter" &&
       $CI->uri->segment(2) != "cekipRouter" &&
       $CI->uri->segment(2) != "nameRouter"
       )
    {
        $API->port = ($CI->session->userdata("port")) ? $CI->session->userdata("port") : $API->port;
        $host      = $CI->session->userdata("host");
        $user      = $CI->session->userdata("user");
        $pass      = $CI->session->userdata("pass");

        ($API->connect($host,$user,$pass)) ? true : show_error("Maaf Tidak bisa terhubung ke device silahkan cek konfigurasi",408);
        
        // echo json_encode($CI->session->userdata());
    }
    


    
}
