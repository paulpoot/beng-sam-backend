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
    return "Lumen is running. Message history: <br />" . App\Message::all();
});

$router->group(['prefix' => 'v1'], function($router)
{
	$router->post('message','MessageController@createMessage');
});