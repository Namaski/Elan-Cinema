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
                <a href="index.php?action=showPanelAddCasting">
                    Add(+) Movie Casting
                </a>
            </li>
            <li>
                <a href="index.php?action=showPanelEditPerson">
                    Actor
                </a>
                <a href="index.php?action=showPanelEditMovie">
                    Movie
                </a>
                
            </li>
            <li>
                <a href="index.php?action=showPanelDeleteActor">
                    Actor
                </a>
                <a href="index.php?action=showPanelDeleteMovie">
                    Movie
                </a>
                
            </li>
        </ul>
    </div>
    <!-- FORM -->
    <div class="admin-panel">
        <h4>Insertion :</h4>
        
        <form action="index.php?action=showPanelAddCasting" method="post"></form>

        <label for="movie"> Select the movie casting </label>
        <select name="movie" class="form-select">
            <option value=""> --Movie-- </option>
            <?php foreach ($allMovies->fetchAll() as $movie) { ?>
                <option value="<?= $movie['id_movie'] ?>">
                    <?= $movie['movie'] ?>
                </option>
            <?php } ?>
            
        </select>


        <form action="index.php?action=addMovie" method="post" id="addPerson">


    

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
