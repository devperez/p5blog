<?php

namespace David\Blogpro\twig;

use David\Blogpro\Session\Session;
use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

class TwigSessionExtension extends AbstractExtension
{
    /***
     * This function makes the other functions accessible from the twig vue
     *
     * @return array
     */
    public function getFunctions()
    {
        return [new TwigFunction('getUsername', [$this, 'getUsername']),
                new TwigFunction('getUserId', [$this, 'getUserId']),
                new TwigFunction('getErrors', [$this, 'getErrors']),
                new TwigFunction('isUserLogged', [$this, 'isUserLogged']),
                new TwigFunction('isUserAdmin', [$this, 'isUserAdmin']),
                new TwigFunction('getMessage', [$this, 'getMessage']),
            ];
    }

    /***
     * This function gets the name of the user stored in the session
     *
     * @return null is user is not logged in or the username if he is
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

    /***
     * This function returns the id of the user
     *
     * @return integer The id of the user
     */

    public function getUserId(): int
    {
        $session = new Session();
        $userSession = $session->get('user');
        return $userSession['id'];
    }
    
    /***
     * This function is used to display errors to the user when he sign up or sign in
     *
     * @return string The error to be displayed or null if there is none
     */
    public function getErrors(): string|null
    {
        $session = new Session();
        $userErrors = $session->get('errors');
        return isset($userErrors['errors']) ? $userErrors['errors'] : null;
    }

    /***
     * This function is used to display messages to the user when he sign up or sign in
     *
     * @return string The message to be displayed or null if there is none
     */
    public function getMessage(): string|null
    {
        $session = new Session();
        $userMessage = $session->get('message');
        return isset($userMessage['message']) ? $userMessage['message'] : null;
    }

    /***
     * This function checks if the user is logged
     *
     * @return boolean
     */
    public function isUserLogged(): bool
    {
        $user = $this->getUsername();
        if (!$user) {
            return false;
        } else {
            return true;
        }
    }

    public function isUserAdmin(): bool
    {
        $session = new Session();
        $user = $session->get('user');
        //var_dump($user);
        if (isset($user['role']) === true && $user['role'] === 'admin') {
            return true;
        } else {
            return false;
        }
    }
}
