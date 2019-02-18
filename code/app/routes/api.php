<?php

use Illuminate\Http\Request;

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

Route::post('login', 'UserController@login');
Route::post('register', 'UserController@register');

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::group(['middleware' => 'auth:api'], function() {
    Route::delete('post/{id}', 'PostController@destroy');
    Route::post('post', 'PostController@store');
    Route::put('post', 'PostController@store');

    Route::delete('author/{id}', 'AuthorController@destroy');
    Route::post('author', 'AuthorController@store');
    Route::put('author', 'AuthorController@store');

    Route::delete('tag/{id}', 'TagController@destroy');
    Route::post('tag', 'TagController@store');
    Route::put('tag', 'TagController@store');

    Route::post('logout', 'UserController@logout');
});


Route::get('posts', 'PostController@index');
Route::get('post/{id}', 'PostController@show');

Route::get('authors', 'AuthorController@index');
Route::get('author/{id}', 'AuthorController@show');

Route::get('tags', 'TagController@index');
Route::get('tag/{id}', 'TagController@show');

