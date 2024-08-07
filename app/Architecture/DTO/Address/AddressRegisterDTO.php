<?php

namespace App\Architecture\DTO\Address;

use InvalidArgumentException;

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
        $this->validate();
    }

    private function validate(): void
    {
        if (empty($this->zipcode) || !preg_match('/^\d{5}-?\d{3}$/', $this->zipcode)) {
            throw new InvalidArgumentException('CEP inválido');
        }

        if (empty($this->address)) {
            throw new InvalidArgumentException('Endereço não pode ser vazio');
        }

        if (empty($this->number)) {
            throw new InvalidArgumentException('Número não pode ser vazio');
        }

        if (empty($this->district)) {
            throw new InvalidArgumentException('Bairro não pode ser vazio');
        }

        if ($this->stateId !== null && $this->stateId <= 0) {
            throw new InvalidArgumentException('ID do estado inválido');
        }

        if ($this->cityId !== null && $this->cityId <= 0) {
            throw new InvalidArgumentException('ID da cidade inválido');
        }
    }
}
