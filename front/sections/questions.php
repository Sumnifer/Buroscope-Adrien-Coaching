<?php
require_once "../tools/fonctions.php";
$connexion = connexion();
mysqli_set_charset($connexion, "utf8");

$questions = "<section class=questions>";
$questions .= "<h1 class='question__title'>Foire au <span class='question__title_span'>question</span></h1>";
$questions .= "<h2 class='question__subtitle'>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Ab asperiores, aspernatur, autem facilis, ipsa optio quaerat repellat sit tempore temporibus tenetur ullam veniam. Aliquam enim laborum nobis quo rem vitae!</h2>";
$request = "SELECT * FROM questions";
$result = mysqli_query($connexion, $request);
while ($rows = mysqli_fetch_object($result)) {
    $questions .= '<div class="questions__container">';
    $questions .= '<h3 class="questions__container_title">"'.$rows->question_name.'"</h3>';
    $questions .= '<div class="questions__container">';
    $questions .= '<p class="questions__container_content">"'.$rows->question_content.'"</p> ';

}
$questions .= '</div></section>';

echo $questions;