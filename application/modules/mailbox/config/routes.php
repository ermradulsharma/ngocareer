<?php defined('BASEPATH') OR exit('No direct script access allowed');

$route['admin/mailbox']                 = 'mailbox';
$route['admin/mailbox/compose']         = 'mailbox/compose';
$route['admin/mailbox/send_action']     = 'mailbox/send_action';
$route['admin/mailbox/read/(:num)']     = 'mailbox/read/$1';
$route['admin/mailbox/delete/(:num)']   = 'mailbox/delete/$1';
$route['admin/mailbox/multi_delete']    = 'mailbox/batch_delete';


