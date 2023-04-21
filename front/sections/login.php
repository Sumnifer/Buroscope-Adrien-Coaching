<?php
session_start();
require_once "../../tools/fonctions.php";
    if (isset($_POST["submit"])) {
        if (!empty($_POST["email"]) && !empty($_POST["password"])) {
            login($_POST["email"], $_POST["password"]);
        }
    }
include "login.html";
include "footer.php";
