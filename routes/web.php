<?php

use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;


//Route::get('/tasks', [TaskController::class, 'index']);
Route::get('/{page}', AuthController::class)->where('page', '.*');

