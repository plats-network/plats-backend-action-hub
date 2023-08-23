<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Game\HomeController;

// Demo
Route::get('demo', [HomeController::class, 'demo'])->name('game.demo');

Route::get('session/{id}', [HomeController::class, 'gameSession'])->name('game.gameSession');
Route::get('booth/{id}', [HomeController::class, 'gameBooth'])->name('game.gameBooth');
Route::get('/update-session/{task_id}/{num}', [
    HomeController::class, 'updateSession'
])->name('home.updateSession');
Route::get('/update-booth/{task_id}/{num}', [
    HomeController::class, 'updateBooth'
])->name('home.updateBooth');
