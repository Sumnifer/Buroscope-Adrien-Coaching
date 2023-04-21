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
                } else {
                    $request =
                        "INSERT INTO presentations SET 
                      title_presentations='" .
                        $_POST["title_presentations"] .
                        "',
                      content_presentations='" .
                        $_POST["content_presentations"] .
                        "',
                        alt_presentations='".$_POST['alt_presentations']."',
                        direction_presentations='".$_POST['direction_presentations']."'";
                    $result = mysqli_query($connexion, $request);
                    $confirmation =
                        "<p class='success'><i class='fa-solid fa-circle-check success_icon'></i> La prestation a bien été crée </p>";
                    foreach ($_POST as $cle => $valeur) {
                        unset($_POST[$cle]);
                    }
                }
                break;

                case "loadPresentations":
                if (isset($_GET["id_presentations"])) {

                    $action_form = "modifyPresentations&id_presentations=" . $_GET["id_presentations"];
                    $request =
                        "SELECT * FROM presentations WHERE id_presentations='" .
                        $_GET["id_presentations"] .
                        "'";
                    $result = mysqli_query($connexion, $request);
                    $rows = mysqli_fetch_object($result);
                    $_POST["title_presentations"] = $rows->title_presentations;
                    $_POST["content_presentations"] = $rows->content_presentations;
                    $_POST["alt_presentations"] = $rows->alt_presentations;
                    $_POST["direction_presentations"] = $rows->direction_presentations;
                }
                break;

                case "modifyPresentations":
                if (isset($_GET["id_presentations"])) {
                    $request =
                        "UPDATE presentations SET 
                      title_presentations='" .
                        $_POST["title_presentations"] .
                        "',
                      content_presentations='" .
                        $_POST["content_presentations"] .
                        "',
                      alt_presentations='" .
                        $_POST["alt_presentations"] .
                        "',
                      direction_presentations='" .
                        $_POST["direction_presentations"] .
                        "' WHERE id_presentations='" .
                        $_GET["id_presentations"] .
                        "'";
                    $result = mysqli_query($connexion, $request);
                    $confirmation =
                        "<p class='success'><i class='fa-solid fa-circle-check success_icon'></i> La prestation a bien été modifiée </p>";
                    foreach ($_POST as $cle => $valeur) {
                        unset($_POST[$cle]);
                    }
                }
                break;

                case "deletePresentations":
                if (isset($_GET["id_presentations"])) {
                    $request =
                        "DELETE FROM presentations WHERE id_presentations='" .
                        $_GET["id_presentations"] .
                        "'";
                    $result = mysqli_query($connexion, $request);
                    $confirmation =
                        "<p class='success'><i class='fa-solid fa-circle-check success_icon'></i> La prestation a bien été supprimée </p>";
                }
                break;
        }
    }
    $request = "SELECT * FROM presentations ORDER BY id_presentations";
    $result = mysqli_query($connexion, $request);
    $content = "<details class='content__details'>";
    $content .= "<summary class='content__details_summary'>";
    $content .= "<div>ID</div>";
    $content .= "<div>PRESENTATIONS</div>";
    $content .= "<div>IMAGE</div>";
    $content .= "<div>ACTIONS</div>";
    $content .= "</summary></details>";
    while ($rows = mysqli_fetch_object($result)) {
        $content .= "<details class='content__details'>";
        $content .= "<summary class='content__details_summary'>";
        $content .= "<div class='content__details_summary_items'>$rows->id_presentations</div>";
        $content .= "<div class='content__details_summary_items'>$rows->title_presentations</div>";
        $content .= "<div class='content__details_summary_items'><img src='#' alt='' class='content__details_summary_items_img'></div>";
        $content .= "<div class='content__details_summary_actions'>";
        $content .= "<a class='content__details_summary_actions_link' href='back.php?action=presentations&case=loadPresentations&id_presentations=" . $rows->id_presentations . "' ><i class='fa-solid fa-eye'></i></a>";
        $content .="<a class='content__details_summary_actions_link' href='back.php?action=presentations&case=loadPresentations&id_presentations=" . $rows->id_presentations . "' ><i class='fa-solid fa-pen-to-square'></i></a>";
        $content .= "<a class='content__details_summary_actions_link' href='back.php?action=presentations&case=warningPresentations&id_presentations=" . $rows->id_presentations . "'><i class='fa-solid fa-trash'></i></a>";
        $content .= "</summary></details>";
    }
}