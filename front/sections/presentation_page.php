<?php
require_once "../tools/fonctions.php";
$connexion = connexion();
mysqli_set_charset($connexion, "utf8");

$request = "SELECT * FROM presentations WHERE visibility_presentations != ? ORDER BY rank_presentations ASC";
$stmt = mysqli_prepare($connexion, $request);
$visibility = 2;
mysqli_stmt_bind_param($stmt, "i", $visibility);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt); ?>



<?php
    $content = "<main class='presentation_page' >";
    $content .= "<h1 class='presentation_page__title'> Mes différentes <span class='presentation_page__title_span'>activités</span></h1>";
     while($rows = mysqli_fetch_object($result)) {
        if ($rows->direction_presentations == 'left') {
            $content .=  "<div class='presentation_page__card'>";
            $content .= "<img src='$rows->img_presentations' alt='' class='presentation_page__card_img'>";
            $content .= "<div class='presentation_page__card_content'>";
            $content .= "<h2 class='presentation_page__card_content_title'>$rows->title_presentations</h2>";
            $content .="<p class='presentation_page__card_content_paragraph'>$rows->content_presentations</p></div></div>";

        } if($rows->direction_presentations == 'right') {
               $content .=  "<div class='presentation_page__card'>";
               $content .= "<div class='presentation_page__card_content'>";
               $content .= "<h2 class='presentation_page__card_content_title'>$rows->title_presentations</h2>";
               $content .="<p class='presentation_page__card_content_paragraph'>$rows->content_presentations</p></div>";
               $content .="<img src='$rows->img_presentations' alt='' class='presentation_page__card_img'></div>";
        }
    }

    $request = "SELECT * FROM pages WHERE page_name = 'A Propos'";
    $result = mysqli_query($connexion, $request);
    $rows = mysqli_fetch_object($result);
    if($rows->visibility_slider == 1) {
        include "slider.php";
    }

    if(isset($content)){echo $content;}

    $request = "SELECT * FROM pages WHERE page_name = 'A Propos'";
    $result = mysqli_query($connexion, $request);
    $rows = mysqli_fetch_object($result);
    if($rows->visibility_prestations == 1) {
        include "prestation.php";
    } ?>

</main>
