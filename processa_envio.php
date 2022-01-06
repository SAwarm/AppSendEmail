<?php

    require "./bibliotecas/PHPMailer/Exception.php";
    require "./bibliotecas/PHPMailer/OAuth.php";
    require "./bibliotecas/PHPMailer/PHPMailer.php";
    require "./bibliotecas/PHPMailer/POP3.php";
    require "./bibliotecas/PHPMailer/SMTP.php";

    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\Exception;

    class Mensagem
    {
        private $para = null;
        private $assunto = null;
        private $mensagem = null;

        public function __get($atribute)
        {
            return $this->$atribute;
        }

        public function __set($atribute, $value)
        {
            $this->$atribute = $value;
        }

        public function mensagemValida()
        {
            if (empty($this->para) || empty($this->assunto) || empty($this->mensagem)) {
                return false;
            }

            return true;
        }
    }

    $mensagem = new Mensagem();

    foreach ($_POST as $key => $value) {
        $mensagem->__set($key, $value);
    }

    if (!$mensagem->mensagemValida()) {
        echo "Mensagem não válida";
        return;
    }

    $mail = new PHPMailer(true);

    try {
        //Server settings
        //$mail->SMTPDebug = SMTP::DEBUG_SERVER;                        //Enable verbose debug output
        $mail->isSMTP();                                                //Send using SMTP
        $mail->Host       = 'smtp.gmail.com';                           //Set the SMTP server to send through
        $mail->SMTPAuth   = true;                                       //Enable SMTP authentication
        $mail->Username   = 'email';                                    //SMTP username
        $mail->Password   = 'password';                                 //SMTP password
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;            
        //$mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;              //Enable implicit TLS encryption
        $mail->Port       = 587;                                        //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

        //Recipients
        $mail->setFrom('estudosprogramacaojonas@gmail.com', 'Remetente estudo');
        $mail->addAddress('estudosprogramacaojonas@gmail.com', 'Destinatário');     //Add a recipient
        //$mail->addAddress('ellen@example.com');                                   //Name is optional
        //$mail->addReplyTo('info@example.com', 'Information');
        //$mail->addCC('cc@example.com');
        //$mail->addBCC('bcc@example.com');

        //Attachments
        //$mail->addAttachment('/var/tmp/file.tar.gz');                             //Add attachments
        //$mail->addAttachment('/tmp/image.jpg', 'new.jpg');                        //Optional name

        //Content
        $mail->isHTML(true);                                                        //Set email format to HTML
        $mail->Subject = 'Assunto e-mail';
        $mail->Body    = '<h1>Title</h1> <br> <strong>e-mail</strong>';
        $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

        $mail->send();
        echo 'Message has been sent';
    } catch (Exception $e) {
        echo "Não foi possível enviar o e-mail!: {$mail->ErrorInfo}";
    }
