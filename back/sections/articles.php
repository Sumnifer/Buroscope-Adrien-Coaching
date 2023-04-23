<?php
if (isset($_SESSION["id_users"])) {
    $connexion = connexion();
    $title = "Gestion des Articles";
    $form = "forms/formArticles.php";
    $action_form = "newArticles";

    if (isset($_GET["case"])) {
        // + <=================================================================================================================>

        switch ($_GET["case"]) {
            // * <=========================================================>

            case "newArticles":
                if (empty($_POST["title_articles"])) {
                    $confirmation =
                        "<p class='warning'><i class='fa-solid fa-triangle-exclamation warning_icon'></i> Veuillez entrer un titre </p>";
                }
                if (empty($_POST["content_articles"])) {
                    $confirmation =
                        "<p class='warning'><i class='fa-solid fa-triangle-exclamation warning_icon'></i> Veuillez entrer du contenu </p>";
                } else {
                    $request =
                        "INSERT INTO articles SET 
                      title_articles='" .
                        $_POST["title_articles"] .
                        "',
                      content_articles='" .
                        $_POST["content_articles"] .
                        "'";
                    $result = mysqli_query($connexion, $request);
                    $confirmation =
                        "<p class='success'><i class='fa-solid fa-circle-check success_icon'></i> L'article a bien été crée </p>";
                }
                foreach ($_POST as $cle => $valeur) {
                    unset($_POST[$cle]);
                }
                break;

            // * <=========================================================>

            case "loadArticles":
                if (isset($_GET["id_articles"])) {
                    $action_form =
                        "modifyArticles&id_articles=" . $_GET["id_articles"];
                    $request =
                        "SELECT * FROM articles WHERE id_articles='" .
                        $_GET["id_articles"] .
                        "'";
                    $result = mysqli_query($connexion, $request);
                    $rows = mysqli_fetch_object($result);
                    $_POST["title_articles"] = $rows->title_articles;
                    $_POST["content_articles"] = $rows->content_articles;
                }
                break;

            // * <=========================================================>

            case "modifyArticles":
                if (isset($_GET["id_articles"])) {
                    echo $_GET["id_articles"];
                    if (empty($_POST["title_articles"])) {
                        $confirmation =
                            "<p class='warning'><i class='fa-solid fa-triangle-exclamation warning_icon'></i>Le champs titre ne peut être vide </p>";
                    } else {
                        $request =
                            "UPDATE articles SET 
                        title_articles='" .
                            $_POST["title_articles"] .
                            "',
                        content_articles='" .
                            $_POST["content_articles"] .
                            "' WHERE id_articles='" .
                            $_GET["id_articles"] .
                            "'";
                        $result = mysqli_query($connexion, $request);
                        $confirmation =
                            "<p class='success'><i class='fa-solid fa-circle-check success_icon'></i> L'article a bien été modifiée </p>";
                    }
                }
                break;

            // * <=========================================================>

            case "deleteArticles":
                $request =
                    "DELETE FROM articles WHERE id_articles='" .
                    $_GET["id_articles"] .
                    "'";
                $result = mysqli_query($connexion, $request);
                $confirmation =
                    "<p class='success'><i class='fa-solid fa-circle-check success_icon'></i> L'article a bien été supprimer </p>";
                break;

            // * <=========================================================>

            case "warningArticles":
                if (isset($_GET["id_articles"])) {
                    $confirmation = "<div class='confirm'>";
                    $confirmation .=
                        "<p class='confirm__paragraph'>Êtes vous sûr de vouloir supprimer l'article n°" .
                        $_GET["id_articles"] .
                        "</p>";
                    $confirmation .=
                        "<a class='confirm__paragraph_link' href='back.php?action=articles&case=deleteArticles&id_articles=" .
                        $_GET["id_articles"] .
                        "'>OUI <i class='fa-light fa-check confirm__paragraph_link_icons'></i></a>";
                    $confirmation .=
                        "<a class='confirm__paragraph_link' href='back.php?action=articles'>NON <i class='fa-light fa-xmark confirm__paragraph_link_icons'></i></a></div>";
                }
                break;

            // * <=========================================================>
        }

        // + <=================================================================================================================>
    }
    $request = "SELECT * FROM articles ORDER BY id_articles";
    $result = mysqli_query($connexion, $request);
    $content = "<details class='content__details'>";
    $content .= "<summary class='content__details_summary'>";
    $content .= "<div>ID</div>";
    $content .= "<div>ARTICLES</div>";
    $content .= "<div>PAGE</div>";
    $content .= "<div>ACTIONS</div>";
    $content .= "</summary></details>";
    while ($rows = mysqli_fetch_object($result)) {
        $content .= "<details class='content__details'>";
        $content .= "<summary class='content__details_summary'>";
        $content .= "<div class='content__details_summary_items'>$rows->id_articles</div>";
        $content .= "<div class='content__details_summary_items'>$rows->title_articles</div>";
        $content .= "<div class='content__details_summary_items'>$rows->page_articles</div>";
        $content .=
            "<div class='content__details_summary_actions'>
                <a class='content__details_summary_actions_link' href='back.php?action=articles&case=loadArticles&id_articles=" .
            $rows->id_articles .
            "' >
                  <i class='fa-solid fa-pen-to-square'></i></a>";
        $content .=
            "<a class='content__details_summary_actions_link' href='back.php?action=articles&case=warningArticles&id_articles=" .
            $rows->id_articles .
            "'>
                  <i class='fa-solid fa-trash'></i></a></div>";
        $content .= "</summary></details>";
    }
}
