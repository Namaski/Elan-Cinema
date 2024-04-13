<?php

namespace Controller;
use Model\Connect;

class CinemaController {
    public function listFilms() {
        $pdo = Connect::seConnecter();
        $requete = $pdo->query("
        SELECT m.titre, m.annee_sortie_fr
        FROM movie m
        ");

        require "view/home.php";

    }
}