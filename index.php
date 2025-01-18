<?php

use Controller\HomeController;
use Controller\MovieController;
use Controller\ActorController;
use Controller\RealisatorController;
use Controller\Security\PersonAdminController;
use Controller\Security\CastingAdminController;
use Controller\Security\MovieAdminController;

spl_autoload_register(function ($class_name) {
    include $class_name . '.php';
});


$ctrlHome = new HomeController();
$ctrlMovie = new MovieController();
$ctrlActor = new ActorController();
$ctrlRealisator = new RealisatorController();
$ctrlPersonAdmin = new PersonAdminController();
$ctrlCastingAdmin = new CastingAdminController();
$ctrlMovieAdmin = new MovieAdminController();

if (isset($_GET['id'])) {
    $id = $_GET['id'];
}

if (isset($_GET['action'])) {
    switch ($_GET['action']) {
        case 'listActors':
            $ctrlActor->listActors();
            break;
        case 'detailActor':
            $ctrlActor->showActor($id);
            break;
        case 'listMovie':
            $ctrlMovie->listMovies();
            break;
        case 'listMoviesByGenre':
            $ctrlMovie->listMoviesByGenre($id);
            break;
        case 'detailMovie':
            $ctrlMovie->showMovie($id);
            break;
        case 'director':
            $ctrlRealisator->listRealisators();
            break;
        case 'detailRealisator':
            $ctrlRealisator->showRealisator($id);
            break;
        case 'showPanelAddPerson':
            $ctrlPersonAdmin->showPanelAddPerson();
            break;
        case 'showPanelAddMovie':
            $ctrlMovieAdmin->showPanelAddMovie();
            break;
        case 'showPanelAddCasting':
            $ctrlCastingAdmin->showPanelAddCasting();
            break;
        case 'showPanelEditPerson':
            $ctrlPersonAdmin->showPanelEditPerson();
            break;
        case 'showPanelEditMovie':
            $ctrlMovieAdmin->showPanelEditMovie();
            break;
        case 'showPanelDeletePerson':
            $ctrlPersonAdmin->showPanelDeletePerson();
            break;
        case 'showPanelDeleteMovie':
            $ctrlMovieAdmin->showPanelDeleteMovie();
            break;
        case 'addPerson':
            $ctrlPersonAdmin->addPerson();
            break;
        case 'addMovie':
            $ctrlMovieAdmin->addMovie();
            break;
        case 'addCasting':
            $ctrlCastingAdmin->addCasting();
            break;
        case 'editPerson':
            $ctrlPersonAdmin->editPerson();
            break;
        case 'editMovie':
            $ctrlMovieAdmin->editMovie();
            break;
        default:
        $ctrlHome->index();
        // TODO : 404 PAGE NOT FOUND
    }
} else {
    $ctrlHome->index();
}
