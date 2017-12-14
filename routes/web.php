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
/*
$router->get('/', function () use ($router) {
    return $router->app->version();
});
*/
$router->get('/', function () use ($router) {
    //return $router->app->version();
    $response = [
        'status' => 1,
        'data' => "Laravel 5.5.* Lumen 5.5.0 RESTful API"
    ];

    return response()->json($response, 200, [], JSON_PRETTY_PRINT);
});

$router->group(['prefix' => 'v1'], function($app)
{
    $app->get('code/search','CodeController@search');

});
