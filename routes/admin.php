<?php

use Illuminate\Support\Facades\Route;

$helper = new \App\Helpers\RouteHelper();

Route::any('admin/login', [\App\Http\Controllers\Admin\UserController::class, 'login']);

Route::middleware(['auth', 'can:admin'])->group(function() use ($helper) {

    $helper->resourceAdminRoutes(['subject', 'comment', 'subject-category']);

    Route::prefix('admin')->group(function() {

        Route::view('/', 'admin/index');
        Route::post('logout', [\App\Http\Controllers\Admin\UserController::class, 'logout']);

        Route::get('explorer', [\App\Http\Controllers\Admin\ExplorerController::class, 'index']);
        Route::get('explorer/content', [\App\Http\Controllers\Admin\ExplorerController::class, 'content'])->name('explorer.content');
        Route::post('explorer/upload', [\App\Http\Controllers\Admin\ExplorerController::class, 'upload']);
        Route::post('explorer/delete', [\App\Http\Controllers\Admin\ExplorerController::class, 'delete']);
        Route::post('explorer/mkdir', [\App\Http\Controllers\Admin\ExplorerController::class, 'mkdir']);
        Route::post('explorer/rmdir', [\App\Http\Controllers\Admin\ExplorerController::class, 'rmdir']);
        Route::post('explorer/copy', [\App\Http\Controllers\Admin\ExplorerController::class, 'copy']);
        Route::post('explorer/move', [\App\Http\Controllers\Admin\ExplorerController::class, 'move']);
    });

});
