<?php

namespace App\Services\User\Auth;

use App\Enum\UserStatus;
use App\Helpers\ResponseHelper;
use App\Jobs\ForgotPassword;
use App\Models\User;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
// use Illuminate\Support\Facades\Response;
use Throwable;

class ForgotPasswordService 
{
    public function sendCode(string $phone): ?JsonResponse
    {
        $user = User::wherePhone($phone)->first();

        if(!$user) {
            return ResponseHelper::error(__('auth.Not found'), statusCode: Response::HTTP_NOT_FOUND);
        }

        ForgotPassword::dispatch($user, $user->generateOTP());

        return ResponseHelper::success(__('auth.Code was sent'), statusCode: Response::HTTP_OK);

    }
    
    public function checkOTP(string $phone, string $code) 
    {
        try {
            $user = User::with('otpCode')->wherephone($phone)->firstOrFail();

            if ($user->otpCode->code !== $code) {
                return ResponseHelper::error(__('auth.Not found', ['attribute' => __('auth.code')]), statusCode: Response::HTTP_NOT_FOUND);
            }

            if ($user->otpCode->isExpired()) {
                return ResponseHelper::error(__('auth.Code is expired'), statusCode: Response::HTTP_BAD_REQUEST);
            }

            // $user->update(['status' => UserStatus::ACTIVE]);

            $user->otpCode()->delete();

            return ResponseHelper::success(__('auth.Code confirmed'));
            
        } catch(ModelNotFoundException $exception) {

            return ResponseHelper::error(__('auth.An error occurred please try again'), statusCode: Response::HTTP_NOT_FOUND);

        } catch(Throwable $error) {

            return ResponseHelper::error(__('auth.An error occurred please try again'));
        }
        
    }

    public function resendOTP(string $phone)
    {
        try {
            $user = User::wherePhone($phone)->firstOrFail();

            ForgotPassword::dispatch($user, $user->generateOTP());

            return ResponseHelper::success(__('auth.Code was sent'));

        } catch (ModelNotFoundException $exception) {

            return ResponseHelper::error(__('auth.Not found', ['attribute' => 'email']), statusCode: Response::HTTP_NOT_FOUND);

        } catch(Throwable $error) {
            
            return ResponseHelper::error(__('auth.An error occurred please try again'));
        }

    }

    public function updatePassword(string $phone, string $password): JsonResponse
    {
        $user = User::wherePhone($phone)->firstOrFail();
        
        $user->update(['password' => bcrypt($password)]);

        return ResponseHelper::success(__('auth.Data was updated successfully'), statusCode: Response::HTTP_OK);
    }
    
}