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

        <div class="genre__card">
            <img src="./public/img/action.png" alt="action">
            <p class="genre__card-text">
                Action
            </p>
        </div>
        
        <div class="genre__card">
            <img src="./public/img/horror.png" alt="horror">
            <p class="genre__card-text">
                Horror
            </p>
        </div>
        
        <div class="genre__card">
            <img src="./public/img/comedy.png" alt="comedy">
            <p class="genre__card-text">
                Comedy
            </p>
        </div>
        
        <div class="genre__card">
            <img src="./public/img/fantasy.png" alt="fantasy">
            <p class="genre__card-text">
                Fantasy<br />

            </p>
        </div>
        

    </div>

    <div class="line-1"></div>

</section>

<?php $content = ob_get_clean();
$style = '
<link rel="stylesheet" href="./public/css/pages/home.css">

';
$script = '<script src="./public/script/script.js"></>';

require "view/template.php";
