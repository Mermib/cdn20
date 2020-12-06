<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;
require_once(__DIR__ . '/Includes/PHPMailer/src/Exception.php');
require_once(__DIR__ . '/Includes/PHPMailer/src/PHPMailer.php');
require_once(__DIR__ . '/Includes/PHPMailer/src/SMTP.php');
require_once(__DIR__ . '/Includes/PHPMailer/src/PHPMailer.php');
require_once(__DIR__ . '/Includes/Config.php');
require_once(__DIR__ . '/Includes/Bd/Consultas.php');

/*
function LinkIsUsed($link)
{
    $query = parse_url($link, PHP_URL_QUERY);
    parse_str($query, $output);
    $notUsed = Bd::getBuy($output['id']);
    return $notUsed;
}

function SendMail($email, $link)
{
    $html = file_get_contents("Plantilla.html");
    $html = str_replace('@link', $link, $html);

    $mail = new PHPMailer();
    $mail->IsSMTP();
    $mail->Mailer = "smtp"; 
    $mail->CharSet = 'UTF-8';
    $mail->IsHTML(true);
    $mail->SMTPAuth   = TRUE;
    $mail->SMTPSecure = "ssl";
    $mail->Port       = EMAIL_PORT;
    $mail->Host       = EMAIL_HOST;
    $mail->Username   = EMAIL_USER;
    $mail->Password   = EMAIL_PASS;
    $mail->AddAddress($email);
    $mail->SetFrom(EMAIL_USER);
    $mail->Subject = '¡Muchas gracias por su compra!';
    $mail->Body = '';
    $mail->MsgHTML($html);
    return $mail->Send();
}

$json = json_decode(file_get_contents('php://input'), true);
$email = $json['email'];
$link = $json['link'];

if(LinkIsUsed($link))
{
    if(filter_var($email, FILTER_VALIDATE_EMAIL))
    {
        $send = SendMail($email, $link);
        if($send)
        {
            echo (json_encode([
                'status' => true,
                'message' => 'Se envio correctamente el correo'
            ]));
        }
        else
        {
            echo (json_encode([
                'status' => false,
                'message' => 'Fallo el envio del correo'
            ]));
        }
    }
    else
    {
        echo (json_encode([
            'status' => false,
            'message' => 'El correo es invalido'
        ])); 
    }
}
else
{
    echo (json_encode([
        'status' => false,
        'message' => 'Este link ya fue usado'
    ])); 
}
*/
    try
    {
        $mail = new PHPMailer();
    $mail->IsSMTP();
    $mail->SMTPDebug = 3;
    $mail->SMTPDebug = SMTP::DEBUG_SERVER;
    //$mail->Mailer = 'smtp'; 
    $mail->CharSet = 'UTF-8';
    $mail->IsHTML(true);
    $mail->SMTPAuth   = true;
    $mail->SMTPSecure = 'tls';
    $mail->Port       = 587;
    $mail->Host       = 'nl2020.mx';
    $mail->Username   = 'compra@nl2020.mx';
    $mail->Password   = '+Gel02734*';
    $mail->AddAddress('daeside123@gmail.com');
    $mail->SetFrom('compra@nl2020.mx');
    $mail->Subject = '¡Muchas gracias por su compra!';
    $mail->Body = '';
    $mail->MsgHTML('<html><head></head><body><p>Test</p></body></html>');
    $mail->Send();
    var_dump($mail);
   // var_dump($mail);
    }
    catch(Exception $e)
    {
        var_dump($e);
    }