<?php

declare(strict_types=1);

use Slim\Factory\AppFactory;
use DI\Container;

require __DIR__ . '/../vendor/autoload.php';

AppFactory::setContainer(
    $container = new Container()
);

$settings = require __DIR__ . '/../config/settings.php';
$settings($container);

$app = AppFactory::create();

$routes = require __DIR__ . '/../config/routes.php';
$routes($app);

$app->run();