<?php

use controller\CinemaController;

spl_autoload_register(function ($class_name) {
    include $class_name . '.php';
});

$ctrlCinema = new CinemaController();

if (isset($_GET['action'])) {
    switch ($_GET['action']) {
        case 'actor':
            # code...
            break;
        case 'movie':
            # code...
            break;
        case 'director':
            # code...
            break;
        
    }
} else {
    $ctrlCinema->listFilms();
}

