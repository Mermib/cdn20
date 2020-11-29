<?php
require_once(__DIR__ . '/Includes/Paypal/Paypal.php');
require_once(__DIR__ . '/Includes/Bd/Consultas.php');

$payerId = '';
$paymentId = '';
$code = '';
$temporalUrl = 'http://new.cdn20.com/download.php';

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
else
{
    $save = Bd::saveData($code);
    if($save)
    {
        $temporalUrl = sprintf('http://new.cdn20.com/download.php?id=%s', Bd::getUrl($code));
    }
    else
    {
        header('Location: http://new.cdn20.com/error.html');
    }
}
?>

<style>
    .text { text-align:center; }
    button { border: 0;
    background-color: #00425C;
    font-size: 1.8rem;
    color: #ffffff;
    padding: 10px 20px;
    border-radius: 6px;
    width: 200px;
    margin: 0 auto;
    display: block;
    text-decoration: none;}
</style>

<!DOCTYPE html>
<html lang="en">
<head>
        <!--<?php echo Bd::get_client_ip(); ?>-->
        <title>N20 - Gracias</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link href="css/style.css" rel="stylesheet">
        <link href="css/fonts.css" rel="stylesheet">
        <script src="js/vue.min.js"></script>
        <script src="js/axios.min.js"></script>
    </head>
    <body>
        <header>        
            <nav class="topnav container">    
                <div class="logo">
                    <img src="img/logo.png" width="110" alt="Logotipo N20">
                </div>
            </nav>      
        </header>
        <main>
            <h1>¡Muchas Gracias!</h1>

            <div class="text">
                <p>Tu apoyo es muy importante para nosotros, disfruta la música!.</p>
                <p>Disfruta de este CD digital descargandolo en el siguiente link</p>
            
            <p><small style="font-size: 10px;">*Link limitado a un solo uso. Dispones de 30 minutos a partir de ahora para descargar el CD</small></p>
                    <!--a href="/audio/test.zip" target="_blank"><button>Descargar</button></a-->
                    <?php echo "<a href='$temporalUrl'>$temporalUrl</a>" ; ?>         
            </div>
        </main>
        <footer>
            <h4>Patrocinadores</h4>
            <div class="patrocinadores">
                <img src="img/consejodenuevoleon.png" width="155" alt="Logo Consejo de nuevo leon">
                <img src="img/buenavista.png" width="155" alt="Logo Buenavista">
                <img src="img/grazzia-records.png" width="155" alt="Logo Grazzia Records">
                <img src="img/telopresenta.png" width="155"  alt="Logo Telopresenta">
                <img src="img/cemex.png" width="155" alt="Logo Cemex">
                <img src="img/hey-banco.png" width="155"  alt="Logo Hey banco">
                <img src="img/NETFLIX.png" width="155"  alt="Logo Netflix">
            </div>
        </footer>

    </body>
</html>