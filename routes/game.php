<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Game\HomeController;

// Demo
Route::get('game/{id}', [HomeController::class, 'miniGame'])->name('game.miniGame');
Route::post('game/result', [HomeController::class, 'updateResult'])->name('game.updateResult');

// Api
Route::get('/api/v1/day1-codes', [HomeController::class, 'dayOne'])->name('game.dayOne');
Route::get('/api/v1/day2-codes', [HomeController::class, 'dayTwo'])->name('game.dayTwo');
Route::get('/api/v1/booth-codes', [HomeController::class, 'boothCodes'])->name('game.boothCodes');

