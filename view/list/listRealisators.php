<?php ob_start(); ?>

<!-- SEARCH BAR -->
<form class="searchbar" action="" method="get">
  <input class="searchbar-input" id="search" type="text" placeholder="Search a movie, an actor or a director">
  <input class="searchbar-submit" id="send" type="submit" value="">
</form>

<!-- LIST -->

<section class="result">

  <h2 class="result__title">
    <?= $title ?>
  </h2>

  <div class="result__list">

    <?php

    foreach ($allRealisators->fetchall() as $element) { ?>
      <a href="index.php?action=detailRealisator&id=<?= $element["id_realisator"] ?>">
        <article class="result__list-card">


        <img class="result__list-image" src="<?=$element["picture"] ? $element["picture"] : './public/img/svg/person-poster.svg' ?>" alt="<?= $element['realisator'] ?>" onerror="this.src='./public/img/svg/person-poster.svg'; this.onerror=null;" >

          <p class="result__list-text"><?= $element["realisator"] ?></p>



        </article>
      </a>
    <?php } ?>

  </div>

</section>


<?php $content = ob_get_clean();


require "view/list/index.php";
