<?php
require_once './stripe-php-16.6.0/init.php';
require './config/config.php';
$stripe = new \Stripe\StripeClient(STRIPE_KEY);

//product price and processing fee calculation
//$price = 1000; //price of product
//$process = 10; //2.9% + 30 cents processing fee rounded to 2 decimal places
$price = 0; //price of product
$process = round($price * 2/100, 2); //2.9% + 30 cents processing fee rounded to 2 decimal places

//prepare shopping cart data for stripe
$lineItems = [
    [
        'price_data' => [
            'currency' => 'php',
            'product_data' => [
                'name' => 'CARDS',
                'description' => 'Card Reloading Payment',  
                'images' => ['https://img.freepik.com/free-vector/paper-money-dollar-bills-blue-credit-card-3d-illustration-cartoon-drawing-payment-options-3d-style-white-background-payment-finances-shopping-banking-commerce-concept_778687-724.jpg?t=st=1742172544~exp=1742176144~hmac=928dbca129fbf676bf9fdc49187f4553c41f4978c895fdbc5b83d569ce013999&w=740'],
            ],
            'unit_amount' => $price * 100, //convert to cents example 100*100 = 100.00 in stripe
        ],
        'quantity' => 1,
    ],

    //processing fee
    [
        'price_data' => [
            'currency' => 'php',
            'product_data' => [
                'name' => 'Processing Fee',
                'description' => 'Payment Processing Fee',
                //'images' => ['https://img.freepik.com/free-vector/paper-money-dollar-bills-blue-credit-card-3d-illustration-cartoon-drawing-payment-options-3d-style-white-background-payment-finances-shopping-banking-commerce-concept_778687-724.jpg?t=st=1742172544~exp=1742176144~hmac=928dbca129fbf676bf9fdc49187f4553c41f4978c895fdbc5b83d569ce013999&w=740'],
            ],
            'unit_amount' => $process * 100, //convert to cents example 100*100 = 100.00 in stripe
        ],
        'quantity' => 1,
    ],
    
];//end of lineItems

//create Stripe Checkout session
$checkout_session = $stripe->checkout->sessions->create([
    'payment_method_types' => ['card'],
    'line_items' => $lineItems,
    'mode' => 'payment',//
    'customer_email' => 'test@test.com',//auto collect email from customer
    //'billing_address_collection' => 'auto', //collect billing address from customer optional
    'success_url' => 'http://localhost/Github%20Techno/Techno/checkout-success.php?provider_session_id={CHECKOUT_SESSION_ID}&show_popup=true',
    'cancel_url' => 'http://localhost/Github%20Techno/Techno/cart.php',
]);

//retrieve provider_session_id. store it in database.
$checkout_session->id;

//send user to stripe
header('Content-Type: application/json');
header("HTTP/1.1 303 See Other");
header("Location: " . $checkout_session->url);
exit();

