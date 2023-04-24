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



