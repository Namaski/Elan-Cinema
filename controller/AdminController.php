<?php

namespace Controller;

use Model\Connect;

class AdminController
{

    ////////SHOW PANEL PERSON/////////


    public function showPanelAddPerson()
    {
        require "view/addPerson.php";
    }

    ////////SHOW PANEL MOVIE/////////

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
    ////////SHOW PANEL CASTING/////////

    public function showPanelAddCasting()
    {
        $pdo = Connect::seConnecter();

        //    IF THERE IS A SELECTED MOVIE
        if (isset($_POST['movie'])) {

            $id_movie = filter_input(INPUT_POST, "movie", FILTER_SANITIZE_NUMBER_INT);

            $movie = $pdo->prepare(
                "SELECT m.title, m.id_movie
                FROM movie m
                WHERE m.id_movie = :id_movie
                "
            );
            $movie->execute([
                ":id_movie" => $id_movie
            ]);
        }
        // ELSE GET ALL MOVIES
        else {
            $allMovies =  $pdo->query(
                "SELECT m.title , m.id_movie
                FROM movie m"
            );
        }

        require "view/addCasting.php";
    }

    ////////////////ADD PERSON//////////////////


    public function addPerson()
    {
        // FILTER DATA
        if (isset($_POST['submit'])) {
            $first_name = filter_input(INPUT_POST, "firstname", FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            $last_name = filter_input(INPUT_POST, "lastname", FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            $birthdate = filter_input(INPUT_POST, "birthdate", FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            $sex = filter_input(INPUT_POST, "sex", FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            $actorOrDirector = filter_input(INPUT_POST, "actorOrDirector", FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        }

        //  ADD PERSON
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

        // GET PERSON ID

        $getId = $pdo->query(
            "SELECT p.id_person
            FROM person p 
            WHERE p.id_person = LAST_INSERT_ID();"
        );

        $id = $getId->fetch();

        // ADD ACTOR OR DIRECTOR
        if ($actorOrDirector = "Actor") {

            $addPerson = $pdo->prepare("
            INSERT INTO actor (id_person)
            VALUES (:id_person)
            ");

            $addPerson->execute(
                [":id_person" => $id["id_person"]]
            );
        } else {
            $addPerson = $pdo->prepare("
            INSERT INTO director (id_person)
            VALUES (:id_person)
            ");

            $addPerson->execute(
                [":id_person" => $id["id_person"]]
            );
        }
        require "view/addPerson.php";
    }

    ////////////////ADD MOVIE//////////////////

    public function addMovie()
    {

        $pdo = Connect::seConnecter();

        // FILTER DATA
        if (isset($_POST['submit'])) {
            $title = filter_input(INPUT_POST, "title", FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            $release = filter_input(INPUT_POST, "release", FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            $duration = filter_input(INPUT_POST, "duration", FILTER_SANITIZE_NUMBER_INT);
            $synopsis = filter_input(INPUT_POST, "synospsis", FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            $director = filter_input(INPUT_POST, "director", FILTER_SANITIZE_NUMBER_INT);
            $genre = filter_input(INPUT_POST, "genre", FILTER_SANITIZE_NUMBER_INT);
        }

        // ADD MOVIE

        $addMovie = $pdo->prepare(
            "INSERT INTO movie (titre,annee_sortie_fr, duree, synopsis, id_director)
            VALUES (:title, :release, :duration, :synopsis, :id_director)"
        );

        $addMovie->execute([
            ':title' => $title,
            ':release' => $release,
            ':duration' => $duration,
            ':synopsis' => $synopsis,
            ':id_director' => $director
        ]);

        // GET MOVIE ID

        $getId = $pdo->query(
            "SELECT m.id_movie
            FROM movie m 
            WHERE m.id_movie = LAST_INSERT_ID();"
        );

        $id = $getId->fetch();

        // ADD MOVIE_GENRE

        $addMovie = $pdo->prepare("
            INSERT INTO genre_movie (id_movie, id_genre)
            VALUES (:id_movie, :id_genre)
            ");

        $addMovie->execute([
            ":id_movie" => $id["id_movie"],
            ":id_genre" => $genre
        ]);

        require "view/addMovie.php";
    }

    /////////////ADD CASTING////////////////

    public function addCasting()
    {

        $pdo = Connect::seConnecter();

        // FILTER DATA
        if (isset($_POST['submit'])) {
            $title = filter_input(INPUT_POST, "title", FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            $release = filter_input(INPUT_POST, "release", FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            $duration = filter_input(INPUT_POST, "duration", FILTER_SANITIZE_NUMBER_INT);
            $synopsis = filter_input(INPUT_POST, "synospsis", FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            $director = filter_input(INPUT_POST, "director", FILTER_SANITIZE_NUMBER_INT);
            $genre = filter_input(INPUT_POST, "genre", FILTER_SANITIZE_NUMBER_INT);
        }

        // ADD MOVIE

        $addMovie = $pdo->prepare(
            "INSERT INTO movie (titre,annee_sortie_fr, duree, synopsis, id_director)
            VALUES (:title, :release, :duration, :synopsis, :id_director)"
        );

        $addMovie->execute([
            ':title' => $title,
            ':release' => $release,
            ':duration' => $duration,
            ':synopsis' => $synopsis,
            ':id_director' => $director
        ]);

        // GET MOVIE ID

        $getId = $pdo->query(
            "SELECT m.id_movie
            FROM movie m 
            WHERE m.id_movie = LAST_INSERT_ID();"
        );

        $id = $getId->fetch();

        // ADD MOVIE_GENRE

        $addMovie = $pdo->prepare("
            INSERT INTO genre_movie (id_movie, id_genre)
            VALUES (:id_movie, :id_genre)
            ");

        $addMovie->execute([
            ":id_movie" => $id["id_movie"],
            ":id_genre" => $genre
        ]);

        require "view/addCasting.php";
    }
}
