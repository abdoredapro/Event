<?php

namespace App\Http\Controllers\Service;

use App\Helpers\ResponseHelper;
use App\Http\Controllers\Controller;
use App\Http\Requests\Service\StoreServiceRequest;
use App\Http\Resources\Service\ServiceResource;
use App\Models\Service;
use App\Services\Service\Services;
use Illuminate\Http\Request;

final class ServiceController extends Controller
{
    protected $service;

    public function __construct(Services $services)
    {
        $this->service = $services;
    }
    public function index()
    {
        $services = Service::paginate(10);
        $services->load([
            'category',
            'sub_category',
            'provider',
        ]);
        return ResponseHelper::success(data: ServiceResource::collection($services));
    }
    public function store(StoreServiceRequest $request)
    {
        $provider = auth('provider')->user();
        
        try {

            $response = $this->service->store($request, $provider);

            return $response;

        } catch (\Throwable $e) {

            return ResponseHelper::error(__('auth.An error occurred please try again'));

        }
    }
}
