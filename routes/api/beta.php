<?php

use App\Http\Controllers\Api\beta\TestController;
use Illuminate\Support\Facades\Route;

Route::get('test', [TestController::class, 'index']);

//tasks
Route::group(['prefix' => 'tasks'], function () {

});
