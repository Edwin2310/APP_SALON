<?php

namespace Classes;

use PHPMailer\PHPMailer\PHPMailer;

class Email
{
    public $email;
    public $nombre;
    public $token;


    public function __construct($email, $nombre, $token)
    {
        $this->email = $email;
        $this->nombre = $nombre;
        $this->token = $token;
    }


    public function enviarConfirmacion()
    {

        //Crear el objeto de email
        $mail = new PHPMailer();
        $mail->isSMTP();

        //CREDENCIAL DE MAILTRAP
        $mail->Host = 'sandbox.smtp.mailtrap.io';
        $mail->SMTPAuth = true;
        $mail->SMTPSecure = 'tls';
        $mail->Port = 2525;
        $mail->Username = '4b1792eca685eb';
        $mail->Password = 'df418a571c5e40';

        $mail->setFrom('aron.martinez@unah.hn'); //Quien lo envia o Remitente
        $mail->addAddress('edwinsin10am@gmail.com', 'AppSalon.com');     //Destinatario
        $mail->Subject = 'Confirma tu cuenta';

        //Set HTML
        $mail->isHTML(TRUE);
        $mail->CharSet = 'UTF-8';
        $contenido = "<html>";
        $contenido .= "<p><strong>Hola " . $this->email . "</strong> Has creado tu cuenta en App 
        Salon, solo debes confirmarla presionando el siguiente enlace: </p>";
        $contenido .= "<p>Presiona aqui: <a href='http://localhost:3000/confirmar-cuenta?token=" . $this->token . "'>Confirmar Cuenta</a></p>";
        $contenido .= "<p>Si tu no solicitaste esta cuenta, puedes ignorar el mensaje.</p>";
        $contenido .= "</html>";
        $mail->Body = $contenido;

        //ENVIAR EL EMAIL
        if ($mail->send() == false) {
            echo "NO SE PUDO ENVIAR EMAIL";
            echo $mail->ErrorInfo;
        } else {
            //echo "Mensaje Enviado Correctamente";
        }
    }



    public function enviarInstrucciones()
    {
        //Crear el objeto de email
        $mail = new PHPMailer();
        $mail->isSMTP();

        //CREDENCIAL DE MAILTRAP
        $mail->Host = 'sandbox.smtp.mailtrap.io';
        $mail->SMTPAuth = true;
        $mail->SMTPSecure = 'tls';
        $mail->Port = 2525;
        $mail->Username = '4b1792eca685eb';
        $mail->Password = 'df418a571c5e40';

        $mail->setFrom('aron.martinez@unah.hn'); //Quien lo envia o Remitente
        $mail->addAddress('edwinsin10am@gmail.com', 'AppSalon.com');     //Destinatario
        $mail->Subject = 'Reestablece tu password';

        //Set HTML
        $mail->isHTML(TRUE);
        $mail->CharSet = 'UTF-8';
        $contenido = "<html>";
        $contenido .= "<p><strong>Hola " . $this->nombre . "</strong> Has solicitado restablecer su contraseña, sigue el siguiente enlace para hacerlo: </p>";
        $contenido .= "<p>Presiona aqui: <a href='http://localhost:3000/recuperar?token=" . $this->token . "'>Reestablecer Contraseña</a></p>";
        $contenido .= "<p>Si tu no solicitaste contraseña, puedes ignorar el mensaje.</p>";
        $contenido .= "</html>";
        $mail->Body = $contenido;

        //ENVIAR EL EMAIL
        if ($mail->send() == false) {
            echo "NO SE PUDO ENVIAR EMAIL";
            echo $mail->ErrorInfo;
        } else {
            //echo "Mensaje Enviado Correctamente";
        }
    }
}
