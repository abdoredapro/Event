<?php

namespace App\Services\Provider\Auth;

use App\Enum\UserStatus;
use App\Http\Resources\user\UserResource;
use App\Jobs\ForgotPassword;
use App\Models\Provider;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Response;

class RegisterService
{
    /**
     * Register Provider.
     * 
     * @param array $credentials
     */
    public function create(array $credentials): JsonResponse
    {
        $provider = Provider::create(array_merge($credentials, [
            'status' => UserStatus::INACTIVE,
            'password' => bcrypt($credentials['password'])
        ]));

        if ($provider->inActive()) {
            ForgotPassword::dispatch($provider, $provider->generateOTP());
        }

        return Response::json(new UserResource($provider), 200);
    }
}
