<?php

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Filmopédia | Admin</title>
    <link rel="stylesheet" href="./public/css/style.css">
    <link rel="stylesheet" href="./public/css/admin/style.css">
    <?php if (isset($style)) {
        echo ($style);
    }  ?>


    <script defer src="https://kit.fontawesome.com/d80deb4694.js" crossorigin="anonymous"></script>

</head>

<body style="background-color: #000814;">

    <header>
        <a href="index.php">
            <h1 class="logo">
                Filmopedia
            </h1>
        </a>

        <a href="index.php?action=showPanelAddPerson">
            <img class="admin-logo" src="./public/img/svg/adminLogo1_x2.svg" />
        </a>
    </header>

    <main>

    <nav class="admin-nav">

    <h2 class="admin-nav-title"> ADMIN PANEL </h2>

    <ul class="admin-nav-ul" >
        <a  href="index.php?action=showPanelMovie">
        <li class="admin-nav-li">
                <img src="./public/img/svg/movie_small.svg" alt="panel-movie">
            <span>
                MOVIE
            </span>    
        </li>
    </a>

    <a  href="index.php?action=showPanelPerson">
        <li class="admin-nav-li">
                <img src="./public/img/svg/person_small.svg" alt="panel-person">
                <span>
                    PERSON
                </span> 
            </li>
        </a>
    </ul>
  

    </nav>

    <section class="admin-content">
        <?= $content ?>
    </section>

    </main>


    <div class="footer">
        <span class="filmopedia">
            2024 © Filmopedia
        </span>
    </div>


    <?php if (isset($script)) {
        echo ($script);
    }  ?>

</body>

</html>