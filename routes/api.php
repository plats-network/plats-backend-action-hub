<?php

use App\Http\Controllers\ActionHub\Task;
use App\Http\Controllers\ActionHub\TaskLocation;
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
Route::prefix('tasks')->controller(Task::class)->group(function () {
    Route::get('/', 'index');
    Route::post('/', 'create');
    Route::get('/{id}', 'detail')->whereUuid('id');

    Route::prefix('{id}/locations')->controller(TaskLocation::class)->group(function () {
        Route::post('/', 'create');
    });
});
