<?php

namespace Src\App;

use Exception;
use Src\App\Classes\AttributesMailClass;
use Src\App\Validation\ValidationMessage;
use Src\App\Classes\SendMailClass;

/**
 * Class ProcessMail
 * @package Src\App
 * @author <jonas-elias/>
 */
class ProcessMail
{
    /**
     * @var AttributesMailClass
     */
    public $attributes;

    /**
     * method constructor
     * @param AttributesMailClass $attributes
     * @return void
     */
    public function __construct(AttributesMailClass $attributes)
    {
        $this->attributes = $attributes;
    }

    /**
     * method process send mail
     * @return bool|string
     */
    public function send(): bool | string
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

    /**
     * method call validate \ValidationMessage
     * @return bool
     */
    public function validate(): bool
    {
        $validation = new ValidationMessage($this->attributes);
        return $validation->validate();
    }
}

/**
 * Instance of AttributesMailClass
 * 
 * @return object $attributes
 */
$attributes = new AttributesMailClass();

/**
 * call method orchestration SendMail
 */
orchestrationSendMail($attributes->setAllElements($_POST, $attributes));

/**
 * Method to orchestration the process of sending mail
 * 
 * @param object $attributes
 * @return mixed
 * @throws Exception
 */
function orchestrationSendMail($attributes): mixed
{
    try {
        $validation = new ValidationMessage($attributes);
        $processMail = new ProcessMail($attributes);

        if (!$validation->validate()) {
            throw new Exception('Invalid Inputs!', 406);
        }

        $response = $processMail->send();

        if ($response) {
            $_SESSION['success'] = true;
            $_SESSION['message'] = 'Mail sent successfully!';

            header('location: /');

            return true;
        }

        throw new Exception($response, 500);
    } catch (Exception $e) {
        $_SESSION['error'] = true;
        $_SESSION['message'] = $e->getMessage();

        header('location: /');

        return false;
    }
}
