<?php
defined('BASEPATH') or exit('No direct script access allowed');

/*
| -------------------------------------------------------------------
|  Google API Configuration
| -------------------------------------------------------------------
| Create your app at: https://console.developers.google.com
| -------------------------------------------------------------------
*/

$config['client_id']        = getenv('GOOGLE_CLIENT_ID') ?: '242205860397-967o9jfhalit8a6palb687gt9q1uo75c.apps.googleusercontent.com';
$config['client_secret']    = getenv('GOOGLE_CLIENT_SECRET') ?: 'R_FRdDf6BqAcnuVcEPNVgLHb';

/*
| Redirect URIs must exactly match those configured in Google Cloud Console.
| Use base_url() so it works both locally and on server.
*/
$config['redirect_uri']          = base_url('auth/google/callback');
$config['employer_redirect_uri'] = base_url('admin/auth/google/callback');

$config['application_name'] = 'NGO_Career';
$config['api_key']          = ''; // optional, only needed for certain APIs
$config['scopes']           = ['profile', 'email'];
