<?php

namespace Alireza\Router;

class Route
{
    public $callable;
    public string $orgPath;

    public function __construct(string $path, callable $callable)
    {
        $this->orgPath = $path;
        $this->callable = $callable;
    }
}