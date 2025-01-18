<?php ob_start(); 
$actor = $showActor->fetch();
?>

<section class="person__detail">

  <h2 class="person__detail-title">
    <?= $actor["actor"] ?>
  </h2>

  <div class="person__detail-container">

    <div class="person__detail-image">

    <img src="<?=$actor["picture"] ? $actor["picture"] : './public/img/svg/person-poster.svg' ?>" alt="<?= $actor['actor'] ?>" onerror="this.src='./public/img/svg/person-poster.svg'; this.onerror=null;">

    </div>

    <div class="person__detail-info">
      <p><strong>Date de naissance :</strong> <?= date("d M Y", strtotime($actor["birthdate"])) ?></p>
      <p><strong>Sexe :</strong> <?= ucfirst($actor["sex"]) ?></p>
    </div>

  </div>

</section>


<?php $content = ob_get_clean();

require "view/detail/index.php";
