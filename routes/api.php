<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TarefaController;
use App\Http\Controllers\TagController;

Route::apiResource('tarefas', TarefaController::class);
Route::apiResource('tags', TagController::class);
Route::post('/tarefas/filtrar', [TarefaController::class, 'filtrar']);
