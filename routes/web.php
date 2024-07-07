<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TaskController;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth', 'verified'])->group(function () {
    Route::inertia('/', 'Tasks')->name('dashboard');

    Route::middleware('auth')->group(function () {
        Route::group(['prefix' => 'profile', 'as' => 'profile.'], function () {
            Route::get('/', [ProfileController::class, 'edit'])->name('edit');
            Route::patch('/', [ProfileController::class, 'update'])->name('update');
            Route::delete('/', [ProfileController::class, 'destroy'])->name('destroy');
        });

        Route::group(['prefix' => 'tasks', 'as' => 'tasks.'], function () {
            Route::get('/', [TaskController::class, 'index'])->name('index');
            Route::patch('{task}', [TaskController::class, 'update'])->name('update');
            Route::post('/', [TaskController::class, 'store'])->name('store');
        });
    });
});
