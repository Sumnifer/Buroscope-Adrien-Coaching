<?php
require_once "../tools/fonctions.php";
$connexion = connexion();
mysqli_set_charset($connexion, "utf8");



$questions = "<section class=questions >";
$questions .= "<h1 class='questions__title'>Foire au <span class='questions__title_span'>questions</span></h1>";
$questions .= "<h2 class='questions__subtitle'>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Ab asperiores, aspernatur,!</h2>";
$request = "SELECT * FROM questions";
$result = mysqli_query($connexion, $request);
while ($rows = mysqli_fetch_object($result)) {
    $questions.="<details class='questions__details'>";
    $questions.="<summary class='questions__details_summary'>$rows->question_name</summary>";
    $questions .= "<p class='questions__details_paragraph'>$rows->question_content</p> ";
    $questions.="</details>";
}
$questions .= '</div></section>';

echo $questions;

