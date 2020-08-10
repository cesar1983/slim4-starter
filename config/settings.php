<?php

use Monolog\Logger;

error_reporting(0);
ini_set('display_errors', '0');

// Timezone
date_default_timezone_set('America/Sao_Paulo');

// Settings
$settings = [

    'root' => dirname(__DIR__),
    'temp' => dirname(__DIR__) . '/tmp',
    'public' => dirname(__DIR__) . '/public',

    'error' => [
        'display_error_details' => true,
        'log_errors' => true,
        'log_error_details' => true,
    ],

    'logger' => [
        'name' => 'app',
        'path' => __DIR__ . '/../tmp/logs',
        'filename' => 'app.log',
        'level' => \Monolog\Logger::DEBUG,
        'file_permission' => 0775,
    ]
];




return $settings;
