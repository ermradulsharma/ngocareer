<?php defined('BASEPATH') or exit('No direct script access allowed');

$route['admin/candidate']                  = 'candidate';
$route['admin/candidate/create']           = 'candidate/create';
$route['admin/candidate/update/(:num)']    = 'candidate/update/$1';
$route['admin/candidate/read/(:num)']      = 'candidate/read/$1';
$route['admin/candidate/delete/(:num)']    = 'candidate/delete/$1';
$route['admin/candidate/create_action']    = 'candidate/create_action';
$route['admin/candidate/update_action']    = 'candidate/update_action';
$route['admin/candidate/delete_action/(:num)']    = 'candidate/delete_action/$1';


//$route['admin/candidate/details/(:num)']    = 'candidate/details/$1';
$route['admin/candidate/popup/(:num)']      = 'candidate/popup/$1';
$route['admin/candidate/set_status']        = 'candidate/set_status';
