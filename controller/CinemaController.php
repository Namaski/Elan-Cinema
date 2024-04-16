<?php

namespace Controller;

use Model\Connect;

class CinemaController
{
    public function listMovies()
    {
        $pdo = Connect::seConnecter();
        $requete = $pdo->query('
        SELECT m.titre, DATE_FORMAT(m.annee_sortie_fr, "%Y") AS date
        FROM movie m    
        ');
        $liste = "Movies :";

        require "view/list-movie.php";
    }
    public function listDirectors()
    {
        $pdo = Connect::seConnecter();
        $requete = $pdo->query("
        SELECT CONCAT(p.prenom, ' ', p.nom) AS 'director'
        FROM director d
        INNER JOIN person p
        ON d.id_person = p.id_person
        ");
        $liste = "Directors :";

        require "view/list-director.php";
    }
    public function listActors()
    {
        $pdo = Connect::seConnecter();
        $requete = $pdo->query("
        SELECT CONCAT(p.prenom, ' ', p.nom) AS 'actor'
        FROM actor a
        INNER JOIN person p
        ON a.id_person = p.id_person
        ");
        $liste = "Actors :";

        require "view/list-actor.php";
    }
    public function showMovie()
    {
        $pdo = Connect::seConnecter();
        $requete = $pdo->query('
        SELECT m.titre, DATE_FORMAT(m.annee_sortie_fr, "%Y") AS date, m.duree, m.synopsis, m.note, m.picture
        FROM movie m
        WHERE m.titre = "' . $_GET['title'] . '"
        ');
        $liste = "Movie :";

        require "view/movie.php";
    }
    public function showActor()
    {
        $pdo = Connect::seConnecter();
        $requete = $pdo->query("
        SELECT CONCAT(p.prenom, ' ', p.nom) AS 'actor', p.date_naissance, p.sexe, a.picture
        FROM actor a
        INNER JOIN person p
        ON a.id_person = p.id_person
        WHERE  CONCAT(p.prenom, ' ', p.nom) = \"" . $_GET['actor'] . "\"
        ");
        $liste = "Actor :";

        require "view/actor.php";
    }

    public function showDirector()
    {
        $pdo = Connect::seConnecter();
        $requete = $pdo->query("
        SELECT CONCAT(p.prenom, ' ', p.nom) AS 'director', p.date_naissance, p.sexe, d.picture
        FROM director d
        INNER JOIN person p
        ON d.id_person = p.id_person
        WHERE  CONCAT(p.prenom, ' ', p.nom) = \"" . $_GET['director'] . "\"
        ");
        $liste = "Director :";

        require "view/director.php";
    }
}
