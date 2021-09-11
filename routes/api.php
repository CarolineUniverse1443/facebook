<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('getUsers', 'App\Http\Controllers\UsersController@getUsers');
Route::post('signUp', 'App\Http\Controllers\UsersController@signUp');
Route::post('signIn', 'App\Http\Controllers\UsersController@signIn');
Route::post('exit', 'App\Http\Controllers\UsersController@logOut');
Route::post('create', 'App\Http\Controllers\UsersController@addUser');
Route::patch('edit', 'App\Http\Controllers\UsersController@editProfile');
Route::post('delete', 'App\Http\Controllers\UsersController@deleteUser');