<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\TaskController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::post('login', [AuthController::class, 'login']);
Route::post('logout', [AuthController::class, 'logout']);
Route::middleware('auth:sanctum')->group(function () {
    Route::post('task-list', [TaskController::class, 'taskList']);
    Route::post('task-create', [TaskController::class, 'taskCreate']);
    Route::post('task-update', [TaskController::class, 'taskUpdate']);
    Route::post('task-delete', [TaskController::class, 'taskDelete']);
    Route::post('task-status-update', [TaskController::class, 'taskStatusUpdate']);
});
