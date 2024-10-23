<?php

namespace App\Services\Service;

use App\Enum\Assets;
use App\Helpers\ImageHelper;
use App\Helpers\ResponseHelper;
use App\Models\Provider;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class Services {

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

        $service = $provider->services()->create(array_merge($request->except('images'), [
            'image' => $imageName
        ]));

        $this->handleImages($service, $request->images);
    
        return ResponseHelper::success(__('home.Service has been added'));

    }

    /**
     * Handle uploading multi images.
     * 
     * @param Service $service
     * @param <array, string> $images
     */
    private function handleImages($service, array $images): void
    {
        $images = collect($images);

        $data = $images->map(function ($image) {
            $name = ImageHelper::uploadImage($image, Assets::SERVICE_IMAGES->value);
            return ['name' => $name];
        });

        $service->images()->createMany($data);

    }


}