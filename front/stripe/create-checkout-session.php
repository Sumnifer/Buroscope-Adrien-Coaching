<?php
session_start();
require '../../vendor/autoload.php';
require '../../tools/fonctions.php';
require"secrets.php";

$connexion = connexion();
$stripe = new \Stripe\StripeClient($stripeSecretKey);

$request = "SELECT * FROM temporary_schedules AS ts INNER JOIN prestations p ON p.id_prestations = ts.prestation_schedules WHERE ts.id_users = ".$_SESSION['id_users']." ORDER BY ts.id ASC";
$result = mysqli_query($connexion, $request);
$cartItems = [];
while ($rows = mysqli_fetch_object($result)) {
    $name = $rows->title_prestations;
    $cartItems[] = [
        'price_data' => [
            'currency' => 'eur',
            'product_data' => [
                'name' => $name, // Remplacez 'T-shirt' par le nom du produit
            ],
            'unit_amount' => $rows->price_prestations * 100, // Remplacez 2000 par le montant du produit en centimes
        ],
        'quantity' => 1,
    ];
}
try {
    $checkout_session = $stripe->checkout->sessions->create([
        'payment_method_types' => ['card'],
        'line_items' => $cartItems,
        'mode' => 'payment',
        'success_url' => 'https://bennyb35.fr/adrien-coaching/front/sections/successCart.php?session_id={CHECKOUT_SESSION_ID}', // Remplacez l'URL de succès par votre URL
        'cancel_url' => 'https://bennyb35.fr/adrien-coaching/front/front.php?action=cart&case=show', // Remplacez l'URL d'annulation par votre URL
    ]);
} catch (\Stripe\Exception\ApiErrorException $e) {
}
header("HTTP/1.1 303 See Other");
header("Location: " . $checkout_session->url);