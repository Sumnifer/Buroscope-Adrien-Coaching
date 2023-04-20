<?php
session_start();
$form = "forms/formNewsletters.php";
require_once "../tools/fonctions.php";
$connexion = connexion(); // ? ==> Connexion DB <==



if (isset($_GET["action"])) {

    switch ($_GET["action"]) {

        case "logout":
            session_destroy();
            header("location: ../front");
            break;

        case "newsletters":
            include "sections/newsletters.php";
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
