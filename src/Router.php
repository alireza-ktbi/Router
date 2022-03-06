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

    public function run(string $URI, string $METHOD): bool
    {
        $url_path = parse_url($URI, PHP_URL_PATH);
        if(strpos($url_path, ".php"))
            $url_path = explode(".php", $url_path)[1];
        $found = false;

        foreach ($this->routs[$METHOD] as $route) {
            if ($this->checkForSimpleRoute($route, $url_path)) {
                $found = true;
                break;
            } elseif ($this->checkForNestedRoute($route, $url_path)) {
                $found = true;
                break;
            }
        }

        if (!$found) {
            $this->notFound();
        }

        return $found;
    }

    private function checkForSimpleRoute(Route $route, string $url_path): bool
    {
        $found = false;
        if ($url_path === $route->orgPath) {
            $this->runTheCallable($route->callable);
            $found = true;
        }
        return $found;
    }

    private function runTheCallable(callable $callable, array $args = null)
    {
        if (is_callable(($callable))) {
            ($callable)($args);
        }
    }

    private function checkForNestedRoute(Route $route, string $url_path): bool
    {
        $found = false;
        preg_match('/^' . $route->replacedPath . '$/', $url_path, $matches);

        if (count($matches) >= 1) {
            preg_match_all('/{(([a-zA-Z0-9]*):?(int|string))}/', $route->orgPath, $args);
            array_shift($matches);
            $matches = array_combine($args[2], $matches);
            $found = true;

            foreach ($args[1] as $arg) {
                $arg = explode(":", $arg);
                if (count($arg) > 1) {
                    if ($arg[1] == "int") {
                        if (ctype_digit($matches[$arg[0]])) {
                            $matches[$arg[0]] = intval($matches[$arg[0]]);
                        } else {
                            $found = false;
                        }
                    } elseif ($arg[1] == "string") {
                        if (!ctype_alpha($matches[$arg[0]])) {
                            $found = false;
                        }
                    }
                }
            }

            if ($found) {
                $this->runTheCallable($route->callable, $matches);
            }
        }

        return $found;
    }

    private function notFound()
    {
        header("HTTP/1.0 404 NOT FOUND");
        if (isset($this->page_404) && !empty($this->page_404)) echo $this->page_404;
    }
}