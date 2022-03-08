<?php

namespace Alireza\Router;

class RouteAction
{
    public $action;

    public function __construct(callable|array $action)
    {
        $this->action = $action;
    }

    public function execute(array $args = [])
    {
        if (is_callable($this->action)) {
            ($this->action)($args);
        } elseif (is_array($this->action)) {
            if (count($this->action) == 2) {
                if (class_exists($this->action[0]) && method_exists($this->action[0], $this->action[1])) {
                    if (is_string($this->action[0])) {
                        $this->action[0] = new $this->action[0];
                    }
                    $this->action[0]->{$this->action[1]}($args);
                }
            }
        }
    }
}