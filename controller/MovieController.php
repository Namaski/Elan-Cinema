<?php

namespace Controller;

use Model\Connect;

class MovieController
{
    public function listMovies()
    {
        $pdo = Connect::seConnecter();
        $allMovies = $pdo->query('
        SELECT m.*, DATE_FORMAT(m.release_date, "%Y") AS date
        FROM movie m    
        ');
        $title = "Movies";

        require "view/list/listMovies.php";
    }

    public function listMoviesByGenre(int $id)
    {
        $pdo = Connect::seConnecter();
        $allMovies = $pdo->prepare('
        SELECT m.*, DATE_FORMAT(m.release_date, "%Y") AS date
        FROM movie m 
        INNER JOIN genre_movie gm
        ON m.id_movie = gm.id_movie
        WHERE gm.id_genre = :id_genre
        ');
        $title = $pdo->prepare('
        SELECT g.name
        FROM genre g
        WHERE g.id_genre = :id_genre
        ');

        $allMovies->execute(["id_genre" => $id]);
        $title->execute(["id_genre" => $id]);

        require "view/list/listMoviesByGenre.php";
    }

    public function showMovie(int $id)
    {
        $pdo = Connect::seConnecter();
        $showMovie = $pdo->prepare('
        SELECT m.title, DATE_FORMAT(m.release_date, "%Y") AS date, m.duration, m.synopsis, m.note, m.picture
        FROM movie m
        WHERE m.id_movie = :id_movie
        ');

        $showMovie->execute(["id_movie" => $id]);

        $title = "Movie";

        require "view/detail/detailMovie.php";
    }
}
