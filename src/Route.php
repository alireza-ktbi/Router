<?php

namespace Alireza\Router;

class Route
{
    public $callable;
    public string $orgPath;
    public string $replacedPath;

    public function __construct(string $path, callable $callable)
    {
        $this->orgPath = $path;
        $this->callable = $callable;
        $this->replacedPath = preg_replace(['/{[a-zA-Z0-9]*:?(|:int|:string)}/', '/\//'], ['([a-zA-Z0-9]+)', '\/'], $path);
    }
}