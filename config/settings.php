<?php

// Error reporting for production

use Monolog\Logger;

error_reporting(0);
ini_set('display_errors', '0');

// Timezone
date_default_timezone_set('America/Sao_Paulo');

// Settings
$settings = [];

// Path settings
$settings['root']   = dirname(__DIR__);
$settings['temp']   = $settings['root'] . '/tmp';
$settings['public'] = $settings['root'] . '/public';

// Error Handling Middleware settings
$settings['error'] = [
    'display_error_details' => true,
    'log_errors' => true,
    'log_error_details' => true,
];

$settings['logger'] = [
    'name' => 'slim-app',
    'path' => isset($_ENV['docker']) ? 'php://stdout' : 'var/logs/app.log',
    'level' => Logger::DEBUG,
];

$settings['doctrine'] =  [

    // TODO Disable in production
    'dev_mode' => true,

    // TODO Enable in production
    'cache_dir' => null,
    // 'cache_dir' => __DIR__ . '/../var/cache/doctrine',

    // TODO Enable in production
    'proxy_dir' => null,
    // 'proxy_dir' => __DIR__ . '/../var/proxies',
    'metadata_dirs' => [__DIR__ . '/../src/Domain/'],

    'connection' => [
        'driver' => 'pdo_mysql',
        'host' => 'localhost',
        'port' => 3306,
        'dbname' => 'world',
        'user' => 'root',
        'password' => '123456',
        'charset' => 'utf-8'
    ]
];


return $settings;
