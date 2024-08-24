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

/**
 * @hideFromAPIDocumentation
 */
$router->get('/', function () use ($router) {
    //return $router->app->version();
    return 'API Employee';
});

$router->post('/register','RegisterController@register');
$router->post('/login','LoginController@authenticate');

$router->group(['middleware' => 'auth'], function () use ($router){
	$router->get('profile', 'LoginController@profile');
	$router->post('regenerate', 'LoginController@refresh');
	$router->post('logout', 'LoginController@logout');

	$router->get('/employees','EmployeeController@index');
	$router->get('/jobs','EmployeeController@get_jobs');
	$router->post('/employees', 'EmployeeController@store');
	$router->get('/employees/{id}', 'EmployeeController@show');
	$router->put('/employees/{id}', 'EmployeeController@update');
	$router->delete('/employees/{id}', 'EmployeeController@destroy');

	$router->get('users', 'UserController@index');
	$router->get('user/{id}', 'UserController@show');
	$router->delete('user/{id}', 'UserController@destroy');
});

/*
$router->group(['middleware' => 'BasicAuth'], function () use ($router){
	
});
*/