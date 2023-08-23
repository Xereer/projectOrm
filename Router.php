<?php


class Router
{
    private $request;

    public function __construct(private $container)
    {
        require_once __DIR__.'/Request.php';
        $this->request = new Request($_SERVER["REQUEST_METHOD"], $_SERVER['REQUEST_URI'], $_POST, $_GET);
    }

    public function handleRequest()
    {

        if ($this->request->getMethod() == "POST" && $this->request->getPath()) {

            $requestPath = $this->request->getPath();

            $query = parse_url($requestPath, PHP_URL_QUERY);
            parse_str($query, $path);

            $action = $path['act'];
            $method = $path['method'];
            $controllerName = 'Controller' . '\\' . $action . 'Controller';
            if (class_exists($controllerName)) {

                $controller = $this->container->get($controllerName);
                $controller->$method($this->request);
            }

            header('Location: index.html');
        }
    }
}