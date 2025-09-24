<?php

use App\Http\Controllers\AvailabilityController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\UserController;


Route::post('login', [UserController::class, 'login']);

Route::middleware(['auth:sanctum'])->group(function () {
    Route::get('auth', [UserController::class, 'auth']);
    Route::resource('tasks', TaskController::class)->only(['index', 'show']);
    Route::put('tasks/{task}/status', [TaskController::class, 'updateStatus']);
    Route::get('/notifications', [NotificationController::class, 'showNotifications']);
    Route::put('/notifications', [NotificationController::class, 'markAsRead']);
    Route::get('/availability', [AvailabilityController::class, 'index']);
    Route::put('/availability', [AvailabilityController::class, 'update']);

    Route::middleware(['role:manager'])->group(function () {
        Route::resource('tasks', TaskController::class)->only(['store', 'update', 'destroy']);
    });
});
