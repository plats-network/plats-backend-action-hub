<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use App\Events\NextQuestionEvent;
use App\Events\NotificationEvent;
use App\Events\TotalPointEvent;
use Illuminate\Support\Facades\Cache;

use App\Http\Controllers\Web\{
    Home,
    Detail,
    Likes,
    Job,
    PagesController,
    QuizGameController,
    UserController
};

use App\Http\Controllers\Web\Auth\{
    Login,
    SignUp,
    ForgotPassword
};

Route::middleware(['guest'])->group(function ($auth) {
    // Login social
    Route::get('login/{providerName}', [Login::class, 'redirectToProvider']);
    Route::post('login/{providerName}/callback', [Login::class, 'handleProviderCallback']);

    // Login
    $auth->get('login', [Login::class, 'showFormLogin'])->name('web.formLogin');
    $auth->post('login', [Login::class, 'login'])->name('web.login');

    $auth->get('login-guest', [Login::class, 'formLoginGuest'])->name('web.formLoginGuest');
    $auth->post('login-guest', [Login::class, 'loginGuest'])->name('web.loginGuest');

    // Comfirm register
    // $auth->get('confirm/{token}', [SignUp::class, 'confirmRegis'])->name('')

    // Forgot password
    $auth->get('forget-password', [ForgotPassword::class, 'showForgetPasswordForm'])->name('web.formForgot');
    $auth->post('forget-password', [ForgotPassword::class, 'submitForgetPasswordForm'])->name('forget.password.post');

    // Action reset
    $auth->get('reset-password/{token}', [ForgotPassword::class, 'showResetPasswordForm'])->name('reset.password.get');
    $auth->post('reset-password', [ForgotPassword::class, 'submitResetPasswordForm'])->name('reset.password.post');

    // Sign up
    $auth->get('sign-up', [SignUp::class, 'showSignup'])->name('web.formSignup');
    $auth->post('sign-up', [SignUp::class, 'store'])->name('web.signUp');
});

Route::get('/', [Home::class, 'index'])->name('web.home');
Route::get('event-lists', [Home::class, 'events'])->name('web.events');
Route::get('event/{id}', [Home::class, 'show'])->name('web.events.show');
Route::get('events/code', [Job::class, 'index'])->name('web.eventCode');
Route::get('solution', [PagesController::class, 'solution'])->name('web.solution');
Route::get('template', [PagesController::class, 'template'])->name('web.template');
Route::get('pricing', [PagesController::class, 'pricing'])->name('web.pricing');
Route::get('resource', [PagesController::class, 'resource'])->name('web.resource');
Route::get('contact', [PagesController::class, 'contact'])->name('web.contact');

Route::middleware(['user_event'])->group(function ($r) {
    $r->get('logout', [Login::class, 'logout'])->name('web.logout');
    $r->get('event-job/{id}', [Home::class, 'jobEvent'])->name('web.jobEvent');
    $r->get('profile', [UserController::class, 'profile'])->name('web.profile');
});

Route::get('/discord/login', [App\Http\Controllers\Web\Discord::class, 'getUserDiscord']);
Route::get('/discord', [App\Http\Controllers\Web\Discord::class, 'index'])->name('discord');
Route::get('/telegram', [App\Http\Controllers\Web\Discord::class, 'telegram'])->name('telegram');
Route::get('logout-discord', [App\Http\Controllers\Web\Discord::class, 'logout']);
Route::get('/events/list', [Home::class, 'webList']);
Route::post('/create-user', [Job::class, 'createUser'])->name('web.createUser');

Route::get('/events/history/list', [Job::class, 'apiList']);
Route::get('/events/history/user', [Home::class, 'apiList']);
Route::get('/events/likes', [Likes::class, 'index'])->name('web.like');;
Route::get('/events/task/{id}', [Detail::class, 'edit'])->whereUuid('id');
Route::post('/events/likes', [Detail::class, 'like']);
Route::get('/events/download-ticket/{id}', [Detail::class, 'downloadTicket']);
Route::get('/events/likes/list', [Detail::class, 'listLike']);
Route::get('/events/user/ticket', [Detail::class, 'userTicket']);
Route::post('/events/ticket', [Detail::class, 'addTicket'])->name('web.event.addTicket');
Route::get('/events/{slug}', [Detail::class, 'index']);


// QUIZ
Route::get('/quiz-game/answers/{eventId}', [QuizGameController::class, 'showAnswers'])->name('quiz-name.answers');
Route::prefix('quiz-game')->group(function () {
    Route::middleware('user_event')->group(function () {
        // Route::get('/answers/{eventId}', [QuizGameController::class, 'showAnswers'])->name('quiz-name.answers');
        Route::post('/send-total-score', [QuizGameController::class, 'sendTotalScore']);
    });
});
