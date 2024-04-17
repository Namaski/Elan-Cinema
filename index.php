<?php

use controller\CinemaController;

spl_autoload_register(function ($class_name) {
    include $class_name . '.php';
});

$ctrlCinema = new CinemaController();
if (isset($_GET['id']) ) {
    $id = $_GET['id'];
}

if (isset($_GET['action'])) {
    switch ($_GET['action']) {
        case 'listActors':
            $ctrlCinema->listActors();
            break;
        case 'detailActor':
            $ctrlCinema->showActor($id);
            break;
        case 'movie':
            $ctrlCinema->listMovies();
            break;
        case 'detailMovie':
            $ctrlCinema->showMovie($id);
            break;
        case 'director':
            $ctrlCinema->listDirectors();
            break;
        case 'detailDirector':
            $ctrlCinema->showDirector($id);
            break;
    }
} else {
    require "view/home.php";
}
