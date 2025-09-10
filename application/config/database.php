<?php
defined('BASEPATH') or exit('No direct script access allowed');

$active_group = 'default';
$query_builder = TRUE;

// ---------------------
// Default MySQL connection
// ---------------------
$db['default'] = array(
    'dsn'       => '',
    'hostname'  => 'localhost',      // Use 'localhost' for local development
    'username'  => 'root',           // Your local MySQL username
    'password'  => 'P@$$w0rd',               // Your local MySQL password
    'database'  => 'ngocareer_db',      // Local database name
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
