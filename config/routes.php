<?php

declare(strict_types=1);

use Controller\HomeController;
use Controller\WelcomeController;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\App;

return function (App $app)
{
    $db = $app->getContainer()->get('database');
    $twig = $app->getContainer()->get('view');
    $app->addErrorMiddleware(true,true,true);

    foreach(glob(__DIR__ . '/../resources/controllers/*.php') as $file) require $file;

//    $app->get('/', function (Request $request, Response $response) use ($db, $twig, $homecontroller, $rrr) {
//
//        $pid = random_int(1,500);
//        $cid = random_int(1,50);
//        $oid = random_int(1,100);
//
//        $data = $db
//            ->get(
//                'product', [
//                    'product_id',
//                    'name',
//                ], [
//                    'product_id' => $pid
//                ]);
//
//        $response->getBody()->write(
//            $twig->render('index.twig',[
//                'product' => $data,
//                'pid' => $pid,
//                'cid' => $cid,
//                'oid' => $oid
//            ]));
//        return $homecontroller($db,$twig);
//    });

    $homecontroller = new HomeController($app);
    $app->get('/', fn(Request $request, Response $response) => $homecontroller($twig, $db));

    $app->get('/products', function (Request $request, Response $response) use ($db, $twig) {

        $data = $db
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

    $app->get('/products/{id}', function (Request $request, Response $response, array $args) use ($db, $twig){

        $data = $db
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

    $app->get('/clients', function (Request $request, Response $response) use ($db, $twig) {

        $data = $db
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

    $app->get('/clients/{id}', function (Request $request, Response $response, array $args) use ($db, $twig) {

        $data = $db
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

    $app->get('/orders', function (Request $request, Response $response) use ($db, $twig){

        $data = $db
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

    $app->get('/orders/{id}', function (Request $request, Response $response, array $args) use ($db, $twig){

        $start = microtime(true);

        $order = $db
            ->get('order',
                [
                    '[>]client' => ['client_id' => 'client_id'],
                    '[>]status' => ['status_id' => 'status_id']
                ],
                '*',
                ['order_id' => $args['id']]
            );

        $products = $db
            ->select('product',
                ['[>]cart' =>
                    ['product_id' => 'product_id']
                ],
                '*',
                ['order_id' => $args['id']]
            );

        $time = floor(100000*(microtime(true) - $start))/100;
        file_put_contents(__DIR__ . '/../public/slim_dbs.txt', $time.PHP_EOL, FILE_APPEND);
        file_put_contents(__DIR__ . '/../public/slim_views.txt', htmlspecialchars($_COOKIE["time"]).PHP_EOL, FILE_APPEND);

        $response->getBody()
            ->write($twig->render(
                '/orders-detail.twig', [
                'id' => $args['id'],
                'order' => $order,
                'products' => $products
            ]));
        return $response;
    });

    $app->get('/orders/status/{id}', function (Request $request, Response $response, array $args) use ($db, $twig){

        $data = $db
            ->select(
                'order',
                [
                    'order_id',
                    'status_id',
                    'client_id',
                    'sum_total'
                ],[
                    'status_id' => $args['id']
            ]);

        $status = $this->get('database')
            ->select(
                'status',
                [
                    'code'
                ], [
                    'status_id' => $args['id']
                ]
            );


        $status = current(current($status));

        $response->getBody()
            ->write($twig->render(
                '/orders-status.twig', [
                'name' => '',
                'status' => $status,
                'orders' => $data
            ]));
        return $response;
    });
};