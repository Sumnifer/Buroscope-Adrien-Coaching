<?php
$connexion = connexion();

$form_action = "../front/front.php?action=newsletters";
if (!empty($_POST['email_newsletters'])){
    $request = "INSERT INTO newsletters SET 
                            email_newsletter = '" . $_POST['email_newsletters'] . "'";
    $result = mysqli_query($connexion, $request);
    if ($result) {
        $confirmation = "<p class='success'>Votre email a bien été enregistré</p>";
    } else {
        $confirmation = "<p class='warning'>Votre email n'a pas été enregistré</p>";
    }
}
    foreach($_POST as $key => $value){
        unset($_POST[$key]);
    }

header("Location: ../index.php");