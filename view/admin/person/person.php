<?php ob_start();
require_once "view/components/searchbar.php";
?>

<?= $searchbar ?>

<div class="content">

    <div class="content-top">
        <a href="index.php?action=addPerson">
            <p class="content-top-add">ADD NEW</p>
        </a>
    </div>

    <table class="content-table">
        <thead class="table-head">
            <tr class="table-head-row">
                <th class="table-id-col"> ID </th>
                <th class="table-image-col"> IMAGE </th>
                <th class="table-title-col"> NAME </th>
                <th class="table-date-col"> BIRTHDATE </th>
                <th class="table-gender-col"> SEX </th>
                <th class="table-type-col"> TYPE </th>
                <th class="table-actions-col"> ACTIONS </th>
            </tr>
        </thead>
        <tbody class="table-body">

            <?php foreach ($allPerson->fetchAll() as $person) { ?>
                <tr>
                    <td class="table-id-row"><?= $person['id_person'] ?></td>

                    <td class="table-image-row">
                        <img class="result__list-image" src="<?= $person["picture"] ? $person["picture"] : './public/img/svg/user-default.svg' ?>" alt="<?= $person['name'] ?>" onerror="this.src='./public/img/svg/person_small.svg'; this.onerror=null;">
                    </td>

                    <td class="table-title-row"><?= htmlspecialchars($person['name']) ?></td>
                    <td class="table-date-row"><?= date("Y/m/d", strtotime($person['birthdate'])) ?></td>
                    <td class="table-gender-row"><?= htmlspecialchars($person['sex']) ?></td>
                    <td class="table-type-row"><?= htmlspecialchars($person['type']) ?></td>

                    <td class="table-actions-row">
                        <a href="index.php?action=editPerson&id=<?= $person['id_person'] ?>">EDIT</a>

                        <form action="index.php?action=deletePerson" method="POST" class="delete-form" onsubmit="return confirm('Are you sure you want to delete this person?');">
                            <input type="hidden" name="id_person" value="<?= $person['id_person'] ?>">
                            <button type="submit" class="link-style-button">DELETE</button>
                        </form>
                    </td>
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
?>
