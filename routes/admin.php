<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\{Dashboard, Task, Guild};

Route::get('/', [Dashboard::class, 'index'])->name(DASHBOARD_ADMIN_ROUTER);

// Task management
Route::prefix('tasks')->controller(Task::class)->group(function () {
    Route::get('/', 'index')->name(TASK_LIST_ADMIN_ROUTER);
    Route::get('/create', 'create')->name(TASK_CREATE_ADMIN_ROUTER);
    Route::get('/edit/{id}', 'edit')->name(TASK_EDIT_ADMIN_ROUTER)->whereUuid('id');
    Route::post('/store', 'store')->name(TASK_STORE_ADMIN_ROUTER);
    Route::get('/deposit/{id}', 'deposit')->name(TASK_DEPOSIT_ADMIN_ROUTER)->whereUuid('id');
});

// Reward management
// Route::prefix('rewards')->controller(Reward::class)->group(function () {
//     Route::get('/', 'index')->name(REWARD_LIST_ADMIN_ROUTER);
//     Route::get('/create', 'create')->name(REWARD_CREATE_ADMIN_ROUTER);
//     Route::get('/edit/{id}', 'edit')->name(REWARD_EDIT_ADMIN_ROUTER)->whereUuid('id');
//     Route::post('/store', 'store')->name(REWARD_STORE_ADMIN_ROUTER);
// });

// Guilds management
Route::prefix('guilds')->controller(Guild::class)->group(function () {
    Route::get('/', 'index')->name(GUILD_LIST_ADMIN_ROUTER);
});
