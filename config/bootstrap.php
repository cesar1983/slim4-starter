<?php

use DI\ContainerBuilder;
use Slim\App;

require_once __DIR__ . '/../vendor/autoload.php';
$containerBuilder = new ContainerBuilder();

// Setup settings
$containerBuilder->addDefinitions(__DIR__ . '/container.php');

// Build PHP-DI Container instance
$container = $containerBuilder->build();

// Create App instance
$app = $container->get(App::class);

// Register routes
$routes = require __DIR__ . '/routes.php';
$routes($app);

// Register middleware
$middleware = require __DIR__ . '/middleware.php';
$middleware($app);


return $app;
