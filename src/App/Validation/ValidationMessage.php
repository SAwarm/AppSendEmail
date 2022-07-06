<?php

namespace Src\App\Validation;

use Src\App\Classes\AttributesMailClass;

class ValidationMessage extends AttributesMailClass
{
    private $to;

    private $subject;

    private $message;

    public function __construct(AttributesMailClass $attributes)
    {
        $this->to = $attributes->to;
        $this->subject = $attributes->subject;
        $this->message = $attributes->message;
    }

    public function validate()
    {
        if (empty($this->to) || empty($this->subject) || empty($this->message)) {
            return false;
        }

        return true;
    }
}
