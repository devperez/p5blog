<?php

namespace David\Blogpro\Router;

use David\Blogpro\Database\DBConnection;
use David\Blogpro\Manager\LoginManager;

class Route
{
    private $path;
    private $callable;
    private $matches;

    public function __construct(string $path, $callable)
    {
        $this->path = trim($path, '/');
        $this->callable = $callable;
    }

    public function match(string $url)
    {
        $url = trim($url, '/');
        $path = preg_replace('#:([\w]+)#', '([^/]+)', $this->path);
        $path = str_replace('/', '/', $path);
        $regex = "#^$path$#i";
        if (!preg_match($regex, $url, $matches)) {
            return false;
        }
        array_shift($matches);
        $this->matches = $matches;
        return true;
    }

    public function call()
    {
        if (is_string($this->callable)) {
            $params = explode('::', $this->callable);
            $controller = "David\\Blogpro\\Controller\\" . $params[0] . "Controller";
            //$controller = new $controller(new LoginManager(new DBConnection('blogpro', '127.0.0.1:3306', 'phpmyadmin', 'jON9KUMbhz8m')));
            $controller = new $controller();
            return call_user_func_array([$controller, $params[1]], $this->matches);
        } else {
            return call_user_func_array($this->callable, $this->matches);
        }
    }
}
