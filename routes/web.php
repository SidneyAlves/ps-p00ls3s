<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dimensions', function () {
    return view('welcome');
});

Route::post('/tasks/create', 'App\Http\Controllers\TaskController@store');
Route::get('/tasks/show', 'App\Http\Controllers\TaskController@show');
Route::put('/task/update/{id}', 'App\Http\Controllers\TaskController@update');
Route::delete('/task/destroy/{id}', 'App\Http\Controllers\TaskController@destroy');

Route::post('/dimensions/create', 'App\Http\Controllers\DimensionsController@store');
Route::get('/dimensions/show', 'App\Http\Controllers\DimensionsController@show');
Route::put('/dimension/update/{id}', 'App\Http\Controllers\DimensionsController@update');
Route::delete('/dimension/destroy/{id}', 'App\Http\Controllers\DimensionsController@destroy');