<?php

use App\Http\Controllers\Category\CategoryController;
use App\Http\Controllers\TestController;
use App\Http\Controllers\User\Auth\ActiveAccountController;
use App\Http\Controllers\User\Auth\ForgotPasswordController;
use App\Http\Controllers\User\Auth\LoginController;
use App\Http\Controllers\User\Auth\RegisterController;
use App\Http\Controllers\User\Auth\SocialLoginController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');


/**
 * Authentication for user's.
 */
Route::group([
    'prefix' => 'auth/user', 
    'middleware' => ['guest'],
], function() {

    Route::post('/register', RegisterController::class);

    Route::post('/login', LoginController::class);

    // Active account
    Route::post('/active-account', [ActiveAccountController::class, 'active']);

    Route::post('/forgot-password', [ForgotPasswordController::class, 'forgot']);

    Route::post('/check-code', [ForgotPasswordController::class, 'check']);

    // Resend code
    Route::post('/resend-code', [ForgotPasswordController::class, 'resend']);

    Route::post('/update-password', [ForgotPasswordController::class, 'update']);

    Route::get('/auth/{provider}/{token}/callback', [SocialLoginController::class, 'callback']);

});

Route::group([
    'prefix' => 'category', 
    'middleware' => ['auth:user,provider'],
], function () {

    Route::get('all', [CategoryController::class, 'index']);

    Route::get('/{category}/sub_category', [CategoryController::class, 'sub_category']);
    
});



