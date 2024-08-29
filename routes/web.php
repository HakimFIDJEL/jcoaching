<?php

use Illuminate\Support\Facades\Route;

// Middlewares
use App\Http\Middleware\AdminMiddleware;
use App\Http\Middleware\AuthMiddleware;


// Controllers
use App\Http\Controllers\MainController;
use App\Http\Controllers\AuthController;

//      Admin Controllers
use App\Http\Controllers\admin\MainController as AdminMainController;
use App\Http\Controllers\admin\MemberController as AdminMemberController;
use App\Http\Controllers\admin\AdminController as AdminAdminController;
use App\Http\Controllers\admin\FeedbackController as AdminFeedbackController;
use App\Http\Controllers\admin\ContactController as AdminContactController;
use App\Http\Controllers\admin\MediaController as AdminMediaController;
use App\Http\Controllers\admin\FaqController as AdminFaqController;
use App\Http\Controllers\admin\PricingController as AdminPricingController;

//      Member Controllers
use App\Http\Controllers\member\MainController as MemberMainController;


// MAIN ROUTES
Route::get('/', [MainController::class, 'index'])->name('main.index');
Route::get('/account', [MainController::class, 'account'])->name('main.account');

// AUTH ROUTES
Route::prefix('/auth')->name('auth.')->controller(AuthController::class)->group(function()
{
    // Authentification
    Route::get('/login', 'login')->name('login');
    Route::get('/register', 'register')->name('register');
    Route::get('/logout', 'logout')->name('logout');
    Route::get('/email-verification/{user_token}', 'emailVerification')->name('email-verification');
    Route::get('/email-verification/{user_token}/sresend', 'emailVerificationResend')->name('email-verification.resend');

    Route::post('/login', 'loginPost')->name('toLogin');
    Route::post('/register', 'registerPost')->name('toRegister');
    Route::post('/email-verification', 'emailVerificationPost')->name('toVerifyEmail');

    // Passwords
    Route::prefix('/password')->name('password.')->group(function()
    {
        Route::get('/forget', 'forget')->name('forget');
        Route::get('/reset/{password_token}', 'reset')->name('reset');
        Route::get('/change', 'change')->name('change');

        Route::post('/forget', 'forgetPost')->name('toForget');
        Route::post('/reset', 'resetPost')->name('toReset');
        Route::post('/change', 'changePost')->name('toChange');
    });
});

// ADMIN ROUTES
Route::prefix("/admin")->middleware([AdminMiddleware::class])->name("admin.")->group(function(){

    // MAIN - DONE
    Route::get('/', [AdminMainController::class, 'index'])->name('index');

    // MEMBERS - DOING
    Route::prefix("/members")->name("members.")->controller(AdminMemberController::class)->group(function(){

        Route::get('/', 'index')->name('index');
        Route::get('/create', 'create')->name('create');
        Route::get('/edit/{user}', 'edit')->name('edit');
        Route::get('/soft-delete/{user}', 'softDelete')->name('soft-delete');
        Route::get('/delete/{user}', 'delete')->name('delete');
        Route::get('/restore/{user}', 'restore')->name('restore');
        Route::get('/download-pfp/{user}', 'downloadPfp')->name('download-pfp');
        Route::get('/download-documents/{user}', 'downloadDocuments')->name('download-documents');

        Route::post('/store', 'store')->name('store');
        Route::post('/update/{user}', 'update')->name('update');
        Route::post('/update-pfp/{user}', 'updatePfp')->name('update-pfp');
        Route::post('/update-documents/{user}', 'updateDocuments')->name('update-documents');

    });

    // ADMINS - DONE
    Route::prefix("/admins")->name("admins.")->controller(AdminAdminController::class)->group(function(){

        Route::get('/', 'index')->name('index');
        Route::get('/create', 'create')->name('create');
        Route::get('/edit', 'edit')->name('edit');
        Route::get('/soft-delete/{user}', 'softDelete')->name('soft-delete');
        Route::get('/delete/{user}', 'delete')->name('delete');
        Route::get('/download-pfp', 'downloadPfp')->name('download-pfp');

        Route::post('/store', 'store')->name('store');
        Route::post('/update', 'update')->name('update');
        Route::post('/update-password', 'updatePassword')->name('updatePassword');
        Route::post('/update-pfp', 'updatePfp')->name('update-pfp');
    });

    // FEEDBACKS - DONE
    Route::prefix("/feedbacks")->name("feedbacks.")->controller(AdminFeedbackController::class)->group(function(){

        Route::get('/', 'index')->name('index');
        Route::get('/create', 'create')->name('create');
        Route::get('/edit/{feedback}', 'edit')->name('edit');
        Route::get('/soft-delete/{feedback}', 'softDelete')->name('soft-delete');
        Route::get('/delete/{feedback}', 'delete')->name('delete');
        Route::get('/restore/{feedback}', 'restore')->name('restore');

        Route::post('/store', 'store')->name('store');
        Route::post('/update/{feedback}', 'update')->name('update');
    });

    // CONTACTS - DONE
    Route::prefix("/contacts")->name("contacts.")->controller(AdminContactController::class)->group(function(){

        Route::get('/', 'index')->name('index');
        Route::get('/show/{contact}', 'show')->name('show');
        Route::get('/soft-delete/{contact}', 'softDelete')->name('soft-delete');
        Route::get('/delete/{contact}', 'delete')->name('delete');
        Route::get('/restore/{contact}', 'restore')->name('restore');
        
    });

    // MEDIAS - DONE
    Route::prefix("/medias")->name("medias.")->controller(AdminMediaController::class)->group(function(){

        Route::get('/', 'index')->name('index');
        Route::get('/create', 'create')->name('create');
        Route::get('/edit/{media}', 'edit')->name('edit');
        Route::get('/soft-delete/{media}', 'softDelete')->name('soft-delete');
        Route::get('/delete/{media}', 'delete')->name('delete');
        Route::get('/restore/{media}', 'restore')->name('restore');
        Route::get('/download/{media}', 'download')->name('download');

        Route::post('/store', 'store')->name('store');
        Route::post('/update/{media}', 'update')->name('update');
    });

    // FAQS - DONE
    Route::prefix("/faqs")->name("faqs.")->controller(AdminFaqController::class)->group(function(){

        Route::get('/', 'index')->name('index');
        Route::get('/create', 'create')->name('create');
        Route::get('/edit/{faq}', 'edit')->name('edit');
        Route::get('/soft-delete/{faq}', 'softDelete')->name('soft-delete');
        Route::get('/delete/{faq}', 'delete')->name('delete');
        Route::get('/restore/{faq}', 'restore')->name('restore');

        Route::post('/store', 'store')->name('store');
        Route::post('/update/{faq}', 'update')->name('update');
    });

    // PRICINGS - DONE
    Route::prefix("/pricings")->name("pricings.")->controller(AdminPricingController::class)->group(function(){

        Route::get('/', 'index')->name('index');
        Route::get('/create', 'create')->name('create');
        Route::get('/edit/{pricing}', 'edit')->name('edit');
        Route::get('/soft-delete/{pricing}', 'softDelete')->name('soft-delete');
        Route::get('/restore/{pricing}', 'restore')->name('restore');
        Route::get('/delete/{pricing}', 'delete')->name('delete');

        Route::post('/store', 'store')->name('store');
        Route::post('/update/{pricing}', 'update')->name('update');
    });

});


// MEMBER ROUTES
Route::prefix("/member")->middleware([AuthMiddleware::class])->name("member.")->group(function(){
    Route::get('/', [MemberMainController::class, 'index'])->name('index');
});