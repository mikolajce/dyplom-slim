<?php

declare(strict_types=1);

use DI\Container;
use Medoo\Medoo;
use Twig\Environment;
use Twig\Loader\FilesystemLoader;

return function (Container $container){

    // Database data required for Medoo connection
    $container->set('database', fn(): Medoo => new Medoo ([
        'type' => 'mysql',
        'host' => 'localhost',
        'database' => 'diplomaslim',
        'username' => 'root',
        'password' => ''
    ]));

    $container->set('view', fn() => new Environment(
        new FilesystemLoader('resources/views'),
        ['cache' => false]));
};
