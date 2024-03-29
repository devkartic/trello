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

$router->post('/login', 'AuthController@login');
$router->get('/logout', 'AuthController@logout');
$router->post('/register', 'AuthController@register');


//$router->get('/boards', ['middleware'=>'auth', 'BoardController@index']);

$router->get('/boards', 'BoardController@index');
$router->post('/boards', 'BoardController@store');
$router->get('/boards/{board}', 'BoardController@show');
$router->patch('/boards/{board}', 'BoardController@update');
$router->delete('/boards/{board}', 'BoardController@destroy');

$router->get('/boards/{board}/lists', 'ListController@index');
$router->post('/boards/{board}/lists', 'ListController@store');
$router->get('/boards/{board}/lists/{list}', 'ListController@show');
$router->patch('/boards/{board}/lists/{list}', 'ListController@update');
$router->delete('/boards/{board}/lists/{list}', 'ListController@destroy');

