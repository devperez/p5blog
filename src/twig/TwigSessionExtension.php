<?php

namespace David\Blogpro\twig;

use David\Blogpro\Session\Session;
use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

/**
 * Class TwigSessionExtension
 *
 * Provides additional Twig functions to access session data.
 */
class TwigSessionExtension extends AbstractExtension
{
    /**
     * Make the functions accessible from Twig views.
     *
     * @return array An array of Twig functions.
     */
    public function getFunctions()
    {
        return [
            new TwigFunction('getUsername', [$this, 'getUsername']),
            new TwigFunction('getUserId', [$this, 'getUserId']),
            new TwigFunction('getErrors', [$this, 'getErrors']),
            new TwigFunction('isUserLogged', [$this, 'isUserLogged']),
            new TwigFunction('isUserAdmin', [$this, 'isUserAdmin']),
            new TwigFunction('getMessage', [$this, 'getMessage']),
        ];
    }

    /**
     * Get the username of the logged-in user in the session.
     *
     * @return string|null The username if the user is logged in, otherwise null.
     */
    public function getUsername(): string|null
    {
        $session = new Session();
        $userSession = $session->get('user');
        if ($userSession) {
            return $userSession['username'];
        }
        return null;
    }

    /**
     * Get the ID of the logged-in user
     *
     * @return int The id of the user
     */

    public function getUserId(): int
    {
        $session = new Session();
        $userSession = $session->get('user');
        return $userSession['id'];
    }

    /**
     * Get the error message to be displayed to the user
     *
     * @return string|null The error message if there is one, otherwise null.
     */
    public function getErrors(): string|null
    {
        $session = new Session();
        $userErrors = $session->get('errors');
        return isset($userErrors['errors']) ? $userErrors['errors'] : null;
    }

    /**
     * Get the message to be displayed to the user.
     *
     * @return string The message if there is one, otherwise null.
     */
    public function getMessage(): string|null
    {
        $session = new Session();
        $userMessage = $session->get('message');
        return isset($userMessage['message']) ? $userMessage['message'] : null;
    }

    /**
     * Checks if the user is logged in.
     *
     * @return bool True if the user is logged in, false otherwise.
     */
    public function isUserLogged(): bool
    {
        $user = $this->getUsername();
        if (!$user) {
            return false;
        }
        return true;
    }

    /**
     * Check if the user is an admin.
     *
     * @return bool True if the user is an admin, false otherwise.
     */
    public function isUserAdmin(): bool
    {
        $session = new Session();
        $user = $session->get('user');
        if (isset($user['role']) === true && $user['role'] === 'admin') {
            return true;
        }
        return false;
    }
}
