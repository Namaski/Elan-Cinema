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


        <h4>Delete :</h4>

        <!-- I SHOULD PUT A LIST OF ACTOR AND DIRECTOR INSTEAD OF PERSON LIST IN THE FUTURE -->
            <form action="index.php?action=deletePerson" method="post">

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

    </div>

</article>

<?php $content = ob_get_clean();

require "view/admin/index.php";

