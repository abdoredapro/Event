<?php

namespace App\Http\Controllers\Provider\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\API\provider\ForgotPasswordRequest;
use App\Http\Requests\API\user\UpdatePasswordRequest;
use App\Models\Provider;
use App\Services\Provider\Auth\ForgotPasswordService;
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
        $response = $this->service->sendCode($request->phone);
        
        return $response;
    }

    /**
     * Check code status.
     */
    public function check(Request $request): JsonResponse 
    {
        $request->validate([
            'phone' => ['required', 'string', Rule::exists(Provider::class, 'phone')],
            'code' => ['required', 'string'],
        ]);

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
        $response = $this->service->updatePassword($request->post('phone'), $request->password);

        return $response;

    }
}
