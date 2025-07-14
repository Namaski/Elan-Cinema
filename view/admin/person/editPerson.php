<?php ob_start(); ?>

<h2 class="admin-content__title">Edit : <?= htmlspecialchars($person['first_name'] . ' ' . $person['last_name']) ?></h2>

<form class="admin-form" action="index.php?action=editPerson&id=<?= $person['id_person'] ?>" method="post" enctype="multipart/form-data">

    <input type="hidden" name="id_person" value="<?= $person['id_person'] ?>">

    <label for="first_name">First Name</label>
    <input type="text" name="first_name" value="<?= htmlspecialchars($person['first_name']) ?>" required>

    <label for="last_name">Last Name</label>
    <input type="text" name="last_name" value="<?= htmlspecialchars($person['last_name']) ?>" required>

    <label for="birthdate">Birthdate</label>
    <input type="date" name="birthdate" value="<?= $person['birthdate_formatted'] ?>" required>

    <label for="sex">Sex</label>
    <select name="sex" class="admin-form__select" required>
        <option disabled >Select sex</option>
        <option value="F" <?= $person['sex'] === 'Female' ? 'selected' : '' ?>>Female</option>
        <option value="M" <?= $person['sex'] === 'Male' ? 'selected' : '' ?>>Male</option>
    </select>

    <label for="picture">Profile Picture</label>
    <input type="file" name="picture" accept="image/*">

    <label>Roles</label>
    <div class="admin-form__checkbox-group">
        <label><input type="checkbox" name="is_actor" value="1" <?= $is_actor ? 'checked' : '' ?>> Actor</label>
        <label><input type="checkbox" name="is_realisator" value="1" <?= $is_realisator ? 'checked' : '' ?>> Realisator</label>
    </div>

    <button class="yellow" type="submit" name="submit" value="send">Submit</button>

</form>

<?php
$style = '<link rel="stylesheet" href="./public/css/admin/form.css">';
$content = ob_get_clean();
require "view/admin/template.php";
?>
