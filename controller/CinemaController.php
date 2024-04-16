<?php

namespace Controller;
use Model\Connect;

class CinemaController {
    public function listMovies() {
        $pdo = Connect::seConnecter();
        $requete = $pdo->query('
        SELECT m.titre, DATE_FORMAT(m.annee_sortie_fr, "%Y") AS date
        FROM movie m
        ');
        $liste = "Movies :";

        require "view/list-movie.php";
    }
    public function listDirectors() {
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
    public function listActors() {
        $pdo = Connect::seConnecter();
        $requete = $pdo->query("
        SELECT CONCAT(p.prenom, ' ', p.nom) AS 'actors'
        FROM actor a
        INNER JOIN person p
        ON a.id_person = p.id_person
        ");
        $liste = "Actors :";

        require "view/list-actor.php";
    }
}