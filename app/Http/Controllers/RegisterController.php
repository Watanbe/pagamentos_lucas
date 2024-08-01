<?php

namespace App\Http\Controllers;

use App\Architecture\DTO\Address\AddressRegisterDTO;
use App\Architecture\DTO\Reference\ReferenceRegisterDTO;
use App\Architecture\DTO\User\UserRegisterDTO;
use App\Architecture\Services\Address\AddressService;
use App\Architecture\Services\Reference\ReferenceService;
use App\Architecture\Services\User\UserService;
use Exception;
use Illuminate\Http\Request;

class RegisterController extends Controller {

    public function __construct(
        protected AddressService $addressService,
        protected UserService $userService,
        protected ReferenceService $referenceService
    )
    {
    }

    public function register(Request $request) {
        try {

            // dd($request->references);

            $personalAddress = $request->personal_address;
            $personalAddressDTO = new AddressRegisterDTO(
                zipcode: $personalAddress["zipcode"],
                address: $personalAddress["address"],
                number: $personalAddress["number"],
                complement: $personalAddress["complement"],
                district: $personalAddress["district"],
                stateId: $personalAddress["state_id"],
                cityId: $personalAddress["city_id"]
            );
            $commercialAddress = $request->commercial_address;
            $commercialAddressDTO = new AddressRegisterDTO(
                zipcode: $commercialAddress["zipcode"],
                address: $commercialAddress["address"],
                number: $commercialAddress["number"],
                complement: $commercialAddress["complement"],
                district: $commercialAddress["district"],
                stateId: $commercialAddress["state_id"],
                cityId: $commercialAddress["city_id"]
            );
            $personalAddress = $this->addressService->create($personalAddressDTO);
            $commercialAddress = $this->addressService->create($commercialAddressDTO);

            $user = $request->user;
            $userDTO = new UserRegisterDTO(
                name: $user["name"],
                username: $user["username"],
                email: $user["email"],
                password: $user["password"],
                cpf: $user["cpf"],
                rg: $user["rg"],
                birthDate: $user["birth_date"],
                userImage: $user["user_image"],
                maritalStatusId: $user["marital_status_id"],
                personalAddressId: $personalAddress->id,
                commercialAddressId: $commercialAddress->id,
            );
            $user = $this->userService->create($userDTO);

            $references = $request->references;
            foreach ($references as $reference) {
                $referenceDTO = new ReferenceRegisterDTO(value: $reference['value']);
                $this->referenceService->create($referenceDTO, $user->id);
            }


        } catch (Exception $e) {
            dd($e);
        }
    }

}
