<?php

/** @var Router $router */

use Laravel\Lumen\Routing\Router;


$router->get('/test', function () use ($router) {
    return $router->app->version();
});
