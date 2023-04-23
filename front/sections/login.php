<?php
if (isset($_POST["submit"])) {
    if (!empty($_POST["email"]) && !empty($_POST["password"])) {
        login($_POST["email"], $_POST["password"]);
    } else {
        $confirmation = "<p class=\"warning\" style='margin-inline: 10%'><i class=\"fa-solid fa-circle-exclamation error_icon\" style='margin-right: 0.5rem;'></i>Vous devez remplir tous les champs !</p>";
    }
} ?>
<main class="login_body">
    <section class="login">
        <h2 class="login__title">J'ai déjà un compte !</h2>
        <form
            name="form_login"
            id="form_login"
            method="POST"
            action="front.php?action=logging"
            class="login__form"
        >
        <?php if (isset($confirmation)){echo $confirmation;} ?>
            <label for="email" class="login__form_label">Email</label>
            <input
                type="email"
                name="email"
                id="email"
                placeholder="Email"
                value="<?php if (isset($_POST["email"])) {
                    echo $_POST["email"];
                } ?>"
                class="login__form_input"
            />
            <label for="password" class="login__form_label">Mot de Passe</label>
            <input
                onfocus="this.type='password';"
                name="password"
                id="password"
                placeholder="Mot de Passe"
                class="login__form_input"
            />
            <a href="#" class="login__form_reset">Mot de passe oublié ?</a>
            <input
                type="submit"
                value="me connecter"
                name="submit"
                class="login__form_cta"
            />
        </form>
    </section>
    <section class="signup">
        <h2 class="signup__title">Je n'ai pas de Compte !</h2>
        <a href="front.php?action=inscription" class="signup__cta">Créer mon compte</a>
    </section>

<section class="google">
    <a href="#" class="google__title">Me connecter avec Google</a>
    <i class="fa-brands fa-google google__icon"></i>
</section>
</main>
