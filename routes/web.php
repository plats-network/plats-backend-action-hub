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

// Định nghĩa các route cho người dùng chưa đăng nhập (guest)
Route::middleware(['guest'])->group(function ($auth) {
    // Login social
    Route::get('login/{providerName}', [Login::class, 'redirectToProvider']);
    Route::post('login/{providerName}/callback', [Login::class, 'handleProviderCallback']);

    // Login
    $auth->get('login', [Login::class, 'showFormLogin'])->name('web.formLogin');
    $auth->post('login', [Login::class, 'login'])->name('web.login');

    $auth->get('login-guest', [Login::class, 'formLoginGuest'])->name('web.formLoginGuest');
    $auth->post('login-guest', [Login::class, 'loginGuest'])->name('web.loginGuest');

    //API Router
//API Connect wallet
    /*
     * Sau khi connect xong thì frontend gửi lên backend 2 thông tin:
     * wallet_address và wallet_name (account name: optional)
    Backend xử lý nếu chưa có trong DB thì đăng ký user mới.
    Nếu có rồi thì thôi. Cuối cùng xử lý để sao cho user đó đã ở trạng thái đã login.
     * */
    Route::post('/api/connect-wallet', [\App\Http\Controllers\FrontendController::class, 'connectWallet'])->name('connect-wallet');

//Wallet Login
    Route::any('/api/wallet-login', [\App\Http\Controllers\FrontendController::class, 'walletLogin'])->name('wallet-login');

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

// Định nghĩa các route cho người dùng đã đăng nhập
Route::middleware(['user_event'])->group(function ($r) {
    $r->get('logout', [Login::class, 'logout'])->name('web.logout');
    $r->get('profile', [UserController::class, 'profile'])->name('web.profile');
    $r->post('editEmail', [UserController::class, 'editEmail'])->name('web.editEmail');

    // Travel
    $r->get('event-job/{id}', [Home::class, 'jobEvent'])->name('web.jobEvent');
    $r->get('info/{task_id}', [Job::class, 'getTravelGame'])->name('job.getTravelGame');
    $r->get('quiz/{code}', [Job::class, 'getJob'])->name('job.getJob');

    // New sponsor
    $r->get('sponsor/new', [Job::class, 'newSponsor'])->name('new.sponsor');
    $r->post('sponsor/pay', [Job::class, 'saveSponsor'])->name('new.saveSponsor');

    $r->get('r/{id}', [Home::class, 'isResult'])->name('r.isResult');
    // remove pop ntf
    $r->get('api/remove-nft', [Job::class, 'removeNft'])->name('nft.remove');
});

// Các route không yêu cầu middleware
Route::get('/', [Home::class, 'index'])->name('web.home');
Route::get('event-lists', [Home::class, 'events'])->name('web.events');
Route::get('event/{id}', [Home::class, 'show'])->name('web.events.show');
Route::get('events/code', [Job::class, 'index'])->name('web.eventCode');
Route::get('solution', [PagesController::class, 'solution'])->name('web.solution');
Route::get('template', [PagesController::class, 'template'])->name('web.template');
Route::get('pricing', [PagesController::class, 'pricing'])->name('web.pricing');
Route::get('resource', [PagesController::class, 'resource'])->name('web.resource');
Route::get('contact', [PagesController::class, 'contact'])->name('web.contact');
Route::get('lang/{lang}', [PagesController::class, 'lang'])->name('web.lang');

Route::post('order/ticket', [Home::class, 'orderTicket'])->name('order.ticket');

Route::get('/discord/login', [App\Http\Controllers\Web\Discord::class, 'getUserDiscord']);
Route::get('/discord', [App\Http\Controllers\Web\Discord::class, 'index'])->name('discord');
Route::get('/telegram', [App\Http\Controllers\Web\Discord::class, 'telegram'])->name('telegram');
Route::get('logout-discord', [App\Http\Controllers\Web\Discord::class, 'logout']);
Route::get('events/list', [Home::class, 'webList'])->name('list.Events');
Route::post('create-user', [Job::class, 'createUser'])->name('web.createUser');

// Route::get('/events/history/list', [Job::class, 'apiList']);
// Route::get('/events/history/user', [Home::class, 'apiList']);
// Route::get('/events/likes', [Likes::class, 'index'])->name('web.like');;
// Route::get('/events/task/{id}', [Detail::class, 'edit'])->whereUuid('id');
// Route::post('/events/likes', [Detail::class, 'like']);
// Route::get('/events/download-ticket/{id}', [Detail::class, 'downloadTicket']);
// Route::get('/events/likes/list', [Detail::class, 'listLike']);
// Route::get('/events/user/ticket', [Detail::class, 'userTicket']);
// Route::post('/events/ticket', [Detail::class, 'addTicket'])->name('web.event.addTicket');
// Route::get('/events/{slug}', [Detail::class, 'index']);


// QUIZ
Route::get('/quiz-game/answers/{eventId}', [QuizGameController::class, 'showAnswers'])->name('quiz-name.answers');
Route::prefix('quiz-game')->group(function () {
    Route::middleware('user_event')->group(function () {
        // Route::get('/answers/{eventId}', [QuizGameController::class, 'showAnswers'])->name('quiz-name.answers');
        Route::post('/send-total-score', [QuizGameController::class, 'sendTotalScore']);
    });
});
