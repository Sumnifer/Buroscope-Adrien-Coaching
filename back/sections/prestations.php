<?php
if (isset($_SESSION["id_users"])) {
    $connexion = connexion();
    mysqli_set_charset($connexion, "utf8");
    $title = "Gestion des Prestations";
    $form = "forms/formPrestations.php";



    if (isset($_GET["case"])) {

        switch ($_GET["case"]) {
            case "newPrestations":
                $action_form = "newPrestations";
                $request =
                    "SELECT COUNT(*) AS nb_prestations FROM prestations";
                $result = mysqli_query($connexion, $request);
                $rows = mysqli_fetch_object($result);
                if (empty($_POST["title_prestations"])) {
                    $confirmation =
                        "<p class='warning confirmation'><i class='fa-solid fa-circle-exclamation warning_icon'></i> Veuillez entrer un titre </p>";
                }
                elseif (empty($_POST["content_prestations"])) {
                    $confirmation =
                        "<p class='warning confirmation'><i class='fa-solid fa-circle-exclamation warning_icon'></i> Veuillez entrer du contenu </p>";
                }
                elseif (empty($_POST["alt_prestations"])) {
                    $confirmation =
                        "<p class='warning confirmation'><i class='fa-solid fa-circle-exclamation warning_icon'></i> Veuillez entrer un alt </p>";
                }
                elseif (empty($_POST["visibility_prestations"])) {
                    $confirmation =
                        "<p class='warning confirmation'><i class='fa-solid fa-circle-exclamation warning_icon'></i> Veuillez choisir une visibilité </p>";
                }elseif (empty($_POST["price_prestations"])) {
                    $confirmation =
                        "<p class='warning confirmation'><i class='fa-solid fa-circle-exclamation warning_icon'></i> Veuillez choisir une visibilité </p>";
                } else {
                    $request =
                        "INSERT INTO prestations SET 
                      title_prestations='" .
                        $_POST["title_prestations"] .
                        "',
                      content_prestations='" .
                        $_POST["content_prestations"] .
                        "',
                        alt_prestations='" .
                        $_POST["alt_prestations"] .
                        "',
                        rank_prestations=($rows->nb_prestations + 1),
                        visibility_prestations='" .
                        $_POST["visibility_prestations"] .
                        "',
                        price_prestations='" .
                        $_POST["price_prestations"] .
                        "'";
                    $result = mysqli_query($connexion, $request);
                    $last_Id = mysqli_insert_id($connexion);

                    if (
                        !empty($_FILES["img_prestations"]) &&
                        $_FILES["img_prestations"]["error"] == 0
                    ) {
                        $file_name = $_FILES["img_prestations"]["name"];
                        $file_extension = pathinfo(
                            $file_name,
                            PATHINFO_EXTENSION
                        );
                        $new_file_name =
                            "prestation_" . $last_Id . "." . $file_extension;
                        $file_path = "../medias/" . $new_file_name;

                        if (
                            move_uploaded_file(
                                $_FILES["img_prestations"]["tmp_name"],
                                $file_path
                            )
                        ) {
                            $request2 =
                                "UPDATE prestations SET img_prestations='" .
                                $file_path .
                                "' WHERE id_prestations='" .
                                $last_Id .
                                "'";
                            $result2 = mysqli_query($connexion, $request2);
                        }
                    }

                    $confirmation =
                        "<p class='success confirmation'><i class='fa-solid fa-circle-check success_icon'></i> La presentation a bien été crée </p>";
                    foreach ($_POST as $cle => $valeur) {
                        unset($_POST[$cle]);
                    }
                }
                break;

            case "loadPrestations":
                if (isset($_GET["id_prestations"])) {
                    $action_form =
                        "modifyPrestations&id_prestations=" .
                        $_GET["id_prestations"];
                    $request =
                        "SELECT * FROM prestations WHERE id_prestations='" .
                        $_GET["id_prestations"] .
                        "'";
                    $result = mysqli_query($connexion, $request);
                    $rows = mysqli_fetch_object($result);
                    $_POST["title_prestations"] = $rows->title_prestations;
                    $_POST["content_prestations"] =
                        $rows->content_prestations;
                    $_POST["alt_prestations"] = $rows->alt_prestations;
                    $_POST['price_prestations'] = $rows->price_prestations;
                    $visibility = $rows->visibility_prestations;
                }
                break;

            case "modifyPrestations":
                $action_form =
                    "modifyPrestations&id_prestations=" .
                    $_GET["id_prestations"];
                $id_prestations = $_GET["id_prestations"];
                $title_prestations = $_POST["title_prestations"];
                $content_prestations = $_POST["content_prestations"];
                $alt_prestations = $_POST["alt_prestations"];
                $price_prestations = $_POST["price_prestations"];
                $visibility_prestations = $_POST["visibility_prestations"];

                $error = "";

                if (empty($title_prestations)) {
                    $error .=
                        "<p class='warning confirmation'><i class='fa-solid fa-circle-exclamation error_icon'></i> Veuillez renseigner le titre</p>";
                }
                if (empty($content_prestations)) {
                    $error .=
                        "<p class='warning confirmation'><i class='fa-solid fa-circle-exclamation error_icon'></i> Veuillez renseigner le contenu</p>";
                }
                if (empty($alt_prestations)) {
                    $error .=
                        "<p class='warning confirmation'><i class='fa-solid fa-circle-exclamation error_icon'></i> Veuillez renseigner la description alternative</p>";
                }
                if (empty($price_prestations)) {
                    $error .=
                        "<p class='warning confirmation'><i class='fa-solid fa-circle-exclamation error_icon'></i> Veuillez renseigner la direction</p>";
                }
                if (empty($visibility_prestations)) {
                    $error .=
                        "<p class='warning confirmation'><i class='fa-solid fa-circle-exclamation error_icon'></i> Veuillez renseigner la visibilité</p>";
                }


                if (empty($error)) {
                    $request = "UPDATE prestations SET 
                    title_prestations='$title_prestations',
                    content_prestations='$content_prestations',
                    alt_prestations='$alt_prestations',
                    price_prestations='$price_prestations',
                    visibility_prestations='$visibility_prestations'
                    WHERE id_prestations='$id_prestations'";
                    $result = mysqli_query($connexion, $request);

                    if (
                        isset($_FILES["img_prestations"]) &&
                        $_FILES["img_prestations"]["error"] == 0
                    ) {
                        $request_img =
                            "SELECT img_prestations FROM prestations WHERE id_prestations='" .
                            $_GET["id_prestations"] .
                            "'";
                        $result_img = mysqli_query($connexion, $request_img);
                        $img_path = mysqli_fetch_object($result_img)
                            ->img_prestations;

                        if (file_exists($img_path)) {
                            unlink($img_path);
                        }
                        $file_name = $_FILES["img_prestations"]["name"];
                        $file_extension = pathinfo(
                            $file_name,
                            PATHINFO_EXTENSION
                        );
                        $new_file_name =
                            "prestation_" .
                            $_GET["id_prestations"] .
                            "." .
                            $file_extension;
                        $file_path = "../medias/" . $new_file_name;

                        if (
                            move_uploaded_file(
                                $_FILES["img_prestations"]["tmp_name"],
                                $file_path
                            )
                        ) {
                            $request2 =
                                "UPDATE prestations SET img_prestations='" .
                                $file_path .
                                "' WHERE id_prestations='" .
                                $_GET["id_prestations"] .
                                "'";
                            $result2 = mysqli_query($connexion, $request2);
                        }
                    }
                    $confirmation =
                        "<p class='success confirmation'><i class='fa-solid fa-circle-check success_icon'></i> La présentation a bien été modifiée </p>";
                } else {
                    $confirmation = $error;
                }
                foreach ($_POST as $cle => $valeur) {
                    unset($_POST[$cle]);
                }
                break;

            case "visibilityPrestations":
                if (isset($_GET["id_prestations"])) {
                    if (isset($_GET["visibility"])) {
                        $requete =
                            "UPDATE prestations SET visibility_prestations='" .
                            $_GET["visibility"] .
                            "' WHERE id_prestations='" .
                            $_GET["id_prestations"] .
                            "'";
                        $resultat = mysqli_query($connexion, $requete);
                        if($_GET['visibility']==1){
                            $confirmation =
                                "<p class='success confirmation'><i class='fa-solid fa-circle-check success_icon'></i> La prestation est désormais visible </p>";
                        }
                        if($_GET['visibility']==2){
                            $confirmation =
                                "<p class='success confirmation'><i class='fa-solid fa-circle-check success_icon'></i> La prestation est désormais invisible </p>";
                        }
                    }
                }

                break;

            case "warningPrestations":
                if (isset($_GET["id_prestations"])) {
                    $confirmation = "<div class='confirm'>";
                    $confirmation .=
                        "<p class='confirm__paragraph'><i class='fa-solid fa-triangle-exclamation warning_icon'></i>Êtes vous sûr de vouloir supprimer la presentation n°" .
                        $_GET["id_prestations"] .
                        "</p>";
                    $confirmation .=
                        "<a class='confirm__paragraph_link' href='back.php?action=prestations&case=deletePrestations&id_prestations=" .
                        $_GET["id_prestations"] .
                        "'>OUI <i class='fa-light fa-check confirm__paragraph_link_icons'></i></a>";
                    $confirmation .=
                        "<a class='confirm__paragraph_link' href='back.php?action=prestations'>NON <i class='fa-light fa-xmark confirm__paragraph_link_icons'></i></a></div>";
                }
                break;

            case "deletePrestations":
                if (isset($_GET["id_prestations"])) {
                    // Récupérer le chemin du fichier image à supprimer
                    $request_img =
                        "SELECT img_prestations FROM prestations WHERE id_prestations='" .
                        $_GET["id_prestations"] .
                        "'";
                    $result_img = mysqli_query($connexion, $request_img);
                    $img_path = mysqli_fetch_object($result_img)
                        ->img_prestations;

                    if (file_exists($img_path)) {
                        unlink($img_path);
                    }

                    $request4 =
                        "DELETE FROM prestations WHERE id_prestations='" .
                        $_GET["id_prestations"] .
                        "'";
                    $result4 = mysqli_query($connexion, $request4);
                    $confirmation =
                        "<p class='success confirmation'><i class='fa-solid fa-circle-check success_icon'></i> La présentation a bien été supprimée </p>";

                    $request2 =
                        "SELECT * FROM prestations ORDER BY rank_prestations";
                    $result2 = mysqli_query($connexion, $request2);
                    $i = 1;
                    while ($rows2 = mysqli_fetch_object($result2)) {
                        $request3 =
                            "UPDATE prestations SET rank_prestations='" .
                            $i .
                            "' WHERE id_prestations='" .
                            $rows2->id_prestations .
                            "'";
                        $result3 = mysqli_query($connexion, $request3);
                        $i++;
                    }
                }
                break;

            case "rankPrestations":
                if (isset($_GET["id_prestations"])) {
                    switch ($_GET["direction"]) {
                        case "up":
                            if (isset($_GET["rank"]) && $_GET["rank"] > 1) {
                                $rank = $_GET["rank"] - 1;
                                $requete =
                                    "UPDATE prestations SET rank_prestations='" .
                                    $_GET["rank"] .
                                    "' WHERE rank_prestations='" .
                                    $rank .
                                    "'";
                                $resultat = mysqli_query($connexion, $requete);
                                $requete2 =
                                    "UPDATE prestations SET rank_prestations='" .
                                    $rank .
                                    "' WHERE id_prestations='" .
                                    $_GET["id_prestations"] .
                                    "'";
                                $resultat2 = mysqli_query(
                                    $connexion,
                                    $requete2
                                );
                            }
                            break;

                        case "down":
                            $requete =
                                "SELECT count(*) AS nb_prestations FROM prestations";
                            $resultat = mysqli_query($connexion, $requete);
                            $ligne = mysqli_fetch_object($resultat);
                            if (
                                isset($_GET["rank"]) &&
                                $_GET["rank"] < $ligne->nb_prestations
                            ) {
                                $rank = $_GET["rank"] + 1;
                                $requete =
                                    "UPDATE prestations SET rank_prestations='" .
                                    $_GET["rank"] .
                                    "' WHERE rank_prestations='" .
                                    $rank .
                                    "'";
                                $resultat = mysqli_query($connexion, $requete);
                                $requete2 =
                                    "UPDATE prestations SET rank_prestations='" .
                                    $rank .
                                    "' WHERE id_prestations='" .
                                    $_GET["id_prestations"] .
                                    "'";
                                $resultat2 = mysqli_query(
                                    $connexion,
                                    $requete2
                                );
                            }
                            break;
                    }
                }
                break;
            case "unloadPrestations" :
                $action_form = "newPrestations";
                foreach ($_POST as $cle => $valeur) {
                    unset($_POST[$cle]);
                }
                break;


        }
    }
    $request = "SELECT * FROM prestations ORDER BY rank_prestations";
    $result = mysqli_query($connexion, $request);
    $content = "<details class='content__details'>";
    $content .= "<summary class='content__details_summary'>";
    $content .= "<div>POSITION</div>";
    $content .= "<div>PRESTATION</div>";
    $content .= "<div>IMAGE</div>";
    $content .= "<div>ACTIONS</div>";
    $content .= "</summary></details>";
    while ($rows = mysqli_fetch_object($result)) {
        $content .= "<details class='content__details'>";
        $content .= "<summary class='content__details_summary'>";
        $content .=
            "<div class='content__details_summary_items'>" .
            $rows->rank_prestations .
            "<a class='content__details_summary_actions_arrows' href='back.php?action=prestations&case=rankPrestations&direction=up&id_prestations=" .
            $rows->id_prestations .
            "&rank=" .
            $rows->rank_prestations .
            "'><i class='fa-solid fa-arrow-up '></i></a>" .
            "<a class='content__details_summary_actions_arrows' href='back.php?action=prestations&case=rankPrestations&direction=down&id_prestations=" .
            $rows->id_prestations .
            "&rank=" .
            $rows->rank_prestations .
            "'><i class='fa-solid fa-arrow-down'></i></a></div>";
        $content .= "<div class='content__details_summary_items'>$rows->title_prestations</div>";

        $content .=
            "<div class='content__details_summary_items'><img src='$rows->img_prestations' alt='' class='content__details_summary_items_img''></div>";
        $content .= "<div class='content__details_summary_actions'>";
        if ($rows->visibility_prestations == 1) {
            $content .=
                "<a class='content__details_summary_actions_link-eyes' href='back.php?action=prestations&case=visibilityPrestations&visibility=2&id_prestations=" .
                $rows->id_prestations .
                "' ><i class='fa-solid fa-eye content__details_summary_actions_link_icon-eyes'></i></a>";
        } else {
            $content .=
                "<a class='content__details_summary_actions_link-eyes' href='back.php?action=prestations&case=visibilityPrestations&visibility=1&id_prestations=" .
                $rows->id_prestations .
                "' ><i class='fa-solid fa-eye-slash content__details_summary_actions_link_icon-eyes'></i></a>";
        }
        $content .=
            "<a class='modify content__details_summary_actions_link-modify' href='back.php?action=prestations&case=loadPrestations&id_prestations=" .
            $rows->id_prestations .

            " '><i class='fa-solid fa-pen-to-square content__details_summary_actions_link_icon-modify'></i></a>";
        $content .=
            "<a class='content__details_summary_actions_link-trash' href='back.php?action=prestations&case=warningPrestations&id_prestations=" .
            $rows->id_prestations .
            "'><i class='fa-solid fa-trash content__details_summary_actions_link_icon-trash'></i></a>";
        $content .= "</summary></details>";
    }
}
