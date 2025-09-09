<?php defined('BASEPATH') OR exit('No direct script access allowed');

$route['admin/job']                  = 'job';
$route['admin/job/create']           = 'job/create';
$route['admin/job/create_action']    = 'job/create_action';

$route['admin/job/update/(:num)']    = 'job/update/$1';
$route['admin/job/update_action']    = 'job/update_action';

$route['admin/job/preview/(:num)']    = 'job/preview/$1';
$route['admin/job/applicants/(:num)'] = 'job/applicants/$1';

$route['admin/job/archive/(:num)']    = 'job/archive/$1';
$route['admin/job/archive_action/(:num)']    = 'job/archive_action/$1';

$route['admin/job/application']      = 'job/application';
$route['admin/job/application_status']      = 'job/application_status';
$route['admin/job/get_sub_categoory/(:num)']      = 'job/get_sub_category/$1';

$route['admin/job/payment_form/(:num)']    = 'job/payment_form/$1';
$route['admin/job/make_payment']    = 'job/make_payment';

//$route['admin/job/stripe_payment']    = 'job/stripe_payment/index';
//$route['admin/job/stripe_payment/check']    = 'job/stripe_payment/check';


// Type
$route['admin/job/type']                  = 'job/type';
$route['admin/job/type/update/(:num)']    = 'job/type/update/$1';
$route['admin/job/type/read/(:num)']      = 'job/type/read/$1';
$route['admin/job/type/delete/(:num)']    = 'job/type/delete/$1';
$route['admin/job/type/create_action']    = 'job/type/create_action';
$route['admin/job/type/update_action']    = 'job/type/update_action';
$route['admin/job/type/delete_action/(:num)']    = 'job/type/delete_action/$1';

// Skill
$route['admin/job/skill']                  = 'job/skill';
$route['admin/job/skill/update/(:num)']    = 'job/skill/update/$1';
$route['admin/job/skill/read/(:num)']      = 'job/skill/read/$1';
$route['admin/job/skill/delete/(:num)']    = 'job/skill/delete/$1';
$route['admin/job/skill/create_action']    = 'job/skill/create_action';
$route['admin/job/skill/update_action']    = 'job/skill/update_action';
$route['admin/job/skill/delete_action/(:num)']    = 'job/skill/delete_action/$1';

// Category
$route['admin/job/category']                  = 'job/category';
$route['admin/job/category/update/(:num)']    = 'job/category/update/$1';
$route['admin/job/category/read/(:num)']      = 'job/category/read/$1';
$route['admin/job/category/delete/(:num)']    = 'job/category/delete/$1';
$route['admin/job/category/create_action']    = 'job/category/create_action';
$route['admin/job/category/update_action']    = 'job/category/update_action';
$route['admin/job/category/delete_action/(:num)']    = 'job/category/delete_action/$1';

// Sub Category
$route['admin/job/sub_category']                  = 'job/sub_category';
$route['admin/job/sub_category/update/(:num)']    = 'job/sub_category/update/$1';
$route['admin/job/sub_category/read/(:num)']      = 'job/sub_category/read/$1';
$route['admin/job/sub_category/delete/(:num)']    = 'job/sub_category/delete/$1';
$route['admin/job/sub_category/create_action']    = 'job/sub_category/create_action';
$route['admin/job/sub_category/update_action']    = 'job/sub_category/update_action';
$route['admin/job/sub_category/delete_action/(:num)']    = 'job/sub_category/delete_action/$1';

//Secttor
$route['admin/job/sector']                  = 'job/sector';
$route['admin/job/sector/update/(:num)']    = 'job/sector/update/$1';
$route['admin/job/sector/read/(:num)']      = 'job/sector/read/$1';
$route['admin/job/sector/delete/(:num)']    = 'job/sector/delete/$1';
$route['admin/job/sector/create_action']    = 'job/sector/create_action';
$route['admin/job/sector/update_action']    = 'job/sector/update_action';
$route['admin/job/sector/delete_action/(:num)']    = 'job/sector/delete_action/$1';

// Benefit
$route['admin/job/benefit']                  = 'job/benefit';
$route['admin/job/benefit/update/(:num)']    = 'job/benefit/update/$1';
$route['admin/job/benefit/read/(:num)']      = 'job/benefit/read/$1';
$route['admin/job/benefit/delete/(:num)']    = 'job/benefit/delete/$1';
$route['admin/job/benefit/create_action']    = 'job/benefit/create_action';
$route['admin/job/benefit/update_action']    = 'job/benefit/update_action';
$route['admin/job/benefit/delete_action/(:num)']    = 'job/benefit/delete_action/$1';


// Category
$route['admin/job/organization_type']                  = 'job/organization_type';
$route['admin/job/organization_type/update/(:num)']    = 'job/organization_type/update/$1';
$route['admin/job/organization_type/delete/(:num)']    = 'job/organization_type/delete/$1';
$route['admin/job/organization_type/create_action']    = 'job/organization_type/create_action';
$route['admin/job/organization_type/update_action']    = 'job/organization_type/update_action';




