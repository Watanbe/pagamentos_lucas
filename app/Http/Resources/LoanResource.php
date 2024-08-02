<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class LoanResource extends JsonResource
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
            'loan_image' => $this->loan_image,
            'value' => $this->value,
            'loan_maturity' => $this->loan_maturity,
            'loan_description' => $this->loan_description,
            'loan_modality' => new LoanModalityResource($this->whenLoaded('loanModality')),
        ];
    }
}
