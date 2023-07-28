<?php
require_once "../tools/functions.php";
$connexion = connexion();
mysqli_set_charset($connexion, "utf8");

$questions = "<section class=questions>";

$request = "SELECT * FROM questions";
$result = mysqli_query($connexion, $request);
while ($rows = mysqli_fetch_object($result)) {
    $questions .= '<div class="questions__container">';
    $questions .= '';
}