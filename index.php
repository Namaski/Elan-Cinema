<?php

use controller\CinemaController;

spl_autoload_register(function ($class_name) {
    include $class_name . '.php';
});

$ctrlCinema = new CinemaController();

if (isset($_GET['action'])) {
    switch ($_GET['action']) {
        case 'actor':
            $ctrlCinema->listActors();
            break;
        case 'movie':
            $ctrlCinema->listMovies();
            break;
        case 'director':
            $ctrlCinema->listDirectors();
            break;
        
    }
} else {
    require "view/home.php";
}

