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
            "SELECT g.id_genre, g.libelle
            FROM genre g"
        );

        $allDirectors = $pdo->query(
            "SELECT CONCAT(p.prenom, ' ', p.nom) AS 'director', d.id_director
        FROM director d
        INNER JOIN person p
        ON d.id_person = p.id_person"
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

        //    IF THERE IS A SELECTED MOVIE
        if (isset($_POST['person'])) {

            $id_person = filter_input(INPUT_POST, "person", FILTER_SANITIZE_NUMBER_INT);

            // SHOW PERSON SELECTED
            $showPerson = $pdo->prepare(
                "SELECT CONCAT(p.prenom, ' ', p.nom) AS 'person', p.id_person
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
                "SELECT CONCAT(p.prenom, ' ', p.nom) AS 'person', p.id_person
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

            $allDirectors = $pdo->query(
                "SELECT CONCAT(p.prenom, ' ', p.nom) AS 'director', d.id_director
            FROM director d
            INNER JOIN person p
            ON d.id_person = p.id_person"
            );

            $allGenres = $pdo->query(
                "SELECT g.id_genre, g.libelle
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
            "SELECT CONCAT(p.prenom, ' ', p.nom) AS 'person', p.id_person
            FROM person p
            LEFT JOIN director d
            ON p.id_person = d.id_person
            LEFT JOIN movie m
            ON d.id_director = m.id_director
            WHERE m.id_director IS NULL 
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
                "INSERT INTO movie (title,annee_sortie_fr, duree, synopsis, id_director)
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

            // GET ID FIRST
            $id_person = filter_input(INPUT_POST, "id_person", FILTER_SANITIZE_NUMBER_INT);

            // UPDATE IF FIRSTNAME IS SET
            if (isset($_POST['firstName'])) {
                $firstName = filter_input(INPUT_POST, "firstName", FILTER_SANITIZE_FULL_SPECIAL_CHARS);

                $changeFirstName = $pdo->prepare(
                    "UPDATE person p
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
            if (isset($_POST['lastName'])) {
                $lastName = filter_input(INPUT_POST, "LastName", FILTER_SANITIZE_FULL_SPECIAL_CHARS);

                $changeLastName = $pdo->prepare(
                    "UPDATE person p
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
            if (isset($_POST['birthdate'])) {
                $birthdate = filter_input(INPUT_POST, "birthdate", FILTER_SANITIZE_FULL_SPECIAL_CHARS);

                $changeBirthdate = $pdo->prepare(
                    "UPDATE person p
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
            if (isset($_POST['sex'])) {
                $sex = filter_input(INPUT_POST, "sex", FILTER_SANITIZE_FULL_SPECIAL_CHARS);

                $changeSex = $pdo->prepare(
                    "UPDATE person p
                    SET p.sexe = :sex
                    WHERE p.id_person = :id_person
                    "
                );
                $changeSex->execute([
                    "sex" => $sex,
                    "id_person" => $id_person
                ]);
            }

            //CHECK IF ADD DIRECTOR
            if ($_POST['actor'] === "1") {

                //DELETE CASTING
                $deleteCasting = $pdo->prepare(
                    "DELETE c.*
                    FROM person p
                    INNER JOIN actor a
                    ON p.id_person = a.id_person
                    INNER JOIN casting c
                    ON a.id_actor = c.id_actor
                    WHERE p.id_person = :id_person"
                );

                $deleteCasting->execute([
                    "id_person" => $id_person
                ]);

                // DELETE ACTOR
                $deleteActor = $pdo->prepare(
                    "SELECT a.*
                    FROM actor a
                    INNER JOIN person p
                    ON p.id_person = a.id_person
                    WHERE p.id_person = :id_person"
                );

                $deleteActor->execute([
                    "id_person" => $id_person
                ]);


                // ADD A NEW ACTOR WITH PERSON ID
                $addActor = $pdo->prepare(
                    "INSERT INTO actor (id_person)
                    VALUES (:id_person)"
                );
                $addActor->execute([
                    "id_person" => $id_person
                ]);

            } else {

                //DELETE CASTING
                $deleteCasting = $pdo->prepare(
                    "DELETE c.*
                    FROM person p
                    INNER JOIN actor a
                    ON p.id_person = a.id_person
                    INNER JOIN casting c
                    ON a.id_actor = c.id_actor
                    WHERE p.id_person = :id_person"
                );

                $deleteCasting->execute([
                    "id_person" => $id_person
                ]);

                // DELETE ACTOR
                $deleteActor = $pdo->prepare(
                    "DELETE a.*
                        FROM actor a
                        INNER JOIN person p
                        ON a.id_person = p.id_person
                        WHERE p.id_person = :id_person"
                );

                $deleteActor->execute([
                    "id_person" => $id_person
                ]);
            }

            //CHECK IF ADD ACTOR
            if ($_POST['director'] === "1") {

                // DELETE DIRECTOR
                $deleteDirector = $pdo->prepare(
                    "SELECT d.*
                    FROM director d
                    INNER JOIN person p
                    ON d.id_person = p.id_person
                    WHERE p.id_person = :id_person"
                );

                $deleteDirector->execute([
                    "id_person" => $id_person
                ]);

                // ADD A NEW ACTOR WITH PERSON ID
                $addActor = $pdo->prepare(
                    "INSERT INTO director (id_person)
                        VALUES (:id_person)"
                );
                $addActor->execute([
                    "id_person" => $id_person
                ]);
            } else {

                // DELETE DIRECTOR
                $deleteDirector = $pdo->prepare(
                    "SELECT d.*
                    FROM director d
                    INNER JOIN person p
                    ON d.id_person = p.id_person
                    WHERE p.id_person = :id_person"
                );

                $deleteDirector->execute([
                    "id_person" => $id_person
                ]);
            }


            header('Location: index.php?action=showPanelEditPerson');
        }
    }

    ////////////////EDIT MOVIE//////////////////
    public function editMovie()
    {

        $pdo = Connect::seConnecter();
        var_dump($_POST);
        // IF SUBMITED
        if (isset($_POST['submit'])) {

            if ($_POST['title'] === '') {
                unset($_POST['title']);    
            }
            if ($_POST['release'] === '') {
                unset($_POST['release']);    
            }
            if ($_POST['duration'] === '') {
                unset($_POST['duration']);    
            }
            if ($_POST['synopsis'] === '') {
                unset($_POST['synopsis']);    
            }
            
            // GET ID FIRST
            $id_movie = filter_input(INPUT_POST, "movie", FILTER_SANITIZE_NUMBER_INT);

            // UPDATE IF TITLE IS SET
            if (isset($_POST['title'])) {
                $title = filter_input(INPUT_POST, "title", FILTER_SANITIZE_FULL_SPECIAL_CHARS);

                $changeTitle = $pdo->prepare(
                    "UPDATE movie m
                    SET m.title = :title
                    WHERE m.id_movie = :id_movie
                    "
                );
                $changeTitle->execute([
                    "title" => $title,
                    "id_movie" => $id_movie
                ]);
                var_dump($changeTitle->fetch());
            }

            // UPDATE IF RELEASE IS SET
            if (isset($_POST['release'])) {
                $release = filter_input(INPUT_POST, "release", FILTER_SANITIZE_FULL_SPECIAL_CHARS);

                $changeRelease = $pdo->prepare(
                    "UPDATE movie m
                    SET m.annee_sortie_fr = :release
                    WHERE m.id_movie = :id_movie
                    "
                );
                $changeRelease->execute([
                    "release" => $release,
                    "id_movie" => $id_movie
                ]);
            }

            // UPDATE IF BIRTHDATE IS SET
            if (isset($_POST['duration'])) {
                $duration = filter_input(INPUT_POST, "duration", FILTER_SANITIZE_NUMBER_INT);

                $changeDuration = $pdo->prepare(
                    "UPDATE movie m
                    SET m.duree = :duration
                    WHERE m.id_movie = :id_movie
                    "
                );
                $changeDuration->execute([
                    "duration" => $duration,
                    "id_movie" => $id_movie
                ]);
            }

            // UPDATE IF SEX IS SET
            if (isset($_POST['synospsis'])) {
                $synopsis = filter_input(INPUT_POST, "synospsis", FILTER_SANITIZE_FULL_SPECIAL_CHARS);

                $changeSynopsis = $pdo->prepare(
                    "UPDATE movie m
                    SET m.synopsis = :synopsis
                    WHERE m.id_movie = :id_movie
                    "
                );
                $changeSynopsis->execute([
                    "synopsis" => $synopsis,
                    "id_movie" => $id_movie
                ]);
            }

            // UPDATE ACTOR OR DIRECTOR IS SET (CHECK LATER IF KEY IS UNIQUE)
            if (isset($_POST['id_director"'])) {
                $id_director = filter_input(INPUT_POST, "id_director", FILTER_SANITIZE_NUMBER_INT);

                $changeDirector = $pdo->prepare(
                    "UPDATE movie m
                    SET m.id_director = :id_director
                    WHERE m.id_movie = :id_movie
                    "
                );
                $changeDirector->execute([
                    "id_director" => $id_director,
                    "id_movie" => $id_movie
                ]);
            }

            // UPDATE ACTOR OR DIRECTOR IS SET (CHECK LATER IF KEY IS UNIQUE)
            if (isset($_POST['id_genre'])) {
                $id_genre = filter_input(INPUT_POST, "id_genre", FILTER_SANITIZE_NUMBER_INT);

                $deleteGenre = $pdo->prepare(
                    "DELETE gm.*
                    FROM movie m
                    INNER JOIN genre_movie gm
                    ON m.id_movie = gm.id_movie
                    WHERE m.id_movie = :id_movie
                    "
                );
                $deleteGenre->execute([
                    "id_movie" => $id_movie
                ]);

                $addGenre = $pdo->prepare(
                    "INSERT INTO genre_movie (id_movie, id_genre)
                    VALUES (:id_movie, :id_genre)
                    "
                );

                $addGenre->execute([
                    "id_movie" => $id_movie,
                    "id_genre" => $id_genre
                ]);
            }
        }

        header('Location: index.php?action=showPanelEditMovie');
    }

    ////////////////DELETE MOVIE//////////////////
    public function deleteMovie()
    {

        $pdo = Connect::seConnecter();

        $id_movie = filter_input(INPUT_POST, "movie", FILTER_SANITIZE_NUMBER_INT);

        var_dump($id_movie);
        // DELETE MOVIE CASTING
        $deleteCasting = $pdo->prepare(
            "DELETE c.* 
            FROM casting c
            WHERE c.id_movie = :id_movie"
        );

        $deleteCasting->execute([
            "id_movie" => $id_movie
        ]);

        // DELETE MOVIE GENRE
        $deleteMovieGenre = $pdo->prepare(
            "DELETE gm.*
            FROM genre_movie gm
            WHERE gm.id_movie = :id_movie
            "
        );

        $deleteMovieGenre->execute([
            "id_movie" => $id_movie
        ]);

        // DELETE MOVIE
        $deleteMovie = $pdo->prepare(
            "DELETE m.* 
            FROM movie m
            WHERE m.id_movie = :id_movie"
        );

        $deleteMovie->execute([
            "id_movie" => $id_movie
        ]);

        header('Location: index.php?action=showPanelDeleteMovie');
    }

    ////////////////DELETE PERSON//////////////////
    public function deletePerson()
    {

        $pdo = Connect::seConnecter();

        $id_person = filter_input(INPUT_POST, "person", FILTER_SANITIZE_NUMBER_INT);

        var_dump($id_person);

        // DELETE ACTOR
        $deleteActor = $pdo->prepare(
            "DELETE a.* 
            FROM actor a
            WHERE a.id_person = :id_person"
        );

        $deleteActor->execute([
            "id_person" => $id_person
        ]);

        // DELETE DIRECTOR
        $deleteDirector = $pdo->prepare(
            "DELETE d.* 
            FROM director d
            WHERE d.id_person = :id_person"
        );

        $deleteDirector->execute([
            "id_person" => $id_person
        ]);

        // DELETE PERSON

        $deletePerson = $pdo->prepare(
            "DELETE p.* 
            FROM person p
            WHERE p.id_person = :id_person"
        );

        $deletePerson->execute([
            "id_person" => $id_person
        ]);

        header('Location: index.php?action=showPanelDeletePerson');
    }
}
