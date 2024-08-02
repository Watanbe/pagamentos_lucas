<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

use Carbon\Carbon;

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
            'loan_images' => LoanImageResource::collection($this->whenLoaded('loanImages')),
            'value' => $this->value,
            'loan_maturity' => $this->loan_maturity,
            'loan_creation' => Carbon::parse($this->created_at)->format('Y-m-d'),
            'loan_description' => $this->loan_description,
            'loan_modality' => new LoanModalityResource($this->whenLoaded('loanModality')),
        ];
    }
}
