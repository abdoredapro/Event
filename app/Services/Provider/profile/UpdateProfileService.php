<?php 

namespace App\Services\Provider\profile;

use App\Enum\Assets;
use App\Helpers\ImageHelper;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class UpdateProfileService
{
    /**
     * Handle update Profile.
     * @param <array> $data.
     * @return void
     */
    public function update(Request $request): void 
    {
        $provider = auth('provider')->user();

        $data = $request->except('image');

        if($request->hasFile('image')) {

            $provider_path = Assets::PROVIDER_IMAGE->value;
            
            $data['image'] = ImageHelper::uploadImage($request->file('image'), $provider_path);
        }

        $provider->update($data);
    }
}