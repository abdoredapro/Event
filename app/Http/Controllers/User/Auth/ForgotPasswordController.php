<?php

namespace App\Http\Controllers\User\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\API\ForgotPasswordRequest;
use App\Http\Requests\API\user\ResetPasswordCodeRequest;
use App\Http\Requests\API\user\UpdatePasswordRequest;
use App\Models\User;
use App\Services\User\Auth\ForgotPasswordService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

final class ForgotPasswordController extends Controller
{
    private $service;

    public function __construct(ForgotPasswordService $service)
    {
        $this->service = $service;
    }

    /**
     * Reset your password using by phone.
     */
    public function forgot(ForgotPasswordRequest $request): JsonResponse
    {
        $response = $this->service->sendCode($request->post('phone'));
        
        return $response;
    }

    /**
     * Check code status.
     */
    public function check(ResetPasswordCodeRequest $request): JsonResponse 
    {
        $response = $this->service->checkOTP($request->get('phone'), $request->get('code'));

        return $response;

    }

    /**
     * Resend OTP code.
     */
    public function resend(ForgotPasswordRequest $request) 
    {
        $response = $this->service->resendOTP($request->post('phone'));

        return $response;
    }

    /**
     * Update password.
     */
    public function update(UpdatePasswordRequest $request)
    {
        $response = $this->service->updatePassword($request->post('phone'), $request->post('password'));

        return $response;

    }
}
