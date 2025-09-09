<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
| -------------------------------------------------------------------
|  Google API Configuration
| -------------------------------------------------------------------
| 
| To get API details you have to create a Google Project
| at Google API Console (https://console.developers.google.com)
| 
|  client_id         string   Your Google API Client ID.
|  client_secret     string   Your Google API Client secret.
|  redirect_uri      string   URL to redirect back to after login.
|  application_name  string   Your Google application name.
|  api_key           string   Developer key.
|  scopes            string   Specify scopes
*/
/*IQBAL APP*/
//$config['client_id']        = '650324242997-9408p03u8caj6b9499flev8b53uvrp93.apps.googleusercontent.com';
//$config['client_secret']    = 'XmVEReyerGJ7f89kWOp6l9Z8';

$config['client_id']        = '242205860397-967o9jfhalit8a6palb687gt9q1uo75c.apps.googleusercontent.com';
$config['client_secret']    = 'R_FRdDf6BqAcnuVcEPNVgLHb';

//$config['redirect_uri']     = 'http://localhost/ngocareer/auth/google/callback';
//$config['employer_redirect_uri']     = 'http://localhost/ngocareer/admin/auth/google/callback';

$config['redirect_uri']             = 'http://localhost/ngocareer//auth/google/callback';
$config['employer_redirect_uri']    = 'http://localhost/ngocareer//admin/auth/google/callback';

$config['application_name'] = 'NGO_Career';
$config['api_key']          = '';
$config['scopes']           = array('profile', 'email' );