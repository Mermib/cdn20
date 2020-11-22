<?php

require_once(__DIR__ . '/Includes/Paypal/Paypal.php');

$price = json_decode(file_get_contents('php://input'), true);

if(doubleval($price['price']) < 100)
{
    echo (json_encode([
        'status' => false,
        'message' => 'El monto es menor que 100'
    ]));
}
else
{
    $response = Paypal::CreatePayment(doubleval($price['price']));
    echo (json_encode([
        'status' => true,
        'message' => $response
    ]));
}