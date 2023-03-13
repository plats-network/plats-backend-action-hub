<?php

use App\Http\Controllers\Api\{
    Task, TaskLocation, UserTask,
    Wallet, Box, Gifts,
    QrCode, TaskNotice, LockTray,
    QrCodeAction, Twitter, Social,TaskV2,Group
};
use App\Http\Controllers\Api\Admin\{
    Reward,
    Tasks,
    Event as CwsEvent,
    Group as CwsGroup
};
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\Api\{Register, Login, RegisterAdmin};
use App\Http\Controllers\Api\{Profile, ResetPassword, TestUser, User};
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
// Register
Route::post('register_admin', [RegisterAdmin::class, 'store']);
Route::post('register', [Register::class, 'register']);
Route::post('register/confirm-email', [Register::class, 'confirmEmail']);
Route::post('register/resend-confirm-email', [Register::class, 'resendOtp']);

// Login
Route::post('login', [Login::class, 'login']);
Route::post('login/social', [Login::class, 'socialLogin']);
Route::get('login/apple', [Login::class, 'loginApple']);
Route::post('login/{providerName}/callback', [Login::class, 'callbackProvider']);

Route::resource('test_user', TestUser::class)->only(['index']);

// Reset password
Route::post('reset-password', [ResetPassword::class, 'sendMail']);
Route::post('check-recovery-code', [ResetPassword::class, 'verifyCode']);
Route::put('reset-password', [ResetPassword::class, 'reset']);

Route::middleware('auth:api')->group(function () {
    Route::post('refresh', [Login::class, 'refresh']);

    Route::prefix('profile')->group(function () {
        Route::get('/{userId}', [Profile::class, 'index']);
        Route::patch('/', [Profile::class, 'update']);
        Route::post('/upload-avatar', [Profile::class, 'updateAvatar']);
        Route::post('/password', [Profile::class, 'changePassword']);
        Route::post('/update-social', [Profile::class, 'updateSocialAccount']);
    });

    Route::prefix('wallet')->group(function () {
        Route::post('withdraw', [Wallet::class, 'withdraw']);
    });

    Route::get('account-socials', [User::class, 'getAccountSocial'])->name('account.social');
    Route::delete('delete-account', [User::class, 'deleteAccount'])->name('delete.account');
});

Route::prefix('cws')->group(function($router) {
    Route::get('events/list', [CwsEvent::class, 'webList']);
    $router->resource('groups', CwsGroup::class)->only(['index', 'store', 'show', 'destroy']);
    $router->resource('events', CwsEvent::class)->only(['index', 'store', 'show', 'destroy']);
    Route::post('events/change-status', [CwsEvent::class, 'changeStatus']);
});


//Route::prefix('tasks')->controller(Task::class)->group(function ($router) {
//    Route::get('/', 'index');
//    Route::get('/doing', 'getTaskDoing');
//    Route::post('/', 'create');
//    Route::get('/{id}', 'detail')->whereUuid('id');
//    // Route::post('/{id}/start/{location_id}', 'startTask')->whereUuid('id')->whereUuid('location_id');
//    Route::post('/{id}/check-in/{location_id}', 'checkIn')->whereUuid('id')->whereUuid('location_id');
//    Route::patch('/{id}/cancel', 'cancel')->whereUuid('id');
//
//    Route::prefix('{id}/locations')->controller(TaskLocation::class)->group(function () {
//        Route::post('/', 'create');
//    });
//
//    Route::post('/{id}/social/{social_id}', [Social::class, 'update'])->name('task.social.update');
//
//    $router->post('like-pin', 'taskAction')->name('task.action');
//    $router->post('start-cancel', 'startTask')->name('task.startTask');
//    $router->get('my-tasks', 'myTasks')->name('task.myTasks');
//});

Route::prefix('tasks-v2')->controller(TaskV2::class)->group(function () {
    Route::get('/', 'index');
    Route::get('/{id}', 'detail')->whereUuid('id');
});

Route::prefix('rewards')->controller(Reward::class)->group(function () {
    Route::get('/', 'index');
    Route::get('/edit/{id}', 'edit')->whereUuid('id');
    Route::post('/store', 'store');
    Route::get('/delete/{id}', 'destroy')->whereUuid('id');
});
Route::prefix('tasks-cws')->controller(Tasks::class)->group(function () {
    Route::get('/', 'index');
    Route::get('/edit/{id}', 'edit')->whereUuid('id');
    Route::post('/store', 'store');
    Route::get('/delete/{id}', 'destroy')->whereUuid('id');
});



// Route::get('/my-tasks', [UserTask::class, 'histories']);
Route::resource('boxes', Box::class)->only(['index', 'update', 'show']);
Route::resource('gifts', Gifts::class)->only(['index', 'show']);
Route::resource('{id}/qr_code', QrCode::class)->only(['index']);
Route::resource('task_notices', TaskNotice::class)->only(['index']);
Route::resource('lock_tray', LockTray::class)->only(['index', 'update']);
Route::get('get_task', [TaskNotice::class, 'getTask']);
Route::post('qr_code', [QrCodeAction::class, 'store'])->name('qrcode.store');
Route::resource('twitter', Twitter::class)->only(['index', 'store']);
Route::resource('socials', Social::class)->only(['index']);
Route::post('social-start/{id}', [Social::class, 'start'])->name('social.start.task');

Route::prefix('wallet')->controller(Wallet::class)->group(function () {
    Route::post('/withdraw', 'withdraw');
});

Route::resource('groups', Group::class)->only(['index', 'show']);
Route::get('my-groups', [Group::class, 'myGroups'])->name('group.my-groups');
Route::post('join-group', [Group::class, 'joinGroup'])->name('group.join-group');
