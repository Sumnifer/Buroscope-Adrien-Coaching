<?php
$content = '
<style>
    table {
        color: black;
        border-collapse: collapse;
    }
    th, td {
        border: 1px solid black;
        padding: 8px;
    }
</style>

<h2 id="weekNumber"></h2>
<table id="calendar">
    <tr>
        <th><button id="prevWeek">&lt;</button></th>
        <th colspan="5">Semaine : <span id="currentWeekNumber"></span></th>
        <th><button id="nextWeek">&gt;</button></th>
    </tr>
    <tr>
        <th>Lundi</th>
        <th>Mardi</th>
        <th>Mercredi</th>
        <th>Jeudi</th>
        <th>Vendredi</th>
        <th>Samedi</th>
        <th>Dimanche</th>
    </tr>
</table>';
?>
<script>
    // Fonction pour obtenir le numéro de la semaine à partir d'une date donnée
    Date.prototype.getWeek = function() {
        var onejan = new Date(this.getFullYear(), 0, 1);
        return Math.ceil((((this - onejan) / 86400000) + onejan.getDay() + 1) / 7);
    };

    // Fonction pour mettre à jour le calendrier avec la semaine donnée
    function updateCalendar(week) {
        // Obtenir la date de début de la semaine
        var startDate = new Date();
        startDate.setDate(startDate.getDate() + (week - startDate.getDay()) - 1);

        // Mettre à jour le numéro de semaine affiché
        document.getElementById("currentWeekNumber").innerHTML = week;

        // Mettre à jour les dates du calendrier
        var table = document.getElementById("calendar");
        var row = table.insertRow(2); // Insérer une nouvelle ligne
        for (var i = 0; i < 7; i++) {
            var cell = row.insertCell(i);
            var currentDate = new Date(startDate);
            currentDate.setDate(currentDate.getDate() + i);
            cell.innerHTML = currentDate.getDate();
        }
    }

    // Gérer le clic sur la flèche précédente
    document.getElementById("prevWeek").addEventListener("click", function() {
        var currentWeek = parseInt(document.getElementById("currentWeekNumber").innerText);
        updateCalendar(currentWeek - 1);
    });

    // Gérer le clic sur la flèche suivante
    document.getElementById("nextWeek").addEventListener("click", function() {
        var currentWeek = parseInt(document.getElementById("currentWeekNumber").innerText);
        updateCalendar(currentWeek + 1);
    });

    // Charger le calendrier avec la semaine actuelle au chargement de la page
    var currentDate = new Date();
    var currentWeek = currentDate.getWeek();
    document.getElementById("weekNumber").innerHTML = "Semaine : " + currentWeek;
    updateCalendar(currentWeek);
</script>
</body>
</html>
