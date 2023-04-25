<?php 
if (isset($_SESSION["id_users"])){
    $title = "Gestion Utilisateur";
    $form = "fomSettings.php";
    $action_form= "modifyUsers";
    $connexion = connexion();
    
}