<?php

defined('BASEPATH') OR exit('No direct script access allowed');

$active_group = 'default';
$query_builder = TRUE;

$db['default'] = array(
    'dsn' => '',
//    'hostname' => 'shareddb-s.hosting.stackcp.net',
//    'username' => 'ngocareer-3132350ab6',
//    'password' => 'orj2t0q5dg',
//    'database' => 'ngocareer-3132350ab6',
//    
    'hostname' => 'sdb-c.hosting.stackcp.net',
    'username' => 'ngocareer-3739d81d',
    'password' => '1O$*(jnlzkyly',
    'database' => 'ngocareer-3739d81d',

    'dbdriver' => 'mysqli',
    'dbprefix' => '',
    'pconnect' => FALSE,
    'db_debug' => (ENVIRONMENT !== 'production'),
    'cache_on' => FALSE,
    'cachedir' => '',
    'char_set' => 'utf8',
    'dbcollat' => 'utf8_general_ci',
    'swap_pre' => '',
    'encrypt' => FALSE,
    'compress' => FALSE,
    'stricton' => FALSE,
    'failover' => array(),
    'save_queries' => TRUE
);

/* For only Keeping DB Backup Logs */
$db['sqlite'] = array(
    'dsn'      => 'sqlite:DB/backup_logs.sqlite',   // path/to/database
    'dbdriver' => 'pdo'
);
