<?php

namespace David\Blogpro\Controller;

use David\Blogpro\Database\DBConnection;
use David\Blogpro\Manager\loginManager;
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

    // protected function getDB()
    // {
    //     return $this->db;
    // }
}
