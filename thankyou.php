<?php
require_once(__DIR__ . '/Includes/Paypal/Paypal.php');

$payerId = '';
$paymentId = '';
$code = '';

if(isset($_GET['paymentId']) && isset($_GET['PayerID']))
{
    $payerId = $_GET['PayerID'];
    $paymentId = $_GET['paymentId'];
    $code = Paypal::ExecutePayment($paymentId, $payerId);
}

if(empty($code))
{
    header('Location: http://new.cdn20.com/error.html');
}

?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <title></title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link href="css/style.css" rel="stylesheet">
        <link href="css/fonts.css" rel="stylesheet">
    </head>
    <body>
        <header>
            <img src="" alt="">
        </header>
        <main>
            <h1>¡Muchas Gracias!</h1>

            <div class="text">
                <p>Tu apoyo es muy importante para nosotros, disfruta la música!.</p>
                    <a href="https://www.dropbox.com/sh/at57o2p21l993rl/AAB43_AOAd0S2QLHeOnQNMjva/MUSICA?dl=0&subfolder_nav_tracking=1" target="_blank"><button>Descargar</button></a>         
            </div>
        </main>
    </body>
</html>