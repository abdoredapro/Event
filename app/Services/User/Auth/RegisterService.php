<?php

namespace App\Services\User\Auth;

use App\Enum\UserStatus;
use App\Http\Resources\user\UserResource;
use App\Jobs\ForgotPassword;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Response;

class RegisterService {

    public function create(array $credentials): ?JsonResponse
    {
        $user = User::create(array_merge($credentials, [
            'status' => UserStatus::INACTIVE,
            'password' => bcrypt($credentials['password'])
        ]));
        
        if($user->inActive()) {
            ForgotPassword::dispatch($user, $user->generateOTP());
        }

        return Response::json(new UserResource($user), 200);
    }

}