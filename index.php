<?php

use Controller\AdminController;
use controller\CinemaController;

spl_autoload_register(function ($class_name) {
    include $class_name . '.php';
});

$ctrlCinema = new CinemaController();
$ctrlAdmin = new AdminController();

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
        case 'showPanelAddPerson':
            $ctrlAdmin->showPanelAddPerson();
            break;
        case 'showPanelAddMovie':
            $ctrlAdmin->showPanelAddMovie();
            break;
        case 'showPanelAddCasting':
            $ctrlAdmin->showPanelAddCasting();
            break;
        case 'addPerson':
            $ctrlAdmin->addPerson();
            break;
        case 'addMovie':
            $ctrlAdmin->addMovie();
            break;
    }
} else {
    require "view/home.php";
}
