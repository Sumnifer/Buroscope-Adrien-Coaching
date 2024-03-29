<?php
$class='';
if(isset($_GET['case'])){
    if($_GET['case']=='loadUsers'){
        $class = "form_section_display";
    }
    if($_GET['case']=='unloadUsers'){
        $class = "form_section_display";
    }
}?>
<section class="form_section <?php echo $class ?>" id="userForm">
<form action="back.php?action=users&case=<?php if (isset($action_form)) {
    echo $action_form;
} ?>" method="post" class="users_form" enctype="multipart/form-data">
    <div class="user_form__container">
        <h1 class="presentation__form_div_title">
            <?php
            if ($_GET['case'] == "loadUsers"){
                echo "Modifier un Utilisateur";
            }
            if($_GET['case']=="unloadUsers")
                echo "Ajouter un Utilisateur";
            ?>
        </h1>
    <i class="users_form__container_icon fa-solid fa-xmark" id="closeButton"></i>
    </div>
    <label for="email_users" class="users_form__container_label">Email</label>
    <input type="email" name="email_users" id="email_users" class="users_form__input" placeholder="Email" value="<?php if (
        isset($_POST["email_users"])
    ) {
        echo $_POST["email_users"];
    } ?>">
    <label for="pass_users" class="users_form__container_label">Password</label>
    <input type="password" name="pass_users" id="pass_users" class="users_form__input" placeholder="Password" value="<?php if (
        isset($_POST["pass_users"])
    ) {
        echo $_POST["pass_users"];
    } ?>">
    <label for="gender_users" class="users_form__container_label">Civilité</label>
    <select name="gender_users" id="gender_users" class="users_form__input">
        <option value="">Sélectionnez une civilité</option>
        <option value="Monsieur" <?php if (
            isset($_POST["gender_users"]) &&
            $_POST["gender_users"] == "Monsieur"
        ) {
            echo "selected";
        } elseif (isset($rows) && $rows->gender_users == "Monsieur") {
            echo "selected";
        } ?>>Monsieur</option>
        <option value="Madame" <?php if (
            isset($_POST["gender_users"]) &&
            $_POST["gender_users"] == "Madame"
        ) {
            echo "selected";
        } elseif (isset($rows) && $rows->gender_users == "Madame") {
            echo "selected";
        } ?>>Madame</option>
        <option value="Autre" <?php if (
            isset($_POST["gender_users"]) &&
            $_POST["gender_users"] == "Autre"
        ) {
            echo "selected";
        } elseif (isset($rows) && $rows->gender_users == "Autre") {
            echo "selected";
        } ?>>Autre</option>
    </select>




    <div class="users_form_div">
        <div class="users_form_div_bloc">
            <label for="name_users" class="users_form__container_label">Prénom</label>
            <input type="text" name="name_users" id="name_users" class="users_form__input users_form_div_bloc_input"
                placeholder="Prénom" value="<?php if (
                    isset($_POST["name_users"])
                ) {
                    echo $_POST["name_users"];
                } ?>">
        </div>
        <div class="users_form_div_bloc">
            <label for="surname_users" class="users_form__container_label">Nom</label>
            <input type="text" name="surname_users" id="surname_users"
                class="users_form__input users_form_div_bloc_input" placeholder="Nom" value="<?php if (
                    isset($_POST["surname_users"])
                ) {
                    echo $_POST["surname_users"];
                } ?>">
        </div>
    </div>
    <label for="phone_users" class="users_form__container_label">Téléphone</label>
    <input type="tel" name="phone_users" id="phone_users" class="users_form__input" placeholder="Téléphone" value="<?php if (
        isset($_POST["phone_users"])
    ) {
        echo $_POST["phone_users"];
    } ?>">
    <label for="date_users" class="users_form__container_label">Date de naissance</label>
    <div class="users_form_div">
        <input class="users_form__input" type="date" name="date_users"  id="date_users" min="1901-01-01" value="<?php if (
            isset($_POST["date_users"])
        ) {
            echo $_POST["date_users"];
        } ?>">
    </div>

    <label for="statut_users" class="users_form__container_label">Statut</label>
    <select name="statut_users" id="statut_users" class="users_form__input">
        <option>Sélectionnez un statut</option>
        <option value="user" <?php if (
            isset($_POST["statut_users"]) &&
            $_POST["statut_users"] == "user"
        ) {
            echo "selected";
        } ?>>Utilisateur</option>
        <option value="admin" <?php if (
            isset($_POST["statut_users"]) &&
            $_POST["statut_users"] == "admin"
        ) {
            echo "selected";
        } ?>>Administrateur</option>
        <option value="root" <?php if (
            isset($_POST["statut_users"]) &&
            $_POST["statut_users"] == "root"
        ) {
            echo "selected";
        } ?>>Root</option>
    </select>

    <button type="submit" class="users_form_btn">Enregistrer</button>
</form>
</section>