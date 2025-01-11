<?php

namespace Controller\Security;

use Model\Connect;

class CastingAdminController
{

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

}
