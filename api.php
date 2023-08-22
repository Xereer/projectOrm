<?php

require_once __DIR__.'/vendor/autoload.php';
require_once __DIR__.'/config/bootstrap.php';
require __DIR__.'/Router.php';

try {
//    $controller = $container->get(\Controller\ProductController::class);
    $router = new Router($container);
    $router->handleRequest();
    $request = new Request($_POST);

} catch (Throwable $exception) {
    print_r($exception->getMessage());
}