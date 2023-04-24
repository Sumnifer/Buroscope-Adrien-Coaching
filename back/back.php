<?php
session_start();
if (isset($_SESSION["id_users"])) {
    if ($_SESSION["statut_users"] != "user") {
        require_once "../tools/fonctions.php";
        $connexion = connexion(); // ? ==> Connexion DB <==

        if (isset($_GET["action"])) {
            switch ($_GET["action"]) {
                case "logout":
                    session_destroy();
                    header("location: ../front/front.php?action=index");
                    break;

                // * <== ----------------------------------------------------- ==>

                case "users":
                    include "sections/users.php";
                    break;

                // * <== ----------------------------------------------------- ==>

                case "settings":
                    include "sections/settings.php";
                    break;

                // * <== ----------------------------------------------------- ==>

                case "dashboard":
                    include "sections/dashboard.php";
                    break;

                // * <== ----------------------------------------------------- ==>

                case "pages":
                    include "sections/pages.php";
                    break;

                // * <== ----------------------------------------------------- ==>

                case "articles":
                    include "sections/articles.php";
                    break;

                // * <== ----------------------------------------------------- ==>

                case "calendar":
                    include "sections/calendar.php";
                    break;

                // * <== ----------------------------------------------------- ==>

                case "presentations":
                    include "sections/presentations.php";
                    break;

                // * <== ----------------------------------------------------- ==>

                case "prestations":
                    include "sections/prestations.php";
                    break;

                // * <== ----------------------------------------------------- ==>

            }

            // ?<== ========================================== ==> Fin du Switch <== =========================================== ==>
        } else {
            header("Location: back.php?action=dashboard");
        }

        include "back.html";
        mysqli_close($connexion); // ? ==> Fermeture DB <==
    } else {
        header("Location: ../front/front.php?action=index");
    }
} else {
    header("Location: ../front/front.php?action=logging");
}
