<?php

namespace Src\App\Classes;

require "./../../libraries/PHPMailer/Exception.php";
require "./../../libraries/PHPMailer/OAuth.php";
require "./../../libraries/PHPMailer/PHPMailer.php";
require "./../../libraries/PHPMailer/POP3.php";
require "./../../libraries/PHPMailer/SMTP.php";

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

class SendMailClass extends AttributesMailClass
{
    public function __construct(AttributesMailClass $attributes)
    {
        $this->to = $attributes->to;
        $this->subject = $attributes->subject;
        $this->message = $attributes->message;
    }

    public function sendMail()
    {
        $mail = new PHPMailer(true);

        try {
            //Server settings
            //$mail->SMTPDebug = SMTP::DEBUG_SERVER;                                    //Enable verbose debug output
            $mail->isSMTP();                                                            //Send using SMTP
            $mail->Host       = 'smtp.freesmtpservers.com';                                       //Set the SMTP server to send through
            $mail->SMTPAuth   = false;                                                   //Enable SMTP authentication
            // $mail->Username   = 'estudosprogramacaojonas@gmail.com';                                                //SMTP username
            // $mail->Password   = 'estudosprogramacao';                                             //SMTP password
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            //$mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;                          //Enable implicit TLS encryption
            $mail->Port       = 25;                                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

            //Recipients
            $mail->setFrom('estudosprogramacaojonas@gmail.com', 'Remetente estudo');
            $mail->addAddress($this->to);                                //Add a recipient
            //$mail->addAddress('ellen@example.com');                                   //Name is optional
            //$mail->addReplyTo('info@example.com', 'Information');
            //$mail->addCC('cc@example.com');
            //$mail->addBCC('bcc@example.com');

            //Attachments
            //$mail->addAttachment('/var/tmp/file.tar.gz');                             //Add attachments
            //$mail->addAttachment('/tmp/image.jpg', 'new.jpg');                        //Optional name

            //Content
            $mail->isHTML(true);                                                        //Set email format to HTML
            $mail->Subject =  $this->subject;
            $mail->Body    =  $this->message;
            $mail->AltBody = 'É necessário um cliente que suporte HTML5';

            $mail->send();

            $this->status['codigo_status'] = 1;
            $this->status['descricao_status'] = 'E-mail enviado com sucesso';

            echo 'E-mail enviado com sucesso';
        } catch (Exception $e) {

            $this->status['codigo_status'] = 2;
            $this->status['descricao_status'] = 'Não foi possível enviar o e-mail ' . $mail->ErrorInfo;
        }
    }
}
