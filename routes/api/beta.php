<?php

use Illuminate\Support\Facades\Route;


//tasks
Route::group(['prefix' => 'tasks'], function () {
    
    Route::put('/{taskId}', [App\Http\Controllers\Api\Beta\Admin\TaskController::class, 'update']);

    Route::delete('/{taskId}', [App\Http\Controllers\Api\Beta\Admin\TaskController::class, 'delete']);

    #upfile
    Route::post('/upload-single', [App\Http\Controllers\Api\Beta\Admin\TaskController::class, 'upload']);
});
