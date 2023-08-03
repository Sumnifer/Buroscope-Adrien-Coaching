<?php
require_once "../tools/fonctions.php";
$connexion = connexion();
mysqli_set_charset($connexion, "utf8");
$request = "SELECT * FROM prestations WHERE visibility_prestations != ? ORDER BY rank_prestations ASC";
$stmt = mysqli_prepare($connexion, $request);
$visibility = 2;
mysqli_stmt_bind_param($stmt, "i", $visibility);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);

$request1 = "SELECT COUNT(*) AS nb_prestations FROM prestations WHERE visibility_prestations = ?";
$stmt1 = mysqli_prepare($connexion, $request1);
$visibility1 = 1;
mysqli_stmt_bind_param($stmt1, "i", $visibility1);
mysqli_stmt_execute($stmt1);
$result1 = mysqli_stmt_get_result($stmt1);

$rows1 = mysqli_fetch_assoc($result1);
$nb_prestations = $rows1['nb_prestations'];


$content = "<section class='prestation' id='prestation'>
<h1 class='prestation__title'>
Découvrez <span class='prestation__title_span'>mes prestations</span></h1>";
$content .= "<div class='prestation__container'>";


while ($rows = mysqli_fetch_object($result)) {
    $content .= "<div class='prestation__container_card' style='width: 300px; min-height: 375px'>";
    $content .= "<div class='prestation__container_card_header'>";
    $content .= "<h3 class='prestation__container_card_header_title'>$rows->title_prestations</h3>";
    $current_url = "https://bennyb35.fr/adrien-coaching/front/front.php?action=prestation";
    if ($_SERVER['REQUEST_URI'] === $current_url) {
        echo "coucou";
        $content .= "<span class='prestation__container_card_header_span'> $rows->price_prestations €</span>";
    }
    $content .= "</div>";
    $content .= "<p class='prestation__container_card_paragraph'>$rows->content_prestations</p>";
    $content .= "<a href='front.php?action=calendar&prestations=$rows->title_prestations' class='prestation__container_card_cta'>Je m'inscris ! <i class='fa-solid fa-dumbbell'></i></a>";
    $content .="</div>";

}



if (isset($content)) {
    echo $content;
} ?>

</section>