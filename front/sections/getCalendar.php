<?php
$currentWeek = date('W');
$currentDate = new DateTime();
function getWeekDaysFromMondayToSunday($weekNumber = null, $year = null)
{
    if ($weekNumber !== null && ($weekNumber < 1 || $weekNumber > 53)) {
        throw new InvalidArgumentException("Le numéro de semaine doit être compris entre 1 et 53.");
    }
    if ($year !== null && $year < 1970) {
        throw new InvalidArgumentException("Année invalide.");
    }
    date_default_timezone_set('Europe/Paris');
    $currentDate = new DateTime();
    if ($weekNumber === null) {
        $weekNumber = $currentDate->format('W');
    }
    if ($year === null) {
        $year = $currentDate->format('Y');
    }
    $firstDayOfYear = new DateTime();
    $firstDayOfYear->setDate($year, 1, 1);
    while ($firstDayOfYear->format('N') !== '1') {
        $firstDayOfYear->modify('+1 day');
    }
    $firstDayOfYear->modify('+' . ($weekNumber - 1) . ' weeks');
    $days = array();
    $days[] = $firstDayOfYear->format('d/m/Y');
    for ($i = 1; $i <= 6; $i++) {
        $nextDay = clone $firstDayOfYear;
        $nextDay->modify('+' . $i . ' days');
        $days[] = $nextDay->format('d/m/Y');
    }
    return $days;
}

$weekNumber = $_GET['week'];
$year = $_GET['year'];
$isWeekDisabled = $weekNumber < $currentWeek;
try {
    $daysOfWeek = getWeekDaysFromMondayToSunday($weekNumber, $year);
    $html = '';
    foreach ($daysOfWeek as $day) {
        $daydate = DateTime::createFromFormat('d/m/Y', $day);
        $daydate->modify('+1 day');
        $isDayPast = $daydate < $currentDate;
        // Vérifier si le jour est égal à la date actuelle (comparer sans l'heure)
        $isDayCurrent = $daydate->format('d/m/Y') === $currentDate->format('d/m/Y');
        // Ajouter la condition pour ajouter l'attribut disabled au bouton si nécessaire
        $disabledAttribute = $isDayPast ? 'disabled' : '';
        $disabledClass = $isDayPast ? 'calendar__container_bloc_disabled' : '';
        $disabledAttribute .= $isDayCurrent ? '' : '';
        // Ajouter la condition pour vérifier si c'est le jour actuel, dans ce cas, ne pas désactiver le bouton
        $date = DateTime::createFromFormat('d/m/Y', $day);
        $jours_en_anglais = array('Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun');
        $jours_en_francais = array('Lundi', 'Mardi', 'Mercredi', 'Jeudi', 'Vendredi', 'Samedi', 'Dimanche');
        $mois_en_anglais = array('Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec');
        $mois_en_francais = array('janvier', 'février', 'mars', 'avril', 'mai', 'juin', 'juillet', 'août', 'septembre', 'octobre', 'novembre', 'décembre');
        $date = DateTime::createFromFormat('d/m/Y', $day);
        $jour_en_francais = $jours_en_francais[(int)$date->format('N') - 1];
        $mois_en_francais = str_replace($mois_en_anglais, $mois_en_francais, $date->format('M'));
        $formattedDate = $jour_en_francais . ', ' . $date->format('d') . ' ' . $mois_en_francais . ' ' . $date->format('Y');
        $html .= '<div class="calendar__container_bloc_date">';
        $html .= '<button class="calendar__container_bloc_button '.$disabledClass.'" ' . $disabledAttribute . '>' . $formattedDate . '</button>';
        $html .= '</div>';
    }
    echo $html;
} catch (InvalidArgumentException $e) {
    echo "Erreur : " . $e->getMessage();
}
