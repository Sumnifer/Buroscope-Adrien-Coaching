<?php
session_start();
require_once("../tools/fonctions.php");
$connexion=connexion();
/**
 * $anneeMin : Permet la selection d'ann�es ant�rieures � celle actuelle (2 = 2 ans ant�rieur)
 * $anneeMax : Permet la s�lection d'ann�es post�rieures � celle actuelle (3 = 3 ans post�rieur)
 */
$anneeMin =0;
$anneeMax = 3;

/**
 * Formatage de la date (par exemple : JJ-MM-AAAA ou JJ|MM|AAAA)
 * $checkzero : ajoute un z�ro devant le mois ou le jour s'ils sont inf�rieur � 10
 *              "false" ou "true"
 * $format    : repr�sente la string qui s�pare le mois du jour de l'ann�e
 * $ordre     : d�termine l'ordre, de gauche � droite, du jour, mois et ann�e
 *              "a" pour ann�e, "m" pour mois, "j" pour jour
 * $affichage : Pour pr�senter le calendrier au format anglais ou fran�ais
 *              "fr" = commencer par lundi ou "en" = commencer par dimanche
 */
$checkzero = "true";
$format = "/";
$ordre = array("j", "m", "a");
$affichage = "fr";


/**
 * Ci-dessous, le nom des mois et des jours. A changer si on veut d'autres langues (ou utiliser
 * la fonction gettext() de PHP. Ne pas changer les positions dans le tableau
 */
$nomj[0] = "D";
$nomj[1] = "L";
$nomj[2] = "M";
$nomj[3] = "Me";
$nomj[4] = "J";
$nomj[5] = "V";
$nomj[6] = "S";

$nomm[0] = "Janvier";
$nomm[1] = "F&eacute;vrier";
$nomm[2] = "Mars";
$nomm[3] = "Avril";
$nomm[4] = "Mai";
$nomm[5] = "Juin";
$nomm[6] = "Juillet";
$nomm[7] = "Ao&ucirc;t";
$nomm[8] = "Septembre";
$nomm[9] = "Octobre";
$nomm[10] = "Novembre";
$nomm[11] = "D&eacute;cembre";

/**
 * Le reste du code PHP, a priori, y'a plus besoin de le toucher. Par contre, y'a la CSS juste
 * un peu plus bas. Celle-l� est parfaitement modifiable (c'est d'ailleurs recommand�, c'est
 * toujours mieux de personnaliser un peu le truc)
 */
$ajd = getdate();
$mois = $ajd['mon'];
$annee = $ajd['year'];


if(isset($_POST['mois']))
	{
	$mois = $_POST['mois'];
	$annee = $_POST['annee'];
	}

//===================================================

$aujourdhui = array($ajd["mday"], $ajd["mon"], $ajd["year"]);

$moisCheck = $mois+1;
$anneeCheck = $annee;
if ($moisCheck > 12)
   {
   $moisCheck=1;
   $anneeCheck=$annee+1;
   }

$dernierJour = strftime("%d", mktime(0, 0, 0, $moisCheck, 0, $anneeCheck));
$premierJour = date("w", mktime(0, 0, 0, $mois, 1, $annee));

if ($affichage != "en"){
    //On modifie la position du premier jour suivant la disposition des jours qu'on veut
    $origine = 1;
    $j = $origine;
    for ($i = 0; $i < count($nomj); $i++){
        if ($j >= count($nomj)){
            $j = 0;
        }
        $temp[] = $nomj[$j];
        $j++;
    }
    $nomj = $temp;
    //On d�cale le 1er jour en cons�quence
    $premierJour--;
    if ($premierJour < 0){
        $premierJour = 6;
    }
}

// Affichage des mois
$ldMois="";
for ($i=0; $i <sizeof($nomm); $i++)
    {
    $selected=get_selected($mois-1, $i);
    $j=$i+1;
    $ldMois.="<option value=" . $j . " $selected>" . $nomm[$i] . "</option>\n";
    }

// Affichage des annees
$ldAnnees="";
for ($i = $ajd["year"] - $anneeMin; $i < $ajd["year"] + $anneeMax; $i++)
    {
    $selected2=get_selected($annee, $i);
    $ldAnnees.="<option value=" . $i . " $selected2>" . $i . "</option>\n";
    }

$calEven="<table id=\"calendar\">\n<tr>\n";

