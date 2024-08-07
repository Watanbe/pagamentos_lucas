<?php

namespace App\Architecture\DTO\User;

use InvalidArgumentException;
use DateTime;

class UserRegisterDTO {
    public function __construct(
        public string $name,
        public string $username,
        public string $email,
        public string $password,
        public string $cpf,
        public string $rg,
        public string $birthDate,
        public string $userImage,
        public int $maritalStatusId,
        public int|null $personalAddressId = null,
        public int|null $commercialAddressId = null,
    )
    {
        $this->validate();
    }

    private function validate(): void
    {
        if (empty($this->name)) {
            throw new InvalidArgumentException('Nome não pode ser vazio');
        }

        if (empty($this->username) || strlen($this->username) < 3) {
            throw new InvalidArgumentException('Nome de usuário inválido (mínimo 3 caracteres)');
        }

        if (!filter_var($this->email, FILTER_VALIDATE_EMAIL)) {
            throw new InvalidArgumentException('Email inválido');
        }

        if (strlen($this->password) < 6) {
            throw new InvalidArgumentException('Senha deve ter no mínimo 8 caracteres');
        }

        if (!preg_match('/^\d{3}\.\d{3}\.\d{3}-\d{2}$/', $this->cpf)) {
            throw new InvalidArgumentException('CPF inválido (formato: xxx.xxx.xxx-xx)');
        }

        if (empty($this->rg)) {
            throw new InvalidArgumentException('RG não pode ser vazio');
        }

        if (!$this->isValidDate($this->birthDate)) {
            throw new InvalidArgumentException('Data de nascimento inválida (formato: YYYY-MM-DD)');
        }

        if (empty($this->userImage)) {
            throw new InvalidArgumentException('Imagem do usuário não pode ser vazia');
        }

        if ($this->maritalStatusId <= 0) {
            throw new InvalidArgumentException('ID do estado civil inválido');
        }

        if ($this->personalAddressId !== null && $this->personalAddressId <= 0) {
            throw new InvalidArgumentException('ID do endereço pessoal inválido');
        }

        if ($this->commercialAddressId !== null && $this->commercialAddressId <= 0) {
            throw new InvalidArgumentException('ID do endereço comercial inválido');
        }
    }

    private function isValidDate(string $date): bool
    {
        $format = 'd/m/Y';
        $d = DateTime::createFromFormat($format, $date);
        return $d && $d->format($format) === $date;
    }
}
