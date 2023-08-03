<footer class="footer">
    <div class="footer__box">
        <nav class="footer__box_nav">
            <menu class="footer__box_nav_menu">
                <li class="footer__box_nav_menu_items"><a class="footer__box_nav_menu_items_cta" href="">accueil</a></li>
                <li class="footer__box_nav_menu_items"><a class="footer__box_nav_menu_items_cta" href="#">présentation</a></li>
                <li class="footer__box_nav_menu_items"><a class="footer__box_nav_menu_items_cta" href="">prestation</a></li>
                <li class="footer__box_nav_menu_items"><a class="footer__box_nav_menu_items_cta" href="#">contact</a></li>
            </menu>
        </nav>
        <div class="footer__box_social">
            <i class="fa-brands fa-instagram footer__box_social_icon"></i>
            <i class="fa-brands fa-facebook-f footer__box_social_icon"></i>
            <i class="fa-brands fa-tiktok footer__box_social_icon"></i>
        </div>
    </div>
    <a href="" class="footer__mention">mentions légales</a>
</footer>
<?php
// Démarrez la session


// Mettez à jour $_SESSION['last_activity'] à chaque chargement du footer
$_SESSION['last_activity'] = time();
?>
<script src="../script.js"></script>
<script>
    // Récupérez tous les éléments avec la classe "confirmation"
    // Récupérez tous les éléments avec la classe "confirmation"
    let confirmations = document.querySelectorAll('.confirmation');

    // Pour chaque élément avec la classe "confirmation"
    confirmations.forEach(function(confirmation) {
        // Utilisez la fonction setTimeout pour définir l'opacité de la confirmation sur 0 après 5 secondes
        setTimeout(function() {
            confirmation.style.opacity = 0;
        }, 5000);
        setTimeout(function () {
            confirmation.style.display = 'none';
        }, 5500);
    });

</script>
  </body>
</html>