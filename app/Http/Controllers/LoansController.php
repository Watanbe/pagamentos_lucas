<?php

namespace App\Http\Controllers;

use App\Architecture\DTO\UserLoan\UserLoanImagesRegisterDTO;
use App\Architecture\DTO\UserLoan\UserLoanRegisterDTO;
use App\Architecture\Services\Upload\UploadService;
use App\Architecture\Services\UserLoan\UserLoanImageService;
use App\Architecture\Services\UserLoan\UserLoanService;
use App\Http\Resources\LoanResource;
use ErrorException;
use Exception;
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

    public function create(Request $request) {
        try {
            $loanDTO = new UserLoanRegisterDTO(
                value: $request->value,
                loanMaturity: $request->loan_maturity,
                installments: $request->installments,
                loanDescription: $request->loan_description,
                userId: $request->user_id,
                loanModalityId: $request->loan_modality_id,
                paid: 0
            );
            $loan = $this->userLoanService->create($loanDTO);

            foreach ($request->loan_images as $image) {
                $imagePath = $this->uploadService->uploadImage($image);
                $userLoanImageDTO = new UserLoanImagesRegisterDTO(image: $imagePath, loanId: $loan->id);
                $this->userLoanImageService->create($userLoanImageDTO);
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

}
