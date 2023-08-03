<section class="calendar">
    <div class="calendar__header">
        <button onclick="loadPreviousWeek()" class="calendar__header_cta"><i
                    class="fa-solid fa-chevron-double-left calendar__header_cta_icons"></i></button>
        <h1 class="calendar__header_title">Semaine en cours : </h1>
        <button onclick="loadNextWeek()" class="calendar__header_cta"><i
                    class="fa-solid fa-chevron-double-right calendar__header_cta_icons"></i></button>
    </div>
    <div class="calendar__container">
        <div id="currentWeekDates" style="" class="calendar__container_bloc">
            <!-- Ici seront affichées les dates de la semaine en cours -->
        </div>
        <div class="calendar__container_schedules">
            <form action="#" method="POST" class="calendar__container_schedules_form" name="prestations">
                <select name="prestations" id="" class="calendar__container_schedules_form_select">
                    <?php
                    $request = "SELECT * FROM prestations ORDER BY rank_prestations";
                    $result = mysqli_query($connexion, $request);
                    while ($rows = mysqli_fetch_object($result)) {
                        if (isset($_GET['prestations']) && strtolower($_GET['prestations']) === strtolower($rows->title_prestations)) {
                            echo "<option value='" . $rows->id_prestations . "' selected class='calendar__container_schedules_form_select_options'>Formule " . $rows->title_prestations . "</option>";
                        } else {
                            echo "<option value='" . $rows->id_prestations . "' class='calendar__container_schedules_form_select_options'>Formule " . $rows->title_prestations . "</option>";
                        }
                    }
                    ?>
                </select>
                <div class="calendar__container_schedules_form_bloc">
                </div>
                <button type="button" onclick="makeReservation()" class="calendar__container_schedules_form_submit">Je réserve</button>
            </form>
        </div>
    </div>

</section>

<!------------------------------------------------JAVASCRIPT + AJAX---------------------------------------------------->
<script>

    let currentWeekNumber = <?php echo date('W'); ?>;
    let currentYear = <?php echo date('Y'); ?>;

    function loadCurrentWeek() {
        let xhr = new XMLHttpRequest();
        xhr.onreadystatechange = function () {
            if (xhr.readyState === 4 && xhr.status === 200) {
                document.getElementById("currentWeekDates").innerHTML = xhr.responseText;
                document.querySelector(".calendar__header_title").innerHTML = "Semaine : " + currentWeekNumber;
                addClickEventToDates();
            }
        };
        xhr.open("GET", "sections/getCalendar.php?week=" + currentWeekNumber + "&year=" + currentYear, true);
        xhr.send();
    }

    function loadPreviousWeek() {
        currentWeekNumber--;
        loadCurrentWeek();
    }

    function loadNextWeek() {
        currentWeekNumber++;
        loadCurrentWeek();
    }

    window.onload = function () {
        loadCurrentWeek();
        addClickEventToDates();
    };

    function addClickEventToDates() {
        let dateButtons = document.querySelectorAll(".calendar__container_bloc_button");
        for (let i = 0; i < dateButtons.length; i++) {
            dateButtons[i].addEventListener("click", function () {
                let date = this.textContent;
                loadSchedulesForDate(date);
                updateActiveButton(this);
            });
        }
    }

    function updateActiveButton(clickedButton) {
        let dateButtons = document.querySelectorAll(".calendar__container_bloc_button");
        for (let i = 0; i < dateButtons.length; i++) {
            if (dateButtons[i] === clickedButton) {
                dateButtons[i].classList.add("calendar__container_bloc_button_active");
            } else {
                dateButtons[i].classList.remove("calendar__container_bloc_button_active");
            }
        }
    }

    function loadSchedulesForDate(date) {
        let xhr = new XMLHttpRequest();
        xhr.onreadystatechange = function () {
            if (xhr.readyState === 4 && xhr.status === 200) {
                let schedules = JSON.parse(xhr.responseText);
                let listElement = document.createElement('div');
                listElement.classList.add("calendar__container_schedules_form_div");
                listElement.style.display = "flex";
                listElement.style.flexDirection = "column";
                schedules.forEach(function (schedule) {
                    let listItem = document.createElement('label');
                    listItem.classList.add("calendar__container_schedules_form_div_label");
                    listItem.style.cursor = "pointer";
                    let checkbox = document.createElement('input');
                    checkbox.type = "radio";
                    checkbox.classList.add("calendar__container_schedules_form_div_label_input");
                    checkbox.name = "creneaux";
                    checkbox.value = schedule;
                    checkbox.id = "slot_" + schedule.replace(":", "_"); // Utilisation de l'heure comme ID
                    listItem.appendChild(checkbox);
                    let span = document.createElement('span');
                    span.textContent = schedule;
                    listItem.appendChild(span);
                    checkbox.addEventListener("change", function () {
                        if (this.checked) {
                            let labels = document.querySelectorAll('.calendar__container_schedules_form_div_label');
                            labels.forEach(function (label) {
                                label.classList.remove("calendar__container_schedules_form_div_checked");
                            });
                            listItem.classList.add("calendar__container_schedules_form_div_checked");
                        } else {
                            listItem.classList.remove("calendar__container_schedules_form_div_checked");
                        }
                    });
                    listElement.appendChild(listItem);
                });
                let containerSchedulesElement = document.querySelector('.calendar__container_schedules_form_bloc');
                containerSchedulesElement.innerHTML = '';
                containerSchedulesElement.appendChild(listElement);
            }
        };
        xhr.open("GET", "sections/getSchedules.php?week=" + currentWeekNumber + "&year=" + currentYear + "&date=" + date, true);
        xhr.send();
    }
    function makeReservation() {
        // Récupérer les informations nécessaires
        let selectedDateButton = document.querySelector(".calendar__container_bloc_button_active");
        if (!selectedDateButton) {
            alert("Veuillez sélectionner une date avant de réserver.");
            return;
        }

        let selectedDate = selectedDateButton.textContent;
        let selectedHourInput = document.querySelector("input[name='creneaux']:checked");
        if (!selectedHourInput) {
            alert("Veuillez sélectionner un créneau horaire avant de réserver.");
            return;
        }
        let selectedHour = selectedHourInput.value;

        let selectedPrestationSelect = document.querySelector(".calendar__container_schedules_form_select");
        let selectedPrestation = selectedPrestationSelect.value;

        // Appeler la fonction pour sauvegarder la réservation via une requête AJAX
        saveReservation(selectedDate, selectedHour, selectedPrestation);
    }

    function saveReservation(date, hour, prestation) {
        let xhr = new XMLHttpRequest();
        xhr.onreadystatechange = function () {
            if (xhr.readyState === 4) {
                    let response = JSON.parse(xhr.responseText);
                    if (response.success) {
                        alert(response.message);
                        // Redirection vers la page de calendrier après la réservation réussie
                        window.location.href = "front.php?action=calendar";
                    } else if(response.error){
                        alert("Veuillez vous connecter pour continuer");
                    }else {
                        alert("Une erreur s'est produite lors de la réservation.");
                    }
            }
        };

        // Modifier le chemin vers le fichier saveSchedules.php en fonction de votre structure de fichiers.
        xhr.open("GET", "sections/saveSchedules.php?week=" + currentWeekNumber + "&year=" + currentYear + "&date=" + date + "&hour=" + hour + "&prestation=" + prestation, true);
        xhr.send();
    }
</script>

