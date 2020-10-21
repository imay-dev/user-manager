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


    // Users Routes
    $router->group([
        'prefix' => 'users',
        'middleware' => 'role:super.admin'
    ], function () use ($router) {
        $router->get('/', 'UserController@index');
        $router->post('/', 'UserController@store');
        $router->get('/{id}', 'UserController@show');
        $router->patch('/{id}', 'UserController@update');
        $router->delete('/{id}', 'UserController@destroy');
        $router->post('/{id}/sync-roles-and-permissions', 'UserController@syncRolesAndPermissions');
    });

    // Roles Routes
    $router->group([
        'prefix' => 'roles',
        'middleware' => 'role:super.admin'
    ], function () use ($router) {
        $router->get('/', 'RoleController@index');
        $router->post('/', 'RoleController@store');
        $router->get('/{id}', 'RoleController@show');
        $router->patch('/{id}', 'RoleController@update');
        $router->delete('/{id}', 'RoleController@destroy');
        $router->post('/{id}/sync-permissions', 'RoleController@syncPermissions');
    });

    // Permissions Routes
    $router->group([
        'prefix' => 'permissions',
        'middleware' => 'role:super.admin'
    ], function () use ($router) {
        $router->get('/', 'PermissionController@index');
        $router->post('/', 'PermissionController@store');
        $router->get('/{id}', 'PermissionController@show');
        $router->patch('/{id}', 'PermissionController@update');
        $router->delete('/{id}', 'PermissionController@destroy');
        $router->post('/{id}/sync-roles', 'PermissionController@syncRoles');
    });

});
