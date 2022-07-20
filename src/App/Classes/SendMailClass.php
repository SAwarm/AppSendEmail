<?php

namespace Src\App\Classes;

use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\PHPMailer;
use Src\Config\MailConfig;

/**
 * Class SendMailClass
 * @package Src\App\Classes
 * @author <jonas-elias/>
 */
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
            $mail->isSMTP();                                                              //Send using SMTP
            $mail->Host       = MailConfig::$service;                                     //Set the SMTP server to send through
            $mail->SMTPAuth   = true;                                                     //Enable SMTP authentication
            $mail->Username   = MailConfig::$emailName;                                   //SMTP username
            $mail->Password   = MailConfig::$emailPassword;                               //SMTP password
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port       = MailConfig::$port;                                        //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

            //Recipients
            $mail->setFrom(MailConfig::$emailName, 'Remetente estudo');
            $mail->addAddress($this->to);                                                 //Add a recipient

            //Content
            $mail->isHTML(true);                                                          //Set email format to HTML
            $mail->Subject =  $this->subject;
            $mail->Body    =  $this->message;
            $mail->AltBody = 'É necessário um cliente que suporte HTML5';

            $mail->send();

            $this->status['status_code'] = 200;
            $this->status['description_status'] = 'Mail sent successfully!';

            return $this->status;
        } catch (Exception $e) {
            $this->status['status_code'] = $e->getCode();
            $this->status['description_status'] = $e->getMessage();

            return $this->status;
        }
    }
}
