<?php
defined('BASEPATH') or exit('No direct script access allowed');

$active_group = 'default';
$query_builder = TRUE;

// ---------------------
// Default MySQL connection
// ---------------------
// -------------------------------------------------------------------
// Dynamic Database Connection
// -------------------------------------------------------------------
// Load database.local.php if in development or localhost
// Load database.server.php otherwise

$host = $_SERVER['HTTP_HOST'] ?? 'localhost';

// -------------------------------------------------------------------
// Database Connection
// -------------------------------------------------------------------

$db['default'] = array(
    'dsn'       => '',
    'hostname'  => getenv('DB_HOSTNAME') ?: 'localhost',
    'username'  => getenv('DB_USERNAME') ?: 'root',
    'password'  => getenv('DB_PASSWORD') ?: 'P@$$w0rd',
    'database'  => getenv('DB_DATABASE') ?: 'ngocareer_db',
    'dbdriver'  => 'mysqli',
    'dbprefix'  => '',
    'pconnect'  => FALSE,
    'db_debug'  => (ENVIRONMENT !== 'production'),
    'cache_on'  => FALSE,
    'cachedir'  => '',
    'char_set'  => 'utf8',
    'dbcollat'  => 'utf8_general_ci',
    'swap_pre'  => '',
    'encrypt'   => FALSE,
    'compress'  => FALSE,
    'stricton'  => FALSE,
    'failover'  => array(),
    'save_queries' => TRUE
);

// ---------------------
// SQLite for backup logs
// ---------------------
$db['sqlite'] = array(
    'dsn'       => 'sqlite:' . FCPATH . 'DB/backup_logs.sqlite', // Use full path
    'dbdriver'  => 'pdo',
    'database'  => '',          // Not needed for PDO SQLite
    'username'  => '',
    'password'  => '',
    'db_debug'  => (ENVIRONMENT !== 'production'),
    'cache_on'  => FALSE,
    'cachedir'  => '',
    'char_set'  => 'utf8',
    'dbcollat'  => 'utf8_general_ci',
    'swap_pre'  => '',
    'encrypt'   => FALSE,
    'compress'  => FALSE,
    'stricton'  => FALSE,
    'failover'  => array(),
    'save_queries' => TRUE
);
