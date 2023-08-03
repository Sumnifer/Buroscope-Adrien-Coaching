<?php
require "../../tools/fonctions.php";
$connexion = connexion();

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["testimonials_firstname"], $_POST["testimonials_lastname"], $_POST["testimonials_content"])) {
    $name = $_POST["testimonials_firstname"]." ".$_POST['testimonials_lastname'];
    $content = $_POST["testimonials_content"];
    $status = 3;
    $visibility = 1;
    $date = date("Y-m-d H:i:s");
    $insertQuery = "INSERT INTO testimonials (testimonials_name, testimonials_content, testimonials_status, testimonials_visibility, testimonials_date) VALUES (?, ?, ?, ?, ?)";
    $stmt = mysqli_prepare($connexion, $insertQuery);
    mysqli_stmt_bind_param($stmt, "ssiis", $name, $content, $status, $visibility, $date);

    $result = mysqli_stmt_execute($stmt);

    if ($result) {
        $response = [
            "status" => "success",
            "message" => "Données du formulaire enregistrées avec succès."
        ];
    } else {
        $response = [
            "status" => "error",
            "message" => "Une erreur est survenue lors de l'enregistrement des données du formulaire."
        ];
    }

    header("Content-Type: application/json");
    echo json_encode($response);
} else {
    $response = [
        "status" => "error",
        "message" => "Le formulaire n'a pas été soumis correctement."
    ];

    header("Content-Type: application/json");
    echo json_encode($response);
}
