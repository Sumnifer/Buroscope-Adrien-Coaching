<?php
$connexion = new PDO("mysql:host=localhost;connexionname=" . BASE, LOGIN, PASSE);
$message = '';
if (empty($_GET['token'])) {
    echo 'Veuillez remplir le champ du mot de passe temporaire';
    exit;
}
$query = $connexion->prepare('SELECT date_users_pwd_users FROM users WHERE pwd_reset_token_users = ?');
$query->bindValue(1, $_GET['token']);
$query->execute();
$row = $query->fetch(PDO::FETCH_ASSOC);
if (empty($row)) {
    echo 'Le mot de passe temporaire n\'est pas bon !';
    exit;
}
$datetoken = strtotime('+1 hours', strtotime($row['date_reset_pwd_users']));
$dateToday = time();
if ($datetoken < $dateToday) {
    echo 'Mot de passe expiré !';
    exit;
}
if (!empty($_POST['btn_user_newPassword'])) {
    if (!empty($_POST['user_newPassword']) && !empty($_POST['user_newPasswordconfirm'])) {
        if ($_POST['user_newPassword'] === $_POST['user_newPasswordconfirm']) {
            $password = password_hash($_POST['user_newPassword'], PASSWORD_DEFAULT);
            $req = 'UPDATE users SET pass_users = ?, pwd_reset_token_users = "" WHERE pwd_reset_token_users = ?';
            $query = $connexion->prepare($req);
            echo $req . "************" . $password . "***********" . $_GET['token'];
            $query->bindValue(1, $password);
            $query->bindValue(2, $_GET['token']);
            $query->execute();
            $message = '<div style="color:green;">Le mot de passe a été changé !</div>';
        } else {
            $message = '<div style="color:red;">Les deux mots de passe ne sont pas identiques !</div>';
        }
    } else {
        $message = '<div style="color:red;">Veuillez remplir tous les champs du formulaire !</div>';
    }
}
?>

<main class="reset_body">
<section>
    <h2> Nouveau mot de passe</h2>
    <form name="form_reset" id="form_reset" method="POST" action="front.php?action=resetPassword" class="reset__form">
        <label for="user_newPassword" class="reset__form_label">Votre nouveau mot de passe</label>
        <input type="password" name="user_newPassword" id="user_newPassword" placeholder="Nouveau mot de passe"
            class="reset__form_input">
        <label for="user_newPasswordconfirm" class="reset__form_label">Confirmez votre nouveau mot de passe</label>
        <input type="password" name="user_newPasswordconfirm" id="user_newPasswordconfirm" placeholder="Confirmation"
            class="reset__form_input">
        <button class="reset__form_cta" name="btn_resetpassword" type="submit">Changer le mot de passe</button>
    </form>
</section>