<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
| -------------------------------------------------------------------
|  Facebook API Configuration
| -------------------------------------------------------------------
|
| To get an facebook app details you have to create a Facebook app
| at Facebook developers panel (https://developers.facebook.com)
|
|  facebook_app_id               string   Your Facebook App ID.
|  facebook_app_secret           string   Your Facebook App Secret.
|  facebook_login_redirect_url   string   URL to redirect back to after login. (do not include base URL)
|  facebook_logout_redirect_url  string   URL to redirect back to after logout. (do not include base URL)
|  facebook_login_type           string   Set login type. (web, js, canvas)
|  facebook_permissions          array    Your required permissions.
|  facebook_graph_version        string   Specify Facebook Graph version. Eg v3.2
|  facebook_auth_on_load         boolean  Set to TRUE to check for valid access token on every page load.
*/

/****IQBAL APP*/
//$config['facebook_app_id']                = '680590722421957';
//$config['facebook_app_secret']            = '3b14ad61b04e93957617b18455c41758';

/****LIVE*/
$config['facebook_app_id']                = '253177405873717';
$config['facebook_app_secret']            = '87ada42ba001b2d48de02a7bb4c8af24';
        
$config['facebook_login_redirect_url']    = 'auth/facebook/callback/';
$config['facebook_logout_redirect_url']   = 'auth/facebook/callback';//It not working

$config['employer_facebook_login_redirect_url']    = 'admin/auth/facebook/callback/';
$config['employer_facebook_logout_redirect_url']   = 'admin/auth/facebook/callback';//It not working
$config['facebook_login_type']            = 'web';
$config['facebook_permissions']           = array('email');
$config['facebook_graph_version']         = 'v3.2';
$config['facebook_auth_on_load']          = TRUE;