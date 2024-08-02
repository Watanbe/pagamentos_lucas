<?php

namespace App\Architecture\DTO\Reference;

class ReferenceRegisterDTO {
    public function __construct(
        public string $value,
        public int $userId
    )
    {

    }
}
