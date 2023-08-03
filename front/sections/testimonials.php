<?php
$testimonials = "";
$request = "SELECT * FROM testimonials WHERE testimonials_status = 1 ORDER BY testimonials_date DESC LIMIT 3";
$result = mysqli_query($connexion, $request);
while ($rows = mysqli_fetch_object($result)) {
    $testimonials .= "<div class='testimonials__cards_card'>";
    $testimonials .= "<i class='fa-solid fa-quote-left testimonials__cards_card_icon'></i>";
    $testimonials .= "<p class='testimonials__cards_card_paragraph'>" . $rows->testimonials_content . "</p>";
    $testimonials .= "<div class='testimonials__cards_card_name'>" . $rows->testimonials_name . "</div>";
    $testimonials .= "</div>";

}
echo $testimonials;
