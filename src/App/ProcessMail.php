<?php

namespace Src\App;

require "./Classes/AttributesMailClass.php";
require "./Validation/ValidationMessage.php";
require "./Classes/SendMailClass.php";

use Src\App\Classes\AttributesMailClass;
use Src\Validation\ValidationMessage;
use Src\App\Classes\SendMailClass;

class ProcessMail
{
    public $attributes;

    public function __construct(AttributesMailClass $attributes)
    {
        $this->attributes = $attributes;
    }

    public function send()
    {
        if (!$this->validate()) {
            return $this->attributes->message = "Error";
        }

        $sendMail = new SendMailClass($this->attributes);
        return $sendMail->sendMail();
    }

    public function validate()
    {
        $validation = new ValidationMessage($this->attributes);
        return $validation->validate();
    }
}

$attributes = new AttributesMailClass();

foreach ($_POST as $key => $value) {
    $attributes->__set($key, $value);
}

$processMail = new ProcessMail($attributes);
$processMail->send();



$validation = new ValidationMessage($attributes);
if ($validation->validate()) {
    echo "OK";
    return;
} else {
    echo "NOK";
    return;
}


?>

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>App Send Email</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
</head>

<body>
    <div class="container">
        <div class="py-3 text-center">
            <img class="d-block mx-auto mb-2" src="logo.png" alt="" width="72" height="72">
            <h2>Send Mail</h2>
            <p class="lead">Seu app de envio de e-mails particular!</p>
        </div>

        <div class="row">
            <div class="col-md-12">

                <?php if ($mensagem->status['codigo_status'] == 1) { ?>

                    <div class="container">
                        <h1 class="display-4 text-success">Sucesso</h1>
                        <p><?= $mensagem->status['descricao_status'] ?></p>
                        <a href="index.php" class="btn btn-success btn-lg mt-5 text-white">Voltar</a>
                    </div>

                <?php } ?>

                <?php if ($mensagem->status['codigo_status'] == 2) { ?>

                    <div class="container">
                        <h1 class="display-4 text-danger">Erro</h1>
                        <p><?= $mensagem->status['descricao_status'] ?></p>
                        <a href="index.php" class="btn btn-danger btn-lg mt-5 text-white">Voltar</a>
                    </div>

                <?php } ?>

            </div>
        </div>
    </div>
</body>