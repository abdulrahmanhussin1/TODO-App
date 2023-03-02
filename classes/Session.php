<?php
class Session {

    public function __construct()
    {
        session_start();
    }
    //set
    public function set($key,$value)
    {
        $_SESSION[$key] = $value;
    }

    //get
    public function hasGetSession($key)
    {
        return isset($_SESSION[$key]);
    }
    
    public function get($key)
    {
        return $_SESSION[$key];
    }

    //unset

    public function remove($key)
    {
        unset($_SESSION[$key]);
    }


    //destory
    public function destroy()
    {
        session_destroy();
    }


}