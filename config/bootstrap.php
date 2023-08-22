<?php

require_once __DIR__."/../vendor/autoload.php";


use Container\ContainerClass;
use Doctrine\DBAL\DriverManager;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\ORMSetup;

$paths = [__DIR__ . '/../src/Entity'];
$isDevMode = true;

$dbParams = array(
        'dbname' => 'project',
        'user' => 'root',
        'password' => '',
        'host' => 'localhost',
        'driver' => 'pdo_mysql'
);

$config = ORMSetup::createAttributeMetadataConfiguration($paths, $isDevMode);
$connection = DriverManager::getConnection($dbParams, $config);
$entityManager = new EntityManager($connection, $config);
$container = new ContainerClass();
$container->set(EntityManager::class, $entityManager);
$controllerPath = __DIR__.'/../src/Controller/';
