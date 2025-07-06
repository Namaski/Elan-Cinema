<?php ob_start(); ?>

<!-- SEARCHBAR SECTION -->

<div class="not-found">
    <img class="not-found__img" src="./public/img/svg/error404.svg" alt="error 404">
    <p class="not-found__text">Sorry, the page you were looking for doesn't exist.</p>
</div>

<?php $content = ob_get_clean();
$style = '
<link rel="stylesheet" href="./public/css/pages/home.css">
<link rel="stylesheet" href="./public/css/pages/notfound.css">

';
$script = '<script src="./public/script/script.js"></>';

require "view/template.php";
