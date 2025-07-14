<?php

namespace Controller\Security;

use Model\Connect;

class MovieAdminController
{


    ////////SHOW PANEL MOVIE/////////
    public function showPanelMovie()
    {
        $pdo = Connect::seConnecter();
        $allGenres = $pdo->query(
            "SELECT g.id_genre, g.name
            FROM genre g"
        );

        $allMovies = $pdo->query('
        SELECT m.*, DATE_FORMAT(m.release_date, "%Y") AS date
        FROM movie m    
        ');

        $allRealisators = $pdo->query(
            "SELECT CONCAT(p.first_name, ' ', p.last_name) AS 'realisator', r.id_realisator
        FROM realisator r
        INNER JOIN person p
        ON r.id_person = p.id_person"
        );

        require "view/admin/movie/movie.php";
    }

    ////////////////ADD MOVIE//////////////////
    public function addMovie()
    {

        $pdo = Connect::seConnecter();

        // FILTER DATA
        if (isset($_POST['submit'])) {

            $title = filter_input(INPUT_POST, "title", FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            $release = filter_input(INPUT_POST, "release_date", FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            $duration = filter_input(INPUT_POST, "duration", FILTER_SANITIZE_NUMBER_INT);
            $synopsis = filter_input(INPUT_POST, "synopsis", FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            $realisator = filter_input(INPUT_POST, "realisator", FILTER_SANITIZE_NUMBER_INT);
            $genres = filter_input(INPUT_POST, "genres", FILTER_VALIDATE_INT, FILTER_REQUIRE_ARRAY);

            if (!empty($_FILES["picture"]["name"])) {
                // ADD THE IMG 
                $target_dir = "./public/img/uploads/";
                $target_file = $target_dir . basename($_FILES["picture"]["name"]);
                $uploadOk = 1;
                $pictureFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

                // Check if picture file is a actual picture or fake picture
                $check = getimagesize($_FILES["picture"]["tmp_name"]);
                $errors = [];

                if ($check == false) {
                    $errors[] = "File is not an picture.";
                    $uploadOk = 0;
                }

                // Check if file already exists
                if (file_exists($target_file)) {
                    $errors[] = "Sorry, file already exists.";
                    $uploadOk = 0;
                }

                // Check file size
                if ($_FILES["picture"]["size"] > 500000) {
                    $errors[] = "Your file is too large.";
                    $uploadOk = 0;
                }

                // Allow certain file formats
                if (
                    $pictureFileType != "jpg" && $pictureFileType != "png" && $pictureFileType != "jpeg"
                    && $pictureFileType != "gif" && $pictureFileType != "webp"
                ) {
                    $errors[] = "Only JPG, JPEG, PNG, WEBP & GIF files are allowed.";
                    $uploadOk = 0;
                }

                // Check if $uploadOk is set to 0 by an error
                if ($uploadOk == 0) {
                    $_POST['message'] = "Upload failed: " . implode(" ", $errors);
                    header('Location: index.php?action=addMovie');
                    exit;
                    // if everything is ok, try to upload file
                } else {
                    if (move_uploaded_file($_FILES["picture"]["tmp_name"], $target_file)) {
                        // $_POST['message'] = "The file " . htmlspecialchars(basename($_FILES["picture"]["name"])) . " has been uploaded.";
                    } else {
                        $_POST['message'] = "Sorry, there was an error uploading your file.";
                        header('Location: index.php?action=addMovie');
                        exit;
                    }
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

            foreach ($genres as $genre) {

                $addMovie = $pdo->prepare("
                INSERT INTO genre_movie (id_movie, id_genre)
                VALUES (:id_movie, :id_genre)
                ");

                $addMovie->execute([
                    ":id_movie" => $id["id_movie"],
                    ":id_genre" => $genre
                ]);
            }

            $_SESSION['message'] = 'The movie has been added';


            header('Location: index.php?action=showPanelMovie');
            exit;
        } else {

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

            require 'view/admin/movie/addMovie.php';
        }
    }


    //////////////// EDIT MOVIE ///////////////////////
    public function editMovie(?int $id = null)
    {

        $pdo = Connect::seConnecter();

        // IF SUBMITED
        if (isset($_POST['submit'])) {

            $title = filter_input(INPUT_POST, "title", FILTER_SANITIZE_SPECIAL_CHARS);
            $realisator = filter_input(INPUT_POST, "realisator", FILTER_VALIDATE_INT);
            $releaseDate = filter_input(INPUT_POST, "release_date", FILTER_SANITIZE_SPECIAL_CHARS);
            $duration = filter_input(INPUT_POST, "duration", FILTER_VALIDATE_INT);
            $synopsis = filter_input(INPUT_POST, "synopsis", FILTER_SANITIZE_SPECIAL_CHARS);
            $genres = filter_input(INPUT_POST, "genres", FILTER_VALIDATE_INT, FILTER_REQUIRE_ARRAY);
            // $id_actor = filter_input(INPUT_POST, "actor", FILTER_SANITIZE_NUMBER_INT); // TO DO : EDIT CASTING
            // $id_role = filter_input(INPUT_POST, "role", FILTER_SANITIZE_NUMBER_INT);


            if (!$title || !$realisator || !$releaseDate || !$duration || !$genres) {
                $_SESSION['message'] = 'please all the required fields';
                header('Location: index.php?action=editMovie&id=' . $id);
            }


            // UPDATE MOVIE
            $editMovie =  $pdo->prepare("
            UPDATE movie
            SET title = :title,
            id_realisator = :realisator,
            release_date = :releaseDate,
            duration = :duration,
            synopsis = :synopsis
            WHERE id_movie = :id
            ");
            $editMovie->execute([
                ':title' => $title,
                ':realisator' => $realisator,
                ':releaseDate' => $releaseDate,
                ':duration' => $duration,
                ':synopsis' => $synopsis,
                ':id' => $id
            ]);

            // UPDATE GENRE MANY TO MANY

            $deleteGenre = $pdo->prepare("DELETE FROM genre_movie WHERE id_movie = :id");
            $deleteGenre->execute([':id' => $id]);

            foreach ($genres as $genre) {

                $addGenre = $pdo->prepare("
                INSERT INTO genre_movie (id_movie, id_genre)
                VALUES (:id_movie, :id_genre)
                ");

                $addGenre->execute([
                    ':id_movie' => $id,
                    ':id_genre' => $genre
                ]);
            };

            $_SESSION['message'] = 'The changes have been saved';


            header('Location: index.php?action=editMovie&id=' . $id);
            exit;
        } elseif ($id) {


            $showDetailMovie = $pdo->prepare(
                "SELECT m.*
                FROM movie m
                WHERE m.id_movie = :id_movie
                "
            );


            $showDetailMovie->execute([
                ":id_movie" => $id
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

            $genreMovie = $pdo->prepare(
                "SELECT gm.id_genre, gm.id_movie
                FROM genre_movie gm
                WHERE gm.id_movie = :id_movie"

            );

            $genreMovie->execute(
                [':id_movie' => $id]
            );

            require "view/admin/movie/editMovie.php";
        } else {

            header('Location: index.php?action=showPanelMovie');
        }
    }



    ////////DELETE MOVIE/////////
    public function deleteMovie()
    {
        $pdo = Connect::seConnecter();
        
        if (isset($_POST['id_movie']) && is_numeric($_POST['id_movie'])) {
            $id_movie = (int)$_POST['id_movie'];

            // DELETE PICTURE
            $stmt = $pdo->prepare("SELECT picture FROM movie WHERE id_movie = :id");
            $stmt->execute([':id' => $id_movie]);
            $movie = $stmt->fetch();

            if ($movie && !empty($movie['picture'])) {
                $picturePath = "./public/img/uploads/" . $movie['picture'];
                if (file_exists($picturePath)) {
                    unlink($picturePath); // supprime le fichier picture
                }
            }

            // DELETE GENRE
            $delGenres = $pdo->prepare("DELETE FROM genre_movie WHERE id_movie = :id");
            $delGenres->execute([':id' => $id_movie]);

            // TODO DELETE CASTING

            // DELETE MOVIE
            $delMovie = $pdo->prepare("DELETE FROM movie WHERE id_movie = :id");
            $delMovie->execute([':id' => $id_movie]);


            $_POST['message'] = "The movie has been successfully deleted.";
            header('Location: index.php?action=showPanelMovie');
            exit;
        } else {
            $_POST['message'] = "Invalid or missing movie ID.";
            header('Location: index.php?action=showPanelMovie');
            exit;
        }
    }

}
