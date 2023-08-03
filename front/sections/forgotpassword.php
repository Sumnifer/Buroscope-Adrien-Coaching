<?php
$connexion = connexion();
$error = "";
if ((!empty($_POST["email"]))) {
    $email = $_POST["email"];
    $email = filter_var($email, FILTER_SANITIZE_EMAIL);
    $email = filter_var($email, FILTER_VALIDATE_EMAIL);
    $sel_query = "SELECT * FROM `users` WHERE email_users='" . $email . "'";
    $results = mysqli_query($connexion, $sel_query);
    $row = mysqli_num_rows($results);
    if ($row == "") {
        $error .= "<p>Aucun n\'utilisateur n'est enregistré sous cette adresse mail.</p>";
    }
    if ($error != "") {
        echo "<div class='error'>" . $error . "</div>
   <br /><a href='javascript:history.go(-1)'>Retour</a>";
    } else {
        $expFormat = mktime(
            date("H"), date("i"), date("s"), date("m"), date("d") + 1, date("Y")
        );
        $expDate = date("Y-m-d H:i:s", $expFormat);
        $key = md5(2418 * 2 + $email);
        $addKey = substr(md5(uniqid(rand(), 1)), 3, 10);
        $key = $key . $addKey;
// Insert Temp Table
        mysqli_query($connexion,
            "INSERT INTO `password_reset_temp` (`email`, `key`, `expDate`)
VALUES ('" . $email . "', '" . $key . "', '" . $expDate . "');");

        $output = '<p>Cher utilisateur,</p>';
        $output .= '<p>Merci de cliquer sur lien suivant pour créer votre nouveau mot de passe.</p>';
        $output .= '<p>-------------------------------------------------------------</p>';
        $output .= '<p><a href=' . URL . '"front/front.php?action=reset_password?
"key=' . $key . '&email=' . $email . '&action=reset" target="_blank">
http://buroscope-adrien-coaching.test/front/front.php?action=reset_password
?key=' . $key . '&email=' . $email . '&action=reset</a></p>';
        $output .= '<p>-------------------------------------------------------------</p>';
        $output .= '<p>Soyez sûr de copier le lien en entier dans votre navigateur.
                        Ce lien expirera dans 1 jour pour des raisons de sécurité</p>';
        $output .= '<p>Si vous n\'avez pas demander un nouveau mot de passe, vous n\'avez rien à faire, votre mot de passe ne sera pas changé. Cependant, vous devriez vous connectez à votre compte pour changer de mot de passe au cas où quelqu\'un l\'aurait deviné.</p>';
        $output .= '<p>Merci,</p>';
        $output .= '<p>Adrien Coaching</p>';
        $body = $output;
        $subject = "Mot de Passe Oublié - Adrien Coaching";

        $email_to = $email;
        $fromserver = "noreply@adriencoaching.fr";
        require("PHPMailer/PHPMailerAutoload.php");
        $mail = new PHPMailer();
        $mail->IsSMTP();
        $mail->Host = "access948592329.webspace-data.io"; // Enter your host here
        $mail->SMTPAuth = true;
        $mail->Username = "acc1437771143"; // Enter your email here
        $mail->Password = "e:kjeblSKik35!987#"; //Enter your password here
        $mail->Port = 25;
        $mail->IsHTML(true);
        $mail->From = "noreply@adriencoaching.fr";
        $mail->FromName = "Adrien Coaching";
        $mail->Sender = $fromserver; // indicates ReturnPath header
        $mail->Subject = $subject;
        $mail->Body = $body;
        $mail->AddAddress($email_to);
        if (!$mail->Send()) {
            echo "Mailer Error: " . $mail->ErrorInfo;
        } else {
            echo "<div class='error'>
<p>Un email vous a été envoyé avec les instructions pour créer un nouveau mot de passe.</p>
</div><br /><br /><br />";
        }
    }
} else {

    ?>
    <form method="post" action="front.php?action=forgotPassword" name="reset"><br /><br />
        <h2>Mot de passe oublié</h2><br />
        <label for="email"><strong>Entrer votre addresse mail</label><br /><br />
        <input type="email" id="email" name="email" placeholder="email" />
        <br /><br />
        <input type="submit" value="Créer un nouveau mot de passe" />
    </form>
    <p>&nbsp;</p>
    <p>&nbsp;</p>
    <p>&nbsp;</p>
<?php } ?>