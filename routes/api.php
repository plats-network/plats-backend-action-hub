<?php

use App\Http\Controllers\Api\{
    Task,
    TaskLocation,
    UserTask,
    Wallet,
    Box,
    Vouchers,
    QrCode
};
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
    Route::get('/doing', 'getTaskDoing');
    Route::post('/', 'create');
    Route::get('/{id}', 'detail')->whereUuid('id');
    Route::post('/{id}/start/{location_id}', 'startTask')->whereUuid('id')->whereUuid('location_id');
    Route::post('/{id}/check-in/{location_id}', 'checkIn')->whereUuid('id')->whereUuid('location_id');
    Route::patch('/{id}/cancel', 'cancel')->whereUuid('id');

    Route::prefix('{id}/locations')->controller(TaskLocation::class)->group(function () {
        Route::post('/', 'create');
    });
});

Route::get('/my-tasks', [UserTask::class, 'histories']);
Route::resource('boxes', Box::class)->only(['index', 'update']);
Route::get('box_use',[Box::class, 'used'])->name('box_use');
Route::resource('vouchers', Vouchers::class)->only(['index', 'show']);
Route::resource('{id}/qr_code', QrCode::class)->only(['index']);

Route::prefix('wallet')->controller(Wallet::class)->group(function () {
    Route::post('/withdraw', 'withdraw');
});
