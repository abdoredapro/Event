<?php

namespace App\Observers;

use App\Enum\Assets;
use App\Helpers\ImageHelper;
use App\Models\Provider;
use Illuminate\Support\Facades\Storage;

class ProviderObserver
{
    /**
     * Handle the Provider "created" event.
     */
    public function created(Provider $provider): void
    {
        //
    }
    
    /**
     * Handle the Provider "updated" event.
     */
    public function updated(Provider $provider): void
    {
        if($provider->isDirty('image') && $provider->getOriginal('image')) {
            // Storage::disk('public')->delete(Assets::PROVIDER_IMAGE . $provider->getOriginal('image'));
            ImageHelper::removeImage(Assets::PROVIDER_IMAGE->value . $provider->getOriginal('image'));
        }
    }

    /**
     * Handle the Provider "deleted" event.
     */
    public function deleted(Provider $provider): void
    {
        //
    }

    
}
