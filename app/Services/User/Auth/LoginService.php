<?php

namespace App\Services\User\Auth;

use App\Enum\UserStatus;
use App\Helpers\ResponseHelper;
use App\Http\Resources\user\UserResource;
use App\Jobs\ForgotPassword;
use App\Models\Otp;
use App\Models\User;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Hash;
use Symfony\Component\HttpFoundation\Response;
use Throwable;

class LoginService
{
    public function login(array $credentials): JsonResponse
    {
        $user = $this->checkUser($credentials['phone']);

        if (!$user) {
            ResponseHelper::error(__('home.Not Found', ['attribute' => __('validation.attributes.phone')]), statusCode: Response::HTTP_NOT_FOUND);
        }

        $password = $this->verifyPassword($credentials['password'], $user->password);

        if (!$password) {
            return ResponseHelper::error(__('home.incorrect', ['attribute' => __('validation.attributes.password')]), statusCode: Response::HTTP_NOT_FOUND);
        }

        if ($user->inActive()) {
            ForgotPassword::dispatch($user, $user->generateOTP());
        }
        return ResponseHelper::success(__('auth.login successfully'), new UserResource($user), Response::HTTP_OK);
    }

    public function activeAccount(string $code): JsonResponse
    {
        try {
            
            $code = Otp::with('otpable')->where('code', $code)->firstOrFail();

            if ($code->isExpired()) {
                return ResponseHelper::error(__('auth.Code is expired'), statusCode: Response::HTTP_FORBIDDEN);
            }

            $code->otpable()->update(['status' => UserStatus::ACTIVE]);

            return ResponseHelper::success(__('auth.The account has been activated'));

        } catch (ModelNotFoundException $e) {
            return ResponseHelper::error(__('auth.This item not found'), statusCode: Response::HTTP_NOT_FOUND);
        }
        catch(Throwable $error) {
            return ResponseHelper::error(__('auth.faild'));
        }
            
    }

    private function checkUser(string $phone): User|NULL
    {
        return User::wherePhone($phone)->first();
    }

    private function verifyPassword(string $password, string $userPassword): bool
    {
        return Hash::check($password, $userPassword);
    }
}
