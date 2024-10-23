<?php

namespace App\Services\Service;

use App\Enum\Assets;
use App\Helpers\ImageHelper;
use App\Helpers\ResponseHelper;
use App\Models\Provider;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class Service {


    /**
     * Add Service
     *
     * @param  Request $request
     * @param  App\Models\Provider $provider
     * @return JsonResponse
     */
    public function store(Request $request, Provider $provider): JsonResponse
    {
        $image = $request->file('image');

        $imageName = ImageHelper::uploadImage($image, Assets::SERVICE_IMAGE->value);

        $provider->services()->create(array_merge($request->all(), [
            'image' => $imageName
        ]));

        return ResponseHelper::success(__('home.Service has been added'));

    }
}