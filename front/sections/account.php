<?php
if (isset($_SESSION["id_users"])) {
    $title = "Mon compte";
    $action_form = "accountForm";
    $connexion = connexion();

    $request = "SELECT * FROM users WHERE id_users ='" . $_SESSION['id_users'] . "'";
    $result = mysqli_query($connexion, $request);
    $rows = mysqli_fetch_object($result);

    

} else {
    header("Location: front.php?action=logging");
}
?>

<section class="account__body">
    <h1 class="account__body_title">Mes informations personnelles</h1>
    <div class="account__body_container-first">
        <p class="account__body_container-first_info"><span class="account__body_container-first_info_span">Nom :</span>

            <?php echo $rows->surname_users ?>

        </p>
        <p class="account__body_container-first_info"><span class="account__body_containe-first_info_span">Prénom :</span>

            <?php echo $rows->name_users ?>

        </p>
        <p class="account__body_container-first_info"><span class="account__body_container-first_info_span">Email :</span>

            <?php echo $rows->email_users ?>

        </p>
        <p class="account__body_container-first_info"><span class="account__body_container-first_info_span">Téléphone :</span>

            <?php echo $rows->phone_users ?>

        </p>
    </div>
    <h2 class="account__body_title">Changer mes informations personnelles</h2>
    <form class="account__body_form" name="accountForm" method="post" enctype="multipart/form-data">

        <div class="account__body_container">
            <h3 class="account__body_container_title">Changer mon adresse mail</h3>
            <label class="account__body_container_label" for="email">Nouvelle adresse mail</label>
            <input type="email" name="email" id="email" class="account__body_container_input"
                placeholder="Nouvelle adresse mail">
            <label class="account__body_container_label" for="emailConfirm">Confirmez la nouvelle adresse email</label>
            <input type="email" name="emailConfirm" id="emailConfirm" class="account__body_container_input"
                placeholder="Confirmez l'adresse mail">
            <button class="account__body_container_cta" type="submit">Modifier</button>
        </div>

        <div class="account__body_container">
            <h3 class="account__body_container_title">Changer mon mot de passe</h3>
            <label class="account__body_container_label" for="oldPassword">Renseignez votre mot de passe actuel</label>
            <input type="password" name="oldPassword" id="oldPassword" class="account__body_container_input"
                placeholder="Mot de passe actuel">
            <label class="account__body_container_label" for="newPassword">Renseignez votre nouveau mot de passe</label>
            <input type="password" name="newPassword" id="newPassword" class="account__body_container_input"
                placeholder="Nouveau mot de passe">
            <label class="account__body_container_label" for="confirmPassword">Confirmez le nouveau mot de passe</label>
            <input type="password" name="confirmPassword" id="confirmPassword" class="account__body_container_input"
                placeholder="Confirmez le mot de passe">
            <button class="account__body_container_cta" type="submit">Modifier</button>
        </div>

        <div class="account__body_container">
            <h3 class="account__body_container_title">Changer mon numéro de téléphone</h3>
            <label class="account__body_container_label" for="phone">Nouveau numéro de téléphone</label>
            <input type="tel" name="phone" id="phone" class="account__body_container_input"
                placeholder="Nouveau numéro de téléphone">
            <button class="account__body_container_cta" type="submit">Modifier</button>
        </div>
</section>