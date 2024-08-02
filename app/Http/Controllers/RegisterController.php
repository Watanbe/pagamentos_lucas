<?php

namespace App\Http\Controllers;

use App\Architecture\DTO\Address\AddressRegisterDTO;
use App\Architecture\DTO\Reference\ReferenceRegisterDTO;
use App\Architecture\DTO\User\UserRegisterDTO;
use App\Architecture\DTO\UserLoan\UserLoanRegisterDTO;
use App\Architecture\Services\Address\AddressService;
use App\Architecture\Services\Reference\ReferenceService;
use App\Architecture\Services\Upload\UploadService;
use App\Architecture\Services\User\UserService;
use App\Architecture\Services\UserLoan\UserLoanService;
use ErrorException;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RegisterController extends Controller {

    public function __construct(
        protected AddressService $addressService,
        protected UserService $userService,
        protected ReferenceService $referenceService,
        protected UserLoanService $userLoanService,
        protected UploadService $uploadService
    )
    {
    }

    public function register(Request $request) {
        try {
            DB::beginTransaction();

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
            $userImagePath = $this->uploadService->uploadImage($user["user_image"]);
            $userDTO = new UserRegisterDTO(
                name: $user["name"],
                username: $user["username"],
                email: $user["email"],
                password: $user["password"],
                cpf: $user["cpf"],
                rg: $user["rg"],
                birthDate: $user["birth_date"],
                userImage: $userImagePath,
                maritalStatusId: $user["marital_status_id"],
                personalAddressId: $personalAddress->id,
                commercialAddressId: $commercialAddress->id,
            );
            $user = $this->userService->create($userDTO);

            $references = $request->references;
            foreach ($references as $reference) {
                $referenceDTO = new ReferenceRegisterDTO(value: $reference['value'], userId: $user->id);
                $this->referenceService->create($referenceDTO);
            }

            $loan = $request->loan;
            $loanImagePath = $this->uploadService->uploadImage($loan["loan_image"]);
            $loanDTO = new UserLoanRegisterDTO(
                loanImage: $loanImagePath,
                value: $loan['value'],
                loanMaturity: $loan['loan_maturity'],
                loanDescription: $loan['loan_description'],
                userId: $user->id,
                loanModalityId: $loan['loan_modality_id'],
            );

            $loan = $this->userLoanService->create($loanDTO);

            $response = [
                "user" => $user,
                "personal_address" => $personalAddress,
                "commercial_addres" => $commercialAddress,
                "references" => $references,
                "loan" => $loan,
                "user_image" => asset('storage/'.$user->user_image)
            ];

            DB::commit();
            return response()->json($response, 200);
        }
        catch (ErrorException $e) {
            return response()->json([
                'error' => $e->getMessage()
            ], 500);
        }
        catch (Exception $e) {
            DB::rollBack();
            return response()->json([
                'error' => 'An error occurred while processing your request.'
            ], 500);
        }
    }

}
