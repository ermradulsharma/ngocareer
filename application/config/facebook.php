<?php
defined('BASEPATH') or exit('No direct script access allowed');

/*
| -------------------------------------------------------------------
|  Facebook API Configuration
| -------------------------------------------------------------------
| Create your Facebook app at https://developers.facebook.com
| -------------------------------------------------------------------
*/

$config['facebook_app_id']     = '253177405873717';
$config['facebook_app_secret'] = '87ada42ba001b2d48de02a7bb4c8af24';

/*
| Use absolute URLs including base_url
| Example: https://ngocareer.com/auth/facebook/callback
*/

$config['facebook_login_redirect_url']     = base_url('auth/facebook/callback');
$config['facebook_logout_redirect_url']    = base_url('auth/logout'); // better to redirect to a logout handler

$config['employer_facebook_login_redirect_url']  = base_url('admin/auth/facebook/callback');
$config['employer_facebook_logout_redirect_url'] = base_url('admin/auth/logout');

$config['facebook_login_type']     = 'web';
$config['facebook_permissions']    = ['email'];
$config['facebook_graph_version']  = 'v19.0'; // update to latest
$config['facebook_auth_on_load']   = TRUE;
