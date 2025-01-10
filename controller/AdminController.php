<?php

namespace Controller;

use Model\Connect;

class AdminController
{

    ////////SHOW PANEL PERSON/////////


    public function showPanelAddPerson()
    {
        require "view/admin/addPerson.php";
    }

    ////////SHOW PANEL MOVIE/////////

    public function showPanelAddMovie()
    {
        $pdo = Connect::seConnecter();
        $allGenres = $pdo->query(
            "SELECT g.id_genre, g.name
            FROM genre g"
        );

        $allRealisators = $pdo->query(
            "SELECT CONCAT(p.firstname, ' ', p.lastname) AS 'realisator', r.id_realisator
        FROM realisator r
        INNER JOIN person p
        ON r.id_person = p.id_person"
        );

        require "view/admin/addMovie.php";
    }

    ////////SHOW PANEL CASTING/////////

    public function showPanelAddCasting()
    {
        $pdo = Connect::seConnecter();

        //    IF THERE IS A SELECTED MOVIE
        if (isset($_POST['movie'])) {

            $id_movie = filter_input(INPUT_POST, "movie", FILTER_SANITIZE_NUMBER_INT);

            $showMovie = $pdo->prepare(
                "SELECT m.title, m.id_movie
                FROM movie m
                WHERE m.id_movie = :id_movie
                "
            );

            $showMovie->execute([
                ":id_movie" => $id_movie
            ]);

            $allActors = $pdo->query(
                "SELECT CONCAT(p.firstname, ' ', p.lastname) AS 'actor', a.id_actor
                FROM actor a
                INNER JOIN person p
                ON a.id_person = p.id_person
                "
            );

            $allRoles = $pdo->query(
                "SELECT r.name, r.id_role
                FROM role r
                "
            );

            require "view/admin/addCasting.php";
        }
        // ELSE GET ALL MOVIES
        else {
            $allMovies =  $pdo->query(
                "SELECT m.title , m.id_movie
                FROM movie m"
            );

            require "view/admin/addCasting.php";
        }
    }

    ////////SHOW PANEL EDIT PERSON/////////


    public function showPanelEditPerson()
    {
        $pdo = Connect::seConnecter();

        //    IF THERE IS A SELECTED PERSON
        if (isset($_POST['person'])) {

            $id_person = filter_input(INPUT_POST, "person", FILTER_SANITIZE_NUMBER_INT);

            // SHOW PERSON SELECTED
            $showPerson = $pdo->prepare(
                "SELECT CONCAT(p.firstname, ' ', p.lastname) AS 'person', p.id_person
                FROM person p
                WHERE p.id_person = :id_person"

            );

            $showPerson->execute([
                ":id_person" => $id_person
            ]);

            require "view/admin/editPerson.php";
        }
        // ELSE GET ALL PERSONS
        else {
            // ALL PERSON LIST
            $showAllPersons = $pdo->query(
                "SELECT CONCAT(p.firstname, ' ', p.lastname) AS 'person', p.id_person
                FROM person p"
            );

            require "view/admin/editPerson.php";
        }
    }
    ////////SHOW PANEL EDIT MOVIE/////////


    public function showPanelEditMovie()
    {
        $pdo = Connect::seConnecter();

        //    IF THERE IS A SELECTED MOVIE
        if (isset($_POST['movie'])) {

            $id_movie = filter_input(INPUT_POST, "movie", FILTER_SANITIZE_NUMBER_INT);

            $showDetailMovie = $pdo->prepare(
                "SELECT m.title, m.id_movie
                FROM movie m
                WHERE m.id_movie = :id_movie
                "
            );



            $showDetailMovie->execute([
                ":id_movie" => $id_movie
            ]);

            $allActors = $pdo->query(
                "SELECT CONCAT(p.firstname, ' ', p.lastname) AS 'actor', a.id_actor
                FROM actor a
                INNER JOIN person p
                ON a.id_person = p.id_person
                "
            );

            $allRoles = $pdo->query(
                "SELECT r.name, r.id_role
                FROM role r
                "
            );

            $allRealisators = $pdo->query(
                "SELECT CONCAT(p.firstname, ' ', p.lastname) AS 'realisator', d.id_realisator
            FROM realisator r
            INNER JOIN person p
            ON r.id_person = p.id_person"
            );

            $allGenres = $pdo->query(
                "SELECT g.id_genre, g.name
                FROM genre g"
            );

            require "view/admin/editMovie.php";
        }
        // ELSE GET ALL PERSONS
        else {
            $showAllMovies =  $pdo->query(
                "SELECT m.title , m.id_movie
                FROM movie m"
            );

            require "view/admin/editMovie.php";
        }
    }

    ////////SHOW PANEL DELETE PERSON/////////


    public function showPanelDeletePerson()
    {
        $pdo = Connect::seConnecter();

        $showAllPersons = $pdo->query(
            "SELECT CONCAT(p.firstname, ' ', p.lastname) AS 'person', p.id_person
            FROM person p
            LEFT JOIN realisator r
            ON p.id_person = r.id_person
            LEFT JOIN movie m
            ON r.id_realisator = m.id_realisator
            WHERE m.id_realisator IS NULL 
            "    
        );

        require "view/admin/deletePerson.php";
    }

    ////////SHOW PANEL DELETE MOVIE/////////


