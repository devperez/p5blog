<?php

namespace David\Blogpro\Router;

class Router
{
    private string $url;

    private array $routes = [];

    public function __construct(string $url)
    {
        $this->url = $url;
    }

    /***
     * @param string $path the url
     * @param string $callable the controller's method
     * @return void
     */
    public function get(string $path, string $callable): void
    {
        $route = new Route($path, $callable);
        $this->routes['GET'][] = $route;
    }

    /***
     * @param string $path the url
     * @param string $callable the controller's method
     * @return void
     */
    public function post(string $path, string $callable): void
    {
        $route = new Route($path, $callable);
        $this->routes['POST'][] = $route;
    }

    /**
     * This function checks if the route exists and if there is a match calls the call function
     */
    public function run()
    {
        if (!isset($this->routes[$_SERVER['REQUEST_METHOD']])) {
            throw new RouterException('REQUEST_METHOD does not exist');
        }
        foreach ($this->routes[$_SERVER['REQUEST_METHOD']] as $route) {
            if ($route->match($this->url) === true) {
                return $route->call();
            }
        }
        throw new RouterException('No matching routes');
    }
}
