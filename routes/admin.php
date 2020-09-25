<?php

use Illuminate\Support\Facades\Route;

Route::any('admin/login', [\App\Http\Controllers\Admin\UserController::class, 'login']);

Route::prefix('admin')->middleware(['auth', 'can:admin'])->group(function() {

    Route::view('/', 'admin/index');
    Route::post('logout', [\App\Http\Controllers\Admin\UserController::class, 'logout']);

    Route::get('subject/list', [\App\Http\Controllers\Admin\SubjectController::class, 'list']);
    Route::any('subject/edit', [\App\Http\Controllers\Admin\SubjectController::class, 'edit']);
    Route::post('subject/destroy', [\App\Http\Controllers\Admin\SubjectController::class, 'destroy']);

    Route::get('comment/list', [\App\Http\Controllers\Admin\CommentController::class, 'list']);
    Route::any('comment/edit', [\App\Http\Controllers\Admin\CommentController::class, 'edit']);
    Route::post('comment/destroy', [\App\Http\Controllers\Admin\CommentController::class, 'destroy']);

    Route::get('subject-category/list', [\App\Http\Controllers\Admin\SubjectCategoryController::class, 'list']);
    Route::any('subject-category/edit', [\App\Http\Controllers\Admin\SubjectCategoryController::class, 'edit']);
    Route::post('subject-category/destroy', [\App\Http\Controllers\Admin\SubjectCategoryController::class, 'destroy']);

    Route::get('explorer', [\App\Http\Controllers\Admin\ExplorerController::class, 'index']);
    Route::get('explorer/content', [\App\Http\Controllers\Admin\ExplorerController::class, 'content'])->name('explorer.content');
    Route::post('explorer/upload', [\App\Http\Controllers\Admin\ExplorerController::class, 'upload']);
    Route::post('explorer/delete', [\App\Http\Controllers\Admin\ExplorerController::class, 'delete']);
    Route::post('explorer/mkdir', [\App\Http\Controllers\Admin\ExplorerController::class, 'mkdir']);
    Route::post('explorer/rmdir', [\App\Http\Controllers\Admin\ExplorerController::class, 'rmdir']);
    Route::post('explorer/copy', [\App\Http\Controllers\Admin\ExplorerController::class, 'copy']);
    Route::post('explorer/move', [\App\Http\Controllers\Admin\ExplorerController::class, 'move']);

});
