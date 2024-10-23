<?php

namespace App\Services\Provider\Auth;

use App\Enum\UserStatus;
use App\Helpers\ResponseHelper;
use App\Jobs\ForgotPassword;
use App\Models\Provider;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Throwable;

class ForgotPasswordService 
{
    public function sendCode(string $phone): ?JsonResponse
    {
        $provider = Provider::wherePhone($phone)->first();

        if(!$provider) {
            return ResponseHelper::error(__('auth.Not found'), statusCode: Response::HTTP_NOT_FOUND);
        }

        ForgotPassword::dispatch($provider, $provider->generateOTP());

        return ResponseHelper::success(__('auth.Code was sent'), statusCode: Response::HTTP_OK);

    }
    
    public function checkOTP(string $phone, string $code) 
    {
        try {
            $provider = Provider::with('otpCode')->wherephone($phone)->firstOrFail();

            if ($provider->otpCode->code !== $code) {
                return ResponseHelper::error(__('auth.Not found', ['attribute' => __('auth.code')]), statusCode: Response::HTTP_NOT_FOUND);
            }

            if ($provider->otpCode->isExpired()) {
                return ResponseHelper::error(__('auth.Code is expired'), statusCode: Response::HTTP_BAD_REQUEST);
            }

            $provider->update(['status' => UserStatus::ACTIVE]);

            $provider->otpCode()->delete();

            return ResponseHelper::success(__('auth.The account has been activated'));
            
        } catch(ModelNotFoundException $exception) {

            return ResponseHelper::error(__('auth.An error occurred please try again'), statusCode: Response::HTTP_NOT_FOUND);

        } catch(Throwable $error) {

            return ResponseHelper::error(__('auth.An error occurred please try again'));
        }
        
    }

    public function resendOTP(string $phone): JsonResponse
    {
        try {
            $provider = Provider::wherePhone($phone)->firstOrFail();

            ForgotPassword::dispatch($provider, $provider->generateOTP());

            return ResponseHelper::success(__('auth.Code was sent'));

        } catch (ModelNotFoundException $exception) {

            return ResponseHelper::error(__('auth.Not found', ['attribute' => 'email']), statusCode: Response::HTTP_NOT_FOUND);

        } catch(Throwable $error) {
            
            return ResponseHelper::error(__('auth.An error occurred please try again'));
        }

    }

    public function updatePassword(string $phone, string $password): JsonResponse
    {
        $provider = Provider::wherePhone($phone)->firstOrFail();

        $provider->update(['password' => bcrypt($password)]);

        return ResponseHelper::success(__('auth.Data was updated successfully'), statusCode: Response::HTTP_OK);
    }
    
}