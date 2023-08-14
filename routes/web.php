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

$router->get('/', function () use ($router) {
    return $router->app->version();
});

$router->group(['middleware' => 'BasicAuth'], function () use ($router){
	$router->get('/employees','EmployeeController@index');
	$router->get('/jobs','EmployeeController@get_jobs');
	$router->post('/employees', 'EmployeeController@store');
	$router->get('/employees/{id}', 'EmployeeController@show');
	$router->patch('/employees/{id}', 'EmployeeController@update');
	$router->delete('/employees/{id}', 'EmployeeController@destroy');
});