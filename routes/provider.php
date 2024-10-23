<?php

use App\Http\Controllers\Provider\Auth\ActiveAccountController;
use App\Http\Controllers\Provider\Auth\ForgotPasswordController;
use App\Http\Controllers\Provider\Auth\LoginController;
use App\Http\Controllers\Provider\Auth\RegisterController;
use App\Http\Controllers\Provider\Profile\ContactUsController;
use App\Http\Controllers\Provider\Profile\ProfileController;
use App\Http\Controllers\Provider\Profile\UpdatePasswordController;
use App\Http\Controllers\Service\ServiceController;
use Illuminate\Auth\Middleware\Authenticate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/provider', function (Request $request) {
    return $request->user();
})->middleware('auth:provider');




/**
 * Authentication for Provider.
 */

Route::group([
    'prefix' => 'auth/provider',
    'middleware' => ['guest'],
], function () {

    Route::post('/register', RegisterController::class);

    Route::post('/login', LoginController::class);

    // Active account
    Route::post('/active-account', [ActiveAccountController::class, 'active']);

    Route::post('/forgot-password', [ForgotPasswordController::class, 'forgot']);

    Route::post('/check-code', [ForgotPasswordController::class, 'check']);

    // Resend code
    Route::post('/resend-code', [ForgotPasswordController::class, 'resend']);

    Route::post('/update-password', [ForgotPasswordController::class, 'update']);

});

Route::group([
    'prefix' => 'provider/profile', 
    'middleware' => [Authenticate::using('provider')],
    'as' => 'provider.'
], function () {

    Route::get('/', [ProfileController::class, 'index']);

    Route::post('/update', [ProfileController::class, 'update']);

    Route::post('/logout', [ProfileController::class, 'logout']);

    Route::patch('/update-password', UpdatePasswordController::class);
});

Route::group([
    'prefix' => 'provider/service', 
    'middleware' => ['auth:provider'], 
    'as' => 'provider.'
], function () {
    Route::get('/all', [ServiceController::class, 'index']);
});

Route::group([
    'prefix' => 'provider/contact-us', 
    'middleware' => [Authenticate::using('provider')], 
    'as' => 'provider.',
], function () {
    Route::post('/', ContactUsController::class);
});


