<?php

/** @var \Laravel\Lumen\Routing\Router $router */

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
// use TodoController;
use App\Http\Controllers\TodoController;
// Group todo controller
$router->group(['prefix' => 'todo'], function () use ($router) {
    // Create new todo
    $router->post('/', 'TodoController@store');
    // Get single todo
    $router->get('/{id}', 'TodoController@show');
    // Update todo
    $router->put('/{id}', 'TodoController@update');
    // Delete todo
    $router->delete('/{id}', 'TodoController@destroy');
});
$router->get('/todos', 'TodoController@index');
