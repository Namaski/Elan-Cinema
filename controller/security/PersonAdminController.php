<?php

namespace Controller\Security;

use Model\Connect;

class PersonAdminController
{

    ////////SHOW PANEL PERSON/////////
    public function showPanelPerson()
    {
        $pdo = Connect::seConnecter();
        $allPerson = $pdo->query(
            "SELECT 
        p.id_person,
        CONCAT(p.first_name, ' ', p.last_name) AS 'name',
        p.birthdate,
        p.picture,
        p.sex,
            CASE 
                WHEN r.id_realisator IS NOT NULL AND a.id_actor IS NOT NULL THEN 'Realisator & Actor'
                WHEN r.id_realisator IS NOT NULL THEN 'Realisator'
                WHEN a.id_actor IS NOT NULL THEN 'Actor'
                ELSE 'None'
            END AS type
        FROM person p
        LEFT JOIN realisator r ON p.id_person = r.id_person
        LEFT JOIN actor a ON p.id_person = a.id_person"
        );

        require "view/admin/person/person.php";
    }


    ////////////////ADD PERSON//////////////////
    public function addPerson()
    {
        $pdo = Connect::seConnecter();

        if (isset($_POST['submit'])) {
            $first_name = filter_input(INPUT_POST, 'first_name', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            $last_name = filter_input(INPUT_POST, 'last_name', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            $birthdate = filter_input(INPUT_POST, 'birthdate', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            $sex = filter_input(INPUT_POST, 'sex', FILTER_SANITIZE_FULL_SPECIAL_CHARS);

            $picture = null;

            if (!empty($_FILES["picture"]["name"])) {
                $target_dir = "./public/img/uploads/";
                $file_name = basename($_FILES["picture"]["name"]);
                $target_file = $target_dir . $file_name;
                $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
                $uploadOk = 1;
                $errors = [];

                $check = getimagesize($_FILES["picture"]["tmp_name"]);
                if ($check === false) {
                    $errors[] = "File is not an image.";
                    $uploadOk = 0;
                }

                if (file_exists($target_file)) {
                    $errors[] = "File already exists.";
                    $uploadOk = 0;
                }

                if ($_FILES["picture"]["size"] > 500000) {
                    $errors[] = "File is too large.";
                    $uploadOk = 0;
                }

                if (!in_array($imageFileType, ['jpg', 'jpeg', 'png', 'gif', 'webp'])) {
                    $errors[] = "Invalid image format.";
                    $uploadOk = 0;
                }

                if ($uploadOk === 1) {
                    if (move_uploaded_file($_FILES["picture"]["tmp_name"], $target_file)) {
                        $picture = $target_file;
                    } else {
                        $_POST['message'] = "Error uploading the file.";
                        return;
                    }
                } else {
                    $_POST['message'] = "Image upload failed: " . implode(" ", $errors);
                    return;
                }
            }

            $stmt = $pdo->prepare("INSERT INTO person (first_name, last_name, birthdate, sex, picture)
                               VALUES (:first_name, :last_name, :birthdate, :sex, :picture)");
            $stmt->execute([
                ':first_name' => $first_name,
                ':last_name' => $last_name,
                ':birthdate' => $birthdate,
                ':sex' => $sex,
                ':picture' => $picture
            ]);

            // GET LAST ID
            $id_person = $pdo->lastInsertId();

    
            if (!empty($_POST['is_actor'])) {
                $stmt = $pdo->prepare("INSERT INTO actor (id_person) VALUES (:id_person)");
                $stmt->execute([':id_person' => $id_person]);
            }

      
            if (!empty($_POST['is_realisator'])) {
                $stmt = $pdo->prepare("INSERT INTO realisator (id_person) VALUES (:id_person)");
                $stmt->execute([':id_person' => $id_person]);
            }

            $_POST['message'] = "The person has been successfully added.";
        }

        require "view/admin/person/addPerson.php";
    }

    ///////////EDIT PERSON/////////
    public function editPerson(?int $id = null)
    {
        $pdo = Connect::seConnecter();

        // IF SUBMITTED
        if (isset($_POST['submit'])) {
            $first_name = filter_input(INPUT_POST, 'first_name', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            $last_name = filter_input(INPUT_POST, 'last_name', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            $birthdate = filter_input(INPUT_POST, 'birthdate', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            $sex = filter_input(INPUT_POST, 'sex', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            $id_person = filter_input(INPUT_POST, 'id_person', FILTER_SANITIZE_NUMBER_INT);

            if (!$first_name || !$last_name || !$birthdate || !$sex) {
                $_SESSION['message'] = 'Please fill all the required fields';
                header('Location: index.php?action=editPerson&id=' . $id_person);
                exit;
            }

            $picture = null;

            if (!empty($_FILES["picture"]["name"])) {
                $target_dir = "./public/img/uploads/";
                $file_name = basename($_FILES["picture"]["name"]);
                $target_file = $target_dir . $file_name;
                $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
                $uploadOk = 1;
                $errors = [];

                $check = getimagesize($_FILES["picture"]["tmp_name"]);
                if ($check === false) {
                    $errors[] = "File is not an image.";
                    $uploadOk = 0;
                }

                if (file_exists($target_file)) {
                    $errors[] = "File already exists.";
                    $uploadOk = 0;
                }

                if ($_FILES["picture"]["size"] > 500000) {
                    $errors[] = "File is too large.";
                    $uploadOk = 0;
                }

                if (!in_array($imageFileType, ['jpg', 'jpeg', 'png', 'gif', 'webp'])) {
                    $errors[] = "Invalid image format.";
                    $uploadOk = 0;
                }

                if ($uploadOk === 1) {
                    if (move_uploaded_file($_FILES["picture"]["tmp_name"], $target_file)) {
                        $picture = $target_file;
                    } else {
                        $_SESSION['message'] = "Error uploading the file.";
                        header('Location: index.php?action=editPerson&id=' . $id_person);
                        exit;
                    }
                } else {
                    $_SESSION['message'] = "Image upload failed: " . implode(" ", $errors);
                    header('Location: index.php?action=editPerson&id=' . $id_person);
                    exit;
                }
            }

            if ($picture) {
                $stmt = $pdo->prepare("UPDATE person SET first_name = :first_name, last_name = :last_name, 
                                     birthdate = :birthdate, sex = :sex, picture = :picture 
                                     WHERE id_person = :id_person");
                $stmt->execute([
                    ':first_name' => $first_name,
                    ':last_name' => $last_name,
                    ':birthdate' => $birthdate,
                    ':sex' => $sex,
                    ':picture' => $picture,
                    ':id_person' => $id_person
                ]);
            } else {
                $stmt = $pdo->prepare("UPDATE person SET first_name = :first_name, last_name = :last_name, 
                                     birthdate = :birthdate, sex = :sex 
                                     WHERE id_person = :id_person");
                $stmt->execute([
                    ':first_name' => $first_name,
                    ':last_name' => $last_name,
                    ':birthdate' => $birthdate,
                    ':sex' => $sex,
                    ':id_person' => $id_person
                ]);
            }

           
            $pdo->prepare("DELETE FROM actor WHERE id_person = :id_person")->execute([':id_person' => $id_person]);
            $pdo->prepare("DELETE FROM realisator WHERE id_person = :id_person")->execute([':id_person' => $id_person]);

            
            if (!empty($_POST['is_actor'])) {
                $pdo->prepare("INSERT INTO actor (id_person) VALUES (:id_person)")->execute([':id_person' => $id_person]);
            }

            if (!empty($_POST['is_realisator'])) {
                $pdo->prepare("INSERT INTO realisator (id_person) VALUES (:id_person)")->execute([':id_person' => $id_person]);
            }

            $_SESSION['message'] = "The person has been successfully updated.";
            header('Location: index.php?action=editPerson&id=' . $id_person);
            exit;

        } elseif ($id) {
            
            $stmt = $pdo->prepare(
                "SELECT p.*, 
                        DATE_FORMAT(p.birthdate, '%Y-%m-%d') AS birthdate_formatted,
                        CASE WHEN a.id_actor IS NOT NULL THEN 1 ELSE 0 END AS is_actor,
                        CASE WHEN r.id_realisator IS NOT NULL THEN 1 ELSE 0 END AS is_realisator
                 FROM person p
                 LEFT JOIN actor a ON p.id_person = a.id_person
                 LEFT JOIN realisator r ON p.id_person = r.id_person
                 WHERE p.id_person = :id_person"
            );
            
            $stmt->execute([':id_person' => $id]);
            $person = $stmt->fetch();

            if (!$person) {
                header('Location: index.php?action=showPanelPerson');
                exit;
            }

            $is_actor = $person['is_actor'];
            $is_realisator = $person['is_realisator'];

            require "view/admin/person/editPerson.php";

        } else {
            // NO ID PROVIDED, REDIRECT TO PERSON PANEL
            header('Location: index.php?action=showPanelPerson');
            exit;
        }
    }

    ///////////DELETE PERSON/////////
    public function deletePerson(int $id)
    {
        $pdo = Connect::seConnecter();

        
        $stmt = $pdo->prepare("SELECT * FROM person WHERE id_person = :id_person");
        $stmt->execute([':id_person' => $id]);
        $person = $stmt->fetch();

        if (!$person) {
            $_SESSION['message'] = "Person not found.";
            header('Location: index.php?action=showPanelPerson');
            exit;
        }

        // DELETE PERSON
        $stmt = $pdo->prepare("DELETE FROM person WHERE id_person = :id_person");
        $stmt->execute([':id_person' => $id]);

        $_SESSION['message'] = "The person has been successfully deleted.";
        header('Location: index.php?action=showPanelPerson');
        exit;
    }
}
