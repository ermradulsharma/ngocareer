<?php

$route['admin/newsletter_subscriber']                 = 'newsletter_subscriber';
$route['admin/newsletter_subscriber/create_action']   = 'newsletter_subscriber/create_action';
$route['admin/newsletter_subscriber/update_action']   = 'newsletter_subscriber/update_action';
$route['admin/newsletter_subscriber/update/(:num)']   = 'newsletter_subscriber/update/$1';
$route['admin/newsletter_subscriber/delete/(:num)']   = 'newsletter_subscriber/delete/$1';
$route['admin/newsletter_subscriber/export_csv']      = 'newsletter_subscriber/export_csv';


$route['newsletter_unsubscribe']      = 'newsletter_subscriber/ajax/unsubscribe';
$route['alert_unsubscribe']      = 'newsletter_subscriber/ajax/alert_unsubscribe';
