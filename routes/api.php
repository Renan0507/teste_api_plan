<?php

use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/ping', function(){
    return 'pong';
});

Route::post('/', [UserController::class, 'store']);
Route::get('/', [UserController::class, 'index']);
Route::post('/{id}', [UserController::class, 'update']);
// O correto a se utilizar seria update com método PUT
// porém o php tem a limitação de não enviar arquivos via PUT, devido a isso foi utilizado o método POST
Route::delete('/{id}', [UserController::class, 'destroy']);
Route::get('/{id}', [UserController::class, 'show']);