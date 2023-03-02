<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Web\{
    Dashboard, Detail, Likes
};
use App\Http\Controllers\Web\Auth\{Login, SignUp};
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
    Route::get('/sign-up', [SignUp::class, 'showSignup'])->name('web.client.showSignup');
    Route::post('/sign-up', [SignUp::class, 'store'])->name('web.client.signUp');
    Route::get('/logout', [Login::class, 'logout'])->name(LOGOUT_WEB_ROUTE);
});
Route::get('/', [Dashboard::class, 'index'])->name(DASHBOARD_WEB_ROUTER);;
Route::get('/events/likes', [Likes::class, 'index'])->name(LIKE_WEB_ROUTER);;
Route::get('/events/{slug}', [Detail::class, 'index']);
Route::get('/events/task/{id}', [Detail::class, 'edit'])->whereUuid('id');
Route::post('/events/likes', [Detail::class, 'like']);
Route::get('/events/likes/list', [Detail::class, 'listLike']);
Route::post('/events/ticket', [Detail::class, 'addTicket'])->name('web.event.addTicket');


