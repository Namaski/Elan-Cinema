<?php

namespace Controller;

use Model\Connect;

class AdminController
{
    public function showPanelAddPerson()
    {
        require "view/addPerson.php";
    }

    public function showPanelAddMovie()
    {
        $pdo = Connect::seConnecter();
        $allGenres = $pdo->query(
            "SELECT g.id_genre, g.libelle
            FROM genre g"
        );

        $allDirectors = $pdo->query(
        "SELECT CONCAT(p.prenom, ' ', p.nom) AS 'director', d.id_director
        FROM director d
        INNER JOIN person p
        ON d.id_person = p.id_person"
        );
        
        require "view/addMovie.php";
    }


    public function addPerson()
    {
        if (isset($_POST['submit'])) {
            $first_name = filter_input(INPUT_POST, "firstname", FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            $last_name = filter_input(INPUT_POST, "lastname", FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            $birthdate = filter_input(INPUT_POST, "birthdate", FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            $sex = filter_input(INPUT_POST, "sex", FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            $actorOrDirector = filter_input(INPUT_POST, "actorOrDirector", FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        }

        $pdo = Connect::seConnecter();
        $addPerson = $pdo->prepare(
            "INSERT INTO person (prenom, nom, date_naissance, sexe)
            VALUES (:first_name, :last_name, :birthdate, :sex)"
            );

        $addPerson->execute([
            ':first_name' => $first_name,
            ':last_name' => $last_name,
            ':birthdate' => $birthdate,
            ':sex' => $sex
        ]);

        $getId = $pdo->query(
            "SELECT p.id_person
            FROM person p 
            WHERE p.id_person = LAST_INSERT_ID();"
        );

        $id = $getId->fetch();

        if ($actorOrDirector = "Actor") {
            
            $addPerson = $pdo->prepare("
            INSERT INTO actor (id_person)
            VALUES (:id_person)
            ");

            $addPerson->execute(
                [ ":id_person" => $id["id_person"]]
            );
        } else {
            $addPerson = $pdo->prepare("
            INSERT INTO director (id_person)
            VALUES (:id_person)
            ");

            $addPerson->execute(
                [ ":id_person" => $id["id_person"]]
            );
        }
        require "view/addPerson.php";
    }

    public function addMovie()
    {
        $pdo = Connect::seConnecter();

        if (isset($_POST['submit'])) {
            $title = filter_input(INPUT_POST, "title", FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            $release = filter_input(INPUT_POST, "release", FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            $duration = filter_input(INPUT_POST, "duration", FILTER_SANITIZE_NUMBER_INT);
            $synopsis = filter_input(INPUT_POST, "synospsis", FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        }

        $addPerson = $pdo->prepare(
            "INSERT INTO movie (titre,annee_sortie_fr, duree, synopsis)
            VALUES (:title, :release, :duration, :synopsis)"
            );

        $addPerson->execute([
            ':title' => $title,
            ':release' => $release,
            ':duration' => $duration,
            ':synopsis' => $synopsis
        ]);

        $getId = $pdo->query(
            "SELECT m.id_movie
            FROM movie m 
            WHERE m.movie = LAST_INSERT_ID();"
        );

        $id = $getId->fetch();

        
        require "view/addMovie.php";
    }


}
