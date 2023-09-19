<?php

declare(strict_types=1);

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\App;
use Twig\Environment as Twig;
use Twig\Loader\FilesystemLoader;

return function (App $app)
{
    // Prepare Twig engine
    $loader = new FilesystemLoader('resources/views');
    $twig = new Twig($loader,[
        'cache' => false
    ]);

//    Autoload required controllers
//    foreach(glob(__DIR__ . '/../resources/controllers/*.php') as $file) require $file;

    $app->get('/', function (Request $request, Response $response) use ($twig) {

        $data = $this->get('database')
            ->get(
                'product', [
                    'product_id',
                    'name',
                ], [
                    'product_id' => random_int(1,500)
                ]);

        $response->getBody()->write(
            $twig->render('index.twig',[
                'product' => $data
            ]));
        return $response;
    });

    $app->get('/products', function (Request $request, Response $response) use ($twig) {

        $data = $this->get('database')
            ->select(
                'product',[
                    'product_id',
                    'name',
                    'manufacturer',
                    'stock',
                    'price'
                ]);

        $response->getBody()->write(
            $twig->render('/product-all.twig', [
                'name' => '',
                'products' => $data
                ]));
        return $response;
    });

    $app->get('/products/{id}', function (Request $request, Response $response, array $args) use ($twig){

        $data = $this->get('database')
            ->get(
                'product', [
                'name',
                'manufacturer',
                'price',
                'stock',
            ], [
                'product_id' => $args['id']
            ]);

        $response->getBody()
            ->write($twig->render(
                '/product-one.twig', [
                'product' => $data
            ]));
        return $response;
    });

    $app->get('/clients', function (Request $request, Response $response) use ($twig) {

        $data = $this->get('database')
            ->select(
                'client',[
                    'client_id',
                    'name',
                    'surname',
                    'address'
                ]);

        $response->getBody()
            ->write($twig->render(
                '/client-all.twig', [
                'name' => '',
                'clients' => $data
            ]));
        return $response;
    });

    $app->get('/clients/{id}', function (Request $request, Response $response, array $args) use ($twig) {

        $data = $this->get('database')
            ->get(
                'client', [
                    'client_id',
                    'name',
                    'surname',
                    'address'
                ], [
                    'client_id' => $args['id']
            ]);

        $response->getBody()
            ->write($twig->render(
                '/client-one.twig', [
                'name' => '',
                'client' => $data
            ]));
        return $response;
    });

    $app->get('/orders', function (Request $request, Response $response) use ($twig){

        $data = $this->get('database')
            ->select(
                'order',[
                    'order_id',
                    'status_id',
                    'client_id',
                    'sum_total'
                ]);

        $response->getBody()
            ->write($twig->render(
                '/orders-all.twig', [
                'name' => '',
                'orders' => $data
            ]));
        return $response;
    });

    $app->get('/orders/{id}', function (Request $request, Response $response, array $args) use ($twig){

        $order = $this->get('database')
            ->select(
                'order',
                '*',
                [
                    'order_id' => $args['id']
                ]);

        $data = $this->get('database')
            ->select(
                'order',
                [
                    '[<>]client' => ['client_id' => 'client_id']
                ],
//                '*',
//                [
//                    'order_id',
//                    'status_id',
//                    'sum_total',
//                    'name',
//                    'surname',
//                    'address'
//                ]
                '*',
                [
                    'order_id' => $args['id']
                ]
            );

        echo '<br>';
        var_dump($order);
        echo '<br>';

        var_dump($data);

        $response->getBody()
            ->write($twig->render(
                '/orders-detail.twig', [
                'id' => $args['id'],
                'order' => $order,
            ]));
        return $response;
    });

    $app->get('/orders/status/{id}', function (Request $request, Response $response, array $args) use ($twig){

        $data = $this->get('database')
            ->select(
                'order',[
                'order_id',
                'status_id',
                'client_id',
                'sum_total'
            ],[
                'status_id' => $args['id']
            ]);

        $response->getBody()
            ->write($twig->render(
                '/orders-status.twig', [
                'name' => '',
                'status' => $args['id'],
                'orders' => $data
            ]));
        return $response;
    });
};