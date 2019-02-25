<?php

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



Auth::routes();

Route::group(['middleware' => 'auth'], function() {
    Route::get('/', 'PostController@index');
    Route::post('/', 'PostController@store');
    Route::post('delete', 'PostController@delete');
    // Route::get('/', function () {
    //     return view('home');
    // });
    // Route::get('admin/', 'HomeController@index')->name('home');    
});

// Route::post('register', 'ExternalAuthController@register');
// Route::get('login', 'ExternalAuthController@showLoginForm');
Route::post('login', 'ExternalAuthController@login');
// Route::post('logout', 'ExternalAuthController@logout');

$this->get('admin/login', 'Auth\LoginController@showLoginForm')->name('admlogin');
// $this->post('login', 'Auth\LoginController@login');
// $this->post('logout', 'Auth\LoginController@logout')->name('logout');
// $this->get('register', 'Auth\RegisterController@showRegistrationForm')->name('register');
// $this->post('register', 'Auth\RegisterController@register');


