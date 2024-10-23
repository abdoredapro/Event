<?php

namespace App\Http\Controllers\Provider\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\API\provider\RegisterRequest;
use App\Services\Provider\Auth\RegisterService;

class RegisterController extends Controller
{
    /**
     * Register provider.
     * @param Illuminate\Http\Request
     * @return Illuminate\Http\JsonResponse;
     */
    public function __invoke(RegisterRequest $request)
    {
        $service = (new RegisterService)->create($request->validated());

        return $service;
    }
}
