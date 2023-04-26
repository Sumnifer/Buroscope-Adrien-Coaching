<?php
require_once "../tools/fonctions.php";
$connexion = connexion();
mysqli_set_charset($connexion, "utf8");
$request = "SELECT * FROM prestations WHERE prestations.visibility_prestations != 2  ORDER BY rank_prestations ASC";
$result=mysqli_query($connexion, $request);

$content = "<section class='prestation' id='prestation'>
<h1 class='prestation__title'>
Découvrez <span class='prestation__title_span'>mes prestations</span></h1>
    <div class='prestation__container'>";

while($rows = mysqli_fetch_object($result)) {
    $content .= "<div class='prestation__container_card'>";
    $content .= "<img src='$rows->img_prestations' alt='$rows->alt_prestations' class='prestation__container_card_img'>";
    $content .= "<button class='prestation__container_card_cta'>$rows->title_prestations</button>";
    $content .= "<h3 class='prestation__container_card_title'>$rows->title_prestations";
    $content .= "<span class='prestation__container_card_title_span'> : $rows->price_prestations</span></h3>";
    $content .= "<p class='prestation__container_card_paragraph'></p></div>";
}

if(isset($content)){echo $content;} ?>

</section>