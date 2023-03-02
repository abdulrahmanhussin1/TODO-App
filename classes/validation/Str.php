<?php 

require_once 'Validator.php';


class Str implements Validator 
{
    public function check($key,$value)
    {
        if(is_numeric($value)){
            return "$key must be in letters and numbers";
        }else {
            return false;
        }
    }
}