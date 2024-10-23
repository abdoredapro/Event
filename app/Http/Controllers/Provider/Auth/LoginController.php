<?php

namespace App\Http\Controllers\Provider\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\API\provider\LoginRequest;
use App\Services\Provider\Auth\LoginService;
use Illuminate\Http\JsonResponse;

class LoginController extends Controller
{
    /**
     * Authentication for Provider.
     * @param App\Http\Requests\provider\LoginRequest
     * @return Illuminate\Http\JsonResponse
     */
    public function __invoke(LoginRequest $request): ?JsonResponse
    {
        $service = (new LoginService())->login($request->validated());

        return $service;

    }
}
