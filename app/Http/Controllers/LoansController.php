<?php

namespace App\Http\Controllers;

use App\Architecture\DTO\UserLoan\UserLoanImagesRegisterDTO;
use App\Architecture\DTO\UserLoan\UserLoanRegisterDTO;
use App\Architecture\Services\Upload\UploadService;
use App\Architecture\Services\UserLoan\UserLoanImageService;
use App\Architecture\Services\UserLoan\UserLoanService;
use App\Http\Resources\LoanResource;
use InvalidArgumentException;
use Exception;
use ErrorException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class LoansController extends Controller {

    public function __construct(
        protected UserLoanService $userLoanService,
        protected UploadService $uploadService,
        protected UserLoanImageService $userLoanImageService
    )
    {
    }

    public function create(Request $request)
    {
        try {
            $this->validateRequest($request);

            DB::beginTransaction();

            $loanDTO = new UserLoanRegisterDTO(
                value: $request->value,
                loanMaturity: $request->loan_maturity,
                installments: $request->installments,
                loanDescription: $request->loan_description,
                userId: $request->user_id,
                loanModalityId: $request->loan_modality_id,
                paid: false
            );
            $loan = $this->userLoanService->create($loanDTO);

            $loanImages = [];
            foreach ($request->loan_images as $image) {
                $imagePath = $this->uploadService->uploadImage($image);
                $userLoanImageDTO = new UserLoanImagesRegisterDTO(image: $imagePath, loanId: $loan->id);
                $loanImage = $this->userLoanImageService->create($userLoanImageDTO);
                $loanImages[] = $loanImage;
            }

            DB::commit();

            $response = [
                "loan" => $loan,
                "loan_images" => $loanImages
            ];
            return response()->json($response, 201);
        }
        catch (ValidationException $e) {
            return response()->json([
                'error' => 'Validation failed',
                'messages' => $e->errors()
            ], 422);
        }
        catch (InvalidArgumentException $e) {
            DB::rollBack();
            return response()->json([
                'error' => $e->getMessage()
            ], 400);
        }
        catch (Exception $e) {
            DB::rollBack();
            return response()->json([
                'error' => 'An error occurred while processing your request.',
                'message' => $e->getMessage()
            ], 400);
        }
    }

    public function update(Request $request, $id) {
        try {
            $loan = $this->userLoanService->getById($id);

            if (!$loan) {
                return response()->json([
                    'error' => 'Loan not found.'
                ], 404);
            }

            $loan->update([
                'value' => $request->has('value') ? $request->value : $loan->value,
                'loan_maturity' => $request->has('loan_maturity') ? Carbon::createFromFormat('d/m/Y', $request->loan_maturity)->format('Y-m-d') : $loan->loan_maturity,
                'installments' => $request->has('installments') ? $request->installments : $loan->installments,
                'loan_description' => $request->has('loan_description') ? $request->loan_description : $loan->loan_description,
                'user_id' => $request->has('user_id') ? $request->user_id : $loan->user_id,
                'loan_modality_id' => $request->has('loan_modality_id') ? $request->loan_modality_id : $loan->loan_modality_id,
                'paid' => $request->has('paid') ? $request->paid : $loan->paid,
            ]);

            if ($request->has('loan_images')) {
                foreach ($request->loan_images as $image) {
                    $imagePath = $this->uploadService->uploadImage($image);
                    $userLoanImageDTO = new UserLoanImagesRegisterDTO(image: $imagePath, loanId: $loan->id);
                    $this->userLoanImageService->create($userLoanImageDTO);
                }
            }

            $response = [
                "loan" => $loan
            ];
            return response()->json($response, 200);
        }
        catch (Exception $e) {
            return response()->json([
                'error' => 'An error occurred while processing your request.'
            ], 500);
        }
    }

    public function getByUser($id) {
        try {

            $response = [];

            $loans = $this->userLoanService->getByUser($id);

            foreach ($loans as $loan) {
                $response[] = new LoanResource($loan);
            }


            return response()->json($response, 200);
        } catch (Exception $e) {
            return response()->json([
                'error' => 'An error occurred while processing your request.'
            ], 500);
        }
    }

    public function getById($id) {
        try {

            $loan = $this->userLoanService->getById($id);

            if ($loan == null) {
                throw new ErrorException("Emprestimo não encontrado");
            }

            $loan = new LoanResource($loan);

            return response()->json($loan, 200);
        } catch (ErrorException $e) {
            return response()->json([
                'error' => $e->getMessage()
            ], 404);
        } catch (Exception $e) {
            return response()->json([
                'error' => 'An error occurred while processing your request.'
            ], 500);
        }
    }

    public function delete($id) {
        try {

            $loan = $this->userLoanService->getById($id);

            if ($loan == null) {
                throw new ErrorException("Emprestimo não encontrado");
            }

            $loan->delete();

            return response(null, 204);
        } catch (ErrorException $e) {
            return response()->json([
                'error' => $e->getMessage()
            ], 404);
        } catch (Exception $e) {
            dd($e);
            return response()->json([
                'error' => 'An error occurred while processing your request.'
            ], 500);
        }
    }

    private function validateRequest(Request $request)
    {
        $rules = [
            'value' => 'required|numeric|min:0',
            'loan_maturity' => 'required|date_format:d/m/Y',
            'installments' => 'required|integer|min:1',
            'loan_description' => 'required|string',
            'user_id' => 'required|integer|exists:users,id',
            'loan_modality_id' => 'required|integer|exists:loan_modalities,id',
            'loan_images' => 'required|array',
            'loan_images.*' => 'required|string'
        ];

        $request->validate($rules);
    }

}
