<?php

namespace David\Blogpro\Session;

class Session
{
    public function start($key, $value)
    {
        session_start();
        $_SESSION[$key] = $value;
        //var_dump($_SESSION);
    }
}
