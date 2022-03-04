<?php

namespace Alireza\Router;


class Router
{
    private array $routs;
    private string $page_404;

    public function set404(string $page)
    {
        $this->page_404 = $page;
    }

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

    public function put(string $path, callable $callable)
    {
        $this->SetRoute($path, Method::PUT, $callable);
    }

    private function notFound()
    {
        header("HTTP/1.0 404 NOT FOUND");
        if (isset($this->page_404) && !empty($this->page_404)) echo $this->page_404;
    }
}