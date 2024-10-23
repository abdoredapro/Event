<?php

namespace App\Services\Provider\profile;

use App\Helpers\ResponseHelper;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Hash;

class UpdatePasswordService
{
        
    /**
     * update provider password
     *
     * @param  mixed $old_password
     * @param  mixed $new_password
     * @return JsonResponse
     */
    public function update(string $old_password, string $new_password): JsonResponse
    {
        $provider = auth('provider')->user();

        if(!Hash::check($old_password, $provider->password)) {
            return ResponseHelper::error(__('auth.faild'));
        }
        $provider->update(['password' => bcrypt($new_password)]);

        return ResponseHelper::success(__('home.Password has been updated'));
    }
}