<?php defined('BASEPATH') OR exit('No direct script access allowed');

$route['admin/slider']                  = 'slider';
$route['admin/slider/create']           = 'slider/create';
$route['admin/slider/create_action']    = 'slider/create_action';

$route['admin/slider/update/(:num)']    = 'slider/update/$1';
$route['admin/slider/update_action']    = 'slider/update_action';

$route['admin/slider/delete']           = 'slider/delete';
$route['admin/slider/reorder']          = 'slider/reorder';
$route['admin/slider/setStatus']        = 'slider/setStatus';