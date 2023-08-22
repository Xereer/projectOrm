<?php

class Router {

    public function __construct(private $container)
    {
    }

    public function handleRequest() {

        if ($_SERVER["REQUEST_METHOD"] == "POST" && $_SERVER['REQUEST_URI']) {

            $request = $_SERVER['REQUEST_URI'];

            $query = parse_url($request, PHP_URL_QUERY);
            parse_str($query, $path);

            $action = $path['act'];
            $method = $path['method'];
            $controllerName = 'Controller'.'\\'.$action.'Controller';
            if (class_exists($controllerName)){
                $controller = $this->container->get($controllerName);
                $controller->$method();
            }

            header('Location: index.html');
        }
    }
}