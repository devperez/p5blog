<?php

namespace David\Blogpro\Controller;

use David\Blogpro\twig\TwigSessionExtension;
use Twig\Environment;
use Twig\Loader\FilesystemLoader;

/**
 * Abstract class for the controllers
 */
abstract class Controller
{
    /**
     * The template loader
     *
     * @var FilesystemLoader
     */
    private $loader;

    /**
     * Instance of Twig to render the templates
     *
     * @var Environment
     */
    protected $twig;

    /**
     * Twig environment for configuration
     *
     * @var \Twig\Environment
     */
    protected $environment;

    /**
     * Controller class constructor
     */
    public function __construct()
    {
        $this->loader = new FilesystemLoader(ROOT . '/blogpro/templates');
        $this->twig = new Environment($this->loader);
        $this->twig->addExtension(new TwigSessionExtension());
    }
}
