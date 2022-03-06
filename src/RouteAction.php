<?php

namespace Alireza\Router;

class RouteAction
{
    public $action;

    public function __construct(callable|array $action)
    {
        $this->action = $action;
    }

    public function execute(array $args = null)
    {
        if (is_callable($this->action)) {
            ($this->action)($args);
        } elseif (is_array($this->action)) {
            if (count($this->action) == 2) {
                call_user_func_array($this->action, $args);
            }
        }
    }
}