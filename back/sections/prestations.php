<?php
if (isset($_SESSION["id_users"])) {
    $connexion = connexion();
    mysqli_set_charset($connexion, "utf8");
    $title = "Gestion des Prestations";
    $form = "forms/formPrestations.php";
    $action_form = "newPrestations";

}
