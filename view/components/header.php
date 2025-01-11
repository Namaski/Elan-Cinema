<?php ob_start(); ?>


<header>
        <a href="index.php">
            <p class="logo">
                Filmopedia
            </p>
            </a>
            <ul class="navbar">
                <li>
                    <a href="index.php?action=listMovie">
                        MOVIE
                    </a>
                </li>
                <li>
                    <a href="index.php?action=listActors">
                        ACTOR
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

<?php $header = ob_get_clean();