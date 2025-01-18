<?php ob_start();
$movie = $showMovie->fetch(); ?>

<section class="movie__detail">

  <h2 class="movie__detail-title">
    <?= $movie["title"] ?> (<?= $movie["date"] ?>)
  </h2>

  <div class="movie__detail-container">

    <div class="movie__detail-image">

    <img src="<?=$movie["picture"] ? $movie["picture"] : './public/img/svg/movie-poster.svg' ?>" alt="<?= $movie['title'] ?>" onerror="this.src='./public/img/svg/movie-poster.svg'; this.onerror=null;" >
    
    </div>

    <div class="movie__detail-info">
      <p><strong>Durée :</strong> <?= $movie["duration"] ?> minutes</p>
      <p><strong>Synopsis :</strong> <?= $movie["synopsis"] ?></p>
      <p><strong>Note :</strong> <?= $movie["note"] ?>/5</p>
    </div>

  </div>

</section>

<?php $content = ob_get_clean();

require "view/detail/index.php";
