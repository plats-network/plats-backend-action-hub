<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Web\{
    Dashboard, Detail, Likes,HistoryJoinEventTask
};
use App\Http\Controllers\Web\Auth\{Login, SignUp,ForgotPassword};
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
Route::prefix('client')->group(function () {
    Route::get('/login', [Login::class, 'showFormLogin'])->name(LOGIN_WEB_ROUTE);
    Route::post('/login', [Login::class, 'login']);
    Route::get('forget-password', [ForgotPassword::class, 'showForgetPasswordForm'])->name('forget.password.get');
    Route::post('forget-password', [ForgotPassword::class, 'submitForgetPasswordForm'])->name('forget.password.post');
    Route::get('reset-password/{token}', [ForgotPassword::class, 'showResetPasswordForm'])->name('reset.password.get');
    Route::post('reset-password', [ForgotPassword::class, 'submitResetPasswordForm'])->name('reset.password.post');
    Route::get('/sign-up', [SignUp::class, 'showSignup'])->name('web.client.showSignup');
    Route::post('/sign-up', [SignUp::class, 'store'])->name('web.client.signUp');
    Route::get('/logout', [Login::class, 'logout'])->name(LOGOUT_WEB_ROUTE);
});
Route::get('/', [Dashboard::class, 'index'])->name(DASHBOARD_WEB_ROUTER);
Route::get('/events/code', [HistoryJoinEventTask::class, 'index']);
Route::get('/events/history/list', [HistoryJoinEventTask::class, 'apiList']);
Route::get('/events/likes', [Likes::class, 'index'])->name(LIKE_WEB_ROUTER);;
Route::get('/events/task/{id}', [Detail::class, 'edit'])->whereUuid('id');
Route::post('/events/likes', [Detail::class, 'like']);
Route::get('/events/download-ticket/{id}', [Detail::class, 'downloadTicket']);
Route::get('/events/likes/list', [Detail::class, 'listLike']);
Route::get('/events/user/ticket', [Detail::class, 'userTicket']);
Route::get('/events/confirm-ticket/', [Detail::class, 'confirmTicket']);
Route::post('/events/ticket', [Detail::class, 'addTicket'])->name('web.event.addTicket');
Route::get('/events/{slug}', [Detail::class, 'index']);



