<?php

class Request
{
    private $postParams;
    private $method;
    private $path;
    private $headers;

    public function __construct($method, $path, $params, $headers) {
        $this->method = $method;
        $this->path = $path;
        $this->postParams = $params;
        $this->headers = $headers;
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

    public function getHeaders()
    {
        return $this->headers;
    }
}