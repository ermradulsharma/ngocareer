<?php

/* Users Management [ Admin, Editor, Vendor, Customer etc everyone ] */
$route['admin/users']                   = 'users';

$route['admin/users/profile/(:num)']    = 'users/profile/$1';
$route['admin/users/create']            = 'users/create';
$route['admin/users/create_action']     = 'users/create_action';
$route['admin/users/create_company']     = 'users/create_company';
$route['admin/users/create_action_company']     = 'users/create_action_company';
$route['admin/users/update_action_company']     = 'users/update_action_company';
$route['admin/users/password/(:num)']   = 'users/password/$1';
$route['admin/users/update/(:num)']     = 'users/update/$1';
$route['admin/users/update_action']     = 'users/update_action';
$route['admin/users/freeze/(:num)']     = 'users/freeze/$1';

$route['admin/profile']                 = 'users/profile';

/* Roles Controller */
$route['admin/users/roles']         = 'users/roles';
$route['admin/users/roles/create']  = 'users/roles/create';
$route['admin/users/roles/rename']  = 'users/roles/rename';
$route['admin/users/roles/delete']  = 'users/roles/delete';
$route['admin/users/roles/update']  = 'users/roles/update';
$route['admin/users/roles/getAcl']  = 'users/roles/getAcl';


$route['admin/users/roles/update_acl']    = 'users/roles/update_acl';
$route['admin/users/seller_status']       = 'users/seller_status';

$route['admin/users/password/(:num)']     = 'users/password/$1';
$route['admin/users/reset_password']      = 'users/reset_password';
$route['admin/users/setStatus']           = 'users/setStatus';
$route['admin/users/set_status']          = 'users/set_status';

$route['admin/users/login_history']                 = 'users/login_history';
$route['admin/users/login_history/graph']           = 'users/login_history/graph';
$route['admin/users/login_history/delete']          = 'users/login_history/delete';
$route['admin/users/login_history/bulk_action']     = 'users/login_history/bulk_action';