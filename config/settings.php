<?php

declare(strict_types=1);

use DI\Container;
use Medoo\Medoo;
use Slim\Views\Twig;

return function (Container $container){

    // App data and debug settings
    $container->set('settings', fn(): array => [
        'name' => 'SLIMPHPNAZWA',
        'displayErrorDetails' => true,
        'logErrorDetails' => true,
        'logErrors' => true
    ]);

    // Database data required for Medoo connection
    $container->set('database', fn(): Medoo => new Medoo ([
        'type' => 'mysql',
        'host' => 'localhost',
        'database' => 'diplomaslim',
        'username' => 'root',
        'password' => ''
    ]));

    // Twig configuration
//    $container->set('view', fn(): Twig => new Twig(
//        'resources/views',
//        ['cache' => false]
//    ));
};
