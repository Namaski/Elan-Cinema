<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Filmopédia</title>
    <link rel="stylesheet" href="./public/css/style.css">
    <script src="https://kit.fontawesome.com/d80deb4694.js" crossorigin="anonymous"></script>
</head>

<body>
    <div class="index">
        <!-- HEADER -->
        <header>
        <a href="index.php">
            <p class="logo">
                Filmopedia
            </p>
            </a>
            <ul class="navbar">
                <li>
                    <a href="index.php?action=listActors">
                        ACTOR
                    </a>
                </li>
                <li>
                    <a href="index.php?action=movie">
                        MOVIE
                    </a>
                </li>
                <li>
                    <a href="index.php?action=director">
                        DIRECTOR
                    </a>
                </li>
            </ul>
            <a href="index.php?action=showPanelAddPerson">
                <img class="admin-logo" src="./public/img/svg/adminLogo1_x2.svg" />
            </a>
        </header>

        <!-- CONTENT -->
        
        <?=$content ?>

        <!-- FOOTER -->
        <div class="footer">
            <span class="filmopedia">
                2024 © Filmopedia
            </span>
        </div>
    </div>

</body>

</html>