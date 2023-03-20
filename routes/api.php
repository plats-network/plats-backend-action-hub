<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\{
    Task, TaskLocation, UserTask,
    Wallet,
    QrCode, TaskNotice,
    Twitter, Social,TaskV2, Group,
    UserReward, Event
};

// Admin CWS
use App\Http\Controllers\Api\Admin\{
    Reward,
    Tasks,
    Event as CwsEvent,
    Group as CwsGroup
};
use App\Http\Controllers\Auth\Api\{
    Register,
    Login,
    RegisterAdmin
};
use App\Http\Controllers\Api\{
    Profile,
    ResetPassword,
    User
};

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

// Reset password
Route::post('reset-password', [ResetPassword::class, 'sendMail']);
Route::post('check-recovery-code', [ResetPassword::class, 'verifyCode']);
Route::put('reset-password', [ResetPassword::class, 'reset']);
Route::get('ticket/{id}', [User::class, 'getTicket'])->name('user.getTicket');

Route::middleware('auth:api')->group(function ($router) {
    $router->post('refresh', [Login::class, 'refresh']);
    $router->get('account-socials', [User::class, 'getAccountSocial'])->name('account.social');
    $router->delete('delete-account', [User::class, 'deleteAccount'])->name('delete.account');
    $router->prefix('profile')->group(function ($router) {
        $router->get('/', [Profile::class, 'index']);
        $router->put('/', [Profile::class, 'update']);
        $router->post('/upload-avatar', [Profile::class, 'updateAvatar']);
        $router->post('/password', [Profile::class, 'changePassword']);
        $router->post('/update-social', [Profile::class, 'updateSocialAccount']);
    });
    $router->prefix('wallet')->group(function ($router) {
        $router->post('withdraw', [Wallet::class, 'withdraw']);
    });
});

Route::prefix('cws')->group(function($router) {
    Route::get('events/list', [CwsEvent::class, 'webList']);
    Route::post('events/change-status', [CwsEvent::class, 'changeStatus']);
    $router->resource('groups', CwsGroup::class)->only(['index', 'store', 'show', 'destroy']);
    $router->resource('events', CwsEvent::class)->only(['index', 'store', 'show', 'destroy']);
});

Route::prefix('tasks')->controller(Task::class)->group(function ($router) {
   $router->get('/', 'index');
   $router->get('/doing', 'getTaskDoing');
   $router->post('/', 'create');
   $router->get('/{id}', 'detail')->whereUuid('id');
   $router->post('/{id}/check-in/{location_id}', 'checkIn')->whereUuid('id')->whereUuid('location_id');
   $router->patch('/{id}/cancel', 'cancel')->whereUuid('id');
   $router->post('/{id}/social/{social_id}', [Social::class, 'update'])->name('task.social.update');
   $router->post('like-pin', 'taskAction')->name('task.action');
   $router->post('start-cancel', 'startTask')->name('task.startTask');
   $router->get('my-tasks', 'myTasks')->name('task.myTasks');
   $router->prefix('{id}/locations')->controller(TaskLocation::class)->group(function ($router) {
       $router->post('/', 'create');
   });
});

Route::get('event-imprgress', [Event::class, 'index'])->name('event.improgress');
Route::get('top-events', [Task::class, 'getEventTaskHots'])->name('task.event.top-events');
Route::prefix('qr')->controller(QrCode::class)->group(function($router) {
    $router->post('qr-event', 'qrEvent')->name('qr.qrEvent');
});

Route::prefix('rewards')->controller(Reward::class)->group(function ($router) {
    $router->get('/', 'index');
    $router->get('/edit/{id}', 'edit')->whereUuid('id');
    $router->post('/store', 'store');
    $router->get('/delete/{id}', 'destroy')->whereUuid('id');
});
Route::prefix('tasks-cws')->controller(Tasks::class)->group(function ($router) {
    $router->get('/', 'index');
    $router->get('/edit/{id}', 'edit')->whereUuid('id');
    $router->post('/store', 'store');
    $router->get('/delete/{id}', 'destroy')->whereUuid('id');
});

Route::resource('task_notices', TaskNotice::class)->only(['index']);
Route::get('get_task', [TaskNotice::class, 'getTask']);
Route::resource('twitter', Twitter::class)->only(['index', 'store']);
Route::resource('socials', Social::class)->only(['index']);
Route::post('social-start/{id}', [Social::class, 'start'])->name('social.start.task');

Route::prefix('wallet')->controller(Wallet::class)->group(function () {
    Route::post('/withdraw', 'withdraw');
});

Route::resource('groups', Group::class)->only(['index', 'show']);
Route::get('my-groups', [Group::class, 'myGroups'])->name('group.my-groups');
Route::post('join-group', [Group::class, 'joinGroup'])->name('group.join-group');
Route::resource('user-rewards', UserReward::class)->only(['index']);
