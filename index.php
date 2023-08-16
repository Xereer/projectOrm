<?php


use Doctrine\ORM\EntityManager;

require_once 'vendor/autoload.php';
require_once 'config/bootstrap.php';

try {
//    $controller = (new \Controller\ProductController(new \Service\UniversityService(new \Repository\UniversityRepository())));
    $controller = $container->get(\Controller\ProductController::class);
    var_dump($controller->index());
//    $controller->index();
} catch (Throwable $exception) {
    print_r(  $exception->getMessage());
}