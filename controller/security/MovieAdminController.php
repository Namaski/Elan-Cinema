<?php

namespace Controller\Security;

use Model\Connect;

class MovieAdminController
{


    ////////SHOW PANEL MOVIE/////////
    public function showPanelAddMovie()
    {
        $pdo = Connect::seConnecter();
        $allGenres = $pdo->query(
            "SELECT g.id_genre, g.name
            FROM genre g"
        );

        $allRealisators = $pdo->query(
            "SELECT CONCAT(p.first_name, ' ', p.last_name) AS 'realisator', r.id_realisator
        FROM realisator r
        INNER JOIN person p
        ON r.id_person = p.id_person"
        );

        require "view/admin/addMovie.php";
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
            $realisator = filter_input(INPUT_POST, "realisator", FILTER_SANITIZE_NUMBER_INT);
            $genre = filter_input(INPUT_POST, "genre", FILTER_SANITIZE_NUMBER_INT);

            // var_dump($_POST);
            // die;
            // ADD THE IMG 
            $target_dir = "./public/img/uploads/";
            $target_file = $target_dir . basename($_FILES["picture"]["name"]);
            $uploadOk = 1;
            $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

            // Check if image file is a actual image or fake image
            $check = getimagesize($_FILES["picture"]["tmp_name"]);

            if ($check == false) {
                echo "File is not an image.";
                $uploadOk = 0;
            }

            // Check if file already exists
            if (file_exists($target_file)) {
                echo "Sorry, file already exists.";
                $uploadOk = 0;
            }

            // Check file size
            if ($_FILES["picture"]["size"] > 500000) {
                echo "Sorry, your file is too large.";
                $uploadOk = 0;
            }

            // Allow certain file formats
            if (
                $imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
                && $imageFileType != "gif"
            ) {
                echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
                $uploadOk = 0;
            }

            // Check if $uploadOk is set to 0 by an error
            if ($uploadOk == 0) {
                echo "Sorry, your file was not uploaded.";
                // if everything is ok, try to upload file
            } else {
                if (move_uploaded_file($_FILES["picture"]["tmp_name"], $target_file)) {
                    echo "The file " . htmlspecialchars(basename($_FILES["picture"]["name"])) . " has been uploaded.";
                } else {
                    echo "Sorry, there was an error uploading your file.";
                }
            }

            // ADD MOVIE

            $addMovie = $pdo->prepare(
                "INSERT INTO movie (title, release_date, duration, synopsis, id_realisator)
                    VALUES (:title, :release, :duration, :synopsis, :id_realisator)"
            );

            $addMovie->execute([
                ':title' => $title,
                ':release' => $release,
                ':duration' => $duration,
                ':synopsis' => $synopsis,
                ':id_realisator' => $realisator
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
                "SELECT CONCAT(p.first_name, ' ', p.last_name) AS 'actor', a.id_actor
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
                "SELECT CONCAT(p.first_name, ' ', p.last_name) AS 'realisator', r.id_realisator
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

    ////////SHOW PANEL DELETE MOVIE/////////
    public function deleteMovie()
    {
        $pdo = Connect::seConnecter();

        $showAllMovies =  $pdo->query(
            "SELECT m.title , m.id_movie
                FROM movie m"
        );

        require "view/admin/deleteMovie.php";
    }
}
