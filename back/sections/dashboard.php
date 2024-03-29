<?php

$title = "Dashboard";
$connexion = connexion();
function counter($connexion, $table)
{
    $request = "SELECT * FROM " . $table;
    if(($table == 'users') && ($_SESSION['statut_users'] != 'root')){
        $request .= " WHERE statut_users != 'root'";
    }
    $result = mysqli_query($connexion, $request);
    return mysqli_num_rows($result);
}

$cards = [
    "users" => [
        "count" => counter($connexion, "users"),
        "icon" => "fa-users",
        "name" => "Utilisateurs",
    ],
    "pages" => [
        "count" => counter($connexion, "pages"),
        "icon" => "fa-page",
        "name" => "Pages",
    ],
    "sliders" => [
        "count" => counter($connexion, "sliders"),
        "icon" => "fa-rectangle-vertical-history",
        "name" => "Sliders",
    ],
    "payments" => [
        "count" => counter($connexion, "sliders"),
        "icon" => "fa-credit-card-alt",
        "name" => "Paiements",
    ],
    "presentations" => [
        "count" => counter($connexion, "presentations"),
        "icon" => "fa-layer-group",
        "name" => "Présentations",
    ],
    "prestations" => [
        "count" => counter($connexion, "prestations"),
        "icon" => "fa-cards-blank",
        "name" => "Prestations",
    ],
    "questions" => [
        "count" => counter($connexion, "questions"),
        "icon" => "fa-question",
        "name" => "Questions",
    ],
    "notices" => [
        "count" => counter($connexion, "notices"),
        "icon" => "fa-thumbs-up",
        "name" => "Avis",
    ],
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
