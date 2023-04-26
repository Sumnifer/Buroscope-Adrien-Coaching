<?php
require_once "../tools/fonctions.php";

$connexion = connexion();
mysqli_set_charset($connexion, "utf8");

$request1="SELECT * FROM sliders ORDER BY id_sliders ASC";
$result1=mysqli_query($connexion,$request1);
$content="";
?>
<section id="slider" class="bgcolor1 flex pad">
    <?php while($rows1 = mysqli_fetch_object($result1)) {
    $content.="<div>";
    $content.="<div class='slide'>";
    $content.="<img class='w2' src='".$rows1->img_sliders."' alt='".$rows1->alt_sliders."'>";
    $content.="<article class='w2'>";
    $content.="<h1 class='color4'>'".$rows1->title_sliders."'</h1>";
    $content.="</article></div></div>";
    }
$content .="</section>";
?>
<?php











$request = "SELECT * FROM presentations WHERE visibility_presentations != 2  ORDER BY rank_presentations ASC";
$result=mysqli_query($connexion, $request);

  $content .= "<main class='presentation_page' >";
    $content .= "<h1 class='presentation_page__title'> Mes différentes <span class='presentation_page__title_span'>presentations</span></h1>";
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
    }?>
    <?php if(isset($content)){echo $content;} ?>
    <?php include "prestation.php"?>
</main>
