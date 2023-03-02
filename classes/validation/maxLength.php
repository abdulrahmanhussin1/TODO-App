<?php 
require_once 'Validator.php';


class maxLength implements Validator
{

    
        public function check($key, $value)
        {
            if (strlen($value) > 50 ) {
                return "$key must be less than 50 digits";
            }
            return false;
        }
    

}