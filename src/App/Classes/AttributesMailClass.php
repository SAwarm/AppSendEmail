<?php

namespace Src\App\Classes;

class AttributesMailClass
{
    private $to;

    private $subject;

    private $message;

    public $status = array('status_code' => null, 'description_status' => null);

    public function __get($atribute)
    {
        return $this->$atribute;
    }

    public function __set($atribute, $value)
    {
        $this->$atribute = $value;
    }
}
