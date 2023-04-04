<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\{
    Dashboard, Reward, Event, TaskBeta,
    Group, User, Export
};
use App\Http\Controllers\Auth\Admin\Register;
use App\Http\Controllers\Auth\Admin\ForgotPassword;

Route::get('/', [Dashboard::class, 'index'])->name(DASHBOARD_ADMIN_ROUTER);
Route::get('register', [Register::class, 'create'])->name('auth.create');
Route::post('register', [Register::class, 'store'])->name('auth.store');
Route::get('forget-password', [ForgotPassword::class, 'showForgetPasswordForm'])->name('admin.forget.password.get');
Route::post('forget-password', [ForgotPassword::class, 'submitForgetPasswordForm'])->name('admin.forget.password.post');
Route::get('reset-password/{token}', [ForgotPassword::class, 'showResetPasswordForm'])->name('admin.reset.password.get');
Route::post('reset-password', [ForgotPassword::class, 'submitResetPasswordForm'])->name('admin.reset.password.post');
Route::get('/verify/{code}', [Register::class, 'verify'])->name(VERIFY_EMAIL);
// Task management
Route::prefix('tasks')->controller(TaskBeta::class)->group(function () {
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
    Route::get('/preview/{task_id}', 'preview');
    Route::get('/edit/{task_id}', 'edit');
    Route::get('/create', 'create');
    Route::get('/api/{task_id}', 'apiUserEvent');
    Route::get('/{task_id}', 'userEvent')->name(EVENT_USER_ADMIN_ROUTER);
});
Route::prefix('groups')->controller(Group::class)->group(function () {
    Route::get('/', 'index')->name(GROUP_LIST_ADMIN_ROUTER);
});
Route::prefix('users')->controller(User::class)->group(function () {
    Route::get('/', 'index')->name(USER_LIST_ADMIN_ROUTER);
    Route::get('/list', 'apiListUser');
});
Route::prefix('export')->controller(Export::class)->group(function () {
    Route::post('/user-join-event', 'userJoinEvent');
});
Route::prefix('api')->group(function($router) {
    Route::get('events/confirm-ticket/', [\App\Http\Controllers\Admin\Api\Event::class, 'confirmTicket'])->middleware('client_admin');
    Route::post('events/change-status', [\App\Http\Controllers\Admin\Api\Event::class, 'changeStatus']);
    Route::post('events/change-status-detail', [\App\Http\Controllers\Admin\Api\Event::class, 'changeStatusDetail']);
    $router->resource('groups', \App\Http\Controllers\Admin\Api\Group::class)->only(['index', 'store', 'show', 'destroy']);
    $router->resource('events', \App\Http\Controllers\Admin\Api\Event::class)->only(['index', 'store', 'show', 'destroy']);
    Route::prefix('rewards')->controller(\App\Http\Controllers\Admin\Api\Reward::class)->group(function ($router) {
        $router->get('/', 'index');
        $router->get('/edit/{id}', 'edit')->whereUuid('id');
        $router->post('/store', 'store');
        $router->get('/delete/{id}', 'destroy')->whereUuid('id');
    });
    Route::prefix('tasks-cws')->controller(\App\Http\Controllers\Admin\Api\Tasks::class)->group(function ($router) {
        $router->get('/', 'index');
        $router->get('/edit/{id}', 'edit')->whereUuid('id');
        $router->post('/store', 'store');
        $router->get('/delete/{id}', 'destroy')->whereUuid('id');
    });
});
