<?php

$route['admin/module']                 = 'module';
$route['admin/module/create']          = 'module/create';
$route['admin/module/create_action']   = 'module/create_action';
$route['admin/module/update_action']   = 'module/update_action';
$route['admin/module/read/(:any)']     = 'module/read/$1';
$route['admin/module/update/(:any)']   = 'module/update/$1';
$route['admin/module/delete/(:any)']   = 'module/delete/$1';
$route['admin/module/add_module_acls'] = 'module/add_module_acls';

$route['admin/module/acl']                    = 'module/acl';
$route['admin/module/acl/create']             = 'module/acl/create';        
$route['admin/module/acl/read/(:num)']        = 'module/acl/read/$1';
$route['admin/module/acl/delete/(:num)']      = 'module/acl/delete/$1';
$route['admin/module/acl/update/(:num)']      = 'module/acl/update/$1';
$route['admin/module/acl/create_action']      = 'module/acl/create_action';
$route['admin/module/acl/update_action']      = 'module/acl/update_action';
