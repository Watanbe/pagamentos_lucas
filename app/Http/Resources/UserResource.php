<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
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
            'cpf' => $this->cpf,
            'birth_date' => $this->birth_date,
            'user_image' => $this->user_image,
            'marital_status' => new MaritalStatusResource($this->whenLoaded('maritalStatus')),
            'personal_address' => new AddressResource($this->whenLoaded('personalAddress')),
            'commercial_address' => new AddressResource($this->whenLoaded('commercialAddress')),
            'references' => ReferenceResource::collection($this->whenLoaded('references')),
            'loans' => LoanResource::collection($this->whenLoaded('loans'))
        ];
    }
}
