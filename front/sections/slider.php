<?php
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
