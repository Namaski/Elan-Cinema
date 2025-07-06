<?php ob_start(); ?>



<h2 class="admin-content__title">Edit : <?php $movie = $showDetailMovie->fetch();
                                        echo $movie['title']; ?></h2>

<form class="admin-form" action="index.php?action=editMovie&id=<?= $movie['id_movie'] ?>" method="post" id="addPerson">


    <input type="hidden" name="movie" value="<?= $movie['id_movie'] //hidden value for movie id    
                                                ?> ">

    <label for="title">
        Title
    </label>
    <input type="text" placeholder="Title" name=title value="<?= $movie['title'] ?>" />


    <label for="realisator">
        Realisator
    </label>
    <select name="realisator" class="admin-form__select">
        <option disabled>Choose a Realisator</option>
        <?php foreach ($allRealisators->fetchAll() as $realisator) { ?>
            <option value="<?= $realisator['id_realisator'] ?>"
                <?= ($movie['id_realisator'] == $realisator['id_realisator']) ? 'selected' : '' ?>>
                <?= htmlspecialchars($realisator['realisator']) ?>
            </option>

        <?php } ?>
    </select>


    <label for="release"> Release date
    </label>
    <input type="date" name="release_date" value="<?= $movie['release_date'] ?>">

    <label for="duration">Duration (in minutes)</label>
    <input
        type="number"
        id="duration"
        name="duration"
        value="<?= htmlspecialchars($movie['duration']) ?>"
        min="1"
        class="admin-form__input" />


    <label for="genres"> Select one or more genres
    </label>
    <select name="genres[]" id="genres" class="form-select" multiple>
        <option value="" disabled>Genre</option>
        <?php foreach ($allGenres->fetchAll() as $genre) { ?>
            <option value="<?= $genre['id_genre'] ?>"
                <?= in_array($genre['id_genre'], $linkedGenres ?? []) ? 'selected' : '' ?>>
                <?= htmlspecialchars($genre['name']) ?>
            </option>
        <?php } ?>
    </select>



    <label for="synopsis">
        Synopsis
    </label>
    <textarea name="synopsis" id="synopsis"><?= $movie['synopsis'] ?>
    </textarea>


    <button class="yellow" type="sumbit" name="submit" value="send"> Submit</button>

</form>




<?php
$style = '
<link rel="stylesheet" href="./public/css/admin/form.css">

';

$content = ob_get_clean();

require "view/admin/template.php";
