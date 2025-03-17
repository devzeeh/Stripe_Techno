<?php
require_once './stripe-php-10.3.0/stripe-php-10.3.0/init.php';
require_once './config.php';
$stripe = new \Stripe\StripeClient(STRIPE_KEY);

//prepare shopping cart data for stripe
$lineItems = [
    [
        'price_data' => [
            'currency' => 'php',
            'product_data' => [
                'name' => 'Electronica',
                'description' => 'High-quality electronic item for sale',
                
            ],
            //'images' => 'https://example.com/images/t-shirt.png',
            'unit_amount' => 1000 * 100, //convert to cents example 100*100 = 100.00 in stripe
        ],
        'quantity' => 1,
    ]
];

//create Stripe Checkout session
$checkout_session = $stripe->checkout->sessions->create([
    'payment_method_types' => ['card'],
    'line_items' => $lineItems,
    'mode' => 'payment',
    'customer_email' => 'test@test.com',
    //'billing_address_collection' => 'auto', //collect billing address from customer optional
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

