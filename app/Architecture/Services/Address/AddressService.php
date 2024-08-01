<?php

namespace App\Architecture\Services\Address;

use App\Architecture\DTO\Address\AddressRegisterDTO;
use App\Models\Address;

class AddressService {

    public function create(AddressRegisterDTO $addressRegisterDTO) {
        $address = Address::create([
            'zipcode' => $addressRegisterDTO->zipcode,
            'address' => $addressRegisterDTO->address,
            'number' => $addressRegisterDTO->number,
            'complement' => $addressRegisterDTO->complement,
            'district' => $addressRegisterDTO->district,
            'state_id' => $addressRegisterDTO->stateId,
            'city_id' => $addressRegisterDTO->cityId
        ]);

        return $address;
    }
}
