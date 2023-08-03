<?php
if (isset($_SESSION["id_users"])) {
    $title = "Mon compte";
    $action_form = "accountForm";
    $connexion = connexion();

    $request =
        "SELECT * FROM users WHERE id_users ='" . $_SESSION["id_users"] . "'";
    $result = mysqli_query($connexion, $request);
    $rows = mysqli_fetch_object($result);

    if (isset($_GET["case"])) {
        switch ($_GET["case"]) {
            case "updateUsers":
                if (!empty($_POST["phone"])) {
                    $request =
                        "UPDATE users SET phone_users = '" .
                        $_POST["phone"] .
                        "' WHERE id_users = '" .
                        $_SESSION["id_users"] .
                        "'";
                    $result = mysqli_query($connexion, $request);
                    $confirmation =
                        "<p class='success confirmation'><i class='fa-solid fa-circle-check success_icon'></i>Votre numéro de téléphone a bien été modifié</p>";
                    unset($_POST["phone"]);
                    header("Refresh: 2; url=front.php?action=account");
                } elseif (
                    !empty($_POST["email"]) &&
                    $_POST["email"] == $_POST["emailConfirm"]
                ) {
                    $mail = $_POST["email"];
                    $request =
                        "UPDATE users SET email_users = '$mail' WHERE id_users = '" .
                        $_SESSION["id_users"] .
                        "'";
                    $result = mysqli_query($connexion, $request);
                    $confirmation =
                        "<p class='success confirmation'><i class='fa-solid fa-circle-check success_icon'></i>Votre adresse email a bien été modifiée</p>";
                    header("Refresh: 2; url=front.php?action=account");
                } elseif (!empty($_POST["oldPassword"])) {
                    if (
                        !empty($_POST["newPassword"]) &&
                        !empty($_POST["confirmPassword"])
                    ) {
                        if (
                            $_POST["newPassword"] == $_POST["confirmPassword"]
                        ) {
                            $request =
                                "SELECT pass_users FROM users WHERE id_users = '" .
                                $_SESSION["id_users"] .
                                "'";
                            $result = mysqli_query($connexion, $request);
                            $rows = mysqli_fetch_object($result);
                            $oldPassword = htmlspecialchars(
                                $_POST["oldPassword"],
                                ENT_QUOTES,
                                "UTF-8"
                            );
                            $newPassword = password_hash(
                                htmlspecialchars(
                                    $_POST["newPassword"],
                                    ENT_QUOTES,
                                    "UTF-8"
                                ),
                                PASSWORD_DEFAULT
                            );
                            if (
                                password_verify($oldPassword, $rows->pass_users)
                            ) {
                                $request1 =
                                    "UPDATE users SET pass_users = '$newPassword' WHERE id_users = '" .
                                    $_SESSION["id_users"] .
                                    "'";
                                $result1 = mysqli_query($connexion, $request1);
                                $confirmation =
                                    "<p class='success confirmation'><i class='fa-solid fa-circle-check success_icon'></i>Votre mot de passe a bien été modifiée</p>";
                                header(
                                    "Refresh: 2; url=front.php?action=account"
                                );
                            } else {
                                $confirmation =
                                    "<p class='warning confirmation'><i class='fa-solid fa-triangle-exclamation warning_icon'></i>Mot de passe incorrect ! </p>";
                                header(
                                    "Refresh: 2; url=front.php?action=account"
                                );
                            }
                        }
                    } else {
                        $confirmation =
                            "<p class='warning confirmation'><i class='fa-solid fa-triangle-exclamation warning_icon'></i> Veuillez remplir tous les champs</p>";
                    }
                }
                break;
            case 'index':
                include "accountInfos.php";
                break;
            case 'accountSchedules':
                $today = date("Y-m-d")." 00:00:00";
                $request="SELECT * FROM schedules  AS s INNER JOIN prestations p ON s.prestation_schedules = p.id_prestations WHERE s.date_schedules >= '$today' AND s.id_users = '".$_SESSION["id_users"]."' ORDER BY s.date_schedules ASC";
                $result=mysqli_query($connexion,$request);
                $request2="SELECT * FROM schedules  AS s INNER JOIN prestations p ON s.prestation_schedules = p.id_prestations WHERE s.date_schedules < '$today' AND s.id_users = ".$_SESSION["id_users"]." ORDER BY s.date_schedules ASC";
                $result2=mysqli_query($connexion,$request2);
                include "accountSchedules.php";
                break;
        }
    }

} else {
    header("Location: front.php?action=logging");
}

