<?php
$route['admin/cms']                 = 'cms';
$route['admin/cms/create']          = 'cms/create';
$route['admin/cms/delete/(:num)']   = 'cms/delete/$1';
$route['admin/cms/create_action']   = 'cms/create_action';
$route['admin/cms/update_action']   = 'cms/update_action';
$route['admin/cms/update/(:num)']   = 'cms/update/$1';
$route['admin/cms/update_status']   = 'cms/update_status';
$route['admin/cms/remove_featured_image']   = 'cms/remove_featured_image';

/* ======== For Post ========== */
$route['admin/cms/posts']                 = 'cms/posts';
$route['admin/cms/new_post']            = 'cms/new_post';
$route['admin/cms/create_action_post']  = 'cms/create_action_post';
$route['admin/cms/update_action_post']  = 'cms/update_action_post';
$route['admin/cms/update_post/(:any)']  = 'cms/update_post/$1';
$route['admin/cms/category']                = 'cms/option';
$route['admin/cms/category/create']         = 'cms/option/create';
$route['admin/cms/category/delete/(:num)']  = 'cms/option/delete/$1';
$route['admin/cms/category/update/(:num)']  = 'cms/option/update/$1';
$route['admin/cms/category/create_action']  = 'cms/option/create_action';
$route['admin/cms/category/update_action']  = 'cms/option/update_action';

$route['admin/cms/menu']                    = 'cms/menu';
$route['admin/cms/menu/add_menu']           = 'cms/menu/add_menu';
$route['admin/cms/menu/delete_menu']        = 'cms/menu/delete_menu';
$route['admin/cms/menu/add_page_to_menu']   = 'cms/menu/add_page_to_menu';
$route['admin/cms/menu/add_category_to_menu']   = 'cms/menu/add_category_to_menu';
$route['admin/cms/menu/add_custom_link_to_menu']   = 'cms/menu/add_custom_link_to_menu';
$route['admin/cms/menu/save_order']         = 'cms/menu/save_order';
$route['admin/cms/menu/item_remove']        = 'cms/menu/item_remove';
$route['admin/cms/menu/item_edit']          = 'cms/menu/item_edit';
$route['admin/cms/menu/item_edit_action']   = 'cms/menu/item_edit_action';

$route['admin/cms/widget']      = 'cms/widget';
$route['admin/cms/widget/add']  = 'cms/widget/add';
$route['admin/cms/widget/save'] = 'cms/widget/save';
$route['admin/cms/widget/delete'] = 'cms/widget/delete';


// Comments
$route['admin/cms/comment']      = 'cms/comment';
$route['admin/cms/comment/update/(:num)']  = 'cms/comment/update/$1';
$route['admin/cms/comment/update_action']  = 'cms/comment/update_action';
$route['admin/cms/comment/delete/(:num)']  = 'cms/comment/delete/$1';
