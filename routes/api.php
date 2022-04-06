<?php

use App\Http\Controllers\ActionHub\Mission;
use App\Http\Controllers\ActionHub\Task;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/
Route::prefix('missions')->controller(Mission::class)->group(function () {
    Route::get('/', 'index');
    Route::post('/', 'create');
    Route::get('/{id}', 'detail')->whereUuid('id');

    Route::prefix('{id}/task')->controller(Task::class)->group(function () {
        Route::post('/', 'create');
    });
});
