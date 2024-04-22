<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Filmopédia</title>
    <link rel="stylesheet" href="./public/css/style.css">
    <!-- <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous"> -->
    <script defer src="https://kit.fontawesome.com/d80deb4694.js" crossorigin="anonymous"></script>
    <!-- <script defer src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4=" crossorigin="anonymous"></script> -->
    <!-- <script defer src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js" integrity="sha384-BBtl+eGJRgqQAUMxJ7pMwbEyER4l1g+O15P+16Ep7Q9Q+zqX6gSbd85u4mG4QzX+" crossorigin="anonymous"></script> -->
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
                    <a href="index.php?action=listMovie">
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