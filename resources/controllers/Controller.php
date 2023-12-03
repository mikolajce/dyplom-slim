<?php

namespace Controller;

class Controller
{
    private $db;
    private $twig;

    public function __construct($app)
    {
        $this->db = $app->getContainer()->get('database');
        $this->twig = $app->getContainer()->get('view');
    }
}