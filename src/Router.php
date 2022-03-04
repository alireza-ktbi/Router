<?php

namespace Alireza\Router;


class Router
{
    private array $routs;

    private function SetRoute(string $path, string $method, callable $callable)
    {
        $this->routs[$method][] = new Route($path, $callable);
    }
}