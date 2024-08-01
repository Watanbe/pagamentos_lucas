<?php

namespace App\Http\Controllers;

use App\Architecture\DTO\Address\AddressRegisterDTO;
use App\Architecture\Services\Address\AddressService;
use Exception;
use Illuminate\Http\Request;

class RegisterController extends Controller {

    public function __construct(
        protected AddressService $addressService
    )
    {
    }

    public function register(Request $request) {
        try {
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

            $this->addressService->create($personalAddressDTO);

            // $commercialAddress = $request->commercial_address;
            // $commercialAddressDTO = new AddressRegisterDTO(
            //     zipcode: $commercialAddress["zipcode"],
            //     address: $commercialAddress["address"],
            //     number: $commercialAddress["number"],
            //     complement: $commercialAddress["complement"],
            //     district: $commercialAddress["district"],
            //     stateId: $commercialAddress["state_id"],
            //     cityId: $commercialAddress["city_id"]
            // );
            // dd($commercialAddressDTO);

        } catch (Exception $e) {
            dd($e);
        }
    }

}
