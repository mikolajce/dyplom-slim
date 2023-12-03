<?php

namespace Controller;
use Slim\Psr7\Response;

class HomeController extends Controller
{
    public function __construct($app)
    {
        parent::__construct($app);
    }

    public function __invoke($twig, $db = null): Response {
        $pid = random_int(1,500);
        $cid = random_int(1,50);
        $oid = random_int(1,100);

        $data = $db
            ->get(
                'product', [
                'product_id',
                'name',
            ], [
                'product_id' => $pid
            ]);

        $response = new Response();
        $response->getBody()->write(
            $twig->render('index.twig',[
                'product' => $data,
                'pid' => $pid,
                'cid' => $cid,
                'oid' => $oid
            ]));
        return $response;
    }

}