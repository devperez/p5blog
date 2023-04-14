<?php

namespace David\Blogpro\Controller;

use Twig\Environment;
use Twig\Loader\FilesystemLoader;

abstract class Controller
{
    private $loader;
    protected $twig;
    //protected $db;

    public function __construct()
    {
        $this->loader = new FilesystemLoader(ROOT . '/blogpro/templates');
        $this->twig = new Environment($this->loader);
    }
}
