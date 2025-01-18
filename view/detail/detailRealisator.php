<?php ob_start(); 
$realisator = $showRealisator->fetch();
?>

<section class="person__detail">

  <h2 class="person__detail-title">
    <?= $realisator["realisator"] ?>
  </h2>

  <div class="person__detail-container">

    <div class="person__detail-image">

    <img src="<?=$realisator["picture"] ? $realisator["picture"] : './public/img/svg/person-poster.svg' ?>" alt="<?= $realisator['realisator'] ?>" onerror="this.src='./public/img/svg/person-poster.svg'; this.onerror=null;">

    </div>

    <div class="person__detail-info">
      <p><strong>Date de naissance :</strong> <?= date("d M Y", strtotime($realisator["birthdate"])) ?></p>
      <p><strong>Sexe :</strong> <?= ucfirst($realisator["sex"]) ?></p>
    </div>

  </div>

</section>


<?php $content = ob_get_clean();

require "view/detail/index.php";
