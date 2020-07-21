<?php

use Illuminate\Support\Facades\Route;

Route::prefix('admin')->middleware(['admin'])->namespace('Admin')->group(function() {

    Route::get('post/list', 'PostController@list');
    Route::any('post/edit', 'PostController@edit');
    Route::post('post/destroy', 'PostController@destroy');

});
