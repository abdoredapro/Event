<?php

namespace App\Http\Resources\Service;

use App\Http\Resources\Category\CategoryResource;
use App\Http\Resources\Category\SubCategoryResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ServiceResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'category' => $this->whenLoaded('category', new CategoryResource($this->category)),
            'sub_category' => $this->whenLoaded('sub_category', new SubCategoryResource($this->sub_category)), 
            'provider' => $this->provider->name, 
            'name' => $this->name, 
            'image' => $this->image, 
            'description' => $this->description,
            'price' => $this->price,
        ];
    }
}
