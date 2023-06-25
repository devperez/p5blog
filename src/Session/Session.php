<?php

namespace David\Blogpro\Session;

/**
 * Class Session
 *
 * Represents a session handler.
 */
class Session
{
    /**
     * Sets a value in the session.
     *
     * @param string $key The array key.
     * @param array $value The value of the key
     * @return void
     */
    public function set(string $key, array $value): void
    {
        $_SESSION[$key] = $value;
    }

    /**
     * Gets a value from the session.
     *
     * @param string $key the array key
     * @return mixed|null The value of the key if it exists, otherwise null.
     */
    public function get(string $key)
    {
        return isset($_SESSION[$key]) ? $_SESSION[$key] : null;
    }

    /**
     * Destroys a value in the session.
     *
     * @param string $key the array key.
     * @return void
     */
    public function destroy(string $key): void
    {
        unset($_SESSION[$key]);
    }
}
