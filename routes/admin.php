<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\{
    Dashboard, Task, Guild,
    Company, Reward
};
use App\Http\Controllers\Auth\Admin\Register;

Route::get('/', [Dashboard::class, 'index'])->name(DASHBOARD_ADMIN_ROUTER);
Route::get('register', [Register::class, 'create'])->name('auth.create');
Route::post('register', [Register::class, 'store'])->name('auth.store');

// Task management
Route::prefix('tasks-beta')->controller(\App\Http\Controllers\Admin\TaskBeta::class)->group(function () {
    Route::get('/', 'index')->name(TASK_BETA_LIST_ADMIN_ROUTER);
    Route::get('edit/{id}', 'edit')->whereUuid('id');
    Route::get('create', 'create');
    Route::post('/save-avatar-api', 'uploadAvatar');
    Route::post('/save-sliders-api', 'uploadSliders');
});

Route::prefix('tasks')->controller(Task::class)->group(function () {
    Route::get('/', 'index')->name(TASK_LIST_ADMIN_ROUTER);
    Route::get('create', 'create')->name(TASK_CREATE_ADMIN_ROUTER);
    Route::get('edit/{id}', 'edit')->name(TASK_EDIT_ADMIN_ROUTER)->whereUuid('id');
    Route::post('store', 'store')->name(TASK_STORE_ADMIN_ROUTER);
    Route::get('deposit/{id}', 'deposit')->name(TASK_DEPOSIT_ADMIN_ROUTER)->whereUuid('id');
});
// Company management
Route::prefix('companies')->controller(Company::class)->group(function () {
    Route::get('/', 'index')->name(COMPANY_LIST_ADMIN_ROUTER);
    Route::get('create', 'create')->name(COMPANY_CREATE_ADMIN_ROUTER);
    Route::get('edit/{id}', 'edit')->name(COMPANY_EDIT_ADMIN_ROUTER)->whereUuid('id');
    Route::post('store', 'store')->name(COMPANY_STORE_ADMIN_ROUTER);
});

// Reward management Chua co controller len commnet
Route::prefix('rewards')->controller(Reward::class)->group(function () {
    Route::get('/', 'index')->name(REWARD_LIST_ADMIN_ROUTER);
    Route::get('/create', 'create')->name(REWARD_CREATE_ADMIN_ROUTER);
    Route::get('/edit/{id}', 'edit')->name(REWARD_EDIT_ADMIN_ROUTER)->whereUuid('id');
    Route::post('/store', 'store')->name(REWARD_STORE_ADMIN_ROUTER);
});

Route::prefix('rewards/{reward}')->controller(DetailReward::class)->group(function() {
    Route::get('/lists', 'index')->name(DETAIL_REWARD_LIST_ADMIN_ROUTER);
    Route::get('/create', 'create')->name(DETAIL_REWARD_CREATE_ADMIN_ROUTER);
    Route::get('/edit/{id}', 'edit')->name(DETAIL_REWARD_EDIT_ADMIN_ROUTER)->whereUuid('id');
    Route::post('/store', 'store')->name(DETAIL_REWARD_STORE_ADMIN_ROUTER);
});

Route::prefix('guilds')->controller(Guild::class)->group(function () {
    Route::get('/', 'index')->name(GUILD_LIST_ADMIN_ROUTER);
});
