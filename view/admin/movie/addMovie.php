<?php ob_start(); ?>

<h2 class="admin-content__title">Add New Movie</h2>

<form class="admin-form" action="index.php?action=addMovie" method="post" enctype="multipart/form-data" id="addMovie" >

    <label for="title">Title</label>
    <input type="text" placeholder="Title" name="title" />

    <label for="realisator">Realisator</label>
    <select name="realisator" class="admin-form__select" required>
        <option disabled selected>Choose a Realisator</option>
        <?php foreach ($allRealisators->fetchAll() as $realisator) { ?>
            <option value="<?= $realisator['id_realisator'] ?>">
                <?= htmlspecialchars($realisator['realisator']) ?>
            </option>
        <?php } ?>
    </select>

    <label for="release_date">Release Date</label>
    <input type="date" name="release_date" />

    <label for="duration">Duration (in minutes)</label>
    <input type="number" id="duration" name="duration" min="1" class="admin-form__input" />

    <label for="genres">Select One or More Genres</label>
    <select name="genres[]" id="genres" multiple>
        <?php foreach($allGenres as $genre) { ?>
            <option value="<?= $genre['id_genre'] ?>">
                <?= htmlspecialchars($genre['name']) ?>
            </option>
        <?php } ?>
    </select>

    <label for="synopsis">Synopsis</label>
    <textarea name="synopsis" id="synopsis"></textarea>

    <label for="picture">Movie Poster (JPG, PNG, WEBP only)</label>
    <input type="file" name="picture" accept="image/*" />


    <button class="yellow" type="submit" name="submit" value="send">Submit</button>

</form>

<?php
$style = '
<link rel="stylesheet" href="./public/css/admin/form.css">
';

$content = ob_get_clean();

require "view/admin/template.php";
