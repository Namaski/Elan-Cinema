<?php
session_start();

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
        case 'showPanelPerson':
            $ctrlPersonAdmin->showPanelPerson();
            break;
        case 'showPanelMovie':
            $ctrlMovieAdmin->showPanelMovie();
            break;
        case 'showPanelCasting':
            $ctrlCastingAdmin->showPanelCasting();
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
            $ctrlPersonAdmin->editPerson(isset($id) ? $id : null);
            break;
        case 'editMovie':
            $ctrlMovieAdmin->editMovie(isset($id) ? $id : null);
            break;
        default:
        $ctrlHome->notFound();
    }
} else {
    $ctrlHome->index();
}
