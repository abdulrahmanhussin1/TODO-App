<?php
class Request {
    //get

    public function get($key=null)
    {
        return ($key !=null) ?( isset($_GET[$key]) ? $_GET[$key] :null ): null;
    }

    //has get

    public function hasGet($key)
    {
        return isset($_GET[$key]);
    }

    //post

    public function post($key=null)
    {
        return ($key !=null) ?( isset($_POST[$key]) ? $_POST[$key] :null ): null;
    }

    // haspost 

    public function hasPost($key)
    {
        return isset($_POST[$key]);
    }


    //filter

    public function sanitize($key) {
        
        return trim(htmlspecialchars(htmlentities($_POST[$key])));
    }

    public function redirect($file){
        return header("location:$file");
    }
}