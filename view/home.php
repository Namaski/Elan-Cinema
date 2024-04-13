<?php ob_start();?>


    <div>
        <h1>Bienvenue</h1>
    </div>

    <?php $content = ob_get_clean(); 

    require "view/template.php"; 