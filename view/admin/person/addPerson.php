<?php ob_start(); ?>

<h2 class="admin-content__title">Add New Person</h2>

<form class="admin-form" action="index.php?action=addPerson" method="post" enctype="multipart/form-data">

<div>
    <label> Actor</label>
    <input type="checkbox" name="is_actor" value="1">
    <label> Realisator</label>
    <input type="checkbox" name="is_realisator" value="1">
</div>


    <label for="first_name">First Name</label>
    <input type="text" name="first_name" placeholder="First name" required>

    <label for="last_name">Last Name</label>
    <input type="text" name="last_name" placeholder="Last name" required>

    <label for="birthdate">Birthdate</label>
    <input type="date" name="birthdate" required>

    <label for="sex">Sex</label>
    <select name="sex" class="admin-form__select" required>
        <option disabled selected>Select sex</option>
        <option value="F">Female</option>
        <option value="M">Male</option>
        <option value="O">Other</option>
    </select>

    <label for="picture">Profile Picture (optional)</label>
    <input type="file" name="picture" accept="image/*">


    <button class="yellow" type="submit" name="submit" value="send">Submit</button>

</form>

<?php
$style = '<link rel="stylesheet" href="./public/css/admin/form.css">';
$content = ob_get_clean();
require "view/admin/template.php";
?>