<?php

use Psr\Container\ContainerInterface;
use Slim\App;
use Slim\Factory\AppFactory;
use Slim\Middleware\ErrorMiddleware;

use Doctrine\Common\Annotations\AnnotationReader;
use Doctrine\Common\Cache\FilesystemCache;
use Doctrine\DBAL\Connection;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Mapping\Driver\AnnotationDriver;
use Doctrine\ORM\Tools\Setup;
use Monolog\Handler\StreamHandler;
use Monolog\Logger;
use Monolog\Processor\UidProcessor;

return [
    'settings' => function () {
        return require __DIR__ . '/settings.php';
    },


    /**
     * Services
     */

    App::class => function (ContainerInterface $container) {
        AppFactory::setContainer($container);

        return AppFactory::create();
    },


    ErrorMiddleware::class => function (ContainerInterface $container) {
        $app = $container->get(App::class);
        $settings = $container->get('settings')['error'];

        return new ErrorMiddleware(
            $app->getCallableResolver(),
            $app->getResponseFactory(),
            (bool)$settings['display_error_details'],
            (bool)$settings['log_errors'],
            (bool)$settings['log_error_details']
        );
    },


    LoggerInterface::class => function (ContainerInterface $container) {

        $loggerSettings = $container->get('settings')['logger'];

        $logger = new Logger($loggerSettings['name']);

        $processor = new UidProcessor();
        $logger->pushProcessor($processor);

        $handler = new StreamHandler($loggerSettings['path'], $loggerSettings['level']);
        $logger->pushHandler($handler);

        return $logger;
    },


    EntityManager::class => function (ContainerInterface $container): EntityManager {

        $doctrineSettings = $container->get('settings')['doctrine'];

        $config = Setup::createAnnotationMetadataConfiguration(
            $doctrineSettings['metadata_dirs'],
            $doctrineSettings['dev_mode']
        );

        $config->setMetadataDriverImpl(
            new AnnotationDriver(
                new AnnotationReader(),
                $doctrineSettings['metadata_dirs']
            )
        );

        $config->setMetadataCacheImpl(
            new FilesystemCache(
                $doctrineSettings['cache_dir']
            )
        );

        return EntityManager::create(
            $doctrineSettings['connection'],
            $config
        );
    },

    Connection::class => function (EntityManagerInterface $entityManager) {
        return $entityManager->getConnection();
    },

    PDO::class => function (Connection $connection) {
        return $connection->getWrappedConnection();
    },

];
