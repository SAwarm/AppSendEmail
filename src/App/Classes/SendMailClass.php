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
    /**
     * Method constructor
     * 
     * @param AttributesMailClass $attributes
     * @return void
     */
    public function __construct(AttributesMailClass $attributes)
    {
        $this->to = $attributes->to;
        $this->subject = $attributes->subject;
        $this->message = $attributes->message;
    }

    /**
     * Method send mail
     * 
     * @return array
     */
    public function sendMail(): array
    {
        try {
            // Create a new PHPMailer instance with attributes
            $mail = $this->configurationAttributesPHPMailer(new PHPMailer(true));

            //Recipients
            $mail->setFrom(MailConfig::$emailName, 'Remetente estudo');
            $mail->addAddress($this->to);

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

    /**
     * Method configuration attributes PHPMailer
     * @param PHPMailer $mail
     * @return PHPMailer
     */
    protected function configurationAttributesPHPMailer($mail): PHPMailer
    {
        $mail->isSMTP();
        $mail->Host       = MailConfig::$service;
        $mail->SMTPAuth   = true;
        $mail->Username   = MailConfig::$emailName;
        $mail->Password   = MailConfig::$emailPassword;
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port       = MailConfig::$port;

        return $mail;
    }
}
