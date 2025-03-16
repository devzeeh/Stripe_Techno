<?php
require_once './stripe-php-10.3.0/stripe-php-10.3.0/init.php';

$stripe = new \Stripe\StripeClient('./config.php');

//prepare shopping cart data for stripe
$lineItems = [
    [
        'price_data' => [
            'currency' => 'usd',
            'product_data' => [
                'name' => 'Electronic',
                'description' => 'High-quality electronic item for sale',
            ],
            'unit_amount' => 9.99 * 100, //convert to cents
        ],
        'quantity' => 5,
    ]
];

//create Stripe Checkout session
$checkout_session = $stripe->checkout->sessions->create([
    'payment_method_types' => ['card'],
    'line_items' => $lineItems,
    'mode' => 'payment',
    'success_url' => 'http://localhost/stripe-php-demo/success.php?session_id={CHECKOUT_SESSION_ID}',
    'cancel_url' => 'http://localhost/stripe-php-demo/cancel.php',
]);


//retrieve provider_session_id. store it in database.
$checkout_session->id;

//send user to stripe
header('Content-Type: application/json');
header("HTTP/1.1 303 See Other");
header("Location: " . $checkout_session->url);
exit();

