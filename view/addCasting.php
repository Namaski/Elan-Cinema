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

        <!-- FIRST FORM CHOOSE MOVIE THE POINT IS TO ADD AFTER THE POSSIBILITY TO SEE ALL CASTING OF A MOVIE AND MODIFY, DELETE OR ADD A NEW CASTING (ADD AFTER WITH JS AUTO SEND FORM WITHOUT SUBMIT ON SCRIPT.JS) -->

        <?php if (!isset($id_movie)) { ?>

            <form action="index.php?action=showPanelAddCasting" method="post">
                <label for="movie"> Select the movie casting</label>

                    <select name="movie" class="form-select" id="movie">
                        <option value=""> --Movie-- </option>
                        <?php foreach ($allMovies->fetchAll() as $movie) { ?>
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

            <h4><?php $movie = $showMovie->fetch();
                echo $movie['title']; ?></h4>

            <!-- I WILL NEED TO MAKE A NEW FONCTION LIKE FIRST FORM TO CHOOSE BEETWEEN EDIT DELETE OR ADD A CASTING-->

            <!-- SECOND(FOR NOW) FORM TO ADD CASTING IN SELECTED MOVIE -->

            <form action="index.php?action=addCasting" method="post" id="addPerson">

                <!-- HIDDEN VALUE TO SEND THE MOVIE ID -->
                <input type="hidden" name="movie" value="<?= $movie['id_movie']?> ">

                <!-- SELECT FOR ACTOR -->
                <label for="actor"> Select the actor</label>

                    <select name="actor" class="form-select" id="actor">

                        <option value="">--Actor--</option>
                        <!-- ADD SELECT LINE FOR EACH EL IN DATABASE -->
                        <?php foreach ($allActors->fetchAll() as $actor) { ?>
                            <option value="<?= $actor['id_actor'] ?>">
                                <?= $actor['actor'] ?>
                            </option>
                        <?php } ?>

                    </select>

                <!-- SELECT FOR ROLE -->
                <label for="role"> Select the role </label>
                <select name="role" class="form-select" id="role">

                    <option value="">--Role--</option>
                    <!-- ADD SELECT LINE FOR EACH EL IN DATABASE -->
                    <?php foreach ($allRoles->fetchAll() as $role) { ?>
                        <option value="<?= $role['id_role'] ?>">
                            <?= $role['libelle'] ?>
                        </option>
                    <?php } ?>
                </select>

                <input type="submit" name="submit" value="Send">

            </form>
        <?php } ?>
    </div>

</article>

<?php $content = ob_get_clean();

require "view/template.php";
