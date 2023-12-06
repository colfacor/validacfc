<?php
//Import PHPMailer classes into the global namespace
//These must be at the top of your script, not inside a function
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;


require 'PHPMailer/src/Exception.php';
require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';

//Create an instance; passing `true` enables exceptions
$mail = new PHPMailer(true);

try {
    //Server settings
    $mail->SMTPDebug = 2;                      //Enable verbose debug output
    $mail->isSMTP();                                            //Send using SMTP
    $mail->Host       = 'ns24.ecohost.la';                     //Set the SMTP server to send through
    $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
    $mail->Username   = '_mainaccount@colfacor.org.ar';                     //SMTP username
    $mail->Password   = ']ws#i^J1AUA)';                               //SMTP password
    $mail->SMTPSecure = 'ssl';            //Enable implicit TLS ssl encryption
    $mail->Port       = 465;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

    //Recipients
    //$mail->setFrom('cfc@validacfc.colfacor.org.ar', 'Colegio de Farmaceuticos');
    //$mail->addAddress('gastondangelo@colfacor.org.ar');     //Add a recipient

     $recipient = $_POST['recipient'];
    $mail->addAddress($recipient);
 

    //Content
    $mail->isHTML(true);                                  //Set email format to HTML
    $mail->Subject = 'Prueba';
    $mail->Body    = 'Prueba</b>';
    

    $mail->send();
    echo 'Enviado Correctamente';
} catch (Exception $e) {
    echo "Error al enviar {$mail->ErrorInfo}";
}