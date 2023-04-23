<?php
session_start();
require_once "../tools/fonctions.php";
$connexion = connexion(); // ? ==> Connexion DB <==
$confirmation = "";
include "sections/header.php";
if (isset($_GET["action"])) {
    switch ($_GET["action"]) {
        case "index":
            include "front.html";
            break;
        case "logging":
            include "sections/login.php";
            break;
        case "contact":
            if (isset($_SESSION["id_users"])) {
                include "sections/contact_logged.php";
            } else {
                include "sections/contact.php";
            }
            break;
        case "contact_logged":
            include "sections/contact_logged.php";
            break;
        case "inscription":
            include "sections/inscription.php";
            break;
        case "formSante":
            include "sections/formSante.php";
            break;
        case "logout":
            session_destroy();
            header("location: front.php?action=index");
            break;

        case "newsletters":
            if (!empty($_POST["email_newsletters"])) {
                $email = htmlspecialchars(
                    $_POST["email_newsletters"],
                    ENT_QUOTES,
                    "UTF-8"
                );
                $stmt = $connexion->prepare(
                    "INSERT INTO newsletters (email_newsletters) VALUES (?)"
                );
                $stmt->bind_param("s", $email);
                $stmt->execute();
                $stmt->close();
                $confirmation =
                    "<p class=\"success\"><i class=\"fa-solid fa-circle-check success_icon\"></i>Vous êtes désormais inscrit à notre newsletter !</p>";
                include "front.html";
            }
            break;
            case "presentation":
                include "sections/presentation_page.php";
                break;
    }
}
include "sections/footer.php";

mysqli_close($connexion); // ? ==> Fermeture DB <==
header("Location: front.php?action=index");
