<?php
session_start();
require_once "../tools/fonctions.php";
$connexion = connexion(); // ? ==> Connexion DB <==
$confirmation="";



if (isset($_GET["action"])) {

    switch ($_GET["action"]) {

        case "logout":
            session_destroy();
            header("location: ../front");
            break;

        case "newsletters" :
            if (!empty($_POST['email_newsletters'])){
                $email = htmlspecialchars($_POST['email_newsletters'], ENT_QUOTES, "UTF-8");
                $stmt = $connexion->prepare(
                    "INSERT INTO newsletters (email_newsletters) VALUES (?)"
                );
                $stmt->bind_param(
                    "s",
                    $email
                );
                $stmt->execute();
                $stmt->close();
                $confirmation = "<p class=\"success\"><i class=\"fa-solid fa-circle-check success_icon\"></i>Vous êtes désormais inscrit à notre newsletter !</p>";
            }
            break;



    }
}
include "front.html";
mysqli_close($connexion); // ? ==> Fermeture DB <==

//if (isset($_SESSION["id_users"])) {
//
//} else {
//    header("Location:../login/login.php");
//}
