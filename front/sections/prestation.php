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
    if(($nb_prestations == '4') || ($nb_prestations == '8')){
    $content .= "<div class='prestation__container' style='grid-template-columns: repeat(4, 1fr);'>";
    }
    else{
    $content .= "<div class='prestation__container' style='grid-template-columns: repeat(3, 1fr);'>";
    }


while($rows = mysqli_fetch_object($result)) {

    $content .= "<div class='prestation__container_card'>";
    $content .= "<img src='$rows->img_prestations' alt='$rows->alt_prestations' class='prestation__container_card_img'>";
    $content .= "<button class='prestation__container_card_cta'>$rows->title_prestations</button>";
    $content .= "<h3 class='prestation__container_card_title'>$rows->title_prestations";
    $content .= "<span class='prestation__container_card_title_span'> : $rows->price_prestations €</span></h3>";
    $content .= "<p class='prestation__container_card_paragraph'>$rows->content_prestations</p></div>";
}

if(isset($content)){echo $content;} ?>

</section>