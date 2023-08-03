<?php
require "../../tools/fonctions.php";
$connexion = connexion();
if (isset($_GET['id'])) {
    $itemId = $_GET['id'];

    $request = "DELETE FROM temporary_schedules WHERE id = ".$itemId;
    $result = mysqli_query($connexion, $request);

}
