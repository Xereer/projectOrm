<?php

class Request
{
    private $postParams;

    public function __construct($postParams)
    {
        $this->postParams = $postParams;
    }
    public function get()
    {
        return $this->postParams;
    }
}