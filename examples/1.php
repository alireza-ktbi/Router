<?php
require "../vendor/autoload.php";

class TestClass
{
    public function test1($args)
    {
        var_dump($args);
        echo "it is a class";

    }
}

use Alireza\Router\{RouteAction, Router};

$router = new Router();


$router->get("/", new RouteAction([new testclass(), "test1"]));

$router->get("/users", new RouteAction(
        function () {
            echo "users page";
        }
    )
);

$router->post("/users/add",
    new RouteAction(function () {
        echo "add a user with post method";
    })
);

$router->get("/users/{id:int}", new RouteAction(function (array $args) {
        echo "users id: " . $args["id"];
    })
);

$router->get("/users/{addr:string}", new RouteAction(function (array $args) {
        echo "user addr: " . $args["addr"];
    })
);

$router->set404("oh shit we cant find your page, sory :(");

$router->run(
    URI: $_SERVER["REQUEST_URI"],
    METHOD: $_SERVER["REQUEST_METHOD"]
);

