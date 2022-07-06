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

$validation = new ValidationMessage($attributes);
$processMail = new ProcessMail($attributes);

if ($validation->validate()) {
    $processMail->send();
    echo "OK";
    return;
} else {
    echo "NOK";
    return;
}
