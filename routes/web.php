<?php

use App\Http\Controllers\Admin\TaskController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('login');
});



Route::middleware('auth')->group(function () {
    Route::get('dashboard', [TaskController::class, 'index'])->name('dashboard');
    Route::post('task-store', [TaskController::class, 'store'])->name('task-store');
    Route::post('task-update', [TaskController::class, 'update'])->name('task-update');
    Route::post('task-status-update', [TaskController::class, 'statusUpdate'])->name('task-status-update');
    Route::get('task-edit', [TaskController::class, 'edit'])->name('task-edit');
    Route::post('task-delete/{id}', [TaskController::class, 'destroy'])->name('task-delete');
    Route::post('task-filter', [TaskController::class, 'taskFilter'])->name('task-filter');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';
