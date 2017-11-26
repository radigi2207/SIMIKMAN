
<?php
defined('BASEPATH') OR exit('No direct script access allowed');

include_once APPPATH.'/third_party/lib/config.php';

//include_once "inc/init.php";
include_once "inc/config.ui.php";
class Smartadmin extends SmartUI
{
    protected $ci; 

    public function __construct()
    {
        $this->ci = & get_instance();
        SmartUI::$icon_source = '';
        // register our UI plugins
        SmartUI::register('widget', 'Widget');
        SmartUI::register('datatable', 'DataTable');
        SmartUI::register('button', 'Button');
        SmartUI::register('tab', 'Tab');
        SmartUI::register('accordion', 'Accordion');
        SmartUI::register('carousel', 'Carousel');
        SmartUI::register('smartform', 'SmartForm');
        SmartUI::register('nav', 'Nav');
        //$CI->load->database();
    }
    public function ribbon()
    {
        return '<div id="ribbon">
                    <span class="ribbon-button-alignment"> 
                        <a id="refresh" class="btn btn-ribbon" href="javascript:history.go(-1)" ><i class="fa fa-arrow-circle-left"></i></a> 
                    </span>
                    
                    <ol class="breadcrumb">
                    </ol>
                </div>';
    }

    function nav($user)
    {
        $user = 1; //Akses ALL menu
        $menu = array();
        $parent =  $this->ci->db->select('*')
                                ->from('tb_menu m')
                                ->join('tb_akses a','m.id_menu = a.menu')
                                ->join("tb_user u", "u.id_group = a.id_group")
                                ->where('m.parent',NULL)
                                ->where('m.disable', 0)
                                ->where('u.id',$user)
                                ->order_by('m.posisi', 'ASC')
                                ->get();
        foreach($parent->result_array() as $row)
        {
            $x = $this->ci->db->select('*')
                              ->from('tb_menu m')                              
                              ->join('tb_akses a','m.id_menu = a.menu')
                              ->join("tb_user u", "u.id_group = a.id_group")
                              ->where('m.parent',$row['id_menu'])
                              ->where('m.disable', 0)
                              ->where('u.id',$user)
                              ->order_by('m.posisi', 'ASC')
                              ->get();
            if($x->num_rows() != 0)
            {
                $menu[$row['title']] = array('title' => $row['title'],
                                             'icon'  => $row['icon'],
                                             'sub'   => array());
                foreach($x->result_array() as $row_c)
                {
                    $y = $this->ci->db->select('*')
                                      ->from('tb_menu m')
                                      ->join('tb_akses a','m.id_menu = a.menu')
                                      ->join("tb_user u", "u.id_group = a.id_group")
                                      ->where('m.parent',$row_c['id_menu'])
                                      ->where('m.disable', 0)
                                      ->where('u.id',$user)
                                      ->order_by('m.posisi', 'ASC')
                                      ->get();

                    if($y->num_rows() != 0)
                    {
                        $menu[$row['title']]['sub'][$row_c['title']] = array('title' => $row_c['title'],
                                                                             'icon'  => $row_c['icon'],
                                                                             'sub'   => array());
                        foreach($y->result_array() as $row_y)
                        {
                            $menu[$row['title']]['sub'][$row_c['title']]['sub'][$row_y['title']] = array('title' => $row_y['title'],
                                                                                                         'icon'  => $row_y['icon'],
                                                                                                         'url'   => ($row_y['url']));
                            
                        }
                    }
                    else
                    {
                        $menu[$row['title']]['sub'][$row_c['title']] =  array('title' => $row_c['title'],
                                                                              'icon'  => $row_c['icon'],
                                                                              'url'   => ($row_c['url']));
                    }
                }
                
            }
            else
            {
                $menu[$row['title']] = array('title'    => $row['title'],
                                             'icon'     => $row['icon'],
                                             'url'      => ($row['url']));
            }
        }

        return $menu;
        
    }

    function is_ajax()
    {
        $header = apache_request_headers();
        if(isset($header['X-Requested-With']) && $header['X-Requested-With'] == 'XMLHttpRequest')
            return true;
        show_404();
    }

    function router()
    {
        $this->ci->db->where("user_id", $this->ci->session->userdata('user_id'));
        $router_all = $this->ci->db->get("tb_user_router");
        $html = "<div class='header-search pull-right'>
                    <section>
                    <label class='select'>
                        <select class='input-sm' id='router-selected'>";        
        foreach ($router_all->result_array() as $row) 
        {
            $select = ($row['status'] == 1) ? "selected" : "";
            $html .= "<option value='$row[id]' $select>$row[name]</option>";
        }
        $html .="</select><i></i></label></section></div>";
        return $html;
    }
}

/* End of file LibraryName.php */
?>