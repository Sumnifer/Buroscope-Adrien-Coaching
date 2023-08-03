<?php
session_start();
global $connexion;
$cart = "";
$cartExist = "";
$title = "<ul class='cart__container_list'>";
if (isset($_SESSION['id_users']) && $_SESSION['id_users'] != "") {
    if (isset($_GET['case']) && $_GET['case'] != "") {
        switch ($_GET['case']) {
            case "show":
                $request = "SELECT * FROM temporary_schedules AS ts INNER JOIN prestations AS p ON ts.prestation_schedules = p.id_prestations WHERE ts.id_users = " . $_SESSION['id_users'] . " ORDER BY ts.id";
                $result = mysqli_query($connexion, $request);
                if (mysqli_num_rows($result) > 0) {
                    $cartExist = true;
                    while ($rows = mysqli_fetch_object($result)) {
                        $title .= "<li class='cart__container_list_items'><p>Formule : " . $rows->title_prestations . "</p><p style='font-weight: bold'>" . $rows->price_prestations . "€</p></li>";
                        $cart .= "<div class='cart__container_bloc_content'>";
                        $cart .= "<div class='cart__container_bloc_content_header'><p>Formule : " . $rows->title_prestations . "</p>";
                        $cart .= "<p>Date :  " . $rows->date_schedules . "</p></div>";
                        $cart .= "<p class='cart__container_bloc_content_price'><a href='#' class='cart__container_bloc_content_price_link' data-id='" . $rows->id . "'><i class='fa-solid fa-trash'></i></a>" . $rows->price_prestations . "€</p></div>";
                    }
                } else {
                    $cartExist = false;
                    $cart .= "<p style='color: white; font-size: 2rem; text-align: center'>Votre panier est terriblement vide.</p>";
                    $cart .= "<a href='front.php?action=calendar' class='cart__container_cta' style='width: 50%; align-self: center; font-size: .8rem'>Je réserve ma séance.</a>";
                }
                $title .= "</ul>";
                $sumRequest = "SELECT SUM(price_prestations) AS sum FROM temporary_schedules WHERE id_users = " . $_SESSION['id_users'];
                $result = mysqli_query($connexion, $sumRequest);
                $row = mysqli_fetch_assoc($result);
                if ($row) {
                    $sumValue = $row['sum'];
                }

                break;
            case "save":

                break;
        }
    }
} ?>

<section class="cart">
    <div class="cart__container">
        <h1 class="cart__container_title">Mon Panier</h1>
        <div class="cart__container_bloc">
            <?php if (isset($cart) && $cart != "") {
                echo $cart;
            } ?>
        </div>
    </div>
    <div class="cart__container">
        <h1 class="cart__container_title">Récapitulatif</h1>
        <?php if (isset($title) && $title != "") {
            echo $title;
        } ?>
        <div class="cart__container_total"><p>Total : </p>
            <p><?php if (isset($sumValue) && $sumValue != "") {
                    echo $sumValue;
                } ?>€</p></div>
        <?php
        if ($cartExist) {
            echo '<form action="https://bennyb35.fr/adrien-coaching/front/stripe/create-checkout-session.php" method="POST">
              <input type="hidden" name="sum" value="' . $sumValue . '">
              <button type="submit" class="cart__container_cta">Procéder au Paiement</button>
          </form>';
        } else {
            echo '<form action="https://bennyb35.fr/adrien-coaching/front/stripe/create-checkout-session.php" method="POST">
              <input type="hidden" name="sum" value="' . $sumValue . '">
              <button type="submit" class="cart__container_cta" disabled>Procéder au Paiement</button>
          </form>';
        }
        ?>

    </div>

</section>

<script>
    // Fonction pour supprimer la ligne via AJAX et actualiser le panier
    function removeItemFromCart(itemId) {
        // Créez une instance d'XMLHttpRequest
        let xhr = new XMLHttpRequest();
        xhr.onreadystatechange = function () {
            if (xhr.readyState === 4) {
                if (xhr.status === 200) {
                    window.location.reload();
                    // Ici vous pouvez appeler la fonction pour actualiser le panier
                    // en récupérant les nouvelles données avec une autre requête AJAX
                } else {
                    alert("Une erreur s'est produite lors de la suppression.");
                }
            }
        };

        // L'ID de l'élément à supprimer est passé en tant que paramètre dans la requête GET
        xhr.open("GET", "sections/updateCart.php?id=" + itemId, true);
        xhr.send();
    }

    // Événement de clic sur le lien de suppression
    let removeLinks = document.getElementsByClassName("cart__container_bloc_content_price_link");
    for (let i = 0; i < removeLinks.length; i++) {
        removeLinks[i].addEventListener("click", function () {
            let itemId = this.getAttribute("data-id");
            removeItemFromCart(itemId);
        });
    }
</script>