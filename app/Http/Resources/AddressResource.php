<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AddressResource extends JsonResource
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
            'zipcode' => $this->zipcode,
            'address' => $this->address,
            'number' => $this->number,
            'complement' => $this->complement,
            'district' => $this->district,
            'city' => new CityResource($this->whenLoaded('city')),
            'state' => new StateResource($this->whenLoaded('state')),
        ];
    }
}
