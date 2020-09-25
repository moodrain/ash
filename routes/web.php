<?php

use Illuminate\Support\Facades\Route;

Route::any('login', [\App\Http\Controllers\UserController::class, 'login'])->name('login');
Route::any('register', [\App\Http\Controllers\UserController::class, 'register']);

Route::middleware(['auth'])->group(function() {

    Route::view('/', 'index');
    Route::post('logout', [\App\Http\Controllers\UserController::class, 'logout']);

    Route::post('subject/upload', [\App\Http\Controllers\SubjectController::class, 'upload']);

    Route::any('subject/edit', [\App\Http\Controllers\SubjectController::class, 'edit']);
    Route::post('subject/comment', [\App\Http\Controllers\SubjectController::class, 'comment']);

});

Route::get('subject', [\App\Http\Controllers\SubjectController::class, 'list']);
Route::get('subject/{subject}', [\App\Http\Controllers\SubjectController::class, 'show']);
Route::any('subject/upload/{file}', [\App\Http\Controllers\SubjectController::class, 'upload']);

require __DIR__ . '/admin.php';