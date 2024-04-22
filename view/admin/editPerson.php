<?php ob_start(); ?>

<article class="admin-section">

    <!-- ADMIN SIDE PANEL -->
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

        <!-- I SHOULD PUT A LIST OF ACTOR AND DIRECTOR INSTEAD OF PERSON LIST IN THE FUTURE -->
        <?php if (!isset($id_person)) { ?>

            <form action="index.php?action=showPanelEditPerson" method="post">
                <label for="person"> Select the person</label>

                <select name="person" class="form-select" id="person">
                    <option value=""> --Person-- </option>
                    <?php foreach ($showAllPersons->fetchAll() as $person) { ?>
                        <option value="<?= $person['id_person'] ?>">
                            <?= $person['person'] ?>
                        </option>
                    <?php } ?>
                    <input type="submit" value="Send">
                </select>
            </form>

        <?php } ?>

        <!-- IF PERSON IS SELECTED -->
        <?php if (isset($id_person)) { ?>

            <h4><?php $person = $showPerson->fetch();
                echo $person['person']; ?></h4>


            <!-- SECOND(FOR NOW) FORM TO EDIT SELECTED PERSON -->

            <form action="index.php?action=editPerson" method="post" id="addPerson">

                <!-- HIDDEN VALUE TO SEND THE PERSON ID -->
                <input type="hidden" name="id_person" value="<?= $person['id_person'] ?> ">

                <div class="radioForm">

                    <div>
                        <label for="actor"> Actor </label>
                        <input type="checkbox" name="actor" value="1">
                    </div>

                    <div>
                        <label for="director"> Director </label>
                        <input type="checkbox" name="director" value="1">
                    </div>
                </div>

                <div>
                    <div>
                        <label for="firstName"> Firstname </label>
                        <input type="text" name="firstname" value="">
                    </div>
                    <div>
                        <label for="lastName"> Lastname </label>
                        <input type="text" name="lastname" value="">
                    </div>
                </div>

                <label for="birthdate"> Birthdate</label>

                <input type="date" name="birthdate" value="">

                <div class="radioForm">
                    <div>
                        <label for="sex"> Female </label>
                        <input type="radio" name="sex" value="Female">
                    </div>

                    <div>
                        <label for="sex"> Male </label>
                        <input type="radio" name="sex" value="Male">
                    </div>
                </div>

                <input type="submit" name="submit" value="Send">

            </form>
        <?php } ?>
    </div>

</article>

<?php $content = ob_get_clean();

require "view/template.php";
