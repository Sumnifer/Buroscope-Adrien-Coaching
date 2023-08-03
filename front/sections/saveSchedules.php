<?php
session_start();
require "../../tools/fonctions.php";
$connexion = connexion();

if (isset($_GET['date'], $_GET['hour'], $_GET['prestation'])) {
    $mois_en_francais = array('janvier', 'février', 'mars', 'avril', 'mai', 'juin', 'juillet', 'août', 'septembre', 'octobre', 'novembre', 'décembre');
    $dateStr = $_GET['date'];
    $dateParts = explode(' ', $dateStr);
    $day = intval($dateParts[1]);
    $month = array_search($dateParts[2], $mois_en_francais) + 1;
    $year = intval($dateParts[3]);
    $formattedDate = sprintf('%04d-%02d-%02d 00:00:00', $year, $month, $day);
    $heure = $_GET['hour'];
    $prestationId = $_GET['prestation'];
    $requestPrice = "SELECT price_prestations FROM prestations WHERE id_prestations = ".$prestationId;
    $resultPrice= mysqli_query($connexion, $requestPrice);
    $rows=mysqli_fetch_object($resultPrice);
    $price = $rows->price_prestations;
    $time= time();
    $timestamp=date('H:i:s', $time);

    if (isset($_SESSION['id_users']) && $_SESSION['id_users'] != "") {
        $user = $_SESSION['id_users'];
        $request = "INSERT INTO temporary_schedules (date_schedules, id_users, hours_schedules, prestation_schedules, price_prestations, paid_prestations,created_at) 
                    VALUES ('$formattedDate', '$user', '$heure', '$prestationId', '$price', 0, '$timestamp')";
        $result = mysqli_query($connexion, $request);

        // Vous pouvez renvoyer une réponse JSON pour indiquer que l'opération a réussi.
        $response = array("success" => true, "message" => "Réservation effectuée avec succès.");
        echo json_encode($response);
    } else {
        // Si l'utilisateur n'est pas connecté, renvoyer une réponse JSON avec une indication d'erreur.
        $response = array("error" => true, "message" => "Vous devez vous connecter pour continuer.");
        echo json_encode($response);
    }
} else {
    // Si les données nécessaires ne sont pas fournies, renvoyer une réponse JSON avec une indication d'erreur.
    $response = array("success" => false, "message" => "Données manquantes pour effectuer la réservation.");
    echo json_encode($response);
}
?>
