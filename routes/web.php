<?php

use Illuminate\Support\Facades\Route;

Route::any('login', 'UserController@login')->name('login');
Route::any('register', 'UserController@register');

Route::get('subject', 'SubjectController@list');
Route::get('subject/{subject}', 'SubjectController@show');
Route::get('subject/upload/{file}', 'SubjectController@upload');

Route::middleware(['auth'])->group(function() {

    Route::view('/', 'index');
    Route::post('logout', 'UserController@logout');

    Route::post('subject/upload', 'SubjectController@upload');

    Route::any('subject/edit', 'SubjectController@edit');


});

require __DIR__ . '/admin.php';