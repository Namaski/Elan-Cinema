<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Filmopédia</title>
</head>

<body>
    <header>
        <nav>
            <ul>
                <li>
                    <a href="index.php?action=home">Home</a>
                </li>
                <li>
                    <a href="index.php?action=actor">Actor</a>
                </li>
                <li>
                    <a href="index.php?action=movie">Movie</a>
                </li>
                <li>
                    <a href="index.php?action=director"> Director </a>
                </li>
            </ul>
        </nav>
    </header>

    <?= $content ?>

    <footer>
        <p>Filmopédia</p>
    </footer>


</body>

</html>