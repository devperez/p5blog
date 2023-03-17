<?php

namespace David\Blogpro\Controller;

use Twig\Environment;
use Twig\Loader\FilesystemLoader;

class PostsController
{
    private $loader;
    protected $twig;
    
    public function __construct()
    {
        $this->loader = new FilesystemLoader('src/templates');

        $this->twig = new Environment($this->loader);
    }

    public function index()
    {
        $this->twig->display('posts/index.html.twig');
        //echo "tous les articles du blog";
    }

    public function show($id)
    {
        $this->twig->display('posts/show.html.twig', compact('id'));
        //echo "Je suis l'article $id";
    }
}
