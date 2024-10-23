<?php

namespace App\Services\Provider\Auth;

use App\Enum\UserStatus;
use App\Helpers\ResponseHelper;
use App\Http\Resources\user\UserResource;
use App\Jobs\ForgotPassword;
use App\Models\Otp;
use App\Models\Provider;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Hash;
use Symfony\Component\HttpFoundation\Response;
use Throwable;

class LoginService
{

    public function login(array $credentials): JsonResponse
    {
        $provider = $this->checkProvider($credentials['phone']);

        if(!$provider) {
            return ResponseHelper::error(__('home.Not Found', ['attribute' => __('validation.attributes.phone')]), statusCode: Response::HTTP_NOT_FOUND);
        }

        $password = $this->verifyPassword($credentials['password'], $provider->password);

        if(!$password) {
            return ResponseHelper::error(__('home.incorrect', ['attribute' => __('validation.attributes.password')]), Response::HTTP_NOT_FOUND);
        }

        if($provider->inActive()) {
            ForgotPassword::dispatch($provider, $provider->generateOTP());
        }
        
        return ResponseHelper::success(__('auth.login successfully'), data: new UserResource($provider));
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
            return ResponseHelper::error(__('auth.This item not found'));
        }
        catch (Throwable $error) {

            return ResponseHelper::error($error->getMessage());
        }
    }

    private function checkProvider(string $phone): Provider|NULL
    {
        return Provider::wherePhone($phone)->first();
    }

    private function verifyPassword(string $password, string $providerPassword): bool
    {
        return Hash::check($password, $providerPassword);
    }

}