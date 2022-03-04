<?php

namespace Alireza\Router;


class Router
{
    private array $routs;

    public function get(string $path, callable $callable)
    {
        $this->SetRoute($path, Method::GET, $callable);
    }

    private function SetRoute(string $path, string $method, callable $callable)
    {
        $this->routs[$method][] = new Route($path, $callable);
    }

    public function post(string $path, callable $callable)
    {
        $this->SetRoute($path, Method::POST, $callable);
    }

    public function delete(string $path, callable $callable)
    {
        $this->SetRoute($path, Method::DELETE, $callable);
    }

    public function patch(string $path, callable $callable)
    {
        $this->SetRoute($path, Method::PATH, $callable);
    }
}