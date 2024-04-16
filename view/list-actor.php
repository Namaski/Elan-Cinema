<?php ob_start(); ?>

<article class="list-section">
  <!-- SEARCH BAR SECTION -->
  <div class="list-searchbar">
    <form class="searchbar-section" action="" method="get">
      <input id="search" type="text" placeholder="Search <?= $liste ?>">
      <input id="send" type="submit" value="Search">
    </form>
    <div class="filter">
      <p> Filter <i class="fa-solid fa-filter"></i></p>
    </div>
  </div>

  <!-- LIST SECTION -->

  <h2>
    <?= $liste ?>
  </h2>

  <div class="list-container">

    <?php
    foreach ($requete->fetchall() as $element) { ?>
      <div class="list-element">
      <a href="index.php?action=actor&actor=<?=$element["actor"] ?>">
          <p><?= $element["actor"] ?></p>
      </a>
      </div>
    <?php } ?>

  </div>
</article>

<?php $content = ob_get_clean();

require "view/template.php";
