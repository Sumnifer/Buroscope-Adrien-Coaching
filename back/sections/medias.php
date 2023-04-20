<?php
if (isset($_SESSION["id_users"])) {
    $connexion = connexion();
    $title = "Gestion des Médias";
    $form = "forms/formMedia.php";
    $action_form = "newMedia";
}
