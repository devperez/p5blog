<?php

namespace David\Blogpro\Router;

use Exception;

/**
 * Class RouterException
 *
 * Represents an exception specific to the router
 */
class RouterException extends \Exception
{
    public function render404()
    {
        header("HTTP/1.0 404 Not Found");
        include 'templates/404.html';
        exit();
    }
}
