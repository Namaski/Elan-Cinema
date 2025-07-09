<?php ob_start();
require_once "view/components/searchbar.php";
?>

<!-- PARENT -> admin-content -->

<?= $searchbar ?>

<div class="content">

    <div class="content-top">
        <a href="index.php?action=addMovie">
            <p class="content-top-add">ADD NEW</p>
        </a>
    </div>

    <table class="content-table">
        <thead class="table-head">
            <tr class="table-head-row">
                <th class="table-id-col"> ID </th>
                <th class="table-active-col"> ACTIVE </th>
                <th class="table-active-col"> IMAGE </th>
                <th class="table-title-col"> TITLE </th>
                <th class="table-actions-col"> ACTIONS </th>
            </tr>
        </thead>
        <tbody class="table-body">

        <?php
    foreach ($allMovies->fetchall() as $element) {?>
    
            <tr>

                <td class="table-id-row"><?= $element['id_movie'] ?></td>

                <td class="table-active-row"><?php if ($element['active']) { ?>
                    ✓
                <?php } else { ?>
                    ✗
                <?php } ?>
                </td>

                <td class="table-image-row"><img class="result__list-image" src="<?=$element["picture"] ? $element["picture"] : './public/img/svg/movie-poster.svg' ?>" alt="<?= $element['title'] ?>" onerror="this.src='./public/img/svg/movie-poster.svg'; this.onerror=null;" ></td>

                <td class="table-title-row"><?= $element["title"] ?> <span><?= "(" . $element["date"] . ")" ?> </td>

                <td class="table-actions-row"> <a href="index.php?action=editMovie&id=<?= $element["id_movie"] ?>"> EDIT </a> <a href="index.php?action=deleteMovie&id=<?= $element["id_movie"] ?>"> DELETE </a> </td>

            </tr>
      
    <?php } ?>

            

        </tbody>
    </table>

</div>


<?php
$style = '
<link rel="stylesheet" href="./public/css/components/searchbar.css">
<link rel="stylesheet" href="./public/css/admin/panel.css">
';
$content = ob_get_clean();

require "view/admin/template.php";
