<?php

use controller\CinemaController;

spl_autoload_register(function ($class_name) {
    include $class_name . '.php';
});

$ctrlCinema = new CinemaController();

if (isset($_GET['action'])) {
    switch ($_GET['action']) {
        case 'actor':
            if (isset($_GET['actor'])) {
                $ctrlCinema->showActor();
            } else {
                $ctrlCinema->listActors();
            }
            break;
        case 'movie':
            if (isset($_GET['title'])) {
                $ctrlCinema->showMovie();
            } else {
                $ctrlCinema->listMovies();
            }
            break;
        case 'director':
            if (isset($_GET['director'])) {
                $ctrlCinema->showDirector();
            } else {
                $ctrlCinema->listDirectors();
            }
            
            break;
        
    }
} else {
    require "view/home.php";
}

