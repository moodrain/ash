<?php

use Illuminate\Support\Facades\Route;

Route::any('login', 'UserController@login')->name('login');
Route::any('register', 'UserController@register');

Route::middleware(['auth'])->group(function() {

    Route::view('/', 'index');
    Route::post('logout', 'UserController@logout');

    Route::get('subject', 'SubjectController@list');
    Route::any('subject/edit', 'SubjectController@edit');
    Route::get('subject/{subject}', 'SubjectController@show');


});

require __DIR__ . '/admin.php';