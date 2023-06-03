<?php

namespace David\Blogpro\Session;

class Session
{
    /***
     * This function is called when the user logs in
     *
     * @param string $key This is the array key
     * @param array $value This is the value of the key
     * @return void
     */
    public function set(string $key, array $value): void
    {
        $_SESSION[$key] = $value;
    }

    /***
     * This function is called when there is a need to check if the session has a certain key
     *
     * @param string key the array key
     * @return boolean true or null
     */
    public function get(string $key)
    {
        return isset($_SESSION[$key]) ? $_SESSION[$key] : null;
    }

    /***
     * This function is called when logging out
     *
     * @param string key the array key
     * @return void
     */
    public function destroy(string $key): void
    {
        unset($_SESSION[$key]);
    }
}
