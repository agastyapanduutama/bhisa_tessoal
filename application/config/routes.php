<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$route['default_controller'] = 'C_login/login';
$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;


$route['admin/login'] = 'C_login/login';
$route['admin/login/aksi'] = 'C_login/aksi';
$route['admin/logout'] = 'C_login/logout';


$route['admin'] = 'admin/C_home/index';
$route['admin/home'] = 'admin/C_home/index';
