<?php

use Illuminate\Support\Facades\Route;

Route::any('admin/login', 'Admin\UserController@login');

Route::prefix('admin')->middleware(['admin'])->namespace('Admin')->group(function() {

    Route::view('/', 'admin/index');

    Route::get('post/list', 'PostController@list');
    Route::any('post/edit', 'PostController@edit');
    Route::post('post/destroy', 'PostController@destroy');

});
