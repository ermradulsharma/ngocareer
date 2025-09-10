<?php

defined('BASEPATH') or exit('No direct script access allowed');

date_default_timezone_set('UTC');
// error_reporting(0);

$config['base_url'] = 'http://localhost/ngocareer/';

$config['index_page']   = '';
$config['uri_protocol'] = 'REQUEST_URI';
$config['charset']      = 'UTF-8';

$config['enable_hooks']      = TRUE;
$config['subclass_prefix']   = 'MY_';
$config['composer_autoload'] = 'vendor/autoload.php';

$config['permitted_uri_chars'] = 'a-z 0-9~%.:_\-=+';

// Stripe (test keys only for dev)
$config['stripe_key']      = 'pk_test_tRoHr74FuGuljYM10pd7l40X';
$config['stripe_secret']   = 'sk_test_Gb55roaIktevZHx3PGUvyNcy';
$config['stripe_currency'] = 'GBP';

// Sessions
$config['sess_driver']             = 'files';
$config['sess_cookie_name']        = 'ci_session_';
$config['sess_expiration']         = 7200;
$config['sess_save_path']          = sys_get_temp_dir(); // safer for WSL
$config['sess_match_ip']           = FALSE;
$config['sess_time_to_update']     = 7200;
$config['sess_regenerate_destroy'] = FALSE;

// Cookies (safe for localhost)
$config['cookie_prefix']   = 'ngo_';
$config['cookie_domain']   = '';       // must stay empty for localhost
$config['cookie_path']     = '/';
$config['cookie_secure']   = false;    // no HTTPS locally
$config['cookie_httponly'] = true;     // keep secure

// CSRF (optional in dev, can enable in prod)
$config['csrf_protection']   = false;
$config['csrf_token_name']   = '_token';
$config['csrf_cookie_name']  = 'csrf_cookie_name';
$config['csrf_expire']       = 3600;
$config['csrf_regenerate']   = true;
$config['csrf_exclude_uris'] = array();

$config['log_threshold'] = 1; // show errors in dev
$config['time_reference'] = 'local';

$config['modules_locations'] = array(
    APPPATH . 'modules/' => '../modules/',
);
