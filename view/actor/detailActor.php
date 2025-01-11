<?php ob_start(); ?>

<article class="list-section">
  <!-- SEARCH BAR SECTION -->
  <div class="list-searchbar">
    <form class="searchbar-section" action="" method="get">
      <input id="search" type="text" placeholder="Search <?= $title ?>">
      <input id="send" type="submit" value="Search">
    </form>
    <div class="filter">
      <p> Filter <i class="fa-solid fa-filter"></i></p>
    </div>
  </div>

  <!-- LIST SECTION -->

  <h2>
    <?= $title ?>
  </h2>

  <div class="list-container">

    <?php $actor = $showActor->fetch(); ?>

      <div class="list-element">
          <p><?=$actor["actor"] ?></p>
      </div>

  </div>
</article>

<?php $content = ob_get_clean();

require "view/template.php";
