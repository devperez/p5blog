<?php

namespace David\Blogpro\Session;

class Session
{
    /***
     * @param string $key
     * @param array $value
     * @return void
     */
    public function set(string $key, array $value): void
    {
        $_SESSION[$key] = $value;
    }

    public function get(string $key)
    {
        return isset($_SESSION[$key]) ? $_SESSION[$key] : null;
    }

    public function destroy(string $key): void
    {
        unset($_SESSION[$key]);
    }
}
