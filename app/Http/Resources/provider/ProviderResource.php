<?php

namespace App\Http\Resources\provider;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProviderResource extends JsonResource
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
            'name' => $this->name,
            'username' => $this->username,
            'email' => $this->email,
            'phone' => $this->phone,
            'image' => $this->image_url,
            'status' => $this->status->value,
            'birthdate' => $this->birthdate,
            'country' => $this->whenLoaded('country', [
                'id'   => $this->id, 
                'name' => $this->country->name
            ]),
            'city' => $this->whenLoaded('city', [
                'id'    => $this->id, 
                'name'  =>  $this->city->name, 
            ]),
            'area' => $this->whenLoaded('area', [
                'id'    => $this->id, 
                'name'  => $this->area->name
            ]),
            'gender' => $this->gender->value,
        ];
    }
}
