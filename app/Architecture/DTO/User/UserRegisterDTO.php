<?php

namespace App\Architecture\DTO\User;

class UserRegisterDTO {
    public string $name;
    public string $username;
    public string $email;
    public string $password;
    public string $cpf;
    public string $rg;
    public string $birthDate;
    public string $userImage;
    public int $maritalStatusId;
    public int|null $personalAddressId = null;
    public int|null $commercialAddressId = null;
}
