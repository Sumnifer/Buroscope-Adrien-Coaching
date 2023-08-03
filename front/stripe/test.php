<?php
session_start();
require "../../tools/fonctions.php";
require "../../vendor/stripe/stripe-php/init.php";
require "secrets.php";
$connexion = connexion();
$stripe = new \Stripe\StripeClient($stripeSecretKey);
$request = "SELECT * FROM temporary_schedules AS ts INNER JOIN prestations p ON p.id_prestations = ts.prestation_schedules ORDER BY ts.id ASC";
$result = mysqli_query($connexion, $request);
$cartItems = [];

// Tableau contenant les produits du panier (vous pouvez le récupérer à partir de la base de données)
while ($rows = mysqli_fetch_object($result)) {
    $cartItems[] = [
        'product_id' => $rows->id, // Vous devez fournir l'ID du produit ici
        'name' => 'Formule ' . $rows->title_prestations,
        'amount' => $rows->price_prestations * 100, // Convertir le montant en centimes
        'quantity' => 1, // Quantité du produit dans le panier (vous pouvez ajuster la quantité au besoin)
    ];
}


$lineItems = [];

foreach ($cartItems as $item) {
    $lineItems[] = [
        'price_data' => [
            'currency' => 'eur',
            'product_data' => [
                'name' => $item['name'], // Nom du produit
                'metadata' => [
                    'product_id' => $item['product_id'], // Ajoutez l'ID du produit ici
                ],
            ],
            'unit_amount' => $item['amount'], // Montant du produit en centimes
        ],
        'quantity' => $item['quantity'], // Quantité du produit dans le panier
    ];
}

// Créez la session de paiement avec tous les produits dans le panier
$checkout_session = $stripe->checkout->sessions->create([
    'line_items' => $lineItems,
    'mode' => 'payment',
    'success_url' => 'http://localhost/Buroscope-Adrien-Coaching/front/sections/successCart.php?session_id={CHECKOUT_SESSION_ID}', // Remplacez {CHECKOUT_SESSION_ID} par la variable appropriée dans votre intégration
    'cancel_url' => 'http://localhost/Buroscope-Adrien-Coaching/front/front.php?action=cart&case=show',
    'client_reference_id' => $_SESSION['id_users'], // Stocke l'ID de l'utilisateur dans la session de paiement
]);

header("HTTP/1.1 303 See Other");

// Récupérez l'ID de session de paiement généré par Stripe
$checkout_session_id = $checkout_session->id;

// Remplacez {CHECKOUT_SESSION_ID} par l'ID de session de paiement dans l'URL
$redirect_url = str_replace('{CHECKOUT_SESSION_ID}', $checkout_session_id, $checkout_session->url);

header("Location: " . $redirect_url);
?>
