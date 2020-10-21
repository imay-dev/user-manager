<?php

/** @var Router $router */

use Laravel\Lumen\Routing\Router;


$router->post('auth/login', 'Auth\AuthController@login');
$router->post('auth/register', 'Auth\AuthController@register');

$router->group(['middleware' => 'auth:api'], function () use ($router) {
    // Auth Logout & Profile Routes
    $router->post('auth/logout', 'Auth\AuthController@logout');
    $router->get('auth/profile', 'Auth\AuthController@profile');
});


$router->group(['middleware' => 'auth:api'], function () use ($router) {
    // Auth Logout & Profile Routes
    $router->post('auth/logout', 'Auth\AuthController@logout');
    $router->get('auth/profile', 'Auth\AuthController@profile');

    // Roles, Permissions & Users Routes
    $router->group([
        'prefix' => 'users'
    ], function () use ($router) {
        $router->get('/', 'UserController@index');
        $router->post('/', 'UserController@store');
        $router->get('/{id}', 'UserController@show');
        $router->patch('/{id}', 'UserController@update');
        $router->delete('/{id}', 'UserController@destroy');
    });
});
