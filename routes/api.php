<?php

use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::post('/', [UserController::class, 'create']);
Route::get('/', [UserController::class, 'read']);
Route::post('/{id}', [UserController::class, 'update']);
Route::delete('/{id}', [UserController::class, 'delete']);
Route::get('/{id}', [UserController::class, 'findById']);