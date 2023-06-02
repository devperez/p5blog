<?php

namespace David\Blogpro\twig;

use David\Blogpro\Session\Session;
use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

class TwigSessionExtension extends AbstractExtension
{
    /***
     * This function makes the other functions accessible from the twig vue
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

    public function getUsername(): string|null
    {
        $session = new Session();
        $userSession = $session->get('user');
        if ($userSession) {
            return $userSession['username'];
        } else {
            return null;
        }
    }

    public function getUserId(): int
    {
        $session = new Session();
        $userSession = $session->get('user');
        return $userSession['id'];
    }

    public function getErrors(): string|null
    {
        $session = new Session();
        $userErrors = $session->get('errors');
        return isset($userErrors['errors']) ? $userErrors['errors'] : null;
    }

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
        if (isset($user['role']) && $user['role'] === 'admin') {
            return true;
        } else {
            return false;
        }
    }
}
