<?php

use Illuminate\Support\Facades\Route;

Route::any('login', 'UserController@login')->name('login');
Route::any('register', 'UserController@register');

Route::middleware(['auth'])->group(function() {

    Route::view('/', 'index');
    Route::post('logout', 'UserController@logout');



});