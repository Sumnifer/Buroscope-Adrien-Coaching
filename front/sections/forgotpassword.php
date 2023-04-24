<?php

$connexion = new PDO("mysql:host=localhost;connexionname=" . BASE, LOGIN, PASSE);
$message = '';
if (isset($_POST['btn_forgotpassword'])) {
    if (!empty($_POST['forgotPassword'])) {
        $stmt = $connexion->prepare('SELECT COUNT(*) AS nb FROM users WHERE email_users = ?');
        $stmt->bindValue(1, $_POST['forgotPassword']);
        $stmt->execute();

        $ligne = $stmt->fetch(PDO::FETCH_ASSOC);
        if (!empty($ligne) && $ligne['nb'] > 0) {
            $string = implode('', array_merge(range('A', 'Z'), range('a', 'z'), range('0', '9')));
            $token = substr(str_shuffle($string), 0, 20);
            $stmt = $connexion->prepare('UPDATE users SET password_recovery_aked_date = NOW(), password_recovery_token = ? WHERE email = ?');
            $stmt->bindValue(1, $token);
            $stmt->bindValue(2, $_POST['forgotPassword']);
            $stmt->execute();
            $link = 'chemin?token=' . $token;
            $to = $_POST['forgotPassword'];
            $subject = "Réinitialisation de votre mot de passe";
            $message = "<h1>Réinitialisation de votre mot de passe</h1><p> Pour réinitialiser votre mot de passe, veuillez suivre ce lien : <a href=" . $link . ">'$link'</a></p>";
            $header = [];
            $headers[] = 'MINE-Version: 1.0';
            $headers[] = 'Content-type: text/html; chaset=iso-8859-1';
            $headers[] = 'To : ' . $to . '<' . $to . '>';
            $headers[] = 'Adrien Coaching <adriencoachsportif@outlook.fr>';
            mail($to, $subject, $message, implode("\r\n", $headers));
            $message = '<div style="color: green;">Un mail a été envoyé sur votre adresse mail. Veuillez regarder votre boîte mail et suivre les instructions.</div>';
        } else {
            $message = '<div style="color:red;"> Cette adresse mail n\'a pas de compte chez nous.</div>';
        }
    } else {
        $message = '<div style="color:red;">Veuillez spécifier une adresse mail</div>';
    }
}

?>
<main class="password_body">
    <section class="password">
        <h2 class="password__title">Mot de passe oublié</h2>

        <form name="form_password" id="form_password" method="POST" action="front.php?action=forgotPassword"
            class="password__form">
            <div class="password__form_item">
                <label for="forgotPassword" class="password__form_item_label">Votre adresse mail</label>
                <input type="email" id="forgotPassword" name="forgotPassword" placeholder="Adresse mail" value="<?php if (isset($_POSt['email'])) {
                    echo $_POST['email'];
                } ?>" class="password__form_item_input">
            </div>
            <button class="password__form_cta" name="btn_forgotpassword" type="submit">Réinitialiser le mot de
                passe</button>
        </form>
    </section>