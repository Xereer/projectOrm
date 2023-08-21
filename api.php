<?php


use Doctrine\ORM\EntityManager;

require_once 'vendor/autoload.php';
require_once 'config/bootstrap.php';
require 'Router.php';

try {
    $controller = $container->get(\Controller\ProductController::class);
    $router = new Router($controller);
    $router->handleRequest();

} catch (Throwable $exception) {
    print_r($exception->getMessage());
}