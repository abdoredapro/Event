<?php

namespace App\Http\Controllers\User\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\API\user\LoginRequest;
use App\Services\User\Auth\LoginService;
use Illuminate\Http\JsonResponse;

class LoginController extends Controller
{
    /**
     * Authentication for Provider.
     * @param App\Http\Requests\user\LoginRequest
     * @return Illuminate\Http\JsonResponse
     */
    public function __invoke(LoginRequest $request): ?JsonResponse
    {
        $service = (new LoginService())->login($request->validated());

        return $service;
    }
}
