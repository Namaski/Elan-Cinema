<?php

namespace Controller;

use Model\Connect;

class ActorController
{
    public function listActors()
    {
        $pdo = Connect::seConnecter();
        $allActors = $pdo->query("
        SELECT CONCAT(p.first_name, ' ', p.last_name) AS 'actor', p.*, a.*
        FROM actor a
        INNER JOIN person p
        ON a.id_person = p.id_person
        ");
        $title = "Actors";

        require "view/list/listActors.php";
    }


    public function showActor(int $id)
    {
        
        $pdo = Connect::seConnecter();
        $showActor = $pdo->prepare("
        SELECT CONCAT(p.first_name, ' ', p.last_name) AS 'actor', p.*, a.*
        FROM actor a
        INNER JOIN person p
        ON a.id_person = p.id_person
        WHERE a.id_actor = :id_actor
        ");

        $showActor->execute([ "id_actor" => $id]);
        $title = "Actor";

        require "view/detail/detailActor.php";
    }

    
}
