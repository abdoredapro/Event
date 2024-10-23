<?php

namespace App\Http\Controllers\User\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Laravel\Socialite\Facades\Socialite;

final class SocialLoginController extends Controller
{
    /**
     * Login with service's like (Google, Facebook, Apple).
     */
    public function callback($provider, $token)
    {
        // $user = Socialite::driver($provider)->userFromToken($token);
        
    }
}
