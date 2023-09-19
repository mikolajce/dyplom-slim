<?php

declare(strict_types=1);

use Slim\App;
use Slim\Middleware\ExampleAfterMiddleware;
use Slim\Middleware\ExampleBeforeMiddleware;
use Slim\Middleware\TwigMiddleware;

return function (App $app)
{
    // Fetching debug settings
    $settings = $app->getContainer()->get('settings');

    $app->addErrorMiddleware(
        $settings['displayErrorDetails'],
        $settings['logErrors'],
        $settings['logErrorDetails']
    );

    // Adding universal middleware

    $app->add(ExampleBeforeMiddleware::class);

    $app->add(ExampleAfterMiddleware::class);

//    $app->addMiddleware(new Clockwork\Support\Slim\ClockworkMiddleware(
//        $app,
//        __DIR__ . '/storage/clockwork'
//    ));
/*
    Fatal error: Declaration of
    Clockwork\Support\Slim\ClockworkMiddleware::
        process(
            Psr\Http\Message\ServerRequestInterface $request,
            Psr\Http\Server\RequestHandlerInterface $handler)
    must be compatible with
    Psr\Http\Server\MiddlewareInterface::
        process(
            Psr\Http\Message\ServerRequestInterface $request,
            Psr\Http\Server\RequestHandlerInterface $handler)
            : Psr\Http\Message\ResponseInterface
*/
};
