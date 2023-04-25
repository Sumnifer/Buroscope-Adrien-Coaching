<?php
if (isset($_SESSION["id_users"])) {
    $title = "Gestion des Utilisateurs";
    $form = "forms/formUsers.php";
    $action_form = "newUsers";
    $connexion = connexion();

    if (isset($_GET["case"])) {
        switch ($_GET["case"]) {
            case "newUsers":
                $requiredFields = [
                    "email_users" => "Veuillez entrer une adresse mail valide",
                    "pass_users" => "Veuillez entrer un mot de passe valide",
                    "gender_users" => "Veuillez sélectionner une civilité",
                    "name_users" => "Veuillez entrer un prénom valide",
                    "surname_users" => "Veuillez entrer un nom valide",
                    "phone_users" => "Veuillez entrer un téléphone valide",
                    "date_users" =>
                        "Veuillez entrer une date de naissance valide",
                    "statut_users" => "Veuillez sélectionner un statut",
                ];

                $confirmation = "";
                foreach ($requiredFields as $field => $message) {
                    if (empty($_POST[$field])) {
                        $confirmation = "<p class='warning confirmation'><i class='fa-solid fa-circle-exclamation warning_icon mr-1'></i>$message</p>";
                        break;
                    }
                }

                if (empty($confirmation)) {
                    // Vérification si l'adresse email existe déjà dans la base de données
                    $email = htmlspecialchars(
                        $_POST["email_users"],
                        ENT_QUOTES,
                        "UTF-8"
                    );
                    $query = "SELECT id_users FROM users WHERE email_users = '$email'";
                    $result = mysqli_query($connexion, $query);

                    if (mysqli_num_rows($result) > 0) {
                        $confirmation =
                            "<p class='warning confirmation'><i class='fa-solid fa-circle-exclamation warning_icon mr-1'></i>Cette adresse e-mail existe déjà dans la base de données.</p>";
                    } else {
                        $surname = htmlspecialchars(
                            $_POST["surname_users"],
                            ENT_QUOTES,
                            "UTF-8"
                        );
                        $name = htmlspecialchars(
                            $_POST["name_users"],
                            ENT_QUOTES,
                            "UTF-8"
                        );
                        $gender = $_POST["gender_users"];
                        $phone = preg_replace(
                            "/[^0-9]/",
                            "",
                            $_POST["phone_users"]
                        );
                        $date = strtotime(
                            str_replace("/", "-", $_POST["date_users"])
                        );
                        if (!$date) {
                            $confirmation =
                                "<p class='warning confirmation'><i class='fa-solid fa-circle-exclamation warning_icon mr-1'></i>Veuillez entrer une date de naissance valide</p>";
                        } else {
                            $date = date("Y-m-d", $date);
                        }
                        $pass = password_hash(
                            htmlspecialchars(
                                $_POST["pass_users"],
                                ENT_QUOTES,
                                "UTF-8"
                            ),
                            PASSWORD_DEFAULT
                        );
                        $statut = htmlspecialchars(
                            $_POST["statut_users"],
                            ENT_QUOTES,
                            "UTF-8"
                        );
                        $stmt = $connexion->prepare(
                            "INSERT INTO users (email_users, surname_users, name_users, gender_users, phone_users, date_users, pass_users, statut_users) VALUES(?, ?, ?, ?, ?, ?, ?, ?)"
                        );
                        $stmt->bind_param(
                            "ssssssss",
                            $email,
                            $surname,
                            $name,
                            $gender,
                            $phone,
                            $date,
                            $pass,
                            $statut
                        );

                        if ($stmt->execute()) {
                            $confirmation =
                                "<p class='success confirmation'><i class='fa-solid fa-circle-check success_icon'></i>L'utilisateur a été ajouté avec succès !</p>";
                            //                        header("Location: back.php?action=users");
                            foreach ($_POST as $cle => $valeur) {
                                unset($_POST[$cle]);
                            }
                        } else {
                            $confirmation =
                                "<p class=\"warning confirmation\"><i class='fa-solid fa-circle-exclamation warning_icon mr-1'></i>Une erreur est survenue</p>";
                        }
                    }
                }
                break;

            case "loadUsers":
                if (isset($_GET["id_users"])) {
                    $action_form = "modifyUsers&id_users=" . $_GET["id_users"];
                    $request =
                        "SELECT * FROM users WHERE id_users= '" .
                        $_GET["id_users"] .
                        "'";
                    $result = mysqli_query($connexion, $request);
                    $rows = mysqli_fetch_object($result);
                    $_POST["email_users"] = $rows->email_users;
                    $_POST["surname_users"] = $rows->surname_users;
                    $_POST["name_users"] = $rows->name_users;
                    $_POST["phone_users"] = $rows->phone_users;
                    $_POST["statut_users"] = $rows->statut_users;
                    $_POST["gender_users"] = $rows->gender_users;
                    $date = date("Y-m-d", strtotime($rows->date_users));
                    $_POST["date_users"] = $date;
                }
                break;

            case "modifyUsers":
                if (isset($_GET["id_users"])) {
                    $phone = $_POST["phone_users"];
                    // Valider le numéro de téléphone
                    if (!preg_match('/^[0-9]+$/', $phone)) {
                        $confirmation =
                            "<p class='warning confirmation'><i class='fa-solid fa-circle-exclamation warning_icon'></i>Numéro de téléphone invalide</p>";
                        break;
                    }
                    $request =
                        "UPDATE users SET 
                surname_users='" .
                        $_POST["surname_users"] .
                        "',
                name_users='" .
                        $_POST["name_users"] .
                        "',
                phone_users='" .
                        $phone .
                        "',
                email_users='" .
                        $_POST["email_users"] .
                        "',
                statut_users='" .
                        $_POST["statut_users"] .
                        "',
                date_users='" .
                        $_POST["date_users"] .
                        "',
                gender_users='" .
                        $_POST["gender_users"] .
                        "'";

                    if (!empty($_POST["pass_users"])) {
                        $request .=
                            ", pass_users ='" .
                            password_hash(
                                htmlspecialchars(
                                    $_POST["pass_users"],
                                    ENT_QUOTES,
                                    "UTF-8"
                                ),
                                PASSWORD_DEFAULT
                            ) .
                            "'";
                    }

                    $request .= " WHERE id_users='" . $_GET["id_users"] . "'";

                    $result = mysqli_query($connexion, $request);

                    if ($result) {
                        $confirmation =
                            "<p class=\"success confirmation\"><i class='fa-solid fa-circle-check success_icon'></i>Le compte a bien été mis à jour</p>";
                    } else {
                        $confirmation =
                            "<p class=\"warning confirmation\"><i class='fa-solid fa-circle-exclamation warning_icon'></i>Une erreur est survenue lors de la mise à jour</p>";
                    }
                }

                break;

            case "warningUsers":
                if (isset($_GET["id_users"])) {
                    $confirmation = "<div class=\"confirm \">";
                    $confirmation .=
                        "<p class=\"confirm__paragraph\"><i class='fa-solid fa-triangle-exclamation warning_icon'></i>Êtes-vous sûr de vouloir supprimer l'utilisateur n°" .
                        $_GET["id_users"] .
                        "</p>";
                    $confirmation .=
                        "<a class=\"confirm__paragraph_link \" href=\"back.php?action=users&case=deleteUsers&id_users=" .
                        $_GET["id_users"] .
                        "\">OUI<i class=\"fa-light fa-check confirm__paragraph_link_icons\"></i></a>";
                    $confirmation .=
                        "<a class=\"confirm__paragraph_link \" href=\"back.php?action=users\">NON<i class=\"fa-light fa-xmark confirm__paragraph_link_icons\"></i></a></div>";
                }
                break;

            case "deleteUsers":
                if (isset($_GET["id_users"])) {
                    $request = "SELECT COUNT(*) AS row FROM users";
                    $result = mysqli_query($connexion, $request);
                    $rows = mysqli_fetch_object($result);
                    if ($rows->row == 1) {
                        $confirmation =
                            "<p class=\"warning confirmation\"><i class=\"fa-solid fa-circle-exclamation warning_icon\"></i>Le dernier compte ne peut pas être supprimé !</p>";
                    } else {
                        $request =
                            "DELETE FROM users WHERE id_users='" .
                            $_GET["id_users"] .
                            "'";
                        $result = mysqli_query($connexion, $request);
                        $confirmation =
                            "<p class='success confirmation'><i class='fa-solid fa-circle-check success_icon'></i>L'utilisateur a bien été supprimé</p>";
                    }
                }
                break;
                case "searchUsers":
                    if (isset($_POST["formUsersSearch"])) {
                        $searchResult = $_POST["formUsersSearch"];
                    }
                    break;
        }
    }

    // Affichage des utilisateurs

    if ($_SESSION["statut_users"] != "root") {
        $request =
            "SELECT * FROM users WHERE statut_users != 'root' ORDER BY id_users";
    }
    //if (

       // $_GET["case"] == "searchUsers"
    //) {
      //  $request = "SELECT * FROM users WHERE name_users LIKE '%$searchResult%' ORDER BY id_users";
    //}
else {
        $request = "SELECT * FROM users ORDER BY id_users";
    }

    $result = mysqli_query($connexion, $request);
    $content = "<details class=\"content__details\">";
    $content .= "<summary class=\"content__details_summary\">";
    $content .= "<div>ID</div>";
    $content .= "<div>EMAIL</div>";
    $content .= "<div>STATUT</div>";
    $content .= "<div>ACTION</div>";
    $content .= "</summary></details>";
    while ($rows = mysqli_fetch_object($result)) {
        $content .= "<details class=\"content__details\">";
        $content .= "<summary class=\"content__details_summary\">";
        $content .= "<div class=\"content__details_summary_items\">$rows->id_users</div>";
        $content .= "<div class=\"content__details_summary_items\">$rows->email_users</div>";
        $content .= "<div class=\"content__details_summary_items\">$rows->statut_users</div>";
        $content .=
            "<div class='content__details_summary_actions'><a class='modify content__details_summary_actions_link-modify' href='back.php?action=users&case=loadUsers&id_users=" .
            $rows->id_users .
            "' >
                      <i class='fa-solid fa-pen-to-square content__details_summary_actions_link_icon-modify'></i></a>";
        $content .=
            "<a class='content__details_summary_actions_link-trash' href='back.php?action=users&case=warningUsers&id_users=" .
            $rows->id_users .
            "'>
                      <i class='fa-solid fa-trash content__details_summary_actions_link_icon-trash'></i></a>";
        $content .= "</summary></details>";
    }
}