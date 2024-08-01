<?php

namespace App\Architecture\Services\Reference;

use App\Architecture\DTO\Reference\ReferenceRegisterDTO;
use App\Models\Reference;
use App\Models\UserReference;

class ReferenceService {

    public function create(ReferenceRegisterDTO $referenceRegisterDTO, int $userId) {
        $reference = Reference::create([
            'value' => $referenceRegisterDTO->value
        ]);

        UserReference::create([
            'user_id' => $userId,
            'reference_id' => $reference->id
        ]);
    }
}
