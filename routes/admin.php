<?php

use Illuminate\Support\Facades\Route;

Route::any('admin/login', 'Admin\UserController@login');

Route::prefix('admin')->middleware(['auth', 'admin'])->namespace('Admin')->group(function() {

    Route::view('/', 'admin/index');

    Route::get('subject/list', 'SubjectController@list');
    Route::any('subject/edit', 'SubjectController@edit');
    Route::post('subject/destroy', 'SubjectController@destroy');

    Route::get('comment/list', 'CommentControoler@list');
    Route::any('comment/edit', 'CommentControoler@edit');
    Route::post('comment/destroy', 'CommentControoler@destroy');

    Route::get('subject-category/list', 'SubjectCategoryController@list');
    Route::any('subject-category/edit', 'SubjectCategoryController@edit');
    Route::post('subject-category/destroy', 'SubjectCategoryController@destroy');

    Route::get('explorer', 'ExplorerController@index');
    Route::get('explorer/content', 'ExplorerController@content');
    Route::post('explorer/upload', 'ExplorerController@upload');
    Route::post('explorer/delete', 'ExplorerController@delete');
    Route::post('explorer/mkdir', 'ExplorerController@mkdir');
    Route::post('explorer/rmdir', 'ExplorerController@rmdir');
    Route::post('explorer/copy', 'ExplorerController@copy');
    Route::post('explorer/move', 'ExplorerController@move');


});
