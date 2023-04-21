<?php
require_once "../../tools/fonctions.php";
$connexion = connexion();

if (isset($_POST["submit"])) {
    $requiredFields = [
        "email_users" => "Veuillez entrer une adresse mail valide",
        "pass_users" => "Veuillez entrer un mot de passe valide",
        "gender_users" => "Veuillez sélectionner une civilité",
        "name_users" => "Veuillez entrer un prénom valide",
        "surname_users" => "Veuillez entrer un nom valide",
        "phone_users" => "Veuillez entrer un téléphone valide",
        "date_users" => "Veuillez entrer une date de naissance valide",
    ];

    $confirmation = "";
    foreach ($requiredFields as $field => $message) {
        if (empty($_POST[$field])) {
            $confirmation = "<p class='warning'><i class='fa-solid fa-triangle-exclamation warning_icon mr-1'></i>$message</p>";
            break;
        }
    }
    if (empty($confirmation)) {
        $email = htmlspecialchars($_POST["email_users"], ENT_QUOTES, "UTF-8");
        $genre =$_POST["gender_users"];
        $surname = htmlspecialchars($_POST["surname_users"], ENT_QUOTES, "UTF-8");
        $name = htmlspecialchars($_POST["name_users"], ENT_QUOTES, "UTF-8");
        $phone = preg_replace("/[^0-9]/","",$_POST["phone_users"]);
        $date = strtotime(str_replace("/", "-", $_POST['date_users']));
        if(!$date){
            $confirmation= "<p class=\"warning\"><i class=\"fa-solid fa-triangle-exclamation warning_icon mr-1\"></i>Veuillez entrer une date de naissance valide</p>";
        }else{
            $date=date("Y-m-d", $date);
        }
        $pass = password_hash(
            htmlspecialchars($_POST["pass_users"], ENT_QUOTES, "UTF-8"),
            PASSWORD_DEFAULT
        );
        $statut = "user";

        $stmt = $connexion->prepare(
            "INSERT INTO users (email_users, surname_users, gender_users, phone_users, name_users, date_users, pass_users, statut_users  ) VALUES (?, ?, ?, ?, ?, ?, ?, ?)"
        );
        $stmt->bind_param(
            "ssssssss",
            $email,
            $surname,
            $genre,
            $phone,
            $name,
            $date,
            $pass,
            $statut

        );


        if($stmt->execute()){
            header("Location: formSante.html");
            $confirmation =
            "<p class=\"success\"><i class=\"fa-solid fa-circle-check success_icon\"></i>Bienvenue parmi nous ! Vous pouvez désormais vous connecter.</p>";
            foreach($_POST as $cle => $valeur){
                unset($_POST[$cle]);
            }
        }else{
            $confirmation=
            "<p class=\"warning\"><i class=\"fa-solid fa-triangle-exclamation warning_icon mr-1\"></i>Une erreur est suvenue</p>";
        }
    }
}
include "inscription.html";
include "footer.php";
mysqli_close($connexion);

        $stmt->execute();
        header("Location: ../front/index.php");