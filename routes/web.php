<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\MainController;
use App\Http\Controllers\AuthController;

Route::get('/', [MainController::class, 'index'])->name('main.index');
Route::get('/account', [MainController::class, 'account'])->name('main.account');

// AUTH ROUTES
Route::prefix('/auth')->name('auth.')->controller(AuthController::class)->group(function()
{
    // Authentification
    Route::get('/login', 'login')->name('login');
    Route::get('/register', 'register')->name('register');
    Route::get('/logout', 'logout')->name('logout');
    Route::get('/email-verification', 'emailVerification')->name('email-verification');
    Route::get('/email-verification/resend', 'emailVerificationResend')->name('email-verification.resend');


    Route::post('/login', 'loginPost')->name('login');
    Route::post('/register', 'registerPost')->name('register');
    Route::post('/logout', 'logoutPost')->name('logout');
    Route::post('/email-verification', 'emailVerificationPost')->name('email-verification');

    // Passwords
    Route::prefix('/password')->name('password.')->group(function()
    {
        Route::get('/forget', 'forget')->name('forget');
        Route::get('/reset/{password_token}', 'reset')->name('reset');
        Route::get('/change', 'change')->name('change');

        Route::post('/forget', 'forgetPost')->name('forget');
        Route::post('/reset', 'resetPost')->name('reset');
        Route::post('/change', 'changePost')->name('change');
    });


});