<?php
if (isset($_SESSION["id_users"])) {
    $connexion = connexion();
    mysqli_set_charset($connexion, "utf8");
    $title = "Gestion des Activités";
    $form = "forms/formPresentations.php";
    $dateInput = '';




    if (isset($_GET["case"])) {

        switch ($_GET["case"]) {
            case "newPresentations":
                $action_form = "newPresentations";
                $request =
                    "SELECT COUNT(*) AS nb_presentations FROM presentations";
                $result = mysqli_query($connexion, $request);
                $rows = mysqli_fetch_object($result);
                if (empty($_POST["title_presentations"])) {
                    $confirmation =
                        "<p class='warning confirmation'><i class='fa-solid fa-circle-exclamation warning_icon'></i> Veuillez entrer un titre </p>";
                }
                elseif (empty($_POST["content_presentations"])) {
                    $confirmation =
                        "<p class='warning confirmation'><i class='fa-solid fa-circle-exclamation warning_icon'></i> Veuillez entrer du contenu </p>";
                }
                elseif (empty($_POST["alt_presentations"])) {
                    $confirmation =
                        "<p class='warning confirmation'><i class='fa-solid fa-circle-exclamation warning_icon'></i> Veuillez entrer un alt </p>";
                }
                elseif (empty($_POST["visibility_presentations"])) {
                    $confirmation =
                        "<p class='warning confirmation'><i class='fa-solid fa-circle-exclamation warning_icon'></i> Veuillez choisir une visibilité </p>";
                } else {

                    $request = "SELECT COUNT(*) AS nb_presentations FROM presentations";
                    $result = mysqli_query($connexion, $request);
                    $rows = mysqli_fetch_object($result);
                    $request = "INSERT INTO presentations SET 
                      title_presentations=?,
                      content_presentations=?,
                      alt_presentations=?,
                      rank_presentations=?,
                      visibility_presentations=?,
                      direction_presentations=?";
                    $stmt = mysqli_prepare($connexion, $request);
                    $title = $_POST["title_presentations"];
                    $content = $_POST["content_presentations"];
                    $alt = $_POST["alt_presentations"];
                    $rank = $rows->nb_presentations + 1;
                    $visibility = $_POST["visibility_presentations"];
                    $direction = $_POST["direction_presentations"];
                    mysqli_stmt_bind_param($stmt, "sssiss", $title, $content, $alt, $rank, $visibility, $direction);
                    $result = mysqli_stmt_execute($stmt);
                    $last_Id = mysqli_insert_id($connexion);

                    if (
                        !empty($_FILES["img_presentations"]) &&
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
                            $request2 = "UPDATE presentations SET img_presentations=? WHERE id_presentations=?";
                            $stmt2 = mysqli_prepare($connexion, $request2);
                            $file_path = $_POST["file_path"];
                            $last_Id = $_POST["last_Id"];
                            mysqli_stmt_bind_param($stmt2, "si", $file_path, $last_Id);
                            $result2 = mysqli_stmt_execute($stmt2);
                        }
                    }

                    $confirmation =
                        "<p class='success confirmation'><i class='fa-solid fa-circle-check success_icon'></i> La presentation a bien été crée </p>";
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
                        "<p class='warning confirmation'><i class='fa-solid fa-circle-exclamation error_icon'></i> Veuillez renseigner le titre</p>";
                }
                if (empty($content_presentations)) {
                    $error .=
                        "<p class='warning confirmation'><i class='fa-solid fa-circle-exclamation error_icon'></i> Veuillez renseigner le contenu</p>";
                }
                if (empty($alt_presentations)) {
                    $error .=
                        "<p class='warning confirmation'><i class='fa-solid fa-circle-exclamation error_icon'></i> Veuillez renseigner la description alternative</p>";
                }
                if (empty($direction_presentations)) {
                    $error .=
                        "<p class='warning confirmation'><i class='fa-solid fa-circle-exclamation error_icon'></i> Veuillez renseigner la direction</p>";
                }
                if (empty($visibility_presentations)) {
                    $error .=
                        "<p class='warning confirmation'><i class='fa-solid fa-circle-exclamation error_icon'></i> Veuillez renseigner la visibilité</p>";
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
                        "<p class='success confirmation'><i class='fa-solid fa-circle-check success_icon'></i> La présentation a bien été modifiée </p>";
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
                        $request = "UPDATE presentations SET visibility_presentations=? WHERE id_presentations=?";
                        $stmt = mysqli_prepare($connexion, $request);
                        mysqli_stmt_bind_param($stmt, "ii", $_GET["visibility"], $_GET["id_presentations"]);
                        $result = mysqli_stmt_execute($stmt);
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

            case "warningPresentations":
                if (isset($_GET["id_presentations"])) {
                    $confirmation = "<div class='confirm'>";
                    $confirmation .=
                        "<p class='confirm__paragraph'><i class='fa-solid fa-triangle-exclamation warning_icon'></i>Êtes vous sûr de vouloir supprimer la presentation n°" .
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
                        "<p class='success confirmation'><i class='fa-solid fa-circle-check success_icon'></i> La présentation a bien été supprimée </p>";

                    $request2 =
                        "SELECT * FROM presentations ORDER BY rank_presentations";
                    $result2 = mysqli_query($connexion, $request2);
                    $i = 1;
                    while ($rows2 = mysqli_fetch_object($result2)) {
                        $request = "UPDATE presentations SET rank_presentations=? WHERE id_presentations=?";
                        $stmt = mysqli_prepare($connexion, $request);
                        mysqli_stmt_bind_param($stmt, "ii", $i, $rows2->id_presentations);
                        $result = mysqli_stmt_execute($stmt);

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
                                $request = "UPDATE presentations SET rank_presentations=? WHERE rank_presentations=?";
                                $stmt1 = mysqli_prepare($connexion, $request);
                                mysqli_stmt_bind_param($stmt1, "ii", $_GET["rank"], $rank);
                                mysqli_stmt_execute($stmt1);

                                $request2 = "UPDATE presentations SET rank_presentations=? WHERE id_presentations=?";
                                $stmt2 = mysqli_prepare($connexion, $request2);
                                mysqli_stmt_bind_param($stmt2, "ii", $rank, $_GET["id_presentations"]);
                                mysqli_stmt_execute($stmt2);

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
            case "unloadPresentations" :
                $action_form = "newPresentations";
                foreach ($_POST as $cle => $valeur) {
                    unset($_POST[$cle]);
                }
                break;
            case "modifyDateInput" :
                break;

            case "modifyDate" :
                if(!empty($_POST['modifyDateInput'])){
                }
                break;


        }
    }
    $request = "SELECT * FROM presentations ORDER BY rank_presentations";
    $result = mysqli_query($connexion, $request);
    $content = "<details class='content__details'>";
    $content .= "<summary class='content__details_summary'>";
    $content .= "<div>POSITION</div>";
    $content .= "<div>ACTIVITÉ</div>";
    $content .= "<div>IMAGE</div>";
    $content .= "<div>ACTIONS</div>";
    $content .= "</summary></details>";
    while ($rows = mysqli_fetch_object($result)) {
        $id = $rows->id_presentations;
        $content .= "<details class='content__details'>";
        $content .= "<summary class='content__details_summary'>";
        $content .=
            "<div class='content__details_summary_items'>" .
            $rows->rank_presentations .
            "<a class='content__details_summary_actions_arrows' href='back.php?action=presentations&case=rankPresentations&direction=up&id_presentations=" .
            $rows->id_presentations .
            "&rank=" .
            $rows->rank_presentations .
            "'><i class='fa-solid fa-arrow-up '></i></a>" .
            "<a class='content__details_summary_actions_arrows' href='back.php?action=presentations&case=rankPresentations&direction=down&id_presentations=" .
            $rows->id_presentations .
            "&rank=" .
            $rows->rank_presentations .
            "'><i class='fa-solid fa-arrow-down'></i></a></div>";

        $content .= "<div class='content__details_summary_items'>$rows->title_presentations</div>";

        $content .=
            "<div class='content__details_summary_items'><a href='$rows->img_presentations'><img src='$rows->img_presentations' alt='' class='content__details_summary_items_img''></a></div>";
        $content .= "<div class='content__details_summary_actions'>";

        if ($rows->visibility_presentations == 1) {
            $content .=
                "<a class='content__details_summary_actions_link-eyes' href='back.php?action=presentations&case=visibilityPresentations&visibility=2&id_presentations=" .
                $rows->id_presentations .
                "' ><i class='fa-solid fa-eye content__details_summary_actions_link_icon-eyes'></i></a>";
        } else {
            $content .=
                "<a class='content__details_summary_actions_link-eyes' href='back.php?action=presentations&case=visibilityPresentations&visibility=1&id_presentations=" .
                $rows->id_presentations .
                "' ><i class='fa-solid fa-eye-slash content__details_summary_actions_link_icon-eyes'></i></a>";
        }

        $content .=
            "<a class='modify content__details_summary_actions_link-modify' href='back.php?action=presentations&case=loadPresentations&id_presentations=" .
            $rows->id_presentations .

            " '><i class='fa-solid fa-pen-to-square content__details_summary_actions_link_icon-modify'></i></a>";
        $content .=
            "<a class='content__details_summary_actions_link-trash' href='back.php?action=presentations&case=warningPresentations&id_presentations=" .
            $rows->id_presentations .
            "'><i class='fa-solid fa-trash content__details_summary_actions_link_icon-trash'></i></a>";
        $content .= "</summary></details>";
    }

}
