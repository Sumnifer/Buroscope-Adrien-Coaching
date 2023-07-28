<?php
if (isset($_SESSION["id_users"])) {
    $connexion = connexion();
    mysqli_set_charset($connexion, "utf8");
    $title = "Gestion du Slider";
    $form = "forms/formSliders.php";
    $action_form = "newSliders";

    if (isset($_GET["case"])) {
        switch ($_GET["case"]) {
            case "newSliders":
                $request =
                    "SELECT COUNT(*) AS nb_sliders FROM sliders";
                $result = mysqli_query($connexion, $request);
                $rows = mysqli_fetch_object($result);
                if (empty($_POST["title_sliders"])) {
                    $confirmation =
                        "<p class='warning'><i class='fa-solid fa-triangle-exclamation warning_icon'></i> Veuillez entrer un titre </p>";
                }
                if (empty($_POST["content_sliders"])) {
                    $confirmation =
                        "<p class='warning'><i class='fa-solid fa-triangle-exclamation warning_icon'></i> Veuillez entrer du contenu </p>";
                }
                if (empty($_POST["alt_sliders"])) {
                    $confirmation =
                        "<p class='warning'><i class='fa-solid fa-triangle-exclamation warning_icon'></i> Veuillez entrer un alt </p>";
                }
                if (empty($_POST["visibility_sliders"])) {
                    $confirmation =
                        "<p class='warning'><i class='fa-solid fa-triangle-exclamation warning_icon'></i> Veuillez choisir une visibilité </p>";
                } else {
                    $request =
                        "INSERT INTO sliders SET 
                      title_sliders='" .
                        $_POST["title_sliders"] .
                        "',
                      content_sliders='" .
                        $_POST["content_sliders"] .
                        "',
                        alt_sliders='" .
                        $_POST["alt_sliders"] .
                        "',
                        rank_sliders=($rows->nb_sliders + 1),
                        visibility_sliders='" .
                        $_POST["visibility_sliders"] .
                        "'";

                    $result = mysqli_query($connexion, $request);
                    $last_Id = mysqli_insert_id($connexion);

                    if (
                        isset($_FILES["img_sliders"]) &&
                        $_FILES["img_sliders"]["error"] == 0
                    ) {
                        $file_name = $_FILES["img_sliders"]["name"];
                        $file_extension = pathinfo(
                            $file_name,
                            PATHINFO_EXTENSION
                        );
                        $new_file_name =
                            "slider_" . $last_Id . "." . $file_extension;
                        $file_path = "../medias/" . $new_file_name;

                        if (
                            move_uploaded_file(
                                $_FILES["img_sliders"]["tmp_name"],
                                $file_path
                            )
                        ) {
                            $request2 =
                                "UPDATE sliders SET img_sliders='" .
                                $file_path .
                                "' WHERE id_sliders='" .
                                $last_Id .
                                "'";
                            $result2 = mysqli_query($connexion, $request2);
                        }
                    }

                    $confirmation =
                        "<p class='success'><i class='fa-solid fa-circle-check success_icon'></i> La slide a bien été crée </p>";
                    foreach ($_POST as $cle => $valeur) {
                        unset($_POST[$cle]);
                    }
                }
                break;

            case "loadSliders":
                if (isset($_GET["id_sliders"])) {
                    $action_form =
                        "modifySliders&id_sliders=" .
                        $_GET["id_sliders"];
                    $request =
                        "SELECT * FROM sliders WHERE id_sliders='" .
                        $_GET["id_sliders"] .
                        "'";
                    $result = mysqli_query($connexion, $request);
                    $rows = mysqli_fetch_object($result);
                    $_POST["title_sliders"] = $rows->title_sliders;
                    $_POST["content_sliders"] =
                        $rows->content_sliders;
                    $_POST["alt_sliders"] = $rows->alt_sliders;
                    $visibility = $rows->visibility_sliders;
                }
                break;

            case "modifySliders":

                $id_sliders = $_GET["id_sliders"];
                $title_sliders = $_POST["title_sliders"];
                $content_sliders = $_POST["content_sliders"];
                $alt_sliders = $_POST["alt_sliders"];
                $visibility_sliders = $_POST["visibility_sliders"];

                $error = "";

                if (empty($title_sliders)) {
                    $error .=
                        "<p class='warning'><i class='fa-solid fa-circle-exclamation error_icon'></i> Veuillez renseigner le titre</p>";
                }
                if (empty($content_sliders)) {
                    $error .=
                        "<p class='warning'><i class='fa-solid fa-circle-exclamation error_icon'></i> Veuillez renseigner le contenu</p>";
                }
                if (empty($alt_sliders)) {
                    $error .=
                        "<p class='warning'><i class='fa-solid fa-circle-exclamation error_icon'></i> Veuillez renseigner la description alternative</p>";
                }

                if (empty($visibility_sliders)) {
                    $error .=
                        "<p class='warning'><i class='fa-solid fa-circle-exclamation error_icon'></i> Veuillez renseigner la visibilité</p>";
                }

                if (empty($error)) {
                    $request = "UPDATE sliders SET 
                    title_sliders='$title_sliders',
                    content_sliders='$content_sliders',
                    alt_sliders='$alt_sliders',
                    visibility_sliders='$visibility_sliders'
                    WHERE id_sliders='$id_sliders'";
                    $result = mysqli_query($connexion, $request);

                    if (
                        isset($_FILES["img_sliders"]) &&
                        $_FILES["img_sliders"]["error"] == 0
                    ) {

                        $request_img =
                            "SELECT img_sliders FROM sliders WHERE id_sliders='" .
                            $_GET["id_sliders"] .
                            "'";

                        $result_img = mysqli_query($connexion, $request_img);
                        $img_path = mysqli_fetch_object($result_img)
                            ->img_sliders;

                        if (file_exists($img_path)) {
                            unlink($img_path);
                        }
                        $file_name = $_FILES["img_sliders"]["name"];
                        $file_extension = pathinfo(
                            $file_name,
                            PATHINFO_EXTENSION
                        );
                        $new_file_name =
                            "slider_" .
                            $_GET["id_sliders"] .
                            "." .
                            $file_extension;
                        $file_path = "../medias/" . $new_file_name;

                        if (
                            move_uploaded_file(
                                $_FILES["img_sliders"]["tmp_name"],
                                $file_path
                            )
                        ) {
                            $request2 =
                                "UPDATE sliders SET img_sliders='" .
                                $file_path .
                                "' WHERE id_sliders='" .
                                $_GET["id_sliders"] .
                                "'";
                            $result2 = mysqli_query($connexion, $request2);
                        }
                    }
                    $confirmation =
                        "<p class='success'><i class='fa-solid fa-circle-check success_icon'></i> La slide a bien été modifiée </p>";
                } else {
                    $confirmation = $error;
                }
                foreach ($_POST as $cle => $valeur) {
                    unset($_POST[$cle]);
                }
                break;

            case "visibilitySliders":
                if (isset($_GET["id_sliders"])) {
                    if (isset($_GET["visibility"])) {
                        $requete =
                            "UPDATE sliders SET visibility_sliders='" .
                            $_GET["visibility"] .
                            "' WHERE id_sliders='" .
                            $_GET["id_sliders"] .
                            "'";
                        $resultat = mysqli_query($connexion, $requete);
                        $confirmation =
                            "<p class='success'><i class='fa-solid fa-circle-check success_icon'></i> La visibilité a bien été modifiée </p>";
                    }
                }

                break;

            case "warningSliders":
                if (isset($_GET["id_sliders"])) {
                    $confirmation = "<div class='confirm'>";
                    $confirmation .=
                        "<p class='confirm__paragraph'>Êtes vous sûr de vouloir supprimer la slide n°" .
                        $_GET["id_sliders"] .
                        "</p>";
                    $confirmation .=
                        "<a class='confirm__paragraph_link' href='back.php?action=sliders&case=deleteSliders&id_sliders=" .
                        $_GET["id_sliders"] .
                        "'>OUI <i class='fa-light fa-check confirm__paragraph_link_icons'></i></a>";
                    $confirmation .=
                        "<a class='confirm__paragraph_link' href='back.php?action=sliders'>NON <i class='fa-light fa-xmark confirm__paragraph_link_icons'></i></a></div>";
                }
                break;

            case "deleteSliders":
                if (isset($_GET["id_sliders"])) {
                    // Récupérer le chemin du fichier image à supprimer
                    $request_img =
                        "SELECT img_sliders FROM sliders WHERE id_sliders='" .
                        $_GET["id_sliders"] .
                        "'";
                    $result_img = mysqli_query($connexion, $request_img);
                    $img_path = mysqli_fetch_object($result_img)
                        ->img_sliders;

                    if (file_exists($img_path)) {
                        unlink($img_path);
                    }

                    $request4 =
                        "DELETE FROM sliders WHERE id_sliders='" .
                        $_GET["id_sliders"] .
                        "'";
                    $result4 = mysqli_query($connexion, $request4);
                    $confirmation =
                        "<p class='success'><i class='fa-solid fa-circle-check success_icon'></i> La présentation a bien été supprimée </p>";

                    $request2 =
                        "SELECT * FROM sliders ORDER BY rank_sliders";
                    $result2 = mysqli_query($connexion, $request2);
                    $i = 1;
                    while ($rows2 = mysqli_fetch_object($result2)) {
                        $request3 =
                            "UPDATE sliders SET rank_sliders='" .
                            $i .
                            "' WHERE id_sliders='" .
                            $rows2->id_sliders .
                            "'";
                        $result3 = mysqli_query($connexion, $request3);
                        $i++;
                    }
                }
                break;

                break;
            case "rankSliders":
                if (isset($_GET["id_sliders"])) {
                    switch ($_GET["direction"]) {
                        case "up":
                            if (isset($_GET["rank"]) && $_GET["rank"] > 1) {
                                $rank = $_GET["rank"] - 1;
                                $requete =
                                    "UPDATE sliders SET rank_sliders='" .
                                    $_GET["rank"] .
                                    "' WHERE rank_sliders='" .
                                    $rank .
                                    "'";
                                $resultat = mysqli_query($connexion, $requete);
                                $requete2 =
                                    "UPDATE sliders SET rank_sliders='" .
                                    $rank .
                                    "' WHERE id_sliders='" .
                                    $_GET["id_sliders"] .
                                    "'";
                                $resultat2 = mysqli_query(
                                    $connexion,
                                    $requete2
                                );
                            }
                            break;

                        case "down":
                            $requete =
                                "SELECT count(*) AS nb_sliders FROM sliders";
                            $resultat = mysqli_query($connexion, $requete);
                            $ligne = mysqli_fetch_object($resultat);
                            if (
                                isset($_GET["rank"]) &&
                                $_GET["rank"] < $ligne->nb_sliders
                            ) {
                                $rank = $_GET["rank"] + 1;
                                $requete =
                                    "UPDATE sliders SET rank_sliders='" .
                                    $_GET["rank"] .
                                    "' WHERE rank_sliders='" .
                                    $rank .
                                    "'";
                                $resultat = mysqli_query($connexion, $requete);
                                $requete2 =
                                    "UPDATE sliders SET rank_sliders='" .
                                    $rank .
                                    "' WHERE id_sliders='" .
                                    $_GET["id_sliders"] .
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

            case "unloadSliders" :
                $action_form = "newSliders";
                foreach ($_POST as $cle => $valeur) {
                    unset($_POST[$cle]);
                }
                break;
        }
    }
    $request = "SELECT * FROM sliders ORDER BY rank_sliders";
    $result = mysqli_query($connexion, $request);
    $content = "<details class='content__details'>";
    $content .= "<summary class='content__details_summary'>";
    $content .= "<div>POSITION</div>";
    $content .= "<div>SLIDERS</div>";
    $content .= "<div>IMAGE</div>";
    $content .= "<div>ACTIONS</div>";
    $content .= "</summary></details>";
    while ($rows = mysqli_fetch_object($result)) {
        $content .= "<details class='content__details'>";
        $content .= "<summary class='content__details_summary'>";
        $content .=
            "<div class='content__details_summary_items'>" .
            $rows->rank_sliders .
            "<a class='content__details_summary_actions_arrows' href='back.php?action=sliders&case=rankSliders&direction=up&id_sliders=" .
            $rows->id_sliders .
            "&rank=" .
            $rows->rank_sliders .
            "'><i class='fa-solid fa-arrow-up ' style='margin-inline: 0.2rem; margin-left: 0.5rem'></i></a>" .
            "<a class='content__details_summary_actions_arrows' href='back.php?action=sliders&case=rankSliders&direction=down&id_sliders=" .
            $rows->id_sliders .
            "&rank=" .
            $rows->rank_sliders .
            "'><i class='fa-solid fa-arrow-down' style='margin-inline: 0.2rem'></i></a></div>";
        $content .= "<div class='content__details_summary_items'>$rows->title_sliders</div>";

        $content .=
            "<div class='content__details_summary_items'><img src='$rows->img_sliders' alt='' class='content__details_summary_items_img''></div>";
        $content .= "<div class='content__details_summary_actions'>";
        if ($rows->visibility_sliders == 1) {
            $content .=
                "<a class='content__details_summary_actions_link-eyes' href='back.php?action=sliders&case=visibilitySliders&visibility=2&id_sliders=" .
                $rows->id_sliders .
                "' ><i class='fa-solid fa-eye-slash content__details_summary_actions_link_icon-eyes'></i></a>";
        } else {
            $content .=
                "<a class='content__details_summary_actions_link-eyes' href='back.php?action=sliders&case=visibilitySliders&visibility=1&id_sliders=" .
                $rows->id_sliders .
                "' ><i class='fa-solid fa-eye content__details_summary_actions_link_icon-eyes'></i></a>";
        }
        $content .=
            "<a class='modify content__details_summary_actions_link-modify' href='back.php?action=sliders&case=loadSliders&id_sliders=" .
            $rows->id_sliders .
            "#presentation_form" .
            "' ><i class=' fa-solid fa-pen-to-square content__details_summary_actions_link_icon-modify'></i></a>";
        $content .=
            "<a class='content__details_summary_actions_link-trash' href='back.php?action=sliders&case=warningSliders&id_sliders=" .
            $rows->id_sliders .
            "'><i class='fa-solid fa-trash content__details_summary_actions_link_icon-trash'></i></a>";
        $content .= "</summary></details>";
    }
}
