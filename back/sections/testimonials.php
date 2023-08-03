<?php
if (isset($_SESSION["id_users"])) {
    $connexion = connexion();
    mysqli_set_charset($connexion, "utf8");
    $title = "Gestion des Avis";
    $form = "forms/formTestimonials.php";
    $action_form = "newTestimonials";

    if (isset($_GET["case"])) {
        switch ($_GET["case"]) {

            case "loadTestimonials":
                if (isset($_GET["id"])) {
                    $action_form =
                        "modifyTestimonials&id=" .
                        $_GET["id"];
                    $request =
                        "SELECT * FROM testimonials WHERE id='" .
                        $_GET["id"] .
                        "'";
                    $result = mysqli_query($connexion, $request);
                    $rows = mysqli_fetch_object($result);
                    $_POST["testimonials_name"] = $rows->testimonials_name;
                    $_POST["testimonials_content"] =
                        $rows->testimonials_content;
                    $visibility = $rows->testimonials_visibility;
                    $_POST['testimonials_status'] = $rows->testimonials_status;
                    $_POST['testimonials_date'] = $rows->testimonials_date;
                }
                break;

            case "modifyTestimonials":

                $id = $_GET["id"];
                $testimonials_name = $_POST["testimonials_name"];
                $testimonials_content = $_POST["testimonials_content"];
                $testimonials_status = $_POST['testimonials_status'];
                $testimonials_visibility = $_POST["testimonials_visibility"];


                $error = "";

                if (empty($testimonials_name)) {
                    $error .=
                        "<p class='warning'><i class='fa-solid fa-circle-exclamation error_icon'></i> Veuillez renseigner le titre</p>";
                }
                if (empty($testimonials_content)) {
                    $error .=
                        "<p class='warning'><i class='fa-solid fa-circle-exclamation error_icon'></i> Veuillez renseigner le contenu</p>";
                }

                if (empty($error)) {
                    $request = "UPDATE testimonials SET 
                    testimonials_name='$testimonials_name',
                    testimonials_content='$testimonials_content',
                    testimonials_status='.$testimonials_status.',
                    testimonials_visibility='$testimonials_visibility'
                    WHERE id='$id'";
                    $result = mysqli_query($connexion, $request);
                    $confirmation =
                        "<p class='success'><i class='fa-solid fa-circle-check success_icon'></i> La slide a bien été modifiée </p>";
                } else {
                    $confirmation = $error;
                }
                foreach ($_POST as $cle => $valeur) {
                    unset($_POST[$cle]);
                }
                break;

            case "visibilityTestimonials":
                if (isset($_GET["id"])) {
                    if (isset($_GET["visibility"])) {
                        $requete =
                            "UPDATE testimonials SET testimonials_visibility='" .
                            $_GET["visibility"] .
                            "' WHERE id='" .
                            $_GET["id"] .
                            "'";
                        $resultat = mysqli_query($connexion, $requete);
                        $confirmation =
                            "<p class='success'><i class='fa-solid fa-circle-check success_icon'></i> La visibilité a bien été modifiée </p>";
                    }
                }

                break;

            case "warningTestimonials":
                if (isset($_GET["id"])) {
                    $confirmation = "<div class='confirm'>";
                    $confirmation .=
                        "<p class='confirm__paragraph'>Êtes vous sûr de vouloir supprimer la slide n°" .
                        $_GET["id"] .
                        "</p>";
                    $confirmation .=
                        "<a class='confirm__paragraph_link' href='back.php?action=testimonials&case=deleteTestimonials&id=" .
                        $_GET["id"] .
                        "'>OUI <i class='fa-light fa-check confirm__paragraph_link_icons'></i></a>";
                    $confirmation .=
                        "<a class='confirm__paragraph_link' href='back.php?action=testimonials'>NON <i class='fa-light fa-xmark confirm__paragraph_link_icons'></i></a></div>";
                }
                break;

            case "deleteTestimonials":
                if (isset($_GET["id"])) {
                    $request4 =
                        "DELETE FROM testimonials WHERE id='" .
                        $_GET["id"] .
                        "'";
                    $result4 = mysqli_query($connexion, $request4);
                    $confirmation =
                        "<p class='success'><i class='fa-solid fa-circle-check success_icon'></i> La présentation a bien été supprimée </p>";

                }
                break;
        }
    }
    $request = "SELECT * FROM testimonials ORDER BY testimonials_date DESC";
    $result = mysqli_query($connexion, $request);
    $content = "<details class='content__details'>";
    $content .= "<summary class='content__details_summary'>";
    $content .= "<div class='content__details_summary_heading'>STATUT</div>";
    $content .= "<div class='content__details_summary_heading'>CONTENU</div>";
    $content .= "<div class='content__details_summary_heading'>DATE</div>";
    $content .= "<div class='content__details_summary_heading'>ACTIONS</div>";
    $content .= "</summary></details>";
    while ($rows = mysqli_fetch_object($result)) {
        $content .= "<details class='content__details'>";
        $content .= "<summary class='content__details_summary'>";
        if ($rows->testimonials_status == 3) {
            $content .= "<div class='content__details_summary_items'><i class='fa-solid fa-hourglass'></i></div>";
        } elseif ($rows->testimonials_status == 2) {
            $content .= "<div class='content__details_summary_items'><i class='fa-solid fa-xmark'></i></div>";
        } else {
            $content .= "<div class='content__details_summary_items'><i class='fa-solid fa-check'></i></div>";
        }
        $maxLength = 50;
        $content .= "<div class='content__details_summary_items'>".substr($rows->testimonials_content, 0, $maxLength) . "...</div>";
        $testimonialsDate = strtotime($rows->testimonials_date);
        $content .= "<div class='content__details_summary_items'>".date('d-m-Y-H-i-s', $testimonialsDate)."</div>";

        $content .= "<div class='content__details_summary_actions'>";
        if ($rows->testimonials_visibility == 1) {
            $content .=
                "<a class='content__details_summary_actions_link-eyes' href='back.php?action=testimonials&case=visibilityTestimonials&visibility=2&id=" .
                $rows->id .
                "' ><i class='fa-solid fa-eye-slash content__details_summary_actions_link_icon-eyes'></i></a>";
        } else {
            $content .=
                "<a class='content__details_summary_actions_link-eyes' href='back.php?action=testimonials&case=visibilityTestimonials&visibility=1&id=" .
                $rows->id .
                "' ><i class='fa-solid fa-eye content__details_summary_actions_link_icon-eyes'></i></a>";
        }
        $content .=
            "<a class='modify content__details_summary_actions_link-modify' href='back.php?action=testimonials&case=loadTestimonials&id=" .
            $rows->id .
            "#presentation_form" .
            "' ><i class=' fa-solid fa-pen-to-square content__details_summary_actions_link_icon-modify'></i></a>";
        $content .=
            "<a class='content__details_summary_actions_link-trash' href='back.php?action=testimonials&case=warningTestimonials&id=" .
            $rows->id .
            "'><i class='fa-solid fa-trash content__details_summary_actions_link_icon-trash'></i></a>";
        $content .= "</summary></details>";
    }
}
