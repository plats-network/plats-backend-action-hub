<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\Dashboard;
use App\Http\Controllers\Admin\Task;

Route::get('/', [Dashboard::class, 'index'])->name(DASHBOARD_ADMIN_ROUTER);
Route::prefix('tasks')->controller(Task::class)->group(function () {
    Route::get('/', 'index')->name(TASK_LIST_ADMIN_ROUTER);
    Route::get('/create', 'create')->name(TASK_CREATE_ADMIN_ROUTER);
    Route::get('/edit/{id}', 'edit')->name(TASK_EDIT_ADMIN_ROUTER)->whereUuid('id');
    Route::post('/store', 'store')->name(TASK_STORE_ADMIN_ROUTER);
});
