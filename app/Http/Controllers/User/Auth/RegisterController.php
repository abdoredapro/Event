<?php

namespace App\Http\Controllers\User\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\API\user\RegisterRequest;
use App\Models\Provider;
use App\Models\User;
use App\Services\User\Auth\RegisterService;
use Illuminate\Http\Request;

class RegisterController extends Controller
{
    /**
     * Authentication for user's.
     * @param Illuminate\Http\Request
     * @return Illuminate\Http\JsonResponse;
     */
    public function __invoke(RegisterRequest $request)
    {
        $service = (new RegisterService)->create($request->validated());
        
        return $service;
    }
}
