<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of the routes that are handled
| by your application. Just tell Laravel the URIs it should respond
| to using a Closure or controller method. Build something great!
|
*/


$api = app('Dingo\Api\Routing\Router');

Route::get('/', function () {
    return view('welcome');
});

$api->version('v1',function($api){
    $api->post('register','App\Http\Controllers\HomeController@register');
    $api->post('login','App\Http\Controllers\HomeController@login');
});
