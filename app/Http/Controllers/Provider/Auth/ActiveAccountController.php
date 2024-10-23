<?php

namespace App\Http\Controllers\Provider\Auth;

use App\Http\Controllers\Controller;
use App\Models\Otp;
use App\Services\Provider\Auth\LoginService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

final class ActiveAccountController extends Controller
{
    /**
     * Activate account for Provider.
     */
    public function active(Request $request): JsonResponse
    {
        $request->validate(['code' => 'required|string']);

        $service = (new LoginService)->activeAccount($request->post('code'));

        return $service;
    }
}
