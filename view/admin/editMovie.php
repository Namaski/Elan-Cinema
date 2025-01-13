<?php ob_start(); ?>

<article class="admin-section">
    <div class="side-panel">
        <h4> Admin-Panel</h4>

        <ul>
            <!-- ADD PERSON -->
            <li>
                <a href="index.php?action=showPanelAddPerson">
                    Add(+) Actor
                </a>
                <a href="index.php?action=showPanelAddMovie">
                    Add(+) Movie
                </a>
            </li>
            <!-- CASTING -->
            <li>
                <a href="index.php?action=showPanelAddCasting">
                    Casting
                </a>
            </li>
            <!-- EDIT -->
            <li>
                <a href="index.php?action=showPanelEditPerson">
                    Edit Person
                </a>
                <a href="index.php?action=showPanelEditMovie">
                    Edit Movie
                </a>

            </li>
            <!-- DELETE -->
            <li>
                <a href="index.php?action=showPanelDeletePerson">
                    Delete(-) Person
                </a>
                <a href="index.php?action=showPanelDeleteMovie">
                    Delete(-) Movie
                </a>

            </li>

        </ul>
    </div>
    <!-- FORM -->
    <div class="admin-panel">


        <h4>Edit :</h4>

        <!-- FIRST FORM CHOOSE MOVIE (ADD AFTER WITH JS AUTO SEND FORM WITHOUT SUBMIT (SCRIPT.JS) -->

        <?php if (!isset($id_movie)) { ?>

            <form action="index.php?action=showPanelEditMovie" method="post">
                <label for="movie"> Select the movie casting </label>

                <select name="movie" class="form-select" id="movie">
                    <option value=""> --Movie-- </option>
                    <?php foreach ($showAllMovies->fetchAll() as $movie) { ?>
                        <option value="<?= $movie['id_movie'] ?>">
                            <?= $movie['title'] ?>
                        </option>
                    <?php } ?>
                    <input type="submit" value="Send">
                </select>
            </form>

        <?php } ?>

        <!-- IF MOVIE IS SELECTED -->
        <?php if (isset($id_movie)) { ?>

            <h4><?php $showMovie = $showDetailMovie->fetch();
                echo $showMovie['title']; ?></h4>

            <!-- SECOND(FOR NOW) FORM TO EDIT THE SELECTED MOVIE -->

            <form action="index.php?action=editMovie" method="post" id="addPerson">


                <!-- HIDDEN VALUE TO SEND THE MOVIE ID -->
                <input type="hidden" name="movie" value="<?= $showMovie['id_movie'] ?> ">

                <label for="title"> Title </label>
                <div>
                    <input type="text" name="title" value="">
                </div>

                <label for="realisator"> Realisator </label>
                <select name="realisator" class="form-select">
                    <option value="" disabled>Realisator</option>
                    <?php foreach ($allRealisators->fetchAll() as $realisator) { ?>
                        <option value="<?= $realisator['id_realisator'] ?>">
                            <?= $realisator['realisator'] ?>
                        </option>
                    <?php } ?>
                </select>

                <div>
                    <label for="release"> Release</label>
                    <input type="date" name="release" value="">

                    <label for="duration"> Duration</label>
                    <input type="number" name="duration" value="">

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
                    <label for="synopsis"> Synopsis</label>
                    <input type="text" name="synopsis" value="">
                </div>

                <input type="submit" name="submit" value="Send">

            </form>
        <?php } ?>
    </div>

</article>

<?php $content = ob_get_clean();

require "view/admin/index.php";

