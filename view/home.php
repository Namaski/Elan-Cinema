<?php ob_start(); ?>

<!-- SEARCHBAR SECTION -->

    <div>
        <article class="searchbar-background">
            <form class="searchbar-section" action="" method="get">
                <input id="search" type="text" placeholder="Search a movie, an actor or a director">
                <input id="send" type="submit" value="Search">
            </form>
        </article>
    </div>
    
    <!-- GENRE SECTION -->
    <article class="section-2">
        <div class="choose-agenre">
            Choose a genre
        </div>
        <div class="genre-list">
            <div class="genre-box-3">
                <img class="arrow-2" src="./public/img/svg/arrow2_x2.svg" />
                <div class="action">
                    Action
                </div>
            </div>
            <div class="genre-box-2">
                <span class="horror">
                    Horror
                </span>
            </div>
            <div class="genre-box-1">
                <span class="comedy">
                    Comedy
                </span>
            </div>
            <div class="genre-box">
                <span class="fantasy">
                    Fantasy<br />
                    
                </span>
                <img class="arrow-1" src="./public/img/svg/arrow1_x2.svg" />
            </div>
            <div class="rectangle-7">
                </div>
            </div>
            <div class="line-1">
                </div>
            </article>
            
            <?php $content = ob_get_clean();

require "view/template.php";
