<?php

namespace App;

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;

class Helpers {
    public static function EnviarCorreo($destino, $asunto, $contenido) {
        $remitente = "evalua.pbrnl";
        $passowrd = "*Ev4035*";
        $host = "correo.nl.gob.mx";
        $port = 25;
    
        //Create an instance; passing `true` enables exceptions
        $mail = new PHPMailer(true);
    
        //Server settings
        //$mail->SMTPDebug = SMTP::DEBUG_SERVER;                      //Enable verbose debug output
        $mail->isSMTP();                                            //Send using SMTP
        $mail->Host       = $host;                                  //Set the SMTP server to send through
        $mail->SMTPAuth   = false;                                   //Enable SMTP authentication
        $mail->Username   = $remitente;                             //SMTP username
        $mail->Password   = $passowrd;                              //SMTP password
        $mail->SMTPSecure = "tls";                                  //Enable implicit TLS encryption
        $mail->Port       = $port;                                  //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`
    
        $mail->SMTPOptions = [
            'ssl' => [
                'verify_peer' => false,
                'verify_peer_name' => false,
                'allow_self_signed' => true,
            ]
        ];
        //Content
        $mail->isHTML(true);                                  //Set email format to HTML
        $mail->setFrom("evalua.pbrnl@nl.gob.mx", utf8_decode('Evalúa PbR NL'));
        //Recipients
        $mail->addAddress($destino, $destino);       //Add a recipient
    
        $mail->Subject = utf8_decode($asunto);
        $mail->Body    = utf8_decode($contenido);
    
        return $mail->send();
    }
}



?>