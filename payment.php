<?php

require_once(__DIR__ . '/Includes/vendor/autoload.php');
require_once(__DIR__ . '/Includes/Config.php');

$json = json_decode(file_get_contents('php://input'));
$price = $json->price;

if(doubleval($price) < 100)
{
    echo (json_encode([
        'status' => false,
        'message' => 'El monto minimo son $100.00'
    ]));
}
else
{
    MercadoPago\SDK::setAccessToken(MP_SECRET);
    $preference = new MercadoPago\Preference();
    $preference->back_urls = [
        "success" => 'http://new.cdn20.com/thankyou.php',
        "failure" => 'http://new.cdn20.com/thankyou.php',
        "pending" => 'http://new.cdn20.com/thankyou.php'
    ];
    $preference->payment_methods = [
        'excluded_payment_types' => [
            [ 'id' => 'digital_wallet' ],
            [ 'id' => 'ticket' ],
            [ 'id' => 'atm' ]
        ]
    ];
    $item = new MercadoPago\Item();
    $item->title = 'Disco Musical';
    $item->quantity = 1;
    $item->unit_price = $price;
    $preference->items = [$item];
    $preference->save();
    echo (json_encode([
        'status' => true,
        'message' => $preference->init_point
    ]));
}