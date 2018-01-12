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
    $router->get('refresh', 'AuthController@refresh');
});

$router->group(['prefix' => 'v1', 'middleware' => 'auth'], function($router)
{
    $router->get('message','MessageController@index');    
    $router->post('message','MessageController@createMessage');
    $router->get('conversation', 'ConversationController@loadMessages');

    $router->get('user', 'UserController@show');
    $router->patch('user', 'UserController@update');
});

$router->get('/admin', 'AdminController@show');

$router->group(['prefix' => 'v1/admin', 'middleware' => 'admin'], function($router)
{
    $router->get('/', 'AdminController@index');
    $router->get('/conversation', 'AdminController@conversationIndex');
    $router->get('/conversation/{id}', 'AdminController@conversationShow');
    $router->delete('/conversation/{id}', 'AdminController@conversationDelete');
    $router->post('message', 'AdminController@messageSend');
    $router->delete('message/{id}', 'AdminController@messageDelete');
});