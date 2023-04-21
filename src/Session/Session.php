<?php

namespace David\Blogpro\Session;

class Session
{
    public function createSession($user)
    {
        $_SESSION['id'] = $user['id'];
        $_SESSION['username'] = $user['username'];
        return $_SESSION;
    }
}
