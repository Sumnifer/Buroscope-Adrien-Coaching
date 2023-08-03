<?php
session_start();
require "../../tools/fonctions.php";
$connexion = connexion();

// Récupérez l'ID de session de Stripe depuis les paramètres de requête
$stripe_session_id = $_GET['session_id'];

// Vérifiez si l'ID de session est défini et non vide
if (!empty($stripe_session_id)) {
    require "../../vendor/stripe/stripe-php/init.php";
    require"../stripe/secrets.php";
    $stripe = new \Stripe\StripeClient($stripeSecretKey);

    try {
        // Récupérez les détails de la session de paiement auprès de Stripe
        $session = $stripe->checkout->sessions->retrieve($stripe_session_id);

        // Vérifiez si le statut de la session est "paid"
        if ($session->payment_status === 'paid') {
            // Le paiement a été effectué avec succès, effectuez les actions nécessaires ici
            // Par exemple, insérer les données de commande dans la table des commandes

            $request = "SELECT * FROM temporary_schedules WHERE id_users = " . $_SESSION['id_users'];
            $result = mysqli_query($connexion, $request);
            while ($rows = mysqli_fetch_object($result)) {
                $save = "INSERT INTO schedules (date_schedules, id_users, hours_schedules, prestation_schedules, paid_prestations) 
                                                    VALUES (?, ?, ?, ?, 1)";
                $stmt = mysqli_prepare($connexion, $save);
                if ($stmt) {
                    mysqli_stmt_bind_param($stmt, "sisi", $rows->date_schedules, $rows->id_users, $rows->hours_schedules, $rows->prestation_schedules);
                    mysqli_stmt_execute($stmt);
                    mysqli_stmt_close($stmt);
                } else {
                    echo "Une erreur s'est produite lors de la préparation de la requête.";
                }
            }

            $drop = "DELETE FROM temporary_schedules WHERE id_users = " . $_SESSION['id_users'];
            $dropped = mysqli_query($connexion, $drop);
            header("Location: ../front.php?action=account&case=index");
            exit; // Assurez-vous de terminer l'exécution du script ici pour éviter tout traitement supplémentaire non souhaité
        } else {
            echo "Le paiement n'a pas été effectué avec succès.";
        }
    } catch (\Stripe\Exception\ApiErrorException $e) {
        echo "Une erreur s'est produite lors de la récupération des détails de la session de paiement : " . $e->getMessage();
    }
} else {
    echo "ID de session de paiement manquant dans les paramètres de requête.";
}
?>

