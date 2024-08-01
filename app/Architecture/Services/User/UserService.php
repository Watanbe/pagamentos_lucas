<?php

namespace App\Architecture\Services\User;

use App\Architecture\DTO\User\UserRegisterDTO;
use App\Models\User;

class UserService {

    public function create(UserRegisterDTO $userRegisterDTO) {
        return User::create([
            'name' => $userRegisterDTO->name,
            'username' => $userRegisterDTO->username,
            'email' => $userRegisterDTO->email,
            'password' => $userRegisterDTO->password,
            'cpf' => $userRegisterDTO->cpf,
            'rg' => $userRegisterDTO->rg,
            'birth_date' => $userRegisterDTO->birthDate,
            'user_image' => $userRegisterDTO->userImage,
            'marital_status_id' => $userRegisterDTO->maritalStatusId,
            'personal_address_id' => $userRegisterDTO->personalAddressId,
            'commercial_address_id' => $userRegisterDTO->commercialAddressId
        ]);
    }
}
