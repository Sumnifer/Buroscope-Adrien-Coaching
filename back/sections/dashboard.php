<?php
$title = "Dashboard";
$connexion = connexion();

function counter($connexion, $table)
{
    $request = "SELECT * FROM " . $table;
    $result = mysqli_query($connexion, $request);
    return mysqli_num_rows($result);
}

$cards = [
    "users" => ["count" => counter($connexion, "users"), "icon" => "fa-users", "name" => "Utilisateurs",],
    "pages" => ["count" => counter($connexion, "pages"), "icon" => "fa-file-alt","name" => "Pages",],
    "articles" => ["count" => counter($connexion, "articles"), "icon" => "fa-newspaper","name" => "Articles",],
    "presentations" => ["count" => counter($connexion, "presentations"), "icon" => "fa-text", "name" => "Présentations",],
];

$content = "<section class='dashboard'>";

foreach ($cards as $name => $card) {
    $count = $card["count"];
    $icon = $card["icon"];
    $titre = $card["name"];
    $link = $name;
    $content .=
        "<a class='dashboard__link' href='back.php?action=" . $link . "'>";
    $content .= "<div class='dashboard__link_card'>";
    $content .= "<p class='dashboard__link_card_title'>$titre</p>";
    $content .= "<i class='fa-solid $icon dashboard__link_card_icons'></i>";
    $content .= "<p class='dashboard__link_card_paragraph'>$count</p>";
    $content .= "</div></a>";
}

$content .= "</section>";
