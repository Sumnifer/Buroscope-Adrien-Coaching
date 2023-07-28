<div class="account_reference">
    <nav class="account__nav">
        <ul class="account__nav_ul">
            <li class="account__nav_ul_li"><a href="front.php?action=index" class="account__nav_ul_li_link"><i class="fa-solid fa-globe account__nav_ul_li_link_icon"></i>Retour</a> <i class="fa-solid fa-chevron-right"></i></li>
            <li class="account__nav_ul_li"><a href="front.php?action=account&case=index" class="account__nav_ul_li_link"><i class="fa-solid fa-user account__nav_ul_li_link_icon"></i>Mes Informations</a> <i class="fa-solid fa-chevron-right"></i></li>
            <li class="account__nav_ul_li"><a href="front.php?action=account&case=accountSchedules" class="account__nav_ul_li_link"><i class="fa-solid fa-dumbbell account__nav_ul_li_link_icon"></i>Mes Séances</a> <i class="fa-solid fa-chevron-right"></i></li>
            <li class="account__nav_ul_li"><a href="front.php?action=account&case=settings" class="account__nav_ul_li_link"><i class="fa-solid fa-gear account__nav_ul_li_link_icon"></i>Paramètres</a> <i class="fa-solid fa-chevron-right"></i></li>
            <li class="account__nav_ul_li"><a href="front.php?action=logout" class="account__nav_ul_li_link"><i class="fa-solid fa-sign-out account__nav_ul_li_link_icon"></i>Deconnexion</a> <i class="fa-solid fa-chevron-right"></i></li>
        </ul>
    </nav>
<section class="account__body">
    <h1 class="account__body_title">Mes informations personnelles</h1>
    <?php if (isset($confirmation)) {
        echo $confirmation;
    } ?>

    <div class="account__body_container-first">
        <h3 class="account__body_container-first_title"><i class="fa-solid fa-user"></i> Informations générales</h3>
        <p class="account__body_container-first_info"><span class="account__body_container-first_info_span"><i class="fa-solid fa-venus-mars"></i> Civilité :</span>
            <?php echo $rows->gender_users; ?>
        </p>
        <p class="account__body_container-first_info"><span class="account__body_container-first_info_span"><i class="fa-solid fa-id-card"></i> Nom :</span>
            <?php echo $rows->surname_users . " " . $rows->name_users; ?>
        </p>

        <p class="account__body_container-first_info"><span class="account__body_container-first_info_span"><i class="fa-solid fa-cake-candles"></i> Dâte de Naissance : </span>
            <?php
            $date_format_fr = date("d/m/Y", strtotime($rows->date_users));
            echo $date_format_fr;
            ?>
        </p>

    </div>
    <form class="account__body_form" action='front.php?action=account&case=updateUsers' name="accountForm" method="post" enctype="multipart/form-data">
        <div class="account__body_container">
            <h3 class="account__body_container_title"><i class="fa-solid fa-address-book"></i> Coordonnées</h3>
            <p class="account__body_container-first_info"><span class="account__body_container-first_info_span"><i class="fa-solid fa-envelope"></i> Adresse Email : </span>
                <?php echo $rows->email_users; ?>
            </p>
            <p class="account__body_container-first_info"><span class="account__body_container-first_info_span"><i class="fa-solid fa-phone"></i> Numéro de Téléphone : </span>
                <?php echo $rows->phone_users; ?>
            </p>
            <h3 class="account__body_container_subtitle"><i class="fa-solid fa-pen"></i>&nbsp; Changer mon numéro de téléphone</h3>
            <label class="account__body_container_label" for="phone">Nouveau numéro de téléphone</label>
            <input type="tel" name="phone" id="phone" class="account__body_container_input"
                   placeholder="Nouveau numéro de téléphone">
            <button class="account__body_container_cta" type="submit">Modifier</button>
            <h3 class="account__body_container_subtitle"><i class="fa-solid fa-pen"></i>&nbsp; Modification de l'adresse email</h3>
            <label class="account__body_container_label" for="email">Nouvelle adresse mail</label>
            <input type="email" name="email" id="email" class="account__body_container_input"
                   placeholder="Nouvelle adresse mail">
            <label class="account__body_container_label" for="emailConfirm">Confirmez la nouvelle adresse email</label>
            <input type="email" name="emailConfirm" id="emailConfirm" class="account__body_container_input"
                   placeholder="Confirmez l'adresse mail">
            <button class="account__body_container_cta" type="submit">Modifier</button>
        </div>

        <div class="account__body_container">
            <h3 class="account__body_container_title"><i class="fa-solid fa-gear"></i> Informations de Connexion</h3>
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
    </form>
</section>
</div>
