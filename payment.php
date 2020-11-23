<?php

require_once(__DIR__ . '/Includes/Paypal/Paypal.php');

$json = json_decode(file_get_contents('php://input'), true);
$price = $json['price'];

if(doubleval($price) < 100)
{
    echo (json_encode([
        'status' => false,
        'message' => 'El monto minimo son $100.00'
    ]));
}
else
{
    $response = Paypal::CreatePayment(doubleval($price));
    echo (json_encode([
        'status' => true,
        'message' => $response
    ]));
}