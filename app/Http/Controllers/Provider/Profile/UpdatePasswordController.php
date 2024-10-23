<?php

namespace App\Http\Controllers\Provider\Profile;

use App\Helpers\ResponseHelper;
use App\Http\Controllers\Controller;
use App\Http\Requests\API\provider\profile\UpdateProfilePasswordRequest;
use App\Services\Provider\profile\UpdatePasswordService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;

final class UpdatePasswordController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(UpdateProfilePasswordRequest $request): JsonResponse
    {
        $response = (new UpdatePasswordService)->update($request->get('old_password'),$request->get('password'));
        return $response;
    }
}
