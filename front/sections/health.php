<?php
$connexion = connexion();
include "formSante.php";
    if (isset($_GET['case'])){
        switch ($_GET['case']){
            case "store":
                if (empty($_POST["1"])) {
                    $confirmation =
                        "<p class='warning confirmation'><i class='fa-solid fa-circle-exclamation warning_icon'></i> Veuillez choisir une option </p>";
                }
                elseif (empty($_POST["2"])) {
                    $confirmation =
                        "<p class='warning confirmation'><i class='fa-solid fa-circle-exclamation warning_icon'></i> Veuillez choisir une option </p>";
                }
                elseif (empty($_POST["3"])) {
                    $confirmation =
                        "<p class='warning confirmation'><i class='fa-solid fa-circle-exclamation warning_icon'></i> Veuillez choisir une option </p>";
                }
                elseif (empty($_POST["4"])) {
                    $confirmation =
                        "<p class='warning confirmation'><i class='fa-solid fa-circle-exclamation warning_icon'></i> Veuillez choisir une option </p>";
                } else {
                    $request = "INSERT INTO health (id_users, question1, question2, question3, question4) 
                    VALUES (:id_users, :question1, :question2, :question3, :question4)";
                    $stmt = $connexion->prepare($request);
                    $id_users = $_SESSION['id_users'];
                    $question1 = $_POST['question1'];
                    $question2 = $_POST['question2'];
                    $question3 = $_POST['question3'];
                    $question4 = $_POST['question4'];
                    $stmt->bindParam(':id_users', $id_users, PDO::PARAM_INT);
                    $stmt->bindParam(':question1', $question1, PDO::PARAM_STR);
                    $stmt->bindParam(':question2', $question2, PDO::PARAM_STR);
                    $stmt->bindParam(':question3', $question3, PDO::PARAM_STR);
                    $stmt->bindParam(':question4', $question4, PDO::PARAM_STR);
                    $stmt->execute();
                }
                break;
        }

}
