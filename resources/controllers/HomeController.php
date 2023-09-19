<?php

namespace Controller;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\App;

class HomeController
{
    public function __construct()
    {
    }
    private $app;

    public function setApp($app){
        $this->app = $app;
    }

    public function process(Request $request, Response $response): Response
    {
        $data = $this->app->get('database')
            ->get(
                'product', [
                'name',
                'manufacturer',
                'price',
                'stock',
            ], [
                'product_id' => random_int(1,500)
            ]);

        $data = $this->app->get('database')->select('product','*');
        $response->getBody()->write(TwigLoader::render(
            '/home/index.twig', [
            'name' => ''
        ]));
        return $response;
    }

//    public function __invoke(Request $request, Response $response, App $app): Response
//    {
//        process($app, $response);
//        $app->getContainer()->get('database')->select('product','*');
//        $response->getBody()->write(TwigLoader::render(
//            '/home/index.twig', [
//                'name' => ''
//            ]));
//        return $response;
//    }
}