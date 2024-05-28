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



    $router->post('/register', ['as' => 'register', 'uses' => 'AuthController@register']);
    $router->post('/user/login', ['as' => 'user.login', 'uses' => 'AuthController@login']);
    $router->post('/admin/login', ['as' => 'admin.login', 'uses' => 'AdminAuthController@login']);
    $router->post('/user/logout', ['as' => 'user.logout', 'uses' => 'AuthController@logout']);
    $router->post('/admin/logout', ['as' => 'admin.logout', 'uses' => 'AdminAuthController@logout']);

    $router->group(['middleware' => 'auth'], function () use ($router) {
      
    });

    $router->get('/form-requests', ['as' => 'form-requests.index', 'uses' => 'FormRequestController@index']);
    $router->post('/form-requests', ['as' => 'form-requests.store', 'uses' => 'FormRequestController@store']);
    $router->get('/form-requests/{id}', ['as' => 'form-requests.show', 'uses' => 'FormRequestController@show']);
    $router->put('/form-requests/{id}', ['as' => 'form-requests.update', 'uses' => 'FormRequestController@update']);
    $router->patch('/form-requests/{id}', ['as' => 'form-requests.update.partial', 'uses' => 'FormRequestController@update']);
    $router->delete('/form-requests/{id}', ['as' => 'form-requests.destroy', 'uses' => 'FormRequestController@destroy']);