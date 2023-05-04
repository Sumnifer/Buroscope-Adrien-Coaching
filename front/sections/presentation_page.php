<?php
require_once "../tools/fonctions.php";
$connexion = connexion();
mysqli_set_charset($connexion, "utf8");

$request = "SELECT * FROM presentations WHERE visibility_presentations != ? ORDER BY rank_presentations ASC";
$stmt = mysqli_prepare($connexion, $request);
$visibility = 2;
mysqli_stmt_bind_param($stmt, "i", $visibility);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);

$request1 = "SELECT * FROM sliders WHERE visibility_sliders = ?";
$stmt1 = mysqli_prepare($connexion, $request1);
$visibility1 = 1;
mysqli_stmt_bind_param($stmt1, "i", $visibility1);
mysqli_stmt_execute($stmt1);
$result1 = mysqli_stmt_get_result($stmt1);
?>

<div class="slider">
    <?php
    while ($rows1=mysqli_fetch_object($result1)){
  echo "<img class='slider-image' src='".$rows1->img_sliders."' alt='".$rows1->alt_sliders."'>"; }
  ?>
  <button id="slider-prev"><i class="fa-solid fa-chevron-left slider_icons"></i></button>
  <button id="slider-next"><i class="fa-solid fa-chevron-right slider_icons"></i></button>

</div>

<?php
    $content = "<main class='presentation_page' >";
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
