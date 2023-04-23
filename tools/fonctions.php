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
    $requete = "SELECT * FROM users WHERE email_users='" . $login . "'";
    $resultat = mysqli_query($connexion, $requete);
    $nb_ligne = mysqli_num_rows($resultat);
    if ($nb_ligne == 1) {
        $ligne = mysqli_fetch_object($resultat);
        $hashed_pass = PASSWORD_VERIFY($pass, $ligne->pass_users);
        $_SESSION["id_users"] = $ligne->id_users;
        $_SESSION["prenom_users"] = $ligne->prenom_users;
        $_SESSION["nom_users"] = $ligne->nom_users;
        $_SESSION["email_users"] = $ligne->email_users;
        $_SESSION["statut_users"] = $ligne->statut_users;
        if ($ligne->statut_users == "root"){
            header("location: ../back/back.php");
        }else {
            header("location: ../front/front.php?action=index");
        }
    }
    mysqli_close($connexion);
}

