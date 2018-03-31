<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
*/

$router->get('/', function () use ($router) {
    return $router->app->version();
});

$router->post('token', 'UserController@authenticate');

$router->group(['prefix' => 'users', 'middleware' => ['auth', 'admin']], function () use ($router) {
    $router->get('/', 'UserController@all');
    $router->post('add', 'UserController@create');
    $router->delete('delete/{id}', 'UserController@delete');

    $router->group(['prefix' => 'group'], function () use ($router) {
        $router->post('add', 'UserController@addToGroup');
        $router->delete('remove', 'UserController@removeFromGroup');
    });
});

$router->group(['prefix' => 'groups', 'middleware' => ['auth', 'admin']], function () use ($router) {
    $router->get('/', 'GroupController@all');
    $router->post('add', 'GroupController@create');
    $router->delete('delete/{id}', 'GroupController@delete');
});
