<?php
$connexion = connexion();

if (isset($_POST["submit"])) {
    $requiredFields = [
        "email_users" => "Veuillez entrer une adresse mail valide",
        "pass_users" => "Veuillez entrer un mot de passe valide",
        "gender_users" => "Veuillez sélectionner une civilité",
        "name_users" => "Veuillez entrer un prénom valide",
        "surname_users" => "Veuillez entrer un nom valide",
        "phone_users" => "Veuillez entrer un téléphone valide",
        "date_users" => "Veuillez entrer une date de naissance valide",
    ];

    $confirmation = "";
    foreach ($requiredFields as $field => $message) {
        if (empty($_POST[$field])) {
            $confirmation = "<p class='warning'><i class='fa-solid fa-triangle-exclamation warning_icon mr-1'></i>$message</p>";
            break;
        }
    }
    if (empty($confirmation)) {
        $email = htmlspecialchars($_POST["email_users"], ENT_QUOTES, "UTF-8");
        $query = "SELECT id_users FROM users WHERE email_users = '$email'";
        $result = mysqli_query($connexion, $query);

        if(mysqli_num_rows($result) > 0){
            $confirmation = "<p class='warning'><i class='fa-solid fa-triangle-exclamation warning_icon mr-1'></i>Cette adresse e-mail est déjà utilisée.</p>";
        } else {
            $genre = $_POST["gender_users"];
            $surname = htmlspecialchars($_POST["surname_users"], ENT_QUOTES, "UTF-8");
            $name = htmlspecialchars($_POST["name_users"], ENT_QUOTES, "UTF-8");
            $phone = preg_replace("/[^0-9]/", "", $_POST["phone_users"]);
            $date = strtotime(str_replace("/", "-", $_POST['date_users']));
            if (!$date) {
                $confirmation = "<p class=\"warning\"><i class=\"fa-solid fa-triangle-exclamation warning_icon mr-1\"></i>Veuillez entrer une date de naissance valide</p>";
            } else {
                $date = date("Y-m-d", $date);
            }
            $pass = password_hash(
                htmlspecialchars($_POST["pass_users"], ENT_QUOTES, "UTF-8"),
                PASSWORD_DEFAULT
            );
            $statut = "user";

            $stmt = $connexion->prepare(
                "INSERT INTO users (email_users, surname_users, gender_users, phone_users, name_users, date_users, pass_users, statut_users  ) VALUES (?, ?, ?, ?, ?, ?, ?, ?)"
            );
            $stmt->bind_param(
                "ssssssss",
                $email,
                $surname,
                $genre,
                $phone,
                $name,
                $date,
                $pass,
                $statut

            );


            if ($stmt->execute()) {
                header("Location: front.php?action=formSante");
                $confirmation =
                    "<p class=\"success\"><i class=\"fa-solid fa-circle-check success_icon\"></i>Bienvenue parmi nous ! Vous pouvez désormais vous connecter.</p>";
                foreach ($_POST as $cle => $valeur) {
                    unset($_POST[$cle]);
                }
            } else {
                $confirmation =
                    "<p class=\"warning\"><i class=\"fa-solid fa-triangle-exclamation warning_icon mr-1\"></i>Une erreur est suvenue</p>";
            }
        }
    }
}
mysqli_close($connexion);
?>


<div class="inscription_body">
<div class="inscription_body_container">
    <img src="../assets/img/image1.png" alt="" class="inscription_body_container_img" />
    <img src="../assets/img/image2.png" alt="" class="inscription_body_container_img" />
    <img src="../assets/img/image3.png" alt="" class="inscription_body_container_img" />
</div>

<section class="connexion">
    <h1 class="connexion__title">Créer votre <span class="connexion__title_span">compte</span></h1>
    <p class="connexion__paragraph">
        Vous avez déjà un compte ?
        <a href="front.php?action=logging" class="connexion__paragraph_link">Connectez-vous.</a>
    </p>
</section>

<section class="inscription">
    <section class="message">
        <?php if (isset($confirmation)) {
            echo $confirmation;
        } ?>
    </section>

    <h2 class="inscription__title">Mes informations de connexion :</h2>
    <form action="front.php?action=inscription" method="post" class="inscription__form">
        <div class="inscription__form_item">
            <label for="email_users" class="inscription__form_item_label">Email</label>
            <input type="email" name="email_users" id="email_users" placeholder="Email"
                   class="inscription__form_item_input" />
        </div>
        <div class="inscription__form_item">
            <label for="pass_users" class="inscription__form_item_label">Mot de passe</label>
            <input type="password" name="pass_users" id="pass_users" placeholder="Mot de Passe"
                   class="inscription__form_item_input" />
        </div>
        <p class="inscription__form_paragraph">
            Votre mot de passe doit contenir :
        </p>
        <div class="inscription__form_required">
            <p class="inscription__form_required_paragraph">
                <i class="fa-classic fa-solid fa-circle-xmark"></i> Entre 8 et 16
                caractères
            </p>
            <p class="inscription__form_required_paragraph">
                <i class="fa-classic fa-solid fa-circle-xmark"></i> Au moins une
                majuscule
            </p>
            <p class="inscription__form_required_paragraph">
                <i class="fa-classic fa-solid fa-circle-xmark"></i> Au moins une
                minuscule
            </p>
            <p class="inscription__form_required_paragraph">
                <i class="fa-classic fa-solid fa-circle-xmark"></i> Au moins un
                chiffre
            </p>
        </div>
        <h2 class="inscription__form_title">Mes informations personnelles :</h2>
        <label for="gender_users" class="inscription__form_label">Civilité</label>
        <select class="inscription__form_input" name="gender_users" id="gender_users">
            <option value="" class="inscription__form_input_options">Sélectionnez une civilité</option>
            <option value="Monsieur" class="inscription__form_input_options">Monsieur</option>
            <option value="Madame" class="inscription__form_input_options">Madame</option>
            <option value="Autre" class="inscription__form_input_options">Autre</option>
        </select>
        <div class="inscription__form_item">
            <label for="name_users" class="inscription__form_item_label">Prénom</label>
            <input type="text" name="name_users" id="name_users" placeholder="Prénom"
                   class="inscription__form_item_input" />

            <label for="surname_users" class="inscription__form_item_label">Nom de famille</label>
            <input type="text" name="surname_users" id="surname_users" placeholder="Nom de famille"
                   class="inscription__form_item_input" />
        </div>
        <label for="phone_users" class="inscription__form_label">Téléphone</label>
        <input type="number" name="phone_users" id="phone_users" placeholder="Téléphone"
               class="inscription__form_input" />
        <div class="inscription__form_item">
            <label for="date_users" class="inscription__form_item_label_date">Date de Naissance</label>
            <input class="inscription__form_item_input" type="date" name="date_users" id="date_users" placeholder="Date de naissance">
        </div>
        <button type="submit" name="submit" class="inscription__form_cta">
            Continuer
        </button>
    </form>
</section>
    </div>
