<?php

$route['admin/profile']                         = 'profile';
$route['admin/profile/business']                = 'profile/business';
$route['admin/profile/update']                  = 'profile/update';
$route['admin/profile/update_action']           = 'profile/update_action';
$route['admin/profile/profile_update_action']   = 'profile/profile_update_action';
$route['admin/profile/business_update_action']  = 'profile/business_update_action';
$route['admin/profile/update_photo']            = 'profile/update_photo';
$route['admin/profile/update_logo']             = 'profile/update_logo';
$route['admin/profile/delete_photo']            = 'profile/delete_photo';

$route['admin/profile/password']                = 'profile/password';

$route['admin/profile/update_password']         = 'profile/update_password';

$route['admin/profile/validate_input/(:any)']   = 'profile/validate_input/$1';

$route['admin/profile/services']                = 'profile/services';
$route['admin/profile/service_action']          = 'profile/service_action';
$route['admin/profile/service_delete/(:num)']         = 'profile/service_delete/$1';
$route['admin/profile/service_update']          = 'profile/service_update';
$route['admin/profile/serviceForm/(:num)']             = 'profile/serviceForm/$1';