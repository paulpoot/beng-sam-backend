<?php

use Illuminate\Http\Request;

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
    return "Lumen is running...";
});

$router->group(['prefix' => 'v1/auth'], function($router)
{
    $router->post('register', 'AuthController@register');        
    $router->post('login', 'AuthController@login');    
});

$router->group(['prefix' => 'v1', 'middleware' => 'auth'], function($router)
{
    $router->get('message','MessageController@index');    
    $router->post('message','MessageController@createMessage');
    
    $router->get('me', function(Request $request) {
        return $request->user();
    });
});