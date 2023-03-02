<?php
require_once 'Validator.php';


class minLength implements Validator
{
    public function check($key, $value)
    {
        if (strlen($value) < 6) {
            return "$key must be more than 6 digits";
        }
        return false;
    }
}
