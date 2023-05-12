<?php
error_reporting(E_ALL);
ini_set("display_errors", 1);

use David\Blogpro\Router\Router;
use Symfony\Component\Dotenv\Dotenv;

//constant aiming to the project root folder
define('ROOT', dirname(__DIR__));

require 'vendor/autoload.php';

session_start();
$dotenv = new Dotenv();
$dotenv->load(__DIR__.'/.env');
$router = new Router($_GET['url']);


$router->get('/', "Nav::homepage");

$router->get('/posts', "Nav::index");

$router->get('/posts/:id', "Nav::show");

$router->get('/admin', "Nav::admin");

$router->post('/signup', "Admin::signup");

$router->post('/signin', "Admin::signin");

$router->get('/writePost', "Admin::write");

$router->get('/indexAdmin', "Admin::index");

$router->post('/publishPost', "Admin::publish");

$router->get('/editPost/:id', "Admin::edit");

$router->post('/editPost/:id', "Admin::editPost");

$router->get('/deletePost/:id', "Admin::deletePost");

$router->get('readPost/:id', "Admin::readPost");

$router->get('logout', "Admin::logout");

$router->post('/comment', "Admin::comment");

$router->get('commentIndex', "Admin::commentIndex");

$router->get('readComment/:id', "Admin::readComment");

$router->get('publishComment/:id', "Admin::publishComment");

$router->get('deleteComment/:id', "Admin::deleteComment");


$router->run();