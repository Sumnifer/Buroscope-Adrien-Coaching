<?php
if (isset($_SESSION["id_users"])) {
    $connexion = connexion();
    $title = "Gestion des pages";
    $action_form = "modifyPages";
    $form_title = "";
    $connexion->set_charset("utf8");

    if (isset($_GET["case"])) {
        // + <=================================================================================================================>

        switch ($_GET["case"]) {

            case "loadPages":

                if (isset($_GET["id_pages"])) {
                    $action_form = "modifyPages&id_pages=" . $_GET["id_pages"];
                    $request = "SELECT * FROM pages WHERE id_pages=?";
                    $stmt = mysqli_prepare($connexion, $request);
                    $id = $_GET["id_pages"];
                    mysqli_stmt_bind_param($stmt, "i", $id);
                    mysqli_stmt_execute($stmt);
                    $result = mysqli_stmt_get_result($stmt);

                    $rows = mysqli_fetch_object($result);
                    $form_title = "Modifier une Page : " .$rows->page_name;
                    $visibility_slider = $rows->visibility_slider;
                    $visibility_prestations = $rows->visibility_prestations;
                $form = "forms/formPages.php";
                }
                break;

            // * <=========================================================>

            case "modifyPages":
                if (isset($_GET["id_pages"])) {
                        $request = "UPDATE pages SET visibility_slider=?, visibility_prestations=? WHERE id_pages=?";
                        $stmt = mysqli_prepare($connexion, $request);
                        $id = htmlspecialchars($_GET["id_pages"]);
                        $visibility_slider = htmlspecialchars($_POST['slider']);
                        $visibility_prestations = htmlspecialchars($_POST['prestations']);
                        mysqli_stmt_bind_param($stmt, "iii", $visibility_slider, $visibility_prestations, $id);
                        if(mysqli_stmt_execute($stmt)) {

                            $confirmation =
                                "<p class='success'><i class='fa-solid fa-circle-check success_icon'></i> La page a bien été modifiée </p>";
                        }
                }
                break;


        }

    // + <=================================================================================================================>
    }
    // ? ==================================================================================================================>

    $request = "SELECT * FROM pages ORDER BY id_pages";
    $result = mysqli_query($connexion, $request);
    $content = "<details class='content__details'>";
    $content .= "<summary class='content__details_summary'>";
    $content .= "<div>PAGE</div>";
    $content .= "<div>SLIDER</div>";
    $content .= "<div>PRESTATIONS</div>";
    $content .= "<div>ACTIONS</div>";
    $content .= "</summary></details>";
    while ($rows = mysqli_fetch_object($result)) {
        $content .= "<details class='content__details'>";
        $content .= "<summary class='content__details_summary'>";
        $content .= "<div class='content__details_summary_items'>$rows->page_name</div>";
        if ($rows->visibility_slider == 1) {
            $content .= "<div class='content__details_summary_items'>OUI</div>";
        } else {
            $content .= "<div class='content__details_summary_items'>NON</div>";
        }
        if ($rows->visibility_prestations == 1) {
            $content .= "<div class='content__details_summary_items'>OUI</div>";
        } else {
            $content .= "<div class='content__details_summary_items'>NON</div>";
        }
        $content .=
            "<div class='content__details_summary_actions'>
                <a class='content__details_summary_actions_link-modify' href='back.php?action=pages&case=loadPages&id_pages=" .
            $rows->id_pages .
            "' >
                  <i class='fa-solid fa-pen-to-square content__details_summary_actions_link_icon-modify'></i></a>";

        $content .= "</summary></details>";
    }
    // ? ==================================================================================================================>
}
