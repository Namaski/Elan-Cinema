<?php

namespace Controller;

use Model\Connect;

class CinemaController
{
    public function listMovies()
    {
        $pdo = Connect::seConnecter();
        $allMovies = $pdo->query('
        SELECT m.title, DATE_FORMAT(m.release_date, "%Y") AS date, m.id_movie
        FROM movie m    
        ');
        $title= "Movies :";

        require "view/listMovies.php";
    }
    public function listRealisators()
    {
        $pdo = Connect::seConnecter();
        $allRealisators = $pdo->query("
        SELECT CONCAT(p.firstname, ' ', p.lastname) AS 'realisator', r.id_realisator
        FROM realisator r
        INNER JOIN person p
        ON r.id_person = p.id_person
        ");
        $title = "Realisators :";

        require "view/listRealisators.php";
    }
    public function listActors()
    {
        $pdo = Connect::seConnecter();
        $allActors = $pdo->query("
        SELECT CONCAT(p.firstname, ' ', p.lastname) AS 'actor', a.id_actor
        FROM actor a
        INNER JOIN person p
        ON a.id_person = p.id_person
        ");
        $title = "Actors :";

        require "view/listActors.php";
    }
    public function showMovie(int $id)
    {
        $pdo = Connect::seConnecter();
        $showMovie = $pdo->prepare('
        SELECT m.title, DATE_FORMAT(m.release_date, "%Y") AS date, m.duree, m.synopsis, m.note, m.picture
        FROM movie m
        WHERE m.id_movie = :id_movie
        ');
        
        $showMovie->execute(["id_movie" => $id]);
    
        $title = "Movie :";

        require "view/detailMovie.php";
    }
    public function showActor(int $id)
    {
        
        $pdo = Connect::seConnecter();
        $showActor = $pdo->prepare("
        SELECT CONCAT(p.firstname, ' ', p.lastname) AS 'actor', p.birthday_date, p.sex, a.picture, a.id_actor
        FROM actor a
        INNER JOIN person p
        ON a.id_person = p.id_person
        WHERE a.id_actor = :id_actor
        ");

        $showActor->execute([ "id_actor" => $id]);
        $title = "Actor :";

        require "view/detailActor.php";
    }

    public function showRealisator(int $id)
    {
        $pdo = Connect::seConnecter();
        $showRealisator = $pdo->prepare("
        SELECT CONCAT(p.firstname, ' ', p.lastname) AS realisator, p.birthday_date, p.sex, r.picture
        FROM realisator r
        INNER JOIN person p
        ON r.id_person = p.id_person
        WHERE r.id_realisator = :id_realisator
        ");
        
        $showRealisator->execute(["id_realisator" => $id]);
        
        
        $title = "Realisator :";

        require "view/detailRealisator.php";
    }

    
}
