<?php
if (isset($_SESSION["id_users"])) {
    $connexion = connexion();
    mysqli_set_charset($connexion, "utf8");
    $title = "Gestion des Questions";
    $form = "forms/formQuestions.php";

    if (isset($_GET["case"])) {
        switch ($_GET["case"]) {
            case "newQuestions":
                $action_form = "newQuestions";
                $request = "SELECT COUNT(*) AS nb_questions FROM questions";
                $result = mysqli_query($connexion, $request);
                $rows = mysqli_fetch_object($result);
                $newRank = $rows->nb_questions + 1;
                if (empty($_POST["question_name"])) {
                    $confirmation =
                        "<p class='warning confirmation'><i class='fa-solid fa-circle-exclamation warning_icon'></i> Veuillez entrer une Question </p>";
                } elseif (empty($_POST["question_content"])) {
                    $confirmation =
                        "<p class='warning confirmation'><i class='fa-solid fa-circle-exclamation warning_icon'></i> Veuillez entrer la réponse </p>";
                } elseif (empty($_POST["visibility_question"])) {
                    $confirmation =
                        "<p class='warning confirmation'><i class='fa-solid fa-circle-exclamation warning_icon'></i> Veuillez choisir une visibilité </p>";
                } else {
                    $request = "INSERT INTO questions SET 
              question_name=?,
              question_content=?,
              question_rank=?,
              visibility_question=?";
                    $stmt = mysqli_prepare($connexion, $request);
                    mysqli_stmt_bind_param(
                        $stmt,
                        "ssii",
                        $_POST["question_name"],
                        $_POST["question_content"],
                        $newRank,
                        $_POST["visibility_question"]
                    );
                    $result = mysqli_stmt_execute($stmt);

                    $confirmation =
                        "<p class='success confirmation'><i class='fa-solid fa-circle-check success_icon'></i> La Question a bien été crée </p>";
                    foreach ($_POST as $cle => $valeur) {
                        unset($_POST[$cle]);
                    }
                }
                break;

            case "loadQuestions":
                if (isset($_GET["id"])) {
                    $action_form =
                        "modifyQuestions&id=" .
                        $_GET["id"];
                    $request =
                        "SELECT * FROM questions WHERE id='" .
                        $_GET["id"] .
                        "'";
                    $result = mysqli_query($connexion, $request);
                    $rows = mysqli_fetch_object($result);
                    $_POST["question_name"] = $rows->question_name;
                    $_POST["question_content"] = $rows->question_content;
                    $visibility = $rows->visibility_question;
                }
                break;

            case "modifyQuestions":
                $action_form =
                    "modifyQuestions&id=" .
                    $_GET["id"];
                $id = $_GET["id"];
                $question_name = $_POST["question_name"];
                $question_content = $_POST["question_content"];
                $visibility_question = $_POST["visibility_question"];

                $error = null;

                if (empty($question_name)) {
                    $error .=
                        "<p class='warning confirmation'><i class='fa-solid fa-circle-exclamation error_icon'></i> Veuillez renseigner la Question</p>";
                }
                if (empty($question_content)) {
                    $error .=
                        "<p class='warning confirmation'><i class='fa-solid fa-circle-exclamation error_icon'></i> Veuillez renseigner la réponse</p>";
                }
                if (empty($visibility_question)) {
                    $error .=
                        "<p class='warning confirmation'><i class='fa-solid fa-circle-exclamation error_icon'></i> Veuillez renseigner la visibilité</p>";
                }

                if (empty($error)) {
                    $request = "UPDATE questions SET 
              question_name=?,
              question_content=?,
              visibility_question=?
              WHERE id=?";
                    $stmt = mysqli_prepare($connexion, $request);
                    mysqli_stmt_bind_param(
                        $stmt,
                        "ssii",
                        $question_name,
                        $question_content,
                        $visibility_question,
                        $id
                    );
                    $result = mysqli_stmt_execute($stmt);


                    $confirmation =
                        "<p class='success confirmation'><i class='fa-solid fa-circle-check success_icon'></i> La Question a bien été modifiée </p>";
                } else {
                    $confirmation = $error;
                }
                foreach ($_POST as $cle => $valeur) {
                    unset($_POST[$cle]);
                }
                break;

            case "visibilityQuestions":
                if (isset($_GET["id"])) {
                    if (isset($_GET["visibility"])) {
                        $requete =
                            "UPDATE questions SET visibility_question='" .
                            $_GET["visibility"] .
                            "' WHERE id='" .
                            $_GET["id"] .
                            "'";
                        $resultat = mysqli_query($connexion, $requete);
                        if ($_GET["visibility"] == 1) {
                            $confirmation =
                                "<p class='success confirmation'><i class='fa-solid fa-circle-check success_icon'></i> La Question est désormais visible </p>";
                        }
                        if ($_GET["visibility"] == 2) {
                            $confirmation =
                                "<p class='success confirmation'><i class='fa-solid fa-circle-check success_icon'></i> La Question est désormais invisible </p>";
                        }
                    }
                }

                break;

            case "warningQuestions":
                if (isset($_GET["id"])) {
                    $confirmation = "<div class='confirm'>";
                    $confirmation .=
                        "<p class='confirm__paragraph'><i class='fa-solid fa-triangle-exclamation warning_icon'></i>Êtes vous sûr de vouloir supprimer la Question n°" .
                        $_GET["id"] .
                        "</p>";
                    $confirmation .=
                        "<a class='confirm__paragraph_link' href='back.php?action=questions&case=deleteQuestions&id="
                        . $_GET["id"] . "'>OUI <i class='fa-light fa-check confirm__paragraph_link_icons'></i></a>";
                    $confirmation .=
                        "<a class='confirm__paragraph_link' href='back.php?action=questions'>NON <i class='fa-light fa-xmark confirm__paragraph_link_icons'></i></a></div>";
                }
                break;

            case "deleteQuestions":
                if (isset($_GET["id"])) {

                    $request4 =
                        "DELETE FROM questions WHERE id='" .
                        $_GET["id"] .
                        "'";
                    $result4 = mysqli_query($connexion, $request4);
                    $confirmation =
                        "<p class='success confirmation'><i class='fa-solid fa-circle-check success_icon'></i> La Question a bien été supprimée </p>";

                    $request2 =
                        "SELECT * FROM questions ORDER BY question_rank";
                    $result2 = mysqli_query($connexion, $request2);
                    $i = 1;
                    while ($rows2 = mysqli_fetch_object($result2)) {
                        $request3 =
                            "UPDATE questions SET question_rank='" .
                            $i .
                            "' WHERE id='" .
                            $rows2->id .
                            "'";
                        $result3 = mysqli_query($connexion, $request3);
                        $i++;
                    }
                }
                break;

            case "rankQuestions":
                if (isset($_GET["id"])) {
                    switch ($_GET["direction"]) {
                        case "up":
                            if (isset($_GET["rank"]) && $_GET["rank"] > 1) {
                                $rank = $_GET["rank"] - 1;
                                $requete =
                                    "UPDATE questions SET question_rank='" .
                                    $_GET["rank"] .
                                    "' WHERE question_rank='" .
                                    $rank .
                                    "'";
                                $resultat = mysqli_query($connexion, $requete);
                                $requete2 =
                                    "UPDATE questions SET question_rank='" .
                                    $rank .
                                    "' WHERE id='" .
                                    $_GET["id"] .
                                    "'";
                                $resultat2 = mysqli_query(
                                    $connexion,
                                    $requete2
                                );
                            }
                            break;

                        case "down":
                            $requete =
                                "SELECT count(*) AS nb_questions FROM questions";
                            $resultat = mysqli_query($connexion, $requete);
                            $ligne = mysqli_fetch_object($resultat);
                            if (
                                isset($_GET["rank"]) &&
                                $_GET["rank"] < $ligne->nb_questions
                            ) {
                                $rank = $_GET["rank"] + 1;
                                $requete =
                                    "UPDATE questions SET question_rank='" .
                                    $_GET["rank"] .
                                    "' WHERE question_rank='" .
                                    $rank .
                                    "'";
                                $resultat = mysqli_query($connexion, $requete);
                                $requete2 =
                                    "UPDATE questions SET question_rank='" .
                                    $rank .
                                    "' WHERE id='" .
                                    $_GET["id"] .
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
            case "unloadQuestions":
                $action_form = "newQuestions";
                foreach ($_POST as $cle => $valeur) {
                    unset($_POST[$cle]);
                }
                break;
        }
    }
    $request = "SELECT * FROM questions ORDER BY question_rank";
    $result = mysqli_query($connexion, $request);
    $content = "<details class='content__details'>";
    $content .= "<summary class='content__details_summary'>";
    $content .= "<div class='content__details_summary_heading'>POSITION</div>";
    $content .= "<div class='content__details_summary_heading'>QUESTION</div>";
    $content .= "<div class='content__details_summary_heading'>RÉPONSE</div>";
    $content .= "<div class='content__details_summary_heading'>ACTIONS</div>";
    $content .= "</summary></details>";
    while ($rows = mysqli_fetch_object($result)) {
        $content .= "<details class='content__details'>";
        $content .= "<summary class='content__details_summary'>";
        $content .=
            "<div class='content__details_summary_items'>" .
            $rows->question_rank .
            "<a class='content__details_summary_actions_arrows' href='back.php?action=questions&case=rankQuestions&direction=up&id=" .
            $rows->id .
            "&rank=" .
            $rows->question_rank .
            "'><i class='fa-solid fa-arrow-up '></i></a>" .
            "<a class='content__details_summary_actions_arrows' href='back.php?action=questions&case=rankQuestions&direction=down&id=" .
            $rows->id .
            "&rank=" .
            $rows->question_rank .
            "'><i class='fa-solid fa-arrow-down'></i></a></div>";
        $content .= "<div class='content__details_summary_items'>$rows->question_name</div>";

        $maxLength = 50;
        $content .= "<div class='content__details_summary_items'>" . substr($rows->question_content, 0, $maxLength) . "...</div>";
        $content .= "<div class='content__details_summary_actions'>";
        if ($rows->visibility_question == 1) {
            $content .=
                "<a class='content__details_summary_actions_link-eyes' href='back.php?action=questions&case=visibilityQuestions&visibility=2&id=" .
                $rows->id .
                "' ><i class='fa-solid fa-eye-slash content__details_summary_actions_link_icon-eyes'></i></a>";
        } else {
            $content .=
                "<a class='content__details_summary_actions_link-eyes' href='back.php?action=questions&case=visibilityQuestions&visibility=1&id=" .
                $rows->id .
                "' ><i class='fa-solid fa-eye content__details_summary_actions_link_icon-eyes'></i></a>";
        }
        $content .=
            "<a class='modify content__details_summary_actions_link-modify' href='back.php?action=questions&case=loadQuestions&id=" .
            $rows->id .
            " '><i class='fa-solid fa-pen-to-square content__details_summary_actions_link_icon-modify'></i></a>";
        $content .=
            "<a class='content__details_summary_actions_link-trash' href='back.php?action=questions&case=warningQuestions&id=" .
            $rows->id .
            "'><i class='fa-solid fa-trash content__details_summary_actions_link_icon-trash'></i></a>";
        $content .= "</summary></details>";
    }
}
