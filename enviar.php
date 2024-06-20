<?php
use PHPMailer\PHPMailer\{PHPMailer, SMTP, Exception};



require 'phpmailer/src/PHPMailer.php';
require 'phpmailer/src/SMTP.php';
require 'phpmailer/src/Exception.php';

$mail = new PHPMailer(true);

try {
    //Server settings
    $mail->SMTPDebug = SMTP::DEBUG_SERVER;                      //Enable verbose debug output
    $mail->isSMTP();                                            //Send using SMTP
    $mail->Host       = 'smtp.gmail.com';                     //Set the SMTP server to send through
    $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
    $mail->Username   = 'smarttecno674@gmail.com';                     //SMTP username
    $mail->Password   = 'vgtecnosmart-';                               //SMTP password
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            //Enable implicit TLS encryption
    $mail->Port       = 465;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

    //Recipients
    $mail->setFrom('smarttecno674@gmail.com', 'TecnoSmart');
    $mail->addAddress('cheloquinchagual@gmail.com', 'Exland');     //Add a recipient

    //Content
    $mail->isHTML(true);                                  //Set email format to HTML
    $mail->Subject = 'Here is the subject';

    $cuerpo = "<h4>¡GRACIAS POR SU COMPRA!</h4>"
    $cuerpo = '<p> El id de su compra es <b>'.$idTransaccion .'</b></p>';

    $mail->Body = utf8_decode($cuerpo);
    $mail->AltBody = 'Le enviamos los detalles de su compra';

    $mail->setLenguage('es', '../phpmailer/lenguage/phpmailer.lang-es.php');

    $mail->send();

} catch (Exception $e) {
    echo "Error al enviar el correo de la compra: {$mail->ErrorInfo}";
}