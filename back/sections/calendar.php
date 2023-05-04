<?php
if (isset($_SESSION["id_users"])) {
    $connexion = connexion();
    $title = "Gestion du Calendrier";
    $form = "forms/formCalendar.php";
    $action = "calendar";

    $allMonths = [
        '0' => 'Choisir un mois',
        '01' => 'Janvier',
        '02' => 'Février',
        '03' => 'Mars',
        '04' => 'Avril',
        '05' => 'Mai',
        '06' => 'Juin',
        '07' => 'Juillet',
        '08' => 'Août',
        '09' => 'Septembre',
        '10' => 'Octobre',
        '11' => 'Novembre',
        '12' => 'Décembre',
    ];

    $allYears = ['Choisir une année', '2023', '2024', '2025', '2026', '2027', '2028', '2029', '2030'];

    if (isset($_POST['months']) && ($_POST['years'])) {
        setlocale(LC_TIME, 'fr_FR.utf8');
        $month = $_POST['months'];
        $year = $_POST['years'];
        // Calculer le nombre de jours dans le mois
        $num_days = cal_days_in_month(CAL_GREGORIAN, $month, $year);

        // Obtenir le premier jour du mois
        $first_day_of_week = date('N', strtotime("$year-$month-01"));

        $scheduleCalendar = "<section>";
        $scheduleCalendar .= "<table class='formCalendar'>";
        $scheduleCalendar .= "<thead><tr>";
        for ($day = 1; $day <= 7; $day++) {
            $scheduleCalendar .= "<th>" . date('D', strtotime("Sunday +{$day} days")) . "</th>";
        }
        $scheduleCalendar .= "</tr></thead>";

        $scheduleCalendar .= "<tbody>";
        $day_counter = 1;
        $num_weeks = ceil(($num_days + $first_day_of_week - 1) / 7);
        $day_of_week_counter = 1;
        $scheduleCalendar .= "<tr style='height: 60px;'>";
        // Gérer les jours manquants de la semaine précédente
        for ($i = 1; $i < $first_day_of_week; $i++) {
            $scheduleCalendar .= "<td></td>";
            $day_of_week_counter++;
        }
        // Afficher les jours du mois
        for ($day = 1; $day <= $num_days; $day++) {

            $scheduleCalendar .= "<td style='width: 60px; height=60px; text-align: center'><a href='back.php?action=calendar'>{$day}</a></td>";
            if ($day_of_week_counter % 7 == 0) {
                $scheduleCalendar .= "</tr><tr style='height: 60px;'>";
            }
            $day_of_week_counter++;
        }
        // Gérer les jours manquants de la semaine suivante
        for ($i = $day_of_week_counter; $i <= 7; $i++) {
            $scheduleCalendar .= "<td></td>";
        }
        $scheduleCalendar .= "</tr>";
        $scheduleCalendar .= "</tbody></table>";

            $content = "<div class='enterSchedules'>";
            $content .= "<p>dskjfbsdkjf</p>";
            $content .= "<p>qskdbqskjbd</p>";
            $content .= "<p>qskdbqskjbd</p></div>";
        }

    
}








