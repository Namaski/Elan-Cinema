<?php

namespace Controller;

use Model\Connect;

class MovieController
{
    public function listMovies()
    {
        $pdo = Connect::seConnecter();
        $allMovies = $pdo->query('
        SELECT m.title, DATE_FORMAT(m.release_date, "%Y") AS date, m.id_movie
        FROM movie m    
        ');
        $title= "Movies :";

        require "view/movie/listMovies.php";
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
    
        $title = "Movie :";

        require "view/movie/detailMovie.php";
    }
}
