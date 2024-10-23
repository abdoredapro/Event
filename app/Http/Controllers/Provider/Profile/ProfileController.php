<?php

namespace App\Http\Controllers\Provider\Profile;

use App\Helpers\ResponseHelper;
use App\Http\Controllers\Controller;
use App\Http\Requests\API\provider\UpdateProfileRequest;
use App\Http\Resources\provider\ProviderResource;
use App\Models\Provider;
use App\Services\Provider\profile\UpdateProfileService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Throwable;

final class ProfileController extends Controller
{

    protected $provider;

    public function __construct()
    {
        $this->provider = auth('provider')->user();
    }

    /**
     * Display a listing of the resource.
     */
    public function index(): JsonResponse
    {
        $this->provider->load([
            'country', 
            'city', 
            'area'
        ]);

        return ResponseHelper::success(message: __('home.Done_successfully'),data: new ProviderResource($this->provider));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateProfileRequest $request)
    {
        try {

            $response = (new UpdateProfileService())->update($request);

            return ResponseHelper::success(message: __('home.Done_successfully'), data: new ProviderResource($this->provider));

        } catch (\Throwable $e) {
            return ResponseHelper::error($e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function logout(): JsonResponse
    {
        $this->provider->currentAccessToken()->delete();

        return ResponseHelper::success(__('home.logout successfully'));
    }
}
