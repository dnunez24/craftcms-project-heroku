<?php

$cacheHost      = getenv('REDIS_HOST')      ?: 'localhost';
$cachePort      = getenv('REDIS_PORT')      ?: '6379';
$cachePassword  = getenv('REDIS_PASSWORD')  ?: '';

return [
    'hostname' => $cacheHost,
    'port'     => $cachePort,
    'password' => $cachePassword,
    'database' => 1,
    'timeout'  => null,
];
