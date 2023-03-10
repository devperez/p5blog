<?php

namespace David\Blogpro\Router;

class Route
{
    private $path;
    private $callable;
    private $matches;

    public function __construct($path, $callable)
    {
        $this->path = trim($path, '/');
        $this->callable = $callable;
    }

    public function match($url)
    {
        $url = trim($url, '/');
        $path = preg_replace('#:([\w]+)#', '([^/]+)', $this->path);
        //var_dump($path);
        $path = str_replace('/', '/', $path);
        //var_dump(($path));
        $regex = "#^$path$#i";
        if (!preg_match($regex, $url, $matches)) {
            return false;
        }
        //var_dump($matches);
        array_shift($matches);
        $this->matches = $matches;
        return true;
    }

    public function call()
    {
        return call_user_func_array($this->callable, $this->matches);
    }
}
