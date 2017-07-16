<?php

/**
 * Database Configuration
 *
 * All of your system's database configuration settings go in here.
 * You can see a list of the default settings in craft/app/etc/config/defaults/db.php
 */

$sqlMode  = "SET SESSION sql_mode='";
$sqlMode .= "STRICT_TRANS_TABLES,";
$sqlMode .= "NO_ZERO_IN_DATE,";
$sqlMode .= "NO_ZERO_DATE,";
$sqlMode .= "ERROR_FOR_DIVISION_BY_ZERO,";
$sqlMode .= "NO_AUTO_CREATE_USER,";
$sqlMode .= "NO_ENGINE_SUBSTITUTION';";

$database      = getenv('MYSQL_DATABASE')   ?: 'craftcms';
$password      = getenv('MYSQL_PASSWORD')   ?: 'craftcms';
$port          = getenv('MYSQL_PORT')       ?: '3306';
$server        = getenv('MYSQL_HOST')       ?: 'localhost';
$user          = getenv('MYSQL_USER')       ?: 'craftcms';

return [
    'database'      => $database,
    'initSQLs'      => [
        $sqlMode,
    ],
    'password'      => $password,
    'port'          => $port,
    'server'        => $server,
    'user'          => $user,
];
