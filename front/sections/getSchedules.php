<?php
require "../../tools/fonctions.php";
$connexion = connexion();
if (isset($_GET['date'])) {
    $mois_en_francais = array('janvier', 'février', 'mars', 'avril', 'mai', 'juin', 'juillet', 'août', 'septembre', 'octobre', 'novembre', 'décembre');
    $dateStr = $_GET['date'];
    $dateParts = explode(' ', $dateStr);
    $day = intval($dateParts[1]);
    $month = array_search($dateParts[2], $mois_en_francais) + 1;
    $year = intval($dateParts[3]);
    $formattedDate = sprintf('%04d-%02d-%02d', $year, $month, $day);
    $weekNumber = $_GET['week'];
    $year = $_GET['year'];
    $date = $_GET['date'];
    $request = "SELECT hours_schedules FROM temporary_schedules WHERE date_schedules LIKE '%$formattedDate%'
            UNION
            SELECT hours_schedules FROM temporary_schedules WHERE date_schedules LIKE '%$formattedDate%'";

    $result = mysqli_query($connexion, $request);
    $reservedSlots = array();
    if (mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            $heure = $row['hours_schedules'];
            $reservedSlots[] = $heure;
        }
    }
    $allSlots = array();
    for ($hour = 9; $hour <= 17; $hour++) {
        $heure = str_pad($hour, 2, '0', STR_PAD_LEFT) . ':00';
        if (!in_array($heure, $reservedSlots)) {
            $allSlots[] = $heure;
        }
    }
    $availableSlots = array_diff($allSlots, $reservedSlots);
    header('Content-Type: application/json');
    echo json_encode($availableSlots);
}