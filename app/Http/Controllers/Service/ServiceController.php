<?php

namespace App\Http\Controllers\Service;

use App\Http\Controllers\Controller;
use App\Http\Requests\Service\StoreServiceRequest;
use App\Services\Service\Service;
use Illuminate\Http\Request;

final class ServiceController extends Controller
{
    protected $service;

    public function __construct(Service $service)
    {
        $this->service = $service;
    }
    public function store(StoreServiceRequest $request)
    {
        $provider = auth('provider')->user();

        $response = $this->service->store($request, $provider);

        return $response;
    }
}
