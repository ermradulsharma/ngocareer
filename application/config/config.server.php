<?php

defined('BASEPATH') or exit('No direct script access allowed');

date_default_timezone_set('Europe/London');

$config['base_url'] = 'https://ngocareer.com/'; // use HTTPS and no extra slash

$config['index_page']   = '';
$config['uri_protocol'] = 'REQUEST_URI';
$config['charset']      = 'UTF-8';

$config['enable_hooks']      = TRUE;
$config['subclass_prefix']   = 'MY_';
$config['composer_autoload'] = 'vendor/autoload.php';

$config['permitted_uri_chars'] = 'a-z 0-9~%.:_\-=';

// Stripe (live keys should go here in prod, not test keys)
$config['stripe_key']      = 'YOUR_LIVE_PUBLISHABLE_KEY';
$config['stripe_secret']   = 'YOUR_LIVE_SECRET_KEY';
$config['stripe_currency'] = 'GBP';

// Logging
$config['log_threshold'] = 1; // log errors only
$config['log_date_format'] = 'Y-m-d H:i:s';

// Encryption
$config['encryption_key'] = 'PUT_A_RANDOM_SECRET_KEY_HERE'; // must set in prod!

// Sessions
$config['sess_driver']             = 'files';
$config['sess_cookie_name']        = 'ci_session_';
$config['sess_expiration']         = 7200;
$config['sess_save_path']          = '/var/www/ngocareer/writable/sessions'; // secure writable path
$config['sess_match_ip']           = FALSE;
$config['sess_time_to_update']     = 7200;
$config['sess_regenerate_destroy'] = FALSE;

// Cookies
$config['cookie_prefix']   = 'ngo_';
$config['cookie_domain']   = '.ngocareer.com'; // works for root + subdomains
$config['cookie_path']     = '/';
$config['cookie_secure']   = true;  // requires HTTPS
$config['cookie_httponly'] = true;  // prevents JavaScript access

// CSRF (must enable in production)
$config['csrf_protection']   = true;
$config['csrf_token_name']   = '_token';
$config['csrf_cookie_name']  = 'csrf_cookie_name';
$config['csrf_expire']       = 3600;
$config['csrf_regenerate']   = true;
$config['csrf_exclude_uris'] = array();

$config['time_reference'] = 'local';

$config['modules_locations'] = array(
    APPPATH . 'modules/' => '../modules/',
);
