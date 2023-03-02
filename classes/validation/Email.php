<?php 
require_once 'Validator.php';


class Email implements Validator
{
    public function check($key, $value)
    {
        if(!filter_var($value,FILTER_VALIDATE_EMAIL)){
            return "please enter a valid email address";
        }else 
        return false;
    }

}