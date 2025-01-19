<?php

namespace Controller\Security;

use Model\Connect;

class PersonAdminController
{

    ////////SHOW PANEL PERSON/////////
    public function showPanelAddPerson()
    {
        require "view/admin/addPerson.php";
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


    ////////SHOW PANEL EDIT PERSON/////////
    public function showPanelEditPerson()
    {
        $pdo = Connect::seConnecter();

        //    IF THERE IS A SELECTED PERSON
        if (isset($_POST['person'])) {

            $id_person = filter_input(INPUT_POST, "person", FILTER_SANITIZE_NUMBER_INT);

            // SHOW PERSON SELECTED
            $showPerson = $pdo->prepare(
                "SELECT CONCAT(p.first_name, ' ', p.last_name) AS 'person', p.id_person
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
                "SELECT CONCAT(p.first_name, ' ', p.last_name) AS 'person', p.id_person
                FROM person p"
            );

            require "view/admin/editPerson.php";
        }
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


    ////////SHOW PANEL DELETE PERSON/////////
    public function showPanelDeletePerson()
    {
        $pdo = Connect::seConnecter();

        $showAllPersons = $pdo->query(
            "SELECT CONCAT(p.first_name, ' ', p.last_name) AS 'person', p.id_person
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
}
