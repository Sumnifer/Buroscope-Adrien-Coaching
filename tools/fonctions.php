<?php
function connexion()
{
    try {
        require_once "connect.php";
        return mysqli_connect(SERVEUR, LOGIN, PASSE, BASE);
    } catch (Exception $e) {
        die("Erreur : " . $e->getMessage());
    }

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



//pour le module calendrier
function get_selected($temps, $i)
{
    $selected = "";
    if ($temps == $i){
        $selected = " selected=\"selected\"";
    }
    return $selected;
}


/* Renvoie une string représentant l'appel à une classe CSS
 *
 * Pour les valeurs par défaut :
 *      - 1 : ' class="aut"'
 *      - 2 : ''
 *
 * @param   integer     $jour       Le jour en cours
 * @param   integer     $index      La valeur par défaut de la string
 * @return  string                  La string nécessaire pour appeller la classe CSS voulue
 */
function get_classe($jour, $index, $mode)
{
    switch ($index) {
        case 1:
            $classe = " class=\"aut\"";
            break;
        default:
            $classe = "";
    }
    switch ($mode) {
        case "en":
            $x1 = 0;
            $x2 = 6;
            break;
        default:
            $x1 = 6;
            $x2 = 5;
    }
    if ($jour == $x1){
        $classe = " class=\"dim\"";
    }elseif ($jour == $x2){
        $classe = " class=\"sam\"";
    }
    return $classe;
}


/* Détermine si on est sur un dimanche ou un samedi, à partir du 1er du mois
 *
 * @param   array       $ajd            Le jour, mois et année de maintenant
 * @param   integer     $annee          L'année en cours
 * @param   integer     $mois           Le mois en cours
 * @param   integer     $jour           Le jour en cours
 * @param   integer     $cptJour        Le numéro du jour en cours de la semaine
 * @param   integer     $premierJour    Le numéro du 1er jour (dans la semaine) du mois
 * @param   array       $nomj           Le tableau des noms des jours
 * @param   integer     $prems          Le numéro du dernier jour de la semaine du mois précédent
 * @param   string      $mode           Le mode d'affichage du calendrier ("fr" ou "en")
 * @return  string                      La string nécessaire pour appeller la classe CSS voulue
 */

function get_classeJour($ajd, $annee, $mois, $jour, $cptJour, $premierJour, $nomj, $prems, $mode)
{
    $classe = "";
    if ($mode == "en"){
        if (($cptJour == 0 && $jour > 1) || ($jour == 1 && $premierJour == 0)){
            $classe = " class=\"dim\"";
        }elseif ($cptJour == 6 || (count($nomj) - $jour == $prems)){
            $classe = " class=\"sam\"";
        }
    }else{
        if ($cptJour == 6 || (count($nomj) - $jour == $prems)){
            $classe = " class=\"dim\"";
        }else if ($cptJour == 5 || (count($nomj) - $jour - 1 == $prems)){
            $classe = " class=\"sam\"";
        }
    }
    if ($jour == $ajd[0] && $mois == $ajd[1] && $annee == $ajd[2]){
        $classe = " class=\"ajd\"";
    }
    return $classe;
}


/* Détermine si on est sur un samedi, lorsqu'on complète le tableau
 *
 * @param   integer     $i              Le jour en cours
 * @param   integer     $cptJour        Le numéro du dernier jour (dans la semaine) du mois
 * @param   string      $mode           Le mode d'affichage du calendrier ("fr" ou "en")
 * @return  string                      La string nécessaire pour appeller la classe CSS voulue
 */

function get_classeJourReste($i, $cptJour, $mode)
{
    $classe = "";
    if ($mode == "en"){
        if ($i == (7 - $cptJour) - 1){
            $classe = " class=\"sam\"";
        }
    }else{
        if ($i == (6 - $cptJour) - 1){
            $classe = " class=\"sam\"";
        }else if ($i == (7 - $cptJour) - 1){
            $classe = " class=\"dim\"";
        }
    }
    return $classe;
}
