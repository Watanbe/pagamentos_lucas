<?php

namespace App\Architecture\DTO\Address;

class AddressRegisterDTO {
    public function __construct(
        public string $zipcode,
        public string $address,
        public string $number,
        public string $district,
        public string|null $complement = null,
        public int|null $stateId = null,
        public int|null $cityId = null,
    )
    {
    }
}
