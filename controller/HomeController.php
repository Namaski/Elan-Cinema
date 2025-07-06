<?php

namespace Controller;

use Model\Connect;

class HomeController
{
    public function index()
    {
        $pdo = Connect::seConnecter();
        $allGenres = $pdo->query('
        SELECT g.*
        FROM genre g
        ');

        require "view/home/index.php";
    }

    public function notFound()
    {
        $pdo = Connect::seConnecter();
        

        require "view/home/notFound.php";
    }

}
