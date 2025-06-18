<?php ob_start();
require_once "view/components/searchbar.php"
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
                <th class="table-title-col"> TITLE </th>
                <th class="table-actions-col"> ACTIONS </th>
            </tr>
        </thead>
        <tbody class="table-body">
            <tr>
                <td class="table-id-row">1</td>
                <td class="table-active-row">true</td>
                <td class="table-title-row">TITANIC</td>
                <td class="table-actions-row">EDIT DELETE</td>
            </tr>
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
