<?php

namespace Alireza\Router;

class Route
{
    public string $orgPath;
    public RouteAction $action;

    public function __construct(string $path, RouteAction $action)
    {
        $this->orgPath = $path;
        $this->action = $action;
    }
}