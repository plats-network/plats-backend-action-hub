<?php

use App\Http\Controllers\Admin\Analytics;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\Dashboard;
use App\Http\Controllers\Admin\Task;
use App\Http\Controllers\Admin\Guild;

Route::get('/', [Dashboard::class, 'index'])->name(DASHBOARD_ADMIN_ROUTER);
Route::prefix('tasks')->controller(Task::class)->group(function () {
    Route::get('/', 'index')->name(TASK_LIST_ADMIN_ROUTER);
    Route::get('/create', 'create')->name(TASK_CREATE_ADMIN_ROUTER);
    Route::get('/edit/{id}', 'edit')->name(TASK_EDIT_ADMIN_ROUTER)->whereUuid('id');
    Route::post('/store', 'store')->name(TASK_STORE_ADMIN_ROUTER);
    Route::get('/deposit/{id}', 'deposit')->name(TASK_DEPOSIT_ADMIN_ROUTER)->whereUuid('id');
});

Route::prefix('guilds')->controller(Guild::class)->group(function () {
    Route::get('/', 'index')->name(GUILD_LIST_ADMIN_ROUTER);
});

Route::prefix('analytics')->controller(Analytics::class)->group(function () {
    Route::get('/', 'index')->name(ANALYSIS_DASHBOARD_ADMIN_ROUTER);
});
