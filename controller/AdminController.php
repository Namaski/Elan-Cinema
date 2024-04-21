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
                "SELECT CONCAT(p.prenom, ' ', p.nom) AS 'actor', a.id_actor
                FROM actor a
                INNER JOIN person p
                ON a.id_person = p.id_person
                "
            );

            $allRoles = $pdo->query(
                "SELECT r.libelle, r.id_role
                FROM role r
                "
            );

            require "view/addCasting.php";
        }
        // ELSE GET ALL MOVIES
        else {
            $allMovies =  $pdo->query(
                "SELECT m.title , m.id_movie
                FROM movie m"
            );

            require "view/addCasting.php";
        }
    }

    ////////SHOW PANEL EDIT PERSON/////////


    public function showPanelEditPerson()
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
                "SELECT CONCAT(p.prenom, ' ', p.nom) AS 'actor', a.id_actor
                FROM actor a
                INNER JOIN person p
                ON a.id_person = p.id_person
                "
            );

            $allRoles = $pdo->query(
                "SELECT r.libelle, r.id_role
                FROM role r
                "
            );

            require "view/editPerson.php";
        }
        // ELSE GET ALL PERSONS
        else {
            $allPersons =  $pdo->query(
                "SELECT CONCAT(p.prenom, ' ', p.nom) AS 'person', p.id_person
                FROM person p
                "
            );

            require "view/editPerson.php";
        }
    }
    ////////SHOW PANEL EDIT MOVIE/////////


    public function showPanelEditMovie()
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
                "SELECT CONCAT(p.prenom, ' ', p.nom) AS 'actor', a.id_actor
                FROM actor a
                INNER JOIN person p
                ON a.id_person = p.id_person
                "
            );

            $allRoles = $pdo->query(
                "SELECT r.libelle, r.id_role
                FROM role r
                "
            );

            require "view/editMovie.php";
        }
        // ELSE GET ALL PERSONS
        else {
            $allMovies =  $pdo->query(
                "SELECT m.title , m.id_movie
                FROM movie m"
            );

            require "view/editMovie.php";
        }
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

    // EDIT PERSON

    public function editPerson()
    {

        $pdo = Connect::seConnecter();

        // FILTER DATA
        if (isset($_POST['submit'])) {

            // GET ID FIRST
            $id_person = filter_input(INPUT_POST, "id_person", FILTER_SANITIZE_NUMBER_INT);

            // UPDATE IF FIRSTNAME IS SET
            if ($_POST['firstname']) {
                $firstName = filter_input(INPUT_POST, "firstName", FILTER_SANITIZE_FULL_SPECIAL_CHARS);

                $changeFirstName = $pdo->prepare(
                    "UPDATE p.prenom
                    FROM person p
                    SET p.prenom = :firstName
                    WHERE p.id_person = :id_person
                    "
                );
                $changeFirstName->execute([
                    "firstName" => $firstName,
                    "id_person" => $id_person
                ]);
            }

            // UPDATE IF LASTNAME IS SET
            if ($_POST['lastName']) {
                $lastName = filter_input(INPUT_POST, "LastName", FILTER_SANITIZE_FULL_SPECIAL_CHARS);

                $changeLastName = $pdo->prepare(
                    "UPDATE p.nom
                    FROM person p
                    SET p.nom = :lastName
                    WHERE p.id_person = :id_person
                    "
                );
                $changeLastName->execute([
                    "lastName" => $lastName,
                    "id_person" => $id_person
                ]);
            }

            // UPDATE IF BIRTHDATE IS SET
            if ($_POST['birthdate']) {
                $birthdate = filter_input(INPUT_POST, "birthdate", FILTER_SANITIZE_FULL_SPECIAL_CHARS);

                $changeBirthdate = $pdo->prepare(
                    "UPDATE p.date_naissance
                    FROM person p
                    SET p.date_naissance = :birthdate
                    WHERE p.id_person = :id_person
                    "
                );
                $changeBirthdate->execute([
                    "birthdate" => $birthdate,
                    "id_person" => $id_person
                ]);
            }

            // UPDATE IF SEX IS SET
            if ($_POST['sex']) {
                $sex = filter_input(INPUT_POST, "sex", FILTER_SANITIZE_FULL_SPECIAL_CHARS);

                $changeSex = $pdo->prepare(
                    "UPDATE p.sexe
                    FROM person p
                    SET p.sexe = :sex
                    WHERE p.id_person = :id_person
                    "
                );
                $changeSex->execute([
                    "sex" => $sex,
                    "id_person" => $id_person
                ]);
            }

            // UPDATE ACTOR OR DIRECTOR IS SET (CHECK LATER IF KEY IS UNIQUE)
            if ($_POST['actorOrDirector']) {
                $actorOrDirector = filter_input(INPUT_POST, "actorOrDirector", FILTER_SANITIZE_NUMBER_INT);

                // DELETE FIRST THE PREVIOUS ACTOR/DIRECTOR ID
                //ACTOR
                $deleteActor = $pdo->prepare(
                    "DELETE a 
                    FROM actor a
                    INNER JOIN person p
                    WHERE p.id_person = :id_person"
                );

                $deleteActor->execute([
                    "id_person" => $id_person
                ]);

                // DIRECTOR
                $deleteDirector = $pdo->prepare(
                    "DELETE d 
                    FROM director d
                    INNER JOIN person p
                    WHERE p.id_person = :id_person"
                );

                $deleteDirector->execute([
                    "id_person" => $id_person
                ]);

                //CHECK IF ADD ACTOR OR DIRECTOR
                if ($_POST['actorOrDirector'] === 1) {

                    // ADD A NEW ACTOR WITH PERSON ID
                    $addActor = $pdo->prepare(
                        "INSERT INTO actor (id_person)
                        VALUES (:id_person)"
                    );
                    $addActor->execute([
                        "id_person" => $id_person
                    ]);
                } else {
                    // ADD A NEW DIRECTOR WITH PERSON ID
                    $addDirector = $pdo->prepare(
                        "INSERT INTO director (id_person)
                        VALUES (:id_person)"
                    );
                    $addDirector->execute([
                        "id_person" => $id_person
                    ]);
                }
            }
        }

        header('Location: index.php?action=showPanelEditPerson');
    }
    // EDIT MOVIE

    public function editMovie()
    {

        $pdo = Connect::seConnecter();

        // FILTER DATA
        if (isset($_POST['submit'])) {

            // GET ID FIRST
            $id_person = filter_input(INPUT_POST, "id_movie", FILTER_SANITIZE_NUMBER_INT);

            // UPDATE IF FIRSTNAME IS SET
            if ($_POST['firstname']) {
                $firstName = filter_input(INPUT_POST, "firstName", FILTER_SANITIZE_FULL_SPECIAL_CHARS);

                $changeFirstName = $pdo->prepare(
                    "UPDATE p.prenom
                    FROM person p
                    SET p.prenom = :firstName
                    WHERE p.id_person = :id_person
                    "
                );
                $changeFirstName->execute([
                    "firstName" => $firstName,
                    "id_person" => $id_person
                ]);
            }

            // UPDATE IF LASTNAME IS SET
            if ($_POST['lastName']) {
                $lastName = filter_input(INPUT_POST, "LastName", FILTER_SANITIZE_FULL_SPECIAL_CHARS);

                $changeLastName = $pdo->prepare(
                    "UPDATE p.nom
                    FROM person p
                    SET p.nom = :lastName
                    WHERE p.id_person = :id_person
                    "
                );
                $changeLastName->execute([
                    "lastName" => $lastName,
                    "id_person" => $id_person
                ]);
            }

            // UPDATE IF BIRTHDATE IS SET
            if ($_POST['birthdate']) {
                $birthdate = filter_input(INPUT_POST, "birthdate", FILTER_SANITIZE_FULL_SPECIAL_CHARS);

                $changeBirthdate = $pdo->prepare(
                    "UPDATE p.date_naissance
                    FROM person p
                    SET p.date_naissance = :birthdate
                    WHERE p.id_person = :id_person
                    "
                );
                $changeBirthdate->execute([
                    "birthdate" => $birthdate,
                    "id_person" => $id_person
                ]);
            }

            // UPDATE IF SEX IS SET
            if ($_POST['sex']) {
                $sex = filter_input(INPUT_POST, "sex", FILTER_SANITIZE_FULL_SPECIAL_CHARS);

                $changeSex = $pdo->prepare(
                    "UPDATE p.sexe
                    FROM person p
                    SET p.sexe = :sex
                    WHERE p.id_person = :id_person
                    "
                );
                $changeSex->execute([
                    "sex" => $sex,
                    "id_person" => $id_person
                ]);
            }

            // UPDATE ACTOR OR DIRECTOR IS SET (CHECK LATER IF KEY IS UNIQUE)
            if ($_POST['actorOrDirector']) {
                $actorOrDirector = filter_input(INPUT_POST, "actorOrDirector", FILTER_SANITIZE_NUMBER_INT);

                // DELETE FIRST THE PREVIOUS ACTOR/DIRECTOR ID
                //ACTOR
                $deleteActor = $pdo->prepare(
                    "DELETE a 
                    FROM actor a
                    INNER JOIN person p
                    WHERE p.id_person = :id_person"
                );

                $deleteActor->execute([
                    "id_person" => $id_person
                ]);

                // DIRECTOR
                $deleteDirector = $pdo->prepare(
                    "DELETE d 
                    FROM director d
                    INNER JOIN person p
                    WHERE p.id_person = :id_person"
                );

                $deleteDirector->execute([
                    "id_person" => $id_person
                ]);

                //CHECK IF ADD ACTOR OR DIRECTOR
                if ($_POST['actorOrDirector'] === 1) {

                    // ADD A NEW ACTOR WITH PERSON ID
                    $addActor = $pdo->prepare(
                        "INSERT INTO actor (id_person)
                        VALUES (:id_person)"
                    );
                    $addActor->execute([
                        "id_person" => $id_person
                    ]);
                } else {
                    // ADD A NEW DIRECTOR WITH PERSON ID
                    $addDirector = $pdo->prepare(
                        "INSERT INTO director (id_person)
                        VALUES (:id_person)"
                    );
                    $addDirector->execute([
                        "id_person" => $id_person
                    ]);
                }
            }
        }

        header('Location: index.php?action=showPanelEditPerson');
    }

    // DELETE MOVIE
    public function deleteMovie($id)
    {
        $pdo = Connect::seConnecter();
        $casting = $pdo->prepare("DELETE FROM
        casting c
        WHERE c.id_movie = :id");

        echo $casting->execute(["id" => $id]);

        $genres = $pdo->prepare(
            "DELETE FROM genre_movie gm
            WHERE gm.id_movie = :id"
        );

        echo $genres->execute(["id" => $id]);

        $movie = $pdo->prepare("
        DELETE FROM
        movie m
        WHERE m.id_movie = :id
        ");

        echo $movie->execute(["id" => $id]);

        $movies = $pdo->query(
            "SELECT m.id_movie, m.title, 
            DATE_FORMAT(SEC_TO_TIME(m.timeMovie * 60), '%HH%imn') AS timeMovie, 
            DATE_FORMAT(m.releaseDate, '%d/%m/%Y') AS releaseDate, 
            m.synopsis, 
            m.image_url,
            d.id_director,
            p.firstName,
            p.lastName, 
            p.birthday, 
            p.sex
            FROM director d
            INNER JOIN movie m ON d.id_director = m.id_director
            INNER JOIN person p ON d.id_person = p.id_person"
        );

        require "view/listMoviesAdmin.php";
    }

    // DELETE PERSON


}
