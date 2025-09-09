<?php defined('BASEPATH') OR exit('No direct script access allowed');

$route['admin/package']                  = 'package';
$route['admin/package/create']           = 'package/create';
$route['admin/package/update/(:num)']    = 'package/update/$1';
$route['admin/package/create_action']    = 'package/create_action';
$route['admin/package/update_action']    = 'package/update_action';
