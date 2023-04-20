<?php
//permet d'autoriser l'usage des variables de session
session_start();
require_once "../tools/fonctions.php";

//si qq appuie sur le bouton ENTRER du formulaire de connexion
if (isset($_POST["submit"])) {
    if (!empty($_POST["email"]) && !empty($_POST["password"])) {
        login($_POST["email"], $_POST["password"]);

    }
}

include "login.html";
include "../front/sections/generic/footer.php";
