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


$route['admin/user'] = 'admin/C_user/list';
$route['admin/user/data'] = 'admin/C_user/data';
$route['admin/user/get/(:any)'] = 'admin/C_user/get/$1';
$route['admin/user/set/(:any)/(:any)'] = 'admin/C_user/set/$1/$2';
$route['admin/user/insert'] = 'admin/C_user/insert';
$route['admin/user/update'] = 'admin/C_user/update';
$route['admin/user/delete/(:any)'] = 'admin/C_user/delete/$1';


$route['admin/jabatan'] = 'admin/C_jabatan/list';
$route['admin/jabatan/data'] = 'admin/C_jabatan/data';
$route['admin/jabatan/get/(:any)'] = 'admin/C_jabatan/get/$1';
$route['admin/jabatan/set/(:any)/(:any)'] = 'admin/C_jabatan/set/$1/$2';
$route['admin/jabatan/insert'] = 'admin/C_jabatan/insert';
$route['admin/jabatan/update'] = 'admin/C_jabatan/update';
$route['admin/jabatan/delete/(:any)'] = 'admin/C_jabatan/delete/$1';

$route['admin/barang'] = 'admin/C_barang/list';
$route['admin/barang/data'] = 'admin/C_barang/data';
$route['admin/barang/get/(:any)'] = 'admin/C_barang/get/$1';
$route['admin/barang/set/(:any)/(:any)'] = 'admin/C_barang/set/$1/$2';
$route['admin/barang/insert'] = 'admin/C_barang/insert';
$route['admin/barang/update'] = 'admin/C_barang/update';
$route['admin/barang/delete/(:any)'] = 'admin/C_barang/delete/$1';


$route['admin/satuan'] = 'admin/C_satuan/list';
$route['admin/satuan/data'] = 'admin/C_satuan/data';
$route['admin/satuan/get/(:any)'] = 'admin/C_satuan/get/$1';
$route['admin/satuan/set/(:any)/(:any)'] = 'admin/C_satuan/set/$1/$2';
$route['admin/satuan/insert'] = 'admin/C_satuan/insert';
$route['admin/satuan/update'] = 'admin/C_satuan/update';
$route['admin/satuan/delete/(:any)'] = 'admin/C_satuan/delete/$1';


$route['admin/transaksi'] = 'admin/C_transaksi/list';
$route['admin/transaksi/add'] = 'admin/C_transaksi/add';
$route['admin/transaksi/edit/(:any)'] = 'admin/C_transaksi/edit/$1';
$route['admin/transaksi/detail/(:any)'] = 'admin/C_transaksi/detail/$1';
$route['admin/transaksi/print_transaksi/(:any)'] = 'admin/C_transaksi/print_transaksi/$1';
$route['admin/transaksi/data'] = 'admin/C_transaksi/data';
$route['admin/transaksi/get/(:any)'] = 'admin/C_transaksi/get/$1';
$route['admin/transaksi/set/(:any)/(:any)'] = 'admin/C_transaksi/set/$1/$2';
$route['admin/transaksi/insert'] = 'admin/C_transaksi/insert';
$route['admin/transaksi/update'] = 'admin/C_transaksi/update';
$route['admin/transaksi/delete/(:any)'] = 'admin/C_transaksi/delete/$1';