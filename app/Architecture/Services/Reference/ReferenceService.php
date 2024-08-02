<?php

namespace App\Architecture\Services\Reference;

use App\Architecture\DTO\Reference\ReferenceRegisterDTO;
use App\Models\Reference;
use App\Models\UserReference;

class ReferenceService {

    public function create(ReferenceRegisterDTO $referenceRegisterDTO) {
        $reference = Reference::create([
            'value' => $referenceRegisterDTO->value,
            'user_id' => $referenceRegisterDTO->userId
        ]);
    }
}
