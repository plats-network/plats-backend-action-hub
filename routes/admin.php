<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\{
    Dashboard, Reward,Event
};
use App\Http\Controllers\Auth\Admin\Register;

Route::get('/', [Dashboard::class, 'index'])->name(DASHBOARD_ADMIN_ROUTER);
Route::get('register', [Register::class, 'create'])->name('auth.create');
Route::post('register', [Register::class, 'store'])->name('auth.store');
Route::get('/verify/{code}', [Register::class, 'verify'])->name(VERIFY_EMAIL);
// Task management
Route::prefix('tasks')->controller(\App\Http\Controllers\Admin\TaskBeta::class)->group(function () {
    Route::get('/', 'index')->name(TASK_LIST_ADMIN_ROUTER);
    Route::get('edit/{id}', 'edit')->whereUuid('id');
    Route::get('create', 'create');
    Route::post('/save-avatar-api', 'uploadAvatar');
    Route::post('/save-sliders-api', 'uploadSliders');
});


Route::prefix('rewards')->controller(Reward::class)->group(function () {
    Route::get('/', 'index')->name(REWARD_LIST_ADMIN_ROUTER);
});

Route::prefix('events')->controller(Event::class)->group(function () {
    Route::get('/', 'index')->name(EVENT_LIST_ADMIN_ROUTER);
    Route::get('/api/{task_id}', 'apiUserEvent');
    Route::get('/{task_id}', 'userEvent')->name(EVENT_USER_ADMIN_ROUTER);
});

Route::prefix('groups')->controller(\App\Http\Controllers\Admin\Group::class)->group(function () {
    Route::get('/', 'index')->name(GROUP_LIST_ADMIN_ROUTER);
});
Route::prefix('users')->controller(\App\Http\Controllers\Admin\User::class)->group(function () {
    Route::get('/', 'index')->name(USER_LIST_ADMIN_ROUTER);
    Route::get('/list', 'apiListUser');
});

