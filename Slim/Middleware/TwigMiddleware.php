<?php

namespace Slim\Middleware;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Server\RequestHandlerInterface as RequestHandler;

class TwigMiddleware
{
//    public function __invoke(Request $request, Response $response): Response
//    {
//        $loader = new ArrayLoader([
//            'index' => 'Hello {{ name }}'
//        ]);
//        $twig = new \Twig\Environment($loader);
//        return $twig->render('index', ['name' => 'Fabien']);
//    }
}