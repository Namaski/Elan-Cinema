<?php ob_start(); ?>

<!-- SEARCH BAR -->
<form class="searchbar" action="" method="get">
  <input class="searchbar-input" id="search" type="text" placeholder="Search a movie, an actor or a director">
  <input class="searchbar-submit" id="send" type="submit" value="">
</form>

<!-- LIST -->

<section class="result">

  <h2 class="result__title">
    <?php $genre = $title->fetch(); ?>
    <?= $genre["name"] ?>
  </h2>

  <div class="result__list">

    <?php
    foreach ($allMovies->fetchall() as $element) {?>
    
      <a href="index.php?action=detailMovie&id=<?= $element["id_movie"] ?>">
        
      <article class="result__list-card">

          <img class="result__list-image" src="<?=$element["picture"] ? $element["picture"] : './public/img/svg/movie-poster.svg' ?>" alt="<?= $element['title'] ?>" onerror="this.src='./public/img/svg/movie-poster.svg'; this.onerror=null;" >

          <p class="result__list-text"><?= $element["title"] ?> <span><?= "(" . $element["date"] . ")" ?> </span> </p>

        </article>
      </a>
    <?php } ?>

  </div>

</section>


<?php $content = ob_get_clean();


require "view/list/index.php";
