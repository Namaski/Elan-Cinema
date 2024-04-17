<?php

namespace Controller;

use Model\Connect;

class CinemaController
{
    public function listMovies()
    {
        $pdo = Connect::seConnecter();
        $allMovies = $pdo->query('
        SELECT m.titre, DATE_FORMAT(m.annee_sortie_fr, "%Y") AS date, m.id_movie
        FROM movie m    
        ');
        $title= "Movies :";

        require "view/listMovies.php";
    }
    public function listDirectors()
    {
        $pdo = Connect::seConnecter();
        $allDirectors = $pdo->query("
        SELECT CONCAT(p.prenom, ' ', p.nom) AS 'director', d.id_director
        FROM director d
        INNER JOIN person p
        ON d.id_person = p.id_person
        ");
        $title = "Directors :";

        require "view/listDirectors.php";
    }
    public function listActors()
    {
        $pdo = Connect::seConnecter();
        $allActors = $pdo->query("
        SELECT CONCAT(p.prenom, ' ', p.nom) AS 'actor', a.id_actor
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
        SELECT m.titre, DATE_FORMAT(m.annee_sortie_fr, "%Y") AS date, m.duree, m.synopsis, m.note, m.picture
        FROM movie m
        WHERE m.id_movie = :id_movie
        ');
        
        $showMovie->execute(["id_movie" => $id]);
    
        $title = "Movie :";

        require "view/movie.php";
    }
    public function showActor(int $id)
    {
        
        $pdo = Connect::seConnecter();
        $showActor = $pdo->prepare("
        SELECT CONCAT(p.prenom, ' ', p.nom) AS 'actor', p.date_naissance, p.sexe, a.picture, a.id_actor
        FROM actor a
        INNER JOIN person p
        ON a.id_person = p.id_person
        WHERE a.id_actor = :id_actor
        ");

        $showActor->execute([ "id_actor" => $id]);
        $title = "Actor :";

        require "view/actor.php";
    }

    public function showDirector(int $id)
    {
        $pdo = Connect::seConnecter();
        $showDirector = $pdo->prepare("
        SELECT CONCAT(p.prenom, ' ', p.nom) AS director, p.date_naissance, p.sexe, d.picture
        FROM director d
        INNER JOIN person p
        ON d.id_person = p.id_person
        WHERE d.id_director = :id_director
        ");
        
        $showDirector->execute(["id_director" => $id]);
        var_dump($showDirector->fetch());
        
        $title = "Director :";

        require "view/director.php";
    }

    
}
