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
        <h4>Insertion :</h4>

        <form action="index.php?action=addPerson" method="post" id="addPerson">
            <div class="radioForm">
                <div>
                    <label for="actorOrDirector"> Actor </label>
                    <input type="radio" name="actorOrDirector" value="Actor">
                </div>
                <div>
                    <label for="actorOrDirector"> Director </label>
                    <input type="radio" name="actorOrDirector" value="Director">
                </div>
            </div>
            <div>
                <div>
                    <label for="firstname"> Firstname </label>
                    <input type="text" name="firstname">
                </div>
                <div>
                    <label for="lastname"> Lastname </label>
                    <input type="text" name="lastname">
                </div>
            </div>
            <label for="birthdate"> Birthdate</label>
            <input type="date" name="birthdate">
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
    </div>

</article>

<?php $content = ob_get_clean();

require "view/template.php";
