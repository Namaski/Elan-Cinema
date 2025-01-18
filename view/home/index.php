<?php ob_start(); ?>

<!-- SEARCHBAR SECTION -->

<section class="hero">

    <form class="hero__searchbar" action="" method="get">
        <input class="hero__searchbar-input" id="search" type="text" placeholder="Search a movie, an actor or a director">
        <input class="hero__searchbar-submit" id="send" type="submit" value="">
    </form>

</section>

<!-- GENRE SECTION -->
<section class="genre">
    <h2 class="genre__title">
        Choose a genre
    </h2>

    <div class="genre__list-cards">
        <?php
        foreach ($allGenres->fetchall() as $genre) { ?>

            <a href="index.php?action=listMoviesByGenre&id=<?= $genre["id_genre"] ?>">

                <div class="genre__card">

                    <img src="<?= $genre["picture"] ? $genre["picture"] : './public/img/svg/movie-poster.svg' ?>" alt="<?= $genre['title'] ?>" onerror="this.src='./public/img/svg/movie-poster.svg'; this.onerror=null;">

                    <p class="genre__card-text">
                        <?= $genre["name"] ?>
                    </p>

                </div>

            </a>

        <?php }; ?>

    </div>

    <div class="line-1"></div>

</section>

<?php $content = ob_get_clean();
$style = '
<link rel="stylesheet" href="./public/css/pages/home.css">

';
$script = '<script src="./public/script/script.js"></>';

require "view/template.php";
