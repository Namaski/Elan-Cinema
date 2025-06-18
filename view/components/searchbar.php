<?php ob_start(); ?>
<form class="searchbar" action="" method="get">
  <input class="searchbar-input" id="search" type="text" placeholder="Search a movie, an actor or a director">
  <input class="searchbar-submit" id="send" type="submit" value="">
</form>

<?php $searchbar = ob_get_clean();