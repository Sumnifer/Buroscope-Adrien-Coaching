<?php
if (isset($_SESSION["id_users"])) {
    $connexion = connexion();
    mysqli_set_charset($connexion, "utf8");
    $title = "Gestion des Presentations";
    $form = "forms/formPresentations.php";
    $action_form = "newPresentations";

    if (isset($_GET["case"])) {
        switch ($_GET["case"]) {
            case "newPresentations":
                $request =
                    "SELECT COUNT(*) AS nb_presentations FROM presentations";
                $result = mysqli_query($connexion, $request);
                $rows = mysqli_fetch_object($result);
                if (empty($_POST["title_presentations"])) {
                    $confirmation =
                        "<p class='warning'><i class='fa-solid fa-triangle-exclamation warning_icon'></i> Veuillez entrer un titre </p>";
                }
                if (empty($_POST["content_presentations"])) {
                    $confirmation =
                        "<p class='warning'><i class='fa-solid fa-triangle-exclamation warning_icon'></i> Veuillez entrer du contenu </p>";
                }
                if (empty($_POST["alt_presentations"])) {
                    $confirmation =
                        "<p class='warning'><i class='fa-solid fa-triangle-exclamation warning_icon'></i> Veuillez entrer un alt </p>";
                }
                if (empty($_POST["visibility_presentations"])) {
                    $confirmation =
                        "<p class='warning'><i class='fa-solid fa-triangle-exclamation warning_icon'></i> Veuillez choisir une visibilité </p>";
                } else {
                    $request =
                        "INSERT INTO presentations SET 
                      title_presentations='" .
                        $_POST["title_presentations"] .
                        "',
                      content_presentations='" .
                        $_POST["content_presentations"] .
                        "',
                        alt_presentations='" .
                        $_POST["alt_presentations"] .
                        "',
                        rank_presentations=($rows->nb_presentations + 1),
                        visibility_presentations='" .
                        $_POST["visibility_presentations"] .
                        "',
                        direction_presentations='" .
                        $_POST["direction_presentations"] .
                        "'";
                    $result = mysqli_query($connexion, $request);
                    $last_Id = mysqli_insert_id($connexion);

                    if (
                        isset($_FILES["img_presentations"]) &&
                        $_FILES["img_presentations"]["error"] == 0
                    ) {
                        $file_name = $_FILES["img_presentations"]["name"];
                        $file_extension = pathinfo(
                            $file_name,
                            PATHINFO_EXTENSION
                        );
                        $new_file_name =
                            "image_" . $last_Id . "." . $file_extension;
                        $file_path = "../medias/" . $new_file_name;

                        if (
                            move_uploaded_file(
                                $_FILES["img_presentations"]["tmp_name"],
                                $file_path
                            )
                        ) {
                            $request2 =
                                "UPDATE presentations SET img_presentations='" .
                                $file_path .
                                "' WHERE id_presentations='" .
                                $last_Id .
                                "'";
                            $result2 = mysqli_query($connexion, $request2);
                        }
                    }

                    $confirmation =
                        "<p class='success'><i class='fa-solid fa-circle-check success_icon'></i> La presentation a bien été crée </p>";
                    foreach ($_POST as $cle => $valeur) {
                        unset($_POST[$cle]);
                    }
                }
                break;

            case "loadPresentations":
                if (isset($_GET["id_presentations"])) {
                    $action_form =
                        "modifyPresentations&id_presentations=" .
                        $_GET["id_presentations"];
                    $request =
                        "SELECT * FROM presentations WHERE id_presentations='" .
                        $_GET["id_presentations"] .
                        "'";
                    $result = mysqli_query($connexion, $request);
                    $rows = mysqli_fetch_object($result);
                    $_POST["title_presentations"] = $rows->title_presentations;
                    $_POST["content_presentations"] =
                        $rows->content_presentations;
                    $_POST["alt_presentations"] = $rows->alt_presentations;
                    $direction = $rows->direction_presentations;
                    $visibility = $rows->visibility_presentations;
                }
                break;

            case "modifyPresentations":
                $action_form =
                    "modifyPresentations&id_presentations=" .
                    $_GET["id_presentations"];
                $id_presentations = $_GET["id_presentations"];
                $title_presentations = $_POST["title_presentations"];
                $content_presentations = $_POST["content_presentations"];
                $alt_presentations = $_POST["alt_presentations"];
                $direction_presentations = $_POST["direction_presentations"];
                $visibility_presentations = $_POST["visibility_presentations"];

                $error = "";

                if (empty($title_presentations)) {
                    $error .=
                        "<p class='warning'><i class='fa-solid fa-circle-exclamation error_icon'></i> Veuillez renseigner le titre</p>";
                }
                if (empty($content_presentations)) {
                    $error .=
                        "<p class='warning'><i class='fa-solid fa-circle-exclamation error_icon'></i> Veuillez renseigner le contenu</p>";
                }
                if (empty($alt_presentations)) {
                    $error .=
                        "<p class='warning'><i class='fa-solid fa-circle-exclamation error_icon'></i> Veuillez renseigner la description alternative</p>";
                }
                if (empty($direction_presentations)) {
                    $error .=
                        "<p class='warning'><i class='fa-solid fa-circle-exclamation error_icon'></i> Veuillez renseigner la direction</p>";
                }
                if (empty($visibility_presentations)) {
                    $error .=
                        "<p class='warning'><i class='fa-solid fa-circle-exclamation error_icon'></i> Veuillez renseigner la visibilité</p>";
                }

                if (empty($error)) {
                    $request = "UPDATE presentations SET 
                    title_presentations='$title_presentations',
                    content_presentations='$content_presentations',
                    alt_presentations='$alt_presentations',
                    direction_presentations='$direction_presentations',
                    visibility_presentations='$visibility_presentations'
                    WHERE id_presentations='$id_presentations'";
                    $result = mysqli_query($connexion, $request);

                    if (
                        isset($_FILES["img_presentations"]) &&
                        $_FILES["img_presentations"]["error"] == 0
                    ) {
                        $request_img =
                            "SELECT img_presentations FROM presentations WHERE id_presentations='" .
                            $_GET["id_presentations"] .
                            "'";
                        $result_img = mysqli_query($connexion, $request_img);
                        $img_path = mysqli_fetch_object($result_img)
                            ->img_presentations;

                        if (file_exists($img_path)) {
                            unlink($img_path);
                        }
                        $file_name = $_FILES["img_presentations"]["name"];
                        $file_extension = pathinfo(
                            $file_name,
                            PATHINFO_EXTENSION
                        );
                        $new_file_name =
                            "image_" .
                            $_GET["id_presentations"] .
                            "." .
                            $file_extension;
                        $file_path = "../medias/" . $new_file_name;
                        echo $file_path;

                        if (
                            move_uploaded_file(
                                $_FILES["img_presentations"]["tmp_name"],
                                $file_path
                            )
                        ) {
                            $request2 =
                                "UPDATE presentations SET img_presentations='" .
                                $file_path .
                                "' WHERE id_presentations='" .
                                $_GET["id_presentations"] .
                                "'";
                            $result2 = mysqli_query($connexion, $request2);
                        }
                    }
                    $confirmation =
                        "<p class='success'><i class='fa-solid fa-circle-check success_icon'></i> La prestation a bien été modifiée </p>";
                } else {
                    $confirmation = $error;
                }
                foreach ($_POST as $cle => $valeur) {
                    unset($_POST[$cle]);
                }
                break;

            case "visibilityPresentations":
                if (isset($_GET["id_presentations"])) {
                    if (isset($_GET["visibility"])) {
                        $requete =
                            "UPDATE presentations SET visibility_presentations='" .
                            $_GET["visibility"] .
                            "' WHERE id_presentations='" .
                            $_GET["id_presentations"] .
                            "'";
                        $resultat = mysqli_query($connexion, $requete);
                        $confirmation =
                            "<p class='success'><i class='fa-solid fa-circle-check success_icon'></i> La visibilité a bien été modifiée </p>";
                    }
                }

                break;

            case "warningPresentations":
                if (isset($_GET["id_presentations"])) {
                    $confirmation = "<div class='confirm'>";
                    $confirmation .=
                        "<p class='confirm__paragraph'>Êtes vous sûr de vouloir supprimer la presentation n°" .
                        $_GET["id_presentations"] .
                        "</p>";
                    $confirmation .=
                        "<a class='confirm__paragraph_link' href='back.php?action=presentations&case=deletePresentations&id_presentations=" .
                        $_GET["id_presentations"] .
                        "'>OUI <i class='fa-light fa-check confirm__paragraph_link_icons'></i></a>";
                    $confirmation .=
                        "<a class='confirm__paragraph_link' href='back.php?action=presentations'>NON <i class='fa-light fa-xmark confirm__paragraph_link_icons'></i></a></div>";
                }
                break;

            case "deletePresentations":
                if (isset($_GET["id_presentations"])) {
                    // Récupérer le chemin du fichier image à supprimer
                    $request_img =
                        "SELECT img_presentations FROM presentations WHERE id_presentations='" .
                        $_GET["id_presentations"] .
                        "'";
                    $result_img = mysqli_query($connexion, $request_img);
                    $img_path = mysqli_fetch_object($result_img)
                        ->img_presentations;

                    if (file_exists($img_path)) {
                        unlink($img_path);
                    }

                    $request4 =
                        "DELETE FROM presentations WHERE id_presentations='" .
                        $_GET["id_presentations"] .
                        "'";
                    $result4 = mysqli_query($connexion, $request4);
                    $confirmation =
                        "<p class='success'><i class='fa-solid fa-circle-check success_icon'></i> La présentation a bien été supprimée </p>";

                    $request2 =
                        "SELECT * FROM presentations ORDER BY rank_presentations";
                    $result2 = mysqli_query($connexion, $request2);
                    $i = 1;
                    while ($rows2 = mysqli_fetch_object($result2)) {
                        $request3 =
                            "UPDATE presentations SET rank_presentations='" .
                            $i .
                            "' WHERE id_presentations='" .
                            $rows2->id_presentations .
                            "'";
                        $result3 = mysqli_query($connexion, $request3);
                        $i++;
                    }
                }
                break;

                break;
            case "rankPresentations":
                if (isset($_GET["id_presentations"])) {
                    switch ($_GET["direction"]) {
                        case "up":
                            if (isset($_GET["rank"]) && $_GET["rank"] > 1) {
                                $rank = $_GET["rank"] - 1;
                                $requete =
                                    "UPDATE presentations SET rank_presentations='" .
                                    $_GET["rank"] .
                                    "' WHERE rank_presentations='" .
                                    $rank .
                                    "'";
                                $resultat = mysqli_query($connexion, $requete);
                                $requete2 =
                                    "UPDATE presentations SET rank_presentations='" .
                                    $rank .
                                    "' WHERE id_presentations='" .
                                    $_GET["id_presentations"] .
                                    "'";
                                $resultat2 = mysqli_query(
                                    $connexion,
                                    $requete2
                                );
                            }
                            break;

                        case "down":
                            $requete =
                                "SELECT count(*) AS nb_presentations FROM presentations";
                            $resultat = mysqli_query($connexion, $requete);
                            $ligne = mysqli_fetch_object($resultat);
                            if (
                                isset($_GET["rank"]) &&
                                $_GET["rank"] < $ligne->nb_presentations
                            ) {
                                $rank = $_GET["rank"] + 1;
                                $requete =
                                    "UPDATE presentations SET rank_presentations='" .
                                    $_GET["rank"] .
                                    "' WHERE rank_presentations='" .
                                    $rank .
                                    "'";
                                $resultat = mysqli_query($connexion, $requete);
                                $requete2 =
                                    "UPDATE presentations SET rank_presentations='" .
                                    $rank .
                                    "' WHERE id_presentations='" .
                                    $_GET["id_presentations"] .
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
        }
    }
    $request = "SELECT * FROM presentations ORDER BY rank_presentations";
    $result = mysqli_query($connexion, $request);
    $content = "<details class='content__details'>";
    $content .= "<summary class='content__details_summary'>";
    $content .= "<div>POSITION</div>";
    $content .= "<div>PRESENTATIONS</div>";
    $content .= "<div>IMAGE</div>";
    $content .= "<div>ACTIONS</div>";
    $content .= "</summary></details>";
    while ($rows = mysqli_fetch_object($result)) {
        $content .= "<details class='content__details'>";
        $content .= "<summary class='content__details_summary'>";
        $content .=
            "<div class='content__details_summary_items'>" .
            $rows->rank_presentations .
            "<a class='content__details_summary_actions_link' href='back.php?action=presentations&case=rankPresentations&direction=up&id_presentations=" .
            $rows->id_presentations .
            "&rank=" .
            $rows->rank_presentations .
            "'><i class='fa-solid fa-arrow-up ' style='margin-inline: 0.2rem; margin-left: 0.5rem'></i></a>" .
            "<a class='content__details_summary_actions_link' href='back.php?action=presentations&case=rankPresentations&direction=down&id_presentations=" .
            $rows->id_presentations .
            "&rank=" .
            $rows->rank_presentations .
            "'><i class='fa-solid fa-arrow-down' style='margin-inline: 0.2rem'></i></a></div>";
        $content .= "<div class='content__details_summary_items'>$rows->title_presentations</div>";

        $content .=
            "<div class='content__details_summary_items'><img src='$rows->img_presentations' alt='' class='content__details_summary_items_img''></div>";
        $content .= "<div class='content__details_summary_actions'>";
        if ($rows->visibility_presentations == 1) {
            $content .=
                "<a class='content__details_summary_actions_link' href='back.php?action=presentations&case=visibilityPresentations&visibility=2&id_presentations=" .
                $rows->id_presentations .
                "' ><i class='fa-solid fa-eye-slash'></i></a>";
        } else {
            $content .=
                "<a class='content__details_summary_actions_link' href='back.php?action=presentations&case=visibilityPresentations&visibility=1&id_presentations=" .
                $rows->id_presentations .
                "' ><i class='fa-solid fa-eye'></i></a>";
        }
        $content .=
            "<a class='content__details_summary_actions_link' href='back.php?action=presentations&case=loadPresentations&id_presentations=" .
            $rows->id_presentations .
            "#presentation_form" .
            "' ><i class='fa-solid fa-pen-to-square'></i></a>";
        $content .=
            "<a class='content__details_summary_actions_link' href='back.php?action=presentations&case=warningPresentations&id_presentations=" .
            $rows->id_presentations .
            "'><i class='fa-solid fa-trash'></i></a>";
        $content .= "</summary></details>";
    }
}