    public function showPanelDeleteMovie()
    {
        $pdo = Connect::seConnecter();

        $showAllMovies =  $pdo->query(
            "SELECT m.title , m.id_movie
            FROM movie m"
        );

        require "view/admin/deleteMovie.php";
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

            //  ADD PERSON
            $pdo = Connect::seConnecter();
            $addPerson = $pdo->prepare(
                "INSERT INTO person (firstname, lastname, birthday_date, sex)
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
            if ($actorOrDirector === "Actor") {

                $addPerson = $pdo->prepare("
            INSERT INTO actor (id_person)
            VALUES (:id_person)
            ");

                $addPerson->execute(
                    [":id_person" => $id["id_person"]]
                );
            } else {
                $addPerson = $pdo->prepare("
            INSERT INTO realisator (id_person)
            VALUES (:id_person)
            ");

                $addPerson->execute(
                    [":id_person" => $id["id_person"]]
                );
            }
        }

        header('Location: index.php?action=showPanelAddPerson');
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

            // ADD MOVIE

            $addMovie = $pdo->prepare(
                "INSERT INTO movie (title, release_date, duree, synopsis, id_director)
                VALUES (:title, :release, :duration, :synopsis, :id_realisator)"
            );

            $addMovie->execute([
                ':title' => $title,
                ':release' => $release,
                ':duration' => $duration,
                ':synopsis' => $synopsis,
                ':id_realisator' => $director
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
        }

        header('Location: index.php?action=showPanelAddMovie');
    }

    /////////////ADD CASTING////////////////

    public function addCasting()
    {

        $pdo = Connect::seConnecter();

        // FILTER DATA
        if (isset($_POST['submit'])) {
            $id_movie = filter_input(INPUT_POST, "movie", FILTER_SANITIZE_NUMBER_INT);
            $id_actor = filter_input(INPUT_POST, "actor", FILTER_SANITIZE_NUMBER_INT);
            $id_role = filter_input(INPUT_POST, "role", FILTER_SANITIZE_NUMBER_INT);


            // ADD Casting

            $addMovie = $pdo->prepare(
                "INSERT INTO casting (id_movie, id_actor, id_role)
            VALUES (:id_movie, :id_actor, :id_role)"
            );

            $addMovie->execute([
                ':id_movie' => $id_movie,
                ':id_actor' => $id_actor,
                ':id_role' => $id_role
            ]);
        }

        $allMovies =  $pdo->query(
            "SELECT m.title , m.id_movie
            FROM movie m"
        );

        //UNSET ID_MOVIE TO SELECT NEW MOVIE (MAYBE ADD RETURN BUTTON INSTEAD) 
        unset($id_movie);

        header('Location: index.php?action=showPanelAddCasting');
    }

    ////////////////EDIT PERSON//////////////////

    public function editPerson()
    {

        $pdo = Connect::seConnecter();

        // if ($_POST['firstName'] === '') {
        //     unset($_POST['firstName']);    
        // }
        // if ( $_POST['lastName'] === '') {
        //     unset( $_POST['lastName']);    
        // }
        if ($_POST['birthdate'] === '') {
            unset($_POST['birthdate']);    
        }
        // if ($_POST['sex'] === '') {
        //     unset($_POST['sex']);    
        // }

        // FILTER DATA
        if (isset($_POST['submit'])) {
            $id_movie = filter_input(INPUT_POST, "movie", FILTER_SANITIZE_NUMBER_INT);
            $id_actor = filter_input(INPUT_POST, "actor", FILTER_SANITIZE_NUMBER_INT);
            $id_role = filter_input(INPUT_POST, "role", FILTER_SANITIZE_NUMBER_INT);


            // ADD PERSON

            $addMovie = $pdo->prepare(
                "INSERT INTO casting (id_movie, id_actor, id_role)
            VALUES (:id_movie, :id_actor, :id_role)"
            );

            $addMovie->execute([
                ':id_movie' => $id_movie,
                ':id_actor' => $id_actor,
                ':id_role' => $id_role
            ]);
        }

        $allMovies =  $pdo->query(
            "SELECT m.title , m.id_movie
            FROM movie m"
        );

        //UNSET ID_MOVIE TO SELECT NEW MOVIE (MAYBE ADD RETURN BUTTON INSTEAD) 
        unset($id_movie);

        header('Location: index.php?action=showPanelAddCasting');
    }
    // EDIT MOVIE

    public function editMovie()
    {

        $pdo = Connect::seConnecter();
        var_dump($_POST);
        // IF SUBMITED
        if (isset($_POST['submit'])) {
            $id_movie = filter_input(INPUT_POST, "movie", FILTER_SANITIZE_NUMBER_INT);
            $id_actor = filter_input(INPUT_POST, "actor", FILTER_SANITIZE_NUMBER_INT);
            $id_role = filter_input(INPUT_POST, "role", FILTER_SANITIZE_NUMBER_INT);


            // ADD Movie

            $addMovie = $pdo->prepare(
                "INSERT INTO casting (id_movie, id_actor, id_role)
            VALUES (:id_movie, :id_actor, :id_role)"
            );

            $addMovie->execute([
                ':id_movie' => $id_movie,
                ':id_actor' => $id_actor,
                ':id_role' => $id_role
            ]);
        }

        $allMovies =  $pdo->query(
            "SELECT m.title , m.id_movie
            FROM movie m"
        );

        //UNSET ID_MOVIE TO SELECT NEW MOVIE (MAYBE ADD RETURN BUTTON INSTEAD) 
        unset($id_movie);

        header('Location: index.php?action=showPanelAddCasting');
    }

}
