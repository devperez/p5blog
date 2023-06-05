<?php

namespace David\Blogpro\Router;

/**
 * Class Router
 *
 * Represents a router that handles routes and executes the corresponding route based on HTTP method.
 */
class Router
{
    /**
     * @var string The current URL.
     */
    private string $url;

    /**
     * @var array The registered routes.
     */
    private array $routes = [];

    /**
     * Router constructor.
     *
     * @param string $url The current URL.
     */
    public function __construct(string $url)
    {
        $this->url = $url;
    }

    /**
     * Register a GET route.
     *
     * @param string $path The URL pattern for the route.
     * @param string $callable The callable associated with the route.
     * @return void
     */
    public function get(string $path, string $callable): void
    {
        $route = new Route($path, $callable);
        $this->routes['GET'][] = $route;
    }

    /**
     * Register a POST route.
     *
     * @param string $path The URL pattern for the route
     * @param string $callable The callable associated with the route
     * @return void
     */
    public function post(string $path, string $callable): void
    {
        $route = new Route($path, $callable);
        $this->routes['POST'][] = $route;
    }

    /**
     * Run the router and execute the appropriate route.
     *
     * @return mixed The result of the route call.
     * @throws RouterException If no matching routes are found.
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
