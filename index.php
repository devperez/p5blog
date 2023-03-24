<?php
error_reporting(E_ALL);
ini_set("display_errors", 1);

use David\Blogpro\Router\Router;

//constant aiming to the project root folder
define('ROOT', dirname(__DIR__));

require 'vendor/autoload.php';


$router = new Router($_GET['url']);


$router->get('/', "Nav::homepage");

$router->get('/posts', "Nav::index");

$router->get('/posts/:id', "Nav::show");

$router->post('/posts/:id', function($id) {echo 'Modifier l\'article '. $id;});

$router->run();