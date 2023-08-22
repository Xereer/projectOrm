<?php

require_once __DIR__.'/vendor/autoload.php';
require_once __DIR__.'/config/bootstrap.php';
require __DIR__.'/Router.php';

try {

    $router = new Router($container);
    $router->handleRequest();

} catch (Throwable $exception) {
    print_r($exception->getMessage());
}