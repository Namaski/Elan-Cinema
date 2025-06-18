<?php
require "view/components/header.php";
require "view/components/footer.php";
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Filmopédia</title>
    <link rel="stylesheet" href="./public/css/style.css">
    <?php if (isset($style)) {
        echo($style);
    }  ?>
    

    <script defer src="https://kit.fontawesome.com/d80deb4694.js" crossorigin="anonymous"></script>

</head>

<body>

    <?= $header ?>

    <main>
        <?= $content ?>
    </main>


    <?= $footer ?>


    <?php if (isset($script)) {
        echo($script);
    }  ?>

</body>

</html>