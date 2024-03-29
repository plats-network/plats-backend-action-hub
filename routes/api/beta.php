<?php

use App\Http\Controllers\Api\Beta\Admin\EventController;
use App\Http\Controllers\Api\Beta\Admin\ShortLinkController;
use App\Http\Controllers\Api\Beta\Admin\TaskController;
use Illuminate\Support\Facades\Route;


//tasks
Route::group(['prefix' => 'tasks'], function () {
    
    Route::put('/{taskId}', [App\Http\Controllers\Api\Beta\Admin\TaskController::class, 'update']);

    Route::delete('/{taskId}', [App\Http\Controllers\Api\Beta\Admin\TaskController::class, 'delete']);

    #upfile
    Route::post('/upload-single', [App\Http\Controllers\Api\Beta\Admin\TaskController::class, 'upload']);

    Route::get('get-tasks', [TaskController::class, 'index']);

    Route::get('detail', [TaskController::class, 'show']);

    Route::post('event-create', [TaskController::class, 'store']);
});

Route::post('short-link', [ShortLinkController::class, 'create']);

Route::post('event-job/{code}', [EventController::class, 'updateJob']);

Route::post('job-sort/{id}', [EventController::class, 'updateJobSort']);

Route::post('update-boot-detail', [EventController::class, 'updateBoothDetail']);

Route::post('create-short-link/{code}', [EventController::class, 'createShortLink']);
