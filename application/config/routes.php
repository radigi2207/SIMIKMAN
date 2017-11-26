<?php
defined('BASEPATH') OR exit('No direct script access allowed');


$route['default_controller'] = 'auth';
$route['404_override'] = '';
$route['general_override'] = 'error/general';
$route['translate_uri_dashes'] = FALSE;


//AUTH
// $route['register']     = 'auth/register';
$route['logout']    = 'auth/logout';

$route['login']   = 'auth/hotspot';
$route['admin/login']   = 'auth/admin';
$route['forgot']    = 'auth/forgot';


// FRONTEND

// $route['register']      = 'frontend/register';
$route['activity']      = 'frontend/activity';

$route['dasbord']       = "admin/dasbord";

//Register
$route['router']        = 'register/router';
$route['check_mikrotik'] = 'mikrotik';
$route['usercek']       = 'register/usercek';


//Mikrotik
$route['sysinfo']       = 'mikrotik/systemInfo';
$route['disconnect']    = 'mikrotik/disconnect';


//Setting
$route['routerSet']     = 'setting/routerset';

$route['donasi']        = 'admin/donasi';



