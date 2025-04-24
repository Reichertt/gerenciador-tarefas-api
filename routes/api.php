<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\TagController;

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login',    [AuthController::class, 'login']);

Route::middleware('auth:api')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::get('/me',      [AuthController::class, 'me']);

    // Protegendo rotas
    Route::post('/tarefas/filtrar', [App\Http\Controllers\TarefaController::class, 'filtrar']);
    Route::apiResource('tarefas', App\Http\Controllers\TarefaController::class);
    Route::get('/tags', [TagController::class, 'index']);
    Route::post('/tags', [TagController::class, 'store']);
    Route::put('/tags/{id}', [TagController::class, 'update']);
    Route::delete('/tags/{id}', [TagController::class, 'destroy']);
    Route::get('/tags/{id}', [TagController::class, 'show']);
    
});
