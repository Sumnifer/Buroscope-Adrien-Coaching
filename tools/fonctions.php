<?php

function connexion()
{
    require_once "connect.php";
    $connexion = mysqli_connect(SERVEUR, LOGIN, PASSE, BASE);
    if (!$connexion) {
        die("Erreur de connexion: " . mysqli_connect_error());
    }
    return $connexion;
}

function login($login, $pass)
{
    $connexion = connexion();
    $requete = "SELECT * FROM users WHERE email_users=?";
    $stmt = mysqli_prepare($connexion, $requete);
    mysqli_stmt_bind_param($stmt, 's', $login);
    mysqli_stmt_execute($stmt);
    $resultat = mysqli_stmt_get_result($stmt);
    $nb_ligne = mysqli_num_rows($resultat);
    if ($nb_ligne == 1) {
        $ligne = mysqli_fetch_object($resultat);
        $hashed_pass = password_verify($pass, $ligne->pass_users);
        if ($hashed_pass) {
            $_SESSION["id_users"] = $ligne->id_users;
            $_SESSION["name_users"] = $ligne->name_users;
            $_SESSION["surname_users"] = $ligne->surname_users;
            $_SESSION["email_users"] = $ligne->email_users;
            $_SESSION["statut_users"] = $ligne->statut_users;
            if ($ligne->statut_users == "root"){
                header("location: ../back/back.php");
            }else {
                header("location: ../front/front.php?action=index");
            }
        }
    }
    mysqli_close($connexion);
}

//function login($login, $pass)
//{
//    $connexion = connexion();
//
//    // Vérifier le nombre de tentatives de connexion pour l'adresse e-mail de l'utilisateur dans les 5 dernières minutes
//    $request =
//        "SELECT COUNT(*) AS attempts_logins FROM logins WHERE email_logins = ? AND timestamp_logins > DATE_SUB(NOW(), INTERVAL 5 MINUTE)";
//    $stmt = mysqli_prepare($connexion, $request);
//    mysqli_stmt_bind_param($stmt, "s", $login);
//    mysqli_stmt_execute($stmt);
//    $result = mysqli_stmt_get_result($stmt);
//    $attempts_logins = mysqli_fetch_object($result)->attempts_logins;
//
//    if ($attempts_logins >= 3) {
//        // L'utilisateur a dépassé le nombre maximum de tentatives de connexion
//        echo "Vous avez dépassé le nombre maximum de tentatives de connexion. Veuillez réessayer dans quelques minutes.";
//        return;
//    }
//
//    // Vérifier le mot de passe de l'utilisateur
//    $request = "SELECT * FROM users WHERE email_users=?";
//    $stmt = mysqli_prepare($connexion, $request);
//    mysqli_stmt_bind_param($stmt, "s", $login);
//    mysqli_stmt_execute($stmt);
//    $result = mysqli_stmt_get_result($stmt);
//    $row = mysqli_num_rows($result);
//
//    if ($row == 1) {
//        $rows = mysqli_fetch_object($result);
//        $hashed_pass = password_verify($pass, $rows->pass_users);
//        if ($hashed_pass) {
//            // Enregistrer la tentative de connexion réussie
//            // Enregistrer la tentative de connexion réussie
//            $request =
//                "INSERT INTO logins (email_logins, timestamp_logins, attempts_logins) VALUES (?, NOW(), 0) ON DUPLICATE KEY UPDATE timestamp_logins = NOW(), attempts_logins = attempts_logins + 1";
//            $stmt = mysqli_prepare($connexion, $request);
//            mysqli_stmt_bind_param($stmt, "s", $login);
//            mysqli_stmt_execute($stmt);
//            $_SESSION["id_users"] = $rows->id_users;
//            $_SESSION["name_users"] = $rows->name_users;
//            $_SESSION["surname_users"] = $rows->surname_users;
//            $_SESSION["email_users"] = $rows->email_users;
//            $_SESSION["statut_users"] = $rows->statut_users;
//            if ($rows->statut_users == "root") {
//                header("location: ../back/back.php");
//            } else {
//                header("location: ../front/front.php?action=index");
//            }
//        }
//    }
//}
