<?php
if (isset($_SESSION["id_users"])) {
    $connexion = connexion();
    $title = "Gestion des pages";
    $form = "forms/formPages.php";
    $action_form = "newPages";

    if (isset($_GET["case"])) {
        // + <=================================================================================================================>

        switch ($_GET["case"]) {
            // * <=========================================================>

            case "newPages":
                if (empty($_POST["title_pages"])) {
                    $confirmation =
                        "<p class='warning'><i class='fa-solid fa-triangle-exclamation warning_icon'></i> Veuillez entrer un titre </p>";
                }
                if (empty($_POST["content_pages"])) {
                    $confirmation =
                        "<p class='warning'><i class='fa-solid fa-triangle-exclamation warning_icon'></i> Veuillez entrer du contenu </p>";
                } else {
                    $request =
                        "INSERT INTO pages SET 
                      title_pages='" .
                        $_POST["title_pages"] .
                        "',
                      content_pages='" .
                        $_POST["content_pages"] .
                        "'";
                    $result = mysqli_query($connexion, $request);
                    $confirmation =
                        "<p class='success'><i class='fa-solid fa-circle-check success_icon'></i> La page a bien été crée </p>";
                }
                foreach ($_POST as $cle => $valeur) {
                    //unset supprime une variable
                    unset($_POST[$cle]);
                }
                break;

            // * <=========================================================>

            case "loadPages":
                if (isset($_GET["id_pages"])) {
                    echo $_GET["id_pages"];

                    $action_form = "modifyPages&id_pages=" . $_GET["id_pages"];
                    $request =
                        "SELECT * FROM pages WHERE id_pages='" .
                        $_GET["id_pages"] .
                        "'";
                    $result = mysqli_query($connexion, $request);
                    $rows = mysqli_fetch_object($result);
                    $_POST["title_pages"] = $rows->title_pages;
                    $_POST["content_pages"] = $rows->content_pages;
                }
                break;

            // * <=========================================================>

            case "modifyPages":
                if (isset($_GET["id_pages"])) {
                    echo $_GET["id_pages"];
                    if (empty($_POST["title_pages"])) {
                        $confirmation =
                            "<p class='warning'><i class='fa-solid fa-triangle-exclamation warning_icon'></i>Le champs titre ne peut être vide </p>";
                    } else {
                        $request =
                            "UPDATE pages SET 
                        title_pages='" .
                            $_POST["title_pages"] .
                            "',
                        content_pages='" .
                            $_POST["content_pages"] .
                            "' WHERE id_pages='" .
                            $_GET["id_pages"] .
                            "'";
                        $result = mysqli_query($connexion, $request);
                        $confirmation =
                            "<p class='success'><i class='fa-solid fa-circle-check success_icon'></i> La page a bien été modifiée </p>";
                    }
                }
                break;

            // * <=========================================================>

            case "deletePages":
                $request =
                    "DELETE FROM pages WHERE id_pages='" .
                    $_GET["id_pages"] .
                    "'";
                $result = mysqli_query($connexion, $request);
                $confirmation =
                    "<p class='success'><i class='fa-solid fa-circle-check success_icon'></i> La page a bien été supprimer </p>";
                break;

            // * <=========================================================>

            case "warningPages":
                if (isset($_GET["id_pages"])) {
                    $confirmation = "<div class='confirm'>";
                    $confirmation .=
                        "<p class='confirm__paragraph'>Êtes vous sûr de vouloir supprimer la page n°" .
                        $_GET["id_pages"] .
                        "</p>";
                    $confirmation .=
                        "<a class='confirm__paragraph_link' href='back.php?action=pages&case=deletePages&id_pages=" .
                        $_GET["id_pages"] .
                        "'>OUI <i class='fa-light fa-check confirm__paragraph_link_icons'></i></a>";
                    $confirmation .=
                        "<a class='confirm__paragraph_link' href='back.php?action=pages'>NON <i class='fa-light fa-xmark confirm__paragraph_link_icons'></i></a></div>";
                }
                break;

            // * <=========================================================>
        }

        // + <=================================================================================================================>
    }
    // ? ==================================================================================================================>

    $request = "SELECT * FROM pages ORDER BY id_pages";
    $result = mysqli_query($connexion, $request);
    $content = "<details class='content__details'>";
    $content .= "<summary class='content__details_summary'>";
    $content .= "<div>ID</div>";
    $content .= "<div>PAGE</div>";
    $content .= "<div></div>";
    $content .= "<div>ACTIONS</div>";
    $content .= "</summary></details>";
    while ($rows = mysqli_fetch_object($result)) {
        $content .= "<details class='content__details'>";
        $content .= "<summary class='content__details_summary'>";
        $content .= "<div class='content__details_summary_items'>$rows->id_pages</div>";
        $content .= "<div class='content__details_summary_items'>$rows->title_pages</div>";
        $content .= "<div class='content__details_summary_items'></div>";
        $content .=
            "<div class='content__details_summary_actions'>
                <a class='content__details_summary_actions_link-modify' href='back.php?action=pages&case=loadPages&id_pages=" .
            $rows->id_pages .
            "' >
                  <i class='fa-solid fa-pen-to-square content__details_summary_actions_link_icon-modify'></i></a>";
        $content .=
            "<a class='content__details_summary_actions_link-trash' href='back.php?action=pages&case=warningPages&id_pages=" .
            $rows->id_pages .
            "'>
                  <i class='fa-solid fa-trash content__details_summary_actions_link_icon-trash'></i></a>";
        $content .= "</summary></details>";
    }
    // ? ==================================================================================================================>
}
