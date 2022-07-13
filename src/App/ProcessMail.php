<?php

namespace Src\App;

use Src\App\Classes\AttributesMailClass;
use Src\App\Validation\ValidationMessage;
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
            return false;
        }

        $sendMail = new SendMailClass($this->attributes);

        $response = $sendMail->sendMail();

        if ($response['status_code'] == 200) {
            return true;
        }

        return $response['description_status'];
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

$validation = new ValidationMessage($attributes);
$processMail = new ProcessMail($attributes);

if ($processMail->send()) {
    $_SESSION['success'] = true;
    header('location: /');
    return;
}

$_SESSION['error'] = true;
header('location: /');
