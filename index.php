<?php
error_reporting(E_ALL);
ini_set("display_errors", 1);

use David\Blogpro\Router\Router;


require 'vendor/autoload.php';


$router = new Router($_GET['url']);
//var_dump($_GET['url']);
//var_dump($_REQUEST);
//var_dump($_SERVER);

$router->get('/', function() {echo 'Hello world from the homepage !';});

$router->get('/posts', function() {echo 'Tous les articles';});

$router->get('/posts/:id', function($id) {echo 'Afficher l\'article '. $id;});

$router->post('/posts/:id', function($id) {echo 'Modifier l\'article '. $id;});

$router->run();