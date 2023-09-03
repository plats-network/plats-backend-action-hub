<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Game\HomeController;

// Demo
Route::get('game/{id}', [HomeController::class, 'miniGame'])->name('game.miniGame');
Route::post('game/result', [HomeController::class, 'updateResult'])->name('game.updateResult');

