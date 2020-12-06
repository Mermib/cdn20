<?php

require_once(__DIR__ . '/Includes/Bd/Consultas.php');

$payment_id = '';
$status = '';
$merchant_order_id = '';
$temporalUrl = 'http://new.cdn20.com/download.php';

if( isset($_GET['payment_id']) && isset($_GET['status']) && isset($_GET['merchant_order_id']))
{
    $payment_id = $_GET['payment_id'];
    $status = $_GET['status'];
    $merchant_order_id = $_GET['merchant_order_id'];
}

if($status == 'approved')
{
    $save = Bd::saveData($payment_id, $merchant_order_id);
    $temporalUrl = sprintf('http://new.cdn20.com/download.php?id=%s', Bd::getUrl($payment_id, $merchant_order_id));
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
        <main <?php echo $status == 'approved' ? '' : 'style="display: none;'; ?>>
            <h1>¡Muchas Gracias!</h1>

            <div class="text">
                <p>Tu apoyo es muy importante para nosotros, disfruta la música!.</p>
                <p>Disfruta de este CD digital descargandolo en el siguiente link</p>
            
            <p><small style="font-size: 10px;">*Link limitado a un solo uso. Dispones de 30 minutos a partir de ahora para descargar el CD</small></p>
                    <?php echo "<a href='$temporalUrl'>$temporalUrl</a>" ; ?>         
            </div>
            <div id="email-container">
                <span>Ingresa tu correo</span>
                <input type="email" v-model="email">
                <button @click="sendMail">
                    <div class="spinner" v-if="spinner">
                        <div class="bounce1"></div>
                        <div class="bounce2"></div>
                        <div class="bounce3"></div>
                    </div>
                    <span class="lbl-btn" v-else>Enviar</span>
                </button>
            </div>
        </main>
        <main <?php echo $status == 'approved' ? 'style="display: none;' : ''; ?>>
            <div class="text">
                <p>La transaccion fue rechazada, no se realizo el pago.</p>         
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
        <script>
            new Vue({
                el: '#email-container',
                data: {
                    email: '',
                    link: '<?php echo $temporalUrl; ?>',
                    spinner: false,
                    reg: /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,24}))$/
                },
                methods: {
                    sendMail: function () {
                        this.spinner = true;

                        if(this.email === null || this.email === '' || !this.reg.test(this.email))
                        {
                            alert('El correo es invalido');
                            this.spinner = false;
                        }
                        else
                        {
                            axios.post('/sendMail.php', JSON.stringify({ email: this.email, link: this.link }), {
                            })
                            .then((response) => {
                                alert(response.data.message);
                                this.spinner = false;
                                if(response.data.status)
                                {
                                    this.email = '';
                                }
                            })
                            .catch((ex) => {
                                console.log(ex.message);
                                this.spinner = false;
                            })
                        }
                    }
                }
            })
        </script>
    </body>
</html>