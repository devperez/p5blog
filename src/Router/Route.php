<?php

namespace David\Blogpro\Router;

use David\Blogpro\Database\DBConnection;
use David\Blogpro\Manager\LoginManager;

/**
 * Class Route
 *
 * Represents a route in the router.
 */
class Route
{
    /**
     * @var string The path pattern for the route.
     */
    private $path;

    /**
     * @var string|callable The callable associated with the route.
     */
    private $callable;

    /**
     * @var array The matches extracted from the route path.
     */
    private $matches;

    /**
     * Route constructor
     *
     * @param string $path The path pattern for the route.
     * @param string|callable $callable The callable associated with the route.
     */
    public function __construct(string $path, string $callable)
    {
        $this->path = trim($path, '/');
        $this->callable = $callable;
    }

    /**
     * Checks if the route matches the given URL.
     *
     * @param string $url The URL to match against.
     * @return bool True if the route matches the URL, false otherwise.
     */
    public function match(string $url): bool
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

    /**
     * Call the appropriate method based on the route configuration.
     *
     * @return mixed The result of the method call.
     */
    public function call()
    {
        if (is_string($this->callable)) {
            $params = explode('::', $this->callable);
            $controller = "David\\Blogpro\\Controller\\" . $params[0] . "Controller";
            $controller = new $controller();
            return call_user_func_array([$controller, $params[1]], $this->matches);
        }
        return call_user_func_array($this->callable, $this->matches);
    }
}