// Affichage du nom des jours
for ($jour = 0; $jour < 7; $jour++)
    {
    $classe = get_classe($jour, 1, $affichage);
    $calEven.="<th $classe>" . $nomj[$jour] . "</th>\n";
    }
$calEven.="</tr>\n<tr>\n";

// Affichage des cellules vides en d�but de mois, s'il y en a
for ($prems = 0; $prems < $premierJour; $prems++)
    {
    $classe = get_classe($prems, 2, $affichage);
    $calEven.="<td $classe>&nbsp;</td>\n";
    }

// Affichage des jours du mois
$cptJour=0;
for ($jour = 1; $jour <= $dernierJour; $jour++)
    {
    $classe = get_classeJour($aujourdhui, $annee, $mois, $jour, $cptJour, $premierJour, $nomj, $prems, $affichage);
    $cptJour++;


    $requete0="SELECT * FROM events WHERE visibility_events='1'";

    $resultat0=mysqli_query($connexion, $requete0);
    $nb=mysqli_num_rows($resultat0);
    if($nb!=0)
      {
      $ligne0=@mysqli_fetch_object($resultat0);

      if($ligne0->link_events!="")// si il y a une url de page vers laquelle pointer
        {
        $lien=" href=\"" . $ligne0->link_events . "\" target=\"_blank\"";//lien externe ou interne
        }
      $calEven.="<a href=''><td " . $classe . "><a " . $lien . " " . $style . "><span data-tip=\"" . $ligne0->titre_evenement . "\">" . $jour . "</span></a></td></a>\n";
      }
    else
      {
      $calEven.="<td " . $classe . "><a href=''>" . $jour . "</a></td>\n";
      }

    if(is_int(($jour + $prems) / 7))
      {
      $cptJour = 0;
      $calEven.="</tr>\n";
      if($jour<$dernierJour)
        {
        $calEven.="<tr>\n";
        }
      }
   }

 //Affichage des cellules vides en fin de mois, s'il y en a
if ($cptJour != 0)
   {
    for($i = 0; $i < (7 - $cptJour); $i++)
       {
       $classe = get_classeJourReste($i, $cptJour, $affichage);
       $calEven.="<td " . $classe . ">&nbsp;</td>\n";
       }
   }
$calEven.="</tr>\n</table>\n";

mysqli_close($connexion);
?>
<section class="calendar">
    <div id="conteneur_calendrier">
        <form id="calendrier" method="POST" action="">
            <select name="mois" id="mois" onChange="document.location.href='';reload(this.form)">
                <?php echo $ldMois; ?>
            </select>
            <select name="annee" id="annee" onChange="document.location.href='';reload(this.form)">
                <?php echo $ldAnnees; ?>
            </select>
        </form>
        <?php echo $calEven; ?>
    </div>
    <div class="schedule">
        <h2 class="schedule__title">Votre Séance</h2>
        <a href="" class="schedule__buttons">sqjkndq</a>
        <a href="" class="schedule__buttons">sqjkndq</a>
        <a href="" class="schedule__buttons">sqjkndq</a>
        <a href="" class="schedule__buttons">sqjkndq</a>
        <a href="" class="schedule__buttons">sqjkndq</a>
        <a href="" class="schedule__buttons">sqjkndq</a>
    </div>
</section>

<script type="text/javascript">
    let checkzero = "<?php if(isset($checkzero)){echo $checkzero;} ?>";
    let format = "<?php echo $format; ?>";
    let ordre = ["<?php echo strtoupper(implode('", "', $ordre)); ?>"];

    /**
     * Reload la fenêtre avec les nouveaux mois et année choisis
     *
     * @param   object      frm     L'object document du formulaire
     */
    function reload(frm){
        let mois = frm.elements["mois"];
        let annee = frm.elements["annee"];
        //Debug du mois et année
        let index1 = mois.options[mois.selectedIndex].value;
        let index2 = annee.options[annee.selectedIndex].value;
        //Envoi du formulaire
        frm.submit();
    }

    /**
     * Ajoute un zéro devant le jour et le mois s'ils sont plus petit que 10
     *
     * @param   integer     jour        Le numéro du jour dans le mois
     * @param   integer     mois        Le numéro du mois
     */
    function checkNum(jour, mois){
        tab = [];
        tab[0] = jour;
        tab[1] = mois;
        if (this.checkzero){
            if (jour < 10){
                tab[0] = "0" + jour;
            }
            if (mois < 10){
                tab[1] = "0" + mois;
            }
        }
        return tab;
    }
</script>
