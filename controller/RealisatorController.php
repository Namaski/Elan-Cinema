<?php

namespace Controller;

use Model\Connect;

class RealisatorController
{
    
    public function listRealisators()
    {
        $pdo = Connect::seConnecter();
        $allRealisators = $pdo->query("
        SELECT CONCAT(p.first_name, ' ', p.last_name) AS realisator, p.*, r.*
        FROM realisator r
        INNER JOIN person p
        ON r.id_person = p.id_person
        ");
        $title = "Realisators";

        require "view/list/listRealisators.php";
    }
    

    public function showRealisator(int $id)
    {
        $pdo = Connect::seConnecter();
        $showRealisator = $pdo->prepare("
        SELECT CONCAT(p.first_name, ' ', p.last_name) AS realisator, p.*, r.*
        FROM realisator r
        INNER JOIN person p
        ON r.id_person = p.id_person
        WHERE r.id_realisator = :id_realisator
        ");
        
        $showRealisator->execute(["id_realisator" => $id]);
        
        
        $title = "Realisator";

        require "view/detail/detailRealisator.php";
    }
    
}
