<?php

namespace David\Blogpro\Controller;

use Twig\Environment;
use Twig\Loader\FilesystemLoader;

class NavController
{
    private $loader;
    protected $twig;
    
    public function __construct()
    {
        $this->loader = new FilesystemLoader('src/templates');

        $this->twig = new Environment($this->loader);
    }

    public function homepage()
    {
        $this->twig->display('homepage.html.twig');
    }

    public function index()
    {
        $this->twig->display('posts/index.html.twig');
    }

    public function show($id)
    {
        $this->twig->display('posts/show.html.twig', compact('id'));
    }
}
