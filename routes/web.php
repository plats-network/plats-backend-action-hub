<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;

use App\Http\Controllers\Web\{
    Dashboard,
    Detail,
    Likes,
    HistoryJoinEventTask
};

use App\Http\Controllers\Web\Auth\{
    Login,
    SignUp,
    ForgotPassword
};

Route::prefix('client')->group(function ($router) {
    $router->get('/login', [Login::class, 'showFormLogin'])->name(LOGIN_WEB_ROUTE);
    $router->post('/login', [Login::class, 'login']);
    $router->get('forget-password', [ForgotPassword::class, 'showForgetPasswordForm'])->name('forget.password.get');
    $router->post('forget-password', [ForgotPassword::class, 'submitForgetPasswordForm'])->name('forget.password.post');
    $router->get('reset-password/{token}', [ForgotPassword::class, 'showResetPasswordForm'])->name('reset.password.get');
    $router->post('reset-password', [ForgotPassword::class, 'submitResetPasswordForm'])->name('reset.password.post');
    $router->get('/sign-up', [SignUp::class, 'showSignup'])->name('web.client.showSignup');
    $router->post('/sign-up', [SignUp::class, 'store'])->name('web.client.signUp');
    $router->get('/logout', [Login::class, 'logout'])->name(LOGOUT_WEB_ROUTE);
});

Route::get('/', [Dashboard::class, 'index'])->name(DASHBOARD_WEB_ROUTER);
Route::get('events/list', [\App\Http\Controllers\Admin\Api\Event::class, 'webList']);
Route::post('/create-user', [HistoryJoinEventTask::class, 'createUser'])->name(CREATE_USER_WEB_ROUTE);
Route::get('/events/code', [HistoryJoinEventTask::class, 'index']);
Route::get('/events/history/list', [HistoryJoinEventTask::class, 'apiList']);
Route::get('/events/history/user', [Dashboard::class, 'apiList']);
Route::get('/events/likes', [Likes::class, 'index'])->name(LIKE_WEB_ROUTER);;
Route::get('/events/task/{id}', [Detail::class, 'edit'])->whereUuid('id');
Route::post('/events/likes', [Detail::class, 'like']);
Route::get('/events/download-ticket/{id}', [Detail::class, 'downloadTicket']);
Route::get('/events/likes/list', [Detail::class, 'listLike']);
Route::get('/events/user/ticket', [Detail::class, 'userTicket']);
Route::post('/events/ticket', [Detail::class, 'addTicket'])->name('web.event.addTicket');
Route::get('/events/{slug}', [Detail::class, 'index']);
