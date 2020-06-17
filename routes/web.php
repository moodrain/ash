<?php

use Illuminate\Support\Facades\Route;

Route::view('/login', 'user.login')->name('login');
Route::view('register', 'user.register');
Route::post('login', 'UserController@login');
Route::post('register', 'UserController@register');


Route::middleware(['auth'])->group(function() {

    Route::view('/', 'index');
    Route::post('logout', 'UserController@logout');

    Route::get('post/list', 'PostController@list');
    Route::any('post/edit', 'PostController@edit');
    Route::post('post/destroy', 'PostController@destroy');

});