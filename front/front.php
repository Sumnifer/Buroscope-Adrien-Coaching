<?php
session_start();
require_once "../tools/fonctions.php";
$connexion = connexion(); // ? ==> Connexion DB <==
$confirmation = null;
include "sections/header.php";
if (isset($_GET["action"])) {
    switch ($_GET["action"]) {
        case "index":
            $questions = "sections/questions.php";
            $request = "SELECT * FROM pages WHERE id_pages = 1";
            $result = mysqli_query($connexion, $request);
            $rows = mysqli_fetch_object($result);
            if($rows->visibility_prestations == 1) {
                $prestations = "sections/prestation.php";

            }

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
            include "sections/health.php";
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

        case "forgotPassword":
            include "sections/forgotpassword.php";
            break;

        case "resetPassword":
            include "sections/resetpassword.php";
            break;

        case "account":
            include "sections/account.php";
            break;
        case "calendar":
            include "sections/calendar.php";
            break;
        case "prestation":
            $request = "SELECT * FROM pages WHERE page_name = 'Prestation'";
            $result = mysqli_query($connexion, $request);
            $rows = mysqli_fetch_object($result);
            if($rows->visibility_slider == 1) {
                include "sections/slider.php";
            }
            include "sections/prestation.php";
            break;

    }
}
include "sections/footer.php";
