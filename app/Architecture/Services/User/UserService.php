<?php

namespace App\Architecture\Services\User;

use App\Architecture\DTO\User\UserRegisterDTO;
use App\Models\User;
use Carbon\Carbon;

class UserService {

    public function create(UserRegisterDTO $userRegisterDTO) {
        return User::create([
            'name' => $userRegisterDTO->name,
            'username' => $userRegisterDTO->username,
            'email' => $userRegisterDTO->email,
            'password' => $userRegisterDTO->password,
            'cpf' => $userRegisterDTO->cpf,
            'rg' => $userRegisterDTO->rg,
            'birth_date' => Carbon::createFromFormat('d/m/Y', $userRegisterDTO->birthDate)->format('Y-m-d'),
            'user_image' => $userRegisterDTO->userImage,
            'marital_status_id' => $userRegisterDTO->maritalStatusId,
            'personal_address_id' => $userRegisterDTO->personalAddressId,
            'commercial_address_id' => $userRegisterDTO->commercialAddressId
        ]);
    }

    public function getById($userId) {
        return User::with([
            'maritalStatus',
            'loans.loanModality',
            'references',
            'personalAddress.city',
            'personalAddress.state',
            'commercialAddress.city',
            'commercialAddress.state'
        ])->find($userId);
    }
}
