<?php

use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/ping', function(){
    return 'pong';
});

Route::post('/', [UserController::class, 'store']);
Route::get('/', [UserController::class, 'index']);
Route::post('/{id}', [UserController::class, 'update']);
Route::delete('/{id}', [UserController::class, 'destroy']);
Route::get('/{id}', [UserController::class, 'show']);