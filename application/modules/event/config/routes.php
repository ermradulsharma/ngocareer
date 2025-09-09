<?php defined('BASEPATH') OR exit('No direct script access allowed');

$route['admin/event']                  = 'event';
$route['admin/event/create']           = 'event/create';
$route['admin/event/update/(:num)']    = 'event/update/$1';
$route['admin/event/payment_form/(:num)']    = 'event/payment_form/$1';
$route['admin/event/read/(:num)']      = 'event/read/$1';
$route['admin/event/delete/(:num)']    = 'event/delete/$1';
$route['admin/event/create_action']    = 'event/create_action';
$route['admin/event/update_action']    = 'event/update_action';
$route['admin/event/delete_action/(:num)']    = 'event/delete_action/$1';
$route['admin/event/make_payment']    = 'event/make_payment';

$route['admin/event/category']                  = 'event/category';
$route['admin/event/category/create']           = 'event/category/create';
$route['admin/event/category/update/(:num)']    = 'event/category/update/$1';
$route['admin/event/category/create_action']    = 'event/category/create_action';
$route['admin/event/category/update_action']    = 'event/category/update_action';
$route['admin/event/category/delete']           = 'event/category/delete';
