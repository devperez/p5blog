<?php
error_reporting(E_ALL);
ini_set("display_errors", 1);

use David\Blogpro\Router\Router;


require 'vendor/autoload.php';


$router = new Router($_GET['url']);


$router->get('/', "Posts#index");

$router->get('/posts', "Posts#index");

$router->get('/posts/:id', "Posts#show");

$router->post('/posts/:id', function($id) {echo 'Modifier l\'article '. $id;});

$router->run();