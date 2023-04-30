<?php

namespace David\Blogpro\Session;

class Session
{
    public function start($key, $value)
    {
        $_SESSION[$key] = $value;
    }

    public function get(string $key)
    {
        return isset($_SESSION[$key]) ? $_SESSION[$key] : null;
    }
}
