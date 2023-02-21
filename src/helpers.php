<?php
if (!function_exists('smsir')) {
    function smsir($message, $phone_number, $data = null, $template_id = null)
    {
        $instance = (new MRGear\SMSIR\SMSIR());
        switch (true):
            case is_string($message) && is_string($phone_number):
                $instance->message($message)->phoneNumber($phone_number)->single();
                break;
            case is_array($message) && is_array($phone_number):
                $instance->messages($message)->phoneNumbers($phone_number)->p2p();
                break;
            case is_string($message) && is_array($phone_number):
                $instance->message($message)->phoneNumbers($phone_number)->multiple();
                break;
            case (strtolower($message) === 'verify' || strtolower($message) === 'v' || $message === true) && is_string($phone_number):
                $instance->templateId($template_id)->phoneNumber($phone_number)->parameters($data)->fast();
                break;
        endswitch;
        return $instance->send();
    }
}