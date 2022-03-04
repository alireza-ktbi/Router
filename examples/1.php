<?php
require "../vendor/autoload.php";

use Alireza\Router\Router;

$router = new Router();

$router->get("/", function () {
    echo "Home Page";
});

$router->get("/users", function () {
    echo "users page";
});

$router->post("/users/add", function () {
    echo "add a user with post method" ;
});

$router->get("/users/{id:int}", function (array $args) {
    echo "users id: " . $args["id"];
});

$router->get("/users/{addr:string}", function (array $args) {
    echo "user addr: " . $args["addr"];
});

$router->set404("oh shit we cant find your page, sory :(");

$router->run(
    URI: $_SERVER["REQUEST_URI"],
    METHOD: $_SERVER["REQUEST_METHOD"]
);

