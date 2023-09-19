<?php

namespace Controller;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class ProductController
{
    public function __construct()
    {
    }

    public function __invoke(Request $request, Response $response): Response
    {
        $products = $app->get('database')
            ->select('product','*');


        $response->getBody()->write(TwigLoader::render(
            '/product/client-client-all.twig', [
                'products' => $products
        ]));
        return $response;
    }
}