<?php
defined('BASEPATH') or exit('No direct script access allowed');

date_default_timezone_set('UTC');
error_reporting(0);

$config['index_page']      = '';
$config['uri_protocol']    = 'REQUEST_URI';
$config['url_suffix']      = '';
$config['language']        = 'english';
$config['charset']         = 'UTF-8';
$config['enable_hooks']    = TRUE;
$config['subclass_prefix'] = 'MY_';

$config['composer_autoload'] = 'vendor/autoload.php';

// Security
$config['permitted_uri_chars'] = 'a-z 0-9~%.:_\-=+&,';
// Environment-based Configuration
$is_dev = ENVIRONMENT === 'development';

// Base URL
$config['base_url'] = getenv('BASE_URL') ?: 'http://localhost:8000/';

// Encryption Key (Must be set in .env for production)
$config['encryption_key'] = getenv('ENCRYPTION_KEY') ?: '7f804b86a87752762263d91689230538';

// Logging (Log everything in dev, errors only in prod)
$config['log_threshold'] = $is_dev ? 1 : 1;

// Sessions
$config['sess_driver']             = 'files';
$config['sess_cookie_name']        = 'ci_session_';
$config['sess_expiration']         = 7200;
$config['sess_save_path']          = getenv('SESS_SAVE_PATH') ?: sys_get_temp_dir();
$config['sess_match_ip']           = FALSE;
$config['sess_time_to_update']     = 7200;
$config['sess_regenerate_destroy'] = FALSE;

// Cookies
$config['cookie_prefix']   = 'ngo_';
$config['cookie_domain']   = getenv('COOKIE_DOMAIN') ?: '';
$config['cookie_path']     = '/';
$config['cookie_secure']   = filter_var(getenv('COOKIE_SECURE'), FILTER_VALIDATE_BOOLEAN);
$config['cookie_httponly'] = true;

// CSRF
$config['csrf_protection']   = FALSE;
$config['csrf_token_name']   = '_token';
$config['csrf_cookie_name']  = 'csrf_cookie_name';
$config['csrf_expire']       = 3600;
$config['csrf_regenerate']   = true;
$config['csrf_exclude_uris'] = array();

// Stripe
$config['stripe_key']      = getenv('STRIPE_KEY') ?: 'pk_test_tRoHr74FuGuljYM10pd7l40X';
$config['stripe_secret']   = getenv('STRIPE_SECRET') ?: 'sk_test_Gb55roaIktevZHx3PGUvyNcy';
$config['stripe_currency'] = getenv('STRIPE_CURRENCY') ?: 'GBP';
