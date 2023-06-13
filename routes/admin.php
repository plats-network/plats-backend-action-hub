<?php


use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\{
    Dashboard, Reward, Event, TaskBeta,
    Group, User, Export, AuthController,
    ConfirmController
};
use App\Http\Controllers\Auth\Admin\{
    Register
};
use App\Http\Controllers\Auth\Admin\ForgotPassword;
use App\Http\Controllers\Admin\EventController;
use App\Http\Controllers\Admin\UploadController;

// NEW
Route::middleware(['guest', 'web'])->group(function($authRoute) {
    $authRoute->get('login', [AuthController::class, 'formLogin'])->name('cws.formLogin');
    $authRoute->post('loginPost', [AuthController::class, 'login'])->name('cws.login');

    // Register
    $authRoute->get('signup', [AuthController::class, 'fromSignUp'])->name('cws.fromSignUp');
    $authRoute->post('signupPost', [AuthController::class, 'register'])->name('cws.register');

    // Comfirm register
    $authRoute->get('confirm-regis/{token}', [ConfirmController::class, 'confirmRegis'])->name('cws.confirmRegis');
    $authRoute->get('resend-regis/{token}', [ConfirmController::class, 'resendConfirm'])->name('cws.resendConfirm');

    // Forgot
    $authRoute->get('forgot', [AuthController::class, 'formForgot'])->name('cws.formForgot');
    $authRoute->post('forgotPost', [AuthController::class, 'forgot'])->name('cws.forgot');
});

Route::middleware(['client_admin'])->group(function($cws) {
    $cws->get('/', [Dashboard::class, 'index'])->name('cws.home');
    $cws->get('logout', [AuthController::class, 'logout'])->name('cws.logout');
    $cws->get('setting', [User::class, 'setting'])->name('cws.setting');
    $cws->post('change-password', [User::class, 'changePassword'])->name('cws.changePassword');
    $cws->post('change-email', [User::class, 'changeEmail'])->name('cws.changeEmail');
    $cws->post('change-info', [User::class, 'changeInfo'])->name('cws.changeInfo');

    // User
    $cws->get('users', [User::class, 'index'])->name('cws.users');

    //Get event list
    $cws->get('event-list', [EventController::class, 'index'])->name('cws.eventList');
    //Event Create
    $cws->get('event-create', [EventController::class, 'create'])->name('cws.eventCreate');
    //Event Store
    $cws->post('event-store', [EventController::class, 'store'])->name('cws.eventStore');
    //Event Edit
    $cws->get('event-edit/{id}', [EventController::class, 'edit'])->name('cws.eventEdit');
    //Event Update
    $cws->post('event-update/{id}', [EventController::class, 'update'])->name('cws.eventUpdate');
    //Event Preview
    $cws->get('event-preview/{id}', [EventController::class, 'preview'])->name('cws.eventPreview');
    //Event Delete
    $cws->get('event-delete/{id}', [EventController::class, 'delete'])->name('cws.eventDelete');
    //Template form event
    $cws->get('event-template', [EventController::class, 'template'])->name('cws.eventTemplate');
});
//Upload file
/*Upload Single*/
Route::match(['patch', 'post'], 'upload-single', [UploadController::class, 'uploadSingle'])
    ->name('upload-storage-single')->withoutMiddleware(['csrf']);

//Upload Editor
Route::post('upload-editor', [UploadController::class, 'uploadEditor2'])->name('uploadEditor')->withoutMiddleware(['csrf']);
/*Delete image*/
Route::delete('delete-image', [UploadController::class, 'uploadDelete'])->name('delete-image')->withoutMiddleware(['csrf']);


// OLD
// Route::get('/', [Dashboard::class, 'index'])->name(DASHBOARD_ADMIN_ROUTER);
// Route::get('register', [Register::class, 'create'])->name('auth.create');
// Route::post('register', [Register::class, 'store'])->name('auth.store');
// Route::get('forget-password', [ForgotPassword::class, 'showForgetPasswordForm'])->name('admin.forget.password.get');
// Route::post('forget-password', [ForgotPassword::class, 'submitForgetPasswordForm'])->name('admin.forget.password.post');
// Route::get('reset-password/{token}', [ForgotPassword::class, 'showResetPasswordForm'])->name('admin.reset.password.get');
// Route::post('reset-password', [ForgotPassword::class, 'submitResetPasswordForm'])->name('admin.reset.password.post');
// Route::get('/verify/{code}', [Register::class, 'verify'])->name('cws.verify');
// Task management
Route::prefix('tasks')->controller(TaskBeta::class)->group(function () {
    Route::get('/', 'index')->name('cws.tasks');
    Route::get('edit/{id}', 'edit')->whereUuid('id');
    Route::get('create', 'create');
    Route::post('/save-avatar-api', 'uploadAvatar');
    Route::post('/save-sliders-api', 'uploadSliders');
});
Route::prefix('rewards')->controller(Reward::class)->group(function () {
    Route::get('/', 'index')->name('cws.rewards');
});
Route::prefix('events')->controller(Event::class)->group(function () {
    Route::get('/', 'index')->name('cws.events');
    Route::get('/preview/{task_id}', 'preview');
    Route::get('/edit/{task_id}', 'edit');
    Route::get('/create', 'create');
    Route::get('/api/{task_id}', 'apiUserEvent');
    Route::get('/{task_id}', 'userEvent')->name('cws.userEvent');
});
Route::prefix('groups')->controller(Group::class)->group(function () {
    Route::get('/', 'index')->name('cws.groups');
});
// Route::prefix('users')->controller(User::class)->group(function () {
//     Route::get('/', 'index')->name('cws.users');
//     Route::get('/list', 'apiListUser');
// });
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
