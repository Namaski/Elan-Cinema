<?php

use Controller\AdminController;
use controller\CinemaController;

spl_autoload_register(function ($class_name) {
    include $class_name . '.php';
});

$ctrlCinema = new CinemaController();
$ctrlAdmin = new AdminController();

if (isset($_GET['id'])) {
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
        case 'listMovie':
            $ctrlCinema->listMovies();
            break;
        case 'detailMovie':
            $ctrlCinema->showMovie($id);
            break;
        case 'director':
            $ctrlCinema->listRealisators();
            break;
        case 'detailRealisator':
            $ctrlCinema->showRealisator($id);
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
        case 'showPanelEditPerson':
            $ctrlAdmin->showPanelEditPerson();
            break;
        case 'showPanelEditMovie':
            $ctrlAdmin->showPanelEditMovie();
            break;
        case 'showPanelDeletePerson':
            $ctrlAdmin->showPanelDeletePerson();
            break;
        case 'showPanelDeleteMovie':
            $ctrlAdmin->showPanelDeleteMovie();
            break;
        case 'addPerson':
            $ctrlAdmin->addPerson();
            break;
        case 'addMovie':
            $ctrlAdmin->addMovie();
            break;
        case 'addCasting':
            $ctrlAdmin->addCasting();
            break;
        case 'editPerson':
            $ctrlAdmin->editPerson();
            break;
        case 'editMovie':
            $ctrlAdmin->editMovie();
            break;
        case 'deletePerson':
            $ctrlAdmin->deletePerson();
            break;
        case 'deleteMovie':
            $ctrlAdmin->deleteMovie();
            break;
    }
} else {
    require "view/home.php";
}
