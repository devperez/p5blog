<?php

namespace David\Blogpro\twig;

use David\Blogpro\Session\Session;
use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

class TwigSessionExtension extends AbstractExtension
{
    public function getFunctions()
    {
        return [new TwigFunction('getUsername', [$this, 'getUsername']),
                new TwigFunction('getUserId', [$this, 'getUserId']),
                new TwigFunction('getErrors', [$this, 'getErrors']),
            ];
    }

    public function getUsername()
    {
        $session = new Session();
        $userSession = $session->get('user');
        return $userSession['username'];
    }

    public function getUserId()
    {
        $session = new Session();
        $userSession = $session->get('user');
        return $userSession['id'];
    }

    public function getErrors()
    {
        $session = new Session();
        $userErrors = $session->get('errors');
        return isset($userErrors['errors']) ? $userErrors['errors'] : null;
    }
}
