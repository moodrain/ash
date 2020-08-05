<?php

use Illuminate\Support\Facades\Route;

Route::any('admin/login', 'Admin\UserController@login');

Route::prefix('admin')->middleware(['auth', 'admin'])->namespace('Admin')->group(function() {

    Route::view('/', 'admin/index');

    Route::get('post/list', 'PostController@list');
    Route::any('post/edit', 'PostController@edit');
    Route::post('post/destroy', 'PostController@destroy');

    Route::get('explorer', 'ExplorerController@index');
    Route::get('explorer/content', 'ExplorerController@content');
    Route::post('explorer/upload', 'ExplorerController@upload');
    Route::post('explorer/delete', 'ExplorerController@delete');
    Route::post('explorer/mkdir', 'ExplorerController@mkdir');
    Route::post('explorer/rmdir', 'ExplorerController@rmdir');
    Route::post('explorer/copy', 'ExplorerController@copy');
    Route::post('explorer/move', 'ExplorerController@move');


});
