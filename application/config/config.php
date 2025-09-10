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
$config['encryption_key']      = '';

// Logging
$config['log_threshold']        = 0;
$config['log_file_permissions'] = 0644;
$config['log_date_format']      = 'Y-m-d H:i:s';

// Sessions
$config['sess_driver']             = 'files';
$config['sess_cookie_name']        = 'ci_session_';
$config['sess_expiration']         = 7200;
$config['sess_save_path']          = NULL;
$config['sess_match_ip']           = FALSE;
$config['sess_time_to_update']     = 7200;
$config['sess_regenerate_destroy'] = FALSE;

// Cookies (override in local/server configs)
$config['cookie_prefix']   = 'ngo_';
$config['cookie_path']     = '/';
$config['cookie_secure']   = false; // overridden later
$config['cookie_httponly'] = true;

// CSRF
$config['csrf_protection']   = false;
$config['csrf_token_name']   = '_token';
$config['csrf_cookie_name']  = 'csrf_cookie_name';
$config['csrf_expire']       = 3600;
$config['csrf_regenerate']   = true;
$config['csrf_exclude_uris'] = array();

$config['compress_output']    = FALSE;
$config['time_reference']     = 'local';
$config['rewrite_short_tags'] = FALSE;

$config['modules_locations'] = array(
    APPPATH . 'modules/' => '../modules/',
);

// Load environment overrides
$host = $_SERVER['HTTP_HOST'] ?? 'localhost';

if (strpos($host, 'localhost') !== false || strpos($host, '127.0.0.1') !== false) {
    include __DIR__ . '/config.local.php';
} else {
    include __DIR__ . '/config.server.php';
}
