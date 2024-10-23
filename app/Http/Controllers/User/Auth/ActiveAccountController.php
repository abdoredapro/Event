<?php

namespace App\Http\Controllers\User\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\API\ActiveAccountRequest;
use App\Models\Otp;
use App\Services\User\Auth\LoginService;
use Illuminate\Http\Request;

final class ActiveAccountController extends Controller
{
    /**
     * Activate account.
     */
    public function active(ActiveAccountRequest $request)
    {
        $service = (new LoginService)->activeAccount($request->post('code'));

        return $service;
        
    }

}
