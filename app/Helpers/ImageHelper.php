<?php

namespace App\Helpers;

use Illuminate\Support\Facades\Storage;
use Illuminate\Http\UploadedFile;

class ImageHelper
{
    /**
     * Upload an image to the specified storage path.
     *
     * @param UploadedFile $image
     * @param string $path
     * @return string|false
     */
    public static function uploadImage(UploadedFile $image, $path = 'public/images')
    {
        // Store the image and return the path or false if failed
        $path = $image->store($path, [
                'disk' => 'public'
            ]);

        return basename($path);
    }

    /**
     * Remove an image from storage.
     *
     * @param string $imagePath
     * @return bool
     */
    public static function removeImage($imagePath)
    {
        $path = Storage::disk('public')->path($imagePath);
        if (file_exists($path)) {
            unlink($path);
        }

        return false;
    }

    /**
     * Update an image by removing the old one and uploading a new one.
     *
     * @param UploadedFile|null $newImage
     * @param string|null $oldImagePath
     * @param string $path
     * @return string|false
     */
    public static function updateImage($newImage, $oldImagePath = null, $path = 'public/images')
    {
        // If a new image is uploaded, remove the old one and upload the new one
        if ($newImage instanceof UploadedFile) {
            // Remove the old image
            if ($oldImagePath) {
                self::removeImage($oldImagePath);
            }

            // Upload the new image
            return self::uploadImage($newImage, $path);
        }

        return $oldImagePath;
    }

    
}
