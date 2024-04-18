<?php ob_start(); ?>

<article class="admin-section">
    <div class="side-panel">
        <h4> Admin-Panel</h4>

        <ul>
            <li>
                <a href="index.php?action=showPanelAddPerson">
                    Add(+) Actor
                </a>
                <a href="index.php?action=showPanelAddMovie">
                    Add(+) Movie
                </a>
            </li>
            <li>
                <a href="index.php?action=adminModification">
                    Modification
                </a>
            </li>
            <li>
                <a href="index.php?action=adminDelete">
                    Delete
                </a>
            </li>
        </ul>
    </div>
    <!-- FORM -->
    <div class="admin-panel">
        <h4>Insertion :</h4>

        <form action="index.php?action=addMovie" method="post" id="addPerson">

            <label for="title"> Title </label>
            <div>
                <input type="text" name="title">
            </div>

            <select name="director" class="form-select">
                <option value="" disabled>Director</option>
                <?php foreach ($allDirectors->fetchAll() as $director) { ?>
                    <option value="<?= $director['id_director'] ?>">
                        <?= $director['director'] ?>
                    </option>
                <?php } ?>
            </select>

            <div>
                <label for="release"> Release
                </label>
                <input type="date" name="release">

                <label for="duration"> Duration
                </label>
                <input type="number" name="duration">

                <label for="genre"> Genre </label>

                <select name="genre" class="form-select">

                    <option value="" disabled>Genre</option>
                    <?php foreach ($allGenres->fetchAll() as $genre) { ?>
                        <option value="<?= $genre['id_genre'] ?>">
                            <?= $genre['libelle'] ?>
                        </option>
                    <?php } ?>
                </select>

            </div>

            <div>
                <label for="synopsis"> Synopsis
                </label>
                <input type="text" name="synopsis">
            </div>

            <input type="submit" name="submit" value="Send">
        </form>
    </div>

</article>

<?php $content = ob_get_clean();

require "view/template.php";
