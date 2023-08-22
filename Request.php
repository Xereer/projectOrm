<?php

class Request
{
    private $postParams;
    private $method;
    private $path;

    public function __construct($method, $path, $params) {
        $this->method = $method;
        $this->path = $path;
        $this->postParams = $params;
    }

    public function getMethod() {
        return $this->method;
    }

    public function getPath() {
        return $this->path;
    }

    public function getParams($key)
    {
        return $this->postParams[$key];
    }
}