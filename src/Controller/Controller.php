<?php

namespace David\Blogpro\Controller;

use David\Blogpro\twig\TwigSessionExtension;
use Twig\Environment;
use Twig\Loader\FilesystemLoader;

abstract class Controller
{
    private $loader;
    protected $twig;
    

    public function __construct()
    {
        $this->loader = new FilesystemLoader(ROOT . '/blogpro/templates');
        $this->twig = new Environment($this->loader);
        $this->twig->addExtension(new TwigSessionExtension());
    }
}
